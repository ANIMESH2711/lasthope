<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Signup extends App_Controller
{
    private $data = [];
    public function __construct()
    {
        $headerCSP = "Content-Security-Policy:".
        "connect-src 'self' ;". // XMLHttpRequest (AJAX request), WebSocket or EventSource.
        "default-src 'self';". // Default policy for loading html elements
        "frame-ancestors 'self' ;". //allow parent framing - this one blocks click jacking and ui redress
        "frame-src 'none';". // vaid sources for frames
        "object-src 'none'; ". // valid object embed and applet tags src
        // allows js from self, jquery and google analytics.  Inline allows inline js
        "style-src 'self' 'unsafe-inline';";// allows css from self and inline allows inline css
        header($contentSecurityPolicy);
        header('X-Frame-Options: SAMEORIGIN');
        parent::__construct();
        $this->base_url = $this->config->item('base_url');
        if ($this->base_url != $this->base_url) {
            header("Location: https://urise.up.gov.in");
        }
        ini_set('memory_limit', -1);
        $this->load->library(array('user_agent', 'emaillibrary', 'encryptlibrary', 'session', 'form_validation','Csrf_custom'));
        date_default_timezone_set('Asia/Calcutta');
        $this->load->helper(array('security', 'common', 'url', 'email_helper'));
        $this->load->model(array('Signup_Model'));
        $this->load->model(array('Lib_model'));
        $this->authKey = 'Alpha837503';
        $this->sellerAuthKey = 'BNiKdG2U5PTA';
        $this->expireAfter = 30; // Minutes
    }

    public function index()
    {
        $token = $this->input->get('token');
        // $data['csrf_name'] = $this->csrf_custom->get_token_name();
        // $data['csrf_hash'] = $this->csrf_custom->get_token_hash();
        if (!empty($token)) {
            $user_info = base64_decode($token);
            $user_info = explode('|', $user_info);
            $user_type = $user_info['2'];
        } else {
            $user_type = 'PU';
        }
        $data['token'] = $token;
        $data['user_type'] = $user_type;
        if (!empty($data['token']) && $user_type == 'SU' || $user_type == 'TU') {
            $this->load->view('user/signup', $data);
        } elseif (empty($data['token']) &&  $user_type == 'PU') {
            $this->load->view('user/signup', $data);
        } else {
            $this->session->set_flashdata('error', 'Please use correct link to register which is sent to you on your email');
            redirect('user/signup/authRedirect');
            //
        }
    }


    public function signupUser()
    {
        if (empty($this->input->post())) {
            $this->session->set_flashdata('error', '<div class="alert alert-warning alert-dismissable"><i class="fa fa-warning"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><b>Try Again!</b> You are doing something wrong.</div>');
            redirect($this->agent->referrer());
        } else {
            $this->form_validation->set_rules('aadhaar_number', 'Aadhaar Number', 'trim|min_length[14]|max_length[14]|xss_clean|strip_tags');
            $this->form_validation->set_rules('gender', 'Gender', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('employee_id', 'eHRMS Id', 'trim|xss_clean|strip_tags');
            
            if ($this->form_validation->run()) {
                $aadhaar_number = $this->input->post('aadhaar_number');
                $pass_str = rand_string(6).'@'.rand(11111, 99999);
                $password = $this->config->item('salt').sha1($pass_str);
                $password = hash("sha256", $password);
                $gender = $this->input->post('gender');

                if (!empty($this->input->post('employee_id'))) {
                    $employee_hrms = $this->input->post('employee_id');
                } else {
                    $employee_hrms = rand(11111, 99999);
                }
                $emp_id = $this->input->post('emp_id');
                $log_id = $this->input->post('log_id');
                $user_type = $this->input->post('user_type');
                $update = ['log_isdisable' => 0,'log_pass' => $password];
                $where = ['log_id' => $log_id];
                $isertdata = $this->Signup_Model->updatelogstatus($update, $where);
                if ($isertdata) {
                    $insertemp = ['hrms_id' => $employee_hrms,'status' => 'registered'];
                    $where2 = ['emp_id' => $emp_id];
                    $isertempdata = $this->Signup_Model->updateEmpdetail($insertemp, $where2);
                    if ($isertempdata) {
                        // $insertemp = ['aadhar_no' => $aadhaar_number, 'pu_gender' =>  $gender];
                        // $where3 = ['emp_id' => $emp_id];
                        if ($user_type == 'SU') {
                            $where3 = ['emp_id' => $emp_id];
                            $insertemp = ['aadhar_no' => $aadhaar_number, 'su_gender' =>  $gender];
                            $isertprimarydata = $this->Signup_Model->updatesecondarydetail($insertemp, $where3);
                        } elseif ($user_type == 'TU') {
                            $where3 = ['emp_id' => $emp_id];
                            $insertemp = ['aadhar_no' => $aadhaar_number, 'tu_gender' =>  $gender];
                            $isertprimarydata = $this->Signup_Model->updatetertiarydetail($insertemp, $where3);
                        } else {
                            $where3 = ['emp_id' => $emp_id];
                            $insertemp = ['aadhar_no' => $aadhaar_number, 'pu_gender' =>  $gender];
                            $isertprimarydata = $this->Signup_Model->updateprimarydetail($insertemp, $where3);
                        }
                        if ($isertprimarydata > 0) {
                            $idPass = $this->Signup_Model->getidPass($log_id);
                            $email = $idPass->emp_email;
                            $urise_id = $idPass->log_authid;
                            $mobile = $idPass->emp_mobile;


                            $data = array(
                            'email' => $email,
                            'username' => $urise_id,
                            'password' => $password,
                        );
                        }
                        pu_details_mail($data);
                        $this->sendUriseIdSMS($mobile, $urise_id, $password);
                        $exp_where = ['log_id' => $log_id];
                        $exptoken = base64_encode(date('Y-m-d'));
                        $exp_update = ['token' =>  $exptoken];
                        $expiretoken = $this->Signup_Model->expiretoken($exp_update, $exp_where);
                        $this->session->sess_destroy('otpsess');
                        $this->session->set_flashdata('msg_success', 'Congratulations, you have successfully registered in URISE. Your Urise Id is <b> '. $urise_id . '</b> and Password is <b> '. $password . '</b>.');
                        redirect('user/signup/authRedirect');
                    } else {
                        $this->session->sess_destroy('otpsess');
                        $this->session->set_flashdata('error', 'Something went wrong.');
                        redirect('user/signup/authRedirect');
                    }
                } else {
                    $skill = 1;
                    if ($skill = 1) {
                        $this->updateSkillemp($emp_id, $aadhaar_number, $gender, $log_id, $employee_hrms);
                    } else {
                        $this->session->set_flashdata('error', 'Error! Something went wrong.');
                        redirect('user/signup/authRedirect');
                    }
                }
            } else {
                $this->session->set_flashdata('error', validation_errors());
           
                redirect('user/signup/authRedirect');
            }
        }
    }

    public function updateSkillemp($emp_id, $aadhaar_number, $gender, $log_id, $employee_hrms)
    {
        $emp_id = $emp_id;
        $aadhaar_number = $aadhaar_number;
        $gender = $gender ;
        $log_id = $log_id;
        $count = '0';
        if ($count == 0) {
            $f = array(
    'hrms_id' => $employee_hrms,
    'status'  => 'registered',
                              );
            $this->Lib_model->Update('urtbl_skill_employee', $f, array('emp_id' => $emp_id));

            $a = array(
    'aadhar_no' => $aadhaar_number,
    'pu_gender' => $gender,
                    );
            $this->Lib_model->Update('urtbl_skillprimary_userinfo', $a, array('emp_id' => $emp_id));

            $b = array(
     'log_isdisable' => 0,
                    );
            $this->Lib_model->Update('urtbl_skill_login', $b, array('log_id' => $log_id));

            $idPass = $this->Signup_Model->getSkillidPass($log_id);
            $email = $idPass->emp_email;
            $urise_id = $idPass->log_authid;
            $mobile = $idPass->emp_mobile;

            $data = array(
        'email' => $email,
        'username' => $urise_id,
        'password' => 1234,
    );
            pu_details_mail($data);
            $this->sendUriseIdSMS($mobile, $urise_id);
            $exptoken = base64_encode(date('Y-m-d'));
            $c = array(
    'token' => $exptoken,
                   );
            $this->Lib_model->Update('urtbl_skill_login', $c, array('log_id' => $log_id));


            $this->session->set_flashdata('msg_success', 'Congratulations, you have successfully registered in URISE. Your login Id has been sent to via email and message.');
            redirect('user/signup/authRedirect');
        } else {
            $this->session->set_flashdata('error', 'Error! Something wrong.');
            redirect('user/signup/authRedirect');
        }
    }
    public function sendUriseIdSMS($mobile, $urise_id, $password)
    {
        $pass = $password;
        $msg = "Your%20registration%20with%20Id%20" . $urise_id . "%20on%20URISE%20portal%20and%20password%20is%20" . $pass . "%20.Please%20use%20these%20credentials%20for%20login.%0a%0aThanks%0aTeam%20URISE";
        $ch = curl_init($this->config->item('sms_api'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=uurise&pass=21097352&sender=UURISE&sendto=" . $mobile . "&message=" . $msg);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch); // This is the result from the API
        $con = 1;
        if (!empty($response)) {
            /* !empty($response) */
            $result['status'] = 1;
            $result['message'] = "OTP sent successfully.";
        } else {
            $result['status'] = 0;
            $result['message'] = "Invalid mobile. Please try again!!";
        }
        return json_encode($result);
    }

    public function authRedirect()
    {
        $this->load->view('user/success_msg');
    }

    public function checkaadhar()
    {
        $aadhar = $this->input->post('aadhar');
        $result = array();
        $isExist = $this->Signup_Model->getUserAadhar(array('aadhar_no' => $aadhar));
        if (!empty($isExist->emp_email)) {
            $result['status'] = 1;
            $result['message'] = "Email already exist";
        } else {
            $result['status'] = 0;
            $result['message'] = "";
        }
        exit(json_encode($result));
    }

    public function user($isEmailToken)
    {
        $this->load->model('Spm_User_Manage_Model');
        if ($isEmailToken) {
            $userDetail = $this->Spm_User_Manage_Model->getTokenDetails($isEmailToken);
            $this->load->view('spm/signup', ['userDetail' => $userDetail]);
        } else {
            echo 'Token Missing.';
            exit;
        }
    }

    public function optGen()
    {
        $email_id = $this->input->post('email_id');
        $mobilenumber = $this->input->post('mobilenumber');
        $mobiledb = $this->Signup_Model->getMobile($mobilenumber, $email_id);
        if (!empty($mobiledb)) {
            $mobile_no = $mobiledb->emp_mobile;
            $this->session->sess_destroy('otpsess');
            $generator = "1357902468";
            $result = "";
            for ($i = 1; $i <= 6; $i++) {
                $result .= substr($generator, (rand() % (strlen($generator))), 1);
            }
            $otpsess = ['otp'=> $result,'time'=>time(),'mobile_no' => $mobile_no];
            $this->session->set_userdata('otpsess', $otpsess);
            $url = "http://103.16.143.17/api/swsendnk.asp?username=uurise&pass=21097352&sender=UURISE&sendto=$mobile_no&message=Your+URISE+Secure+OTP+is+$result+and+valid+for+next+30+minutes%0aEnter+this+OTP+on+the+registration+form%0a%0aThanks%0aURISE+Team";
            $contents = file_get_contents($url);
            if ($contents !== false) {
                //Print out the contents.
                //$optCreate = $this->Signup_Model->optCreate($mobile_no, $result);
                $res['status'] = 1;
                $res['msg'] = 'success';
                $res['csrf_token'] = $this->security->get_csrf_hash();
                exit(json_encode($res));
            } else {
                $res['status'] = 2;
                $res['msg'] = 'fail';
                $res['csrf_token'] = $this->security->get_csrf_hash();
                exit(json_encode($res));
            }
        } else {
            $skill = 1;
            if ($skill == 1) {
                $this->genSkillotp($mobilenumber, $email_id) ;
            } else {
                $response['status'] = 3;
                $response['msg'] = 'fail';
                $response['csrf_token'] = $this->security->get_csrf_hash();
                exit(json_encode($response));
            }
        }
    }

    public function genSkillotp($mobile, $email_id)
    {
        $email_id = $email_id;

        $mobilenumber = $mobile;
        $mobileskill = $this->Signup_Model->getSkillMobile($mobilenumber, $email_id);
        //  prx($mobileskill);
        
        if (empty($mobileskill)) {
            $response['status'] = 0;
            $response['msg'] = 'fail';
            exit(json_encode($response));
        }
        $mobile_no = $mobileskill->emp_mobile;
        $generator = "1357902468";

        $result = "";

        for ($i = 1; $i <= 6; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        ////The URL that we want to GET.
        $url = "http://103.16.143.17/api/swsendnk.asp?username=uurise&password=21097352&sender=UURISE&sendto=$mobilenumber&message=Your+URISE+Secure+OTP+is+$result+and+valid+for+next+30+minutes%0aEnter+this+OTP+on+the+registration+form%0a%0aThanks%0aURISE+Team";
        //Use file_get_contents to GET the URL in question.
        $contents = file_get_contents($url);
        //If $contents is not a boolean FALSE value.
        if ($contents !== false) {
            //Print out the contents.
            $optCreate = $this->Signup_Model->skillOtpCreate($mobile_no, $result);
            $response['status'] = 1;
            $response['msg'] = 'success';
            console.log("1122");
            exit(json_encode($response));
        }
    }

    public function generateCsrfToken()
    {
        $data['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }

    public function optUpdate()
    {
        $mobilenumber = $this->input->post('mobilenumber');
        $email_id = $this->input->post('email_id');
        $optno = $this->input->post('optno');
        $token = $this->input->post('token');
        //$updateOtp = $this->Signup_Model->optUpdate($mobilenumber, $optno);
        
        $user_otp = $this->session->userdata('otpsess');
        if ($optno == $user_otp['otp'] && $mobilenumber == $user_otp['mobile_no']) {
            $this->session->sess_destroy('otpsess');
        
            if (!empty($token)) {
                $user_info = base64_decode($token);
                $user_info = explode('|', $user_info);
                $user_type = $user_info['2'];
            } else {
                $user_type = 'PU';
            }
            if ($user_type == 'SU' || $user_type == 'TU') {
                $where = ['ue.emp_mobile' => $mobilenumber, 'ue.emp_email' => $email_id, 'ur.role_name' => $user_type];
                $getUserexist = $this->Signup_Model->getUsersData($where);
            } else {
                $where = ['ue.emp_mobile' => $mobilenumber, 'ue.emp_email' => $email_id, 'ur.role_name' => $user_type];
                $getUserexist = $this->Signup_Model->getPUdata($where);
            }
            // prx($getUserexist);
            if (!empty($getUserexist)) {
                $result['status'] = 'success';
                $result['role_name'] = $getUserexist[0]->desig_name;
                $result['prog_name'] = $getUserexist[0]->org_name;
                $result['pu_name'] = $getUserexist[0]->firstName;
                $result['pu_email'] = $getUserexist[0]->emp_email;
                $result['pu_district'] = $getUserexist[0]->dis_name;
                $result['pu_department'] = $getUserexist[0]->dept_name;
                $result['emp_id'] = $getUserexist[0]->emp_id;
                $result['log_id'] = $getUserexist[0]->log_id;
                $result['reg_status'] = $getUserexist[0]->status;
                $log_isdisable = $getUserexist[0]->log_isdisable;
                $result['csrf_token'] = $this->security->get_csrf_hash();
            } else {
                $result['status'] = 'False';
                $result['csrf_token'] = $this->security->get_csrf_hash();
            }
        } else {
            $skill = 1;
            if ($skill == 1) {
                $this->skillotpUpdate($mobilenumber, $optno, $email_id, $token);
            //$result['status'] = 'false';
            } else {
                $result['status'] = 'false';
                $result['csrf_token'] = $this->security->get_csrf_hash();
            }
        }
        echo json_encode($result);
    }


    public function skillotpUpdate($mobilenumber, $optno, $email_id, $token)
    {
        $mobilenumber = $mobilenumber;
        $email_id = $email_id;
        $optno = $optno;
        $token = $token;
        $updateOtp = $this->Signup_Model->optSkillUpdate($mobilenumber, $optno);
       
        if ($updateOtp == true) {
            $where = ['ue.emp_mobile' => $mobilenumber, 'ue.emp_email' => $email_id];
            $getUserexist = $this->Signup_Model->getSkillPUdata($where);
            // prx ($getUserexist);
            if (!empty($getUserexist)) {
                $result['status'] = 'success';
                $result['role_name'] = $getUserexist[0]->desig_name;
                $result['prog_name'] = 'Skill Training';
                $result['pu_name'] = $getUserexist[0]->firstName;
                $result['pu_email'] = $getUserexist[0]->emp_email;
                $result['pu_district'] = $getUserexist[0]->dis_name;
                $result['pu_department'] = $getUserexist[0]->dept_name;
                $result['emp_id'] = $getUserexist[0]->emp_id;
                $result['log_id'] = $getUserexist[0]->log_id;
                $log_isdisable = $getUserexist[0]->log_isdisable;
            } else {
                $result['status'] = 'False';
            }
        } else {
            $result['status'] = 'false';
        }
        exit(json_encode($result));
    }

    public function getEmpDetails()
    {
        $emp_id =  $this->input->post('emp_id');
        $isExist = $this->Signup_Model->getEmpDetails($emp_id);
        if (!empty($isExist)) {
            echo 'success';
        } else {
            echo 'false';
        }
    }

   

    public function skill()
    {
        $token = $this->input->get('token');
        if (!empty($token)) {
            $user_info = base64_decode($token);
            $user_info = explode('|', $user_info);
            $user_type = $user_info['2'];
        } else {
            $user_type = 'PU';
        }
        $data['token'] = $token;
        $data['user_type'] = $user_type;
        if (!empty($data['token']) && $user_type == 'SU' || $user_type == 'TU') {
            $this->load->view('user/skillSignup', $data);
        } elseif (empty($data['token']) &&  $user_type == 'PU') {
            $this->load->view('user/skillSignup', $data);
        } else {
            $this->session->set_flashdata('error', 'Please use correct link to register which is sent to you on your email');
            redirect('user/signup/authRedirect');
            //
        }
    }
}
