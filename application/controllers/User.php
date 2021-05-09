<?php


class User extends CI_Controller
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
$allow_url = array('Logout', 'Auth', 'index','teacherSignup','confirm_otp','dt_Signup','signUpTeacherProcess2','userLogin','ConfirmLoginOtp' ,'sendOTP','');
		$url = $this->uri->segment(2);
		if (!in_array($url, $allow_url)) {
			// if (!$this->session->userdata('ELogin')) {
			// 	redirect(base_url());
			// }

			
//$rs = $this->lib_model->Counter('m_role_assignment', array('fid' => $this->session->EmpId, 'sid'=> 3, 'status' => 0));
//			if ($rs == 0) {redirect(base_url() . 'Faculty/dashboard');}
		}



			
	}

	/*    
	 * Index
	 */
	public function index()
	{
		
		// redirect(base_url() . 'Admin/adminLogin');
		$data['flash'] = $flash = $this->uri->segment(3);		
		if($flash == 1){
		$this->session->set_flashdata('category_success', 'Registered Successfully.');	
	}
		$this->load->view('home',$data);
	}

	public function u2Signup()
	{
		// redirect(base_url() . 'Admin/adminLogin');
		$this->load->view('u2signup');
	}
	public function confirm_u2_otp()
	{
		$rules = array(
			array('field' => 'phone', 'label' => 'phone', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
		
			$this->session->set_flashdata('category_error', validation_errors() );
			
			redirect(base_url('User/u2Signup'));
		} else {
		$data['phone'] = $this->lib->validate($this->input->post('phone'));
		$otp = rand(1000,9999) ; 
		$insert = 'na' ;
		$count = $this->lib_model->Counter('sent_otp', array('meta' => $data['phone']));
		if ($count == 0) {
		$f = array(
			'otp' => $otp,
			'meta' => $data['phone'],				
			);
		$insert = $this->lib_model->Insert('sent_otp', $f);
		}
		
		if ($count <> 0) { $insert = 0 ; }
		$data['rs'] = $this->lib_model->Select('sent_otp', '*', array('meta' => $data['phone']));
			
		if(!empty($data['rs'])){
			$this->session->set_flashdata('category_success', 'Otp Sent Successfully. - OTP - ' .  $data['rs'][0]->otp);
			$this->load->view('confirm_u2_otp', $data);
		}
		else{
			$this->session->set_flashdata('category_error', 'Something Went Wrong.');
			redirect(base_url('User/u2Signup'));	
		} 		}
	}
	
	public function confirm_u2_otp_process()
	{
		$data['phone'] = $phone = $this->lib->validate($this->input->post('phone'));
		$rules = array(
			array('field' => 'phone', 'label' => 'phone', 'rules' => 'required') ,
		
		);
		
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
		
			$this->session->set_flashdata('category_error', validation_errors() );			
			$this->load->view('confirm_u2_otp', $data);
		} else {
			
					
			$data['phone'] = $phone = $this->lib->validate($this->input->post('phone'));
			$otp = $this->lib->validate($this->input->post('otp'));
		
	$count = $this->lib_model->Counter('sent_otp', array('meta' => $phone, 'otp' => $otp));

			if ($count <> 0) {
					$f = array('status' => 1,);
				$this->lib_model->Update('sent_otp', $f, array('meta' => $phone, 'otp' => $otp));
				
				$this->session->set_flashdata('category_success', 'Registered Successfully.');
				// $this->load->view('direct_Signup', $data);
				redirect(base_url('User/u2_Signup/'. base64_encode($phone)));
				// $this->dt_Signup($phone);	
			}
			if ($count == 0) {
			
				$this->session->set_flashdata('category_error', 'OTP Not Matched');
				$this->load->view('confirm_u2_otp', $data);
			}
		}
	}
	public function u2_Signup($phone)
	{
		// redirect(base_url() . 'Admin/adminLogin');
		$data['phone'] = base64_decode($phone) ;
		$this->load->view('u2/u2_Signup', $data);
	}








	public function teacherSignup()
	{
		// redirect(base_url() . 'Admin/adminLogin');
		$this->load->view('teacherSignup');
	}
	public function confirm_otp()
	{
		$rules = array(
			array('field' => 'phone', 'label' => 'phone', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
		
			$this->session->set_flashdata('category_error', validation_errors() );
			
			redirect(base_url('User/teacherSignup'));
		} else {
		$data['phone'] = $this->lib->validate($this->input->post('phone'));
		$otp = rand(1000,9999) ; 
		$insert = 'na' ;
		$count = $this->lib_model->Counter('sent_otp', array('meta' => $data['phone']));
		if ($count == 0) {
		$f = array(
			'otp' => $otp,
			'meta' => $data['phone'],				
			);
		$insert = $this->lib_model->Insert('sent_otp', $f);
		}
		
		if ($count <> 0) { $insert = 0 ; }
		$data['rs'] = $this->lib_model->Select('sent_otp', '*', array('meta' => $data['phone']));
			
		if(!empty($data['rs'])){ 
			$this->session->set_flashdata('category_success', 'Otp Sent Successfully. - Sent OTP - ' . $data['rs'][0]->otp );
			$this->load->view('confirm_otp', $data);
		}
		else{
			$this->session->set_flashdata('category_error', 'Something Went Wrong.');
			redirect(base_url('User/teacherSignup'));	
		} 		}
	}
	public function confirm_otp_process()
	{		$data['rs'] = 0;
		$data['phone'] = $phone = $this->lib->validate($this->input->post('phone'));
		$rules = array(
			array('field' => 'phone', 'label' => 'phone', 'rules' => 'required') ,
		
		);
		
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			
			$this->session->set_flashdata('category_error', validation_errors() );			
			$this->load->view('confirm_otp', $data);
		} else {
			
					
			$data['phone'] = $phone = $this->lib->validate($this->input->post('phone'));
			$otp = $this->lib->validate($this->input->post('otp'));
		
	$count = $this->lib_model->Counter('sent_otp', array('meta' => $phone, 'otp' => $otp));

			if ($count <> 0) {
					$f = array('status' => 1,);
				$this->lib_model->Update('sent_otp', $f, array('meta' => $phone, 'otp' => $otp));
				
				$this->session->set_flashdata('category_success', 'Fill Registration Form .');
				// $this->load->view('direct_Signup', $data);
				redirect(base_url('User/dt_Signup/'. base64_encode($phone)));
				// $this->dt_Signup($phone);	
			}
			if ($count == 0) {
				
				$this->session->set_flashdata('category_error', 'OTP Not Matched');
				$this->load->view('confirm_otp', $data);
			}
		}
	}


	public function dt_Signup($phone)
	{
		// redirect(base_url() . 'Admin/adminLogin');
		$data['phone'] = base64_decode($phone) ;
		$this->load->view('user/direct_Signup', $data);
	}
	public function dtSignUpProcess()
	{		
		$rules = array(
			array('field' => 'phone', 'label' => 'phone', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
		
			$this->session->set_flashdata('category_error', validation_errors() );
			 
			redirect(base_url('User/index'));
		} else {
			$name = $this->lib->validate($this->input->post('name'));
			$email = $this->lib->validate($this->input->post('email'));			
			$role = $this->lib->validate($this->input->post('role'));
			$phone = $this->lib->validate($this->input->post('phone'));
			$city = $this->lib->validate($this->input->post('city'));
			$password = $this->lib->validate($this->input->post('password'));
			// $upload_file = $file_name ;
			$count = $this->lib_model->Counter('student', array('phone' => $phone));

			if ($count == 0) {
				
				$w_id = 1 ;
				if ($w_id) {
				$f = array(
					'name' => $name,
					'email'=>$email,
					'role'=>$role,
					'phone'=>$phone,
					'city'=> trim($city),	
					'wallet_id'=> '0' ,		
					'password'=>$password,					
					);				
				$insert= $this->lib_model->Insert('student', $f);
				$this->session->set_flashdata('category_success', 'Registered Successfully.');
				redirect(base_url('User/index/1'));
				} 	else { 
					$this->session->set_flashdata('category_error', 'Something Went Wrong.');
				redirect(base_url('User/dt_Signup/'. base64_encode($phone)));
				}
				} else {
				$this->session->set_flashdata('category_error', 'Duplicate Phone Number .');
				redirect(base_url('User/dt_Signup/'. base64_encode($phone)));
			}


		}
	}
	public function login()
	{
		$flash = $this->uri->segment(3);		
		if($flash == 1){
		$this->session->set_flashdata('category_success', 'Registered Successfully.');	
	}
		$this->load->view('adminlogin');
	}

	public function signUpTeacherProcess2()
	{
			

			$phone = $this->lib->validate($this->input->post('phone'));
			$rules = array(
				array('field' => 'phone', 'label' => 'phone', 'rules' => 'required')
			);
	
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			
				$this->session->set_flashdata('category_error', validation_errors() );
				
				redirect(base_url('User/dt_Signup/'. base64_encode($phone)));
			} else {

				 
				$tt = time();
				$this->load->library('upload');
				$new_name = $tt . $_FILES["img"]['name'];
				$config['upload_path'] = 'img/profile/';
				
				$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPG|pjpeg|pdf|doc|docx|ppt|pptx|txt';
				$config['max_size'] = 1100;
				$config['file_name'] = $new_name;
				$this->upload->initialize($config);
		
				if ($this->upload->do_upload('img')) {
					$upload_data = $this->upload->data();
					$file_name = $upload_data['file_name'];
					
				} else { 
					$this->session->set_flashdata('category_error', 'File size not Allowed .');
						redirect(base_url('User/dt_Signup/'. base64_encode($phone)));
				}
				


				// id_img
					
				$tt = time();
				$this->load->library('upload');
				$new_name = $tt . $_FILES["id_img"]['name'];
				$config['upload_path'] = 'img/t_documents/';
				
				$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPG|pjpeg|pdf|doc|docx|ppt|pptx|txt';
				$config['max_size'] = 1100;
				$config['file_name'] = $new_name;
				$this->upload->initialize($config);
		
				if ($this->upload->do_upload('id_img')) {
					$upload_data = $this->upload->data();
					$file_name2 = $upload_data['file_name'];
					
				} else {					
					$this->session->set_flashdata('category_error', 'File size not Allowed .');
						redirect(base_url('User/dt_Signup/'. base64_encode($phone)));
				}
				$pro_pic = $file_name ;
				$id_card_img = $file_name2 ;
				// $insert = 'na' ;
				$name = $this->lib->validate($this->input->post('name'));
				// $email = $this->lib->validate($this->input->post('email'));			
				
				$gender = $this->lib->validate($this->input->post('gender'));
				$tut_type_h = $this->lib->validate($this->input->post('tut_type_h'));
				$tut_type_c = $this->lib->validate($this->input->post('tut_type_c'));
				$tut_type_o = $this->lib->validate($this->input->post('tut_type_o'));

				$qualification = $this->lib->validate($this->input->post('quali'));
				$other_quali = $this->lib->validate($this->input->post('other_quali'));
				$t_morning = $this->lib->validate($this->input->post('t_morning'));
				$t_noon = $this->lib->validate($this->input->post('t_noon'));

				$t_evening = $this->lib->validate($this->input->post('t_evening'));
				$t_night = $this->lib->validate($this->input->post('t_night'));
				$any_time = $this->lib->validate($this->input->post('any_time'));
				$lang_h = $this->lib->validate($this->input->post('lang_h'));

				$lang_en = $this->lib->validate($this->input->post('lang_en'));
				$cbse = $this->lib->validate($this->input->post('CBSE'));
				$icse = $this->lib->validate($this->input->post('ICSE'));
				$other = $this->lib->validate($this->input->post('OTHER'));

				$c1 = $this->lib->validate($this->input->post('c1'));
				$c2 = $this->lib->validate($this->input->post('c2'));
				$c6 = $this->lib->validate($this->input->post('c6'));
				$c8 = $this->lib->validate($this->input->post('c8'));

				$c9 = $this->lib->validate($this->input->post('c9'));
				$c10 = $this->lib->validate($this->input->post('c10'));
				$c11 = $this->lib->validate($this->input->post('c11'));
				$c12 = $this->lib->validate($this->input->post('c12'));
if($any_time == 1 ){ $t_morning = 1 ; $t_noon = 1 ; $t_evening = 1 ; $t_night = 1 ;  }
				// $upload_file = $file_name ;
				$count = $this->lib_model->Counter('teacher', array('phone' => $phone));
	
				if ($count == 0) {
					$f = array(
							'name' => $name,
							// 'email'=>$email,
							'phone'=>$phone,
							// 'subject'=> $s_id,
							// 'age'=>$age,
							'meta'=>$gender,					
						);
						
					$t_id = $this->lib_model->Insert('teacher', $f);

					if ($t_id) {
				
						$g = array(
							'u_id' => $t_id,
							'img'=>$pro_pic,
							'id_card_img'=>$id_card_img,
							'gender'=> $gender,
							'tut_type_h'=>$tut_type_h,
							'tut_type_c'=>$tut_type_c,
							'tut_type_o'=>$tut_type_o,	
											
						);
						$tp_id = $this->lib_model->Insert('teacher_p_info', $g);
					}
					if ($tp_id) {
				
						$h = array(
							'm_id' => $t_id,
							'qualification'=>$qualification,
							'other_quali'=>$other_quali,
							't_morning'=> $t_morning,
							't_noon'=>$t_noon,
							't_evening'=>$t_evening,
							't_night'=>$t_night,	
							'any_time' => $any_time,
							'lang_en'=>$lang_en,
							'lang_h'=>$lang_h,
							'cbse'=> $cbse,
							'icse'=>$icse,
							'other'=>$other,
							'c1'=>$c1,
							'c2'=> $c2,
							'c6'=>$c6,
							'c8'=>$c8,
							'c9'=>$c9,	
							'c10'=>$c10,
							'c11'=>$c11,
							'c12'=>$c12,	
											
						);
						$insert = $this->lib_model->Insert('teacher_edu_info', $h);
					}}
					if($count <> 0){ 
						$this->session->set_flashdata('category_error', 'Duplicate Phone Number .');
						redirect(base_url('User/dt_Signup/'. base64_encode($phone)));
					}	
					if(!empty($insert)) { 
					$this->session->set_flashdata('category_success', 'Registered Successfully.');						
					redirect(base_url('User/userLogin/1'));
					}
					if( (empty($insert)) || (empty($t_id)) || (empty($tp_id)) ) { 
					$this->session->set_flashdata('category_error', 'Something Went Wrong.');
					redirect(base_url('User/dt_Signup/'. base64_encode($phone)));									
				} 
			}
	}
	
	
	public function userLogin()
	{
		$flash = $this->uri->segment(3);		
		if($flash == 1){
		$this->session->set_flashdata('category_success', 'Registered Successfully.');	
	}
		$this->load->view('adminlogin');
	}
	
	public function ConfirmLoginOtp()
	{
		$this->load->view('ConfirmLoginOtp');
	}
	public function sendOTP()
    {
        $data['phone'] = isset($_REQUEST['org_id']) ? $_REQUEST['org_id'] : '';
      
		$data['otp'] =  $otp = rand(1000,9999) ; 
	  $count = $this->lib_model->Counter('sent_otp', array('meta' => $data['phone']));
	  $updated = 'na';
        if ($count <> 0) {
            $f = array('otp' => $otp,);
			$updated = $this->lib_model->Update('sent_otp', $f, array('meta' => $data['phone']));
			$g = array('password' => $otp,);
			$t_avail = $this->lib_model->Counter('teacher', array('phone' => $data['phone']));
			if($t_avail <> 0){		
			$update_teacher = $this->lib_model->Update('teacher', $g, array('phone' => $data['phone']));
			$data['updated'] = 1 ;
				}
			$s_avail = $this->lib_model->Counter('student', array('phone' => $data['phone']));
			if($s_avail <>  0){
				$update_student = $this->lib_model->Update('student', $g, array('phone' => $data['phone']));
				$data['updated'] = 2 ;	
			}
		}
		if($count == 0){ 	$data['updated'] = 0 ;}
		
        echo json_encode($data);              
            
       
	}
	

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
			redirect(base_url() . 'User/login');
		} else {
			$username = $this->lib->validate($this->input->post('username'));
			$password = $this->lib->validate($this->input->post('password'));

			$username = $this->security->xss_clean($username);
			$password = $this->security->xss_clean($password);
			$student = 0 ;
			
			$rs = $this->lib_model->Select('teacher', '*', array('phone' => $username, 'password' => $password));
			if(empty($rs)){
	$ss = $this->lib_model->Select('student', '*', array('phone' => $username, 'password' => $password));
	$student = 1;
			}
			
			if (count($rs) == 1) {
				foreach ($rs as $r)
				{
					$Sessions = array(
						'u_id' => $r->t_id,
						'Name' => $r->UserName,
						'phone'   =>$r->phone,
						'ELogin' => true);
				}
				$this->session->set_userdata($Sessions);
				$Msg = array('Msg' => ' Have a Nice Day ', 'Type' => 'success');
				//$this->session->set_flashdata($Msg);
				$this->session->set_flashdata('msg', 'Have a Nice Day');
				redirect(base_url() . 'user/dashboard');

			} else if (count($ss) == 1) {
				foreach ($ss as $r)
				{
					$Sessions = array(
						's_id' => $r->s_id,
						'Name' => $r->name,
						'phone'   =>$r->phone,
						'ELogin' => true);
				}

				$this->session->set_userdata($Sessions);

				$Msg = array('Msg' => ' Have a Nice Day ', 'Type' => 'success');
				//$this->session->set_flashdata($Msg);
				$this->session->set_flashdata('msg', 'Have a Nice Day');
				redirect(base_url() . 'student/dashboard');
			}
			else {
				$Msg = array('Msg' => 'Username and Password Invalid', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				$this->session->set_flashdata('msg', 'Invalid Username or Password ');
				redirect(base_url() . 'Admin/adminLogin');
			}
		}

	}
	
/*
	 *  Faculty Subject Mapping List and admin dashboard 
	 */
	public function machineList()
	{
		$sess = $this->session->userdata();
		
		
		// $data['rs'] = $this->lib_model->Select('v_faculty_mapping', 'UserId, `SubjId`,`UserId` `UserSubjectId`, `FullName`, `IsFaculty`,`SubjectName`', array());
		// If($sess['username']== 'admin'){
			$data['rs'] = $this->lib_model->Select('machine_master', '*', array('status' => 0));
			$this->load->view('admin/header',$data);
			$this->load->view('admin/mList');
			$this->load->view('admin/footer');
	// }else {('error');}
	}

	public function Dashboard()
	{
	
		// $data['rs'] = $this->lib_model->product_list();
		// prx($data['rs']) ;
		redirect(base_url() . 'u1/dashboard');
		$this->load->view('user/header');
		// $this->load->view('admin/mList',$data);
		$this->load->view('user/footer');
	}

	/*
     * Logout
     */
	public function Logout()
	{

		unset($this->session->ELogin);
		session_destroy();
		redirect(base_url());
	}
	}


























