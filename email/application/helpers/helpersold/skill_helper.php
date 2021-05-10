<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}



function skillTPName_Id2($id) {
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


function animesh2($emp_id){
	get_instance()->db->select('urtbl_designation.desig_name, urtbl_institute.ins_name');
	get_instance()->db->from('urtbl_employee');
	get_instance()->db->join('urrel_dept_desig', 'urrel_dept_desig.dept_desig_id = urtbl_employee.dept_desig_rel_id');
	get_instance()->db->join('urtbl_designation', 'urtbl_designation.desig_id = urrel_dept_desig.desig_id');
	get_instance()->db->join('urtrel_meta_inst', 'urtrel_meta_inst.meta_id = urtbl_employee.emp_id');
	get_instance()->db->join('urtbl_institute', 'urtrel_meta_inst.inst_id = urtbl_institute.ins_id');
	get_instance()->db->where('urtbl_employee.emp_id', $emp_id);
	return get_instance()->db->get()->result();
}

function tc_count($where,$dis_id)
{
	get_instance()->db->select('a.tc_name as centername, tcemp.emp_id as tcempid, tcemp.status as tcstatus, a.tcmanager_name as tcmanager,a.tcmanager_email as mgrmail
,a.contact_no as contact,a.tc_address as tc_adress ,e.dis_name as tcdistrict, a.tc_code as tcCode,a.tc_id as tcId,a.dis_id as tcDisId
,a.tc_name as tcName,b.TP_code as tpCode ');


get_instance()->db->from('urtbl_skill_training_center a'); 

get_instance()->db->join('urrel_skill_tc_meta tcmeta', 'tcmeta.tc_with_tp_id=a.tc_id', 'left');


get_instance()->db->join('urtbl_skill_employee tcemp', 'tcemp.emp_id=tcmeta.tc_emp_id', 'left');


get_instance()->db->join('urtbl_skill_district e', 'e.dis_id=a.dis_id', 'left');
get_instance()->db->join('urtbl_skill_TPmaster b', 'b.TP_Id=a.TP_id', 'left');

get_instance()->db->join('urtbl_skill_TPmeta c', 'c.TP_meta=b.TP_Id', 'left');

get_instance()->db->where('b.TP_id', $where);

get_instance()->db->where('a.dis_id', $dis_id);

//get_instance()->db->where_in('tcemp.status', array('not-invited','invited'));   
return get_instance()->db->get()->result();
}



function Su_tu_count($where,$dis_id)
{
	get_instance()->db->select('a.tc_name as centername, tcemp.emp_id as tcempid, tcemp.status as tcstatus, a.tcmanager_name as tcmanager,a.tcmanager_email as mgrmail
,a.contact_no as contact,a.tc_address as tc_adress ,e.dis_name as tcdistrict, a.tc_code as tcCode,a.tc_id as tcId,a.dis_id as tcDisId
,a.tc_name as tcName,b.TP_code as tpCode ');


get_instance()->db->from('urtbl_skill_training_center a'); 

get_instance()->db->join('urrel_skill_tc_meta tcmeta', 'tcmeta.tc_with_tp_id=a.tc_id', 'left');


get_instance()->db->join('urtbl_skill_employee tcemp', 'tcemp.emp_id=tcmeta.tc_emp_id', 'left');


get_instance()->db->join('urtbl_skill_district e', 'e.dis_id=a.dis_id', 'left');
get_instance()->db->join('urtbl_skill_TPmaster b', 'b.TP_Id=a.TP_id', 'left');

get_instance()->db->join('urtbl_skill_TPmeta c', 'c.TP_meta=b.TP_Id', 'left');

get_instance()->db->where('b.TP_id', $where);

get_instance()->db->where('a.dis_id', $dis_id);

//get_instance()->db->where_in('tcemp.status', array('not-invited','invited'));   
return get_instance()->db->get()->result();
}
  

function getSkillDistrict(){
	get_instance()->db->select('dis_id, dis_name');
	get_instance()->db->from('urtbl_skill_district');
	return get_instance()->db->get()->result();
}

function getAllStudent($batch){
	$today = date('Y-m-d');
	get_instance()->db->select('status');
	get_instance()->db->from('urtbl_skill_std_attendance');
	get_instance()->db->where_in('batch_id', $batch);
	get_instance()->db->like('created_at', $today, 'after');
	return get_instance()->db->get()->result();
}

function getPresentStudent($batch){
	$today = date('Y-m-d');
	get_instance()->db->select('status');
	get_instance()->db->from('urtbl_skill_std_attendance');
	get_instance()->db->where_in('batch_id', $batch);
	get_instance()->db->where_in('status', 'P');
	get_instance()->db->like('created_at', $today, 'after');
	return get_instance()->db->get()->result();
}

function getAbsentStudent($batch){
	$today = date('Y-m-d');
	get_instance()->db->select('status');
	get_instance()->db->from('urtbl_skill_std_attendance');
	get_instance()->db->where_in('batch_id', $batch);
	get_instance()->db->where_in('status', 'A');
	get_instance()->db->like('created_at', $today, 'after');
	return get_instance()->db->get()->result();
}

// public function getSkillBatchTodayStudent($tc_id,$batch){
// 	//$this->db->distinct();
// 	$today = date('Y-m-d');
// 			//$this->db->select('COUNT(urtbl_std_attendance.status) as absent');
// 		$this->db->select('batch.batch_id,batch.batch_code,studatt.created_at,student.stu_enroll_no,student.stu_first_name,sector.sector_name,course.course_name,batch.batch_id,batch.batch_code,studatt.status');
// 		//$this->db->select('student.stu_enroll_no,student.stu_first_name');
// 		$this->db->from('urtbl_skill_std_attendance as studatt');	
// 		$this->db->join('urtblskill_student as student', 'studatt.std_id = student.stu_id', 'left');


// 		$this->db->join('urelskill_stud_course_meta as studcourse', 'studcourse.stud_id = student.stu_id', 'left');

// 		$this->db->join('urtbl_course_master as course', 'course.course_id = studcourse.courseid', 'left');

// 		$this->db->join('urtbl_sector as sector', 'course.sector_id = sector.sector_id', 'left');


// 		$this->db->join('urtbl_skill_batch as batch', 'batch.batch_id = studatt.batch_id', 'left');

// 		$this->db->join('urtbl_skill_batch_center_map as tcbatch', 'batch.batch_id = tcbatch.batch_id', 'left');

// 		$this->db->join('urtbl_skill_training_center as ins', 'ins.tc_id = tcbatch.center_id', 'left');


// 	//$this->db->where('urtbl_std_attendance.status', 'A');
// 	$this->db->where('ins.tc_id', $tc_id);
// 	$this->db->like('studatt.created_at', $today, 'after');
// 	//$this->db->like('urtbl_std_attendance.created_at', $date, 'after');
// 	return $this->db->get()->result();
// }


