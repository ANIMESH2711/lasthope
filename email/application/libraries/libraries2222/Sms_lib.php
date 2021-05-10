<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Sms_lib {
		
		private $sms_url;  
		private $sms_user;	
		private $sms_pass;
		private $sms_sdid;
		
		public function __construct()
		{
			$this->_ci =& get_instance();
			$this->_ci->load->config('sms');
			$this->sms_url= $this->_ci->config->item("sms_url");
			$this->sms_user = $this->_ci->config->item("sms_user");
			$this->sms_pass = $this->_ci->config->item("sms_pass");
			$this->sms_sdid = $this->_ci->config->item("sms_sdid");
			$this->dblogs = $this->_ci->load->database('logs', TRUE);
                        $this->_ci->load->helper('url');
                        date_default_timezone_set("Asia/Calcutta");
			//$this->_initial();
		}
		/*
			POST URL 
		*/
		public function post_to_url($url, $data) 
		{
			$fields = '';
                        $mobileno = $data['mnumber'];
                        $txn = $mobileno . date("YmdHis") . "GeM";
                        $request_module = end($this->_ci->uri->segment_array());
			foreach($data as $key => $value) {
				$fields .= $key . '=' . $value . '&';
			}
			rtrim($fields, '&');
			
			$post = curl_init();			
			curl_setopt($post, CURLOPT_PROXY, false);			
			curl_setopt($post, CURLOPT_URL, $url);
			curl_setopt($post, CURLOPT_POST, count($data));
			curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($post, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($post, CURLOPT_SSL_VERIFYPEER, 0);
			
			$proxy_url = "https://10.247.51.9:8080";		
			curl_setopt($post, CURLOPT_PROXY, $proxy_url); 
			$bool = false;
			if(curl_exec($post) === false){
                          unset($data['username']);
                          unset($data['pin']);
                          $logdata = array('ov_mobile'=>$mobileno,'ov_transaction_id'=>$txn,'ov_module'=>$request_module,'ov_data'=>  json_encode($data),'ov_status'=>0);
                          $logid =  $this->log_otp_verification("insert", $logdata); 
                          $bool = false;
                        }else{
                           unset($data['username']);
                           unset($data['pin']);
                           $logdata = array('ov_mobile'=>$mobileno,'ov_transaction_id'=>$txn,'ov_module'=>$request_module,'ov_data'=>  json_encode($data),'ov_status'=>1);
                           $logid =  $this->log_otp_verification("insert", $logdata);
                           $bool = true; 
                        }
			
			curl_close($post);
			
			return $bool;
		}
		
		
		/**
			* sending an SMS message
			*
			* @param string
			* @param string
		*/
		public function send_message($to=NULL,$msg=NULL)
		{
			
			
			$data = array(
			"username" => $this->sms_user,      // type your assigned username here(for example:"username" => "CDACMUMBAI")
			"pin" => $this->sms_pass,     //type your password
			"signature" =>$this->sms_sdid,           //type your senderID
			//		   "smsservicetype" =>"singlemsg",  //*Note*  for single sms enter  îsinglemsgî , for bulk enter ìbulkmsgî
			"mnumber" =>"$to",          	//enter the mobile number
			//		   "bulkmobno" => "",    			//enter mobile numbers separated by commas for bulk sms otherwise leave it blank
			"message"  => "$msg"           	//type the message.
			
			);
			
			return $this->post_to_url($this->sms_url, $data); 
		}
		public function send_message_multi($to=NULL,$msg=NULL)
		{
			
			$data = array(
			"username" => $this->sms_user,      // type your assigned username here(for example:"username" => "CDACMUMBAI")
			"pin" => $this->sms_pass,     //type your password
			"signature" =>$this->sms_sdid,           //type your senderID
			"smsservicetype" =>"bulkmsg",  //*Note*  for single sms enter  îsinglemsgî , for bulk enter ìbulkmsgî
			// "mnumber" =>"$to",          	//enter the mobile number
			"bulkmobno" => "$to",    			//enter mobile numbers separated by commas for bulk sms otherwise leave it blank
			"message"  => "$msg"           	//type the message.
			
			);
			
			return $this->post_to_url($this->sms_url, $data); 
		}
                
                
                        /*
             * @log for otp verificatiion
             * @author :chandan
             */

            function log_otp_verification($mode,$data,$logid=NULL){
               if ($mode == "insert") {
                    $this->dblogs->insert('log_otp_verification', $data);
                    
                   return $this->dblogs->insert_id();
                } else if ($mode == "update") {

                    $this->dblogs->where('ov_id', $logid);
                    $this->dblogs->update('log_otp_verification', $data);
                } 
            }

		
	}
	
	/* End of file Sms_lib.php */
/* Location: ./application/libraries/Sms_lib.php */