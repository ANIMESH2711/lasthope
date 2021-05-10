<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


if (!function_exists('email_token_checker')) {
    function email_token_checker($token)
    {
        $CI = &get_instance();
        $CI->db->from('ur_super_users');
        $CI->db->where('isEmailToken', $token);
        $CI->db->where('isEmailVerified', 'N');
        $query = $CI->db->get();
        return $query->row();
    }
}











/* Video Auditor Sent Mail */

if (!function_exists('videoauditor_mail')) {
    function videoauditor_mail($data)
    {
        $from_email = 'no-reply@urise.online';
        $from_name = 'URISE';

        $config = array(

            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtps.datamail.in',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@urise.online',
            'smtp_pass' => 'Vikram@123*',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $CI = &get_instance();
        $CI->load->library('email', $config);

        $CI->email->set_newline("\r\n");

        $CI->email->from($from_email, $from_name);
        $CI->email->to($data['email']);  // replace it with receiver mail id
        $CI->email->subject('Login Details |' . $from_name); // replace it with relevant subject

        $body = $CI->load->view('email_templates/videoauditor_mail', ['data' => $data], true);

        $CI->email->message($body);

        //Send mail
        if ($CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}




if (!function_exists('forget_Mail')) {
    function forget_Mail($email, $uriseid, $logid)
    {
        $Uid = $uriseid;
        $to_email = $email;
        $from_email = 'no-reply@urise.online';
        $user = array('uriseid' =>  $uriseid,'logid' => $logid);
        //$from_name = 'Unified Portal For Requisite Innonations For Student Empowerment';
        $from_name = 'URISE';
        $config = array(

            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtps.datamail.in',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@urise.online',
            'smtp_pass' => 'Vikram@123*',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $CI = &get_instance();
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from($from_email, $from_name);
        $CI->email->to($to_email);  // replace it with receiver mail id
        $CI->email->subject('Forget Password Link |'  . $from_name); // replace it with relevant subject


        $body = $CI->load->view('email_templates/forget', $user, true);
        $CI->email->message($body);
        //Send mail
        if ($CI->email->send()) {
            // prx($link);
             
            $CI->session->set_flashdata('Success', 'Email has been sent on your registered Email Id.');
            redirect(base_url('user/login/forget_password'));
            return true;
        } else {
            $CI->session->set_flashdata('Success', 'Email has been sent on your registered Email Id.');
            redirect(base_url('user/login/forget_password'));
            return false;
        }
    }
}

if (!function_exists('Forget_Mail_stud')) {
    function Forget_Mail_stud($email, $Uid, $otp)
    {
        $otp = $otp;
        $Uid = $Uid;
        $to_email = $email;
        $link = 'http://www.urise.aktu.ac.in/frontend/homepage/forgetpwd/' . $Uid . '/' . $otp . '';
        $from_email = 'ssl://smtps.datamail.in';
         $user = array('Uid' =>  $Uid, 'otp' => $otp);
        //$from_name = 'Unified Portal For Requisite Innonations For Student Empowerment';
        $from_name = 'URISE';

        $config = array(

            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtps.datamail.in',
            'smtp_port' => 587,
            'smtp_user' => 'no-reply@urise.online',
            'smtp_pass' => 'Vikram@123*',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $CI = &get_instance();
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from($from_email, $from_name);
        $CI->email->to($to_email);  // replace it with receiver mail id
        $CI->email->subject('Student Forget Password Link |'  . $from_name); // replace it with relevant subject
        $CI->email->message('Thanks for contacting us regarding Resetting  forgot password,<br> Click On Link And
        Reset Password:<b><a href="http://urise.aktu.ac.in/frontend/homepage/forgetpwd/' . $Uid . '/' . $otp . ' ">
        Reset Password</a></b>' . "\r\n");
        if ($CI->email->send()) {
        $CI->session->set_flashdata('Success', 'Forget Password Link is Sended To Your Email');
        redirect(base_url('/frontend/homepage/'));
        } else {
            return false;
            // return false;}
        }
    }
}

if (!function_exists('invitation_mail')) {
    function invitation_mail($receiverMail, $senderMail, $invite_token, $mobile)
    {
        $pu_approver = $receiverMail;

        $from_email = 'no-reply@urise.online';

        //$from_name = 'Unified Portal For Requisite Innonations For Student Empowerment';
        $from_name = 'URISE';

        $config = array(

            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtps.datamail.in',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@urise.online',
            'smtp_pass' => 'Vikram@123*',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $CI = &get_instance();
        $CI->load->library('email', $config);

        $CI->email->set_newline("\r\n");

        $CI->email->from($from_email, $from_name);
        $CI->email->to($pu_approver);  // replace it with receiver mail id
        $CI->email->subject('Invitation Link |' . $from_name); // replace it with relevant subject

        $body = $CI->load->view('email_templates/su_approval', ['data' => $invite_token, 'mobile' => $mobile, 'email' => $pu_approver], true);

        $CI->email->message($body);

        ////Send mail
        if ($CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('invitation_mail_ts')) {
    function invitation_mail_ts($receiverMail, $senderMail, $invite_token, $mobile, $user_type)
    {
        $pu_approver = $receiverMail;

        $from_email = 'no-reply@urise.online';
        $from_name = 'URISE';

        $config = array(

            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtps.datamail.in',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@urise.online',
            'smtp_pass' => 'Vikram@123*',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        // $config = array(

        //     'protocol' => 'smtp',
        //     'smtp_host' => 'mail.datamail.in',
        //     'smtp_port' => 25,
        //     'smtp_user' => 'no-reply@urise.online',
        //     'smtp_pass' => 'Vikram@123*',
        //     'mailtype'  => 'html',
        //     'charset'   => 'iso-8859-1'
        // );
        $CI = &get_instance();
        $CI->load->library('email', $config);

        $CI->email->set_newline("\r\n");

        $CI->email->from($from_email, $from_name);
        $CI->email->to($pu_approver);  // replace it with receiver mail id
        $CI->email->subject('Invitation Link |' . $from_name); // replace it with relevant subject

        $body = $CI->load->view('email_templates/tu_approval', ['data' => $invite_token, 'mobile' => $mobile, 'email' => $pu_approver, 'user_type' => $user_type], true);

        $CI->email->message($body);

        ////Send mail
        if ($CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('student_registration')) {
    function student_registration($data)
    {
        $to_email = $data['email'];
        $from_email = 'no-reply@urise.online';
        $from_name = 'URISE';
        $config = array(
            // 'protocol' => 'smtp',
            // 'smtp_host' => 'ssl://smtps.datamail.in',
            // 'smtp_port' => 465,
            // 'smtp_user' => 'urise@aktu.ac.in',
            // 'smtp_pass' => 'aktu@2020@',
            // 'mailtype'  => 'html',
            // 'charset'   => 'iso-8859-1'
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtps.datamail.in',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@urise.online',
            'smtp_pass' => 'Vikram@123*',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $CI = &get_instance();
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from($from_email, $from_name);
        $CI->email->to($to_email);  // replace it with receiver mail id
        $CI->email->subject($subject); // replace it with relevant subject
        $body = $CI->load->view('email_templates/student_registration', ['data' => $data], true);
        $CI->email->message($body);
        //Send mail
        if ($CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('su_details_login')) {
    function su_details_login($data)
    {
        $pu_approver = $data[0]->emailId;
        $from_email = 'no-reply@urise.online';
        //echo $pu_approver;die;
        //$from_name = 'Unified Portal For Requisite Innonations For Student Empowerment';
        $from_name = 'URISE';

        $config = array(

            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtps.datamail.in',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@urise.online',
            'smtp_pass' => 'Vikram@123*',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'

        );
        $CI = &get_instance();
        $CI->load->library('email', $config);

        $CI->email->set_newline("\r\n");


        $CI->email->from($from_email, $from_name);
        $CI->email->to($pu_approver);  // replace it with receiver mail id
        $CI->email->subject('Login Detail |' . $from_name); // replace it with relevant subject

        $body = $CI->load->view('email_templates/pu_details', ['data' => $data], true);


        $CI->email->message($body);

        //Send mail
        if ($CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}


/* SU Verify Video Email*/

if (!function_exists('facultyverifyVideo')) {
    function facultyverifyVideo($data=[])
    {
        
        $where = $data['where'];
        get_instance()->db->select('*');
        get_instance()->db->from('smtp');
        get_instance()->db->where('id', $where);
        $db_smtp = get_instance()->db->get()->result();
        $e = $db_smtp;
        foreach($e as $k){
        $server = $k->server;
        $port = $k->port;
        $Username = $k->Username;
        $Password = $k->Password;
        $From_id = $k->From_id;
        } 
        
        $pu_approver = 'www.bolboro.com';

        $from_email = $From_id;

        //$from_name = 'Unified Portal For Requisite Innonations For Student Empowerment';
        $from_name = 'BOLBORO.COM   Bolo Khul Ke';

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => $server,
            'smtp_port' => $port,
            'smtp_user' => $Username,
            'smtp_pass' => $Password,
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        $CI = &get_instance();
        $CI->load->library('email', $config);

        $CI->email->set_newline("\r\n");

        $CI->email->from($from_email, $from_name);
        $CI->email->to($data['email']);  // replace it with receiver mail id
        $CI->email->subject('Notification - Join our Community And Live More'); // replace it with relevant subject

        $body = $CI->load->view('pu_approval', ['data' => $data], true);

        $CI->email->message($body);
        // $status = $CI->email->send();
        // print_r($status);
        //Send mail
        if ($CI->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}

