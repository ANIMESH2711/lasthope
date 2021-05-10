<?php
/**
	* Notification library for GeM portal
	* @desc Send notification client library for GeM portal
	* @package		Bid
	* @author		Tulsi Chandan
	* @version		1.0.1
	
**/

class Notification {
  
	
	
	function __construct()
		{
			$this->ci =& get_instance();
			$this->NotificationHubUrl = $this->ci->config->item('NotificationHubUrl');
			
			
		}
		
		
		public function __callToMessegeHub($postData)
		{  

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->NotificationHubUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 300,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $postData,
			CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"Cache-Control: no-cache",
			"Content-Type: application/json; charset=utf-8" 
		),
		));

		$response = curl_exec($curl);

		$err = curl_error($curl);

		if ($err) 
		{
			$OutPut = $err;
		} else 
		{
			$OutPut = $response;
		}

		curl_close($curl);
		 
		$SellersListArray = json_decode($OutPut, true);
 
		if(!empty($SellersListArray))
		{
			if(isset($SellersListArray["status"]) && $SellersListArray["status"]=='success')
			{ 
				return json_encode(array("status"=>true,"responseData"=>"Request Send Successfully","Server"=>"Massage HUB")); 
			} 
			else{
				return json_encode(array("status"=>false,"responseData"=>"Request Not Send","Server"=>"Massage HUB"));
			}
		}else
		{
			return json_encode(array("status"=>false,"responseData"=>"There is server error","Server"=>"Massage HUB"));
		} 
  
	}
	 
	 
	 /*------------BID Mail and SMS ---BID Mail and SMS ----BID Mail and SMS ---BID Mail and SMS ---BID Mail and SMS -----------------*/
	 
	/*---------------------- Send Notification to PU for BID Successfully created on GeM ------------------------
		// Event ID=1007
	*/
	function sendNotificationForBidCreatedToPU($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1176;
                        }else{
                            $event_id = 1007;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                             $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
                                "recipient_name":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"remaining_productcount": "'.((is_null($remaining_productcount))?' ':$remaining_productcount).'",				
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                 "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","qty":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"product_title1": "'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'",
                                "buyer_office": "'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
                                "buyer_org": "'.((is_null($BidDetails["buyer_org"]))?' ':$BidDetails["buyer_org"]).'",
				"bid_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
                                "bid_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
                                "s_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
                                "e_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		 $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	
	/*---------------------- Send Notification to Invitation register Participate after BID created on GeM-----------
		// Event ID=1008
	*/
	function sendNotificationForBidInvitationToParticipate($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type=0)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1177;
                        }else{
                            $event_id = 1008;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
                                "product_title1": "'.$BidItemDetails[0]["product_title"].'",
                                "product_title": "'.$BidItemDetails[0]["product_title"].'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"recipient_name":"Buyer",
				"bid_number": "'.$BidDetails["bid_number"].'",
                                "ra_number": "'.$BidDetails["bid_number"].'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.$Item["product_title"].'","quantity":"'.$Item["quantity"].'","qty":"'.$Item["quantity"].'","expected_delivery_date":"'.$Item["expected_delivery_date"].'",
					"consignee":"'.$Item["consignee"].'","delivery_locn":"'.$Item["delivery_locn"].'","delivery_address":"'.$Item["delivery_address"].'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"product_name": "'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'",
				"bid_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
				"bid_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
                                "ra_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
				"ra_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'"
				},
				"correlationId": "'.$BidDetails["correlationId"].'",
				"initiatingAppId":"'.$BidDetails["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$BidDetails["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$BidDetails["tenantId"].'",
				"referenceNumber":"'.$BidDetails["referenceNumber"].'"
				}';  
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	
	/*---------------------- Send Notification to Buyer after Bid Cancelled on GeM-------------------------
		// Event ID=1012
	*/
	function sendNotificationForBidCancelledToBuyer($recipientDetails,$BidDetails,$BidItemDetails)
	{   
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1012",
				"notificationData": {
                                "remaining_productcount": "'.$remaining_productcount.'",
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"product_title1": "'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'",
                                "bid_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
				"bid_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
				"cancelled_date":"'.((is_null($BidDetails["cancelled_date"]))?' ':$BidDetails["cancelled_date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';
		 
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1012;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	/*---------------------- Send Notification to Participate after Bid Cancelled on GeM-------------------------
		// Event ID=1014
	*/
	function sendNotificationForBidCancelledToParticipate($recipientDetails,$BidDetails,$BidItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
		        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1014",
				"notificationData": {
				"recipient_name":"'.((is_null($BidItemDetails["recipient_name"]))?' ':$BidItemDetails["recipient_name"]).'",
                                 "remaining_productcount": "'.$remaining_productcount.'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
                                "product_title1": "'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'", 
				"bid_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
				"bid_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
				"buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
				"cancelled_date":"'.((is_null($BidDetails["cancelled_date"]))?' ':$BidDetails["cancelled_date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1014;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	
	/*---------------------- Send Notification to Buyer after Bid Technical Evaluation on GeM-------------------------
		// Event ID=1073
	*/
	function sendNotificationForBidTechnicalEvaluationToBuyer($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1179;
                        }else{
                            $event_id = 1073;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                             $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId":'.$event_id.',
				"notificationData": {
                                "recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"products":[';
				
                                foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
                                "date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'"
				},
                                "correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",                                
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		 //echo $InfoData;exit;
		 $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	
	/*---------------------- Send Notification to Participate after Bid Technical Evaluation  on GeM-------------------------
		// Event ID=1074
	*/
	function sendNotificationForBidTechnicalEvaluationToParticipate($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1180;
                        }else{
                            $event_id = 1074;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							 "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.$Item["product_title"].'","quantity":"'.$Item["quantity"].'","expected_delivery_date":"'.$Item["expected_delivery_date"].'",
					"consignee":"'.$Item["consignee"].'","delivery_address":"'.$Item["delivery_address"].'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
                                "buyer_org":"'.((is_null($BidDetails["orgName"]))?' ':$BidDetails["orgName"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",                                
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		 //echo $InfoData;exit;
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	
	/*---------------------- Send Notification to Buyer after Bid Commercial Evaluation  on GeM-------------------------
		// Event ID=1075
	*/
	function sendNotificationForBidCommercialEvaluationToBuyer($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1181;
                        }else{
                            $event_id = 1075;
                        }						
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                             $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number":  "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],	
				"date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'"
				},
				"correlationId":"'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'", 
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'", 
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'", 
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'", 
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		 //echo $InfoData;exit;
		 $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	 
	 
	 
	/*---------------------- Send Notification to Participate after Bid Commercial EvaluationT on GeM-------------------------
		// Event ID=1076
	*/
	function sendNotificationForBidCommercialEvaluationToParticipate($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1182;
                        }else{
                            $event_id = 1076;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                             $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number":  "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.$Item["product_title"].'","quantity":"'.$Item["quantity"].'","expected_delivery_date":"'.$Item["expected_delivery_date"].'",
					"consignee":"'.$Item["consignee"].'","delivery_address":"'.$Item["delivery_address"].'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],				
				"date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'"
				},
				"correlationId":"'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'", 
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'", 
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'", 
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'", 
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		//echo  $InfoData.'<br><br>';
		 $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                 $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	
	/*---------------------- Send Notification to Buyer after Bid Award on GeM-------------------------
		// Event ID=1078
	*/
	function sendNotificationForBidAwardToBuyer($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
              
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1184;
                        }else{
                            $event_id = 1078;
                        }						
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","qty":"'.$Item["quantity"].'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],	
				"buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
				"seller_name":"'.((is_null($BidDetails["seller_name"]))?' ':$BidDetails["seller_name"]).'",
				"date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';


		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	
	/*---------------------- Send Notification to Participate after Bid Award on GeM-------------------------
		// Event ID=1081
	*/
	function sendNotificationForBidAwardToParticipate($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{ 
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1187;
                        }else{
                            $event_id = 1081;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                              $email = $val["emailId"];
				$InfoData .= '{
							   "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{  
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","qty":"'.$Item["quantity"].'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,','); 
				$InfoData .='],	
				"buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
                                "buyer_org":"'.((is_null($BidDetails["orgName"]))?' ':$BidDetails["orgName"]).'",
                                "date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	

	/*---------------------- Send Notification to Recipient after Bid Corrigendum created on GeM---------------
		// Event ID=1066
	*/
	function sendNotificationForBidCorrigendumToRecipient($recipientDetails,$BidDetails,$b_bid_type,$is_buyer)
	{
            $recipientDetails = json_encode($recipientDetails);
            $recipientDetails = json_decode($recipientDetails, true);
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1067;
                        }else{
                            $event_id = 1066;
                        }
			$InfoData .= '{
					"recipientDetails": [{
                                        "recipientCategory": "GEM",
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                                                          "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'",   
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [{
								  "platform": "ios",
								  "token": "001"
								}]
							  
							},';
			}
                        $InfoData = trim($InfoData,','); 
			$InfoData .=' ] }],
				"initiatingUser": "GEM",
				"referenceNumber": "GEM",
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"Seller",
				"e_bidno": "'.((is_null($BidDetails["e_bidno"]))?' ':$BidDetails["e_bidno"]).'",
                                "ra_no": "'.((is_null($BidDetails["e_bidno"]))?' ':$BidDetails["e_bidno"]).'",
                                "cdate": "'.((is_null($BidDetails["cdate"]))?' ':$BidDetails["cdate"]).'",    
                                "bdate": "'.((is_null($BidDetails["bdate"]))?' ':$BidDetails["bdate"]).'"   
				},
				"locale":"en_US",
                                "initiatingAppId": "GEM",
	                        "correlationId": "009909"
				}';
                         $InfoData;
                         
		//return $this->__callToMessegeHub($InfoData);
                 $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["b_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = $is_buyer;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	 
	 
	 
	
	/*------------RA Mail and SMS ---RA Mail and SMS ---RA Mail and SMS ---RA Mail and SMS ---RA Mail and SMS ---RA Mail and SMS ------------------------------*/
	
	
	/*---------------------- Send Notification to Buyer after RA Created on GeM-------------------------
		// Event ID=1009
	*/
	function sendNotificationForRACreatedToBuyer($recipientDetails,$RADetails,$RAItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
				// "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"		
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							 "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"

							},';
			}
                        $InfoData = trim($InfoData,',');
		        $remaining_productcount = (count($RAItemDetails) > 1) ? "and ".(count($RAItemDetails)-1)." other(s)": ' ';
			
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1009",
				"notificationData": {
				"recipient_name":"'.((is_null($RADetails["recipient_name"]))?' ':$RADetails["recipient_name"]).'",
				"ra_number": "'.((is_null($RADetails["ra_number"]))?' ':$RADetails["ra_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($RAItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"product_name": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
                                "product_title1": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
				"ra_start_date":"'.((is_null($RADetails["ra_start_date"]))?' ':$RADetails["ra_start_date"]).'",
				"ra_end_date":"'.((is_null($RADetails["ra_end_date"]))?' ':$RADetails["ra_end_date"]).'"
				},
                                "correlationId": "'.((is_null($RADetails["correlationId"]))?' ':$RADetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($RADetails["initiatingAppId"]))?' ':$RADetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($RADetails["initiatingUser"]))?' ':$RADetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($RADetails["tenantId"]))?' ':$RADetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($RADetails["referenceNumber"]))?' ':$RADetails["referenceNumber"]).'"                                 
				}';
                                //echo $InfoData;exit;
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $RADetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1009;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	
	/*---------------------- Send Notification to to Invitation register Participate after RA Created on GeM-------------------------
		// Event ID=1011
	*/
	function sendNotificationForRAInvitationToParticipate($recipientDetails,$RADetails,$RAItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1189;
                        }else{
                            $event_id = 1011;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
			// '.((is_null($val["emailId"]))?' ':$val["emailId"]).'"	
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							 "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"

							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($RAItemDetails) > 1) ? "and ".(count($RAItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($RADetails["recipient_name"]))?' ':$RADetails["recipient_name"]).'",
				"ra_number": "'.((is_null($RADetails["ra_number"]))?' ':$RADetails["ra_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($RAItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				
				$InfoData .='],
				"product_name": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
                                "product_title1": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'", 
				"ra_start_date":"'.((is_null($RADetails["ra_start_date"]))?' ':$RADetails["ra_start_date"]).'",
				"ra_end_date":"'.((is_null($RADetails["ra_end_date"]))?' ':$RADetails["ra_end_date"]).'"
				},
				 "correlationId": "'.((is_null($RADetails["correlationId"]))?' ':$RADetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($RADetails["initiatingAppId"]))?' ':$RADetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($RADetails["initiatingUser"]))?' ':$RADetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($RADetails["tenantId"]))?' ':$RADetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($RADetails["referenceNumber"]))?' ':$RADetails["referenceNumber"]).'"
				}';

		 //echo $InfoData;
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $RADetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	/*---------------------- Send Notification to Buyer after RA Cancelled on GeM-------------------------
		// Event ID=1015
	*/
function sendNotificationForRACancelledToBuyer($recipientDetails,$RADetails,$RAItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{   
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
		        $remaining_productcount = (count($RAItemDetails) > 1) ? "and ".(count($RAItemDetails)-1)." other(s)": ' ';
			
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1015",
				"notificationData": {
				"recipient_name":"'.((is_null($RADetails["recipient_name"]))?' ':$RADetails["recipient_name"]).'",
				"ra_number": "'.((is_null($RADetails["ra_number"]))?' ':$RADetails["ra_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($RAItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"product_name": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
                                "product_title1":"'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
				"cancelled_date":"'.((is_null($RADetails["cancelled_date"]))?' ':$RADetails["cancelled_date"]).'",
				"ra_start_date":"'.((is_null($RADetails["ra_start_date"]))?' ':$RADetails["ra_start_date"]).'",
				"ra_end_date":"'.((is_null($RADetails["ra_end_date"]))?' ':$RADetails["ra_end_date"]).'"
				},
				 "correlationId": "'.((is_null($RADetails["correlationId"]))?' ':$RADetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($RADetails["initiatingAppId"]))?' ':$RADetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($RADetails["initiatingUser"]))?' ':$RADetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($RADetails["tenantId"]))?' ':$RADetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($RADetails["referenceNumber"]))?' ':$RADetails["referenceNumber"]).'"
				}';
                                
		 //echo $InfoData;exit;
		  $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $RADetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1015;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	/*---------------------- Send Notification to Participate after RA Cancelled on GeM--------------------
		// Event ID=1017
	*/
	function sendNotificationForRACancelledToParticipate($recipientDetails,$RADetails,$RAItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
		        $remaining_productcount = (count($RAItemDetails) > 1) ? "and ".(count($RAItemDetails)-1)." other(s)": ' ';
			
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1017",
				"notificationData": {
				"recipient_name":"'.((is_null($RADetails["recipient_name"]))?' ':$RADetails["recipient_name"]).'",
				"ra_number": "'.((is_null($RADetails["ra_number"]))?' ':$RADetails["ra_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($RAItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				
				$InfoData .='],
				"product_title1": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
                                 "product_name": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'", 
				"buyer_office":"'.((is_null($RADetails["buyer_office"]))?' ':$RADetails["buyer_office"]).'",
				"cancelled_date":"'.((is_null($RADetails["cancelled_date"]))?' ':$RADetails["cancelled_date"]).'",
				"ra_start_date":"'.((is_null($RADetails["ra_start_date"]))?' ':$RADetails["ra_start_date"]).'",
				"ra_end_date":"'.((is_null($RADetails["ra_end_date"]))?' ':$RADetails["ra_end_date"]).'"
				},
				 "correlationId": "'.((is_null($RADetails["correlationId"]))?' ':$RADetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($RADetails["initiatingAppId"]))?' ':$RADetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($RADetails["initiatingUser"]))?' ':$RADetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($RADetails["tenantId"]))?' ':$RADetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($RADetails["referenceNumber"]))?' ':$RADetails["referenceNumber"]).'"
				}';

		 //echo $InfoData;exit;
		  $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $RADetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1017;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	
	
	/*---------------------- Send Notification to Recipient after RA Corrigendum created on GeM-------------------------
		// Event ID=1067
	*/
	function sendNotificationForRACorrigendumToRecipient($recipientDetails,$RADetails,$BidItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
		 
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1067",
				"notificationData": {
				"recipient_name":"Buyer",
				"ra_no": "'.$RADetails["ra_no"].'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.$Item["product_title"].'","quantity":"'.$Item["quantity"].'","expected_delivery_date":"'.$Item["expected_delivery_date"].'",
					"consignee":"'.$Item["consignee"].'","delivery_address":"'.$Item["delivery_address"].'"},';
				}
				  
				$InfoData .='],
				"product_name": "'.$RADetails["product_name"].'", 
				"ra_start_date":"'.$RADetails["ra_start_date"].'",
				"ra_end_date":"'.$RADetails["ra_end_date"].'",
				"buyer_office":"'.$RADetails["buyer_office"].'",  
				"date":"'.$RADetails["date"].'"
				},
				"correlationId": "'.$RADetails["correlationId"].'",
				"initiatingAppId":"'.$RADetails["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$RADetails["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$RADetails["tenantId"].'",
				"referenceNumber":"'.$RADetails["referenceNumber"].'"
				}';

		 
		 return $this->__callToMessegeHub($InfoData);
	}
        
        
        /*---------------------- Send Notification to Buyer created on gem-------------------------
		// Event ID=1007
	*/
	function sendNotificationForBIDcreatedonGEM($recipientDetails,$BidDetails,$BidItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
		 
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1007",
				"notificationData": {
				"recipient_name":"Buyer",
				"bid_number": "'.$BidDetails["bid_number"].'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.$Item["product_title"].'","quantity":"'.$Item["quantity"].'","expected_delivery_date":"'.$Item["expected_delivery_date"].'",
					"consignee":"'.$Item["consignee"].'","delivery_address":"'.$Item["delivery_address"].'"},';
				}
				  
				$InfoData .='],
				"product_name": "'.$BidDetails["product_name"].'", 
				"product_quantity": "'.$BidDetails["product_quantity"].'",
				"bid_start_date":"'.$BidDetails["bid_start_date"].'",
				"bid_end_date":"'.$BidDetails["bid_end_date"].'",
				"buyer_office":"'.$BidDetails["buyer_office"].'" 
				},
				"correlationId": "'.$BidDetails["correlationId"].'",
				"initiatingAppId":"'.$BidDetails["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$BidDetails["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$BidDetails["tenantId"].'",
				"referenceNumber":"'.$BidDetails["referenceNumber"].'"
				}';

		  
		 return $this->__callToMessegeHub($InfoData);
	}
	
	function sendNotificationForRAcreatedPU($recipientDetails,$RACREATEDetails,$RAItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                             $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							 "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                         $InfoData = trim($InfoData,','); 
                         $remaining_productcount = (count($RAItemDetails) > 1) ? "and ".(count($RAItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1010",
				"notificationData": {
				"remaining_productcount":"'.((is_null($remaining_productcount))?' ':$remaining_productcount).'",				
				"ra_number": "'.((is_null($RACREATEDetails["ra_number"]))?' ':$RACREATEDetails["ra_number"]).'",
				"products":[';
				
				foreach($RAItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				 $InfoData = trim($InfoData,','); 
				$InfoData .='],                               
                                "product_title1": "'.((is_null($RACREATEDetails["product_name"]))?' ':$RACREATEDetails["product_name"]).'",
				"ra_start_date":"'.((is_null($RACREATEDetails["ra_start_date"]))?' ':$RACREATEDetails["ra_start_date"]).'",
				"ra_end_date":"'.((is_null($RACREATEDetails["ra_end_date"]))?' ':$RACREATEDetails["ra_end_date"]).'",                               
                                "buyer_office":"'.((is_null($RACREATEDetails["buyer_office"]))?' ':$RACREATEDetails["buyer_office"]).'"
				},
				"correlationId": "'.((is_null($RACREATEDetails["correlationId"]))?' ':$RACREATEDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($RACREATEDetails["initiatingAppId"]))?' ':$RACREATEDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($RACREATEDetails["initiatingUser"]))?' ':$RACREATEDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($RACREATEDetails["tenantId"]))?' ':$RACREATEDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($RACREATEDetails["referenceNumber"]))?' ':$RACREATEDetails["referenceNumber"]).'"
				}';
				

		 
		 $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $RACREATEDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1010;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	function sendNotificationForRACancelledPU($recipientDetails,$RADetails,$RAItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                             $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($RAItemDetails) > 1) ? "and ".(count($RAItemDetails)-1)." other(s)": ' ';
			
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1016",
				"notificationData": {
				"recipient_name":"'.((is_null($RADetails["recipient_name"]))?' ':$RADetails["recipient_name"]).'",
				"ra_number": "'.((is_null($RADetails["bid_number"]))?' ':$RADetails["bid_number"]).'",
                                "remaining_productcount": "'.((is_null($remaining_productcount))?' ':$remaining_productcount).'",
				"products":[';
				
				foreach($RAItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
                                "product_title1":"'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
				"cancelled_date":"'.((is_null($RADetails["cancelled_date"]))?' ':$RADetails["cancelled_date"]).'",
				"ra_start_date":"'.((is_null($RADetails["ra_start_date"]))?' ':$RADetails["ra_start_date"]).'",
				"ra_end_date":"'.((is_null($RADetails["ra_end_date"]))?' ':$RADetails["ra_end_date"]).'",
                                "buyer_office":"'.((is_null($RADetails["buyer_office"]))?' ':$RADetails["buyer_office"]).'"
				},
				"correlationId": "'.((is_null($RADetails["correlationId"]))?' ':$RADetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($RADetails["initiatingAppId"]))?' ':$RADetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($RADetails["initiatingUser"]))?' ':$RADetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($RADetails["tenantId"]))?' ':$RADetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($RADetails["referenceNumber"]))?' ':$RADetails["referenceNumber"]).'"
				}';
 
		 
		 $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $RADetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1016;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	function sendNotificationForCommercialEvaluationPU($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1183;
                        }else{
                            $event_id = 1077;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                             $email = $val["emailId"];
				$InfoData .= '{
							   "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							    "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId":'.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number":"'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				 "products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.$Item["product_title"].'","quantity":"'.$Item["quantity"].'","expected_delivery_date":"'.$Item["expected_delivery_date"].'",
					"consignee":"'.$Item["consignee"].'","delivery_address":"'.$Item["delivery_address"].'"},';
				}
				
				$InfoData = trim($InfoData,',');  
				$InfoData .='],
				"date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'",
				"buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;  
		
	}
	
	function sendNotificationForTechnicalEvaluationPU($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1186;
                        }else{
                            $event_id = 1080;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {				
                                "bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'",
				"buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';
		   
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	
	function sendNotificationForBidAwardToSeller($recipientDetails,$BidDetails,$BidItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
		 
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1081",
				"notificationData": {
				"recipient_name":"Seller",
				"bid_number": "'.$BidDetails["bid_number"].'",
				"seller_name":"'.$BidDetails["seller_name"].'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.$Item["product_title"].'","qty":"'.$Item["quantity"].'","expected_delivery_date":"'.$Item["expected_delivery_date"].'",
					"consignee":"'.$Item["consignee"].'","delivery_address":"'.$Item["delivery_address"].'"},';
				}
				  
				$InfoData .='],
				"product_name": "'.$BidDetails["product_name"].'", 
				"bid_start_date":"'.$BidDetails["bid_start_date"].'",
				"bid_end_date":"'.$BidDetails["bid_end_date"].'",
				"buyer_office":"'.$BidDetails["buyer_office"].'",
				
				"date":"'.$BidDetails["date"].'"
				},
				"correlationId": "'.$BidDetails["correlationId"].'",
				"initiatingAppId":"'.$BidDetails["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$BidDetails["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$BidDetails["tenantId"].'",
				"referenceNumber":"'.$BidDetails["referenceNumber"].'"
				}';

		 
		 return $this->__callToMessegeHub($InfoData);
	}
	
	
	function sendNotificationForVendorAssessment($recipientDetails,$vendor)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
		 
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1071",
				"notificationData": {
				"recipient_name":"Seller",
				"assessment_scope":"'.$vendor["assessment_scope"].'",
				"ref_no":"'.$vendor["ref_no"].'",
				"va_fee":"'.$vendor["va_fee"].'"
				
				},
				"correlationId": "'.$vendor["correlationId"].'",
				"initiatingAppId":"'.$vendor["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$vendor["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$vendor["tenantId"].'",
				"referenceNumber":"'.$vendor["referenceNumber"].'"
				}';

		 
		 return $this->__callToMessegeHub($InfoData);
	}
	
	function sendNotificationForVendorAssessmentReferencenumber($recipientDetails,$vendor)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
		 
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1072",
				"notificationData": {
				"recipient_name":"Seller",
				"ref_no":"'.$vendor["ref_no"].'",
				},
				"correlationId": "'.$vendor["correlationId"].'",
				"initiatingAppId":"'.$vendor["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$vendor["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$vendor["tenantId"].'",
				"referenceNumber":"'.$vendor["referenceNumber"].'"
				}';

		 
		 return $this->__callToMessegeHub($InfoData);
	}
	
	
	
	function sendNotificationForWelcomeMessage($recipientDetails,$vendor)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
		 
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1082",
				"notificationData": {
				"recipient_name":"Seller",
				"registration_number":"'.$vendor["registration_number"].'",
				},
				"correlationId": "'.$vendor["correlationId"].'",
				"initiatingAppId":"'.$vendor["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$vendor["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$vendor["tenantId"].'",
				"referenceNumber":"'.$vendor["referenceNumber"].'"
				}';

		 
		 return $this->__callToMessegeHub($InfoData);
	}
	
	
	function sendNotificationForBid_e_bidnoCorrigendumissuedonGeM($recipientDetails,$BidDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
		 
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1066",
				"notificationData": {
				"recipient_name":"Buyer",
				"date":"'.$vendor["registration_number"].'",
				
				"e_bidno":"'.$vendor["e_bidnor"].'",
				
				},
				"correlationId": "'.$vendor["correlationId"].'",
				"initiatingAppId":"'.$vendor["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$vendor["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$vendor["tenantId"].'",
				"referenceNumber":"'.$vendor["referenceNumber"].'"
				}';

		 
		 return $this->__callToMessegeHub($InfoData);
	}
        /*---------------------- Send Notification to Buyer for BID Successfully created on GeM ------------------------
		// Event ID=1006
	*/
	function sendNotificationForBidCreatedToBuyer1006($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1175;
                        }else{
                            $event_id = 1006;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{

                            $email = $val["emailId"];

				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
		 $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
                                "remaining_productcount": "'.$remaining_productcount.'",
				"recipient_name":"'.((is_null($BidItemDetails["recipient_name"]))?' ':$BidItemDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","qty":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"product_name": "'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'",
                                "product_title1": "'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'",
				"bid_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
				"bid_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
                                "s_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
				"e_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
                                "product_title": "'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'"
				},
				"correlationId": "'.((is_null($vendor["correlationId"]))?' ':$vendor["correlationId"]).'",
				"initiatingAppId":"'.((is_null($vendor["initiatingAppId"]))?' ':$vendor["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($vendor["initiatingUser"]))?' ':$vendor["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($vendor["tenantId"]))?' ':$vendor["tenantId"]).'",
				"referenceNumber":"'.((is_null($vendor["referenceNumber"]))?' ':$vendor["referenceNumber"]).'"
				}';

		 
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
	/*
         * 
         * @desc: send otp
         * author chandan
         */
        
        function sendOtp($Otpdata,$reciverdata)
	{
            $uniquid = time();
            $recipientDetails = array(array('recipients'=>$reciverdata,'recipientCategory'=>'GEM'));
            $otparray = array('notificationData'=>$Otpdata,'recipientDetails'=>$recipientDetails,'initiatingUser'=>'HSMUSER','initiatingAppId'=>'BID','correlationId'=>$uniquid,'eventId'=>'1124','referenceNumber'=>$uniquid);
            $jsondata = json_encode($otparray);
            return $this->__callToMessegeHub($jsondata);
	}
        // Event : 1144;
        
            function sendNotificationForRABuyerExtensionMail($recipientDetails,$RADetails,$RAItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                 $email = $val["emailId"];
				$InfoData .= '{
							   "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($RAItemDetails) > 1) ? "and ".(count($RAItemDetails)-1)." other(s)": ' ';

			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1144",
				"notificationData": {
				"recipient_name":"Buyer",
				"ra_num":  "'.((is_null($RADetails["ra_number"]))?' ':$RADetails["ra_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($RAItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				 $InfoData = trim($InfoData,',');
				$InfoData .='],
				"product_name": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
                                "product_title1": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'", 
				"ra_start_date":"'.((is_null($RADetails["ra_start_date"]))?' ':$RADetails["ra_start_date"]).'", 
				"ra_end_datetime":"'.((is_null($RADetails["new_ra_end_date"]))?' ':$RADetails["new_ra_end_date"]).'",
                                "prev_ra_end_datetime":"'.((is_null($RADetails["prev_ra_end_datetime"]))?' ':$RADetails["prev_ra_end_datetime"]).'",                                
                                "and_remaining_others":"'.((is_null($remaining_productcount))?' ':$remaining_productcount).'"
				},
				"correlationId":"'.((is_null($RADetails["correlationId"]))?' ':$RADetails["correlationId"]).'", 
				"initiatingAppId":"'.((is_null($RADetails["initiatingAppId"]))?' ':$RADetails["initiatingAppId"]).'", 
				"locale":"en_US",
				"initiatingUser":"'.((is_null($RADetails["initiatingUser"]))?' ':$RADetails["initiatingUser"]).'", 
				"attachmentPaths":"",
				"tenantId":"'.((is_null($RADetails["tenantId"]))?' ':$RADetails["tenantId"]).'", 
				"referenceNumber":"'.((is_null($RADetails["referenceNumber"]))?' ':$RADetails["referenceNumber"]).'"
				}';
		 
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $RADetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1144;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        
        function sendNotificationForRASellerExtensionMail($recipientDetails,$RADetails,$RAItemDetails)
	{ 
            
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							   "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                         $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($RAItemDetails) > 1) ? "and ".(count($RAItemDetails)-1)." other(s)": ' ';

			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1145",
				"notificationData": {
				"recipient_name":"'.((is_null($RADetails["recipient_name"]))?' ':$RADetails["recipient_name"]).'",
                                "ra_num":"'.((is_null($RADetails["ra_number"]))?' ':$RADetails["ra_number"]).'",
				"products":[';
				
				foreach($RAItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				 $InfoData = trim($InfoData,',');
				$InfoData .='],				
                                "product_title1": "'.((is_null($RADetails["product_name"]))?' ':$RADetails["product_name"]).'",
                                 "ra_start_date":"'.((is_null($RADetails["ra_start_date"]))?' ':$RADetails["ra_start_date"]).'", 
				"prev_ra_end_datetime":"'.((is_null($RADetails["old_ra_end_date"]))?' ':$RADetails["old_ra_end_date"]).'",
                                "ra_end_datetime":"'.((is_null($RADetails["new_ra_end_date"]))?' ':$RADetails["new_ra_end_date"]).'",
                                "and_remaining_others":"'.((is_null($remaining_productcount))?' ':$remaining_productcount).'"
				},
				"correlationId":"'.((is_null($RADetails["correlationId"]))?' ':$RADetails["correlationId"]).'", 
				"initiatingAppId":"'.((is_null($RADetails["initiatingAppId"]))?' ':$RADetails["initiatingAppId"]).'", 
				"locale":"en_US",
				"initiatingUser":"'.((is_null($RADetails["initiatingUser"]))?' ':$RADetails["initiatingUser"]).'", 
				"attachmentPaths":"",
				"tenantId":"'.((is_null($RADetails["tenantId"]))?' ':$RADetails["tenantId"]).'", 
				"referenceNumber":"'.((is_null($RADetails["referenceNumber"]))?' ':$RADetails["referenceNumber"]).'"
				}';
                               
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $RADetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1145;
                 $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        /*---------------------- Send Notification to  Buyer after Bid Extension Mail on GeM-------------------------
		// Event ID=1142
	*/
        function sendNotificationForBidExtensionMailBuyer($recipientDetails,$BidDetails,$BidItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                         $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1142",
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "bid_num": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "and_remaining_others": "'.((is_null($remaining_productcount))?' ':$remaining_productcount).'",
				 "products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				
				  $InfoData = trim($InfoData,','); 
				$InfoData .='],
				"extension_days":"'.((is_null($BidDetails["extension_days"]))?' ':$BidDetails["extension_days"]).'",
                                "product_title1":"'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'",
                                "bid_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
                                "bid_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'"
				
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';

		  
		   //echo $InfoData;exit;	   
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1142;
                $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        /*---------------------- Send Notification to Seller after Bid Extension Mail on GeM-------------------------
		// Event ID=1143
	*/
        function sendNotificationForBidExtensionMailSeller($recipientDetails,$BidDetails,$BidItemDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                               $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                         $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1143",
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["seller_name"]))?' ':$BidDetails["seller_name"]).'",
                                "bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"bid_num": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "and_remaining_others": "'.((is_null($remaining_productcount))?' ':$remaining_productcount).'",
                                "remaining_others": "'.((is_null($remaining_productcount))?' ':$remaining_productcount).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				
				 $InfoData = trim($InfoData,',');  
				$InfoData .='],
                                "extension_days":"'.((is_null($BidDetails["extension_days"]))?' ':$BidDetails["extension_days"]).'",
                                "product_title1":"'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'",
                                "new_bid_end_date":"'.((is_null($BidDetails["new_bid_end_date"]))?' ':$BidDetails["new_bid_end_date"]).'",
                                "bid_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
                                "bid_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
                                "old_bid_end_date":"'.((is_null($BidDetails["old_bid_end_date"]))?' ':$BidDetails["old_bid_end_date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';
		// echo "<br/>".$InfoData;
                $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1143;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
           /*------------Service Bid Mail and SMS ---Service Bid Mail and SMS ---Service Bid Mail and SMS ---------------------------*/
	/*---------------------- Send Notification to Buyer after Service Bid Created on GeM-------------------------
		// Event ID=1110/1193
	*/
	function sendNotificationForServiceBIDCreatedToBuyer($recipientDetails,$ServiceDetails,$ServiceItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1193;
                        }else{
                            $event_id = 1110;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
		        $remaining_productcount = (count($ServiceItemDetails) > 1) ? "and ".(count($ServiceItemDetails)-1)." other(s)": ' ';
			
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($ServiceDetails["recipient_name"]))?' ':$ServiceDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($ServiceDetails["bid_number"]))?' ':$ServiceDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($ServiceDetails["bid_number"]))?' ':$ServiceDetails["bid_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($ServiceItemDetails as $Item)
				{
					$InfoData .='{"service_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","qty":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],				
                                "serv_title": "'.((is_null($ServiceDetails["serv_title"]))?' ':$ServiceDetails["serv_title"]).'",
                                "service_title": "'.((is_null($ServiceDetails["serv_title"]))?' ':$ServiceDetails["serv_title"]).'",
                                "service_title1": "'.((is_null($ServiceDetails["serv_title"]))?' ':$ServiceDetails["serv_title"]).'",
				"s_date":"'.((is_null($ServiceDetails["bid_start_date"]))?' ':$ServiceDetails["bid_start_date"]).'",
				"e_date":"'.((is_null($ServiceDetails["bid_end_date"]))?' ':$ServiceDetails["bid_end_date"]).'",                                
                                "qty":"'.((is_null($ServiceDetails["qty"]))?' ':$ServiceDetails["qty"]).'"
				},
                                "correlationId": "'.((is_null($ServiceDetails["correlationId"]))?' ':$ServiceDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($ServiceDetails["initiatingAppId"]))?' ':$ServiceDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($ServiceDetails["initiatingUser"]))?' ':$ServiceDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($ServiceDetails["tenantId"]))?' ':$ServiceDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($ServiceDetails["referenceNumber"]))?' ':$ServiceDetails["referenceNumber"]).'"                                 
				}';
                                //echo $InfoData;exit;
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $ServiceDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        
        /*---------------------- Send Notification to Selelr after Service Bid Created on GeM-------------------------
		// Event ID=1111
	*/
	function sendNotificationForServiceBIDCreatedToSeller($recipientDetails,$ServiceDetails,$ServiceItemDetails,$b_bid_type)
	{
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1192;
                        }else{
                            $event_id = 1111;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
		        $remaining_productcount = (count($ServiceItemDetails) > 1) ? "and ".(count($ServiceItemDetails)-1)." other(s)": ' ';
			
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($ServiceDetails["recipient_name"]))?' ':$ServiceDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($ServiceDetails["bid_number"]))?' ':$ServiceDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($ServiceDetails["bid_number"]))?' ':$ServiceDetails["bid_number"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
                                "remaining_servicecount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($ServiceItemDetails as $Item)
				{
					$InfoData .='{"service_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","qty":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"serv_title": "'.((is_null($ServiceDetails["product_name"]))?' ':$ServiceDetails["product_name"]).'",
                                "service_title1": "'.((is_null($ServiceDetails["product_name"]))?' ':$ServiceDetails["product_name"]).'",
                                "service_title": "'.((is_null($ServiceDetails["product_name"]))?' ':$ServiceDetails["product_name"]).'",
				"s_date":"'.((is_null($ServiceDetails["bid_start_date"]))?' ':$ServiceDetails["bid_start_date"]).'",
				"e_date":"'.((is_null($ServiceDetails["bid_end_date"]))?' ':$ServiceDetails["bid_end_date"]).'",
                                "ra_start_date":"'.((is_null($ServiceDetails["bid_start_date"]))?' ':$ServiceDetails["bid_start_date"]).'",
				"ra_end_date":"'.((is_null($ServiceDetails["bid_end_date"]))?' ':$ServiceDetails["bid_end_date"]).'",                                
                                "qty":"'.((is_null($ServiceDetails["qty"]))?' ':$ServiceDetails["qty"]).'"
				},
                                "correlationId": "'.((is_null($ServiceDetails["correlationId"]))?' ':$ServiceDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($ServiceDetails["initiatingAppId"]))?' ':$ServiceDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($ServiceDetails["initiatingUser"]))?' ':$ServiceDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($ServiceDetails["tenantId"]))?' ':$ServiceDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($ServiceDetails["referenceNumber"]))?' ':$ServiceDetails["referenceNumber"]).'"                                 
				}';
                                //echo $InfoData;exit;
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $ServiceDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
            /*---------------------- Send Notification to Buyer after Bid Cancelled on GeM-------------------------
		// Event ID=1013
	*/
	function sendNotificationForBidCancelledToPU($recipientDetails,$BidDetails,$BidItemDetails)
	{   
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1013",
				"notificationData": {
                                "remaining_productcount":  "'.((is_null($remaining_productcount))?' ':$remaining_productcount).'",
                                "recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],
				"product_title1": "'.((is_null($BidDetails["product_name"]))?' ':$BidDetails["product_name"]).'",
                                "bid_start_date":"'.((is_null($BidDetails["bid_start_date"]))?' ':$BidDetails["bid_start_date"]).'",
				"bid_end_date":"'.((is_null($BidDetails["bid_end_date"]))?' ':$BidDetails["bid_end_date"]).'",
                                "buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
				"cancelled_date":"'.((is_null($BidDetails["cancelled_date"]))?' ':$BidDetails["cancelled_date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';
		 
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1013;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
            /*---------------------- Send Notification to Buyer after Bid Award on GeM-------------------------
		// Event ID=1079
	*/
	function sendNotificationForBidAwardToPU($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{
              
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1185;
                        }else{
                            $event_id = 1079;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                 "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","qty":"'.$Item["quantity"].'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],	
				"buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
				"seller_name":"'.((is_null($BidDetails["seller_name"]))?' ':$BidDetails["seller_name"]).'",
				"date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';


		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        // 1108 Bid Response submitted successfully
        function sendNotificationForBidResponseToSeller($recipientDetails,$BidDetails,$BidItemDetails,$b_bid_type)
	{   
		$InfoData='';
                        if($b_bid_type==5){
                            $event_id = 1188;
                        }else{
                            $event_id = 1108;
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = (count($BidItemDetails) > 1) ? "and ".(count($BidItemDetails)-1)." other(s)": ' ';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
                                "remaining_productcount":  "'.((is_null($remaining_productcount))?' ':$remaining_productcount).'",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"products":[';
				
				foreach($BidItemDetails as $Item)
				{
					$InfoData .='{"product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],				
                                "buyer_office":"'.((is_null($BidDetails["buyer_office"]))?' ':$BidDetails["buyer_office"]).'",
                                "buyer_org":"'.((is_null($BidDetails["buyer_org"]))?' ':$BidDetails["buyer_org"]).'",
				"date":"'.((is_null($BidDetails["date"]))?' ':$BidDetails["date"]).'"
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';
		 
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        
        /*****************************************************************************
         * Task: Send Notification to seller for request for ePBG
	 * Event ID = 1146
	******************************************************************************/
	function sendNotificationForePBGToSeller($recipientDetails,$ServiceDetails)
	{
		$InfoData=''; //1146

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1146",
				"notificationData": {
				"recipient_name":"'.((is_null($ServiceDetails["recipient_name"]))?' ':$ServiceDetails["recipient_name"]).'",
				"bid_num": "'.((is_null($ServiceDetails["bid_number"]))?' ':$ServiceDetails["bid_number"]).'",
                                "pbg_submit_date":"'.((is_null($ServiceDetails["pbg_submit_date"]))?' ':$ServiceDetails["pbg_submit_date"]).'",
				"b_id":"'.((is_null($ServiceDetails["b_id"]))?' ':$ServiceDetails["b_id"]).'"
				},
                                "correlationId": "'.((is_null($ServiceDetails["correlationId"]))?' ':$ServiceDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($ServiceDetails["initiatingAppId"]))?' ':$ServiceDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($ServiceDetails["initiatingUser"]))?' ':$ServiceDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($ServiceDetails["tenantId"]))?' ':$ServiceDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($ServiceDetails["referenceNumber"]))?' ':$ServiceDetails["referenceNumber"]).'"                                 
				}';
                                //echo $InfoData;exit;
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $ServiceDetails["b_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1146;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        /*---------------------- Send Notification to RA Financial Invitation Participate----------
		// Event ID=1008
	*/
	function sendNotificationForRAReminderToRAFinancial($recipientDetails,$BidDetails)
	{
		$InfoData='';

			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							  "firstName": "'.$val["firstName"].'",
							  "lastName": "'.$val["lastName"].'",
							  "mobileNumber": "'.$val["mobileNumber"].'",
							  "userNo": "'.$val["userNo"].'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.$val["emailId"].'"
							},';
			}
                        $InfoData = trim($InfoData,',');
                        $remaining_productcount = '';
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": "1190",
				"notificationData": {                                
                                "remaining_productcount": "'.$remaining_productcount.'",
				"recipient_name":"Buyer",
				"ra_number": "'.((is_null($BidDetails["ra_number"]))?' ':$BidDetails["ra_number"]).'",
				"ra_end_datetime":"'.((is_null($BidDetails["ra_end_datetime"]))?' ':$BidDetails["ra_end_datetime"]).'"
				},
				"correlationId": "'.$BidDetails["correlationId"].'",
				"initiatingAppId":"'.$BidDetails["initiatingAppId"].'",
				"locale":"en_US",
				"initiatingUser":"'.$BidDetails["initiatingUser"].'",
				"attachmentPaths":"",
				"tenantId":"'.$BidDetails["tenantId"].'",
				"referenceNumber":"'.$BidDetails["referenceNumber"].'"
				}';
                     //echo $InfoData;
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1190;
                $data['is_buyer'] = 2;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        function sendNotificationForServiceBIDCreatedToPU($recipientDetails,$ServiceDetails,$ServiceItemDetails)
	{
		$InfoData='';                        
                        $event_id = 1194;
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
		        $remaining_productcount = (count($ServiceItemDetails) > 1) ? "and ".(count($ServiceItemDetails)-1)." other(s)": ' ';
			
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($ServiceDetails["recipient_name"]))?' ':$ServiceDetails["recipient_name"]).'",
				"bid_number": "'.((is_null($ServiceDetails["bid_number"]))?' ':$ServiceDetails["bid_number"]).'",
                                "ra_number": "'.((is_null($ServiceDetails["bid_number"]))?' ':$ServiceDetails["bid_number"]).'",
                                "buyer_office": "'.((is_null($ServiceDetails["buyer_office"]))?' ':$ServiceDetails["buyer_office"]).'",
                                "buyer_org": "'.((is_null($ServiceDetails["buyer_org"]))?' ':$ServiceDetails["buyer_org"]).'",
                                "remaining_productcount": "'.$remaining_productcount.'",
                                "remaining_servicecount": "'.$remaining_productcount.'",
				"products":[';
				
				foreach($ServiceItemDetails as $Item)
				{
					$InfoData .='{"service_title1":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","service_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","product_title":"'.((is_null($Item["product_title"]))?' ':$Item["product_title"]).'","qty":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","quantity":"'.((is_null($Item["quantity"]))?' ':$Item["quantity"]).'","expected_delivery_date":"'.((is_null($Item["expected_delivery_date"]))?' ':$Item["expected_delivery_date"]).'",
					"consignee":"'.((is_null($Item["consignee"]))?' ':$Item["consignee"]).'","delivery_address":"'.((is_null($Item["delivery_address"]))?' ':$Item["delivery_address"]).'"},';
				}
				$InfoData = trim($InfoData,',');
				$InfoData .='],				
                                "service_title": "'.((is_null($ServiceDetails["serv_title"]))?' ':$ServiceDetails["serv_title"]).'",
                                "service_title1": "'.((is_null($ServiceDetails["serv_title"]))?' ':$ServiceDetails["serv_title"]).'",
                                "serv_title": "'.((is_null($ServiceDetails["serv_title"]))?' ':$ServiceDetails["serv_title"]).'",
				"s_date":"'.((is_null($ServiceDetails["bid_start_date"]))?' ':$ServiceDetails["bid_start_date"]).'",
				"e_date":"'.((is_null($ServiceDetails["bid_end_date"]))?' ':$ServiceDetails["bid_end_date"]).'",                                
                                "qty":"'.((is_null($ServiceDetails["qty"]))?' ':$ServiceDetails["qty"]).'"
				},
                                "correlationId": "'.((is_null($ServiceDetails["correlationId"]))?' ':$ServiceDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($ServiceDetails["initiatingAppId"]))?' ':$ServiceDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($ServiceDetails["initiatingUser"]))?' ':$ServiceDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($ServiceDetails["tenantId"]))?' ':$ServiceDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($ServiceDetails["referenceNumber"]))?' ':$ServiceDetails["referenceNumber"]).'"                                 
				}';
                                //echo $InfoData;exit;
		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $ServiceDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = 1194;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
    }
    public function __prepareReceepients($qualifiers) {
        if (!empty($qualifiers) && isset($qualifiers->comps) && count($qualifiers->comps) > 0 ) {
            $recipientDetails = [];
            foreach ($qualifiers->comps as $v) {
//                echo "<pre>"; print_r($v);
                $arr = [];
                $arr ['firstName'] = $v->sd_seller_name;
                $arr ['lastName'] = '';
                $arr ['mobileNumber'] = $v->sd_mobile;
                $arr ['emailId'] = $v->sd_email;
                $arr ['userNo'] = $v->sd_seq_id;
                $arr ['sd_user_id'] = $v->sd_user_id;
                $recipientDetails[] = $arr;
            }
            return $recipientDetails;
        }
        return false;
    }
    /*---------------------- Send Notification to Recipient after Bid Corrigendum created on GeM---------------
            // Event ID=2004/2005
    */
    function sendNotificationForBidCorrigendumToSeller($recipientDetails,$BidDetails,$b_bid_type,$is_buyer)
        {
        $recipientDetails = json_encode($recipientDetails);
        $recipientDetails = json_decode($recipientDetails, true);
            $InfoData='';
                    if($b_bid_type==5){
                        $event_id = 2005;
                    }else{
                        $event_id = 2004;
                    }
                    $InfoData .= '{
                                    "recipientDetails": [{
                                    "recipientCategory": "GEM",
                                            "recipients": [';

                    foreach($recipientDetails as $val)
                    {
                            $email = $val["emailId"];
                            $InfoData .= '{
                                                     "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
                                                      "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
                                                      "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                                                      "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'",   
                                                      "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
                                                      "pushTokens": [{
                                                              "platform": "ios",
                                                              "token": "001"
                                                            }]

                                                    },';
                    }
                    $InfoData = trim($InfoData,','); 
                    $InfoData .=' ] }],
                            "initiatingUser": "GEM",
                            "referenceNumber": "GEM",
                            "eventId": '.$event_id.',
                            "notificationData": {
                            "recipient_name":"Seller",
                            "e_bidno": "'.((is_null($BidDetails["e_bidno"]))?' ':$BidDetails["e_bidno"]).'",
                            "ra_no": "'.((is_null($BidDetails["e_bidno"]))?' ':$BidDetails["e_bidno"]).'",
                            "cdate": "'.((is_null($BidDetails["cdate"]))?' ':$BidDetails["cdate"]).'",    
                            "bdate": "'.((is_null($BidDetails["bdate"]))?' ':$BidDetails["bdate"]).'"   
                            },
                            "locale":"en_US",
                            "initiatingAppId": "GEM",
                            "correlationId": "009909"
                            }';
                     $InfoData;

            //return $this->__callToMessegeHub($InfoData);
             $response =  $this->__callToMessegeHub($InfoData);
            $data['bnl_bid_id'] = $BidDetails["b_id"];
            $data['email_id'] = $email;
            $data['event_id'] = $event_id;
            $data['is_buyer'] = $is_buyer;
            $data['bnl_request'] = $InfoData;
            $data['bnl_response'] = $response;               
            $data['bnl_created_on'] = date('Y-m-d H:i:s');
            saved_notificaion_log($data);
            return $response;
    }
     //2003 Bid Response submitted successfully
    function sendNotificationForL1PriceMatchToSeller($recipientDetails,$BidDetails,$b_bid_type)
    {   
        $InfoData='';
        if($b_bid_type==2){
           $event_id = 1201;
        }else{
           $event_id = 2003;
        }//prx($recipientDetails);
        $InfoData .= '{
                            "recipientDetails": [
                                {
                                "recipients": [';

            foreach($recipientDetails as $val)
            {
                $email = $val["emailId"];
                    $InfoData .= '{
                        "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
                        "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
                        "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                        "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
                        "pushTokens": [
                              {
                                "platform": "ios",
                                "token": "001"
                              },
                              {
                                "platform": "android",
                                "token": "002"
                              }
                        ],
                        "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
                      },';
            }
            $InfoData = trim($InfoData,',');            
            $InfoData .=' ],
                        "recipientCategory": "GEM"
                                        }
                                ],
                        "eventId": '.$event_id.',
                        "notificationData": {                        
                        "bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                        "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'"                       
                        },
                        "correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
                        "initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
                        "locale":"en_US",
                        "initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
                        "attachmentPaths":"",
                        "tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
                        "referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
                        }';
        $response =  $this->__callToMessegeHub($InfoData);
        $data['bnl_bid_id'] = $BidDetails["ba_id"];
        $data['email_id'] = $email;
        $data['event_id'] = $event_id;
        $data['is_buyer'] = 2;
        $data['bnl_request'] = $InfoData;
        $data['bnl_response'] = $response;               
        $data['bnl_created_on'] = date('Y-m-d H:i:s');
        saved_notificaion_log($data);
        return $response;
    }
    //2002 Bid Response submitted successfully
    function sendNotificationForL1PriceBySellerToBuyer($recipientDetails,$BidDetails,$b_bid_type)
    {   
        $InfoData='';
        if($b_bid_type==2){
           $event_id = 1200;
        }else{
           $event_id = 2002;
        }
        $InfoData .= '{
                            "recipientDetails": [
                                {
                                "recipients": [';

            foreach($recipientDetails as $val)
            {
                $email = $val["emailId"];
                    $InfoData .= '{
                        "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
                        "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
                        "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                        "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
                        "pushTokens": [
                              {
                                "platform": "ios",
                                "token": "001"
                              },
                              {
                                "platform": "android",
                                "token": "002"
                              }
                        ],
                        "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
                      },';
            }
            $InfoData = trim($InfoData,',');            
            $InfoData .=' ],
                        "recipientCategory": "GEM"
                                        }
                                ],
                        "eventId": '.$event_id.',
                        "notificationData": {                        
                        "bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                        "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                        "seller_name": "'.((is_null($BidDetails["seller_name"]))?' ':$BidDetails["seller_name"]).'",
                        "offer_status": "'.((is_null($BidDetails["offer_status"]))?' ':$BidDetails["offer_status"]).'" 
                        },
                        "correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
                        "initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
                        "locale":"en_US",
                        "initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
                        "attachmentPaths":"",
                        "tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
                        "referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
                        }';
        $response =  $this->__callToMessegeHub($InfoData);
        $data['bnl_bid_id'] = $BidDetails["ba_id"];
        $data['email_id'] = $email;
        $data['event_id'] = $event_id;
        $data['is_buyer'] = 1;
        $data['bnl_request'] = $InfoData;
        $data['bnl_response'] = $response;               
        $data['bnl_created_on'] = date('Y-m-d H:i:s');
        saved_notificaion_log($data);
        return $response;
    }
    
    function NegotiatePriceToSeller($recipientDetails,$BidDetails,$b_bid_type)
    {   
        $InfoData='';
        if($b_bid_type==2 || $b_bid_type==5){
           $event_id = 1205;
        }else{
           $event_id = 1203;
        }//prx($recipientDetails);
        $InfoData .= '{
                            "recipientDetails": [
                                {
                                "recipients": [';

            foreach($recipientDetails as $val)
            {
                $email = $val["emailId"];
                    $InfoData .= '{
                        "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
                        "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
                        "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                        "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
                        "pushTokens": [
                              {
                                "platform": "ios",
                                "token": "001"
                              },
                              {
                                "platform": "android",
                                "token": "002"
                              }
                        ],
                        "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
                      },';
            }
            $InfoData = trim($InfoData,',');            
            $InfoData .=' ],
                        "recipientCategory": "GEM"
                                        }
                                ],
                        "eventId": '.$event_id.',
                        "notificationData": {                        
                        "bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                        "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'"                       
                        },
                        "correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
                        "initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
                        "locale":"en_US",
                        "initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
                        "attachmentPaths":"",
                        "tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
                        "referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
                        }';
        $response =  $this->__callToMessegeHub($InfoData);
        $data['bnl_bid_id'] = $BidDetails["ba_id"];
        $data['email_id'] = $email;
        $data['event_id'] = $event_id;
        $data['is_buyer'] = 2;
        $data['bnl_request'] = $InfoData;
        $data['bnl_response'] = $response;               
        $data['bnl_created_on'] = date('Y-m-d H:i:s');
        saved_notificaion_log($data);
        return $response;
    }
     function NegotiatePriceToBuyer($recipientDetails,$BidDetails,$b_bid_type)
    {   
        $InfoData='';
        if($b_bid_type==2 || $b_bid_type==5){
           $event_id = 1206;
        }else{
           $event_id = 1204;
        }//prx($recipientDetails);
        $InfoData .= '{
                            "recipientDetails": [
                                {
                                "recipients": [';

            foreach($recipientDetails as $val)
            {
                $email = $val["emailId"];
                    $InfoData .= '{
                        "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
                        "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
                        "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                        "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
                        "pushTokens": [
                              {
                                "platform": "ios",
                                "token": "001"
                              },
                              {
                                "platform": "android",
                                "token": "002"
                              }
                        ],
                        "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
                      },';
            }
            $InfoData = trim($InfoData,',');            
            $InfoData .=' ],
                        "recipientCategory": "GEM"
                                        }
                                ],
                        "eventId": '.$event_id.',
                        "notificationData": {                        
                        "bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                        "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'"                       
                        },
                        "correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
                        "initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
                        "locale":"en_US",
                        "initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
                        "attachmentPaths":"",
                        "tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
                        "referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
                        }';
        $response =  $this->__callToMessegeHub($InfoData);
        $data['bnl_bid_id'] = $BidDetails["ba_id"];
        $data['email_id'] = $email;
        $data['event_id'] = $event_id;
        $data['is_buyer'] = 2;
        $data['bnl_request'] = $InfoData;
        $data['bnl_response'] = $response;               
        $data['bnl_created_on'] = date('Y-m-d H:i:s');
        saved_notificaion_log($data);
        return $response;
    }
    function sendNotificationForBidDraftCorrigendumToBuyer($recipientDetails,$BidDetails,$is_buyer)
    {
        $recipientDetails = json_encode($recipientDetails);
        $recipientDetails = json_decode($recipientDetails, true);
        $InfoData='';
        $event_id = 1223;
        $InfoData .= '{
					"recipientDetails": [{
                                        "recipientCategory": "GEM",
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                                $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                                                          "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'",   
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [{
								  "platform": "ios",
								  "token": "001"
								}]
							  
							},';
			}
                        $InfoData = trim($InfoData,','); 
			$InfoData .=' ] }],
				"initiatingUser": "GEM",
				"referenceNumber": "GEM",
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"Buyer",
				"bid_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'"
                                },
				"locale":"en_US",
                                "initiatingAppId": "GEM",
	                        "correlationId": "009909"
				}';
                         $InfoData;
                         
		//return $this->__callToMessegeHub($InfoData);
                 $response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["b_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                $data['is_buyer'] = $is_buyer;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
        
        function sendNotificationextendValidityToSeller($recipientDetails,$BidDetails)
        {
        $recipientDetails = json_encode($recipientDetails);
        $recipientDetails = json_decode($recipientDetails, true);
            $InfoData='';
                   
                    $InfoData .= '{
                                    "recipientDetails": [{
                                    "recipientCategory": "GEM",
                                            "recipients": [';

                    foreach($recipientDetails as $val)
                    {
                            $email = $val["emailId"];
                            $InfoData .= '{
                                                     "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
                                                      "lastName":"",
                                                      "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                                                      "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'",   
                                                      "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
                                                      "pushTokens": [{
                                                              "platform": "ios",
                                                              "token": "001"
                                                            }]

                                                    },';
                    }
                    $InfoData = trim($InfoData,','); 
                    $InfoData .=' ] }],
                            "initiatingUser": "GEM",
                            "referenceNumber": "GEM",
                            "eventId": "1247",
                            "notificationData": {
                            "recipient_name":"Seller",
                            "BID_NUMBER": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                            "VALID_UPTO": "'.((is_null($BidDetails["current_validity"]))?' ':$BidDetails["current_validity"]).'",
                            "EXTENDED_UPTO": "'.((is_null($BidDetails["extend_upto"]))?' ':$BidDetails["extend_upto"]).'",    
                            "TYPE": "'.((is_null($BidDetails["type"]))?' ':$BidDetails["type"]).'"   
                            },
                            "locale":"en_US",
                            "initiatingAppId": "GEM",
                            "correlationId": "009909"
                            }';
            //return $this->__callToMessegeHub($InfoData);
             $response =  $this->__callToMessegeHub($InfoData);
            $data['bnl_bid_id'] = $BidDetails["b_id"];
            $data['email_id'] = $email;
            $data['event_id'] = 1247;
            $data['is_buyer'] = 2;
            $data['bnl_request'] = $InfoData;
            $data['bnl_response'] = $response;               
            $data['bnl_created_on'] = date('Y-m-d H:i:s');
            saved_notificaion_log($data);
            return $response;
    }
    function sendNotificationextendValidityToBuyer($recipientDetails,$BidDetails)
        {
        $recipientDetails = json_encode($recipientDetails);
        $recipientDetails = json_decode($recipientDetails, true);
            $InfoData='';
                   
                    $InfoData .= '{
                                    "recipientDetails": [{
                                    "recipientCategory": "GEM",
                                            "recipients": [';

                    foreach($recipientDetails as $val)
                    {
                            $email = $val["emailId"];
                            $InfoData .= '{
                                                     "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
                                                      "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
                                                      "mobileNumber": "'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
                                                      "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'",   
                                                      "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
                                                      "pushTokens": [{
                                                              "platform": "ios",
                                                              "token": "001"
                                                            }]

                                                    },';
                    }
                    $InfoData = trim($InfoData,','); 
                    $InfoData .=' ] }],
                            "initiatingUser": "GEM",
                            "referenceNumber": "GEM",
                            "eventId": "1248",
                            "notificationData": {
                            "recipient_name":"Buyer",
                            "SELLER_NAME": "'.((is_null($BidDetails["seller_name"]))?' ':$BidDetails["seller_name"]).'",
                            "OFFER_STATUS": "'.((is_null($BidDetails["offerstatus"]))?' ':$BidDetails["offerstatus"]).'",
                            "BID_NUMBER": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                            "VALID_UPTO": "'.((is_null($BidDetails["current_validity"]))?' ':$BidDetails["current_validity"]).'",
                            "EXTENDED_UPTO": "'.((is_null($BidDetails["extend_upto"]))?' ':$BidDetails["extend_upto"]).'",    
                            "TYPE": "'.((is_null($BidDetails["type"]))?' ':$BidDetails["type"]).'"   
                            },
                            "locale":"en_US",
                            "initiatingAppId": "GEM",
                            "correlationId": "009909"
                            }';
            //return $this->__callToMessegeHub($InfoData);
             $response =  $this->__callToMessegeHub($InfoData);
            $data['bnl_bid_id'] = $BidDetails["b_id"];
            $data['email_id'] = $email;
            $data['event_id'] = 1248;
            $data['is_buyer'] = 1;
            $data['bnl_request'] = $InfoData;
            $data['bnl_response'] = $response;               
            $data['bnl_created_on'] = date('Y-m-d H:i:s');
            saved_notificaion_log($data);
            return $response;
    }
    
    /*---------------------- Send Notification to HOD for Competent Authority Apporval Upload ------------------------*/
    function sendNotificationForCAAUpload($recipientDetails,$BidDetails,$b_bid_type)
	{
              
		$InfoData='';
                $event_id = 1252;
                $typ_lbl = '';
                        if($b_bid_type==5){
                            $typ_lbl = 'RA No.';
                        }else{
                            $typ_lbl = 'Bid No.';
                        }
			$InfoData .= '{
					"recipientDetails": [
						{
						"recipients": [';
						
			foreach($recipientDetails as $val)
			{
                            $email = $val["emailId"];
				$InfoData .= '{
							 "firstName": "'.((is_null($val["firstName"]))?' ':$val["firstName"]).'",
							  "lastName":"'.((is_null($val["lastName"]))?' ':$val["lastName"]).'",
							  "mobileNumber":"'.((is_null($val["mobileNumber"]))?' ':$val["mobileNumber"]).'",
							  "userNo": "'.((is_null($val["userNo"]))?' ':$val["userNo"]).'",
							  "pushTokens": [
								{
								  "platform": "ios",
								  "token": "001"
								},
								{
								  "platform": "android",
								  "token": "002"
								}
							  ],
							  "emailId": "'.((is_null($val["emailId"]))?' ':$val["emailId"]).'"
							},';
			}
                        $InfoData = trim($InfoData,',');
			$InfoData .=' ],
				"recipientCategory": "GEM"
						}
					],
				"eventId": '.$event_id.',
				"notificationData": {
				"recipient_name":"'.((is_null($BidDetails["recipient_name"]))?' ':$BidDetails["recipient_name"]).'",
				"bidNumber": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
                                 "ra_number": "'.((is_null($BidDetails["bid_number"]))?' ':$BidDetails["bid_number"]).'",
				"buyer_office":"",
				"buyerName": "'.((is_null($BidDetails["buyerName"]))?' ':$BidDetails["buyerName"]).'",
				"bidType": "'.$typ_lbl.'",
				"seller_name":"",
				"date":""
				},
				"correlationId": "'.((is_null($BidDetails["correlationId"]))?' ':$BidDetails["correlationId"]).'",
				"initiatingAppId":"'.((is_null($BidDetails["initiatingAppId"]))?' ':$BidDetails["initiatingAppId"]).'",
				"locale":"en_US",
				"initiatingUser":"'.((is_null($BidDetails["initiatingUser"]))?' ':$BidDetails["initiatingUser"]).'",
				"attachmentPaths":"",
				"tenantId":"'.((is_null($BidDetails["tenantId"]))?' ':$BidDetails["tenantId"]).'",
				"referenceNumber":"'.((is_null($BidDetails["referenceNumber"]))?' ':$BidDetails["referenceNumber"]).'"
				}';


		$response =  $this->__callToMessegeHub($InfoData);
                $data['bnl_bid_id'] = $BidDetails["ba_id"];
                $data['email_id'] = $email;
                $data['event_id'] = $event_id;
                 $data['is_buyer'] = 1;
                $data['bnl_request'] = $InfoData;
                $data['bnl_response'] = $response;               
                $data['bnl_created_on'] = date('Y-m-d H:i:s');
                saved_notificaion_log($data);
                return $response;
	}
}
?>
