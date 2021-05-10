
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class skillSignup extends App_Controller
{
    private $data = [];
    public function __construct()
    {
        parent::__construct();
        $this->base_url = $this->config->item('base_url');
        if ($this->base_url != $this->base_url) {
            header("Location: https://urise.up.gov.in");
        }
        ini_set('memory_limit', -1);
        $this->load->library(array('user_agent', 'emaillibrary', 'encryptlibrary', 'session', 'form_validation'));
        date_default_timezone_set('Asia/Calcutta');
        $this->load->helper(array('security', 'common', 'url', 'email_helper'));
        $this->load->model(array('Signup_Model'));
        $this->authKey = 'Alpha837503';
        $this->sellerAuthKey = 'BNiKdG2U5PTA';
    }



    public function index()
    {
        prx('ok');
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
            $this->load->view('user/SkillSignup', $data);
        } elseif (empty($data['token']) &&  $user_type == 'PU') {
            $this->load->view('user/SkillSignup', $data);
        } else {
            $this->session->set_flashdata('error', 'Please use correct link to register which is sent to you on your email');
            redirect('user/SkillSignup/authRedirect');
        }
    }


    public function signupUser()
    {
        $this->form_validation->set_rules('aadhaar_number', 'Aadhaar Number', 'trim|min_length[14]|max_length[14]');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        if ($this->form_validation->run()) {
            $aadhaar_number = $this->input->post('aadhaar_number');
            $password = '1234';
            $gender = $this->input->post('gender');

            if (!empty($this->input->post('employee_id'))) {
                $employee_hrms = $this->input->post('employee_id');
            } else {
                $employee_hrms = rand(11111, 99999);
            }
            $emp_id = $this->input->post('emp_id');
            $log_id = $this->input->post('log_id');
            $user_type = $this->input->post('user_type');
            $update = ['log_isdisable' => 0];
            $where = ['log_id' => $log_id];
            $isertdata = $this->skillSignup_Model->updatelogstatus($update, $where);
            if ($isertdata > 0) {
                $insertemp = ['hrms_id' => $employee_hrms,'status' => 'registered'];
                $where2 = ['emp_id' => $emp_id];
                $isertempdata = $this->skillSignup_Model->updateEmpdetail($insertemp, $where2);
                if ($isertempdata > 0) {
                    // $insertemp = ['aadhar_no' => $aadhaar_number, 'pu_gender' =>  $gender];
                    // $where3 = ['emp_id' => $emp_id];
                    if ($user_type == 'SU') {
                        $where3 = ['emp_id' => $emp_id];
                        $insertemp = ['aadhar_no' => $aadhaar_number, 'su_gender' =>  $gender];
                        $isertprimarydata = $this->skillSignup_Model->updatesecondarydetail($insertemp, $where3);
                    } elseif ($user_type == 'TU') {
                        $where3 = ['emp_id' => $emp_id];
                        $insertemp = ['aadhar_no' => $aadhaar_number, 'tu_gender' =>  $gender];
                        $isertprimarydata = $this->skillSignup_Model->updatetertiarydetail($insertemp, $where3);
                    } else {
                        $where3 = ['emp_id' => $emp_id];
                        $insertemp = ['aadhar_no' => $aadhaar_number, 'pu_gender' =>  $gender];
                        $isertprimarydata = $this->skillSignup_Model->updateprimarydetail($insertemp, $where3);
                    }
                    if ($isertprimarydata > 0) {
                        $idPass = $this->skillSignup_Model->getidPass($log_id);
                        $email = $idPass->emp_email;
                        $urise_id = $idPass->log_authid;

                        $data = array(
                            'email' => $email,
                            'username' => $urise_id,
                            'password' => $password,
                        );
                    }
                }
                pu_details_mail($data);
                $exp_where = ['log_id' => $log_id];
                $exptoken = base64_encode(date('Y-m-d'));
                $exp_update = ['token' =>  $exptoken];
                $expiretoken = $this->skillSignup_Model->expiretoken($exp_update, $exp_where);
                $this->session->set_flashdata('msg_success', 'Congratulations, you have successfully registered in URISE. Your login Id has been sent to via email and message.');
                redirect('user/SkillSignup/authRedirect');
            } else {
                $this->session->set_flashdata('error', 'Error! Something went wrong.');
                redirect('user/skillSignup/authRedirect');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/skillSignup/authRedirect');
        }
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
        $mobilenumber = $this->input->post('mobilenumber');
        $mobiledb = $this->skillSignup_Model->getMobile($mobilenumber);
        if (empty($mobiledb)) {
            $response['status'] = 0;
            $response['msg'] = 'fail';
            exit(json_encode($response));
        }
        $mobile_no = $mobiledb->emp_mobile;
        $generator = "1357902468";

        $result = "";

        for ($i = 1; $i <= 6; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        //The URL that we want to GET.
        $url = "http://103.16.143.17/api/swsend.asp?username=UURISE&password=21097352&sender=BE-UURISE&sendto=$mobilenumber&message=Your+URISE+Secure+OTP+is+$result+and+valid+for+next+30+minutes%0aEnter+this+OTP+on+the+registration+form%0a%0aThanks%0aURISE+Team";
        //Use file_get_contents to GET the URL in question.
        $contents = file_get_contents($url);
        //If $contents is not a boolean FALSE value.
        if ($contents !== false) {
            //Print out the contents.
            $optCreate = $this->SkillSignup->optCreate($mobile_no, $result);
            $response['status'] = 1;
            $response['msg'] = 'success';
        }
        exit(json_encode($response));
    }

    public function optUpdate()
    {
        $mobilenumber = $this->input->post('mobilenumber');
        $email_id = $this->input->post('email_id');
        $optno = $this->input->post('optno');
        $token = $this->input->post('token');
        $updateOtp = $this->Signup_Model->optUpdate($mobilenumber, $optno);
        if ($updateOtp == true) {
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
                $log_isdisable = $getUserexist[0]->log_isdisable;
                if ($log_isdisable == 0) {
                    $result['status'] = 'already_registered';
                    $result['err_msg'] = 'You have already registered in URISE.';
                }
            } else {
                $result['status'] = 'False';
            }
        } else {
            $result['status'] = 'false';
        }
        echo json_encode($result);
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

    //Verification Page 
    public function verify($token)
    {

        $check = email_token_checker($token);

        if (!empty($check)) {
            $mobilenumber = $check->mobileNumber;
            pu_verified_declined($token, 'Verified');
            $url = "http://103.16.143.17/api/swsend.asp?username=UURISE&password=21097352&sender=BE-UURISE&sendto=$mobilenumber&message=Congratulations+Your+URISE+Registration+Request+Has+Been+Approved+By+Authority%0a%0aThanks%0aURISE+Team";
            file_get_contents($url);
            $res = $this->Signup_Model->verifyUser($token);
            if ($res) {
                pu_details_mail($res);
                $this->session->set_flashdata('msg_success', 'PU Accepted Successfully!');
                redirect('user/SUlist');
            }
            echo 'Thanks for verifed the user. Email/Mobile Notification has been sent to user !';
        } else {
            echo 'Ops! Invalid Token.';
        }
    }

    //Verification Page 
    public function decline($token)
    {


        $check = email_token_checker($token);

        if (!empty($check)) {
            $mobilenumber = $check->mobileNumber;

            pu_verified_declined($token, 'Declined');
            $url = "http://103.16.143.17/api/swsend.asp?username=UURISE&password=21097352&sender=BE-UURISE&sendto=$mobilenumber&message=Your+URISE+Registration+Request+Has+Been+Declined+By+Authority%0a%0aThanks%0aURISE+Team";
            file_get_contents($url);
            $this->Signup_Model->declineUser($token);
            echo 'Thanks for declined the user. Email/Mobile Notification has been sent to user !';
        } else {
            echo 'Ops! Invalid Token.';
        }
    }
}
