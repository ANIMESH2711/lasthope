<?php


class Supervisior extends CI_Controller
{
	/*
	 * Construct
	 */
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
			//$rs = $this->lib_model->Counter('m_role_assignment', array('fid' => $this->session->EmpId, 'sid'=> 4, 'status' => 0));
			//if ($rs == 0) {redirect(base_url() . 'Faculty/dashboard');}



		}
	}

	/*
	 * index
	 */
	/*
	 * Index
	 */

/*	public function index()
	{
		$this->load->view('supervisior/index');
	}


 ---------------------------------------------------------------------------------------------------------------------------
 Supervisor functions 
	 */



 /*
	 * supervisiorlogin
	 */
	

public function supervisior_login()
	{
		
		$this->load->view('supervisior/supervisior_index');
		$this->load->view('supervisior/supervisior_footer');
	}

/*
	 * supervisior auth
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


#supervisior login
			elseif ($this->form_validation->run() == true
		) {    

				$username = $this->lib->validate($this->input->post('username'));
			$password = $this->lib->validate($this->input->post('password'));

			$username = $this->security->xss_clean($username);
			$password = $this->security->xss_clean($password);			
			$count = $this->lib_model->Counter('m_supervisior', array('username' => $username, 'password' => $password, 'status' => 0));			
#elseif
			if ($count == 1) {
				$Sessions = array(
					'EmpCode' => $username,
					'EmpName' => 'Administration',
					'ELogin' => true);
				$this->session->set_userdata($Sessions);

				$Msg = array('Msg' => ' Have a Nice Day ', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url() . 'Supervisior/dashboard');

			}



			}

			else {
				$Msg = array('Msg' => 'Username and Password Invalid', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url() . 'supervisior/dashboard');

		}



	}


/*
	 * Dashboard
	 */
	
public function dashboard()
	{
	//$sql  = "SELECT * from m_addques where (status = 5) and(id in 
	//(SELECT qid from m_qns_supervisor_mapping where sid = ?))";


//	$sql  = "SELECT * from m_addques where (status = 5)";



$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,

		QTitle,QTime,QComplexity,QCurStateId', array('QCurStateId' => 0));
		
		
		//$data['rs'] = $this->lib_model->Execute($sql,array($this->session->EmpId))->result();
		
		rsort($data['rs']);

		//$data['rs'] = $this->lib_model->Execute($sql,array($this->session->EmpId))->result();
		//$data['rs'] = $this->lib_model->Select('m_addques', 'name,about,status,subjectcode', array('status' => 0));
		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/supervisior_dashboard');
		$this->load->view('supervisior/supervisior_footer');
	}

/*
	 * show my account details
	 */
public function account()
	{



		
//$data['rs'] = $this->lib_model->Select('m_faculty', 'id,username,name,email,status', array('id' => $this->session->EmpId));
		
	
			# code...
		
		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/account');
		$this->load->view('supervisior/supervisior_footer');
	
}

/*
	 *  CategoryList
	 */
	public function QuesBucket()
	{

		//$data['rs'] = $this->lib_model->Select('ques', 'question,answer,status,subjectcode', array('status' => 0));



$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,

		QTitle,QTime,QComplexity,QCurStateId', array('QCurStateId' => 0));

	
	rsort($data['rs']);
	
		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/supervisior_dashboard');
		$this->load->view('supervisior/supervisior_footer');
	}


/*
	 *  CategoryList
	 */
	public function QuesSelectionBucket()
	{


		//$data['rs'] = $this->lib_model->Select('m_addques', 'id,createdBy,question,answer,status,subjectcode', array('status' => 0));
	
	//rsort($data['rs']);
	
		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/Ques_selection_bucket');
		$this->load->view('supervisior/supervisior_footer');
	}



//view &  single question of bucket

	public function ViewSelectQues($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_addques', 'subjectcode,createdBy,status,id,question,answer', array('id' => $data['Id']));



		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/viewSelectQues');
		$this->load->view('supervisior/supervisior_footer');
	}







/*
	 *  CategoryList
	 */
	public function AllApproved()
	{

		
		//$data['rs'] = $this->lib_model->Select('m_addques', 'id,createdBy,question,answer,status,subjectcode', array('status' => 1));
		





$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,QCurStateUsrId,QTitle,QTime,QComplexity,QCurStateId', array('QCurStateId' => 1,'QCurStateUsrId' => $this->session->EmpId));

		rsort($data['rs']);
		
		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/All_approved');
		$this->load->view('supervisior/supervisior_footer');
	}



/*
	 *  CategoryList
	 */
	public function AllRejected()
	{

		//$data['rs'] = $this->lib_model->Select('m_addques', 'id,createdBy,question,answer,status,subjectcode', array('status' => 2));
		




$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,QCurStateUsrId,QTitle,QTime,QComplexity,QCurStateId', array('QCurStateId' => 2,'QCurStateUsrId' => $this->session->EmpId));



		rsort($data['rs']);
		
		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/All_rejected');
		$this->load->view('supervisior/supervisior_footer');
	}
/*
	 *  CategoryList
	 */
	public function AllSkip()
	{
	    
	    
	    
	    
$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,QCurStateUsrId,QTitle,QTime,QComplexity,QCurStateId', array('QCurStateId' => 2,'QCurStateUsrId' => $this->session->EmpId));


		//$data['rs'] = $this->lib_model->Select('m_addques', 'id,createdBy,question,answer,status,subjectcode', array('status' => 3));
		
		rsort($data['rs']);

		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/All_skip');
		$this->load->view('supervisior/supervisior_footer');
	}



/*
	 * supervisior Add subject Category page
	 */
	public function SupervisiorAddSubject()
	{

		$this->load->view('supervisior/supervisior_header');
		$this->load->view('supervisior/supervisior_AddSubject');
		$this->load->view('supervisior/supervisior_footer');
	}
/*
	 * supervisor  Add suject Process
	 */
	public function SupervisiorAddSubjectProcess()
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
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
					'createdBy' => $this->session-'Empid',

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
	 * supervisior Add question
	 */

public function Addques()
	{

		$this->load->view('supervisior/supervisior_header');
		$this->load->view('supervisior/supervisior_Addques');
		$this->load->view('supervisior/supervisior_footer');
	}





public function Addquesprocess()
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

			$count = $this->lib_model->Counter('m_addques', array('name' => $CName));

			if ($count == 0) {
				$f = array(
					'name' => $CName,
					'about' => $CAbout,
					'subjectcode'=>$CCode,
					'type'=>$CType,
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
					'createdBy' => $this->session-'Empid',

				);


				$this->lib_model->Insert('m_addques', $f);
				$Msg = array('Msg' => 'Subject Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/supervisior_Addques'));
			} else {
				$Msg = array('Msg' => 'Subject Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/supervisior_Addques'));
			}


		}

}






/*
	 *  Approve question Status
	 */
	public function QuesApprov($table, $id, $status, $url)
	{
		$table = $this->lib->validate($table);
		$id = $this->lib->validate($id);
		$status = $this->lib->validate($status);
		if ($status == 0) {
			$s = 1;
		}
		

		$f = array('status' => $s);
		$this->lib_model->Update($table, $f, array('id' => $id));

		$Msg = array('Msg' => 'Status Change Sucessfully', 'Type' => 'success');
		$this->session->set_flashdata($Msg);
		redirect(base_url('supervisior/Dashboard'));

	}

/*
	 *  reject question Status
	 */
	public function RejectQuesDisable($table, $id, $status, $url)
	{
		$table = $this->lib->validate($table);
		$id = $this->lib->validate($id);
		$status = $this->lib->validate($status);
		if ($status == 0) {
			$s = 2;
		} 
		

		$f = array('status' => $s);
		$this->lib_model->Update($table, $f, array('id' => $id));

		$Msg = array('Msg' => 'Status Change Sucessfully', 'Type' => 'success');
		$this->session->set_flashdata($Msg);
		redirect(base_url('supervisior/Dashboard'));

	}


/*
	 *  skip question Status
	 */
	public function skipQuesDisable($table, $id, $status, $url)
	{
		$table = $this->lib->validate($table);
		$id = $this->lib->validate($id);
		$status = $this->lib->validate($status);
		if ($status == 0) {
			$s = 3;
		} 

		$f = array('status' => $s);
		$this->lib_model->Update($table, $f, array('id' => $id));

		$Msg = array('Msg' => 'Status Change Sucessfully', 'Type' => 'success');
		$this->session->set_flashdata($Msg);
		redirect(base_url('supervisior/Dashboard'));

	}



//this method assign qns in Supervisor

public function RequestQuestion()
{
   $count = $this->lib_model->Counter('m_qns_supervisor_mapping',array('sid'=>$this->session->EmpId,'status'=>'-1'));
   if($count>0)
   {
      $Msg = array('Msg' => 'Sorry you have already pending Qns in your Account', 'Type' => 'danger');
      $this->session->set_flashdata($Msg);
      redirect(base_url('supervisior/Dashboard'));
   }
   else
   {
      $sql = 'SELECT id from m_addques where id not in (SELECT qid FROM m_qns_supervisor_mapping) limit 0,20';
      $rs = $this->lib_model->Execute($sql,array())->result();

      foreach ($rs as $r)
      {
         $f = array('qid'=>$r->id,'sid'=>$this->session->EmpId,'created'=>date('Y-m-d H:i:s'),'createdip'=>$this->input->ip_address());
         $this->lib_model->Insert('m_qns_supervisor_mapping',$f);

      }
      $Msg = array('Msg' => 'Qns is successfully assign in your account', 'Type' => 'danger');
      $this->session->set_flashdata($Msg);
      redirect(base_url('supervisior/Dashboard'));
   }

}


//this method assign qns in Supervisor

public function assignQuestion($table, $id, $status, $url)


	{
		$table = $this->lib->validate($table);
		$id = $this->lib->validate($id);
		$status = $this->lib->validate($status);
		if ($status == 0) {
			$s = 5;
		} 

		$f = array('status' => $s);
		$this->lib_model->Update($table, $f, array('id' => $id));

		//$this->session->set_flashdata($Msg);



  $count = $this->lib_model->Counter('m_qns_supervisor_mapping',array('sid'=>$this->session->EmpId,'status'=>'-1'));
  // if($count>0)
   //{
     // $Msg = array('Msg' => 'Sorry you have already pending Qns in your Account', 'Type' => 'danger');
      //$this->session->set_flashdata($Msg);
      //redirect(base_url('supervisior/Dashboard'));
   //}
   //else
   //{
     

  			 $sql = 'SELECT id from m_addques where id not in (SELECT qid FROM m_qns_supervisor_mapping) limit 0,1';

     // $sql = 'SELECT * from m_addques  ';
      $rs = $this->lib_model->Execute($sql,array())->result();

      foreach ($rs as $r)
      {
         $v = array('qid'=>$r->id,'sid'=>$this->session->EmpId,'created'=>date('Y-m-d H:i:s'),'createdip'=>$this->input->ip_address());
         $this->lib_model->Insert('m_qns_supervisor_mapping',$v);

      }
      $Msg = array('Msg' => 'Qns is successfully assign in your account', 'Type' => 'danger');
      $this->session->set_flashdata($Msg);
      redirect(base_url('supervisior/QuesSelectionBucket'));
   }








//this method assign single qns in Supervisor
/*
public function Requestques($Id)
{



	$data['Id'] = $this->lib->validate($Id);
$data['rs'] = $this->lib_model->Select('m_addques', 'subjectcode,createdBy,status,,id,name,about', array('id' => $data['Id']));



   $count = $this->lib_model->Counter('m_qns_supervisor_mapping',array('sid'=>$this->session->EmpId,'status'=>'-1','qid'=> $data['Id'));
   if($count>0)
   {
      $Msg = array('Msg' => 'Sorry you have already pending Qns in your Account', 'Type' => 'danger');
      $this->session->set_flashdata($Msg);
      redirect(base_url('supervisior/supervisior_dashboard'));
   }
   else
   {
      $sql = 'SELECT id from m_addques where id not in (SELECT qid FROM m_qns_supervisor_mapping)';
      $rs = $this->lib_model->Execute($sql,array())->result();

      foreach ($rs as $r)
      {
         $f = array('qid'=>$r->id,'sid'=>$this->session->EmpId,'created'=>date('Y-m-d H:i:s'),'createdip'=>$this->input->ip_address());
         $this->lib_model->Insert('m_qns_supervisor_mapping',$f);

      }
      $Msg = array('Msg' => 'Qns is successfully assign in your account', 'Type' => 'danger');
      $this->session->set_flashdata($Msg);
      redirect(base_url('supervisior/supervisior_dashboard'));
   }

}
*/



//view single question of bucket

	public function Viewques($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_addques', 'subjectcode,createdBy,status,,id,question,answer', array('id' => $data['Id']));



		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/viewques');
		$this->load->view('supervisior/supervisior_footer');
	}



//view single question of other section

	public function viewQuesOther($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_addques', 'subjectcode,createdBy,status,id,question,answer', array('id' => $data['Id']));



		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/viewquesother');
		$this->load->view('supervisior/supervisior_footer');
	}
}
