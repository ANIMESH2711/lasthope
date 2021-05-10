<?php
function course_branch_selector(){
  $CI = & get_instance();
  $userId = getsessdata('user');
  $org_id = $userId->org_id;
  if($org_id == 2){
    echo "Trade";
  }else if ($org_id == 3){
    echo "Course";
  }else{
    echo "Trade";
  }
}

function year_semester_selector(){
  $CI = & get_instance();
  $userId = getsessdata('user');
  $org_id = $userId->org_id;
  if($org_id == 2){
    echo "Year";
  }else if ($org_id == 3){
    echo "Semester";
  }else{
    echo "Hours";
  }
}

function lang_line_courses_selector(){
  $CI = & get_instance();
  $userId = getsessdata('user');
  $org_id = $userId->org_id;
  if($org_id == 2){
    echo $CI->lang->line('branch_name');
  }else if ($org_id == 3){
    echo $CI->lang->line('course_name');
  }else{
    echo "Hours";
  }
}

function lang_line_year_selector(){
  $CI = & get_instance();
  $userId = getsessdata('user');
  $org_id = $userId->org_id;
  if($org_id == 2){
    echo $CI->lang->line('year');
  }else if ($org_id == 3){
    echo $CI->lang->line('semester');
  }else{
    echo "Hours";
  }
}
