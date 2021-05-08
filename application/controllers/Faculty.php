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
                  'EmpId' =>$r->id,
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
	 * show All question tp Faculty
	 */
public function account()
	{



		
$data['rs'] = $this->lib_model->Select('m_faculty', 'id,username,name,email,status', array('id' => $this->session->EmpId));
		
	
			# code...
		
		$this->load->view('f/f_header', $data);
		$this->load->view('f/account');
		$this->load->view('f/f_footer');
	
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
	
/*
public function dashboard()

	{

		$rs = $this->lib_model->Select('m_subject_faculty_mapping', 'fid', array('fid' => $this->session->EmpId));
			if (count($rs) == 1) {


		 

		$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,status,subjectcode', array('status' => 0));


		
		$this->load->view('f/f_header',$data);
		$this->load->view('f/f_dashboard',$data);
		$this->load->view('f/f_footer');
	}}*/


public function dashboard()
   {


		$data['rs'] = $this->lib_model->Select('v_faculty_mapping', 'UserId,SubjectName,UserSubjectId,SubjId,IsFaculty,FullName,UserEmail,IsModerator', array('UserId' => $this->session->EmpId, 'IsUserActive' => 0, 'IsFaculty' =>  1));
		//$data['ra'] = $this->lib_model->Select('m_topic', 'id,sid,topic', array('status' => 0 ));
$sql  = "SELECT * from topic where (ChapterId in (SELECT ChapterId from chapter))";


//$sql  = "SELECT * from topic where (status = 0) and(cid in (SELECT chapter from m_chapter))";
		$data['ra'] = $this->lib_model->Execute($sql,array($this->session->EmpId))->result();

//$sql  = "SELECT * from m_chapter where (status = 0) and(sid in (SELECT sid from v_subject_faculty_mapping where fid  = ?))";

$sql  = "SELECT * from chapter where (SubjectId in (SELECT SubjId from usersubjects where UserId  = ?))";

		$data['rc'] = $this->lib_model->Execute($sql,array($this->session->EmpId))->result();


      /*
         * CK Editor
         */
      $path = '../assets/ckfinder';
      $width = '85%';
      //Loading Library For Ckeditor
      $this->load->library('ckeditor');
      $this->load->library('ckfinder');
      //configure base path of ckeditor folder
      $this->ckeditor->basePath = base_url('assets/ckeditor/');
      $this->ckeditor->config['toolbar'] = 'Full';
      $this->ckeditor->config['language'] = 'en';
      $this->ckeditor->config['width'] = $width;
      //configure ckfinder with ckeditor config
      $this->ckfinder->SetupCKEditor($this->ckeditor, $path);

      $this->load->view('f/f_header',$data);
      $this->load->view('f/dashboard');
      $this->load->view('f/f_footer');
   }


public function AddQues()
   {

   	$data['rs'] = $this->lib_model->Select('v_subject_faculty_mapping', 'id,Subject,fid', array('fid' => $this->session->EmpId, 'status' => 0 ));
      /*
         * CK Editor
         */
      $path = '../assets/ckfinder';
      $width = '85%';
      //Loading Library For Ckeditor
      $this->load->library('ckeditor');
      $this->load->library('ckfinder');
      //configure base path of ckeditor folder
      $this->ckeditor->basePath = base_url('assets/ckeditor/');
      $this->ckeditor->config['toolbar'] = 'Full';
      $this->ckeditor->config['language'] = 'en';
      $this->ckeditor->config['width'] = $width;
      //configure ckfinder with ckeditor config
      $this->ckfinder->SetupCKEditor($this->ckeditor, $path);

      $this->load->view('f/f_header',$data);
      $this->load->view('f/dashboard');
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






//view single question

	public function ViewQues($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
$data['rs'] = $this->lib_model->Select('m_addques', 'subjectcode,createdBy,status,,id,question,answer', array('id' => $data['Id']));



		$this->load->view('f/f_header', $data);
		$this->load->view('f/view_ques');
		$this->load->view('f/f_footer');
	}




//view single question

	public function ViewQuesDraft($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
$data['rs'] = $this->lib_model->Select('draft_ques', 'subjectcode,createdBy,status,,id,question,answer', array('id' => $data['Id']));



		$this->load->view('f/f_header', $data);
		$this->load->view('f/view_ques_draft');
		$this->load->view('f/f_footer');
	}




/*
	 * show All question tp Faculty
	 */
public function MyAllQues()
	{



		$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,

		QTitle,QTime,QComplexity,', array('AuthorId' => $this->session->EmpId));
		
        rsort($data['rs']);
	
			# code...
		
		$this->load->view('f/f_header', $data);
		$this->load->view('f/myallques');
		$this->load->view('f/f_footer');
	
}

/*
	 * show pending question tp Faculty
	 */
public function PendingQueslist()
	{



$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,

		QTitle,QTime,QComplexity,QCurStateId', array('AuthorId' => $this->session->EmpId,

			'QCurStateId' => 0));



		//$data['rs'] = $this->lib_model->Select('m_addques', 'id,createdBy,question,answer,status,subjectcode,createdBy', array('createdBy' => $this->session->EmpId,'status' => 0));
		rsort($data['rs']);
		
		$this->load->view('f/f_header', $data);
		$this->load->view('f/f_pendingqueslist');
		$this->load->view('f/f_footer');
	}







/*
	 * show draft question tp Faculty
	 */
public function DraftQuestion()
	{

		//$data['rs'] = $this->lib_model->Select('draft_ques', 'id,createdBy,question,answer,status,subjectcode,createdBy', array('createdBy' => $this->session->EmpId,'status' => 0));


$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,

		QTitle,QTime,QComplexity,QCurStateId', array('AuthorId' => $this->session->EmpId,

			'QCurStateId' => 5));


	rsort($data['rs']);
	
		$this->load->view('f/f_header', $data);
		$this->load->view('f/draft_ques_list');
		$this->load->view('f/f_footer');
	}




/*.
 * Edit Subject 
 */
public function EditDraftQues()//$Id)
{
   $data['Id'] = $this->lib->validate($Id);
   //$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,subjectcode,type', array('id' => $data['Id']));

  //$data['rt'] = $this->lib_model->Select('v_subject_faculty_mapping', 'id,Subject,fid,sid', array('fid' => $this->session->EmpId, 'status' => 0 ));
		//$data['ra'] = $this->lib_model->Select('m_topic', 'id,sid,topic', array('status' => 0 ));

//$sql  = "SELECT * from m_topic where (status = 0) and(sid in (SELECT sid from m_subject_faculty_mapping where fid = ?))";
//		$data['ra'] = $this->lib_model->Execute($sql,array($this->session->EmpId))->result();



		$data['rs'] = $this->lib_model->Select('m_addques', 'id,createdBy,question,topic,answer,status,subjectcode,createdBy', array('id' => $data['Id']));







/*
      
         * CK Editor
         */
      $path = '../assets/ckfinder';
      $width = '85%';
      //Loading Library For Ckeditor
      $this->load->library('ckeditor');
      $this->load->library('ckfinder');
      //configure base path of ckeditor folder
      $this->ckeditor->basePath = base_url('assets/ckeditor/');
      $this->ckeditor->config['toolbar'] = 'Full';
      $this->ckeditor->config['language'] = 'en';
      $this->ckeditor->config['width'] = $width;
      //configure ckfinder with ckeditor config
      $this->ckfinder->SetupCKEditor($this->ckeditor, $path);

      $this->load->view('f/f_header',$data);
      $this->load->view('f/dashboard');
      $this->load->view('f/f_footer');
   }














/*
	 * show approved question tp Faculty
	 */
public function ApprovedQuestion()
	{

		//$data['rs'] = $this->lib_model->Select('m_addques', 'id,createdBy,question,answer,status,subjectcode,createdBy', array('createdBy' => $this->session->EmpId,'status' => 1));


$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,

		QTitle,QTime,QComplexity,QCurStateId', array('AuthorId' => $this->session->EmpId,

			'QCurStateId' => 1));


	rsort($data['rs']);
	
		$this->load->view('f/f_header', $data);
		$this->load->view('f/f_approved_ques_list');
		$this->load->view('f/f_footer');
	}




/*
	 * show unapproved question tp Faculty
	 */
public function UnapprovedQuestion()
	{

		//$data['rs'] = $this->lib_model->Select('m_addques', 'id,createdBy,question,answer,status,subjectcode,createdBy', array('createdBy' => $this->session->EmpId,'status' => 2));
		



$data['rs'] = $this->lib_model->Select('question', 'QuestionId,SubjectId,UnitId,TopicId,AuthorId,QTypeId,QMarks,QAnswer,Question,

		QTitle,QTime,QComplexity,QCurStateId', array('AuthorId' => $this->session->EmpId,

			'QCurStateId' => 2));



		rsort($data['rs']);
		
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


// faculty add question process
public function AddQuesProcess()
	{
		
		$rules = array(
			array('field' => 'Question', 'label' => 'Question', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('faculty/addques'));
		} else {

			$Ques = $this->lib->validate($this->input->post('Question'));
			$Ans = $this->lib->validate($this->input->post('Answer'));
			$Sub = $this->lib->validate($this->input->post('Subject'));
			$Chapter = $this->lib->validate($this->input->post('Chapter'));
			$Topic = $this->lib->validate($this->input->post('Topic'));
			$Type = $this->lib->validate($this->input->post('Type'));
			$Qlevel = $this->lib->validate($this->input->post('Qlevel'));
			$Title = $this->lib->validate($this->input->post('Title'));
			$Marks = $this->lib->validate($this->input->post('Marks'));
			$Time = $this->lib->validate($this->input->post('TIme'));
			

			$count = $this->lib_model->Counter('question', array('Question' => $CName));

			if ($count == 0) {
				$f = array(
					'SubjectId' => $Sub,
					'UnitId' => $Chapter,
					'TopicId '=>$Topic,
					'AuthorId'=> $this->session->EmpId,
					'QTypeId'=>$Type,
					'QTitle'=>$Title,
					'Question' => $Ques,
					'QAnswer' => $Ans,
					'QMarks' => $Marks,
					'QTime' => $Time,
					'QComplexity' => $Qlevel,
					'QBTId' => A,
					'QKeywords' => ABCD,
					'QCurStateUsrId' => $this->session->EmpId,

					//date('Y-m-d H:i:s')
				)




				;


				$this->lib_model->Insert('question', $f);


				


				$Msg = array('Msg' => 'Question Added Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('Faculty/dashboard'));
			} else {
				$Msg = array('Msg' => 'Question Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('Faculty/dashboard'));
			}


		}}








// faculty add question process
public function DraftQuesProcess()


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
			$type = $this->lib->validate($this->input->post('type'));
			$mcq = $this->lib->validate($this->input->post('mcq'));
			$topic = $this->lib->validate($this->input->post('topic'));
			$sub = $this->lib->validate($this->input->post('sub'));
			$qlevel = $this->lib->validate($this->input->post('qlevel'));
			

			$count = $this->lib_model->Counter('m_addques', array('question' => $CName));

			if ($count == 0) {
				$f = array(
					'question' => $CName,
					'answer' => $CAbout,
					'subjectcode'=>$sub,
					'mcq'=>$mcq,
					'type'=>$type,
					'topic'=>$topic,
					'qlevel' => $qlevel,
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
					'createdBy' => $this->session->EmpId,

				);


				$this->lib_model->Insert('draft_ques', $f);
				$Msg = array('Msg' => 'Question Added Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('Faculty/dashboard'));
			} else {
				$Msg = array('Msg' => 'Question Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('Faculty/dashboard'));
			}


		}}









}
