<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}


function attendance_course_name($id) {
	$CI = &get_instance();
	$CI->db->select('c_name');
	$CI->db->from('ur_course');
	$CI->db->where('c_pr_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->c_name)) {
		return $return->c_name;
	} else {
		return "";
	}
}

function attendance_batch_name($id) {
	$CI = &get_instance();
	$CI->db->select('ubi_batch_name');
	$CI->db->from('ur_batch');
	$CI->db->where('ubi_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->ubi_batch_name)) {
		return $return->ubi_batch_name;
	} else {
		return "";
	}
}

function attendance_subject_name($id) {
	$CI = &get_instance();
	$CI->db->select('urtblsub_description.subject_name');
	$CI->db->from('urel_tu_subject');
	$CI->db->join('urtblsub_description', 'urtblsub_description.sub_id = urel_tu_subject.sub_id');
	$CI->db->where('urel_tu_subject.tu_sub_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->subject_name)) {
		return $return->subject_name;
	} else {
		return "";
	}
}

function getfaculty_name($id) {
	$CI = &get_instance();
	$CI->db->select('emp_name');
	$CI->db->from('urtbl_employee');
	$CI->db->where('emp_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->emp_name)) {
		return $return->emp_name;
	} else {
		return "NA";
	}
}

function attendance_student_name($id) {
	$CI = &get_instance();
	$CI->db->select('stu_first_name,stu_last_name');
	$CI->db->from('urtbl_student');
	$CI->db->where('stu_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->stu_first_name)) {
		return $return->stu_first_name." ".$return->stu_last_name;
	} else {
		return "";
	}
}

function attendance_progra_name($id) {
	$CI = &get_instance();
	$CI->db->select('ur_programs.pr_name');
	$CI->db->from('ur_programs');
	$CI->db->join('ur_institute', 'ur_institute.in_program_type = ur_programs.pr_id');
	$CI->db->where('ur_institute.in_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->pr_name)) {
		return $return->pr_name;
	} else {
		return "";
	}
}
function attendance_student_name_byRollno($id) {
	$CI = &get_instance();
	$CI->db->select('stu_first_name,stu_last_name');
	$CI->db->from('urtbl_student');
	$CI->db->where('stu_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->stu_first_name)) {
		return $return->stu_first_name." ".$return->stu_last_name;
	} else {
		return "";
	}
}

function attendance_student_name_get($rollno) {
	$CI = &get_instance();
	$CI->db->select('stu_first_name,stu_last_name');
	$CI->db->from('urtbl_student');
	//$CI->db->join('urtbl_student_roll_no', 'urtbl_student_roll_no.student_id = urtbl_student.stu_id');
	$CI->db->where('stu_roll_no', $rollno);
	$return = $CI->db->get()->row();
	if (!empty($return->stu_first_name)) {
		return $return->stu_first_name." ".$return->stu_last_name;
	} else {
		return "";
	}
}

function ispresentAttendance($attendanceID) {
	$CI = &get_instance();
	$condition = array(
		'attendance_id' => $attendanceID,
		'ispresent' =>1
	);
	$CI->db->select('count(ispresent) as count');
	$CI->db->from('ur_attendance_roll_list');
	$CI->db->where($condition);
	//return $CI->db->get()->row();
	$queryResult = $CI->db->get()->row_array();
	return $queryResult['count'];

}
function attendance_program_name_branch($branchcode) {
	$CI = &get_instance();
	$CI->db->select('ur_programs.pr_name');
	$CI->db->from('ur_programs');
	$CI->db->join('ur_course', 'ur_course.c_programe_type = ur_programs.pr_id');
	$CI->db->where('ur_course.c_pr_id', $branchcode);
	$return = $CI->db->get()->row();
	if (!empty($return->pr_name)) {
		return $return->pr_name;
	} else {
		return "";
	}
}
function institute_get_id($facultyId,$branch) {
	$CI = &get_instance();
	$CI->db->select('uif_inst_id');
	$CI->db->from('ur_inst_faculty');
	$CI->db->where('uif_er_id', $facultyId);
	$CI->db->where('uif_course_id', $branch);
	$return = $CI->db->get()->row();
	if (!empty($return->uif_inst_id)) {
		return $return->uif_inst_id;
	} else {
		return "";
	}
}


function Semester_namebyId($id) {
	$CI = &get_instance();
	$CI->db->select('semester_name');
	$CI->db->from('ur_semester');
	$CI->db->where('semester_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->semester_name)) {
		return $return->semester_name;
	} else {
		return "";
	}
}

function faculty_name($id) {
	$CI = &get_instance();
	$CI->db->select('er_employee_name');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->er_employee_name)) {
		return $return->er_employee_name;
	} else {
		return "";
	}
}

function program_name($id) {
	$CI = &get_instance();
	$CI->db->select('pr_name');
	$CI->db->from('ur_programs');
	$CI->db->where('pr_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->pr_name)) {
		return $return->pr_name;
	} else {
		return "";
	}
}
function empId($id) {
	$CI = &get_instance();
	$CI->db->select('employee_id');
	$CI->db->from('ur_super_users');
	$CI->db->where('id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->employee_id)) {
		return $return->employee_id;
	} else {
		return "";
	}
}

function programId($id) {
	$CI = &get_instance();
	$CI->db->select('er_prog_id');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->er_prog_id)) {
		return $return->er_prog_id;
	} else {
		return "";
	}
}

function subjectIdbyName($name) {
	$CI = &get_instance();
	$CI->db->distinct();
	$CI->db->select('subject_id');
	$CI->db->from('ur_subject');
	//$CI->db->like('subject_name', $name);
	//$CI->db->where('subject_name', $name);
	$return = $CI->db->get()->row();
	if (!empty($return->subject_id)) {
		return $return->subject_id;
	} else {
		return "";
	}
}
function studentId($id) {
	$CI = &get_instance();
	$CI->db->select('stu_id');
	$CI->db->from('urtbl_student');
	$CI->db->where('stu_urise_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->stu_id)) {
		return $return->stu_id;
	} else {
		return "";
	}
}
function studentRollNo($id) {
	$CI = &get_instance();
	$CI->db->select('stu_roll_no');
	$CI->db->from('urtbl_student');
	$CI->db->where('stu_auth_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->stu_roll_no)) {
		return $return->stu_roll_no;
	} else {
		return "";
	}
}

function su_institute_name($empid) {
	$CI = &get_instance();
	$CI->db->select('ur_institute.in_name');
	$CI->db->from('ur_institute');
	$CI->db->join('ur_inst_faculty', 'ur_institute.in_code = ur_inst_faculty.uif_inst_id');
	$CI->db->join('v_ur_employee_program_details', 'ur_inst_faculty.uif_er_id = v_ur_employee_program_details.er_employee_id');
	$CI->db->where('v_ur_employee_program_details.er_employee_id', $empid);
	$CI->db->where('ur_institute.in_program_type', 3);
	$return = $CI->db->get()->row();
	if (!empty($return->in_name)) {
		return $return->in_name;
	} else {
		return "NA";
	}
}
function su_institute_namess($empid,$progId) {
	$CI = &get_instance();
	$CI->db->select('ur_institute.in_name');
	$CI->db->from('ur_institute');
	$CI->db->join('ur_inst_faculty', 'ur_institute.in_code = ur_inst_faculty.uif_inst_id');
	$CI->db->join('v_ur_employee_program_details', 'ur_inst_faculty.uif_er_id = v_ur_employee_program_details.er_employee_id');
	$CI->db->where('v_ur_employee_program_details.er_employee_id', $empid);
	$CI->db->where('ur_institute.in_program_type', $progId);
	$return = $CI->db->get()->row();
	if (!empty($return->in_name)) {
		return $return->in_name;
	} else {
		return "NA";
	}
}

function puZone($id) {
	$CI = &get_instance();
	$CI->db->select('ur_zone.uz_zone_name,ur_district.di_name');
	$CI->db->from('ur_zone');
	$CI->db->join('ur_district', 'ur_zone.uz_id = ur_district.di_zone_id');
	$CI->db->join('ur_employee_details', 'ur_district.di_name = ur_employee_details.er_district_id');
	$CI->db->where('ur_employee_details.er_employee_id', $id);
	$CI->db->where('ur_employee_details.er_prog_id', 3);
	$return = $CI->db->get()->row();
	if (!empty($return)) {
		return $return;
	} else {
		return "NA";
	}
}
function instIdbyName($name) {
	$CI = &get_instance();
	$CI->db->select('it_id');
	$CI->db->from('ur_institute_type');
	$CI->db->like('it_name', $name,'both');
	//$CI->db->where('subject_name', $name);
	$return = $CI->db->get()->row();
	if (!empty($return->it_id)) {
		return $return->it_id;
	} else {
		return "";
	}
}
function institID($id) {
	$CI = &get_instance();
	$CI->db->select('er_inst_code');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_id', $id);
	//$CI->db->where('subject_name', $name);
	$return = $CI->db->get()->row();
	if (!empty($return->er_inst_code)) {
		return $return->er_inst_code;
	} else {
		return "";
	}
}
function disIdbyName($name) {
	$CI = &get_instance();
	$CI->db->select('di_code');
	$CI->db->from('ur_district');
	$CI->db->like('di_name', $name);
	//$CI->db->where('subject_name', $name);
	$return = $CI->db->get()->row();
	if (!empty($return->di_code)) {
		return $return->di_code;
	} else {
		return "";
	}
}
function disnamebyId($id) {
	$CI = &get_instance();
	$CI->db->select('di_name');
	$CI->db->from('ur_district');
	$CI->db->like('di_code', $id);
	//$CI->db->where('subject_name', $name);
	$return = $CI->db->get()->row();
	if (!empty($return->di_name)) {
		return $return->di_name;
	} else {
		return "";
	}
}
function programIdd($id) {
	$CI = &get_instance();
	$CI->db->select('link_with');
	$CI->db->from('ur_super_users');
	$CI->db->where('id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->link_with)) {
		return $return->link_with;
	} else {
		return "";
	}
}

function regname($id) {
	$CI = &get_instance();
	$CI->db->select('er_district_id');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->er_district_id)) {
		return $return->er_district_id;
	} else {
		return "";
	}
}
function regnameid($id) {
	$CI = &get_instance();
	$CI->db->select('er_district');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_email', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->er_district)) {
		return $return->er_district;
	} else {
		return "";
	}
}

function regionameid($id) {
	$CI = &get_instance();
	$CI->db->select('er_zone_region_id');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->er_zone_region_id)) {
		return $return->er_zone_region_id;
	} else {
		return "";
	}
}
function puzoneid($emailid,$type,$prog) {
	$CI = &get_instance();
	$CI->db->select('er_zone_region_id');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_email', $emailid);
	$CI->db->where('er_user_type', $type);
	$CI->db->where('er_prog_id', $prog);
	$return = $CI->db->get()->row();
	if (!empty($return->er_zone_region_id)) {
		return $return->er_zone_region_id;
	} else {
		return "";
	}
}
function getinstcode($emailid,$type,$prog) {
	$CI = &get_instance();
	$CI->db->select('er_inst_code');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_email', $emailid);
	$CI->db->where('er_user_type', $type);
	$CI->db->where('er_prog_id', $prog);
	$return = $CI->db->get()->row();
	if (!empty($return->er_inst_code)) {
		return $return->er_inst_code;
	} else {
		return "";
	}
}
function getempidcode($emailid,$type,$prog) {
	$CI = &get_instance();
	$CI->db->select('er_id');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_email', $emailid);
	$CI->db->where('er_user_type', $type);
	$CI->db->where('er_prog_id', $prog);
	$return = $CI->db->get()->row();
	if (!empty($return->er_id)) {
		return $return->er_id;
	} else {
		return "";
	}
}
function empEmail($id) {
	$CI = &get_instance();
	$CI->db->select('emailId');
	$CI->db->from('ur_super_users');
	$CI->db->where('id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->emailId)) {
		return $return->emailId;
	} else {
		return "";
	}
}

function empEmpid($id) {
	$CI = &get_instance();
	$CI->db->select('er_inst_code');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_email', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->er_inst_code)) {
		return $return->er_inst_code;
	} else {
		return "";
	}
}
function empEmpiddata($email,$type,$progid) {
	$CI = &get_instance();
	$CI->db->select('er_inst_code');
	$CI->db->from('ur_employee_details');
	$CI->db->where('er_employee_email', $email);
	$CI->db->where('er_user_type', $type);
	$CI->db->where('er_prog_id', $progid);
	$return = $CI->db->get()->row();
	if (!empty($return->er_inst_code)) {
		return $return->er_inst_code;
	} else {
		return "";
	}
}
/*   new Database */

function studentCourseId($id) {
	$CI = &get_instance();
	$CI->db->select('courseid');
	$CI->db->from('urel_stud_course_meta');
	$CI->db->where('stud_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->courseid)) {
		return $return->courseid;
	} else {
		return "";
	}
}
function studentSemesterId($id) {
	$CI = &get_instance();
	$CI->db->select('sei_semester');
	$CI->db->from('urtbl_student_educational_info');
	$CI->db->where('sei_student_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->sei_semester)) {
		return $return->sei_semester;
	} else {
		return "";
	}
}

function sucountdetails($id){
	$CI = &get_instance();
	$CI->db->select('count(ue.emp_id) as totalsu');
    $CI->db->from('urrel_zone_dist as zd');
    $CI->db->join('urtbl_institute as zi','zd.zone_dis_id=zi.zone_dis_id','left');
    $CI->db->join('urtrel_meta_inst as mi','mi.inst_id=zi.ins_id','left');
    $CI->db->join('urtbl_employee as ue','ue.emp_id=mi.meta_id','left');
    $CI->db->where('mi.relation_pair','ins-su');
	$CI->db->where('zd.zone_id',$id);
	$queryResult = $CI->db->get()->row_array();
	return $queryResult['totalsu'];
}
function tucountdetails($id){
	$CI = &get_instance();
	$CI->db->select('count(ue.emp_id) as totaltu');
    $CI->db->from('urtbl_employee as ue');
    $CI->db->join('urtrel_meta_inst as mi','ue.emp_id=mi.meta_id','left');
    $CI->db->join('urtbl_institute as zi','zi.ins_id=mi.inst_id','left');
    $CI->db->where('mi.relation_pair','ins-tu');
    $CI->db->where('zi.ins_id',$id);
	$queryResult = $CI->db->get()->row_array();
	return $queryResult['totaltu'];
}

function studcountdetails($id){
	$CI = &get_instance();
	$CI->db->select('count(sd.stu_id) as totalstud');
    $CI->db->from('urtbl_student as sd');
    $CI->db->join('urtrel_stumeta_inst as si','si.meta_id=sd.stu_id','left');
    $CI->db->where('si.inst_id',$id);
	$queryResult = $CI->db->get()->row_array();
	return $queryResult['totalstud'];
}

function getzoneid($id) {
	$CI = &get_instance();
	$CI->db->select('zone_meta_id');
	$CI->db->from('ur_puzone_meta');
	$CI->db->where('pu_empid', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->zone_meta_id)) {
		return $return->zone_meta_id;
	} else {
		return "";
	}
}
function subjectnameById($id) {
	$CI = &get_instance();
	$CI->db->select('subject_name');
	$CI->db->from('urtblsub_description');
	$CI->db->where('sub_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->subject_name)) {
		return $return->subject_name;
	} else {
		return "";
	}
}

function coursenameById($id) {
	$CI = &get_instance();
	$CI->db->select('course_name');
	$CI->db->from('urtbl_course_master');
	$CI->db->where('course_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->course_name)) {
		return $return->course_name;
	} else {
		return "";
	}
}

function gettotalvideo($orgid){
	$CI = &get_instance();
	$CI->db->select('count(vl.lect_id) as lect_id');
    $CI->db->from('urtbl_course_master as uz');
    $CI->db->join('urrel_sem_subject as ts','ts.course_id=uz.course_id');
    $CI->db->join('urtbl_video_lectures_org as vl','vl.course_sem_sub_id=ts.sem_sub_id');
    $CI->db->where('vl.org_id',$orgid);
	$queryResult = $CI->db->get()->row_array();
	return $queryResult['lect_id'];
}
function pageUrl($data, $total, $per_page) {
	$config = array();
	$config['base_url'] = base_url() . $data;
	$config['total_rows'] = $total;
	$config['per_page'] = $per_page;
	$config["uri_segment"] = 3;
	$choice = $config["total_rows"] / $config["per_page"];
	$config["num_links"] = 4;

	// integrate bootstrap pagination
	$config['full_tag_open'] = '<ul class="pagination">';
	$config['full_tag_close'] = '</ul>';
	$config['first_link'] = 'First';
	$config['last_link'] = 'Last';
	$config['first_tag_open'] = '<li>';
	$config['first_tag_close'] = '</li>';
	$config['prev_link'] = 'Prev';
	$config['prev_tag_open'] = '<li class="prev">';
	$config['prev_tag_close'] = '</li>';
	$config['next_link'] = 'Next';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['last_tag_open'] = '<li>';
	$config['last_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active"><a style="pointer-events: none;">';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	return $config;
}
function suskillCountdetails($id){
	$CI = &get_instance();
	$CI->db->select('count(ue.emp_id) as totalstud');
	$CI->db->from('urtbl_skill_employee as ue');
    $CI->db->join('urtbl_skill_TPmeta as sd','ue.emp_id=sd.TP_emp_id','left');
    $CI->db->join('urtbl_skill_training_center as si','si.TP_id=sd.TP_meta','left');
    $CI->db->where('si.dis_id',$id);
	$queryResult = $CI->db->get()->row_array();
	return $queryResult['totalstud'];
}
function tuskillcountdetails($id){
	$CI = &get_instance();
	$CI->db->select('count(ue.emp_id) as totalstud');
	$CI->db->from('urtbl_skill_employee as ue');
    $CI->db->join('urrel_skill_tc_meta as sd','ue.emp_id=sd.tc_emp_id');
    $CI->db->where('sd.tc_with_tp_id',$id);
	$queryResult = $CI->db->get()->row_array();
	return $queryResult['totalstud'];
}
function institutetype_byid($id) {
	$CI = &get_instance();
	$CI->db->select('ins_type');
	$CI->db->from('urtbl_institute');
	$CI->db->where('ins_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->ins_type)) {
		return $return->ins_type;
	} else {
		return "";
	}
}
function skillDistrictNmae_Id($id) {
	$CI = &get_instance();
	$CI->db->select('dis_name');
	$CI->db->from('urtbl_skill_district');
	$CI->db->where('dis_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->dis_name)) {
		return $return->dis_name;
	} else {
		return "";
	}
}
function skillTPName_Id($id) {
	$CI = &get_instance();
	$CI->db->select('TP_name');
	$CI->db->from('urtbl_skill_TPmaster');
	$CI->db->where('TP_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->TP_name)) {
		return $return->TP_name;
	} else {
		return "";
	}
}
			function getAadharbyId($id) {
			$CI = &get_instance();
			$CI->db->select('stu_aadhar_no');
			$CI->db->from('urtbl_student');
			$CI->db->where('stu_id', $id);
			$return = $CI->db->get()->row();
			if (!empty($return->stu_aadhar_no)) {
				return $return->stu_aadhar_no;
			} else {
				return "";
			}
}


				function getAttPercent($student_id,	$tu_sub_id) {
					$previoussmonth = date('Y-m-01');
					$currentDate = date('Y-m-d');
					
					$CI = &get_instance();
					$CI->db->select('urtbl_std_attendance.status');

					      //  prx($std_id .'/'. $tu_sub_id.'/' . $register_id.'/' . $emp_id . '/'. $previoussmonth .'/' . $currentDate  );
			$CI->db->select('urtbl_std_attendance.created_at,urtbl_std_attendance.std_id,urtbl_student.stu_enroll_no, urtbl_student.stu_first_name,urtbl_std_attendance.status,urtbl_std_attendance.updated_by');
			$CI->db->from('urtbl_std_attendance');
			$CI->db->join('urtbl_att_registerbook', 'urtbl_att_registerbook.tu_sub_id = urtbl_std_attendance.tu_sub_id');

			$CI->db->join('urtbl_student', 'urtbl_student.stu_id = urtbl_std_attendance.std_id', 'left');

			$CI->db->join('urrel_stud_sem_meta as ssm', 'urtbl_student.stu_id = ssm.stud_id', 'left');
			$CI->db->where('urtbl_att_registerbook.semester = ssm.stud_sem' ); 

			$CI->db->where('date(urtbl_std_attendance.created_at) >= ', ( $previoussmonth ) ) ;
    
			$CI->db->where('date(urtbl_std_attendance.created_at) <= ', ( $currentDate ) );
			$CI->db->where('ssm.stud_id', $student_id); 
					 // $CI->db->where('urtbl_std_attendance.updated_by', $tu_id);
			$CI->db->where('urtbl_std_attendance.tu_sub_id', $tu_sub_id);
       

    		return $CI->db->get()->row();
					
				}


		function totalAttendance($ins) {
									
					$CI = &get_instance();
					//$CI->db->select('urtbl_std_attendance.status');

					      //prx($ins .'/'. $tu_sub_id.'/' . $register_id.'/' . $emp_id . '/'. $previoussmonth .'/' . $currentDate  );
			$CI->db->select('urtbl_institute.ins_name,urtbl_course_master.course_name,urtblsub_description.sub_id,urtblsub_description.subject_name'); 
			$CI->db->from('urtbl_institute');
			$CI->db->join('urrel_inst_course', 'urtbl_institute.ins_id = urrel_inst_course.int_id', 'left');

			$CI->db->join('urtbl_course_master', 'urrel_inst_course.course_id = urtbl_course_master.course_id', 'left');

			$CI->db->join('urrel_sem_subject', 'urrel_inst_course.course_id = urrel_sem_subject.course_id', 'left');

			$CI->db->join('urtblsub_description', 'urrel_sem_subject.subject_id = urtblsub_description.sub_id', 'left');

			
			$CI->db->group_by('urtbl_institute.ins_name,urtbl_course_master.course_name,urtblsub_description.sub_id,urtblsub_description.subject_name');

			$CI->db->where('urtbl_institute.ins_id', $ins);
			$CI->db->where('urtbl_institute.org_id', '3');
			$CI->db->where_in('urtblsub_description.subject_type', array('T','P'));
			
			$rows = count($CI->db->get()->result());
			$t = date('t');
			$totalAtt = ($rows * $t) ;
			return $totalAtt;    
		}

		
		function attMarked($ins) {
									
			$CI = &get_instance();

			$date_from = date("Y-m-01");
        $date_to = date("Y-m-d");
		
	$CI->db->select('date(urtbl_std_attendance.created_at),urtbl_std_attendance.updated_by,urtbl_institute.ins_name,
	urtbl_employee.emp_name,urtbl_zone.zone_name,urtblsub_description.sub_id
	,urtblsub_description.subject_name,urtbl_course_master.course_id,urtbl_course_master.course_name');  

	$CI->db->from('urtbl_std_attendance');
	$CI->db->join('urtbl_employee', 'urtbl_employee.emp_id = urtbl_std_attendance.updated_by', 'left');

	$CI->db->join('urtrel_meta_inst', 'urtbl_employee.emp_id = urtrel_meta_inst.meta_id', 'left');

	$CI->db->join('urtbl_institute', 'urtbl_institute.ins_id = urtrel_meta_inst.inst_id', 'left');

	$CI->db->join('urrel_zone_dist', 'urrel_zone_dist.zone_dis_id = urtbl_institute.zone_dis_id', 'left');

	
	$CI->db->join('urtbl_zone', 'urtbl_zone.zone_id = urrel_zone_dist.zone_id', 'left');

	$CI->db->join('urtblsub_description', 'urtbl_std_attendance.tu_sub_id = urtblsub_description.sub_id', 'left');

	$CI->db->join('urrel_sem_subject', 'urtblsub_description.sub_id = urrel_sem_subject.subject_id', 'left');

	$CI->db->join('urtbl_course_master', 'urrel_sem_subject.course_id = urtbl_course_master.course_id', 'left');

	
	
	$CI->db->where('urtbl_institute.ins_id', $ins);

	$CI->db->where('date(urtbl_std_attendance.created_at) >= ', ( $date_from ) ) ;
	$CI->db->where('date(urtbl_std_attendance.created_at) <= ', ( $date_to ) );
	$CI->db->where_in('urtblsub_description.subject_type', array('T','P'));
	
	$rows = count($CI->db->get()->result());
	return $rows;    
}

		function attPercentage($Marked , $total) {

			$CI = &get_instance();

			$attMarkedPercentage = ($Marked * 100) / $total ;
if ((is_integer($attMarkedPercentage)) && ($attMarkedPercentage > 0)) {$attMarkedPercentage = $attMarkedPercentage;}
else {$attMarkedPercentage = 0;};
			return $attMarkedPercentage;
		}