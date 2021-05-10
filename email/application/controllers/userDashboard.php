<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends App_Controller
{
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
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', '0'); // for infinite time of execution
        $this->load->library(array('user_agent', 'emaillibrary','pagination', 'Ajax_pagination', 'session', 'form_validation','uploadfiles', 'PHPExcel/Classes/PHPExcel'));
        date_default_timezone_set('Asia/Calcutta');
        $this->load->helper(array('security', 'common', 'url', 'email_helper','super_admin_helper','skill_helper'));
        $this->load->model(array('dashboard_model', 'User_Profile_Model', 'Lib_model'));
        $this->authKey = 'Alpha837503';
        $this->sellerAuthKey = 'BNiKdG2U5PTA';
        $this->perPage = 9;
        $this->OPENSSL_CIPHER_NAME = "AES-128-CBC"; //Name of OpenSSL Cipher 
        $this->CIPHER_KEY_LEN = 16; //128 bits
        $OPENSSL_CIPHER_NAME=$this->OPENSSL_CIPHER_NAME;
        $CIPHER_KEY_LEN= $this->CIPHER_KEY_LEN;
        $this->base_url = $this->config->item('base_url');
        if ($this->base_url != $this->base_url) {
            header("Location: https://urise.up.gov.in");
        }
        $key=$this->session->userdata('user')['session_var'];
        $sess_data=getsessdata('user');
        if (empty($sess_data) or empty($key)) {
            redirect('user/login', 'refresh');
        }
        //        $this->ValidateUser();
    }

    public function checkPermission()
    {
        // $sess_data = getsessdata('user');
        $key=$this->session->userdata('user')['session_var'];
        $sess_data=getsessdata('user');
        if (empty($sess_data) or empty($key)) {
            redirect('user/login', 'refresh');
        }
    }

    public function ValidatePU()
    {
        $sess_data = (array) getsessdata('user');
        // prx($sess_data);
        if ($sess_data['role_id'] != 2) {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('user/login', 'refresh');
        }
    }

    public function ValidateSU()
    {
        $sess_data = (array) getsessdata('user');
        // prx($sess_data);
        if ($sess_data['role_id'] != 3) {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('user/login', 'refresh');
        }
    }

    public function index()
    {
        $this->checkPermission();
        $p[] = $t =  getsessdata('user');
        //prx($p);

        $is_skill = array_column($p, 'desig_id');

        //prx($is_skill);
        if ($is_skill[0] == '5' || $is_skill[0] == '6') {
            // prx($p);
            //$t = $t[];
            $org_id = array_column($t, 'org_id');
            $id = array_column($t, 'pu_empid');
            $role = array_column($t, 'dept_desig_rel_id');
            $log_authid = array_column($t, 'urise_id');
            $emp_id = array_column($t, 'emp_id');
            $name = array_column($t, 'emp_name');
            $email = array_column($t, 'emp_email');
            $login_time = array_column($t, 'login_time');
            $role_name = array_column($t, 'urise_pre');
            $Pu_District = array_column($t, 'dis_name');
            $Pu_dis_id = array_column($t, 'dis_id');
            $data['org_id'] = $t['org_id'];
            $data['id'] = $t['emp_id'];
            $data['role'] = $role;
            $data['log_authid'] = $log_authid;
            $data['emp_id'] = $emp_id;
            $data['name'] = $name;
            $data['email'] = $email;
            $data['login_time'] = $login_time;
            $data['role_name'] = $role_name;
            $data['Pu_District'] = $Pu_District;
            $data['Pu_dis_id'] = $t['dis_id'];
            //prx($Pu_dis_id[0]);
            $current_role = $t['desig_id'];
            $data['current_role'] = $current_role;

            if ($current_role == 5) {
                $where = $t['dis_id'];
                //prx($where);
                $org_id = $sess_data->org_id;
                $role_id = 2;
                $user_list_type = 'SU List';

                $unreglis = $this->Lib_model->getskillinstitutedata($where);
                $data['unreglis'] = ($unreglis);

                $reglis = $this->Lib_model->registerskillinstitutedata($where);
                $data['reglis'] = ($reglis);

                $uniqueregtpdata = $this->Lib_model->uniqueregtpdata($where);
                $data['uniqueregtpdata'] = ($uniqueregtpdata);

                $uniqueunregtpdata = $this->Lib_model->uniqueunregtpdata($where);
                $data['uniqueunregtpdata'] = ($uniqueunregtpdata);

                // prx(($uniqueunregtpdata));

                $allskillinst = $this->Lib_model->allskillinstitutedata();
                $data['allskillinst'] = ($allskillinst);

                $TpSkillcount = $this->Lib_model->TpSkillcount($where);
                $data['TpSkillcount'] = $TpSkillcount;
                $data['user_list_type'] = $user_list_type ;
                $data['alltpCenters'] =  $this->Lib_model->alltpCenters();
                // $tptc_reg_Count
                $data['allTc'] = $this->Lib_model->Select('urtbl_skill_training_center', '*', array('dis_id' => $where));
                $sess_data = getsessdata('user');
                // prx($where);
                $data['tc_dis'] = $sess_data['dis_id'];
            //prx($data['unreglis']);
            } elseif ($current_role == 6) {
                $t =  getsessdata('user');

                $tp = $t['tp_id'];
                //prx($t);
                $tpcenter = $data['tpInsti'] = $this->Lib_model->Select('urtbl_skill_training_center', '*', array('TP_id' => $tp));
                //prx($tpcenter);
                $user_list_type ='District Co-ordinator List' ;

                foreach ($tpcenter as $tp) {
                    $where[] = $tp->dis_id ;
                }
                if (empty($where)) {
                    $where[] = '';
                }
       
                $allDc = $this->Lib_model->allDcDetails($where);
                //prx($where);
                
                $sess_data = getsessdata('user');
                $data['where'] = $sess_data['tp_id'];
                $t =  getsessdata('user');
                $data['allDc'] = $allDc;
                $data['tpCenters'] = $tpCenters;
                $data['user_list_type'] = $user_list_type ;
            }
        } else {
            //
            // $sess_data = $this->session->userdata('user')['session_var'];
            // $sess_data = $this->session->userdata($sess_data);
            $sess_data=getsessdata('user');
            $current_role = $sess_data->role_id;
            if ($current_role == 1) {
                $org_id = $sess_data->org_id;
                $role_id = 2;
                $user_list_type = 'PU List';
                if ($sess_data->org_id == 1) {
                    $skilldata['userslist'] = $this->dashboard_model->getskillreglistpu($sess_data->org_id);
                    $skilldata['unreglist'] = $this->dashboard_model->getskillunreglistpu($sess_data->org_id);
                }
                $where = ['ul.role_id' => $role_id,'uo.org_id' => $org_id];
                $data['userslist'] = $this->dashboard_model->getPuUserslist($where);
            } elseif ($current_role == 2) {
                $org_id = $sess_data->org_id;
                $zoneid = getzoneid($sess_data->emp_id);

                $role_id = 3;
                $user_list_type = 'SU List';
                $where = ['zd.zone_id'=>$zoneid];
                $data['userslist'] = $this->dashboard_model->getUserslist($where);
                $data['unreglist'] = $this->dashboard_model->getunregUserslist($where);
            } elseif ($current_role == 3) {
                $isnt_id = $sess_data->institute_id;
                $org_id = $sess_data->org_id;
                $role_id = 4;
                $user_list_type = 'TU List';

                $where = ['ui.org_id' => $org_id, 'ui.ins_id' => $isnt_id,'ul.role_id'=>$role_id];
                $data['userslist'] = $this->dashboard_model->getUserslisttu($where);
                $data['unreglist'] = $this->dashboard_model->getunregUserslisttu($where);
            }else{
                $this->session->set_flashdata('error', 'Access Denied');
                redirect('user/login', 'refresh');
            }
            // prx($where);
            $data['user_list_type'] = $user_list_type;
            $data['current_role'] = $current_role;
            $data['user_id'] = $sess_data->id;
        }
        //prx($data['userslist']);
        $this->load->view('includes/common_header', $sess_data);
        if ($sess_data->org_id == 1) {
            $this->load->view('user/pulistskill', $skilldata);
        } else {
            $this->load->view('user/dashboard', $data);
        }
        $this->load->view('includes/common_footer');
    }

    public function userProfile()
    {
        $this->checkPermission();
        $p[] = $sess_data = getsessdata('user');
        $is_skill = array_column($p, 'desig_id');
        //PRX($org_id);
        //prx($is_skill);

        if ($is_skill[0] == '5' || $is_skill[0] == '6') {
            $data['skill_Sess'] = getsessdata('user');
            $id = $sess_data['urise_id'];

            $data['skill'] = $this->Lib_model->Select('urtbl_skill_employee', '*', array('urise_id' => $id));
            ;

            //prx($sess_data);
        }

        $current_role = $sess_data->role_id;
        $emp_id = $sess_data->emp_id;
        $where = ['ue.emp_id' => $emp_id];
        $data['user_data'] = $this->User_Profile_Model->getprofile($where, $current_role);
        //prx($data['emp_data']);
        $this->load->view('includes/common_header');
        $this->load->view('user_profile', $data);
        $this->load->view('includes/common_footer');
    }

    public function SkillTuList($where)
    {
        $this->checkPermission();
        $TP_id = base64_decode($where);
        $sess_data = getsessdata('user');
        // prx($where);
        $tc_dis = $sess_data['dis_id'];

        $data['unregtpCenters'] = $this->Lib_model->unregtpCenters($TP_id, $tc_dis);
        $data['regtpCenters'] = $this->Lib_model->regtpCenters($TP_id, $tc_dis);
        //prx($tpCenters);
        $current_role = $sess_data->role_id;
        $emp_id = $this->uri->segment(4);
        $where = ['ue.emp_id' => $emp_id];
        $data['user_data'] = $this->User_Profile_Model->getprofile($where, $current_role);
        //prx($data['emp_data']);
        $this->load->view('includes/common_header');
        $this->load->view('tulistskill', $data);
        $this->load->view('includes/common_footer');
    }


    public function skillsutuList($tc_dis)
    {
        $this->checkPermission();
        $tc_dis = base64_decode($tc_dis);
        $sess_data = getsessdata('user');
        $data['where'] = $sess_data['tp_id'];
        $where = $sess_data['tp_id'];
        //prx($tc_dis);
        $data['user_list_type'] = 'Tu List';
        $data['tc_dis'] = $tc_dis ;
       

        $data['unregtpCenters'] = $this->Lib_model->unregtpCenters($where, $tc_dis);
        $data['regtpCenters'] = $this->Lib_model->regtpCenters($where, $tc_dis);
        // prx($data['unregtpCenters']);
        $current_role = $sess_data->role_id;
        $emp_id = $this->uri->segment(4);
        $where = ['ue.emp_id' => $emp_id];
        $data['user_data'] = $this->User_Profile_Model->getprofile($where, $current_role);
        //prx($data['emp_data']);
        $this->load->view('includes/common_header');
        $this->load->view('skillsutulist', $data);
        $this->load->view('includes/common_footer');
    }




    public function pulist()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');

        $current_role = $sess_data->role_id;
        if ($current_role == 1) {
            $org_id = $sess_data->org_id;
            $role_id = 2;
            $user_list_type = 'PU List';

            $where = ['ui.org_id' => $org_id];
        } elseif ($current_role == 2) {
            $org_id = $sess_data->org_id;
            $role_id = 3;
            $user_list_type = 'SU List';
            $where = ['ui.org_id' => $org_id,'ul.role_id'=>$role_id];
        }  elseif ($current_role == 3) {
            $role_id = 4;
            $user_list_type = 'TU List';
            $where = ['ui.org_id' => $org_id, 'ui.ins_id' => $isnt_id,'ul.role_id'=>$role_id];
        }else{
            $this->session->set_flashdata('error', 'Access Denied');
                redirect('user/login', 'refresh');
        }



        $data['user_list_type'] = $user_list_type;
        $data['current_role'] = $current_role;
        $data['user_id'] = $sess_data->id;
        $data['userslist'] = $this->dashboard_model->getUserslist($where);
        $data['unreglist'] = $this->dashboard_model->getunregUserslist($where);
        //prx($data['userslist']);
        $this->load->view('includes/common_header');
        $this->load->view('user/sulist', $data);
        $this->load->view('includes/common_footer');
    }


    public function sulist($org_id='', $zone_id='')
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        //  pr($sess_data);
        $current_role = $sess_data->role_id;
        $user_list_type = 'SU List';
        $role_id = 3;

        if ($org_id=='' && $zone_id=='') {
            $org_id = $sess_data->org_id;
            $zone_id = $sess_data->zone_id;
        }

        if ($current_role == 1) {

            //$where = ['ul.role_id'=>$role_id,'uz.org_id' => $org_id,'uz.zone_id' => $zone_id];
            if ($org_id == 1) {
                $data['usersskilllist'] = $this->dashboard_model->directorskillsu($org_id);
                $data['unregskilllist'] = $this->dashboard_model->directorskillunreglsu($org_id);
            } else {
                $where = $org_id;
                $data['userslist'] = $this->dashboard_model->getsuliststud($where);
                $data['unreglist'] = $this->dashboard_model->getsuunreglist($where);
            }
        } elseif ($current_role == 2) {
            $zoneid = getzoneid($sess_data->emp_id);

            $where = ['zd.zone_id'=>$zoneid];
            //$where = ['ui.org_id' => $org_id,'ul.role_id'=>$role_id];
            $data['userslist'] = $this->dashboard_model->getSuUserslist($where);
            $data['unreglist'] = $this->dashboard_model->getunregUserslist($where);
        } else {
                $this->session->set_flashdata('error', 'Access Denied');
                redirect('user/login', 'refresh');
        }

        $data['user_list_type'] = $user_list_type;
        $data['current_role'] = $current_role;
        $data['user_id'] = $sess_data->id;

        $this->load->view('includes/common_header');
        if ($org_id == 1) {
            $this->load->view('user/directorskillsu', $data);
        } else {
            $this->load->view('user/dashboard', $data);
        }

        $this->load->view('includes/common_footer');
    }

    public function tulist($org_id = '', $isnt_id='')
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $current_role = $sess_data->role_id;
        $role_id = 4;
        $user_list_type = 'TU List';
        if ($org_id == '' && $isnt_id == '') {
            $isnt_id = $sess_data->institute_id;
            $org_id = $sess_data->org_id;
        }


        if ($current_role == 1) {

            //$where = ['ul.role_id'=>$role_id,'uz.org_id' => $org_id,'uz.zone_id' => $zone_id];
            if ($org_id == 1) {
                $data['usersskilllist'] = $this->dashboard_model->directorskilltu($org_id);
                $data['unregskilllist'] = $this->dashboard_model->directorskillunregtu($org_id);
            } else {
                $where = $org_id;
                $data['userslist'] = $this->dashboard_model->gettuliststud($where);
                $data['unreglist'] = $this->dashboard_model->gettuunreglist($where);
            }
            //$data['userslist'] = $this->dashboard_model->getprincipallist($where);
            //prx($data['userslist']);
        } elseif($current_role == 2) {
            $where = ['ui.org_id' => $org_id, 'ui.ins_id' => $isnt_id];
            $data['userslist'] = $this->dashboard_model->getUserslist($where);
        }else{
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('user/login', 'refresh');
        }
        $data['user_list_type'] = $user_list_type;
        $data['current_role'] = $current_role;
        $data['user_id'] = $sess_data->id;

        $this->load->view('includes/common_header');
        if ($org_id == 1) {
            $this->load->view('user/directorskilltu', $data);
        } else {
            $this->load->view('user/tulist', $data);
        }

        $this->load->view('includes/common_footer');
    }

    public function listsu()
    {
        $this->checkPermission();
        $zone= base64_decode($this->uri->segment(2));

        $data['userslist'] = $this->dashboard_model->getUserslistsu($zone);
        $data['unreglist'] = $this->dashboard_model->getUsersunreglistsu($zone);

        $this->load->view('includes/common_header');
        $this->load->view('user/listsu', $data);
        $this->load->view('includes/common_footer');
    }
    public function editstu()
    {
        $this->checkPermission();
        $stuid= base64_decode($this->uri->segment(4));
        // prx($stuid);
        $data['stuid'] = $stuid;
        $data['stu'] = $this->dashboard_model->getStudob($stuid);
        //prx($data['stu']);
        $this->load->view('includes/common_header');
        $this->load->view('user/editStudent', $data);
        $this->load->view('includes/common_footer');
    }

    public function updateStudent()
    {
        //prx($this->input->post());
        if (empty($this->input->post())) {
            $this->session->set_flashdata('error', 'You are doing something wrong.');
            redirect('user/dashboard/studentlist', 'refresh');
        } else {
            $this->form_validation->set_rules('dob', 'DOB', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('stu_status', 'Student status', 'required|xss_clean|strip_tags');
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors());
                $this->session->set_flashdata('postdata', $this->input->post());
                redirect('user/dashboard/studentlist', 'refresh');
            } else {
                $stuid = $this->input->post('stuid');
                $dob = $this->input->post('dob');
                $stu_status = $this->input->post('stu_status');
                $where = ['stu_id' => $stuid];
                $update = ['status' => $stu_status,'stu_dob' => date('Y-m-d', strtotime($dob))];
               //prx($update);
                $update_id = $this->dashboard_model->updateStudent($where, $update);
                //prx($update_id);
                if ($update_id) {
                    $this->session->set_flashdata('success', 'Updated Successfully');
                    redirect('user/dashboard/studentlist', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Unable to update details');
                    redirect('user/dashboard/studentlist', 'refresh');
                }
            }
        }
    }
    public function skilllistsu()
    {
        $this->checkPermission();
        $tpid= base64_decode($this->uri->segment(2));

        $data['userslist'] = $this->dashboard_model->skilllistsu($tpid);
        $data['unreglist'] = $this->dashboard_model->skillunreglistsu($tpid);
        prx($data['unreglist']);
        $this->load->view('includes/common_header');
        $this->load->view('user/skilllistsu', $data);
        $this->load->view('includes/common_footer');
    }
    public function listtu()
    {
        $this->checkPermission();
        $id= base64_decode($this->uri->segment(2));
        $orgid= base64_decode($this->uri->segment(3));
        $inscode= insidByEmpid($id);

        $data['userslist'] = $this->dashboard_model->getUsersreglisttu($inscode, $orgid);
        $data['unreglist'] = $this->dashboard_model->getUsersunreglisttu($inscode, $orgid);

        $this->load->view('includes/common_header');
        $this->load->view('user/listtu', $data);
        $this->load->view('includes/common_footer');
    }
    public function tulistskill()
    {
        $this->checkPermission();
        $tcid= base64_decode($this->uri->segment(2));

        $data['userslist'] = $this->dashboard_model->skilllisttu($tcid);
        $data['unreglist'] = $this->dashboard_model->skillunreglisttu($tcid);

        $this->load->view('includes/common_header');
        $this->load->view('user/skilltulistdetails', $data);
        $this->load->view('includes/common_footer');
    }

    public function studentlist($org_id = '', $isnt_id = '', $zone_dis_id = '')
    {
        $this->checkPermission();
        $this->ValidateSU();
        $sess_data = getsessdata('user');
        $current_role = $sess_data->role_id;
        $logged_user_id = $sess_data->id;

        $id= base64_decode($this->uri->segment(2));
        $orgid= base64_decode($this->uri->segment(3));
        $inscode= insidByEmpid($id);
        if (!empty($orgid) && !empty($inscode)) {
            $isnt_id = $inscode;
            $org_id = $orgid;
        }

        if ($org_id == '' && $isnt_id == '') {
            $isnt_id = $sess_data->institute_id;
            $org_id = $sess_data->org_id;
        }
        $where = ['ui.org_id' => $org_id, 'ui.ins_id' => $isnt_id];



        //prx($where);

        $user_list_type = 'Student List';
        //prx($where);

        $data['user_list_type'] = $user_list_type;
        $data['current_role'] = $current_role;
        $data['userslist'] = $this->dashboard_model->getstuUserslist($where);
        $data['unreglist'] = $this->dashboard_model->getstuUsersunreg($where);
        //prx($data['userslist']);
        $this->load->view('includes/common_header');
        $this->load->view('user/stulist', $data);
        $this->load->view('includes/common_footer');
    }
    public function uploadedvideo()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $current_role = $sess_data->role_id;
        $org_id = $sess_data->org_id;

        $data['dataView'] = $this->dashboard_model->getvideolec($org_id);
        //prx($data['userslist']);
        $this->load->view('includes/common_header');
        $this->load->view('user/uploadedvideo', $data);
        $this->load->view('includes/common_footer');
    }
    public function uploadedcont()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        //prx($sess_data);
        $current_role = $sess_data->role_id;
        if( $current_role == 3){
            $org_id = $sess_data->org_id;
            $insid = $sess_data->institute_id;
            $data['dataView'] = $this->dashboard_model->getvideoleccont($insid);
            $data['approved'] = $this->dashboard_model->getvideoleccontapprove($insid);
            $data['reject'] = $this->dashboard_model->getvideoleccontreject($insid);
        }else{
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('user/login', 'refresh');
        }
       
        //prx($data['userslist']);
        $this->load->view('includes/common_header');
        $this->load->view('user/facultyvideoapprove', $data);
        $this->load->view('includes/common_footer');
    }

    public function approve_faculty_video()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        if (empty($this->input->post())) {
            $this->session->set_flashdata('error', 'You are doing something wrong.');
            redirect('user/dashboard/uploadedcont', 'refresh');
        } else {
            $this->form_validation->set_rules('status', 'Status', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('videoid', 'Videoid', 'required|xss_clean|strip_tags');
            $this->form_validation->set_rules('comment', 'Comment', 'xss_clean|strip_tags');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('error', validation_errors());
                $this->session->set_flashdata('postdata', $this->input->post());
                redirect('user/dashboard/uploadedcont', 'refresh');
            } else {
                $statusValue = $this->input->post('status');
                $statusArray = explode('_', $statusValue);
                $status=$statusArray[0];
                $videoid = $this->input->post('videoid');
                $approvedfile = $this->input->post('approvedfile');
                $comment = $this->input->post('comment');
                $approvedby = $sess_data->emp_id;
                $tt = time();
                $this->load->library('upload');
                $new_name = $tt . $_FILES["approvedfile"]['name'];
                $config['upload_path'] = 'excel_upload/uploads/Circulars';
                $config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPG|pjpeg|pdf|doc|docx|ppt|pptx|txt';
                $config['max_size'] = 2000000;
                $config['file_name'] = $new_name;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('approvedfile')) {
                    $upload_data = $this->upload->data();
                    $approvedfile_name = $upload_data['file_name'];
                } else {
                    //print_r($this->upload->display_errors());
          //  $this->session->set_flashdata('error', $this->upload->display_errors());
                }
                if (!empty($comment)) {
                    $update=[
        'approved_by'=>$sess_data->emp_id,
        'approved_date'=>date('Y-m-d H:i:s', time()),
        'status'=>$status,
        'byrejected_comment'=>$comment
    ];
                } else {
                    $update=[
        'approved_by'=>$sess_data->emp_id,
        'approved_date'=>date('Y-m-d H:i:s', time()),
        'status'=>$status,
        'approval_file'=>$approvedfile_name
    ];
                }
                $dates = $this->dashboard_model->getvideoapprove($update, $videoid);
               
                if ($dates) {
                    if(empty($comment)){
                        if($sess_data->org_id == 3){
                            $emails = $this->dashboard_model->auditoremaildetails(12);
                        }elseif($sess_data->org_id == 2){
                            $emails = $this->dashboard_model->auditoremaildetails(13);
                        }else{
                            $emails = $this->dashboard_model->auditoremaildetails(14);
                        }
                        foreach($emails as $email){
                            $vefyEmail=[
                                'faculty'=>$dates[0]->emp_name,
                                'title'=>$dates[0]->topic_title,
                                'videourl'=>$dates[0]->youtube_url,
                                'subject'=>$dates[0]->subject_name,
                                'email'=>$email,
                               
                       ];
                       facultyverifyVideo($vefyEmail);
                        } 
                    
              
            }
                    $this->session->set_flashdata('msg', '<div class="alert alert-info"><b>Success ! </b> Updated successfully!</div>');
                    redirect('user/dashboard/uploadedcont', 'refresh');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger">Something Went Wrong!</div>');
                    redirect('user/dashboard/uploadedcont', 'refresh');
                }
            }
        }
    }
    public function courses()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $current_role = $sess_data->role_id;
        $org_id = $sess_data->org_id;
       
        if( $current_role == 1){
        $data['dataView'] = $this->dashboard_model->getcourses($org_id);
        }else{
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('user/login', 'refresh');
        }
        //prx($data['dataView']);
        $this->load->view('includes/common_header');
        $this->load->view('user/courses', $data);
        $this->load->view('includes/common_footer');
    }
    public function uploadPu()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadPu');
        $this->load->view('includes/common_footer');
    }
    public function uploadPuDataExcel()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        //$current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 1;
            $relation_pair = 'ins-su';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);


                    if (empty($data[9])) {
                        $data[9] =  $this->dashboard_model->generateUriseId('AD');
                    }
                    $inst_tbl_urise = [
                            'urise_pre' => 'SU',
                            'urise_id' => $data[9],
                            'mapped_with' => $org_id
                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_urise';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    if ($isInst > 0) {
                        if (empty($data[10])) {
                            $data[10] = md5($this->config->item('salt').$pass);
                        }
                        $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $data[9],
                                'log_pass' => $data[10],
                                'log_isdisable' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $sess_data['id'],
                                'status' => 'NA',
                            ];
                        //prx($inst_tbl_login);
                        $tbl_name = 'urtbl_skill_login';
                        $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                    }
                    if ($isInstLogin > 0) {
                        if (isset($data[12]) && $data[12] != '') {
                            $hrms_id =  $data[12];
                        } else {
                            $hrms_id =  000000;
                        }

                        $inst_tbl_emp = [
                                'log_id' => $isInstLogin,
                                'urise_id' => $data[9],
                                'emp_name' => $data[0],
                                'dept_desig_rel_id' => $desig_id,
                                'emp_email' => $data[1],
                                'emp_mobile' => $data[4],
                                'hrms_id' => $hrms_id,
                                'created_by' => $sess_data['id'],
                                'status' => 0,
                                'ad_isactive' => 1
                            ];
                    }

                    //prx($inst_tbl_emp );
                    $tbl_name = 'urtbl_skill_employee';
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_emp);


                    if ($role_id == 2) {
                        $tbl_name = 'urtbl_primary_userinfo';
                    }

                    if ($role_id == 3) {
                        $tbl_name = 'urtbl_secondary_userinfo';
                    }
                    if ($role_id == 4) {
                        $tbl_name = 'urtbl_tertiary_userinfo';
                    }


                    $urtrel_meta_inst = [
                            'urise_id' => $data[9],
                            'emp_id' => $isInstEmp,
                        ];


                    $meta_ist = $this->dashboard_model->insertData($tbl_name, $urtrel_meta_inst);

                    $instId = $this->dashboard_model->getInstId($data[11], $org_id);
                    if ($isInstEmp > 0) {
                        $inst_tbl_meta = [
                                'inst_id' => $instId,
                                'meta_id' => $isInstEmp,
                                'meta_value' => '',
                                'relation_pair' => $relation_pair,

                            ];
                    }

                    $tbl_name = 'urtrel_meta_inst';
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);


                    $data['count'] = $c++;
                }

                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploPu');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadAdmin');
            }
        }
    }


    public function inviteSkillUsers()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');

        $id = $this->uri->segment(4);

        $emp_id = base64_decode($id);
        $emp_data =  $this->Lib_model->getEmpdata($emp_id);
        $parent_id = $sess_data['emp_id'];
        $user_type = $emp_data->role_name;
        $date = date('Y-m-d H:i:s');
        $invite_token = base64_encode($date . '|' . $parent_id . '|' . $user_type);
        $update = ['token' => $invite_token];
        $log_id = $emp_data->log_id;
        $receiverMail = $emp_data->emp_email;
        $senderMail = $sess_data['emp_email'];
        $mobile = $emp_data->emp_mobile;
        $update = ['token' => $invite_token];
        $updatetoken = $this->Lib_model->updateInviteToken($log_id, $update);
        if ($updatetoken > 0) {
            $updateStatus = ['status' => 'invited'];
            $updatestatus = $this->Lib_model->updatebtnStatus($log_id, $updateStatus);
            invitation_mail_ts($receiverMail, $senderMail, $invite_token, $mobile, $user_type);
            $url = base_url() . 'user/signup/?token=' . $invite_token;
            $this->skillSendSMS($mobile, $url);
            $result['status'] = 1;
            $result['msg'] = 'Invitation sent successfully.';
            $result['token'] = $url;
        } else {
            $result['status'] = 0;
            $result['msg'] = 'Invitation sent failed.';
        }

        echo json_encode($result);
    }

    public function skillSendSMS($mobile, $url)
    {
        $this->checkPermission();
        $msg = "Dear%20Sir/Madam,%0aYou%20are%20invited%20to%20be%20a%20part%20of%20URISE%20as%20%20admin.%0aPlease%20click%20on%20below%20link%20to%20complete%20the%20registration%20process:%0a%0a" . $url . ".%0a%0aThanks%0aTeam%20URISE";
        $ch = curl_init($this->config->item('sms_api'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=uurise&password=21097352&sender=BE-UURISE&sendto=" . $mobile . "&message=" . $msg);
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

    public function uploadSkillPu()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillPu');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillsuMaster()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);
                    if (empty($data[9])) {
                        $data[9] =  $this->dashboard_model->generateUriseId('TP');
                        //prx($data[9]);
                    }

                    $inst_tbl_urise = [

                            'TP_code' => $data[2],
                            'TP_type' => $data[4],
                            'TP_name' => $data[3],
                            'TP_address' => $data[0],
                            'TP_contact ' => $data[6],
                            'TP_email ' => $data[7],
                            'status ' => 'not-invited',

                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_skill_TPmaster';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';

                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];

                    //prx($inst_tbl_meta);
                    $data['count'] = $c++;
                }

                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/pu');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/upload');
            }
        }
    }


    public function uploadSkillPuDataExcel()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 2;
            $desig_id = 5;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A3:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $inst = [];
                foreach ($readData as $data) {
                    prx($data);


                    if (empty($data[9])) {
                        $data[9] =  $this->dashboard_model->generateUriseId('AD');
                        //prx($data[9]);
                    }
                    $inst_tbl_urise = [
                            'urise_pre' => 'DC',
                            'urise_id' => $data[9],
                            'mapped_with' => $org_id
                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_urise';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    //prx($isInst);
                    if ($isInst > 0) {
                        if (empty($data[10])) {
                            $data[10] = md5($this->config->item('salt').$pass);
                        }
                        $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $data[9],
                                'log_pass' => $data[10],
                                'log_isdisable' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => 4,
                                'status' => 'NA',
                            ];
                        //prx($inst_tbl_login);
                        $tbl_name = 'urtbl_skill_login';
                        $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                    }
                    if ($isInstLogin > 0) {
                        if (isset($data[12]) && $data[12] != '') {
                            $hrms_id =  $data[12];
                        } else {
                            $hrms_id =  000000;
                        }
                        $inst_tbl_emp = [
                                'log_id' => $isInstLogin,
                                'urise_id' => $data[9],
                                'emp_name' => $data[3],
                                'dept_desig_rel_id' => $desig_id,
                                'emp_email' => $data[6],
                                'emp_mobile' => $data[5],
                                'hrms_id' => $data[7],
                                'created_by' => 4,
                                'status' => 'not-invited',
                                'ad_isactive' => 1
                            ];
                    }
                    //prx($inst_tbl_emp );
                    $tbl_name = 'urtbl_skill_employee';
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_emp);
                    //prx($isInstEmp);
                    $urtrel_primary = [
                            'urise_id' => $data[9],
                            'emp_id' => $isInstEmp,
                        ];
                    $isInst = $this->Lib_model->Insert('urtbl_skillprimary_userinfo', $urtrel_primary);

                    $dis_Code =	$data[2];

                    $t = $this->Lib_model->Select('urtbl_skill_district', '*', array('dis_code' => $dis_Code));
                    //prx($t);
                    $dis_ok = array_column($t, 'dis_id');
                    //prx($Tp_id[0]);
                    $disid = $dis_ok[0];
                    //prx($Tp_id);


                    if ($isInstEmp > 0) {
                        $inst_tbl_meta = [
                                'pu_empid' => $isInstEmp,
                                //'TP_meta' => $Tp_id,
                                'district_meta_id' => $disid,
                                ];
                    }


                    $tbl_name = 'ur_skillpu_meta';
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);
                    //prx($inst_tbl_meta);
                    $data['count'] = $c++;
                }

                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadSkillPu');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillPu');
            }
        }
    }



    public function uploadSkillSu()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillSu');
        $this->load->view('includes/common_footer');
    }


    public function uploadSkillSuDataExcel()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $created_by = $this->input->post('created_by');
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $s = 1;
                $r = 1;
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);
                    $tpcode = $data[0];
                    $tpid = $this->Lib_model->Select('urtbl_skill_TPmaster', '*', array('TP_code' => $tpcode));

                    $tp = array_column($tpid, 'TP_code');
                                           
                    $tp_exist = $tp[0];

                    $tpemail = $data[3];
                    $tpemail = $this->Lib_model->Select('urtbl_skill_employee', '*', array('emp_email' => $tpemail));

                    $tpemai = array_column($tpemail, 'emp_email');
                                           
                    $email_exist = $tpemai[0];
                    //prx($tp_exist);

                    if ((!empty($tp_exist)) OR (!empty($email_exist))) {
                        if (!empty($tp_exist)) {
                            $reason = 'TP exist';
                        }
                        if (!empty($email_exist)) {
                            $reason = 'Email exist';
                        }

            $tp_dump = ['email' => $email_exist,'tp_code' => $tp_exist,'reason' => $reason,'meta ' => $created_by];
            $this->Lib_model->Insert('Skill_tp_dump', $tp_dump);
            $reject = $r++;

                    }

                    if (empty($data[9])) {
                        $data[9] =  $this->dashboard_model->generateUriseId('AD');
                        //prx($data[9]);
                    }
                    if ((empty($tp_exist)) && (empty($email_exist))) {



                        $inst_master = [
                            'TP_code' => $data[0],
                            'TP_type' => $data[5],
                            'TP_name' => $data[4],
                            'TP_address' => 'Not-Available',
                            'TP_contact ' => $data[2],
                            'TP_email ' => $data[3],
                            'status ' => 'not-invited',
                            

                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_skill_TPmaster';
                    $TpMasterID = $this->dashboard_model->insertData($tbl_name, $inst_master);

                    $inst_tbl_urise = [
                            'urise_pre' => 'TP',
                            'urise_id' => $data[9],
                            'mapped_with' => $org_id
                        ];
                    $tbl_name = 'urtbl_urise';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    //$isInst = 5 ;
                    $pass = 'dacd15e246806c77ed637749bda721430a0cc94b8124dee85743f931510d3e91';
                    // $pass = substr($pass, 5, -5);
                    // $password = $this->config->item('salt').$pass;
                    // $pass = hash("sha256", $pass);
                       if ($isInst > 0) {
                        if (empty($data[10])) {
                            $data[10] = md5($this->config->item('salt').$pass);
                        }
                        $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $data[9],
                                'log_pass' =>  $pass,
                                'log_isdisable' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => 4,
                                'status' => 'NA',
                            ];
                            //prx($data);
                        $tbl_name = 'urtbl_skill_login';
                        $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                    }
                    if ($isInstLogin > 0) {
                        if (isset($data[12]) && $data[12] != '') {
                            $hrms_id =  $data[12];
                        } else {
                            $hrms_id =  000000;
                        }
                        $inst_tbl_emp = [
                                'log_id' => $isInstLogin,
                                'urise_id' => $data[9],
                                'emp_name' => $data[1],
                                'dept_desig_rel_id' => $desig_id,
                                'emp_email' => $data[3],
                                'emp_mobile' => $data[2],
                                'hrms_id' => $hrms_id,
                                'created_by' => 4,
                                'status' => 'not-invited',
                                'ad_isactive' => 1
                            ];
                    }
                    $tbl_name = 'urtbl_skill_employee';
                    //prx($inst_tbl_emp);
                    $isInstEmp = $this->Lib_model->Insert('urtbl_skill_employee', $inst_tbl_emp);
                    //prx($isInstEmp);
                    $urtrel_meta_inst = [
                            'urise_id' => $data[9],
                            'emp_id' => $isInstEmp,
                            'relg_id' => 6,
                        ];

                        
                    //$meta_ist = $this->Lib_model->Insert('urtbl_skill_secondary_userinfo', $urtrel_meta_inst);
                    $tbl_name = 'urtbl_skill_secondary_userinfo';
                    //prx($meta_ist);
                    $meta_ist = $this->Lib_model->Insert('urtbl_skill_secondary_userinfo', $urtrel_meta_inst);
                   //prx($meta_ist);
                    
                   // $instId = $this->dashboard_model->getInstId($data[11], $org_id);

                    $TpCode =	$data[0];
                   
                    $t = $this->Lib_model->Select('urtbl_skill_TPmaster', '*', array('TP_code' => $TpCode));
                    //prx($t);
                    $Tp_ok = array_column($t, 'TP_Id');
                    //prx($Tp_id[0]);
                    $Tp_id = $Tp_ok[0];
                    //prx($Tp_id);

                        
                    if ($isInstEmp > 0) {
                        $inst_tbl_meta = [
                                'TP_emp_id' => $isInstEmp,
                                'TP_meta' => $Tp_id,
                            ];
                    }
                    //prx($inst_tbl_meta);
                    $tbl_name = 'urtbl_skill_TPmeta';
                  // prx($inst_tbl_meta);
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);
                    $uploaded = $s++;
                }
                    //prx($inst_tbl_meta);
                    $data['count'] = $c++;
                }

         $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
              redirect('user/dashboard/uploadSkillSu');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillSu');
            }
        }
    }


    public function uploadSkillnonPmkvyCourse()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillCourse');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillCourseExcel()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 4;
            $desig_id = 7;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $inst = [];
                foreach ($readData as $data) {
                    //  prx($data);


                    if (empty($data[15])) {
                        $data[15] =  $this->dashboard_model->generateUriseId('AD');
                        //prx($data[9]);
                    }

                    $sector =	$data[1];

                    $rs = $this->Lib_model->Select('urtbl_sector', 'sector_id', array('nopmkvy'=>  $sector));
                    $r = json_decode(json_encode($rs[0]), true);
                    // prx($r['sector_id']) ;
                    $sc = $r['sector_id'] ;
                    $inst_tbl = [
                                            'course_code' =>$data[3],
                                            'course_name' => $data[4],
                                            'org_id' => 1,
                                            'course_category' => 'Mixed',
                                            'duration_type' => 'hourly',//$data[5],
                                            'duration' => $data[6],
                                            'sector_id' => $sc
                                                                                      
                                        ];
                    $tbl_name = 'urtbl_course_master';
                    $is = $this->dashboard_model->insertData($tbl_name, $inst_tbl);
                    $data['count'] = $c++;
                    //prx($inst_tbl);
                }

                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadSkillnonPmkvyCourse');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillnonPmkvyCourse');
            }
        }
    }

    


    public function uploadSkillTu()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillTu');
        
        $this->load->view('includes/common_footer');
    }
    public function uploadSkillTuExcel()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 4;
            $desig_id = 7;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $s = 1;
                $r = 1 ;
                $inst = [];
                $created_by = $this->input->post('created_by');

                foreach ($readData as $data) {
                     //prx($created_by);


                    if (empty($data[15])) {
                        $data[15] =  $this->dashboard_model->generateUriseId('AD');
                        //prx($data[9]);
                    }



                    $email_exitst = $data[8]; 
                    $tpid = $this->Lib_model->Select('urtbl_skill_employee', '*', array('emp_email' => $email_exitst));

                    $emailtp = array_column($tpid, 'emp_email');                    
                  
                    $mail_exist = $emailtp[0];

                    ###########################

                    $tpcode = $data[3];
                    $tpid = $this->Lib_model->Select('urtbl_skill_TPmaster', '*', array('TP_code' => $tpcode));

                    $tp = array_column($tpid, 'TP_Id');

                    $tname = array_column($tpid, 'TP_name');
                  
                    $tid = $tp[0];
                    $name = $tname[0];

                    ###############################

                    $dis_Code =	$data[2];

                    $td = $this->Lib_model->Select('urtbl_skill_district', '*', array('dis_code' => $dis_Code));

                    $dis_ok = array_column($td, 'dis_id');
                  //  prx($dis_ok[0]);
                    $disid = $dis_ok[0];

                    #################################

                    $tccode = $data[4];
                    $tcid = $this->Lib_model->Select('urtbl_skill_training_center', '*', array('tc_code' => $tccode));

                    $tc = array_column($tcid, 'tc_id');
                    $tc_id = $tc[0];

                    ########################################


                    if((!empty($mail_exist)) OR (empty($tid)) OR (empty($disid)) OR (!empty($tc_id))){
                       
                    if(!empty($mail_exist)){ 
                        $reason =  'duplicate email' ; 
                    }    
                      if(empty($tid)){ 
                        $reason =  'TP  not found' ;
                      }
                    if(empty($disid)){  
                        $reason =  'District  not found' ; 
                    }               
                    if (!empty($tc_id)){
                        $reason =  'Tc  Exist' ;
                    }
                    $avail_mail = ['email_exist' => $mail_exist,'tc_code' => $data[4],'reason' => $reason , 'meta' =>$created_by ];                        
                    $isInstEmp = $this->Lib_model->Insert('Skill_tc_dump', $avail_mail);
                    $reject = $r++;
                    //prx($data) ;                  
                }

                
               // $x = $mail_exist . '/' . $tid . '/'. $disid . '/'. $tc_id ; prx($x);
                if((empty($mail_exist)) && (!empty($tid)) && (!empty($disid)) && (empty($tc_id))){
                    //prx($created_by); 
                    
                        $inst_tbl_uris =  array(
                            'tcmanager_name' => $data[6],
                            'tc_name' => $name,
                            'tcmanager_email' => $data[8],
                            'contact_no' => $data[7],
                            'tc_address' => $data[5],

                                'tc_code' => $data[4],
                                'dis_id' => $disid,
                                'mapped_with' => 1 ,
                                'TP_id' => $tid ,
                                'created_by' => $created_by,

                            );
                            

                        $tbl_name = 'urtbl_skill_training_center';
                        $tc_id = $this->dashboard_model->insertData($tbl_name, $inst_tbl_uris);
                    /*
                        // $isIns = $this->dashboard_model->insertData($tbl_name, $inst_tbl_uris);
                        // $this->lib_model->Delete('m_productsubcategory', array('pid' => $Pid));
                        $this->Lib_model->Update('urtbl_skill_training_center', $i, array('tc_id' => $tc_id));
                        // prx($name);
                    }*/
                                       
                    $pass = '1234';

                    $inst_tbl_urise = [
                            'urise_pre' => 'TC',
                            'urise_id' => $data[15],
                            'mapped_with' => $org_id
                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_urise';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    //prx($isInst);
                    if ($isInst > 0) {
                        if (empty($data[10])) {
                            $data[16] = md5($this->config->item('salt').$pass);
                        }
                        $inst_tbl_login = [
                                                'role_id' => $role_id,
                                                'log_authid' => $data[15],
                                                'log_pass' => 'dacd15e246806c77ed637749bda721430a0cc94b8124dee85743f931510d3e91',
                                                'log_isdisable' => 1,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'created_by' => $created_by,
                                                'status' => 'NA',
                                            ];
                        //prx($inst_tbl_login);
                        $tbl_name = 'urtbl_skill_login';
                        $Tclogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                    }//prx($isInstLogin);
                    if ($Tclogin > 0) {
                        if (isset($data[12]) && $data[12] != '') {
                            $hrms_id =  $data[12];
                        } else {
                            $hrms_id =  000000;
                        }
                        $inst_tbl_emp = [
                                                'log_id' => $Tclogin,
                                                'urise_id' => $data[15],
                                                'emp_name' => $data[6],
                                                'dept_desig_rel_id' => $desig_id,
                                                'emp_email' => $data[8],
                                                'emp_mobile' => $data[7],
                                                'hrms_id' => $hrms_id,
                                                'created_by' => $created_by,
                                                'status' => 'not-invited',
                                                'ad_isactive' => 1
                                            ];
                    }
                    $tbl_name = 'urtbl_skill_employee';
                    //prx($data);
                    $TcEmp = $this->Lib_model->Insert('urtbl_skill_employee', $inst_tbl_emp);
                  //prx($TcEmp);

                    if ($TcEmp > 0) {
                        $inst_tbl_meta = [      'tc_emp_id' => $TcEmp,
                                                'tc_with_tp_id' => $tc_id,
                                                'tp_meta_value' => $created_by,
                                            ];
                    }
                    $tbl_name = 'urrel_skill_tc_meta';
                    $isInstEmppl= $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);
                    
                    $inst_tbl = [           'emp_id' => $TcEmp,
                                            'urise_id' => $data[15],
                                            'created_by' => $created_by,
                                           ];
                    $tbl_name = 'urtbl_skill_tertiary_userinfo';
                    $is = $this->dashboard_model->insertData($tbl_name, $inst_tbl); 
                    $innnn = [          
                                     'emp_id' => $TcEmp,
                                     'urise_id' => $data[15],
                                     'created_by' => $created_by,
                                                        ];
                     $tbl_name = 'urtbl_skill_employee_residance';
                     $upload = $this->dashboard_model->insertData($tbl_name, $inst_tbl);
                    $uploaded = $s++ ; 
                                    }                                     
                  //  prx($tc_id);
                                     
                }
               
                $data['count'] = $c++;

                $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
                redirect('user/dashboard/uploadSkillTu');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillTu');
            }
        }
    }
    
    public function uploadSkillTuExcel22()
    //for tp master
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);


                    if (empty($data[9])) {
                        $data[9] =  $this->dashboard_model->generateUriseId('TP');
                        //prx($data[9]);

                        $dis = $data[1];
                        $rs = $this->Lib_model->Select('urtbl_skill_TPmaster', 'TP_Id', array('dis_id' => $dis));
                        //prx($data[1]);
                    }
                    $inst_tbl_urise = [

                            'dis_id' => $rs,
                            'dis_id' => $data[1],
                            'TP_code' => $data[2],
                            'TP_type' => $data[4],
                            'TP_name ' => $data[3],
                            'TP_isactive' => '1',
                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_skill_training_center';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    //prx($isInst);

                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];

                    //prx($inst_tbl_meta);
                    $data['count'] = $c++;
                }

                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/Su');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadAdmin');
            }
        }
    }


    public function uploadSkillInst()
    {
        $this->checkPermission();

        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());


        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillSInst');
        $this->load->view('includes/common_footer');
    }



    public function uploadSkillInstSuDataExcel()
    {
        $this->checkPermission();
        $log_array=[]; //for tpcode Data Not
        $sess_data = (array) getsessdata('user');
        //$current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 4;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData[0][0]);
                $c = 0;
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data[4]);
                    $tpp = $data[0];
                    $dis = $data[4];


                    $rs = $this->Lib_model->Select('urtbl_skill_tpmaster', '*', array('TP_code' => $tpp));

                    //prx($rs[0]->TP_Id);
                    $Tppp_id = $rs[0]->TP_Id;

                    //prx($rs[0]->TP_Id);
                    $Tppp_id = $rs[0]->TP_Id;

                    if ($Tppp_id == 0) {
                        $log_array[]="'$data[0]'/'$data[2]'/'$data[5]'/'$data[6]'/'$data[7]'/'$data[3]'/'$data[4]'/'$data[8]'/'$data[9]'/'$data[10]' "; //for tpcode Data Not
                    }
                    if ($Tppp_id > 0) {
                        $sql  = "SELECT * FROM urtbl_skill_district WHERE dis_name LIKE '%$dis%' " ;

                        $dis = $this->Lib_model->Execute($sql, array())->result();
                        //prx($dis[0]->dis_id);
                        $dis = $dis[0]->dis_id;

                        //prx($data[0]);
                        if ($dis > 0) {
                            $inst_tbl_urise = [
                            'tc_code' => $data[1],
                            'tc_name' => $data[2],
                            'tcmanager_name' => $data[5],
                            'tcmanager_email' => $data[7],
                            'contact_no' => $data[6],
                            'tc_address' => $data[3],
                            'dis_id' => $dis,
                            'TP_id' => $Tppp_id,

                        ];
                            //prx($inst_tbl_urise);
                            // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                            $tbl_name = 'urtbl_skill_training_center';
                            $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                        }
                    }

                    $data['count'] = $c++;
                }
                prx($log_array);
                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadSkillInst');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillInst');
            }
        }
    }







    public function uploadAdmin()
    {
        $this->checkPermission();
        $this->load->view('includes/common_header');
        $this->load->view('upload-admin-exel');
        $this->load->view('includes/common_footer');
    }

    public function uploadAdminDataExcel()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];

        $role_id = 3;
        $desig_id = 3;
        $relation_pair = 'ins-su';
        // $relation_pair = 'ins-tu';
        $org_id = 3;


        $file = $_FILES['excel_file'];
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'captcha_images/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'captcha_images/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);


                    if (empty($data[9])) {
                        $data[9] =  $this->dashboard_model->generateUriseId('AD');
                    }
                    $inst_tbl_urise = [
                            'urise_pre' => 'SU',
                            'urise_id' => $data[9],
                            'mapped_with' => $org_id
                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_urise';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $password = 'dacd15e246806c77ed637749bda721430a0cc94b8124dee85743f931510d3e91';
                    
                    if ($isInst > 0) {
                        if (empty($data[10])) {
                            $data[10] = $password;
                        }
                        $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $data[9],
                                'log_pass' => $data[10],
                                'log_isdisable' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $sess_data['id'],
                                'status' => 'NA',
                            ];

                        $tbl_name = 'urtbl_login';
                        $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                    }
                    if ($isInstLogin > 0) {
                        if (isset($data[12]) && $data[12] != '') {
                            $hrms_id =  $data[12];
                        } else {
                            $hrms_id =  000000;
                        }

                        $inst_tbl_emp = [
                                'log_id' => $isInstLogin,
                                'urise_id' => $data[9],
                                'emp_name' => $data[0],
                                'dept_desig_rel_id' => $desig_id,
                                'emp_email' => trim($data[1]),
                                'emp_mobile' => trim($data[4]),
                                'hrms_id' => $hrms_id,
                                'created_by' => $sess_data['id'],
                                'status' => 'not-invited',
                                'ad_isactive' => 1
                            ];
                    }
                    $tbl_name = 'urtbl_employee';
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_emp);


                    // if ($role_id == 2) {
                    // 	$tbl_name = 'urtbl_primary_userinfo';
                    // }

                    // if ($role_id == 3) {
                    // 	$tbl_name = 'urtbl_secondary_userinfo';
                    // }
                    // if ($role_id == 4) {
                    // 	$tbl_name = 'urtbl_tertiary_userinfo';
                    // }

                    $tbl_name = 'urtbl_secondary_userinfo';
                    $urtrel_meta_inst = [
                            'urise_id' => $data[9],
                            'emp_id' => $isInstEmp,
                        ];


                    $meta_ist = $this->dashboard_model->insertData($tbl_name, $urtrel_meta_inst);

                    $instId = $this->dashboard_model->getInstId($data[11], $org_id);
                    if ($isInstEmp > 0) {
                        $inst_tbl_meta = [
                                'inst_id' => $instId,
                                'meta_id' => $isInstEmp,
                                'meta_value' => '',
                                'relation_pair' => $relation_pair,

                            ];
                    }

                    $tbl_name = 'urtrel_meta_inst';
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);


                    $data['count'] = $c++;
                }

                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadAdmin');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadAdmin');
            }
        }
    }


    public function uploadPuData()
    {
        $this->checkPermission();
        $users =  $this->Lib_model->getd(true);

        //prx($users);

        prx(array_column($users, 'emp_mobile', 'emp_name'));


        $sess_data = (array) getsessdata('user');
        //$current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 2;
            $desig_id = 5;
            //$relation_pair = 'ins-pu';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);

        //prx($file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');


            //$isUpload = $this->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            //prx($isUpload);
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                //prx($inputFileName);
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                //prx($inputFileType);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                //prx($objReader);
                $objPHPExcel = $objReader->load($inputFileName);
                //prx($objPHPExcel);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objReader);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                prx($readData);
                $c = 0;
                $inst = [];
                //prx($inst);
                foreach ($readData as $data) {
                    //prx($data[8]);


                    if (empty($data[9])) {
                        $data[9] =  $this->dashboard_model->generateUriseId('AD');
                        //prx($data);
                    }
                    $inst_tbl_urise = [
                            'urise_pre' => 'PU',
                            'urise_id' => $data[9],
                            'mapped_with' => $org_id
                        ];
                    prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_urise';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    if ($isInst > 0) {
                        if (empty($data[10])) {
                            $data[10] = md5($this->config->item('salt').$pass);
                        }
                        $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $data[9],
                                'log_pass' => $data[10],
                                'log_isdisable' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => $sess_data['id'],
                                'status' => 'NA',
                            ];

                        $tbl_name = 'urtbl_login';
                        $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                    }
                    if ($isInstLogin > 0) {
                        if (isset($data[12]) && $data[12] != '') {
                            $hrms_id =  $data[12];
                        } else {
                            $hrms_id =  000000;
                        }

                        $inst_tbl_emp = [
                                'log_id' => $isInstLogin,
                                'urise_id' => $data[9],
                                'emp_name' => $data[0],
                                'dept_desig_rel_id' => $desig_id,
                                'emp_email' => $data[1],
                                'emp_mobile' => $data[4],
                                'hrms_id' => $hrms_id,
                                'created_by' => $sess_data['id'],
                                'status' => 0,
                                'ad_isactive' => 1
                            ];
                    }
                    $tbl_name = 'urtbl_employee';
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_emp);


                    if ($role_id == 2) {
                        $tbl_name = 'urtbl_primary_userinfo';
                    }

                    if ($role_id == 3) {
                        $tbl_name = 'urtbl_secondary_userinfo';
                    }
                    if ($role_id == 4) {
                        $tbl_name = 'urtbl_tertiary_userinfo';
                    }


                    $urtrel_meta_inst = [
                            'urise_id' => $data[9],
                            'emp_id' => $isInstEmp,
                        ];


                    $meta_ist = $this->dashboard_model->insertData($tbl_name, $urtrel_meta_inst);

                    $instId = $this->dashboard_model->getInstId($data[11], $org_id);
                    if ($isInstEmp > 0) {
                        $inst_tbl_meta = [
                                'inst_id' => $instId,
                                'meta_id' => $isInstEmp,
                                'meta_value' => '',
                                'relation_pair' => $relation_pair,

                            ];
                    }

                    $tbl_name = 'urtrel_meta_inst';
                    $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);


                    $data['count'] = $c++;
                }

                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadAdmin');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadAdmin');
            }
        }
    }


    public function uploadStudentdev()
    {
        $this->checkPermission();
        // $sess_data = (array) getsessdata('user');
        // prx($sess_data);
        $this->load->view('includes/common_header');
        $this->load->view('upload-student-exel');
        $this->load->view('includes/common_footer');
    }

    public function uploadStuDataExcel()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $org_id = 3;// $sess_data['org_id'];
        $role_id = 5;
        $relation_pair = 0;
        $file = $_FILES['excel_file'];
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'captcha_images/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'captcha_images/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                // prx($readData);
                $c = 0;
                $inst = [];
                foreach ($readData as $data) {
                    $institute_id = $data[12];
                    if ($institute_id == "") {
                    }
                    $inst_id = "";
                    $course_id = "";
                    $status = $this->dashboard_model->getinstituteIdbycode($institute_id, $org_id);
                    if ($status) {
                        $inst_id = $status;
                    }
                    $course_code =  $data[13];
                    $status = $this->dashboard_model->getcourseId($course_code, $org_id)->course_id;
                    if ($status) {
                        $course_id =  $this->dashboard_model->getcourseId($course_code, $org_id)->course_id;
                    }
                    if ($inst_id != "" && $course_id != "") {
                        $urise_user_id =  $this->dashboard_model->generateUriseIdstudent('UR');
                        $inst_tbl_urise = [
                            'urise_pre' => 'UR',
                            'urise_id' => $urise_user_id,
                            'mapped_with' => $org_id
                        ];
                        $tbl_name = 'urtbl_urise';
                        $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                        if ($isInst > 0) {
                            $password = '123123123';
                            $password = hash("sha256", $password);
                            $password = $this->config->item('salt').$password;
                            $password = hash("sha256", $password);
                            $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $urise_user_id,
                                'log_pass' => $password,
                                'log_isdisable' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => '',
                                'status' => 'NA',
                            ];
                            $tbl_name = 'urtbl_login';
                            $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                        }
                        if ($isInstLogin > 0) {
                            $dob = date('Y-m-d', strtotime($data[6]));
                            $inst_tbl_stu = [
                                'stu_enroll_no' => $data[0],
                                'stu_roll_no' => $data[1],
                                'stu_log_id' => $isInstLogin,
                                'stu_first_name' => $data[3],
                                'stu_aadhar_no' => $data[4],
                                'stu_dob' => date('Y-m-d', strtotime($data[6])),
                                'stu_gender' => $data[7],
                                'stu_category' => $data[8],
                                'stu_mother_name' => $data[9],
                                'stu_father_name' => $data[10],
                                'stu_religion' =>  $data[15],
                                'stu_mobile_no' =>  $data[16],
                                'stu_email_id' =>  $data[17],
                                'status' => 0,
                                'stu_urise_id' => $urise_user_id,
                                'stu_org_id' => $org_id
                            ];
                        }
                        $tbl_name = 'urtbl_student';
                        $isInstStu = $this->dashboard_model->insertData($tbl_name, $inst_tbl_stu);
                        if ($isInstStu > 0) {
                            //$inst_id =  $this->dashboard_model->getinstituteIdbycode($data[12], $org_id);
                            $inst_tbl_meta = [
                                'inst_id' => $inst_id,
                                'meta_id' => $isInstStu,
                                'meta_value' => '',
                                'relation_pair' => $relation_pair,
                            ];
                            $tbl_name = 'urtrel_stumeta_inst';
                            $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);
                            $student_address = [
                                'sa_student_id' => $isInstStu,
                                'sa_village' => $data[21],
                                'sa_gram_panchayat' => $data[21],
                                'sa_tehsil' => $data[22],
                                'sa_district' => $data[23],
                                'sa_block_town' => $data[24],
                                'sa_pincode' => $data[25],
                                'sa_address' => $data[19],
                            ];
                            $tbl_name = 'urtbl_student_address';
                            $isInstEmp = $this->dashboard_model->insertData($tbl_name, $student_address);
                            $student_address = [
                                'courseid' => $course_id,
                                'stud_id' => $isInstStu,
                                'stud_meta_value' => '',
                            ];
                            $tbl_name = 'urel_stud_course_meta';
                            $isInstEmp = $this->dashboard_model->insertData($tbl_name, $student_address);
                            // insert semester
                            $semarray = [
                                'stud_id' => $isInstStu,
                                'stud_sem' => $data[2],
                            ];
                            $tbl_name = 'urrel_stud_sem_meta';
                            $isInstEmp = $this->dashboard_model->insertData($tbl_name, $semarray);
                            // Get course id by course code
                            $course_code =  $data[13];
                            //$course_id =  $this->dashboard_model->getcourseId($course_code,$orgid);
                            $student_course = [
                                'sei_student_id' => $isInstStu,
                                'sei_course_id' => $course_id,
                                //'sei_course_id' => $data[23],
                                'sei_sector_id' => $data[24],
                                'sei_inst_id' => $data[19],
                                'sei_semester' => $data[2],
                            ];
                            $tbl_name = 'urtbl_student_educational_info';
                            $isInstEmp = $this->dashboard_model->insertData($tbl_name, $student_course);
                            $student_personal_details = [
                                'sd_student_id' => $isInstStu,
                                'sd_is_physically_handicapped' => $data[19],
                                'sd_handicapped_type' => $data[20]
                            ];
                            $tbl_name = 'urtbl_student_details';
                            $isInstEmp = $this->dashboard_model->insertData($tbl_name, $student_personal_details);
                        }
                        $data['count'] = $c++;
                    } else {
                        $urise_user_id =  $this->dashboard_model->generateUriseIdstudent('UR');
                        $inst_tbl_urise = [
                        'urise_pre' => 'UR',
                        'urise_id' => $urise_user_id,
                        'mapped_with' => $org_id
                    ];
                        $tbl_name = 'urtbl_urise';
                        $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                        $dob = date('Y-m-d', strtotime($data[6]));
                        $reason = '';
                        if ($inst_id) {
                            $reason .='';
                        } else {
                            $reason .='INA';
                        }
                        if ($course_id) {
                            $reason .='';
                        } else {
                            $reason .='CNA';
                        }
                        $inst_tbl_stu = [
                        'stu_enroll_no' => $data[0],
                        'stu_roll_no' => $data[1],
                        'stu_first_name' => $data[3],
                        'stu_aadhar_no' => $data[4],
                        'stu_dob' => date('Y-m-d', strtotime($data[6])),
                        'stu_gender' => $data[7],
                        'stu_category' => $data[8],
                        'stu_mother_name' => $data[9],
                        'stu_father_name' => $data[10],
                        'stu_religion' =>  $data[15],
                        'stu_mobile_no' =>  $data[16],
                        'stu_email_id' =>  $data[17],
                        'status' => $reason,
                        'stu_urise_id' => $urise_user_id,
                        'stu_pr_id' => $org_id,
                        // 'temp_reason' =>  $reason
                    ];
                        $tbl_name = 'urtbl_student_tmp';
                        $this->dashboard_model->insertData($tbl_name, $inst_tbl_stu);
                    }
                }
                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadStudentdev');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadStudentdev');
            }
        }
    }

    public function uploadStudent()
    {
        $this->checkPermission();
        $this->load->view('includes/common_header');
        $this->load->view('upload-student-exel-su');
        $this->load->view('includes/common_footer');
    }

    public function uploadStuDataExcelsu()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        //prx($sess_data);


        $current_role = $sess_data['role_id'];
        $org_id = $sess_data['org_id'];

        $role_id = 5;
        $relation_pair = 0;

        $file = $_FILES['excel_file'];
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);

                $error == false;
                foreach ($readData as $data) {
                    $error = true;
                }


                if ($error == true) {
                    $this->session->set_flashdata('error', 'Error please try again !!!');
                    redirect('user/dashboard/uploadStudent');
                }

                exit;
                $c = 0;
                $inst = [];

                foreach ($readData as $data) {
                    $institute_id = $data[12];
                    $inst_id =  $this->dashboard_model->getinstituteIdbycode($institute_id, $org_id);

                    $course_code =  $data[13];
                    $course_id =  $this->dashboard_model->getcourseId($course_code, $orgid);


                    if ($inst_id && $course_id) {
                        //prx($data);
                        if (!empty($data[11])) {
                            $urise_user_id =  $this->dashboard_model->generateUriseId('UR');

                            $inst_tbl_urise = [
                            'urise_pre' => 'UR',
                            'urise_id' => $urise_user_id,
                            'mapped_with' => $org_id
                        ];
                            //prx($inst_tbl_urise);

                            $tbl_name = 'urtbl_urise';
                            $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                            if ($isInst > 0) {
                                $pass = '1234';
                                $password = md5($this->config->item('salt') . $pass);
                                $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $urise_user_id,
                                'log_pass' => $password,
                                'log_isdisable' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => '',
                                'status' => 'NA',
                            ];

                                $tbl_name = 'urtbl_login';
                                $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                            }
                            if ($isInstLogin > 0) {
                                $dob = date('Y-m-d', strtotime($data[6]));

                                /*
                                ENROLL NUM-0
                                Roll no	-1
                                Full name-3
                                aadhar no-4
                                dob-6
                                gender-7
                                category-8
                                Mother name-9
                                Father name-10
                                religion -15
                                mobile no -16
                                email id -17
                                institute code-12
                                Branch code -13
                                Batch	-11
                                institute code-12
                                Branch code -13
                                program name -14


                                */

                                $inst_tbl_stu = [
                                'stu_enroll_no' => $data[0],
                                'stu_roll_no' => $data[1],
                                'stu_log_id' => $isInstLogin,
                                'stu_first_name' => $data[3],
                                'stu_aadhar_no' => $data[4],
                                'stu_dob' => date('Y-m-d', strtotime($data[6])),
                                'stu_gender' => $data[7],
                                'stu_category' => $data[8],
                                'stu_mother_name' => $data[9],
                                'stu_father_name' => $data[10],
                                'stu_religion' =>  $data[15],
                                'stu_mobile_no' =>  $data[16],
                                'stu_email_id' =>  $data[17],
                                'status' => 0,
                                'stu_urise_id' => $urise_user_id,
                                'stu_org_id' => $org_id
                            ];
                            }

                            $tbl_name = 'urtbl_student';
                            $isInstStu = $this->dashboard_model->insertData($tbl_name, $inst_tbl_stu);


                            if ($isInstStu > 0) {
                                $inst_tbl_meta = [
                                'inst_id' => $inst_id,
                                'meta_id' => $isInstStu,
                                'meta_value' => '',
                                'relation_pair' => $relation_pair,
                            ];

                                $tbl_name = 'urtrel_stumeta_inst';
                                $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);



                                $student_address = [
                                'sa_student_id' => $isInstStu,
                                'sa_village' => $data[21],
                                'sa_gram_panchayat' => $data[21],
                                'sa_tehsil' => $data[22],
                                'sa_district' => $data[23],
                                'sa_block_town' => $data[24],
                                'sa_pincode' => $data[25],
                                'sa_address' => $data[19],


                            ];

                                $tbl_name = 'urtbl_student_address';
                                $isInstEmp = $this->dashboard_model->insertData($tbl_name, $student_address);

                                $student_address = [
                                'courseid' => $course_id,
                                'stud_id' => $isInstStu,
                                'stud_meta_value' => '',
                            ];

                                $tbl_name = 'urel_stud_course_meta';
                                $isInstEmp = $this->dashboard_model->insertData($tbl_name, $student_address);


                                // Get course id by course code



                                $student_course = [
                                'sei_student_id' => $isInstStu,
                                'sei_course_id' => $course_id,
                                //'sei_course_id' => $data[23],
                                'sei_sector_id' => $data[24],
                                'sei_inst_id' => $data[19],
                                'sei_semester' => $data[2],

                            ];

                                $tbl_name = 'urtbl_student_educational_info';
                                $isInstEmp = $this->dashboard_model->insertData($tbl_name, $student_course);


                                $student_personal_details = [
                                'sd_student_id' => $isInstStu,
                                'sd_is_physically_handicapped' => $data[19],
                                'sd_handicapped_type' => $data[20]

                            ];

                                $tbl_name = 'urtbl_student_details';
                                $isInstEmp = $this->dashboard_model->insertData($tbl_name, $student_personal_details);
                            }




                            $data['count'] = $c++;
                        }
                    }
                }

                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadStudent');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadStudent');
            }
        }
    }


public function inviteUsers()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $emp_id = $this->uri->segment(4);
        $emp_id = base64_decode($emp_id);
        $emp_data =  $this->dashboard_model->getEmpdata($emp_id);
        $parent_id = $sess_data->emp_id;
        $user_type = $emp_data->role_name;
        $date = date('Y-m-d H:i:s');
        $invite_token = base64_encode($date . '|' . $parent_id . '|' . $user_type);
        $update = ['token' => $invite_token];
        // print_r($insertdata);die;
        // $insert_users = $this->Dpm_User_Manage_Model->insertUsers($update);
        $log_id = $emp_data->log_id;
        $receiverMail = $emp_data->emp_email;
        $senderMail = $sess_data->email;
        $mobile = $emp_data->emp_mobile;
        $update = ['token' => $invite_token];
        $updatetoken = $this->dashboard_model->updateInviteToken($log_id, $update);
        if ($updatetoken > 0) {
            $updateStatus = ['status' => 'invited'];
            $updatestatus = $this->dashboard_model->updatebtnStatus($log_id, $updateStatus);
            invitation_mail_ts($receiverMail, $senderMail, $invite_token, $mobile, $user_type);
            $url = base_url() . 'user/signup/?token=' . $invite_token;
            $this->sendSMS($mobile, $url);
            $result['status'] = 1;
            $result['msg'] = 'Invitation sent successfully.';
            $result['token'] = $url;
        } else {
            $result['status'] = 0;
            $result['msg'] = 'Invitation sent failed.';
        }

        echo json_encode($result);
    }

    public function sendSMS($mobile, $url)
    {
        $msg = "Dear%20Sir/Madam,%0aYou%20are%20invited%20to%20be%20a%20part%20of%20urise%20as%20a%20Tertiary%20admin.%0aPlease%20click%20on%20below%20link%20to%20complete%20the%20registration%20process:%0a%0a" . $url . ".%0a%0aThanks%0aTeam%20URISE";
        $ch = curl_init($this->config->item('sms_api'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=AKTU&pass=109386231&sender=DRAKTU&sendto=" . $mobile . "&message=" . $msg);
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


    public function changePassword()
    {
        $this->checkPermission();
        $this->form_validation->set_rules('prev_pass', 'Current Password', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|strip_tags|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|xss_clean|strip_tags');
        $sess_data = getsessdata('user');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('postdata', $this->input->post());
            redirect('user/dashboard', 'refresh');
        } else {
            //prx($this->input->post());
            $prev_pass = $this->input->post('prev_pass');
            $prev_pass = substr($prev_pass, 5, -5);
            $prev_pass = $this->config->item('salt').$prev_pass;
            $prev_pass = hash("sha256", $prev_pass);
            $password = $this->input->post('password');
            $password = substr($password, 5, -5);
            $password = $this->config->item('salt').$password;
            $password = hash("sha256", $password);
            $passExist = $this->User_Profile_Model->getCurrentPass($prev_pass, $sess_data->urise_id);
          
            if (!empty($passExist)) {
                $unique_id = ($sess_data->log_authid != "") ? $sess_data->log_authid : $sess_data->urise_id;
                
                $wherepass = ['log_pass' => $prev_pass,'log_authid' => $unique_id];
                $passUpdate = ['log_pass' => $password, 'updated_at' => date('Y-m-d H:i:s')];
                // pr($wherepass);
                // prx($passUpdate);
                $update_pass = $this->User_Profile_Model->updatePassword($passUpdate, $wherepass);
                if ($update_pass) {
                    if (!empty(getsessdata('user'))) {
                        $key = $this->session->userdata('user')['session_var'];
                        $this->session->sess_destroy($key);
                        $this->session->sess_destroy('user');
                    }
                    redirect('user/login', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Unable to change password please try again.');
                    redirect('user/dashboard');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
                redirect('user/dashboard');
            }
        }
    }



    public function changeSkillPassword()
    {
        $this->checkPermission();
        $this->form_validation->set_rules('prev_pas', 'Current Password', 'required|xss_clean|strip_tags');
        $this->form_validation->set_rules('pasword', 'Password', 'required|xss_clean|strip_tags|matches[pasword_confirm]');
        $this->form_validation->set_rules('pasword_confirm', 'Confirm Password', 'required|xss_clean|strip_tags');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('postdata', $this->input->post());
            redirect('user/dashboard', 'refresh');
        } else {
            // prx($this->input->post());
            $prev_pass = $this->input->post('prev_pas');
            $prev_pass = substr($prev_pass, 5, -5);
            $prev_pass = $this->config->item('salt').$prev_pass;
            $prev_pass = hash("sha256", $prev_pass);
            $password = $this->input->post('pasword');
            $password = substr($password, 5, -5);
            $password = $this->config->item('salt').$password;
            $password = hash("sha256", $password);
            $passExist = $this->User_Profile_Model->getSkillCurrentPass($prev_pass);

            $sess_data = getsessdata('user');
            
            //prx($passExist);
           
            if (!empty($passExist)) {
                // $unique_id = ($sess_data->log_authid != "") ? $sess_data->log_authid : $sess_data->urise_id;
                $unique_id = $sess_data['urise_id'];
                $wherepass = ['log_pass' => $prev_pass,'log_authid' => $unique_id];
                $passUpdate = ['log_pass' => $password, 'updated_at' => date('Y-m-d H:i:s')];
                //prx($wherepass);
                // prx($passUpdate);
                $update_pass = $this->User_Profile_Model->updateSkillPassword($passUpdate, $wherepass);
                if ($update_pass) {
                    if (!empty(getsessdata('user'))) {
                        $key = $this->session->userdata('user')['session_var'];
                        $this->session->sess_destroy($key);
                        $this->session->sess_destroy('user');
                    }
                    redirect('user/login', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Unable to change password please try again.');
                    redirect('user/dashboard');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
                redirect('user/dashboard');
            }
        }
    }
    public function changeSkillPwd()
    {
        $this->checkPermission();
        // $sess_data = (array) getsessdata('user');
        // prx($sess_data);
        $this->load->view('includes/common_header');
        $this->load->view('changePwd');
        $this->load->view('includes/common_footer');
    }

    public function changeSkillPwdProcess()
    {
        //  prx($this->input->post());
        $this->checkPermission();
        if (empty($this->input->post())) {
            $this->session->set_flashdata('error', 'You are doing something wrong.');
            redirect('user/login', 'refresh');
        } else {
            $this->form_validation->set_rules('Currentpwd', 'Currentpwd', 'required|xss_clean|strip_tags');

            $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|strip_tags');
        }
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('postdata', $this->input->post());
            redirect('user/login', 'refresh');
        } else {
            $sess =  $this->session->userdata('user');
            prx($sess['urise_id']);
            $uriseid = $sess['urise_id'];
            $Currentpwd = $this->input->post('Currentpwd');
            // $Currentpwd = md5($this->config->item('salt') . $Currentpwd);
            $Currentpwd = substr($password, 5, -5);
            $Currentpwd = $this->config->item('salt').$password;
            $Currentpwd = hash("sha256", $password);


            $password = $this->input->post('password');
            $password = substr($password, 5, -5);
            $password = $this->config->item('salt').$password;
            $password = hash("sha256", $password);

            $count = $this->Lib_model->Counter('urtbl_skill_login', array('log_authid' => $uriseid,'log_pass' => $Currentpwd));

            if ($count == 1) {
                $f = array(
                     'log_pass' => $password,
                       );

                $this->Lib_model->Update('urtbl_skill_login', $f, array('log_authid' => $uriseid));
                $msg = array('msg' => 'Password Updated Successfully', 'Type' => 'msg');
                $this->session->set_flashdata($msg);
                redirect('user/dashboard', 'refresh');
            } else {
                $err = array('err' => 'You have entered wrong Current Password', 'Type' => 'err');
                $this->session->set_flashdata($err);
                redirect('user/dashboard', 'refresh');
            }
        }
    }
    public function liststudent()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $org_id = $sess_data->org_id;
       
        $roll=$sess_data->role_id;
    if($roll ==1 && $org_id !=1){     
        
          if($this->uri->segment(3) == 'dirRegister'){
            $data['userslistdata'] = $this->dashboard_model->dirstudentliststud($sess_data->org_id);
            $data['userslist'] = $this->dashboard_model->dirstudentliststud(array('org_id'=>$org_id, 'limit' => $this->perPage));            
            $totalRec = count($data['userslistdata']);               

            $config['target']      = '#dirRegister';
            $config['base_url']    = base_url().'user/ajax_dirRegister';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter1';

           } elseif($this->uri->segment(3) == 'liststudent' || $this->uri->segment(3) == ''){
            $data['unreglistdata'] = $this->dashboard_model->dirstudentunreglist($sess_data->org_id);
            $data['unreglist'] = $this->dashboard_model->dirstudentunreglist(array('org_id'=>$org_id, 'limit' => $this->perPage));           
            $totalRec = count($data['unreglistdata']);               

            $config['target']      = '#dirUnregister';
            $config['base_url']    = base_url().'user/ajax_dirUnregister';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter';

        }else{
            echo 'Bad Request';
        }
    }elseif($roll ==1 && $org_id ==1){
        if($this->uri->segment(3) == 'dirRegister'){           
            $data['userslistdata'] = $this->dashboard_model->skilldirstudentliststud($sess_data->org_id);
            $data['userslist'] = $this->dashboard_model->skilldirstudentliststud(array('org_id'=>$org_id, 'limit' => $this->perPage));                        
            $totalRec = count($data['userslistdata']);               

            $config['target']      = '#dirRegister';
            $config['base_url']    = base_url().'user/ajax_dirRegister';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter1';

           } elseif($this->uri->segment(3) == 'liststudent' || $this->uri->segment(3) == ''){
            
            $data['unreglistdata'] = $this->dashboard_model->skilldirunregstud($sess_data->org_id);
            $data['unreglist'] = $this->dashboard_model->skilldirunregstud(array('org_id'=>$org_id, 'limit' => $this->perPage));                       
            $totalRec = count($data['unreglistdata']);               

            $config['target']      = '#dirUnregister';
            $config['base_url']    = base_url().'user/ajax_dirUnregister';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter';

        }else{
            echo 'Bad Request';
        }
    }else{
        $this->session->set_flashdata('error', 'Access Denied');
        redirect('user/login', 'refresh');
    }
        $p[] = $t =  getsessdata('user');
        //prx($t->org_id);
        $is_skill = $t->org_id;
        
        if ($is_skill == 1) {        
        
        //$data['userslist'] = $this->dashboard_model->skilldirstudentliststud($is_skill);
        //$data['unreglist'] = $this->dashboard_model->skilldirunregstud($is_skill);

        $data['dirRegister'] = $this->dashboard_model->skilldirstudentliststud($is_skill);
        $data['dirUnregister'] = $this->dashboard_model->skilldirunregstud($is_skill);
        $data['is_skill']  = $t->org_id;
        //prx($data['unreglist']);
        }else{
            $data['dirRegister'] = $this->dashboard_model->dirstudentliststud($sess_data->org_id);
            $data['dirUnregister'] = $this->dashboard_model->dirstudentunreglist($sess_data->org_id);
        }
        
        $this->ajax_pagination->initialize($config);
        $this->load->view('includes/common_header');
        $this->load->view('user/studentlist', $data);
        $this->load->view('includes/common_footer');
    }

    public function ajax_dirUnregister(){
        $this->checkPermission();
    $user = getsessdata('user');;
    $org_id = $user->org_id;

    $page = $this->input->post('page');
    if(!$page){
        $offset = 0;
    }else{
        $offset = $page;
    }
    $nopage = $this->input->post('pageSize');
    if(empty($nopage)){
$setpage=$this->perPage;
}else{
    $setpage=$nopage;
}
        $enroll = isset($_POST['enroll']) ? $_POST['enroll'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';		
		$inst_code = isset($_POST['inst_code']) ? $_POST['inst_code'] : '';
			$model = array(
			'enroll' => $enroll,
			'name' => $name,      
	  'inst_code'=>$inst_code,
      'org_id'=>$org_id,
    );
	
    $returnRes['csrf_token'] = $this->security->get_csrf_hash();
if($org_id != 1){
    $returnRes['dataView'] = $this->dashboard_model->dirstudentunreglist($model);
    $totalRec = count($returnRes['dataView']);

    $config['target']      = '#dirUnregister';
    $config['base_url']    = base_url().'user/ajax_dirUnregister';
    $config['total_rows']  = $totalRec;
    $config['per_page']    = $this->perPage;
    $config['link_func']   = 'searchFilter';

    $this->ajax_pagination->initialize($config);    
    $returnRes['unreglist'] = $this->dashboard_model->dirstudentunreglist(array('org_id'=>$org_id,'start' => $offset, 'limit' => $setpage,'enroll'=>$enroll,'name' => $name,'inst_code'=>$inst_code));

}else {
    
    $returnRes['dataView'] = $this->dashboard_model->skilldirunregstud($model);
    $totalRec = count($returnRes['dataView']);

    $config['target']      = '#dirUnregister';
    $config['base_url']    = base_url().'user/ajax_dirUnregister';
    $config['total_rows']  = $totalRec;
    $config['per_page']    = $this->perPage;
    $config['link_func']   = 'searchFilter';

    $this->ajax_pagination->initialize($config);   
    $returnRes['unreglist'] = $this->dashboard_model->skilldirunregstud(array('org_id'=>$org_id,'start' => $offset, 'limit' => $setpage,'enroll'=>$enroll,'name' => $name,'inst_code'=>$inst_code));

}
    
    $returnRes['pagi'] = $this->ajax_pagination->create_links();

    $this->load->view('user/ajax_dirUnregister', $returnRes,false);
    }

    public function ajax_dirRegister(){
        $this->checkPermission();
    $user = getsessdata('user');;
    $org_id = $user->org_id;

    $page = $this->input->post('page');
    if(!$page){
        $offset = 0;
    }else{
        $offset = $page;
    }
    $nopage = $this->input->post('pageSize');
    if(empty($nopage)){
$setpage=$this->perPage;
}else{
    $setpage=$nopage;
}
        $enroll = isset($_POST['enroll']) ? $_POST['enroll'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';		
		$inst_code = isset($_POST['inst_code']) ? $_POST['inst_code'] : '';
			$model = array(
			'enroll' => $enroll,
			'name' => $name,      
	  'inst_code'=>$inst_code,
      'org_id'=>$org_id,
    );
	
    $returnRes['csrf_token'] = $this->security->get_csrf_hash();   
    
    if($org_id != 1){
    $returnRes['dataView'] = $this->dashboard_model->dirstudentliststud($model);
    $totalRec = count($returnRes['dataView']);

    $config['target']      = '#dirRegister';
    $config['base_url']    = base_url().'user/ajax_dirRegister';
    $config['total_rows']  = $totalRec;
    $config['per_page']    = $setpage;
    $config['link_func']   = 'searchFilter1';

    $this->ajax_pagination->initialize($config);    
    $returnRes['userslist'] = $this->dashboard_model->dirstudentliststud(array('org_id'=>$org_id,'start' => $offset, 'limit' => $setpage,'enroll'=>$enroll,'name' => $name,'inst_code'=>$inst_code));
    }else {
        
        $returnRes['dataView'] = $this->dashboard_model->skilldirstudentliststud($model);
        $totalRec = count($returnRes['dataView']);
    
        $config['target']      = '#dirRegister';
        $config['base_url']    = base_url().'user/ajax_dirRegister';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $setpage;
        $config['link_func']   = 'searchFilter1';
    
        $this->ajax_pagination->initialize($config);  
        $returnRes['userslist'] = $this->dashboard_model->skilldirstudentliststud(array('org_id'=>$org_id,'start' => $offset, 'limit' => $setpage,'enroll'=>$enroll,'name' => $name,'inst_code'=>$inst_code)); 
       
    }
    $returnRes['pagi'] = $this->ajax_pagination->create_links();

    $this->load->view('user/ajax_dirRegister', $returnRes,false);
    }

    public function uploadSkillSubjectMapping()
    {
        $this->checkPermission();

        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillSubject');
        $this->load->view('includes/common_footer');
    }
   
    public function uploadSkillSubjProcess()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $org_id = 2;// $sess_data['org_id'];
        $role_id = 5;
        $relation_pair = 0;
        $file = $_FILES['excel_file'];
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                $c = 0;
                $inst = [];
                //prx($readData);
                foreach ($readData as $data) {
                    //prx($data[4]);
                    $tpp = $data[0];
                    $dis = $data[4];
                    $tpp = $data[2];

                    // $arr = $this->Lib_model->Select('urtbl_skill_TPmaster', 'TP_Id', array('TP_code' => $tp_i));

                    // $rs = (array)$arr[0];
                    //prx($rs);
                    $rs = $this->Lib_model->Select('urtbl_skill_TPmaster', '*', array('TP_code' => $tpp));

                    // prx($rs[0]->TP_Id);
                    $Tppp_id = $rs->TP_Id;

                    //prx($rs[0]->TP_Id);
                    $Tppp_id = $rs[0]->TP_Id;
                    // prx($Tppp_id);

                    if ($Tppp_id == 0) {
                        $log_array[]="'a''$data[0]'/'$data[2]'/'$data[5]'/'$data[6]'/'$data[7]'/'$data[3]'/'$data[4]'/'$data[8]'/'$data[9]'/'$data[10]' "; //for tpcode Data Not
                    }

                    if ($Tppp_id > 0) {
                        $sec = $data[3];

                        $ra = $this->Lib_model->Select('urtbl_sector', 'sector_id', array('nopmkvy' => $sec));
                        if ($ra == 0) {
                            $log_array[]="'b''$data[0]'/'$data[2]'/'$data[5]'/'$data[6]'/'$data[7]'/'$data[3]'/'$data[4]'/'$data[8]'/'$data[9]'/'$data[10]' "; //for tpcode Data Not
                        }
                        // prx($rs[0]->TP_Id);
                        $sec = $ra->sector_id;
 
                        //prx($rs[0]->TP_Id);
                        $sec_id = $ra[0]->sector_id;
                        //prx($sec_id);
                        // // $sql  = "SELECT * FROM urtbl_skill_district WHERE dis_name LIKE '%$dis%' " ;

                        // // $dis = $this->Lib_model->Execute($sql, array())->result();
                        // //prx($dis[0]->dis_id);
                        // $dis = $dis[0]->dis_id;

                        //prx($data[0]);
            
                        if ($sec_id > 0) {
                            $Sector_map = [
                'tp_id' => $Tppp_id,
                'sector_id' => $sec_id,
                'meta_value' => 'non-pmkvy',
                    ];
        
                            $isInst = $this->Lib_model->Insert('urtbl_skill_tp_sector', $Sector_map);
                                
                            //     $tbl_name = 'urtbl_skill_tp_sector';
            //     $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                        }
                    }
        
                    if ($isInst > 0) {
                        $tc_code = $data[0];

                        $ra = $this->Lib_model->Select('urtbl_skill_training_center', 'tc_id', array('tc_code' => $tc_code));
                        if ($ra == 0) {
                            $log_array[]="'c''$data[0]'/'$data[2]'/'$data[5]'/'$data[6]'/'$data[7]'/'$data[3]'/'$data[4]'/'$data[8]'/'$data[9]'/'$data[10]' "; //for tpcode Data Not
                        }
                        // prx($rs[0]->TP_Id);
                        $tc_id = $ra->tc_id;
 
                        //prx($rs[0]->TP_Id);
                        $tc_id = $ra[0]->tc_id;
                        //prx($tc_id);
           
                        $crs = $data[1];

                        $crs = $this->Lib_model->Select('urtbl_course_master', 'course_id', array('course_code' => $crs));
                        if ($crs == 0) {
                            $log_array[]="'d''$data[0]'/'$data[2]'/'$data[5]'/'$data[6]'/'$data[7]'/'$data[3]'/'$data[4]'/'$data[8]'/'$data[9]'/'$data[10]' "; //for tpcode Data Not
                        }
                        // prx($rs[0]->TP_Id);
                        $crs_id = $crs->course_id;
    
                        //prx($rs[0]->TP_Id);
                        $crs_iddd = $crs[0]->course_id;
            
                        // prx($tc_id);
              
                        $dob = date('Y-m-d', strtotime($data[6]));
                        if (($crs_iddd > 0) && ($tc_id > 0)) {
                            $course_map = [
                'tc_id' => $tc_id,
                'course_id' => $crs_iddd,
                'meta_value' => 'non-pmkvy',
            ];
                        } //prx($tc_id);
        
                        $this->Lib_model->Insert('urtbl_skill_tc_course', $course_map);
                    }
                    // $tbl_name = 'urtbl_skill_tc_course';
                    // $isInstS = $this->dashboard_model->insertData($tbl_name, $inst);
        
                    if ($isInst > 0) {
                        $sub_code = $data[1];
    
                        $rsub = $this->Lib_model->Select('urtblsub_description', 'sub_id', array('sub_code' => $sub_code));
                        if ($rsub == 0) {
                            $log_array[]="'e''$data[0]'/'$data[2]'/'$data[5]'/'$data[6]'/'$data[7]'/'$data[3]'/'$data[4]'/'$data[8]'/'$data[9]'/'$data[10]' "; //for tpcode Data Not
                        }
                        // prx($rs[0]->TP_Id);
                        $rsu = $rsub->sub_id;
     
                        //prx($rs[0]->TP_Id);
                        $rsubb = $rsub[0]->sub_id;
                        //prx($tc_id);
               
                        $crs = $data[1];
    
                        $crs = $this->Lib_model->Select('urtbl_course_master', 'course_id', array('course_code' => $crs));
                        if ($crs == 0) {
                            $log_array[]="'f''$data[0]'/'$data[2]'/'$data[5]'/'$data[6]'/'$data[7]'/'$data[3]'/'$data[4]'/'$data[8]'/'$data[9]'/'$data[10]' "; //for tpcode Data Not
                        }
                        // prx($rs[0]->TP_Id);
                        $crs_id = $crs->course_id;
        
                        //prx($rs[0]->TP_Id);
                        $crs_iddddd = $crs[0]->course_id;
                        //prx($crs_id);
                  
                        $dob = date('Y-m-d', strtotime($data[6]));
                        if (($crs_iddddd > 0) && ($rsubb > 0)) {
                            $course_sub = [
                    'sub_id' => $rsubb,
                    'course_id' => $crs_iddddd,
                    'meta_value' => 'non-pmkvy',
                ];
                        } //prx($tc_id);
            
                        // $tbl_name = 'urtbl_skill_course_sub';
                        // $is = $this->dashboard_model->insertData($tbl_name, $inst_sub);
                        $this->Lib_model->Insert('urtbl_skill_course_sub', $course_sub);
                    }
        
                    $data['count'] = $c++;
                }
                //prx($log_array);
                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadSkillSubjectMapping');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillSubjectMapping');
            }
        }
    }


    public function pustudent()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $zoneid = getzoneid($sess_data->emp_id);
        $current_role = $sess_data->role_id;
        if( $current_role == 2){
            $data['userslist'] = $this->dashboard_model->getstudentliststud($zoneid);
            $data['unreglist'] = $this->dashboard_model->getstudentunreglist($zoneid);
        }else{
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('user/login', 'refresh');
        }
       

        $this->load->view('includes/common_header');
        $this->load->view('user/pustudentlist', $data);
        $this->load->view('includes/common_footer');
    }

    public function puUploadedvideo()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $zoneid = getzoneid($sess_data->emp_id);
        $current_role = $sess_data->role_id;
        if( $current_role == 2){
        $data['dataView'] = $this->dashboard_model->purfaData($zoneid);
        $data['approved'] = $this->dashboard_model->puapproveData($zoneid);
        $data['reject'] = $this->dashboard_model->purejectData($zoneid);
        }else{
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('user/login', 'refresh');  
        }
        $this->load->view('includes/common_header');
        $this->load->view('user/puuploadedvideo', $data);
        $this->load->view('includes/common_footer');
    }
    public function directorUploadedvideo()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $current_role = $sess_data->role_id;
        $org_id = $sess_data->org_id;
        if( $current_role == 1){
        // $data['dataView'] = $this->dashboard_model->directorrfaData($sess_data->org_id);
        // $data['approved'] = $this->dashboard_model->directorapproveData($sess_data->org_id);
        // $data['reject'] = $this->dashboard_model->directorrejectData($sess_data->org_id);

        if ($this->uri->segment(3) == 'approve') {
            $data['approved'] = $this->dashboard_model->directorapproveData($org_id);
            $data['approvedVideos'] = $this->dashboard_model->directorapproveData(array('org_id'=>$org_id, 'limit' => $this->perPage));
            $totalRec = count($data['approved']);               

            $config['target']      = '#videoapproved';
            $config['base_url']    = base_url().'dashboard/ajax_approved';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter1';

        }elseif($this->uri->segment(3) == 'reject'){
            $data['reject'] = $this->dashboard_model->directorrejectData($org_id);
            $data['rejectVideos'] = $this->dashboard_model->directorrejectData(array('org_id'=>$org_id, 'limit' => $this->perPage));
            $totalRec = count($data['reject']);               

            $config['target']      = '#videreject';
            $config['base_url']    = base_url().'dashboard/ajax_reject';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter2';

        } elseif($this->uri->segment(3) == 'directorUploadedvideo' || $this->uri->segment(3) == ''){
            $data['dataView'] = $this->dashboard_model->directorrfaData($org_id);
            $data['dataViewVideos'] = $this->dashboard_model->directorrfaData(array('org_id'=>$org_id, 'limit' => $this->perPage));
            $totalRec = count($data['dataView']);               

            $config['target']      = '#myTable';
            $config['base_url']    = base_url().'dashboard/ajax_unapprove';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter';

        }else{
            echo 'Bad Request';
        }

        }else{
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('user/login', 'refresh'); 
        }

        $data['unapp'] = $this->dashboard_model->directorrfaData($org_id);
        $data['dataapproved'] = $this->dashboard_model->directorapproveData($org_id);
        $data['datareject'] = $this->dashboard_model->directorrejectData($org_id);
        $data['totalcourse'] = $this->dashboard_model->getCourse($org_id);
        $this->ajax_pagination->initialize($config);

        $this->load->view('includes/common_header');
        $this->load->view('user/directoruploadedvideo', $data);
        $this->load->view('includes/common_footer');
    }
    public function ajax_unapprove(){
        $this->checkPermission();
    $user = getsessdata('user');;
    $org_id = $user->org_id;

    $page = $this->input->post('page');
    if(!$page){
        $offset = 0;
    }else{
        $offset = $page;
    }
    $nopage = $this->input->post('pageSize');
    if(empty($nopage)){
$setpage=$this->perPage;
}else{
    $setpage=$nopage;
}
    $topic = isset($_POST['topic']) ? $_POST['topic'] : '';
		$course = isset($_POST['course']) ? $_POST['course'] : '';
		$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
		$inst_code = isset($_POST['inst_code']) ? $_POST['inst_code'] : '';
			$model = array(
			'topic' => $topic,
			'course' => $course,
      'subject' => $subject,
	  'inst_code'=>$inst_code,
      'org_id'=>$org_id,
    );
	
    $returnRes['csrf_token'] = $this->security->get_csrf_hash();
    $returnRes['dataView'] = $this->dashboard_model->directorrfaData($model);
    $totalRec = count($returnRes['dataView']);


    $config['target']      = '#unmyTable';
    $config['base_url']    = base_url().'dashboard/ajax_unapprove';
    $config['total_rows']  = $totalRec;
    $config['per_page']    = $setpage;
    $config['link_func']   = 'searchFilter';

    $this->ajax_pagination->initialize($config);
    $returnRes['dataViewVideos'] = $this->dashboard_model->directorrfaData(array('org_id'=>$org_id,'start' => $offset, 'limit' => $setpage,'topic'=>$topic,'course' => $course, 'subject' => $subject,'inst_code'=>$inst_code));
    $returnRes['pagi'] = $this->ajax_pagination->create_links();

    $this->load->view('user/ajax_dirunapprove', $returnRes,false);
    }
    public function ajax_approved(){
        $this->checkPermission();
    $user = getsessdata('user');;
    $org_id = $user->org_id;

    $page = $this->input->post('page');
    if(!$page){
        $offset = 0;
    }else{
        $offset = $page;
    }
    $nopage = $this->input->post('pageSize');
    if(empty($nopage)){
$setpage=$this->perPage;
}else{
    $setpage=$nopage;
}
    $topic = isset($_POST['topic']) ? $_POST['topic'] : '';
		$course = isset($_POST['course']) ? $_POST['course'] : '';
		$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
		$inst_code = isset($_POST['inst_code']) ? $_POST['inst_code'] : '';
			$model = array(
			'topic' => $topic,
			'course' => $course,
      'subject' => $subject,
	  'inst_code'=>$inst_code,
      'org_id'=>$org_id,
    );
	
    $returnRes['csrf_token'] = $this->security->get_csrf_hash();
    $returnRes['approved'] = $this->dashboard_model->directorapproveData($model);
    $totalRec = count($returnRes['approved']);


    $config['target']      = '#videoapproved';
    $config['base_url']    = base_url().'dashboard/ajax_approved';
    $config['total_rows']  = $totalRec;
    $config['per_page']    = $setpage;
    $config['link_func']   = 'searchFilter1';

    $this->ajax_pagination->initialize($config);
    $returnRes['approvedVideos'] = $this->dashboard_model->directorapproveData(array('org_id'=>$org_id,'start' => $offset, 'limit' => $setpage,'topic'=>$topic,'course' => $course, 'subject' => $subject,'inst_code'=>$inst_code));
    $returnRes['pagi'] = $this->ajax_pagination->create_links();

    $this->load->view('user/ajax_approved', $returnRes,false);
    }
    public function ajax_reject(){
        $this->checkPermission();
    $user = getsessdata('user');;
    $org_id = $user->org_id;

    $page = $this->input->post('page');
    if(!$page){
        $offset = 0;
    }else{
        $offset = $page;
    }
    $nopage = $this->input->post('pageSize');
    if(empty($nopage)){
$setpage=$this->perPage;
}else{
    $setpage=$nopage;
}
    $topic = isset($_POST['topic']) ? $_POST['topic'] : '';
		$course = isset($_POST['course']) ? $_POST['course'] : '';
		$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
		$inst_code = isset($_POST['inst_code']) ? $_POST['inst_code'] : '';
			$model = array(
			'topic' => $topic,
			'course' => $course,
            'subject' => $subject,
	        'inst_code'=>$inst_code,
            'org_id'=>$org_id,
    );
	
    $returnRes['csrf_token'] = $this->security->get_csrf_hash();
    $returnRes['reject'] = $this->dashboard_model->directorrejectData($model);
    $totalRec = count($returnRes['reject']);


    $config['target']      = '#videreject';
    $config['base_url']    = base_url().'dashboard/ajax_reject';
    $config['total_rows']  = $totalRec;
    $config['per_page']    = $setpage;
    $config['link_func']   = 'searchFilter2';

    $this->ajax_pagination->initialize($config);
    $returnRes['rejectVideos'] = $this->dashboard_model->directorrejectData(array('org_id'=>$org_id,'start' => $offset, 'limit' => $setpage,'topic'=>$topic,'course' => $course, 'subject' => $subject,'inst_code'=>$inst_code));
    $returnRes['pagi'] = $this->ajax_pagination->create_links();

    $this->load->view('user/ajax_reject', $returnRes,false);
    }
    public function contestlist()
    {
        $this->checkPermission();
        $sess_data = getsessdata('user');
        $orgId = $sess_data->org_id;
        $current_role = $sess_data->role_id;
        if ($current_role == 1) {
        $data['dataViews']= $this->dashboard_model->viewcontestData($orgId);
    }else{
        $this->session->set_flashdata('error', 'Access Denied');
        redirect('user/login', 'refresh');
    }
        $this->load->view('includes/common_header');
        $this->load->view('user/contestlist', $data);
        $this->load->view('includes/common_footer');
    }

    public function uploadskillStudent()
    {
        $this->checkPermission();
        // $sess_data = (array) getsessdata('user');
        // prx($sess_data);
        $this->load->view('includes/common_header');
        $this->load->view('upload-skill-student-exel');
        $this->load->view('includes/common_footer');
    }

    
    public function uploadSkillStuDataExcel()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $org_id = 1;// $sess_data['org_id'];
        $role_id = 5;
        $relation_pair = 0;
        $file = $_FILES['excel_file'];
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                $c = 0;
                $s = 1;
                $r = 1;
                $creator = $this->input->post('created_by');
                $inst = [];
                foreach ($readData as $data) {
                                     
                    //prx($creator);
                    $enroll_exist = $data[0];
                    //'stu_enroll_no' => $data[0]

                    $e_exist = $this->Lib_model->Select('urtblskill_student', '*', array('stu_enroll_no' => $enroll_exist));
                    //prx($t);
                    $e_ex = array_column($e_exist, 'stu_enroll_no');
                    
                    $enr_exist = $e_ex[0];

                  //  #################################3
                   //= prx($data[11]);
                    $tc_Code = $data[11];

                    $t = $this->Lib_model->Select('urtbl_skill_training_center', '*', array('tc_code' => $tc_Code));
                    //prx($t);
                    $tc_ok = array_column($t, 'tc_id');
                    
                    $inst_id = $tc_ok[0];
                   // prx($tcid);
                   
                  // ###################################################
                   $course_Code = $data[10];

                   $p = $this->Lib_model->Select('urtbl_course_master', '*', array('course_code' => $course_Code));
                 //  prx($p);
                   $crc_ok = array_column($p, 'course_id');
                   
                   $cour_id = $crc_ok[0];
                   //  prx($p);
                  // ###################################################

                     $batch_code = $data[8];                    

                    $x = $this->Lib_model->Select('urtbl_skill_batch', '*', array('batch_code' => $batch_code));
                   
                    $btch_tym = array_column($x, 'end_date');
                    
                    $batch_t = $btch_tym[0];
                    //prx($batch_t);
                    
                    //##################################################
                    
                    if ((empty($inst_id)) OR (empty($cour_id)) OR (empty($batch_t)) OR (!empty($enr_exist))){
                        
                        if (empty($cour_id)){ $meta = 'course not exist' ; } 

                     if (empty($batch_t)){ $meta = 'batch not exist'; }
                    if (empty($inst_id)){ $meta = 'institute not exist'; }

                    if (!empty($enr_exist)){ $meta = 'Duplicate Enrollment'; }
                       
                      // prx('institute');
                        $urt = [
                            'stu_enrollment_no' => $data[0],
                            'stu_phone' => $data[13],
                            'tc_id' => $data[11],
                            'batch_code' =>  $data[8],
                            'tp_id' => $data[9],
                            'course_code' => $data[10],
                            'meta' => $meta,
                            'dump' => $creator,
                        ];
                    $is = $this->Lib_model->Insert('skill_student_dump', $urt);
                    $reject = $r++;
                }
                //prx($data);
                if ((!empty($inst_id)) && (!empty($cour_id)) && (!empty($batch_t)) && (empty($enr_exist))) {

//                     $counter = 0;prx($cour_id);
// foreach ($inst_id as $item) {
         
//       $counter++;      
// }
// $total_count=$counter-1;
                       // prx($data);
                        $urise_user_id =  $this->dashboard_model->generateUriseIdstudent('UR');
                        //prx($urise_user_id);
                        $inst_tbl_urise = [
                            'urise_pre' => 'UR',
                            'urise_id' => $urise_user_id,
                            'mapped_with' => $org_id,
                           
                        ];
                        $tbl_name = 'urtbl_urise';
                        $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                       //prx($isInst);
                        if ($isInst > 0) {
                            $password = 'dacd15e246806c77ed637749bda721430a0cc94b8124dee85743f931510d3e91';
                            $password = hash("sha256", $password);
                            $password = $this->config->item('salt').$password;
                            $password = hash("sha256", $password);
                            $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $urise_user_id,
                                'log_pass' => $password,
                                'log_isdisable' => '1',
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => '4',
                                'status' => 'NA',
                                'dump' => $creator,
                                
                            ];
                            $tbl_name = 'urtbl_skill_login';
                            $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                        }
                        //prx($isInstLogin);
                        if ($isInstLogin > 0) {
                            $dob = date('Y-m-d', strtotime($data[6]));
                            $inst_tbl_stu = [
                                'stu_enroll_no' => $data[0],
                                //'stu_roll_no' => $data[1],
                                'stu_log_id' => $isInstLogin,
                              
                                'stu_aadhar_no' => '',
                                'stu_org_id' => $org_id,
                                'stu_mobile_no' =>  $data[13],
                                //'stu_email_id' =>  $data[17],
                                'stu_first_name' => $data[1],
                                'stu_dob' => date('Y-m-d', strtotime($data[3])),
                               /* 'stu_gender' => 'M',*/
                                'stu_category' => $data[5],
                                'stu_mother_name' => $data[6],
                                'stu_father_name' => $data[7],
                                'stu_religion' =>  $data[12],                         
                               
                                'status' => 0,
                                'stu_urise_id' => $urise_user_id,
                                'dump' => $creator,
                               
                                
                            ];
                        }
                        $tbl_name = 'urtblskill_student';
                       // prx($inst_tbl_stu);
                        $isInstStu = $this->dashboard_model->insertData($tbl_name, $inst_tbl_stu);
                        //prx($isInstStu);
                        
                        
                        if ($isInstStu > 0) {
                            //$inst_id =  $this->dashboard_model->getinstituteIdbycode($data[12], $org_id);
                            $inst_tbl_meta = [
                                'inst_id' => $inst_id,
                                'meta_id' => $isInstStu,
                                'meta_value' => 'new',
                                'relation_pair' => 'ins-stu',
                                'dump' => $creator,
                               
                            ];
                            $tbl_name = 'urtrelskill_stumeta_inst';
                            $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);
                          //  prx($isInstEmp);
                            $student_address = [
                                'sa_student_id' => $isInstStu,
                                'sa_village' => $data[17],
                                'sa_gram_panchayat' => $data[18],
                                'sa_tehsil' => $data[19],
                                'sa_district' => $data[20],
                                'sa_block_town' => $data[21],
                                'sa_pincode' => $data[22],
                                'sa_address' => $data[17],
                                'dump' => $creator,
                               
                            ];
                            $tbl_name = 'urtblskill_student_address';
                            $isstuadress = $this->dashboard_model->insertData($tbl_name, $student_address);
                           // prx($isstuadress);
                            $student_co = [
                                'courseid' => $cour_id,
                                'stud_id' => $isInstStu,
                                'stud_meta_value' => '',
                                'dump' => $creator,
                                
                            ];
                            $tbl_name = 'urelskill_stud_course_meta';
                            $isIns = $this->dashboard_model->insertData($tbl_name, $student_co);
                           
                            
                            $batch_code = $data[8];

                            $z = $this->Lib_model->Select('urtbl_skill_batch', '*', array('batch_code' => $batch_code));
                           // prx($t);
                            $btch_ok = array_column($z, 'batch_id');
                            
                            $batch_id = $btch_ok[0];

                            // insert semester
                            $semarray = [
                                'stud_id' => $isInstStu,
                                'stud_batch' => $batch_id,
                                'dump' => $creator,
                               
                            ];

                            $tbl_name = 'urrelskill_stud_batch_meta';
                            $isInst2 = $this->dashboard_model->insertData($tbl_name, $semarray);
                           // prx($isInst2);
                            // Get course id by course code
                           // $course_code =  $data[13];
                            //$course_id =  $this->dashboard_model->getcourseId($course_code,$orgid);
                            $student_course = [
                                'sei_student_id' => $isInstStu,
                                'sei_course_id' => $cour_id,
                                //'sei_course_id' => $data[23],
                               // 'sei_sector_id' => $data[24],
                                'sei_inst_id' => $inst_id,
                                //'sei_semester' => $data[2],
                                'dump' => $creator,
                                
                            ];
                            $tbl_name = 'urtblskill_student_educational_info';
                            $isInstEmp7 = $this->dashboard_model->insertData($tbl_name, $student_course);
                            
                           // prx($isInstEmp7);
                            $student_personal_details = [
                                'sd_student_id' => $isInstStu,
                                'sd_is_physically_handicapped' => $data[15],
                                'sd_handicapped_type' => $data[16],
                                'dump' => $creator,
                                
                            ];
                            $tbl_name = 'urtblskill_student_details';
                       
                            $isInstEmp11 = $this->dashboard_model->insertData($tbl_name, $student_personal_details);
                            $uploaded = $s++;
                        }
                       // prx($isInstEmp11);
                        $data['count'] = $c++;
                    } /*else {
                        if (empty($cour_id)){ $meta = 'course not exist' ;
                        }              
                     if (empty($batch_t)){ $meta = 'batch not exist';
                          }
                    if (empty($inst_id)){ $meta = 'institute not exist';}
                       
                      // prx('institute');
                        $urt = [
                            'stu_enrollment_no' => $data[0],
                            'stu_phone' => $data[13],
                            'tc_id' => $data[11],
                            'batch_code' =>  $data[8],
                            'tp_id' => $data[9],
                            'course_code' => $data[10],
                            'meta' => $meta,
                        ];
                    $is = $this->Lib_model->Insert('skill_student_dump', $urt);
                        }*/
                }
                $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
               // $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadskillStudent');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadskillStudent');
            }
        }
    }

    public function uploadskillBatch()
    {
        $this->checkPermission();
        // $sess_data = (array) getsessdata('user');
        // prx($sess_data);
        $this->load->view('includes/common_header');
        $this->load->view('upload-skill-batch-exel');
        $this->load->view('includes/common_footer');
    }
    

    public function uploadSkillBatchDataExcel()
    {
       $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                
                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $inst = [];
                $s = 1;
                $r = 1 ;               
                $created_by = $this->input->post('created_by');
                foreach ($readData as $data) {
                   /// prx($data);


                    if (empty($data[9])) {
                        //$data[9] =  $this->dashboard_model->generateUriseId('TP');
                        //prx($data[9]);
                    }

                    $batch_Exist =	$data[1];

                $t = $this->Lib_model->Select('urtbl_skill_batch', '*', array('batch_code' => $batch_Exist));
               
                $batch_present = array_column($t, 'batch_code');
                $batch_present = $batch_present[0];
               // PRX($batch_present);
                if(!empty($batch_present)){
                    
                    $btch = [
                        'batch_code' => $data[1],
                        'end_date ' => $data[4],                        
                        'reason' => 'batch exist',
                        'meta' =>  $created_by,

                    ];
                $is = $this->Lib_model->Insert('Skill_batch_dump', $btch);
                $reject = $r++;

                }
                    if(empty($batch_present)){

                    $batch = [
                            'enroll_year' => $data[0],
                            'batch_code' => $data[1],
                            'total_enrollment' => $data[2],
                            'start_date' => $data[3],
                            'end_date ' => $data[4],
                            'start_time ' => $data[5],
                            'end_time ' => $data[6],
                            'Batch_tenure' =>$data[7],
                            'meta_value' =>  $created_by,

                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_skill_batch';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $batch);
                    $pass = '1234';
                    $uploaded = $s++;
                    }
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];

                    //prx($inst_tbl_meta);
                    $data['count'] = $c++;
                }

                $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
                redirect('user/dashboard/uploadskillBatch');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadskillBatch');
            }
        }
    }


    public function uploadskillBatchTcMap()
    {
        $this->checkPermission();
        // $sess_data = (array) getsessdata('user');
        // prx($sess_data);
        $this->load->view('includes/common_header');
        $this->load->view('upload-skill-batch-Tc-Map-exel');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillBatchTcMapDataExcel()
    {
       $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $s = 1;
                $r = 1;
                $inst = [];
                $created_by = $this->input->post('created_by');
                foreach ($readData as $data) {
                //prx($data);
                                  
                $b = $this->Lib_model->Select('urtbl_skill_batch', '*', array('batch_code' => $batch_Code));
                
                $tc_Code =	$data[1];

                $t = $this->Lib_model->Select('urtbl_skill_training_center', '*', array('tc_code' => $tc_Code));
               // prx($t);
                $tc_ok = array_column($t, 'tc_id');
                
                $tcid = $tc_ok[0];
               // prx($tcid);
               $batch_Code =	$data[0];
              





                if (empty($tcid)){
                    $meta = 'TC not exist'; 
                   
                    $urtrel = [
                        'institute_id' => $tc_Code,
                        'batch_id' => $batch_Code,
                        'reason' => $meta,
                        'meta' => $created_by,
                    ];
                $is = $this->Lib_model->Insert('skill_batch_institute_dump', $urtrel);
                $reject = $r++;
                }
                if  (!empty($tcid)){
     ////////////////////////////////
                           
                $batch_Code =	$data[0];
                    
                $b = $this->Lib_model->Select('urtbl_skill_batch', '*', array('batch_code' => $batch_Code));
                
                $batch_ok = array_column($b, 'batch_id');
                //prx($Tp_id[0]);
                $batchid = $batch_ok[0];
                //prx($b);
                
                if (empty($batchid)){
                    $meta = 'Batch not exist';
                    $urtrel_primary = [
                        'institute_id' => $tc_Code,
                        'batch_id' => $batch_Code,
                        'reason' => $meta,
                        'meta' => $created_by,
                    ];
                $isInst = $this->Lib_model->Insert('skill_batch_institute_dump', $urtrel_primary);
                $reject = $r++;
                }
                if (!empty($batchid)){

                    $k = $this->Lib_model->Select('urtbl_skill_batch_center_map', '*', array('batch_id ' => $batchid));
                
                $batchmapex = array_column($k, 'batch_id');
                //prx($Tp_id[0]);
                $batchmapexi = $batchmapex[0];
                if (!empty($batchmapexi)){
                    $meta = 'Batch mapping  exist';
                    $urtrel_primary = [
                        'institute_id' => $tc_Code,
                        'batch_id' => $batch_Code,
                        'reason' => $meta,
                        'meta' => $created_by,
                    ];
                $isInst = $this->Lib_model->Insert('skill_batch_institute_dump', $urtrel_primary);
                $reject = $r++;
                }
                
                if (empty($batchmapexi)) {
                    if (empty($data[9])) {
                       // $data[9] =  $this->dashboard_model->generateUriseId('TP');
                        //prx($data[9]);
                    }

                    $batchmap = [
                            'batch_id' => $batchid,
                            'center_id' => $tcid,
                            'meta_value' => $created_by,
                          ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_skill_batch_center_map';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $batchmap);
                    $pass = '1234';
                    $uploaded = $s++;
                   // prx($uploaded);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                        
                    //prx($inst_tbl_meta);
                    $data['count'] = $c++;
                }}}}

                              
$this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');

                redirect('user/dashboard/uploadskillBatchTcMap');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadskillBatchTcMap');
            }
        }
    }


    public function countdate()
    {
        $this->checkPermission();
        $b = $this->Lib_model->Select('urtbl_skill_batch', '*', array());
        //start_date
        $d =  $b[0]->start_date . '^^^^^^^^^' . $b[0]->end_date  ;
        prx(date('d-m-Y')); 
        $strt = $b[0]->start_date;
        $last = $b[0]->end_date ; 
        // or your date as well
$start = date_create($strt);

$end = date_create($last);
$d = date_diff($start, $end);
$d = $d->format('Difference between two dates: %R%a days');
//$d = $d->format('%a');
         prx($d);        
    }

    public function uploadSkillVideos()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillvideos');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillVideosExcel()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $s = 1;
                $r = 1;                
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);
                    if (empty($data[9])) {
                        //$data[9] =  $this->dashboard_model->generateUriseId('TP');
                        //prx($data[9]);
                    }

                    $course_Code = $data[6];

                    $p = $this->Lib_model->Select('urtbl_course_master', '*', array('course_code' => $course_Code));
                  //  prx($p);
                    $crc_ok = array_column($p, 'course_id');
                    
                    $cour_id = $crc_ok[0];
                    $title = $data[1];
                    $title_ex = $this->Lib_model->Select('urtbl_skill_video_lectures_org', '*', array('topic_title' => $title));
                    $title_exist = array_column($title_ex, 'topic_title');
                    $title_exist =  $title_exist[0];
                   // prx($title_exist);
                if ((empty($title)) OR (empty($cour_id)) OR (!empty($title_exist))){                        
                       
                    if (empty($cour_id)){ $meta = 'Course not exist'; }
                    if (empty($title)){ $meta = 'Empty Title  field'; }
                    if (!empty($title_exist)){ $meta = ' Title Exist'; }
                       
                      
                        $urt = [
                            'course_title' => $data[1],
                            'course_code' => $data[6],
                            'meta' => $meta,
                        ];
                        //prx($urt);
                    $is = $this->Lib_model->Insert('skill_video_dump', $urt);
                    $reject = $r++;
                    //prx($title_exist);
                }
                //prx($data);
                if ((!empty($title)) && (!empty($cour_id)) && (empty($title_exist))){

                    $inst_tbl_urise = [
                            'topic_title' => $data[1],
                            //'file_name' => $data[3],
                            'urise_youtube_link' => $data[3],
                            'org_id' => '1',
                            'course_id' => $cour_id,
                            'recorded_by' => 'urise',
                            'approved_status' => '1',
                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_skill_video_lectures_org';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    $uploaded = $s++;
                     }
                    $data['count'] = $c++;
                }
                    //prx($isInst);
        $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
             
                    redirect('user/dashboard/uploadSkillVideos');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillVideos');
            }
        }
    }


    public function uploadSkillEcontent()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillecontent');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillEcontentExcel()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $s = 1;
                $r = 1;                
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);
                    if (empty($data[9])) {
                        //$data[9] =  $this->dashboard_model->generateUriseId('TP');
                        //prx($data[9]);
                    }

                    $course_Code = $data[6];

                    $p = $this->Lib_model->Select('urtbl_course_master', '*', array('course_code' => $course_Code));
                  //  prx($p);
                    $crc_ok = array_column($p, 'course_id');
                    
                    $cour_id = $crc_ok[0];
                    $title = $data[1];
                    $title_ex = $this->Lib_model->Select('urtbl_skill_e_content_org', '*', array('topic_title' => $title));
                    $title_exist = array_column($title_ex, 'topic_title');
                    $title_exist =  $title_exist[0];
                   // prx($title_exist);
                   
                if ((empty($title)) OR (empty($cour_id)) OR (!empty($title_exist))){                        
                       //prx($nolink);
                    if (empty($cour_id)){ $meta = 'Course not exist'; }
                    if (empty($title)){ $meta = 'Empty Title  field'; }
                    if (!empty($title_exist)){ $meta = ' Title Exist'; }
                    if (!empty($nolink)){ $meta = ' video Exist'; }
                       
                      
                        $urt = [
                            'course_title' => $data[1],
                            'course_code' => $data[6],
                            'meta' => $meta,
                        ];
                        //prx($urt);
                    $is = $this->Lib_model->Insert('skill_econtent_dump', $urt);
                    $reject = $r++;
                    //prx($title_exist);
                }
                //prx($data);
                if ((!empty($title)) && (!empty($cour_id)) && (empty($title_exist)) &&  (empty($nolink))){

                    $inst_tbl_urise = [
                            'topic_title' => $data[1],
                            'file_name' => $data[3],
                           // 'urise_youtube_link' => $data[4],
                            'org_id' => '1',
                            'course_id' => $cour_id,
                            'recorded_by' => 'urise',
                            'approved_status' => '1',
                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_skill_e_content_org';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    $uploaded = $s++;
                     }
                    $data['count'] = $c++;
                }
                    //prx($isInst);
        $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
             
                    redirect('user/dashboard/uploadSkillEcontent');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillEcontent');
            }
        }
    }




    public function uploadSkillTpSectorMapping()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillTpSectorMapping');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillTpSectorMappingExcel()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $meta_id = $this->input->post('meta');
       
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $s = 1;
                $re == 1;                
                $inst = [];
                foreach ($readData as $data) {
                    
                    //prx($data);
                    if (empty($data[9])) {
                        //$data[9] =  $this->dashboard_model->generateUriseId('TP');
                        //prx($data[9]);
                    }

                    $npm_sector = $data[1];

                    $p = $this->Lib_model->Select('urtbl_sector', '*', array('nopmkvy' => $npm_sector));
                  
                    $sec_ok = array_column($p, 'sector_id');
                    
                    $sector_exist = $sec_ok[0];


                    $tp_code = $data[0];

                    $q = $this->Lib_model->Select('urtbl_skill_TPmaster', '*', array('TP_code' => $tp_code));
                  
                    $tp_ok = array_column($q, 'TP_Id');
                    
                    $tp_exist = $tp_ok[0];
                    
                    $r = $this->Lib_model->Select('urtbl_skill_tp_sector', '*', array('tp_id' => $tp_exist));
                    $tp_map_ok = array_column($r, 'tp_id');
                    
                    $tp_map_exist = $tp_map_ok[0];
                      //prx($tp_map_exist);
                    
                   // prx($title_exist);
                   
                if ((empty($sector_exist)) OR (empty($tp_exist)) OR (!empty($tp_map_exist))){                        
                       //prx($nolink);
                    if (empty($sector_exist)){ $meta = 'sector not exist'; }
                    if (empty($tp_exist)){ $meta = 'TP not exist'; }
                    if (!empty($tp_map_exist)){ $meta = ' Mapping Exist'; }
                    
                       
                      
                        $urt = [
                            'tp_code' => $data[0],
                            'sector_code' => $data[1],
                            'reason' => $meta,
                            'meta' => $meta_id,
                        ];
                       
                    $is = $this->Lib_model->Insert('tp_sector_map_dump', $urt);
                    $rejected = $re++;
                    
                }
                
                if ((!empty($sector_exist)) && (!empty($tp_exist)) && (empty($tp_map_exist))){

                    $inst_tbl_urise = [
                            'tp_id' =>  $tp_exist,
                            'sector_id' => $sector_exist,
                           // 'urise_youtube_link' => $data[4],
                            'meta_value' => $meta_id,
                            
                        ];
                    $tbl_name = 'urtbl_skill_tp_sector';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    $uploaded = $s++;
                     }
                    $data['count'] = $c++;
                }
                   
        $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $rejected . '  ' . ' Entries Rejected');
             
                    redirect('user/dashboard/uploadSkillTpSectorMapping');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillTpSectorMapping');
            }
        }
    }



    public function AnimeshUploadSkillStuDataExcel()
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $org_id = 1;// $sess_data['org_id'];
        $role_id = 5;
        $relation_pair = 0;
        $file = $_FILES['excel_file'];
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                $c = 0;
                $s = 1;
                $r = 1;
                $creator = $this->input->post('created_by');
                $inst = [];
                foreach ($readData as $data) {
                       prx($data);              
                    
                    $enroll_exist = $data[0];
                    //'stu_enroll_no' => $data[0]

                    $e_exist = $this->Lib_model->Select('urtblskill_student', '*', array('stu_enroll_no' => $enroll_exist));
                    
                    $e_ex = array_column($e_exist, 'stu_enroll_no');
                    
                    $enr_exist = $e_ex[0];

                  //  #################################3
                 
                    $tc_Code = $data[11];

                    $t = $this->Lib_model->Select('urtbl_skill_training_center', '*', array('tc_code' => $tc_Code));
                    
                    $tc_ok = array_column($t, 'tc_id');
                    
                    $inst_id = $tc_ok[0];
                   // prx($tcid);
                   
                  // ###################################################
                   $course_Code = $data[10];

                   $p = $this->Lib_model->Select('urtbl_course_master', '*', array('course_code' => $course_Code));
                 //  prx($p);
                   $crc_ok = array_column($p, 'course_id');
                   
                   $cour_id = $crc_ok[0];
                   //  prx($p);
                  // ###################################################

                     $batch_code = $data[8];                    

                    $x = $this->Lib_model->Select('urtbl_skill_batch', '*', array('batch_code' => $batch_code));
                   
                    $btch_tym = array_column($x, 'end_date');
                    
                    $batch_t = $btch_tym[0];
                    //prx($batch_t);
                    
                    //##################################################
                    
                    if ((empty($inst_id)) OR (empty($cour_id)) OR (empty($batch_t)) OR (!empty($enr_exist))){
                        
                        if (empty($cour_id)){ $meta = 'course not exist' ; } 

                     if (empty($batch_t)){ $meta = 'batch not exist'; }
                    if (empty($inst_id)){ $meta = 'institute not exist'; }

                    if (!empty($enr_exist)){ $meta = 'Duplicate Enrollment'; }
                       
                      // prx('institute');
                        $urt = [
                            'stu_enrollment_no' => $data[0],
                            'stu_phone' => $data[13],
                            'tc_id' => $data[11],
                            'batch_code' =>  $data[8],
                            'tp_id' => $data[9],
                            'course_code' => $data[10],
                            'meta' => $meta,
                            'dump' => $creator,
                        ];
                    $is = $this->Lib_model->Insert('skill_student_dump', $urt);
                    $reject = $r++;
                }
                //prx($data);
                if ((!empty($inst_id)) && (!empty($cour_id)) && (!empty($batch_t)) && (empty($enr_exist))) {


                       // prx($data);
                        $urise_user_id =  $this->dashboard_model->generateUriseIdstudent('UR');
                        //prx($urise_user_id);
                        $inst_tbl_urise = [
                            'urise_pre' => 'UR',
                            'urise_id' => $urise_user_id,
                            'mapped_with' => $org_id,
                            'dump' => $creator,
                        ];
                        $tbl_name = 'urtbl_urise';
                        $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                       //prx($isInst);
                        if ($isInst > 0) {
                            $password = 'dacd15e246806c77ed637749bda721430a0cc94b8124dee85743f931510d3e91';
                            $password = hash("sha256", $password);
                            $password = $this->config->item('salt').$password;
                            $password = hash("sha256", $password);
                            $inst_tbl_login = [
                                'role_id' => $role_id,
                                'log_authid' => $urise_user_id,
                                'log_pass' => $password,
                                'log_isdisable' => '1',
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => '4',
                                'status' => 'NA',
                                'dump' => $creator,
                            ];
                            $tbl_name = 'urtbl_skill_login';
                            $isInstLogin = $this->dashboard_model->insertData($tbl_name, $inst_tbl_login);
                        }
                        //prx($isInstLogin);
                        if ($isInstLogin > 0) {
                            $dob = date('Y-m-d', strtotime($data[6]));
                            $inst_tbl_stu = [
                                'stu_enroll_no' => $data[0],
                                //'stu_roll_no' => $data[1],
                                'stu_log_id' => $isInstLogin,
                              
                                'stu_aadhar_no' => '',
                                'stu_org_id' => $org_id,
                                'stu_mobile_no' =>  $data[13],
                                //'stu_email_id' =>  $data[17],
                                'stu_first_name' => $data[1],
                                'stu_dob' => date('Y-m-d', strtotime($data[3])),
                               /* 'stu_gender' => 'M',*/
                                'stu_category' => $data[5],
                                'stu_mother_name' => $data[6],
                                'stu_father_name' => $data[7],
                                'stu_religion' =>  $data[12],                         
                               
                                'status' => 0,
                                'stu_urise_id' => $urise_user_id,
                                'dump' => $creator,
                                
                            ];
                        }
                        $tbl_name = 'urtblskill_student';
                       // prx($inst_tbl_stu);
                        $isInstStu = $this->dashboard_model->insertData($tbl_name, $inst_tbl_stu);
                        //prx($isInstStu);
                        
                        
                        if ($isInstStu > 0) {
                            //$inst_id =  $this->dashboard_model->getinstituteIdbycode($data[12], $org_id);
                            $inst_tbl_meta = [
                                'inst_id' => $inst_id,
                                'meta_id' => $isInstStu,
                                'meta_value' => 'new',
                                'relation_pair' => 'ins-stu',
                                'dump' => $creator,
                            ];
                            $tbl_name = 'urtrelskill_stumeta_inst';
                            $isInstEmp = $this->dashboard_model->insertData($tbl_name, $inst_tbl_meta);
                          //  prx($isInstEmp);
                            $student_address = [
                                'sa_student_id' => $isInstStu,
                                'sa_village' => $data[17],
                                'sa_gram_panchayat' => $data[18],
                                'sa_tehsil' => $data[19],
                                'sa_district' => $data[20],
                                'sa_block_town' => $data[21],
                                'sa_pincode' => $data[22],
                                'sa_address' => $data[17],
                                'dump' => $creator,
                            ];
                            $tbl_name = 'urtblskill_student_address';
                            $isstuadress = $this->dashboard_model->insertData($tbl_name, $student_address);
                           // prx($isstuadress);
                            $student_co = [
                                'courseid' => $cour_id,
                                'stud_id' => $isInstStu,
                                'stud_meta_value' => '',
                                'dump' => $creator,
                            ];
                            $tbl_name = 'urelskill_stud_course_meta';
                            $isIns = $this->dashboard_model->insertData($tbl_name, $student_co);
                           
                            
                            $batch_code = $data[8];

                            $z = $this->Lib_model->Select('urtbl_skill_batch', '*', array('batch_code' => $batch_code));
                           // prx($t);
                            $btch_ok = array_column($z, 'batch_id');
                            
                            $batch_id = $btch_ok[0];

                            // insert semester
                            $semarray = [
                                'stud_id' => $isInstStu,
                                'stud_batch' => $batch_id,
                                'dump' => $creator,
                            ];

                            $tbl_name = 'urrelskill_stud_batch_meta';
                            $isInst2 = $this->dashboard_model->insertData($tbl_name, $semarray);
                           // prx($isInst2);
                            // Get course id by course code
                           // $course_code =  $data[13];
                            //$course_id =  $this->dashboard_model->getcourseId($course_code,$orgid);
                            $student_course = [
                                'sei_student_id' => $isInstStu,
                                'sei_course_id' => $cour_id,
                                //'sei_course_id' => $data[23],
                               // 'sei_sector_id' => $data[24],
                                'sei_inst_id' => $inst_id,
                                //'sei_semester' => $data[2],
                                'dump' => $creator,
                            ];
                            $tbl_name = 'urtblskill_student_educational_info';
                            $isInstEmp7 = $this->dashboard_model->insertData($tbl_name, $student_course);
                            
                           // prx($isInstEmp7);
                            $student_personal_details = [
                                'sd_student_id' => $isInstStu,
                                'sd_is_physically_handicapped' => $data[15],
                                'sd_handicapped_type' => $data[16],
                                'dump' => $creator,
                            ];
                            $tbl_name = 'urtblskill_student_details';
                       
                            $isInstEmp11 = $this->dashboard_model->insertData($tbl_name, $student_personal_details);
                            $uploaded = $s++;
                        }
                       // prx($isInstEmp11);
                        $data['count'] = $c++;
                    } /*else {
                        if (empty($cour_id)){ $meta = 'course not exist' ;
                        }              
                     if (empty($batch_t)){ $meta = 'batch not exist';
                          }
                    if (empty($inst_id)){ $meta = 'institute not exist';}
                       
                      // prx('institute');
                        $urt = [
                            'stu_enrollment_no' => $data[0],
                            'stu_phone' => $data[13],
                            'tc_id' => $data[11],
                            'batch_code' =>  $data[8],
                            'tp_id' => $data[9],
                            'course_code' => $data[10],
                            'meta' => $meta,
                        ];
                    $is = $this->Lib_model->Insert('skill_student_dump', $urt);
                        }*/
                }
                $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
               // $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('user/dashboard/uploadskillStudent');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadskillStudent');
            }
        }
    }



    public function dumpdetails()
    {
        $this->checkPermission();
        // $sess_data = (array) getsessdata('user');
        // prx($sess_data);
      
        $this->load->view('includes/common_header');
        $this->load->view('dumpdetails');
        $this->load->view('includes/common_footer');
    }

    public function dumpdetailsprint()
    {
        $this->checkPermission();
        // $sess_data = (array) getsessdata('user');
        // prx($sess_data);
        $id = $this->input->post('identity');

        $dump = $this->Lib_model->Select('Skill_batch_dump', '*', array('meta' => $id));
        
        $dump2 = $this->Lib_model->Select('skill_batch_institute_dump', '*', array('meta_value' => $id));
        
       // $dump3 = $this->Lib_model->Select('skill_student_dump', '*', array('meta_value' => $id));
       $dump3 = $this->Lib_model->Select('skill_student_dump', '*', array('dump' => $id));
       
       $dump4 = $this->Lib_model->Select('Skill_tc_dump', '*', array('meta' => $id));
       
        if(!empty($dump))
        {
        prx($dump);
        }
        if(!empty($dump2))
        {
        prx($dump2);
        }
        if(!empty($dump3))
        {
        prx($dump3);
        }
        if(!empty($dump4))
        {
        prx($dump4);
        }
        $this->load->view('includes/common_header');
        $this->load->view('dumpdetails');
        $this->load->view('includes/common_footer');
    }
    public function uploadSkillDdugkySector()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillDdugkySector');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillDdugkySectortExcel()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $s = 1;
                $r = 1;                
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);
                    if (empty($data[9])) {
                        //$data[9] =  $this->dashboard_model->generateUriseId('TP');
                    }$check = $data[1] ;
                    if (!empty($check)){

                    $inst_tbl_urise = [
                        'org_id ' => '1',
                        'ddugky' => $data[0],
                      // 'tbl_relation' => 1234,
                        'sector_name' => $data[1],
                      // 'created_by ' => '999', 
                        ];
                   
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_sector';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    $uploaded = $s++;
                     }
                     if (empty($isInst)){                        
                        $reject = $r++;
                  }
                    $data['count'] = $c++;
                }
                    //prx($isInst);
        $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
             
                    redirect('user/dashboard/uploadSkillDdugkySector');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillDdugkySector');
            }
        }
    }


    public function uploadSkillDdkvyCourse()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillDdkvyCourse');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillDdkvyCourseExcel()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 4;
            $desig_id = 7;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $r = 1;
                $s = 1;
                $inst = [];
                foreach ($readData as $data) {
                    //prx($data);


                    if (empty($data[15])) {
                        $data[15] =  $this->dashboard_model->generateUriseId('AD');
                        //prx($data[9]);
                    }

                    $sector =	$data[2];

                    $rs = $this->Lib_model->Select('urtbl_sector', 'sector_id', array('ddugky'=>  $sector));
                    $r = json_decode(json_encode($rs[0]), true);
                  //  prx($r['sector_id']) ;
                    $sc = $r['sector_id'] ;

                    if(!empty($sc)){
                    $inst_tbl = [
                                            'course_code' =>$data[3],
                                            'course_name' => $data[4],
                                            'org_id' => 1,
                                            'course_category' => 'DDMKY',
                                            'duration_type' => 'hourly',//$data[5],
                                            'duration' => $data[10],
                                            'sector_id' => $sc,
                                            'updated_by' => '214'                                                                             
                                        ];
                    $tbl_name = 'urtbl_course_master';
                    //prx($inst_tbl);
                    $is = $this->dashboard_model->insertData($tbl_name, $inst_tbl);
                   

                    $uploaded = $s++;
                }
                if (empty($is)){                        
                   $reject = $r++;
                        }                                   
                    $data['count'] = $c++;
                    //prx($inst_tbl);
                }

        $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $reject . '  ' . ' Entries Rejected');
        
                redirect('user/dashboard/uploadSkillDdkvyCourse');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillDdkvyCourse');
            }
        }
    }


    public function uploadSkillDdkvyTpSectorMapping()
    {
        $this->checkPermission();
        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillDdkvyTpSectorMapping');
        $this->load->view('includes/common_footer');
    }

    public function uploadSkillDdkvyTpSectorMappingExcel()
    //for tc training centers
    {
        $this->checkPermission();
        $sess_data = (array) getsessdata('user');
        $meta_id = $this->input->post('meta');
       
        $current_role = $sess_data['role_id'];
        $current_role = '1';
        if ($current_role == 1) {
            $role_id = 3;
            $desig_id = 6;
            $relation_pair = '';
            // $relation_pair = 'ins-tu';
            $org_id = 1;
        }
        $file = $_FILES['excel_file'];
        //prx($file);
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/files/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/files/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();

                //prx($objPHPExcel);
                $highestColumn = $sheet->getHighestColumn();
                //prx($highestColumn);
                $readData = $sheet->rangeToArray('A2:' . $highestColumn . $highestRow);
                //prx($readData);
                $c = 0;
                $s = 1;
                $re == 1;                
                $inst = [];
                foreach ($readData as $data) {
                    
                    //prx($data);
                    if (empty($data[9])) {
                        //$data[9] =  $this->dashboard_model->generateUriseId('TP');
                        //prx($data[9]);
                    }

                    $npm_sector = $data[1];

                    $p = $this->Lib_model->Select('urtbl_sector', '*', array('ddugky' => $npm_sector));
                  
                    $sec_ok = array_column($p, 'sector_id');
                    
                    $sector_exist = $sec_ok[0];
                   // prx($sector_exist);

                    $tp_code = $data[0];

                    $q = $this->Lib_model->Select('urtbl_skill_TPmaster', '*', array('TP_code' => $tp_code));
                  
                    $tp_ok = array_column($q, 'TP_Id');
                    
                    $tp_exist = $tp_ok[0];
                    
                    $r = $this->Lib_model->Select('urtbl_skill_tp_sector', '*', array('tp_id' => $tp_exist));
                    $tp_map_ok = array_column($r, 'tp_id');
                    
                    $tp_map_exist = $tp_map_ok[0];
                      //prx($tp_map_exist);
                    
                   // prx($title_exist);
                   
                if ((empty($sector_exist)) OR (empty($tp_exist)) OR (!empty($tp_map_exist))){                        
                       //prx($nolink);
                    if (empty($sector_exist)){ $meta = 'sector not exist'; }
                    if (empty($tp_exist)){ $meta = 'TP not exist'; }
                    if (!empty($tp_map_exist)){ $meta = ' Mapping Exist'; }
                    
                       
                      
                        $urt = [
                            'tp_code' => $data[0],
                            'sector_code' => $data[1],
                            'reason' => $meta,
                            'meta' => $meta_id,
                        ];
                        //prx($urt);
                    $is = $this->Lib_model->Insert('tp_sector_map_dump', $urt);
                    $rejected = $re++;
                    //prx($title_exist);
                }
                //prx($data);
                if ((!empty($sector_exist)) && (!empty($tp_exist)) && (empty($tp_map_exist))){

                    $inst_tbl_urise = [
                            'tp_id' =>  $tp_exist,
                            'sector_id' => $sector_exist,
                           // 'urise_youtube_link' => $data[4],
                            'meta_value' => $meta_id,
                            
                        ];
                    //prx($inst_tbl_urise);
                    // $inst[] = ['er_employee_id' => $data[0],'er_inst_id'=> $data[1],'er_course_id'=> $data[2],'er_designation'=>$data[3],'er_employee_name'=> $data[4],'er_employee_email'=>$data[5],'er_mobile' => $data[6],'er_district_id'=>$data[7]];
                    $tbl_name = 'urtbl_skill_tp_sector';
                    $isInst = $this->dashboard_model->insertData($tbl_name, $inst_tbl_urise);
                    $pass = '1234';
                    $uploaded = $s++;
                     }
                    $data['count'] = $c++;
                }
                    //prx($rejected);
        $this->session->set_flashdata('success', $uploaded . '  '.'Information saved successfully and ' . $rejected . '  ' . ' Entries Rejected');
             
                    redirect('user/dashboard/uploadSkillTpSectorMapping');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('user/dashboard/uploadSkillTpSectorMapping');
            }
        }
    }
    public function opensourceVideo()
    {
        $this->checkPermission();
        $user = getsessdata('user');        
        $org_id = $user->org_id;      
        $data['totalcourse'] = $this->dashboard_model->getCourse($org_id);
        $datas=[
            'org_id'=>$org_id,
            'limit'=> $this->perPage,            
          ];
          $data['totalvideos'] = $this->dashboard_model->outsourcevideo(array('org_id'=>$org_id));
          $data['videoView'] = $this->dashboard_model->outsourcevideo($datas);
          $totalRec = count($data['totalvideos']);
        $config['target']      = '#videotest';
        $config['base_url']    = base_url().'dashboard/ajax_opensourceVideo';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        $this->load->view('includes/common_header');
        $this->load->view('user/outsource_video',$data);
        $this->load->view('includes/common_footer');
    }
    public function ajax_opensourceVideo()
    {
        $this->checkPermission();
        $user = getsessdata('user');        
        $org_id = $user->org_id;      
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $returnRes['csrf_token'] = $this->security->get_csrf_hash();
        $topic = isset($_POST['topic']) ? $_POST['topic'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : '';
        $faculty_name = isset($_POST['faculty_name']) ? $_POST['faculty_name'] : '';
        $model = array(
            'topic' => $topic,
            'course' => $course,
      'faculty_name' => $faculty_name,
      'org_id'=>$org_id
    );
    $returnRes['totalvideos'] = $this->dashboard_model->outsourcevideo($model);
        $totalRec = count($returnRes['totalvideos']);


        $config['target']      = '#videotest';
        $config['base_url']    = base_url().'dashboard/ajax_opensourceVideo';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';

        $this->ajax_pagination->initialize($config);

        $returnRes['videoView'] = $this->dashboard_model->outsourcevideo(array('org_id'=>$org_id,'start' => $offset, 'limit' => $this->perPage,'topic' => $topic,'course' => $course,'faculty_name' => $faculty_name));
        $returnRes['pagi'] = $this->ajax_pagination->create_links();


        // $response['html_res']=$html;
        // exit(json_encode($response));
        $this->load->view('user/ajax_opensourceVideo', $returnRes, false);
       
    }
    public function encrypt($key, $iv, $data) {
        if (strlen($key) < $this->CIPHER_KEY_LEN) {
            $key = str_pad("$key", $this->CIPHER_KEY_LEN, "0"); //0 pad to len 16
        } else if (strlen($key) > $this->CIPHER_KEY_LEN) {
            $key = $key;
        }
        
        $encodedEncryptedData = base64_encode(openssl_encrypt($data, $this->OPENSSL_CIPHER_NAME, $key, OPENSSL_RAW_DATA, $iv));
        $encryptedPayload = $encodedEncryptedData;

        return $encryptedPayload;
        
    }
    public function decrypt($key, $data, $iv) {
        if (strlen($key) < $this->CIPHER_KEY_LEN) {
            $key = str_pad("$key", $this->CIPHER_KEY_LEN, "0"); //0 pad to len 16
        } else if (strlen($key) > $this->CIPHER_KEY_LEN) {
            $key = $key;
        }

        $decryptedData = openssl_decrypt(base64_decode($data), $this->OPENSSL_CIPHER_NAME, $key, OPENSSL_RAW_DATA, $iv);
        
        return $decryptedData;
    }
    public function paymenttest()
    {         
        header('Content-Type:text/html; charset=UTF-8');   
        //$OPENSSL_CIPHER_NAME = "AES-128-CBC"; //Name of OpenSSL Cipher 
        //$CIPHER_KEY_LEN = 16; //128 bits
           
    
        
        //$key = 'bfic5MhLJHLnDdCDBxjFEYrTP2lMyFHdJuK27YE1NB4=';
        $key = 'A7C9F96EEE0602A61F184F4F1B92F0566B9E61D98059729EAD3229F882E81C3A';
        $iv = substr($key, 0, 16);
        
        $requestParameter  = "1000112|DOM|IN|INR|31|Other|https://urise.up.gov.in/user/dashboard/paymentsuccess|https://urise.up.gov.in/user/dashboard/paymentfail|SBIEPAY|FjkUi|FjkUi|CASH|ONLINE|ONLINE";
        echo '<b>Requestparameter:-</b> '.$requestParameter.'<br/><br/>';
        $EncryptTrans  = $this->encrypt($key, $iv, $requestParameter);
        
        //Billingdetails
        $billingDtls ="Biller|Mumbai|Maharastra|403706|India|+91|222|1234567|9812345678||N";
        echo '<b>Billingdetails:-</b> '.$billingDtls.'<br/><br/>';
        $EncryptbillingDetails =  $this->encrypt($key, $iv, $billingDtls);
        
        //Shippingdetails
        $shippingDtls ="Shipper|Mayuresh Enclave,Sector 20,Plat A-211,Nerul,Navi-Mumbai,403706|Mumbai|Maharastra|India|403706|+91|222|30988373|9812345678|N";
        echo '<b>Shippingdetails:-</b> '.$shippingDtls.'<br/><br/>';
        $EncryptshippingDetais =  $this->encrypt($key, $iv, $shippingDtls);
        
        //Paymentdetails
        $PaymentDtls="NA|NA|NA|NA|NA|NA|NA|NA|NA";
        echo '<b>Paymentdetails:-</b> '.$PaymentDtls.'<br/><br/>';
        $EncryptpaymentDetails =   $this->encrypt($key, $iv, $PaymentDtls);
        
        
        echo '<b>Encrypted EncryptTrans:-</b>'.$EncryptTrans.'<br/><br/>';
        echo '<b>Encrypted EncryptbillingDetails:-</b> '.$EncryptbillingDetails.'<br/><br/>';
        echo '<b>Encrypted EncryptshippingDetais:-</b>'.$EncryptshippingDetais.'<br/><br/>';
        echo '<b>Encrypted EncryptpaymentDetails:-</b>'.$EncryptpaymentDetails.'<br/><br/>';
        echo "<br/>Action URL:https://merchant.timesofmoney.in/secure/AggregatorHostedListener".'<br/><br/>'; 
        
       echo '
        <form name="ecom" method="post" action="https://test.sbiepay.com/secure/AggregatorHostedListener">
        <!-- <form name="ecom" method="post" action="https://test.sbiepay.sbi"> -->
            <input type="hidden" name="EncryptTrans" value="<?php echo $EncryptTrans; ?>">
            <!-- <input type="hidden" name="EncryptbillingDetails" value="<?php echo $EncryptbillingDetails; ?>">
            <input type="hidden" name="EncryptshippingDetais" value="<?php echo $EncryptshippingDetais; ?>"> 
            <input type="hidden" name="EncryptpaymentDetails" value="<?php echo $EncryptpaymentDetails; ?>">-->
            <input type="hidden" name="merchIdVal" value ="1000112"/>
            <input type="submit" name="submit" value="Submit">
        </form>';
        
        

        // $this->load->view('includes/common_header');
        // $this->load->view('upload-skill-student-exel');
        // $this->load->view('includes/common_footer');
    }
    public function paymentsuccess(){
        echo 'Payment successfully Done !';
    }
    public function paymentfail(){
       echo 'Payment Failed !';
    }
   

    public function kibanaRegStu(){
        //$allregstu = $this->Lib_model->Select('urtbl_login', 'log_isdisable', array('log_isdisable' => 0,'role_id'=> 5));
        $allregstu = $this->Lib_model->Counter('urtbl_login', array('log_isdisable' => 0,'role_id'=> 5));
       // $count = 
        prx($allregstu);
    }


}
