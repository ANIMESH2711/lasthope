<?php


class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('lib');
		$this->load->model('lib_model');
		$this->load->helper('string');
		$this->load->library(array('emaillibrary','uploadfiles', 'PHPExcel/Classes/PHPExcel'));
		// $this->load->library(array('emaillibrary','uploadfiles'));
		$this->load->helper(array('email_helper'));
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
		$this->load->view('admin/index');


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
			redirect(base_url() . 'Admin/');
		} else {
			$username = $this->lib->validate($this->input->post('username'));
			$password = $this->lib->validate($this->input->post('password'));

			$username = $this->security->xss_clean($username);
			$password = $this->security->xss_clean($password);

			$rs = $this->lib_model->Select('login', '*', array('username' => $username, 'password' => $password));
			if (count($rs) == 1) {
				foreach ($rs as $r)
				{
					$Sessions = array(
						'username' => $username,
						'Name' => $r->UserName,
						'phone'   =>$r->phone,
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
				redirect(base_url() . 'Admin/');
			}
		}

	}
	


public function Dashboard()
	{

		$data['rk'] = $this->lib_model->Select('smtp', '*', array());
		$this->load->view('admin/header',$data);
		$this->load->view('admin/smtp');
		$this->load->view('admin/footer');
	}

public function addSmtpPage()
	{

		$data['rk'] = $this->lib_model->Select('smtp', '*', array());
		$this->load->view('admin/header',$data);
		$this->load->view('admin/addSmtp');
		$this->load->view('admin/footer');
	}
	public function addSmtp()
	{
		
			$server = $this->input->post('server');
			$port = $this->input->post('port');
			$Username = $this->input->post('Username');
			$Password = $this->input->post('Password');
			$From_id = $this->input->post('From');

			$meta1 = $this->input->post('meta1');

			$meta2 = $this->input->post('meta2');
			//prx($server);
$count = $this->lib_model->Counter('smtp', array('Username' => $Username));


			if ($count == 0) {
				$f = array(
					'server' => $server,
					
					'port'=>$port,
					'Username'=>$Username,
					'Password'=>$Password,
					'From_id'=>$From_id,
					'meta1'=>$meta1,
					'meta2'=>$meta2,

					'created_at' => date('Y-m-d H:i:s'),
										

				);
		

				$this->lib_model->Insert('smtp', $f);
				
				
				 $this->session->set_flashdata('success', 'SMTP Sucessfully added  ');
      

				redirect(base_url('Admin/addSmtppage'));
			} else {
			
				
				
				$this->session->set_flashdata('error', 'Duplicate Username Or Something went wrong  wrong. Error!!');
      
				
				
				
				redirect(base_url('Admin/addSmtppage'));
			}


		
	}
	
	
	
// 			if($counter == 0){
// 			}
// 			if($counter !== 0){
	
// 				$this->lib_model->Update('smtp', $f, array());
// 				$Msg = array('Msg' => 'smtp Add Successfully', 'Type' => 'success');
// 				$this->session->set_flashdata($Msg);
// 				$this->session->set_flashdata('message_name', 'smtp updated Successfully');
// 			}
  

	public function uploadcsv()
    {
        $this->checkPermission();

        //$data['rs'] = $this->Lib_model->Select('ur_super_users', '*', array());
        //prx($sess_data['role_id']);
        $this->load->view('includes/common_header', $data);
        $this->load->view('uploadSkillSubject');
        $this->load->view('includes/common_footer');
    }
   
    public function csvProcess()
    {
        $relation_pair = 0;
        $file = $_FILES['excel_file'];
        $ex_file = explode('.', $file['name']);
        $ext = end($ex_file);
        $in_ext = ['xls', 'xlsx', 'csv'];
        if (!in_array($ext, $in_ext)) {
            $this->session->set_flashdata('error', 'Only excel file is required. Given in other formats');
        } else {
            $isUpload = $this->uploadfiles->uploadImages($file, $file['name'], $path = FCPATH . 'excel_upload/');
            if ($isUpload) {
                $inputFileName = FCPATH . 'excel_upload/' . $file['name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $readData = $sheet->rangeToArray('A1:' . $highestColumn . $highestRow);
                $c = 0;
                $inst = [];
				//prx($readData);
				$where = $this->input->post('smtp_id');
                foreach ($readData as $data) {
                    //prx($data[0]);
                   
            //         $data = array(
			// 			'email' => $email,
			// 			'username' => '12345',
			// 			'password' => '78887887',
			// 		);
			// 	}
			// }
			// pu_details_mail($data);
			$adress = $data[0];
			$vefyEmail=[
				'where' => $where,
				'email'=>$adress,
			   
	   ];
	  $status = facultyverifyVideo($vefyEmail);
	 // print_r ($status);die;

                   
                    $data['count'] = $c++;
                }
                //prx($log_array);
                $this->session->set_flashdata('success', 'Information saved successfully.');
                redirect('Admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Error please try again !!!');
                redirect('Admin/dashboard');
            }
        }
    }


































































	public function Authold()
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
		} else {
			$username = $this->lib->validate($this->input->post('username'));
			$password = $this->lib->validate($this->input->post('password'));

			$username = $this->security->xss_clean($username);
			$password = $this->security->xss_clean($password);

			$rs = $this->lib_model->Select('userlogin', 'UserId,UserName', array('UserEmail' => $username, 'UserPass' => $password, 'IsUserActive' => 0));
			if (count($rs) == 1) {
				foreach ($rs as $r)
				{
					$Sessions = array(
						'EmpCode' => $username,
						'EmpName' => $r->UserName,
						'EmpId'   =>$r->UserId,
						'ELogin' => true);
				}


				$this->session->set_userdata($Sessions);

				$Msg = array('Msg' => ' Have a Nice Day ', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url() . 'Faculty/dashboard');


			} else {
				$Msg = array('Msg' => 'Username and Password Invalid', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url() . 'Admin/');
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


/*
	 *  Faculty Subject Mapping List and admin dashboard 
	 */



 function fetch_user(){  
           $this->load->model("crud_model");  
           $fetch_data = $this->crud_model->make_datatables();  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                 
                $sub_array[] = $row->first_name;  
                $sub_array[] = $row->last_name;  
                $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs">Update</button>';  
                $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs">Delete</button>';  
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->crud_model->get_all_data(),  
                "recordsFiltered"     =>     $this->crud_model->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);  
      }  
      function user_action(){  
           if($_POST["action"] == "Add")  
           {  
                $insert_data = array(  
                     'first_name'          =>     $this->input->post('first_name'),  
                     'last_name'               =>     $this->input->post("last_name"),  
                                         
                );  
                $this->load->model('crud_model');  
                $this->crud_model->insert_crud($insert_data);  
                echo 'Data Inserted';  
           }  
      }  
      function upload_image()  
      {  
           if(isset($_FILES["user_image"]))  
           {  
                $extension = explode('.', $_FILES['user_image']['name']);  
                $new_name = rand() . '.' . $extension[1];  
                $destination = './upload/' . $new_name;  
                move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);  
                return $new_name;  
           }  
      }  
  











/*
	 * show single question tp admin*/

	public function viewques($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_addques', 'subjectcode,status,id,name,about', array('id' => $data['Id']));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/viewques');
		$this->load->view('admin/footer');
	}








/*
	 * show All question tp Faculty
	 */
public function account()
	{



		
$data['rs'] = $this->lib_model->Select('m_faculty', 'id,username,name,email,status', array('id' => $this->session->EmpId));
		
	
			# code...
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/account');
		$this->load->view('admin/footer');
	
}







	/*
	 * Dashboard
	 
	public function Dashboard()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}
*/
	/*
	 * Add Category
	 */
	public function AddSubject()
	{

		$this->load->view('admin/header');
		$this->load->view('admin/AddSubject');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
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
			redirect(base_url('admin/AddCategory'));
		} else {

			$CName = $this->lib->validate($this->input->post('CName'));
			$CAbout = $this->lib->validate($this->input->post('CAbout'));
			$CCode = $this->lib->validate($this->input->post('CCode'));
			$CType = $this->lib->validate($this->input->post('CType'));

			$count = $this->lib_model->Counter('subject', array('SubjectCode' => $CCode));

			if ($count == 0) {
				$f = array(
					'SubjectName' => $CName,
					//'about' => $CAbout,
					'SubjectCode'=>$CCode,
					//'type'=>$CType,
					//'status' => 0,
					'CreateTs' => date('Y-m-d H:i:s'),
					//'createdIp' => $this->input->ip_address(),
					'CreateUserId' => 'Admin'

				);


				$this->lib_model->Insert('subject', $f);
				$Msg = array('Msg' => 'Subject Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddSubject'));
			} else {
				$Msg = array('Msg' => 'Subject Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddSubject'));
			}


		}
	}

	/*
	 * Add Category
	 */
	public function AddAttr()
	{

		$this->load->view('admin/header');
		$this->load->view('admin/AddAttr');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function AddAttrProcess()
	{
		$rules = array(
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddAttr'));
		} else {

			$CName = $this->lib->validate($this->input->post('CName'));

			$CAbout = $this->lib->validate($this->input->post('CAbout'));

			$count = $this->lib_model->Counter('m_attribute', array('name' => $CName));
			if ($count == 0) {
				$f = array(
					'name' => $CName,
					'about' => $CAbout,
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdip' => $this->input->ip_address(),
					'createdby' => 'Admin'

				);


				$this->lib_model->Insert('m_attribute', $f);
				$Msg = array('Msg' => 'Attribute Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddAttr'));
			} else {
				$Msg = array('Msg' => 'Attribute Already Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddAttr'));
			}


		}
	}

	/*
	 * Add Category
	 */
	public function AddCoupon()
	{

		$this->load->view('admin/header');
		$this->load->view('admin/AddCoupon');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function AddCouponProcess()
	{
		$rules = array(
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddCoupon'));
		} else {

			$CName = $this->lib->validate($this->input->post('CName'));

			$CAbout = $this->lib->validate($this->input->post('CAbout'));
			$Code = $this->lib->validate($this->input->post('Code'));
			$Per = $this->lib->validate($this->input->post('Per'));

			$count = $this->lib_model->Counter('m_copoun', array('name' => $CName));
			if ($count == 0) {
				$f = array(
					'name' => $CName,
					'about' => $CAbout,
					'code' => $Code,
					'Per' => $Per,
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address()

				);


				$this->lib_model->Insert('m_copoun', $f);
				$Msg = array('Msg' => 'copoun Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddCoupon'));
			} else {
				$Msg = array('Msg' => 'Coupon Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddCoupon'));
			}


		}
	}

	/*
	 * Add Category
	 */
	public function AddFaculty()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/AddFaculty');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function AddFacultyProcess()
	{
		$rules = array(
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required'),
			array('field' => 'Eid', 'label' => 'Enrollment', 'rules' => 'required'),

		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddFaculty'));
		} else {

			$CName = $this->lib->validate($this->input->post('CName'));
			$CAbout = $this->lib->validate($this->input->post('CAbout'));
			$Eid = $this->lib->validate($this->input->post('Eid'));
			$Mobile = $this->lib->validate($this->input->post('Mobile'));
			$Email = $this->lib->validate($this->input->post('Email'));
			$Address = $this->lib->validate($this->input->post('Address'));
			$pwd = $this->lib->validate($this->input->post('password'));

			$count = $this->lib_model->Counter('m_faculty', array( 'enrollment' => $Eid,));
			if ($count == 0) {
				$f = array(
					'UserName' => $CName,
					'UserPass' => $pwd,
					'FullName' => $CAbout,
					'enrollment'=>$Eid,
					'mobile'=>$Mobile,
					'address'=>$Address,
					'email'=>$Email,
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
					'createdBy' => 'Admin',

				);


				$this->lib_model->Insert('m_faculty', $f);
				$Msg = array('Msg' => 'Faculty Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddFaculty'));
			} else {
				$Msg = array('Msg' => 'Enrollment Id  Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddFaculty'));
			}


		}
	}


	/*
	 * Add Product
	 */
	public function AddProduct()
	{
		$data['rs']  = $this->lib_model->Select('m_category', 'id,name', array('status' => 0));
		$data['rs2'] = $this->lib_model->Select('m_attribute', 'id,name', array('status' => 0));
		$this->load->view('admin/header', $data);
		$this->load->view('admin/AddProduct');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function AddProductProcess()
	{
		$rules = array(
			array('field' => 'Category', 'label' => 'Category', 'rules' => 'required'),
			array('field' => 'name', 'label' => 'CName', 'rules' => 'required')

		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddProduct'));
		} else {

			$CName = $this->lib->validate($this->input->post('name'));
			$Category = $this->lib->validate($this->input->post('Category'));
			$SubCategory = $this->lib->validate($this->input->post('SubCategory'));
			$price = $this->lib->validate($this->input->post('price'));
			//$Pd = date('Y-m-d', strtotime($this->input->post('pd')));
			//$Ed = date('Y-m-d', strtotime($this->input->post('ed')));
			$weight = $this->lib->validate($this->input->post('weight'));
			$mu     = $this->lib->validate($this->input->post('mu'));

			$count = $this->lib_model->Counter('m_product', array('name' => $CName, 'category' => $Category));
			if ($count == 0) {
				$f = array(
					'category' => $Category,
					'name' => $CName,
					'price' => $price,
					'weight' => $weight,
					'mu'=>$mu,
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
					'createdBy' => 'Admin'

				);


				$Pid = $this->lib_model->Insert('m_product', $f);

				/*
				 * Sub Category Insert
				 */
				$SubCategory = $_REQUEST['SubCategory'];
				foreach ($SubCategory as $k => $v) {
					$f2 = array(
						'created' => date('Y-m-d H:i:s'),
						'pid' => $Pid,
						'sid' => $v
					);
					$this->lib_model->Insert('m_productsubcategory', $f2);
				}

				/*
				 * Attribute Insert
				 */
				$rs2 = $this->lib_model->Select('m_attribute', 'id,name', array('status' => 0));
				foreach ($rs2 as $r2)
				{
					$AI =  $this->lib->validate($this->input->post('AI'.$r2->id));
					$AV =  $this->lib->validate($this->input->post('AV'.$r2->id));

					$fa = array(
						'pid'=>$Pid, 'aid'=>$AI, 'name'=>$AV, 'status'=>0, 'created'=>date('Y-m-d H:i:s'), 'createdby'=>'Admin'
					);
					$this->lib_model->Insert('m_productattribute',$fa);
				}


				$Msg = array('Msg' => 'Product Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddProduct'));
			} else {
				$Msg = array('Msg' => 'Product Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddProduct'));
			}


		}
	}

	/*
	 * Ajax List
	 */
	public function AjaxList()
	{
		$data['cid'] = $this->lib->validate($this->input->post('val'));
		$data['name'] = $this->lib->validate($this->input->post('name'));
		$data['title'] = $this->lib->validate($this->input->post('title'));

		$sql = "SELECT distinct type FROM `m_subcategory` WHERE `category`=? and status=?";
		$data['rs'] = $this->lib_model->Execute($sql, array($data['cid'], 0))->result();

		$this->load->view('admin/AjaxList', $data);

	}

	/*
	 *  CategoryList
	 */
	public function SubjectList()
	{



		//$data['r'] = $this->lib_model->Select('m_topic', 'id,topic,sid', array());

		$data['rs'] = $this->lib_model->Select('subject', 'SubjectId,SubjectCode,SubjectName,', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/SubjectList');
		$this->load->view('admin/footer');
	}





	/*
	 * Add Category Process
	 *
	public function EditCategoryProcess()
	{
		$rules = array(
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required'),
			array('field' => 'id', 'label' => 'Id', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/EditCategory'));
		} else {

			$Cid = $this->lib->validate($this->input->post('id'));
			$CName = $this->lib->validate($this->input->post('CName'));
			$CAbout = $this->lib->validate($this->input->post('CAbout'));


			$count = $this->lib_model->Counter('m_category', array('name' => $CName));
			if ($count == 0) {
				$f = array(
					'name' => $CName,
					'about' => $CAbout,
					'`modified`' => date('Y-m-d H:i:s'),
					'`modifiedBy`' => 'Admin',
					'`modifiedIp`' => $this->input->ip_address()
				);


				$this->lib_model->Update('m_category', $f, array('id' => $Cid));
				$Msg = array('Msg' => 'Category Update Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditCategory/' . $Cid));
			} else {
				$Msg = array('Msg' => 'Category Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditCategory/' . $Cid));
			}


		}
	}


*/


	/*
	 *  CategoryList
	 */
	public function AttributeList()
	{
		$data['rs'] = $this->lib_model->Select('m_attribute', 'id,name,about,status', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/AttributeList');
		$this->load->view('admin/footer');
	}

	/*
	 *  Sub CategoryList
	 */
	public function FacultyList()
	{

		$data['rs'] = $this->lib_model->Select('userlogin', 'UserName, FullName, UserId, UserMobile,UserAdd1,IsUserActive,CreateTs, Modts, UserEmail, ', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/FacultyList');
		$this->load->view('admin/footer');
	}

	/*
	 * Add FSM
	 */
	
	/*
	 * Add SS
	 */
	public function AddSS()
	{
		$data['rs']  = $this->lib_model->Select('m_subject', 'id,name,subjectcode', array('status' => 0));
		$data['rs2'] = $this->lib_model->Select('m_faculty', 'id,name', array('status' => 0));
		$this->load->view('admin/header', $data);
		$this->load->view('admin/AddSS');
		$this->load->view('admin/footer');
	}
	/*
	 *  Faculty Subject Mapping List
	 */
	public function FSMList()
	{

		$data['rs'] = $this->lib_model->Select('v_subject_faculty_mapping', 'status, `id`, `enrollment`, `name`, `subject`', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/FSMList');
		$this->load->view('admin/footer');
	}

	/*
	 *   Subject Supervisor List
	 */
	public function SSList()
	{

		$data['rs'] = $this->lib_model->Select('v_subject_supervisor_mapping', 'status, `id`, `enrollment`, `name`, `subject`', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/SSList');
		$this->load->view('admin/footer');
	}
	/*
	 * Add FSM
	 */
	public function AddFSMProcess()
	{
		$rules = array(
			array('field' => 'S', 'label' => 'Subject', 'rules' => 'required'),
			array('field' => 'F', 'label' => 'Faculty', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddFSM'));
		} else {

			$S = $this->lib->validate($this->input->post('S'));
			$F = $this->lib->validate($this->input->post('F'));


			$count = $this->lib_model->Counter('m_subject_faculty_mapping', array('fid' => $F,'sid'=>$S));
			if ($count == 0) {
				$f = array(
					'fid' => $F,
					'sid' => $S,
					'`created`' => date('Y-m-d H:i:s'),
					'`createdby`' => '',
					'`createdip`' => $this->input->ip_address()
				);


				$this->lib_model->Insert('m_subject_faculty_mapping', $f );
				$Msg = array('Msg' => 'Mapping Successfully done', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddFSM/' ));
			} else {
				$Msg = array('Msg' => 'Mapping Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddFSM/'));
			}


		}
	}

	/*
	 * Add FSM
	 */
	public function AddSSProcess()
	{
		$rules = array(
			array('field' => 'S', 'label' => 'Subject', 'rules' => 'required'),
			array('field' => 'F', 'label' => 'Faculty', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddSS'));
		} else {

			$S = $this->lib->validate($this->input->post('S'));
			$F = $this->lib->validate($this->input->post('F'));


			$count = $this->lib_model->Counter('m_subject_supervisor_mapping', array('fid' => $F,'sid'=>$S));
			if ($count == 0) {
				$f = array(
					'fid' => $F,
					'sid' => $S,
					'`created`' => date('Y-m-d H:i:s'),
					'`createdby`' => '',
					'`createdip`' => $this->input->ip_address()
				);


				$this->lib_model->Insert('m_subject_supervisor_mapping', $f );
				$Msg = array('Msg' => 'Mapping Successfully done', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddSS/' ));
			} else {
				$Msg = array('Msg' => 'Mapping Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddSS/'));
			}


		}
	}

	/*
	 *  CategoryList
	 */
	public function ProductList()
	{

		$data['rs'] = $this->lib_model->Select('v_product', 'id,name,description,price,category,packingDate,expiredDate,status,statusValue', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/ProductList');
		$this->load->view('admin/footer');
	}

	/*
	 *  CategoryList
	 */
	public function DealList()
	{

		$data['rs'] = $this->lib_model->Select('v_deal', 'dealprice,DD,id,name,description,price,category,packingDate,expiredDate,status,statusValue,type,created', array('dealstatus' => 0));
		//$sql = "SELECT * from v_product where id in (SELECT pid from m_deal where status=0)";
		//$data['rs'] = $this->lib_model->Execute($sql,array())->result();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/DealList');
		$this->load->view('admin/footer');
	}

	/*
	 *  Disable Status
	 */
	public function Disable($table, $id, $status, $url)
	{
		$table = $this->lib->validate($table);
		$id = $this->lib->validate($id);
		$status = $this->lib->validate($status);
		if ($status == 0) {
			$s = 1;
		} else if ($status == 1) {
			$s = 0;
		}

		$f = array('status' => $s);
		$this->lib_model->Update($table, $f, array('id' => $id));

		$Msg = array('Msg' => 'Status Change Sucessfully', 'Type' => 'success');
		$this->session->set_flashdata($Msg);
		redirect(base_url('Admin/' . $url));

	}

	/*
	 * Add Category
	 */
	public function EditCategory($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_category', 'id,name,about', array('id' => $data['Id']));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/EditCategory');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function EditCategoryProcess()
	{
		$rules = array(
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required'),
			array('field' => 'id', 'label' => 'Id', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/EditCategory'));
		} else {

			$Cid = $this->lib->validate($this->input->post('id'));
			$CName = $this->lib->validate($this->input->post('CName'));
			$CAbout = $this->lib->validate($this->input->post('CAbout'));


			$count = $this->lib_model->Counter('m_category', array('name' => $CName));
			if ($count == 0) {
				$f = array(
					'name' => $CName,
					'about' => $CAbout,
					'`modified`' => date('Y-m-d H:i:s'),
					'`modifiedBy`' => 'Admin',
					'`modifiedIp`' => $this->input->ip_address()
				);


				$this->lib_model->Update('m_category', $f, array('id' => $Cid));
				$Msg = array('Msg' => 'Category Update Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditCategory/' . $Cid));
			} else {
				$Msg = array('Msg' => 'Category Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditCategory/' . $Cid));
			}


		}
	}

	/*
	 * Add Category
	 */
	public function EditAttr($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_attribute', 'id,name,about', array('id' => $data['Id']));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/EditAttr');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function EditAttrProcess()
	{
		$rules = array(
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required'),
			array('field' => 'id', 'label' => 'Id', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/EditAttr'));
		} else {

			$Cid = $this->lib->validate($this->input->post('id'));
			$CName = $this->lib->validate($this->input->post('CName'));
			$CAbout = $this->lib->validate($this->input->post('CAbout'));



			$count = $this->lib_model->Counter('m_attribute', array('name' => $CName));
			if ($count == 0) {

			$f = array(
					'name' => $CName,
					'about' => $CAbout,
					'`modified`' => date('Y-m-d H:i:s'),
					'`modifiedby`' => 'Admin',
					'`modifiedip`' => $this->input->ip_address()
				);


				$this->lib_model->Update('m_attribute', $f, array('id' => $Cid));
				$Msg = array('Msg' => 'Attribute Update Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditAttr/' . $Cid));

		} else {
				$Msg = array('Msg' => 'Attribute Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditAttr/' . $Cid));
			}

		}
	}

	/*
	 * Add Category
	 */
	public function EditSubCategory($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_category', 'id,name', array('status' => 0));
		$data['rs2'] = $this->lib_model->Select('v_subcategory', 'id,name,about,cid,type', array('id' => $data['Id']));
		$this->load->view('admin/header', $data);
		$this->load->view('admin/EditSubCategory');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function EditSubCategoryProcess()
	{
		$rules = array(
			array('field' => 'Category', 'label' => 'Category', 'rules' => 'required'),
			array('field' => 'CName', 'label' => 'CName', 'rules' => 'required'),
			array('field' => 'id', 'label' => 'Id', 'rules' => 'required'),
			array('field' => 'type', 'label' => 'type', 'rules' => 'required'),

		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/SubCategoryList'));
		} else {

			$Cid = $this->lib->validate($this->input->post('id'));
			$CName = $this->lib->validate($this->input->post('CName'));
			$Category = $this->lib->validate($this->input->post('Category'));
			$CAbout = $this->lib->validate($this->input->post('CAbout'));
			$type = $this->lib->validate($this->input->post('type'));

			$count = $this->lib_model->Counter('m_subcategory', array('name' => $CName, 'category' => $Category, 'type' => $type));
			if ($count == 0) {
				$f = array(
					'category' => $Category,
					'name' => $CName,
					'about' => $CAbout,
					'`modified`' => date('Y-m-d H:i:s'),
					'`modifiedBy`' => 'Admin',
					'`modifiedIp`' => $this->input->ip_address(),
					'type' => $type

				);


				$this->lib_model->Update('m_subcategory', $f, array('id' => $Cid));
				$Msg = array('Msg' => 'Sub Category Update Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditSubCategory/' . $Cid));
			} else {
				$Msg = array('Msg' => 'Sub Category Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditSubCategory/' . $Cid));
			}


		}
	}

	/*
	 * Add Product
	 */
	public function EditProduct($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_category', 'id,name', array('status' => 0));
		$data['rs2'] = $this->lib_model->Select('v_product', 'weight,mu,`id`, `cid`, `scid`, `name`, `price`, `packingDate`, `expiredDate`, `description`, `category`,  `status`, `statusValue`', array('id' => $data['Id']));
		$data['rs3'] = $this->lib_model->Select('v_productattribute', 'id,name,attribute,aid', array('pid' => $Id));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/EditProduct');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function EditProductProcess()
	{
		$rules = array(
			array('field' => 'Category', 'label' => 'Category', 'rules' => 'required'),
			array('field' => 'name', 'label' => 'CName', 'rules' => 'required'),
			array('field' => 'id', 'label' => 'Id', 'rules' => 'required')

		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/ProductList/' . $Pid));
		} else {

			$CName = $this->lib->validate($this->input->post('name'));
			$Category = $this->lib->validate($this->input->post('Category'));
			$SubCategory = $this->lib->validate($this->input->post('SubCategory'));
			$price = $this->lib->validate($this->input->post('price'));
			//$Pd = date('Y-m-d', strtotime($this->input->post('pd')));
			//$Ed = date('Y-m-d', strtotime($this->input->post('ed')));
			//$CAbout = $this->lib->validate($this->input->post('description'));
			$Pid = $this->lib->validate($this->input->post('id'));
			$weight = $this->lib->validate($this->input->post('weight'));
			$mu     = $this->lib->validate($this->input->post('mu'));

			$count = $this->lib_model->Counter('m_product', array('name' => $CName, 'category' => $Category,'price'=>$price,'weight'=>$weight,'mu'=>$mu));
			if ($count == 0) {
				$f = array(
					'category' => $Category,
					'name' => $CName,
					'price' => $price,
					'weight'=>$weight,
					'mu'=>$mu,
					'`modified`' => date('Y-m-d H:i:s'),
					'`modifiedBy`' => 'Admin',
					'`modifiedIp`' => $this->input->ip_address()


				);
				$this->lib_model->Update('m_product', $f, array('id' => $Pid));

				/*
				 * Delete
				 */
				$this->lib_model->Delete('m_productsubcategory', array('pid' => $Pid));
				foreach ($_REQUEST['SubCategory'] as $k => $v) {
					$f2 = array(
						'created' => date('Y-m-d H:i:s'),
						'pid' => $Pid,
						'sid' => $v
					);
					$this->lib_model->Insert('m_productsubcategory', $f2);
				}

				/*
				 * Attribute Insert
				 */
				$rs2 = $this->lib_model->Select('m_attribute', 'id,name', array('status' => 0));
				foreach ($rs2 as $r2)
				{
					$AI =  $this->lib->validate($this->input->post('AI'.$r2->id));
					$AV =  $this->lib->validate($this->input->post('AV'.$r2->id));

					$fa = array(
						'name'=>$AV, 'modified'=>date('Y-m-d H:i:s'), 'modifiedby'=>'Admin'
					);
					$this->lib_model->Update('m_productattribute',$fa,array('id'=>$AI));
				}


				$Msg = array('Msg' => 'Product Update Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditProduct/' . $Pid));
			} else {
				$Msg = array('Msg' => 'Product Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditProduct/' . $Pid));
			}


		}
	}

	/*
	 * Add Product Images
	 */
	public function AddProductImages($id = 0)
	{
		$data['id'] = $this->lib->validate($id);
		$data['rs'] = $this->lib_model->Select('m_product', 'id,name', array('status' => 0, 'id' => $data['id']));
		$data['rs2'] = $this->lib_model->Select('m_productimages', 'id,name,status', array('pid' => $data['id']));
		$this->load->view('admin/header', $data);
		$this->load->view('admin/AddProductImages');
		$this->load->view('admin/footer');
	}

	/*
	 * Add Product Images Process
	 */
	public function AddProductImagesProcess()
	{
		$rules = array(
			array('field' => 'id', 'rules' => 'required', 'label' => 'Id is Must'),
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			$Msg = array('Msg' => validation_errors(), 'Type' => 'error');
			$this->session->set_flashdata($Msg);
			redirect(base_url('Admin/ProductList/'));
		} else {
			$this->load->library('upload');
			$Id = $this->lib->validate($this->input->post('id'));
			$i = 0;
			$files = $_FILES;
			while (isset($_FILES['image']['name'][$i])) {
				$_FILES['FileName']['name'] = random_string('alnum', 16) . time() . $i . '.jpg';
				$_FILES['FileName']['type'] = $files['image']['type'][$i];
				$_FILES['FileName']['tmp_name'] = $files['image']['tmp_name'][$i];
				$_FILES['FileName']['error'] = $files['image']['error'][$i];
				$_FILES['FileName']['size'] = $files['image']['size'][$i];

				$this->upload->initialize($this->set_upload_options('products'));
				$this->upload->do_upload('FileName');
				$dataInfo[] = $this->upload->data();


				$f[$i] = array(
					'pId' => $Id,
					'name' => $_FILES['FileName']['name'],
					'created' => date('Y-m-d H:i:s'),
					'createdBy' => 'Admin',
					'createdIp' => $this->input->ip_address()
				);


				$i++;
			}
			$this->lib_model->Insert_Batch('m_productimages', $f);

			$Msg = array('Msg' => 'Images successfully', 'Type' => 'success');
			$this->session->set_flashdata($Msg);
			redirect(base_url('Admin/AddProductImages/' . $Id));

		}
	}


	/*
	 * Add Product Images
	 */
	public function AddCategoryImages($id = 0)
	{
		$data['id'] = $this->lib->validate($id);
		$data['rs'] = $this->lib_model->Select('m_category', 'id,name', array('status' => 0, 'id' => $data['id']));
		$data['rs2'] = $this->lib_model->Select('m_categoryimages', 'id,name,status', array('cid' => $data['id']));
		$this->load->view('admin/header', $data);
		$this->load->view('admin/AddCategoryImages');
		$this->load->view('admin/footer');
	}

	/*
	 * Add Product Images Process
	 */
	public function AddCategoryImagesProcess()
	{
		$rules = array(
			array('field' => 'id', 'rules' => 'required', 'label' => 'Id is Must'),
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			$Msg = array('Msg' => validation_errors(), 'Type' => 'error');
			$this->session->set_flashdata($Msg);
			redirect(base_url('Admin/ProductList/'));
		} else {
			$this->load->library('upload');
			$Id = $this->lib->validate($this->input->post('id'));
			$i = 0;
			$files = $_FILES;
			while (isset($_FILES['image']['name'][$i])) {
				$_FILES['FileName']['name'] = random_string('alnum', 16) . time() . $i . '.jpg';
				$_FILES['FileName']['type'] = $files['image']['type'][$i];
				$_FILES['FileName']['tmp_name'] = $files['image']['tmp_name'][$i];
				$_FILES['FileName']['error'] = $files['image']['error'][$i];
				$_FILES['FileName']['size'] = $files['image']['size'][$i];

				$this->upload->initialize($this->set_upload_options('category'));
				$this->upload->do_upload('FileName');
				$dataInfo[] = $this->upload->data();


				$f[$i] = array(
					'cid' => $Id,
					'name' => $_FILES['FileName']['name'],
					'created' => date('Y-m-d H:i:s'),
					'createdby' => 'Admin',
					'createdIp' => $this->input->ip_address()
				);


				$i++;
			}
			$this->lib_model->Insert_Batch('m_categoryimages', $f);

			$Msg = array('Msg' => 'Images successfully', 'Type' => 'success');
			$this->session->set_flashdata($Msg);
			redirect(base_url('Admin/AddCategoryImages/' . $Id));

		}
	}

	/*
	 * set_upload_options
	 */
	private function set_upload_options($Path)
	{
		//upload an image options
		$Path = $this->lib->validate($Path);
		$config = array();
		$config['upload_path'] = './assets/fe/img/' . $Path . '/';
		$config['allowed_types'] = 'JPG|jpg|PNG|png|GIF|gif';
		$config['max_size'] = 2048;


		return $config;
	}

	/*
	 * Add Category
	 */
	public function AddPromoCode()
	{

		$this->load->view('admin/header');
		$this->load->view('admin/AddPromoCode');
		$this->load->view('admin/footer');
	}


	/*
	 * Add Category Process
	 */
	public function AddPromoCodeProcess()
	{
		$rules = array(
			array('field' => 'PromoCode', 'label' => 'PromoCode', 'rules' => 'required'),
			array('field' => 'Discout', 'label' => 'Discout', 'rules' => 'required'),
			array('field' => 'Type', 'label' => 'Type', 'rules' => 'required'),
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddPromoCode'));
		} else {

			$PromoCode = $this->lib->validate($this->input->post('PromoCode'));
			$Remarks = $this->lib->validate($this->input->post('Remarks'));
			$Discout = $this->lib->validate($this->input->post('Discout'));
			$Type = $this->lib->validate($this->input->post('Type'));

			$count = $this->lib_model->Counter('m_promocode', array('promocode' => $PromoCode));
			if ($count == 0) {
				$f = array(
					'promocode' => $PromoCode,
					'remarks' => $Remarks,
					'discount' => $Discout,
					'type' => $Type,
					'status' => 0,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
				);


				$this->lib_model->Insert('m_promocode', $f);
				$Msg = array('Msg' => 'Promocode Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddPromoCode'));
			} else {
				$Msg = array('Msg' => 'Promocode Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddPromoCode'));
			}


		}
	}

	/*
	 * Add Category
	 */
	public function EditPromoCode($Id)
	{
		$data['Id'] = $this->lib->validate($Id);
		$data['rs'] = $this->lib_model->Select('m_promocode', 'id,promocode, remarks, discount, type, status', array('id' => $data['Id']));

		$this->load->view('admin/header', $data);
		$this->load->view('admin/EditPromoCode');
		$this->load->view('admin/footer');
	}

	/*
	 * Add Category Process
	 */
	public function EditPromoCodeProcess()
	{
		$rules = array(
			array('field' => 'PromoCode', 'label' => 'PromoCode', 'rules' => 'required'),
			array('field' => 'Discout', 'label' => 'Discout', 'rules' => 'required'),
			array('field' => 'Type', 'label' => 'Type', 'rules' => 'required'),
			array('field' => 'id', 'label' => 'Id', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/PromoCodeList'));
		} else {

			$PromoCode = $this->lib->validate($this->input->post('PromoCode'));
			$Remarks = $this->lib->validate($this->input->post('Remarks'));
			$Discout = $this->lib->validate($this->input->post('Discout'));
			$Type = $this->lib->validate($this->input->post('Type'));
			$Pid = $this->lib->validate($this->input->post('id'));

			$count = $this->lib_model->Counter('m_promocode', array('promocode' => $PromoCode,'discount'=>$Discout,'type'=>$Type));
			if ($count == 0) {
				$f = array(
					'promocode' => $PromoCode,
					'remarks' => $Remarks,
					'discount' => $Discout,
					'type' => $Type,
					'modified' => date('Y-m-d H:i:s'),
					'modifiedIp' => $this->input->ip_address(),
				);


				$this->lib_model->Update('m_promocode', $f, array('id' => $Pid));
				$Msg = array('Msg' => 'Promocode Update Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditPromoCode/' . $Pid));
			} else {
				$f = array(
					'remarks' => $Remarks,
					'discount' => $Discout,
					'type' => $Type,
					'created' => date('Y-m-d H:i:s'),
					'createdIp' => $this->input->ip_address(),
				);
				$this->lib_model->Update('m_promocode', $f, array('id' => $Pid));
				$Msg = array('Msg' => 'Promocode Update Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/EditPromoCode/' . $Pid));
			}


		}
	}

	/*
	 *  CategoryList
	 */
	public function PromoCodeList()
	{

		$data['rs'] = $this->lib_model->Select('m_promocode', 'id,promocode, remarks, discount, type,status', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/PromoCodeList');
		$this->load->view('admin/footer');
	}

	/*
	 * Add Category Process
	 */
	public function AddDeal()
	{

		$Pid  = $this->lib->validate($this->input->post('pid'));
		$Type = $this->lib->validate($this->input->post('type'));
		$DD = date('Y-m-d',strtotime($this->input->post('dodDate')));
		$price   = $this->lib->validate($this->input->post('price'));
		if ($Type == 1) {
			$DN = 'Deal of Day';
		} else {
			$DN = 'Hot Sale';
		}

		$count = $this->lib_model->Counter('m_deal', array('pid' => $Pid, 'status' => 0));
		if ($count == 0) {
			$f = array(
				'pid' => $Pid,
				'status' => 0,
				'DD'=>$DD,
				'price'=>$price,
				'type' => $Type,
				'created' => date('Y-m-d H:i:s'),
				'createdip' => $this->input->ip_address(),
			);


			$this->lib_model->Insert('m_deal', $f);
			$Msg = array('Msg' => 'Product Successfully Add in ' . $DN, 'Type' => 'success');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/ProductList'));
		} else {
			$Msg = array('Msg' => 'Product Already Add in Deal of Day or Hot Sale' , 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/ProductList/'));
		}


	}

	/*
	 * Add Category Process
	 */
	public function RemoveDeal($Pid, $Type)
	{

		$Pid = $this->lib->validate($Pid);
		$Type = $this->lib->validate($Type);
		if ($Type == 1) {
			$DN = 'Deal of Day';
		} else {
			$DN = 'Hot Sale';
		}

		$f = array(
			'status' => 1,
			'modified' => date('Y-m-d H:i:s'),
			'modifiedip' => $this->input->ip_address(),
		);

		$this->lib_model->Update('m_deal', $f, array('pid' => $Pid, 'type' => $Type));
		$Msg = array('Msg' => 'Product Successfully Remove from ' . $DN, 'Type' => 'success');
		$this->session->set_flashdata($Msg);
		redirect(base_url('admin/DealList'));
	}


/*
	 * Add question
	 */

public function AddQues()
	{
		$rs = $this->lib_model->Select('m_subject_faculty_mapping', 'fid', array('fid' => $this->session->EmpId));
			if (count($rs) == 1) {


		 

		$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,status,subjectcode', array('status' => 0));

		$this->load->view('admin/header');
		$this->load->view('admin/Addques',$data);
		$this->load->view('admin/footer');
	}

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
			redirect(base_url('admin/AddCategory'));
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
					'createdBy' => 'Admin'

				);


				$this->lib_model->Insert('m_addques', $f);
				$Msg = array('Msg' => 'Subject Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/Addques'));
			} else {
				$Msg = array('Msg' => 'Subject Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/Addques'));
			}


		}

}






	/*
	 *  view topic list
	 */
	public function topic_list()
	{



//$sql  = "SELECT * from m_topic where (status = 0) and(sid in (SELECT id from m_subject ))";
//		$data['rs'] = $this->lib_model->Execute($sql)->result();


//$sql = 'SELECT * from m_topic where sid in (SELECT sid FROM m_subject)';
  //    $data['rs'] = $this->lib_model->Execute($sql,array())->result();

//$sql2 = 'SELECT * from m_subject where id in (SELECT sid FROM m_topic)';
  //    $data['ra'] = $this->lib_model->Execute($sql,array())->result();




//$data['rs'] = $this->lib_model->Select('v_subject_chapter_topic_mapping', 'status, `chapter`, `topic`, `subjectcode`, `id`, `subjectname`', array());





rsort($data['rs']);

		//$data['r'] = $this->lib_model->Select('m_topic', 'id,topic,sid', array());
		//$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,status,subjectcode', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/topiclist');
		$this->load->view('admin/footer');
	}




	/*
	 *  view topic list
	 */
	public function topiclist()
	{



//$sql  = "SELECT * from m_topic where (status = 0) and(sid in (SELECT id from m_subject ))";
//		$data['rs'] = $this->lib_model->Execute($sql)->result();


//$sql = 'SELECT * from m_topic where cid in (SELECT id FROM m_chapter)';
      //$data['rs'] = $this->lib_model->Execute($sql,array())->result();

//$sql2 = 'SELECT * from m_subject where id in (SELECT sid FROM m_topic)';
      //$data['ra'] = $this->lib_model->Execute($sql,array())->result();




$data['rs'] = $this->lib_model->Select('topic', 'TopicId, `TopicName`, `ChapterId`, `CreateTs`', array());





rsort($data['rs']);

		//$data['r'] = $this->lib_model->Select('m_topic', 'id,topic,sid', array());
		//$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,status,subjectcode', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/topiclist');
		$this->load->view('admin/footer');
	}


/*
	 *  view topic list
	 */
	public function chapterlist()
	{



//$sql  = "SELECT * from m_topic where (status = 0) and(sid in (SELECT id from m_subject ))";
//		$data['rs'] = $this->lib_model->Execute($sql)->result();


//$sql = 'SELECT * from m_topic where cid in (SELECT id FROM m_chapter)';
      //$data['rs'] = $this->lib_model->Execute($sql,array())->result();

//$sql2 = 'SELECT * from m_subject where id in (SELECT sid FROM m_topic)';
      //$data['ra'] = $this->lib_model->Execute($sql,array())->result();




$data['rs'] = $this->lib_model->Select('chapter', 'CreateTs,ChapterId, `ChapterName`, `SubjectId`,', array());





rsort($data['rs']);

		//$data['r'] = $this->lib_model->Select('m_topic', 'id,topic,sid', array());
		//$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,status,subjectcode', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/chapterlist');
		$this->load->view('admin/footer');
	}



/*
	 * Add chapter
	 */
	public function AddChapter()
	{
		$data['rs']  = $this->lib_model->Select('subject', '*', array());
		//$data['rs2'] = $this->lib_model->Select('m_faculty', 'id,name', array('status' => 0));
		$this->load->view('admin/header', $data);
		$this->load->view('admin/AddChapter');
		$this->load->view('admin/footer');
	}






/*
	 * Add topic
	 */
	public function Addtopic()
	{

		$data['rs']  = $this->lib_model->Select('chapter', '*', array());


		$data['rs2'] = $this->lib_model->Select('userlogin', '*', array('IsUserActive' => 0));
$rx = $this->session->ELogin;
//prx($rx) ;

		$this->load->view('admin/header', $data);
		$this->load->view('admin/addtopic');
		$this->load->view('admin/footer');
	}



/*
	 * Add topic Process
	 */
	public function Addtopicprocess()
	{
		$rules = array(
			array('field' => 'S', 'label' => 'Subject', 'rules' => 'required'),
			array('field' => 'topic', 'label' => 'topic', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/Addtopic'));
		} else {
			$S = $this->lib->validate($this->input->post('S'));
			$topic = $this->lib->validate($this->input->post('topic'));

			

			$count = $this->lib_model->Counter('topic', array('TopicName' => $topic));

			if ($count == 0) {
				$f = array(
					'TopicName' => $topic,
					'CreateUserId' => $this->session->ELogin,
					'ChapterId' => $S,
					
					

				);


				$this->lib_model->Insert('topic', $f);
				$Msg = array('Msg' => 'Topic Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/Addtopic'));
			} else {
				$Msg = array('Msg' => 'Topic Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/Addtopic'));
			}


		}
	}



/*
	 * Add CHAPTER Process
	 */
	public function AddChapterprocess()
	{
		$rules = array(
			array('field' => 'S', 'label' => 'Subject', 'rules' => 'required'),
			array('field' => 'chapter', 'label' => 'chapter', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/Addchapter'));
		} else {
			$S = $this->lib->validate($this->input->post('S'));
			$chapter = $this->lib->validate($this->input->post('chapter'));

			

			$count = $this->lib_model->Counter('chapter', array('ChapterName' => $chapter));

			if ($count == 0) {
				$f = array(
					'ChapterName' => $chapter,
					//'status' => 0,
					'SubjectId' => $S
					

				);


				$this->lib_model->Insert('chapter', $f);
				$Msg = array('Msg' => 'Topic Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				 $this->session->set_flashdata('item','item-value'); 
   
				redirect(base_url('admin/Addchapter'));
			} else {
				$Msg = array('Msg' => 'Topic Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/Addchapter'));
			}


		}
	}




/*
	 * Add FSM
	 */
	public function AddFSbjMProcess()
	{
		$rules = array(
			array('field' => 'S', 'label' => 'Subject', 'rules' => 'required'),
			array('field' => 'F', 'label' => 'Faculty', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/AddFSM'));
		} else {

			$S = $this->lib->validate($this->input->post('S'));
			$F = $this->lib->validate($this->input->post('F'));


			$count = $this->lib_model->Counter('m_subject_faculty_mapping', array('fid' => $F,'sid'=>$S));
			if ($count == 0) {
				$f = array(
					'fid' => $F,
					'sid' => $S,
					'`created`' => date('Y-m-d H:i:s'),
					'`createdby`' => '',
					'`createdip`' => $this->input->ip_address()
				);


				$this->lib_model->Insert('m_subject_faculty_mapping', $f );
				$Msg = array('Msg' => 'Mapping Successfully done', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddFSM/' ));
			} else {
				$Msg = array('Msg' => 'Mapping Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/AddFSM/'));
			}


		}
	}







#add process topic


public function Addtopicprocessss()
	{
		$rules = array(
			array('field' => 'topic', 'label' => 'topic', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/SubjectList'));
		} else {

			$topic = $this->lib->validate($this->input->post('topic'));
			

			$count = $this->lib_model->Counter('m_topic', array('topic' => $topic));

			if ($count == 0) {
				$f = array(
					'topic' => $topic,
					'status' => 0,
					'createdBy' => 'Admin'

				);


				$this->lib_model->Insert('m_topic', $f);
				$Msg = array('Msg' => 'Subject Add Successfully', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/subjectlist/#userModal'));
			} else {
				$Msg = array('Msg' => 'Subject Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/subjectlist/#userModal'));
			}


		}

}



/*
	 *  Disable question Status
	 */
	public function Ques_Disable($table, $id, $status, $url)
	{
		$table = $this->lib->validate($table);
		$id = $this->lib->validate($id);
		$status = $this->lib->validate($status);
		if ($status == 0) {
			$s = 1;
		} else if ($status == 1) {
			$s = 0;
		}
		else {
			$s = 2;
		}

		$f = array('status' => $s);
		$this->lib_model->Update($table, $f, array('name' => $id));

		$Msg = array('Msg' => 'Status Change Sucessfully', 'Type' => 'success');
		$this->session->set_flashdata($Msg);
		redirect(base_url('Admin/' . $url));

	}


/*
	 *  Disable question Status
	 */
	public function skip_Ques_Disable($table, $id, $status, $url)
	{
		$table = $this->lib->validate($table);
		$id = $this->lib->validate($id);
		$status = $this->lib->validate($status);
		if ($status == 0) {
			$s = 2;
		

		$f = array('status' => $s);
		$this->lib_model->Update($table, $f, array('name' => $id));

		$Msg = array('Msg' => 'Status Change Sucessfully', 'Type' => 'success');
		$this->session->set_flashdata($Msg);
		redirect(base_url('Admin/' . $url));

	}}
































/*
	 * show question tp admin*/

	
public function queslist()
	{

		$data['rs'] = $this->lib_model->Select('m_addques', 'id,name,about,status,createdBy,subjectcode', array());
		rsort($data['rs']);
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/queslist');
		$this->load->view('admin/footer');
	}

/*.
 * Edit Subject 
 */
public function EditSubject($Id)
{
   $data['Id'] = $this->lib->validate($Id);
   $data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,subjectcode,type', array('id' => $data['Id']));

   $this->load->view('admin/header', $data);
   $this->load->view('admin/EditSubject');
   $this->load->view('admin/footer');
}






/*
 * Edit Subject 
 */
public function edittopic($Id)
{
   $data['Id'] = $this->lib->validate($Id);
   $data['rt'] = $this->lib_model->Select('m_topic', 'id,topic,sid,subjectcode', array('id' => $data['Id']));
//$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,subjectcode,type', array('id' => $data['Id']));

   $this->load->view('admin/header', $data);
   $this->load->view('admin/edittopic');
   $this->load->view('admin/footer');
}


/*
 * Add topic Process this
 */
public function EdittopicProcess()
{
   $rules = array(
      array('field' => 'Ctopic', 'label' => 'Ctopic', 'rules' => 'required'),
      array('field' => 'id', 'label' => 'Id', 'rules' => 'required')
   );

   $this->form_validation->set_rules($rules);
   if ($this->form_validation->run() == false) {
      echo validation_errors();
      $Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
      $this->session->set_flashdata($Msg);
      redirect(base_url('admin/edittopic'));
   } else {

      $Cid = $this->lib->validate($this->input->post('id'));
      $CName = $this->lib->validate($this->input->post('Ctopic'));
      $CCode = $this->lib->validate($this->input->post('CCode'));

      $count = $this->lib_model->Counter('m_topic', array('topic' => $CName));

      if ($count == 0) {
         $f = array(
           
            'topic' => $CName,
            'subjectcode'=>$CCode,
            
         );


         $this->lib_model->Update('m_topic', $f, array('id' => $Cid));
         $Msg = array('Msg' => 'Category Update Successfully', 'Type' => 'success');
         $this->session->set_flashdata($Msg);
         redirect(base_url('admin/edittopic/' . $Cid));
      } else {
         $f = array(
             'topic' => $CName,
            'subjectcode'=>$CCode,
            
         );


         $this->lib_model->Update('m_topic', $f, array('id' => $Cid));
         $Msg = array('Msg' => 'Category Update Successfully', 'Type' => 'success');
         $this->session->set_flashdata($Msg);
         redirect(base_url('admin/Edittopic/' . $Cid));
      }


   }
}

/*
	 *  Faculty role Mapping List
	 */
	public function F_roles_lis()
	{

		$data['rs'] = $this->lib_model->Select('m_role_assignment', 'status, `id`, `f_name`, `role`', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/F_roles_list');
		$this->load->view('admin/footer');

	}







/*
 * edit Category Process this
 */
public function EditSubjectProcess()
{
   $rules = array(
      array('field' => 'CName', 'label' => 'CName', 'rules' => 'required'),
      array('field' => 'id', 'label' => 'Id', 'rules' => 'required')
   );

   $this->form_validation->set_rules($rules);
   if ($this->form_validation->run() == false) {
      echo validation_errors();
      $Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
      $this->session->set_flashdata($Msg);
      redirect(base_url('admin/EditSubject'));
   } else {

      $Cid = $this->lib->validate($this->input->post('id'));
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
            '`modified`' => date('Y-m-d H:i:s'),
            '`modifiedby`' => 'Admin',
            '`modifiedip`' => $this->input->ip_address()
         );


         $this->lib_model->Update('m_subject', $f, array('id' => $Cid));
         $Msg = array('Msg' => 'Category Update Successfully', 'Type' => 'success');
         $this->session->set_flashdata($Msg);
         redirect(base_url('admin/EditSubject/' . $Cid));
      } else {
         $f = array(
            'about' => $CAbout,
            'subjectcode'=>$CCode,
            'type'=>$CType,
            '`modified`' => date('Y-m-d H:i:s'),
            '`modifiedby`' => 'Admin',
            '`modifiedip`' => $this->input->ip_address()
         );


         $this->lib_model->Update('m_subject', $f, array('id' => $Cid));
         $Msg = array('Msg' => 'Category Update Successfully', 'Type' => 'success');
         $this->session->set_flashdata($Msg);
         redirect(base_url('admin/EditSubject/' . $Cid));
      }


   }
}

/*
	 *  Faculty role Mapping List
	 */
	public function F_roles_list()
	{

		$data['rs'] = $this->lib_model->Select('m_role_assignment', 'status, `id`, `f_name`, `role`', array());
		$this->load->view('admin/header', $data);
		$this->load->view('admin/F_roles_list');
		$this->load->view('admin/footer');

	}

/*
	 * Add Faculty role 
	 */
	/*
	 * Add Faculty role 
	 */
	public function F_add_roles()
	{
		$data['rs']  = $this->lib_model->Select('role', 'RoleId,Role', array('IsRoleActive' => 0));
		$data['rs2'] = $this->lib_model->Select('userlogin', 'UserId,UserEmail,UserName', array('IsUserActive' => 0));
		$this->load->view('admin/header', $data);
		$this->load->view('admin/F_add_roles');
		$this->load->view('admin/footer');
	}





/*
	 * Add role process
	 */
	public function F_add_roles_process()
	{
		$rules = array(
			array('field' => 'S', 'label' => 'name', 'rules' => 'required'),
			array('field' => 'F', 'label' => 'Faculty', 'rules' => 'required')
		);

		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == false) {
			echo validation_errors();
			$Msg = array('Msg' => validation_errors(), 'Type' => 'danger');
			$this->session->set_flashdata($Msg);
			redirect(base_url('admin/F_add_roles'));
		} else {

			$S = $this->lib->validate($this->input->post('S'));
			$F = $this->lib->validate($this->input->post('F'));


			$count = $this->lib_model->Counter('userrole', array('UserId' => $F,'RoleId'=>$S));
			if ($count == 0) {
				$f = array(
					'UserId' => $F,
					'RoleId' => $S,
					'`CreateTs`' => date('Y-m-d H:i:s'),
					'`IsUserRoleActive`' => '0',
					'`createIp`' => $this->input->ip_address()
				);


				$this->lib_model->Insert('userrole', $f );
				$Msg = array('Msg' => 'Mapping Successfully done', 'Type' => 'success');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/F_add_roles/' ));
			} else {
				$Msg = array('Msg' => 'Mapping Alredy Exist in Database', 'Type' => 'danger');
				$this->session->set_flashdata($Msg);
				redirect(base_url('admin/F_add_roles/'));
			}


		} 
	}



/*
 ---------------------------------------------------------------------------------------------------------------------------
 Supervisor functions 
	 */





/*
	 * Dashboard
	 
	
public function supervisior_dashboard()
	{
		$this->load->view('supervisior/supervisior_header');
		$this->load->view('supervisior/supervisior_dashboard');
		$this->load->view('supervisior/supervisior_footer');
	}
*/


/*
	 *  CategoryList
	 */
	public function supervisior_Ques_bucket()
	{

		$data['rs'] = $this->lib_model->Select('m_addques', 'name,about,status,subjectcode', array());
		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/supervisior_Ques_bucket');
		$this->load->view('supervisior/supervisior_footer');
	}



/*
	 *  CategoryList
	 */
	public function supervisior_SubjectList()
	{

		$data['rs'] = $this->lib_model->Select('m_subject', 'id,name,about,status,subjectcode', array());
		$this->load->view('supervisior/supervisior_header', $data);
		$this->load->view('supervisior/supervisior_SubjectList');
		$this->load->view('supervisior/supervisior_footer');
	}

/*
	 * supervisior Add subject Category page
	 */
	public function supervisior_AddSubject()
	{

		$this->load->view('supervisior/supervisior_header');
		$this->load->view('supervisior/supervisior_AddSubject');
		$this->load->view('supervisior/supervisior_footer');
	}
/*
	 * supervisor  Add suject Process
	 */
	public function supervisior_AddSubjectProcess()
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
	 * supervisior Add question
	 */

public function supervisior_Addques()
	{

		$this->load->view('supervisior/supervisior_header');
		$this->load->view('supervisior/supervisior_Addques');
		$this->load->view('supervisior/supervisior_footer');
	}





public function supervisor_Addquesprocess()
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
					'createdBy' => 'Faculty'

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








}}


























