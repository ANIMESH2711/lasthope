<?php


class Admin extends CI_Controller
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

	/*    
	 * Index
	 */
	public function index()
	{
		$flash = '' ;
		$flash = $this->uri->segment(3);		
		if($flash == 1){
		$this->session->set_flashdata('category_success', 'Registered Successfully.');	
	}
		$this->load->view('home');
	}
	public function adminLogin()
	{
		$this->load->view('adminlogin');
	}
	public function Auth()
	{
		//prx($this->input->post());
		$rules = array(
			array('field' => 'username', 'label' => 'Username', 'rules' => 'required'),
			array('field' => 'password', 'label' => 'Password', 'rules' => 'required'),
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url() . 'login');
		} else {
			$username = $this->lib->validate($this->input->post('username'));
			$password = $this->lib->validate($this->input->post('password'));

			$username = $this->security->xss_clean($username);
			$password = $this->security->xss_clean($password);

			$rs = $this->lib_model->Select('login', '*', array('username' => $username, 'password' => $password));
			$ap =  0 ;if (!empty($rs)) { $ap =  1 ; }
			if (empty($rs)) {
$rs = $this->lib_model->Select('student', '*', array('phone' => $username, 'password' => $password));
				if (!empty($rs)){
				foreach ($rs as $r)
				{	
					
					$Sessions = array(
						'username' => $username,
						's_id' => $r->s_id,
						'name' => $r->name,
						'phone' => $r->phone,
						'role' => $r->role ,
						'email' => $r->email,
						'city'   =>$r->city,
						'ELogin' => true);	
				} 
				
				$this->session->set_userdata($Sessions);

				$Msg = array('Msg' => ' Have a Nice Day ', 'Type' => 'success');
				//$this->session->set_flashdata($Msg);
				$this->session->set_flashdata('msg', 'Have a Nice Day');
				if($rs[0]->role == 1){
				redirect(base_url() . 'User/dashboard');
				}
				else{
			redirect(base_url() . 'U2/dashboard');
				}
			}else {
				$Msg = array('Msg' => 'Username and Password Invalid', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				$this->session->set_flashdata('msg', 'Invalid Username or Password ');
				redirect(base_url() . 'login');
			}

				} else if (!empty($rs)){
			
				foreach ($rs as $r)
				{
						$Sessions = array(
							'username' => $username,							
							'phone'   =>$r->phone,'Name' => $r->username,
							'ELogin' => true);
				}
				$this->session->set_userdata($Sessions);

				$Msg = array('Msg' => ' Have a Nice Day ', 'Type' => 'success');
				//$this->session->set_flashdata($Msg);
				$this->session->set_flashdata('msg', 'Have a Nice Day');

				redirect(base_url() . 'Admin/dashboard');

			} else {
				$Msg = array('Msg' => 'Username and Password Invalid', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				$this->session->set_flashdata('msg', 'Invalid Username or Password ');
				redirect(base_url() . 'login');
			}
		}
prx('Please Try Again .');
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
	// }else {prx('error');}
	}

	public function Dashboard()
	{
		$p_id = $_SESSION['s_id'] ;
		$data['name'] = $_SESSION['name'] ;
		$data['rs'] = $this->lib_model->product_list($p_id);		
			
		$this->load->view('admin/header',$data);
		$this->load->view('admin/mList');
		$this->load->view('admin/footer');
	}


	
	public function viewDetails()
    {   
        
       
        $p_id = ($this->input->post('p_id'));       
       $rs = $data['viewDetails'] = $this->lib_model->Select('product_master', '*', array('p_id' => $p_id));
        // prx('ok');
        if ($data['viewDetails']) {
            $data['msg'] = "success";
			$data['city'] =  $rs[0]->cat_id ;
			$data['pincode'] =  $rs[0]->sub_cat_id ;
			$data['landmark'] =  $rs[0]->price ;
			$data['detail'] =  $rs[0]->remark ;
		 
			$data['success'] =  'done' ;
          
            exit(json_encode($data));
        } else {
			$data['success'] =  'failed' ; 
            $data['msg'] = "failed";
            
            exit(json_encode($data));
        }
    }


/*
	 * Add Category
	 */
	public function addMachine()
	{
		$data['rs'] = $this->lib_model->Select('cat_master', '*', array('status' => 0));
			
		$this->load->view('admin/header',$data);
		$this->load->view('admin/addMachine');
		$this->load->view('admin/footer');
	}
   
/*
	 * Add Category Process
	 */
	public function addMachineProcess()
	{
		
		$rules = array(
			array('field' => 'cat_id', 'label' => 'cat_id', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddCategory'));
		} else {

			$tt = time();
		$this->load->library('upload');
		$new_name = $tt . $_FILES["img"]['name'];
		$config['upload_path'] = 'img/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPG|pjpeg|pdf|doc|docx|ppt|pptx|txt';
		$config['max_size'] = 20000;
		$config['file_name'] = $new_name;
		$this->upload->initialize($config);

		if ($this->upload->do_upload('img')) {
			$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
		
		} else {
			$Msg = array('Msg' => 'Something Went wrong', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('u1/addRequest'));
		}
			// prx($this->input->post());
			$cat_id = $this->lib->validate($this->input->post('cat_id'));
			$sub_cat = $this->lib->validate($this->input->post('sub_cat'));			
			$name = $this->lib->validate($this->input->post('name'));
			$price = $this->lib->validate($this->input->post('price'));
			$remarks = $this->lib->validate($this->input->post('remarks'));
			$upload_file = $file_name ;
			$count = $this->lib_model->Counter('product_master', array('remark' => $remarks));

			if ($count == 0) {
				$f = array(
					'cat_id' => $cat_id,
					'sub_cat_id'=>$sub_cat,
					'name'=> $_SESSION['s_id'],
					'price'=>$price,
					'img' => $upload_file,
					'remark'=>trim($remarks),
					'status' => 0,
					);
					
			$inserted = $this->lib_model->Insert('product_master', $f);
			if ($inserted) {
				// पुलिस ''' कि '' # हटती ''तो ''#सबकी''फटती है. __''लेकिन'' जब '''' # अपने_भाई ''''की फोटो FB pEडलती है , तो अच्छे अच्छो की जलती है...!!! ... ★★★★ ★
				$Msg = array('Msg' => 'Added Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('u1/addRequest'));
			}else{
				$Msg = array('Msg' => 'Something went Wrong', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('u1/addRequest'));
			} } else {
				$Msg = array('Msg' => 'Something went Wrong', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('u1/addRequest'));
			}


		}
	}

	public function delete_product($p_id)
	{
		$data['rs'] = $this->lib_model->delete('product_master', array('p_id' => $p_id));
		// prx($data);
		$Msg = array('Msg' => 'Product Deleted Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/dashboard'));
	}
	public function edit_product($p_id)
	{
		$product = $data['p_detail'] = $this->lib_model->Product_detail($p_id);
		$cat_id = $product[0]->cat_id ; 
		$data['all_cat'] = $this->lib_model->Select('cat_master', '*', array());
		$data['all_sub_cat'] = $this->lib_model->Select('sub_cat_master', '*', array());
		$data['available_sub_cat'] = $this->lib_model->Select('sub_cat_master', '*', array('cat_id' => $cat_id));
		// prx($data['available_sub_cat']) ;
		$this->load->view('admin/header',$data);
		$this->load->view('admin/edit_product');
		$this->load->view('admin/footer');
		// prx($data['p_id']) ;
	}




	public function editMachineProcess()
	{
		
		$rules = array(
			array('field' => 'cat_id', 'label' => 'cat_id', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddCategory'));
		} else {

			$tt = time();
		$this->load->library('upload');
		$new_name = $tt . $_FILES["img"]['name'];
		$config['upload_path'] = 'img/';
		$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPG|pjpeg|pdf|doc|docx|ppt|pptx|txt';
		$config['max_size'] = 2000000;
		$config['file_name'] = $new_name;
		$this->upload->initialize($config);

		if ($this->upload->do_upload('img')) {
			$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
			
		} else{
			$file_name = $this->input->post('file_name');
		}
			// prx($this->input->post());
			$cat_id = $this->lib->validate($this->input->post('cat_id'));
			$sub_cat = $this->lib->validate($this->input->post('sub_cat'));			
			$name = $this->lib->validate($this->input->post('name'));
			$price = $this->lib->validate($this->input->post('price'));
			$remarks = $this->lib->validate($this->input->post('remarks'));
			$p_id = $this->lib->validate($this->input->post('p_id'));
			$upload_file = $file_name ;
			$count = 0;//$this->lib_model->Counter('product_master', array('p_id' => $mcode));

			if ($count == 0) {
				$f = array(
					'cat_id' => $cat_id,
					'sub_cat_id'=>$sub_cat,
					'name'=>$name,
					'price'=>$price,
					'img' => $upload_file,
					'remark'=>$remarks,
					'status' => 0,
					);
					// prx($f);
					$this->lib_model->Update('product_master', $f, array('p_id' => $p_id));
				$Msg = array('Msg' => 'Product Edited Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/dashboard'));
			} else {
				$Msg = array('Msg' => 'Something went Wrong', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/dashboard'));
			}


		}
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


























