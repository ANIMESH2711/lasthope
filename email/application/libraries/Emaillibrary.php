<?php

/**
* @author Naveen Rastogi
* @copyright Feb-2015
* 
*/

if( ! defined('BASEPATH'))
	exit('No direct script access allowed');

/**
* @author :: Naveen Rastogi
* @create :: Feb-2015
* EmailLibrary for send email on server
*
* @access	public
*/

class Emaillibrary
{

	public function sendEmail($tomail, $mail_subject, $REPLACE_MGS,$file = '')
	{
		$CI = & get_instance();
		$tomail = strtolower($tomail);
		$CI->load->library(['email']);
		$mail_from = config_item('mail_from');
		$mail_from_name = config_item('mail_from_name');
		$config['protocol'] = config_item('mailer');
		$config['smtp_host'] = config_item('smtp_host');
		$config['smtp_port'] = config_item('smtp_port');
		$config['smtp_timeout'] = '7';
		$config['smtp_user'] = config_item('smtp_username');
		$config['smtp_pass'] = trim(config_item('smtp_password'));
		$config['charset'] = 'utf-8';
		$config['newline'] = "\r\n";
		$config['mailtype'] = 'html';
		$config['validation'] = TRUE;
		$CI->email->initialize($config);
		$CI->email->from($mail_from, $mail_from_name);
		$CI->email->to($tomail);
		$CI->email->subject($mail_subject);
		$CI->email->message($REPLACE_MGS);
		if($file != '')
		{
			$CI->email->attach($file);
		}
		$ree = $CI->email->print_debugger();
		//prx($ree);
		$res = $CI->email->send();
		//prx($res);
		return $res;
		
	}
}
?>