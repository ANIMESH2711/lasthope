<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Arx_auth
 * Authentication library for Code Igniter.
 * @package		Arx_auth
 * 
 */
class Arx_auth {

    function __construct() {

        $this->ci = & get_instance();
		$this->arxKey = $this->ci->config->item('arxKey');
    }

    /**
     * Logout user from the site
     *
     * @return	void
     */
    function logout() {
        $this->arx_logout_user(); // log out from ARX server on behalf of user ticket stored in session
        //$this->delete_autologin();
        $this->__unsetuserdata();
        $this->ci->session->sess_destroy();
    }

    function logout_before() {
        $this->__unsetuserdata();
        $this->ci->session->sess_destroy();
    }

    /**
     * Check if user logged in. Also test if user is activated or not.
     *
     * @param	bool
     * @return	bool
     */
    function is_logged_in($activated = TRUE) {

        return $this->ci->session->userdata('status') === ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
    }

    /**
     * Clear user's autologin data
     *
     * @return	void
     */
    private function delete_autologin() {
        $this->ci->load->helper('cookie');
        if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'arx_auth'), TRUE)) {

            $data = unserialize($cookie);

            $this->ci->load->model('arx_auth/user_autologin');
            $this->ci->user_autologin->delete($data['user_id'], md5($data['key']));

            delete_cookie($this->ci->config->item('autologin_cookie_name', 'arx_auth'));
        }
    }

    /*     * *
     * 
     * logged info
     * 
     */

    function arx_loggedin_info($user_ticket) {
        if (empty($user_ticket)) {
            return false;
        }
        $response = '';
        $url = $this->ci->config->item('ArmorSOAServices') . '/GetLoggedInInfo';
        $post_data = $user_ticket;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));

        $responce_code = $response->serviceStatusResponse->responseCode;
        curl_close($ch);
        if ($responce_code == 0) { // valid user and login success
            return $response;
        } else {
            return false;
        }
    }
    
    
    function arx_loggedin_info_admin($user_ticket) {
        $this->ci = & get_instance();
        $url = $this->ci->config->item('audit_arx_url');
        $post_data = array(
            'userTicket' => $user_ticket
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));
        
        $responce_code = $response->serviceStatusResponse->responseCode;
        curl_close($ch);

        if ($responce_code == 0) { // valid user and login success
            return true;
        } else {
            return false;
        }
    }

    /*
     * 
     * @desc : user logged info
     */

    function arx_loggedin_userinfo($user_ticket) {
        if (empty($user_ticket)) {
            return false;
        }
        $response = '';
        $url = $this->ci->config->item('ArmorSOAServices') . '/GetLoggedInUserInfo';
        $post_data = array(
            'userTicket' => $user_ticket
        );

        //print_r($post_data);die;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));

        $responce_code = $response->serviceStatusResponse->responseCode;
        curl_close($ch);

        if ($responce_code == 0) { // valid user and login success
            return $response;
        } else {
            return false;
        }
    }

    /*
     * 
     * @desc : log out user from arx
     */

    function arx_logout_user() {
        $user_ticket = $this->ci->session->userdata('user_ticket');

        if (empty($user_ticket)) {
            return false;
        }
        $response = '';

        $url = $this->ci->config->item('ArmorSOAServices') . '/LogOutUser';
        $post_data = array(
            'userTicket' => $user_ticket
        );

        //pr($post_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //$proxy_url = "https://10.247.51.9:8080";
        //curl_setopt($ch, CURLOPT_PROXY, $proxy_url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));
        $responce_code = $response->serviceStatusResponse->responseCode;
        curl_close($ch);

        if ($responce_code == 0) { // valid user and login success
            $this->ci->session->unset_userdata('user_ticket');
            return true;
        } else {
            return false;
        }
    }

    /*
     * validte user ticket
     * 
     */

    function validateTicket() {
        $user_ticket = $this->ci->session->userdata('user_ticket');

        if (empty($user_ticket)) {
            return false;
        }
        $response = '';

        $url = $this->ci->config->item('ArmorSOAServices') . '/ValidateUserTicket';
        $post_data = array(
            'userTicket' => $user_ticket
        );

        //pr($post_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //$proxy_url = "https://10.247.51.9:8080";
        //curl_setopt($ch, CURLOPT_PROXY, $proxy_url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));
        //$responce_code = $response->serviceStatusResponse->responseCode;
        $responce_code = $response->responseCode;
        curl_close($ch);

        if ($responce_code == 0) { // valid user and login success
            return true;
        } else {
            return false;
        }
    }

    /*
     * @desc : view user arx
     * @param : userid string
     * @return: array
     */

    function viewUserArx($UserId) {

        $response = array();
        try {
            $this->validateTicket();
            $user_ticket = $this->ci->session->userdata('user_ticket');
	//		$user_ticket = $this->arxKey;

            if (empty($user_ticket)) {
                $response = array('status' => false, 'responseData' => 'Invalid ticket');
                return $response;
            }


            $url = $this->ci->config->item('ArmorSOAServices') . '/ViewUser';
            $post_data = array(
                'ticket' => $user_ticket,
                'userId' => $UserId
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responsedata = json_decode(curl_exec($ch));
            
            if ($errno = curl_errno($ch)) {
                $error_message = curl_strerror($errno);
                $response_1_error = "cURL error ({$errno}):\n {$error_message}";
                $response = array('status' => false, 'responseData' => $response_1_error);
                return $response;
            }
            curl_close($ch);
            $response = array('status' => true, 'responseData' => $responsedata);
            return $response;
        } catch (Exception $e) {

            $response = array('status' => false, 'responseData' => $e->getMessage());
            return $response;
        }
    }

    function __unsetuserdata() {

        $userdata = array('user_ticket', 'userId', 'user_detail', 'ref_url', 'status', 'role_id');
        $this->ci->session->unset_userdata($userdata);
    }
    
    
       function getDDoArx($UserId) {

            $response = array();
            try {
                $this->validateTicket();
                $user_ticket = $this->ci->session->userdata('user_ticket');
    //                        $user_ticket = $this->arxKey;

                if (empty($user_ticket)) {
                    $response = array('status' => false, 'responseData' => 'Invalid ticket');
                    return $response;
                }


                $url = $this->ci->config->item('ArmorSOAServices') . '/ViewDDOUsers';
                $post_data = array(
                    'userTicket' => $user_ticket,
                    'userId' => $UserId
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $responsedata = json_decode(curl_exec($ch));

                if ($errno = curl_errno($ch)) {
                    $error_message = curl_strerror($errno);
                    $response_1_error = "cURL error ({$errno}):\n {$error_message}";
                    $response = array('status' => false, 'responseData' => $response_1_error);
                    return $response;
                }
                curl_close($ch);
                $response = array('status' => true, 'responseData' => $responsedata);
                return $response;
            } catch (Exception $e) {

                $response = array('status' => false, 'responseData' => $e->getMessage());
                return $response;
            }
        }
           /*
     * @desc : view Hod arx
     * @param : userid string
     * @return: array
     */

    function viewHOdArx($UserId) {

        $response = array();
        try {
            $user_ticket = $this->ci->session->userdata('user_ticket');
//			$user_ticket = $this->arxKey;

            if (empty($user_ticket)) {
                $response = array('status' => false, 'responseData' => 'Invalid ticket');
                return $response;
            }


            $url = $this->ci->config->item('ViewHodUser');
            $post_data = array(
                'userTicket' => $user_ticket,
                'userId' => $UserId
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responsedata = json_decode(curl_exec($ch));
            
            if ($errno = curl_errno($ch)) {
                $error_message = curl_strerror($errno);
                $response_1_error = "cURL error ({$errno}):\n {$error_message}";
                $response = array('status' => false, 'responseData' => $response_1_error);
                return $response;
            }
            curl_close($ch);
            $response = array('status' => true, 'responseData' => $responsedata);
            return $response;
        } catch (Exception $e) {

            $response = array('status' => false, 'responseData' => $e->getMessage());
            return $response;
        }
    }
    function viewUserCracPending($UserId) {

        $response = array();
        try {
            $this->validateTicket();
            $user_ticket = $this->arxKey;
	//		$user_ticket = $this->arxKey;

            if (empty($user_ticket)) {
                $response = array('status' => false, 'responseData' => 'Invalid ticket');
                return $response;
            }


            $url = $this->ci->config->item('ArmorSOAServices') . '/ViewUser';
            $post_data = array(
                'ticket' => $user_ticket,
                'userId' => $UserId,
                'userAttributes'=>"crac_70_status"    
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responsedata = json_decode(curl_exec($ch));
            
            if ($errno = curl_errno($ch)) {
                $error_message = curl_strerror($errno);
                $response_1_error = "cURL error ({$errno}):\n {$error_message}";
                $response = array('status' => false, 'responseData' => $response_1_error);
                return $response;
            }
            curl_close($ch);
            $response = array('status' => true, 'responseData' => $responsedata);
            return $response;
        } catch (Exception $e) {

            $response = array('status' => false, 'responseData' => $e->getMessage());
            return $response;
        }
    }


}

/* End of file arx_auth.php */
/* Location: ./application/libraries/arx_auth.php */