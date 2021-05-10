<?php
function debug($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	exit;
}

function sanitize($data){
	$CI =& get_instance();
	if(is_array($data)){
		foreach ($data as $key => $value) {
			$data[$key] = $CI->security->xss_clean(htmlspecialchars(stripslashes(trim($value))));
		}
		return $data;
	}else{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_NOQUOTES);
		$data = $CI->security->xss_clean($data);
		return $data;
	}

}


function getDistrict(){
	get_instance()->db->select('dis_id, dis_name');
	get_instance()->db->from('urtbl_district');
	return get_instance()->db->get()->result();
}

function getReligion(){
	get_instance()->db->select('relg_id, rel_name');
	get_instance()->db->from('ur_religion');
	return get_instance()->db->get()->result();
}

function getEnrollMentNumber($studentId){
	get_instance()->db->select('stu_enroll_no');
	get_instance()->db->from('urtbl_student');
	get_instance()->db->where('urtbl_student.stu_id', $studentId);
	return get_instance()->db->get()->row()->stu_enroll_no;
}

function getCourse($studentId){
	get_instance()->db->select('urtbl_course_master.course_name');
	get_instance()->db->from('urtbl_student_educational_info');
	get_instance()->db->join('urtbl_course_master', 'urtbl_student_educational_info.sei_course_id = urtbl_course_master.course_id');
	get_instance()->db->where('urtbl_student_educational_info.sei_student_id', $studentId);
	return get_instance()->db->get()->row()->course_name;
}

function getFacultyStrip($emp_id){
	get_instance()->db->select('urtbl_designation.desig_name, urtbl_institute.ins_name');
	get_instance()->db->from('urtbl_employee');
	get_instance()->db->join('urrel_dept_desig', 'urrel_dept_desig.dept_desig_id = urtbl_employee.dept_desig_rel_id');
	get_instance()->db->join('urtbl_designation', 'urtbl_designation.desig_id = urrel_dept_desig.desig_id');
	get_instance()->db->join('urtrel_meta_inst', 'urtrel_meta_inst.meta_id = urtbl_employee.emp_id');
	get_instance()->db->join('urtbl_institute', 'urtrel_meta_inst.inst_id = urtbl_institute.ins_id');
	get_instance()->db->where('urtbl_employee.emp_id', $emp_id);
	return get_instance()->db->get()->row();
}
