<?php


class U2 extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('lib');
		$this->load->model('lib_model');
		$this->load->helper('string');
		$this->load->library('upload');
		/*
		 * Session Check for ERP
		 */
		$allow_url = array('Logout', 'Auth', 'index', '');
		$url = $this->uri->segment(2);
		if (!in_array($url, $allow_url)) {
			if (!$this->session->userdata('ELogin')) {
				redirect(base_url());
			}

			
//$rs = $this->lib_model->Counter('m_role_assignment', array('fid' => $this->session->EmpId, 'sid'=> 3, 'status' => 0));
//			if ($rs == 0) {redirect(base_url() . 'Faculty/dashboard');}
		}	
	}

    public function Dashboard()
	{
	$city = $_SESSION['city'] ;
		$data['rs'] = $this->lib_model->city_requirement_list($city);
		
		
		$this->load->view('u2/header');
		$this->load->view('u2/mList',$data);
		$this->load->view('u2/footer');
	}
}