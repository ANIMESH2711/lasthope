<?php
/*********************************************
* Notification library for GeM portal
*********************************************/

class Mobileverification {
    
    public $eSignMode=0;
    private $db=false;
    private $dblogs=false;
    private $u_id=0;
    private $auth_identifier=0;
    private $user_detail=0;
    private $COMP_ID=0;

    
    public function __construct() { 
        $this->ci = & get_instance();
        $this->ci->load->helper('url');
        $this->ci->load->library('user_agent');

//        $this->eSignMode = 1;
        $this->eSignMode = $this->ci->config->item('esignMode');
        $this->db = $this->ci->load->database('default', TRUE);
        $this->dblogs = $this->ci->load->database('default', TRUE);
        $this->u_id = $this->ci->session->userdata('userId');
        $this->user_detail = $this->ci->session->userdata('user_detail');
        $this->sellercomp_id=0;
        $this->sellercomp_id = $this->ci->session->userdata('user_detail')->comp_id;
        if($this->ci->config->item('debugMode')==1){
//           error_reporting(-1);
//           ini_set('display_errors', 1);
        }
       
    }
    
     /* ******************************************************************
     * Send OTP 
     *
     * @access	public
     * @input   Bid ID
     * @return	OTP on register mobile
     * @Author Sandeep Kumawat
     * ******************************************************************* */
    public function Generate_OTP($requestData) {
       if ($this->eSignMode == 0) {
            $au_otpReference=  base64_encode($this->u_id.":".$requestData['bid_id'].":".time());
            $outPut_response['status'] = 0;
            $outPut_response['responseData'] = "Request Send Successfully.";
            $outPut_response['Server'] = "UAT Offline system";
            $outPut_response['otpReference'] = $au_otpReference;
            $outPut_response['responseData_msg'] = "OTP verification Mode Off on UAT";
            return json_encode($outPut_response);
            exit;
        }else if ($this->eSignMode == 1){
            $tdata= $this->arx_GenerateOTP($requestData);
            return $tdata; 
        }
    }
    
    
    /** ******************************************************************
     * Verify OTP 
     *
     * @access	public
     * @input   OTP, BID NO
     * @return	string,status
     * @Author Sandeep Kumawat

     * ******************************************************************* */

    public function Verify_OTP($requestData) {
        if ($this->eSignMode == 0) {
            // Condition for disable OTP verification
            $outPut_response['BidAuthlast_id'] = $BidAuthlast_id;
                $tdata = json_encode(array('status' => 0, 
                    'Server' => '',
                    'BidAuthlast_id' => 99,
                    'responseData' => 'Your mobile authentication successfull',
                    'responseData_msg' => 'Your mobile authentication successfull'));
        }else if ($this->eSignMode == 1){
           $tdata= $this->arx_ValidateOTP($requestData);
        }
        return $tdata;
    }
    
    
    private function arx_GenerateOTP($requestData) {
        
        $response = '';
        $comp_id="";
        $balv_type="Buyer";
        $au_otpReference=  base64_encode($this->u_id.":".$requestData['bid_id'].":".time());
//        $au_otpReference=1234567890;
        $au_otpflag=False;
        $url = $this->ci->config->item('GenerateOTP');
        $post_data = array(
            'userTicket' => $this->ci->config->item('arxKey'),
            'otpIpaddress' => get_ip(),
            'userId' => $this->u_id,
            'otpReference' => $au_otpReference,
            'otpResend' => $requestData['otpflag']
        );
        if($this->user_detail->comp_id!="")
        {
            $comp_id=$this->user_detail->comp_id;
            $balv_type="Seller";
        }
        $BidAuthresponsedata=array("balv_bid_id"=>$requestData['bid_id'],"balv_request"=>json_encode($post_data),"balv_otpReference"=>$au_otpReference,"balv_request_time"=>date("Y-m-d H:i:s"),"balv_type"=>$balv_type,"balv_mode"=>"mobileotp","balv_user_id"=>$this->u_id,"balv_compid"=>$comp_id);
        $BidAuthlast_id=$this->UpdateBidAuthLog($BidAuthresponsedata);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));
       // pr($response);

        $responce_code = $response->serviceStatusResponse->responseCode;
        curl_close($ch);
        
      
        $BidAuthresponsedata=array("balv_response"=>json_encode($response),"balv_response_time"=>date("Y-m-d H:i:s"));
        $this->UpdateBidAuthLog($BidAuthresponsedata,$BidAuthlast_id);
        
        if ($responce_code == 0) { // valid user and login success
            $maskEmail="";
            $maskEmail=$this->maskEmail($this->user_detail->emailAddress);
            $outPut_response=array();
            $outPut_response['status'] = $response->serviceStatusResponse->responseCode;
            $outPut_response['responseData'] = "OTP Request sent successfully to your registered mobile xxxxxx" . substr($this->user_detail->mobileNumber, -4) . " and email ID " . $maskEmail;
            $outPut_response['Server'] = "";
            $outPut_response['otpReference'] = $au_otpReference;
            $outPut_response['responseData_msg'] = $response->serviceStatusResponse->responseMsg;
            return json_encode($outPut_response);
        } else {
            $outPut_response=array();
            $outPut_response['status'] = $response->serviceStatusResponse->responseCode;
            $outPut_response['responseData'] = $response->serviceStatusResponse->responseMsg;
            $outPut_response['otpReference'] = $au_otpReference;
            $outPut_response['Server'] = "";
            $outPut_response['responseData_msg'] = $response->serviceStatusResponse->responseMsg;
            return json_encode($outPut_response);
        }
    }
    
    private function arx_ValidateOTP($requestData) {
        
     
        $comp_id="";
        $balv_type="Buyer Verify";
        $url = $this->ci->config->item('ValidateOTP');
        $au_otpReference=$requestData['otpReference'];
        $au_otpvalue=$requestData['otp_box'];
        $post_data = array(
            'userTicket' => $this->ci->config->item('arxKey'),
            'otpIpaddress' => get_ip(),
            'userId' => $this->u_id,
            'otpReference' => $au_otpReference,
            'otp' => $au_otpvalue
        );
        if($this->user_detail->comp_id!="")
        {
            $comp_id=$this->user_detail->comp_id;
            $balv_type="Seller";
        }
        $BidAuthresponsedata=array("balv_bid_id"=>$requestData['bid_id'],"balv_request"=>json_encode($post_data),"balv_otpReference"=>$au_otpReference,"balv_request_time"=>date("Y-m-d H:i:s"),"balv_type"=>$balv_type,"balv_mode"=>"mobileotp","balv_user_id"=>$this->u_id,"balv_compid"=>$comp_id);
        $BidAuthlast_id=$this->UpdateBidAuthLog($BidAuthresponsedata);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));

        $BidAuthresponsedata=array("balv_response"=>json_encode($response),"balv_response_time"=>date("Y-m-d H:i:s"));
        $this->UpdateBidAuthLog($BidAuthresponsedata,$BidAuthlast_id);
        
        $responce_code = $response->responseCode;
        curl_close($ch);
        if ($responce_code == 0) { // valid user and login success
            
            $outPut_response=array();
            $outPut_response['status'] = $response->responseCode;
            $outPut_response['responseData'] = $response->responseMsg;
            $outPut_response['Server'] = "";
            $outPut_response['responseData_msg'] = $response->responseMsg;
            $outPut_response['BidAuthlast_id'] = $BidAuthlast_id;
            
            return json_encode($outPut_response);
        } else {
            $outPut_response=array();
            $outPut_response['status'] = $response->responseCode;
            $outPut_response['responseData'] = $response->responseMsg;
            $outPut_response['Server'] = "";
            $outPut_response['responseData_msg'] = $response->responseMsg;
            $outPut_response['BidAuthlast_id'] = $BidAuthlast_id;
            return json_encode($outPut_response); 
        }
    }
    
    
    /*
     * @desc : update data
     * @author: Sandeep Kumawat 
     */

    public function getreferenceAuthLog() {
        $this->dblogs->select('count(balv_id) as lastid');
        $this->dblogs->from('bid_authentication_log');
        $this->dblogs->order_by('balv_id DESC');
        $query = $this->dblogs->get();
        $BidAuthLog_data = $query->row();
        return $BidAuthLog_data;
    }
    
    /*
     * @desc : update data
     * @author: Sandeep Kumawat 
     */

    public function UpdateBidAuthLog($BidAuthresponsedata,$id=0) {
        $update=0;
        if($id>0)
        {
            $this->dblogs->where('balv_id', $id);
            $update=$this->dblogs->update('bid_authentication_log', $BidAuthresponsedata);
            return $id;
        }else{
            $update = $this->dblogs->insert('bid_authentication_log', $BidAuthresponsedata);
            return $this->dblogs->insert_id();
        }
    }
    
    /*
     * @desc : Email Masking
     * @author: Sandeep Kumawat 
     */
    
    public function maskEmail($email, $minLength = 3, $maxLength = 10, $mask = "***") {
    $atPos = strrpos($email, "@");
    $name = substr($email, 0, $atPos);
    $len = strlen($name);
    $domain = substr($email, $atPos);

    if (($len / 2) < $maxLength){ $maxLength = ($len / 2);}

    $shortenedEmail = (($len > $minLength) ? substr($name, 0, $maxLength) : "");
    return  "{$shortenedEmail}{$mask}{$domain}";
}

}

