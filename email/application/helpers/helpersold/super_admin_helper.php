<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
 


/* Super admin */

function insnameByEmpid($id) {
	$CI = &get_instance();
	$CI->db->select('urtbl_institute.ins_name as name');
	$CI->db->from('urtbl_institute');
    $CI->db->join('urtrel_meta_inst', 'urtrel_meta_inst.inst_id = urtbl_institute.ins_id');
   // $CI->db->join('urtbl_employee', 'urtbl_employee.emp_id = urtrel_meta_inst.pr_id');
	$CI->db->where('urtrel_meta_inst.meta_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->name)) {
		return $return->name;
	} else {
		return "";
	}
}

function insidByEmpid($id) {
	$CI = &get_instance();
	$CI->db->select('urtbl_institute.ins_id as insid');
	$CI->db->from('urtbl_institute');
    $CI->db->join('urtrel_meta_inst', 'urtrel_meta_inst.inst_id = urtbl_institute.ins_id');
   // $CI->db->join('urtbl_employee', 'urtbl_employee.emp_id = urtrel_meta_inst.pr_id');
	$CI->db->where('urtrel_meta_inst.meta_id', $id);
	$return = $CI->db->get()->row();
	if (!empty($return->insid)) {
		return $return->insid;
	} else {
		return "";
	}
}
function getUserslistpuname($id)
  {
    $CI = &get_instance();
    $CI->db->select('zd.emp_name as name');
    $CI->db->from('urtbl_employee as zd');    
    $CI->db->join('ur_puzone_meta as mi','mi.pu_empid=zd.emp_id','left');     
    $CI->db->where('mi.zone_meta_id',$id);   
    $return = $CI->db->get()->row();
    if (!empty($return->name)) {
		return $return->name;
	} else {
		return "";
	}

  }

  function sutotalcount($orgid){
	$CI = &get_instance();
	$CI->db->select('count(ue.emp_id) as totalsu');
	$CI->db->from('urtbl_zone as uz');
	$CI->db->join('urrel_zone_dist as zd','zd.zone_id=uz.zone_id','left');
	$CI->db->join('urtbl_institute as zi','zd.zone_dis_id=zi.zone_dis_id','left');
	$CI->db->join('urtrel_meta_inst as mi','zi.ins_id=mi.inst_id','left');
	$CI->db->join('urtbl_employee as ue','ue.emp_id=mi.meta_id','left');		     
    $CI->db->where('uz.org_id',$orgid);
    $CI->db->where('mi.relation_pair','ins-su');	
	$queryResult = $CI->db->get()->row_array();	
	return $queryResult['totalsu'];	
}
function tutotalcount($orgid){
	$CI = &get_instance();
	$CI->db->select('count(ue.emp_id) as totaltu');
	$CI->db->from('urtbl_zone as uz');
	$CI->db->join('urrel_zone_dist as zd','zd.zone_id=uz.zone_id','left');
	$CI->db->join('urtbl_institute as zi','zd.zone_dis_id=zi.zone_dis_id','left');
	$CI->db->join('urtrel_meta_inst as mi','zi.ins_id=mi.inst_id','left');
	$CI->db->join('urtbl_employee as ue','ue.emp_id=mi.meta_id','left');		     
    $CI->db->where('uz.org_id',$orgid);
    $CI->db->where('mi.relation_pair','ins-tu');	
	$queryResult = $CI->db->get()->row_array();	
	return $queryResult['totaltu'];	
}
function suskilltotalcount($orgid){
	$CI = &get_instance();
$CI->db->select('count(ue.emp_id) as totalsu');
  $CI->db->from('urtbl_skill_employee as ue');
    $CI->db->join('urtbl_skill_TPmeta as sd','ue.emp_id=sd.TP_emp_id','left');
    $CI->db->join('urtbl_skill_TPmaster as tc','tc.TP_id=sd.TP_meta');
	//$CI->db->join('urtbl_skill_training_center as si','si.TP_id=sd.TP_meta','left');
	$CI->db->where('ue.dept_desig_rel_id',6);   
    //$CI->db->where('si.mapped_with',$orgid);    
	$queryResult = $CI->db->get()->row_array();	
	return $queryResult['totalsu'];	
}
function tuskilltotalcount($orgid){
	$CI = &get_instance();
	$CI->db->select('count(ue.emp_id) as totaltu');
	$CI->db->from('urtbl_skill_employee as ue');
	$CI->db->join('urrel_skill_tc_meta as sd','ue.emp_id=sd.tc_emp_id');      
	$CI->db->join('urtbl_skill_training_center as tc','tc.tc_id=sd.tc_with_tp_id');     
	$CI->db->where('tc.mapped_with',$orgid);	
	$queryResult = $CI->db->get()->row_array();	
	return $queryResult['totaltu'];		
}
function studenttotalcount($orgid){
	$CI = &get_instance();
	$CI->db->select('count(us.stu_id) as totalstudent');
	$CI->db->from('urtbl_student as us');
	$CI->db->join('urtrel_stumeta_inst as si','si.meta_id=us.stu_id','left');
	$CI->db->join('urtbl_institute as zi','si.inst_id=zi.ins_id','left');			     
    $CI->db->where('us.stu_org_id',$orgid);
    //$CI->db->where('mi.relation_pair','ins-tu');	
	$queryResult = $CI->db->get()->row_array();	
	return $queryResult['totalstudent'];	
}
function tradeBranchnameById($id)
  {
    $CI = &get_instance();
    $CI->db->select('cm.course_name');
    $CI->db->from('urtbl_course_master as cm');    
    $CI->db->join('urrel_sem_subject as ss','cm.course_id=ss.course_id','left');     
    $CI->db->where('ss.subject_id',$id);   
    $return = $CI->db->get()->row();
    if (!empty($return->course_name)) {
		return $return->course_name;
	} else {
		return "";
	}

  }
  function averageRatingCount($videiId,$type)
	{
	  $CI = &get_instance();
	  $CI->db->select('ROUND(AVG(v_rating),1) as averageRating');
	  $CI->db->from('urtbl_video_rating');	      
	  $CI->db->where('video_lecture_id',$videiId);
	  $CI->db->where('video_type',$type);
	  $CI->db->group_by('v_rating');     
	  $return = $CI->db->get()->row();
	  if (!empty($return->averageRating)) {
		  return $return->averageRating;
	  } else {
		  return "NA";
	  }
  }
  function institutelist($id){
	$CI = &get_instance();
	$CI->db->select('count(ins_id) as totalinst');
	$CI->db->from('urtbl_institute');	      
	$CI->db->where('org_id',$id);
	$CI->db->where('status','active');		    
	$return = $CI->db->get()->row();
	if (!empty($return->totalinst)) {
		return $return->totalinst;
	} else {
		return "NA";
	}
  }
  function branchtradelist($id){
	$CI = &get_instance();
	$CI->db->select('count(course_id) as totalcourse');
	$CI->db->from('urtbl_course_master');	      
	$CI->db->where('org_id',$id);
	$CI->db->where('status','active');
	$CI->db->where('course_category','N');	    
	$return = $CI->db->get()->row();
	if (!empty($return->totalcourse)) {
		return $return->totalcourse;
	} else {
		return "NA";
	}
  }
  function subjectlist($id){
	$CI = &get_instance();
	$CI->db->select('count(sub_id) as totalsubject');
	$CI->db->from('urtblsub_description');	      
	$CI->db->where('mapped_with',$id);
	$CI->db->where('status','active');
	$CI->db->where_in('subject_type',array('T','P'));	    
	$return = $CI->db->get()->row();
	if (!empty($return->totalsubject)) {
		return $return->totalsubject;
	} else {
		return "NA";
	}
  }
  function skillCourseList($id){
	$CI = &get_instance();
	$CI->db->select('count(course_id) as totalcourse');
	$CI->db->from('urtbl_course_master');	      
	$CI->db->where('org_id',$id);
	$CI->db->where('status','active');		    
	$return = $CI->db->get()->row();
	if (!empty($return->totalcourse)) {
		return $return->totalcourse;
	} else {
		return "NA";
	}
  }
  function skillInstituteList($id){
	$CI = &get_instance();
	$CI->db->select('count(distinct(urtbl_skill_training_center.tc_code)) as totalcenter');
	$CI->db->from('urtbl_skill_training_center');
    $CI->db->where('ins_isactive', 1);
    $CI->db->where('mapped_with', $id);		    
	$return = $CI->db->get()->row();
	if (!empty($return->totalcenter)) {
		return $return->totalcenter;
	} else {
		return "NA";
	}
  }
  function branchtradelistdata($id){
	$CI = &get_instance();
	$CI->db->select('count(ui.course_id) as course_id');	
	$CI->db->from('urrel_inst_course AS ic');       
	$CI->db->join('urtbl_course_master AS ui', 'ic.course_id = ui.course_id');
	$CI->db->where('ic.int_id',$id);
	$CI->db->where('ui.status','active');	    
	$return = $CI->db->get()->row();
	if (!empty($return->course_id)) {
		return $return->course_id;
	} else {
		return "NA";
	}
  }
  function subjectlistdata($id){
	$CI = &get_instance();
	$CI->db->select('count(sd.sub_id) as sub_id');
	$CI->db->from('urrel_inst_course AS ic');       
    $CI->db->join('urrel_sem_subject AS ss', 'ss.course_id = ic.course_id','left');
    $CI->db->join('urtbl_course_master AS ui', 'ss.course_id = ui.course_id');
    $CI->db->join('urtblsub_description AS sd', 'sd.sub_id = ss.subject_id');
	$CI->db->where('ic.int_id',$id);
	$CI->db->where('ui.status','active');	    
	$return = $CI->db->get()->row();
	if (!empty($return->sub_id)) {
		return $return->sub_id;
	} else {
		return "NA";
	}
  }
  