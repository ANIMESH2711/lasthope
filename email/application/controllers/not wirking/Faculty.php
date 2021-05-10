<?php


class Faculty extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('lib');
		$this->load->model('lib_model');
		$this->load->helper('string');
		/*
		 * Session Check for ERP
		 */
		$allow_url = array('Logout', 'Auth', 'index', '');
		$url = $this->uri->segment(2);
		if (!in_array($url, $allow_url)) {
			if (!$this->session->userdata('ELogin')) {
				redirect(base_url());
			}
		}
	}
	/*
	 * Index
	 */

/*	public function index()
	{
		$this->load->view('faculty/index');


	}

*/









/*faculty functions
 ---------------------------------------------------------------------------------------------------------------------------
	 */


 /*
	 * f login
	 */
	

public function login()
	{
		
		$this->load->view('f/index');
		$this->load->view('f/footer');
	}

/*
	 * f auth
	 */
public function Auth()
   {
      $rules = array(
         array('field' => 'username', 'label' => 'Username', 'rules' => 'required'),
         array('field' => 'password', 'label' => 'Password', 'rules' => 'required'),
      );

      $this->form_validation->set_rules($rules);
      if ($this->form_validation->run() == false) {
         $Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
         $this->session->set_flashdata($Msg);
         redirect(base_url() . 'Admin/');
      } 

#faculty login

      elseif 
      ($this->form_validation->run() == true
      ) {
         # code...


         $username = $this->lib->validate($this->input->post('username'));
         $password = $this->lib->validate($this->input->post('password'));

         $username = $this->security->xss_clean($username);
         $password = $this->security->xss_clean($password);       
         $rs = $this->lib_model->Select('m_faculty','name,username,id', array('email' => $username, 'password' => $password, 'status' => 0));
#if under else if
         if (count($rs) == 1) {
            foreach ($rs as $r)
            {
               $Sessions = array(
                  'EmpCode' => $username,
                  'EmpName' => $r->name,
                  'ELogin' => true,
                  'EmpId' =>$r->id
                  );
            }

               $this->session->set_userdata($Sessions);

               $Msg = array('Msg' => ' Have a Nice Day ', 'Type' => 'success');
               $this->session->set_flashdata($Msg);
               redirect(base_url() . 'Faculty/f_dashboard');
         }
      }
else {
            $Msg = array('Msg' => 'Username and Password Invalid', 'Type' => 'danger');
            $this->session->set_flashdata($Msg);
            redirect(base_url() . 'Admin/');

      }



   }


	

/*
	 * Dashboard
	 */
	

public function f_dashboard()
	{
		$this->load->view('f/f_header');
		$this->load->view('f/f_dashboard');
		$this->load->view('f/f_footer');
	}





/*
	 * Dashboard
	 */
	

public function dashboard()

	{

		/*  $loggeduser=$this->session->Empid;
      $query= $this->db->query("SELECT*FROM m_faculty WHERE username='$loggeduser'");*/
		
		$this->load->view('f/f_header');
		$this->load->view('f/f_dashboard');
		$this->load->view('f/f_footer');
	}

/*
	 *  CategoryList
	 */
	public function SubjectList()
	{

		$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,status,subjectcode', array());
		$this->load->view('f/f_header', $data);
		$this->load->view('f/f_SubjectList');
		$this->load->view('f/f_footer');
	}

/*
	 * show All question tp Faculty
	 */
public function myallques()
	{

		$data['rs'] = $this->lib_model->Select('m_addques', 'name,about,status,subjectcode', array());
		$this->load->view('f/f_header', $data);
		$this->load->view('f/myallques');
		$this->load->view('f/f_footer');
	}


/*
	 * show pending question tp Faculty
	 */
public function pendingqueslist()
	{



		$data['rs'] = $this->lib_model->Select('m_addques', 'name,about,status,subjectcode', array('status' => -1));
		$this->load->view('f/f_header', $data);
		$this->load->view('f/f_pendingqueslist');
		$this->load->view('f/f_footer');
	}



/*
	 * show approved question tp Faculty
	 */
public function approved_question()
	{

		$data['rs'] = $this->lib_model->Select('m_addques', 'name,about,status,subjectcode', array('status' => 0));
		$this->load->view('f/f_header', $data);
		$this->load->view('f/f_approved_ques_list');
		$this->load->view('f/f_footer');
	}




/*
	 * show unapproved question tp Faculty
	 */
public function unapproved_question()
	{

		$data['rs'] = $this->lib_model->Select('m_addques', 'name,about,status,subjectcode', array('status' => 1));
		$this->load->view('f/f_header', $data);
		$this->load->view('f/f_Unapproved_ques_list');
		$this->load->view('f/f_footer');
	}



/*
	 * Add subject Category page
	 */
	public function f_AddSubject()
	{

		$this->load->view('f/f_header');
		$this->load->view('f/f_AddSubject');
		$this->load->view('f/f_footer');
	}


	/*
	 * faculty  Add suject Process
	 */
	public function AddSubjectProcess()
	{
		$rules = array(
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/f_AddCategory'));
		} else {

			$CName = $this->lib->validate($this->input->post('CName'));
			$CAbout = $this->lib->validate($this->input->post('CAbout'));
			$CCode = $this->lib->validate($this->input->post('CCode'));
			$CType = $this->lib->validate($this->input->post('CType'));

			$count = $this->lib_model->Counter('m_subject', array('name' => $CName));

			if ($count == 0) {
				$f = array(
					'name' => $CName,
					'about' => $CAbout,
					'subjectcode'=>$CCode,
					'type'=>$CType,
					'status' => 1,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
					'createdBy' => 'Faculty'

				);


				$this->lib_model->Insert('m_subject', $f);
				$Msg = array('Msg' => 'Subject Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/f_AddSubject'));
			} else {
				$Msg = array('Msg' => 'Subject Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/f_AddSubject'));
			}


		}
	}

/*
	 * faculty Add question
	 */

public function AddQues()
	{

		$this->load->view('f/f_header');
		$this->load->view('f/f_Addques');
		$this->load->view('f/f_footer');
	}




// faculty add question process
public function Addquesprocess()
	{
		if( Request.Form["submitbutton1"] != null)
{
		$rules = array(
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('faculty/addques'));
		} else {

			$CName = $this->lib->validate($this->input->post('CName'));
			$CAbout = $this->lib->validate($this->input->post('CAbout'));
			$CCode = $this->lib->validate($this->input->post('CCode'));
			$CType = $this->lib->validate($this->input->post('CType'));
			$mcq = $this->lib->validate($this->input->post('mcq'));
			

			$count = $this->lib_model->Counter('m_addques', array('name' => $CName));

			if ($count == 0) {
				$f = array(
					'name' => $CName,
					'about' => $CAbout,
					'subjectcode'=>$CCode,
					'mcq'=>$mcq,
					'type'=>$CType,
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
					'createdBy' => $this->session->empid,

				);


				$this->lib_model->Insert('m_addques', $f);
				$Msg = array('Msg' => 'Subject Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('Faculty/Addques'));
			} else {
				$Msg = array('Msg' => 'Subject Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('Faculty/Addques'));
			}


		}}


else if(Request.Form["submitButton2"] != null )
{  

	echo "hiiiiiiiiiiiiiiiiiii"; }?



}


*/















}
