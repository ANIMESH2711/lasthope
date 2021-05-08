<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/  
$route['default_controller'] = 'Admin/';
 $route['404_override'] = 'Custom404';
// $route['403_override'] = 'Custom403';
// $route['500_override'] = 'Custom500';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = "Admin/index";
$route['User/u1Signup'] = 'User/teacherSignup';
$route['u1/addRequest'] = 'Admin/addMachine/';
$route['u1/dashboard'] = "Admin/dashboard/";
$route['s1v3e5d7d9n0e'] = "systemusers/index/login";
$route['u2t4k6a8e0t1e3l5e6d/(:any)'] = "systemusers/index/delete/$1";
$route['UserProfile'] = "user/dashboard/userProfile/";
$route['StudentProfile'] = "student/dashboard/stuProfile";
$route['tuList/(:any)/(:any)'] = "user/dashboard/listtu/$1/$1";
$route['suList/(:any)'] = "user/dashboard/listsu/$1";
$route['studentlist/(:any)/(:any)'] = "user/dashboard/studentlist/$1/$1";

$route['userSkillTuList/(:any)'] = "user/Dashboard/SkillTuList/$1";

$route['skillsutuList/(:any)'] = "user/Dashboard/skillsutuList/$1";

$route['ListSU'] = "user/dashboard/sulist";
$route['ListTU'] = "user/dashboard/tulist";
$route['skilllistsu/(:any)'] = "user/dashboard/skilllistsu/$1";
$route['tulistskill/(:any)'] = "user/dashboard/tulistskill/$1";
/*  Administrator Routing Start */
$route['administrator-PUList/(:any)'] = "admin/administrator/zone_diviList/$1";
$route['administrator-SUList/(:any)'] = "admin/administrator/pusList/$1";
$route['administrator-SUSkillList/(:any)'] = "admin/administrator/skillsuList/$1";
$route['administrator-TUList/(:any)'] = "admin/administrator/tusList/$1";
$route['administrator-TUSkillList/(:any)'] = "admin/administrator/skilltuList/$1";
$route['administrator-StudentList/(:any)'] = "admin/administrator/stuList/$1";
$route['administrator-ListPU'] = "admin/administrator/pulist";
$route['administrator-ListSU'] = "admin/administrator/sulist";
$route['administrator-ListTU'] = "admin/administrator/tulist";
$route['institutelist/(:any)'] = "admin/administrator/institutelist/$1";
$route['admin/ajaxinstitutelist/(:any)'] = "admin/administrator/ajaxinstitutelist/$1";

        $route['administrator-polyUserStatus'] = "admin/Administrator/polyUserStatus";
        $route['administrator-itiUserStatus'] = "admin/Administrator/itiUserStatus";
        $route['administrator-skillUserStatus'] = "admin/Administrator/skillUserStatus";


/*  Administrator Routing End */

/*  Frontend Routing Start */
$route['Survey'] = "frontend/homepage/stuSurvey";
$route['home'] = "frontend/homepage";
$route['about'] = "frontend/homepage/aboutUrise";
$route['studentservice'] = "frontend/homepage/studentService";
$route['listofiti'] = "frontend/homepage/listofiti";
$route['listofpolytechnic'] = "frontend/homepage/listofGovPolytechnic";
$route['listofskill'] = "frontend/homepage/listofSkillDevelopment";
$route['institutesearch/(:any)'] = "frontend/homepage/institutesearch/$1";
$route['institutesearch'] = "frontend/homepage/institutesearch";
$route['mediacoverage'] = "frontend/homepage/mediaCoverage";
$route['termsandcondition'] = "frontend/homepage/termsandcondition";
$route['circulars'] = "frontend/homepage/circulars";
$route['listofconcernedperson'] = "frontend/homepage/listofconcernedperson";
$route['disclaimer'] = "frontend/homepage/disclaimer";
$route['privacypolicy'] = "frontend/homepage/privacypolicy";
$route['courselist/(:any)'] = "frontend/homepage/courselist/$1";
$route['support'] = "grievance/support/index";
//$route['add_ticket'] = "Support/add";
$route['events'] = "frontend/homepage/events";
$route['studentTest'] = "student/StudentAssessment/studentTestList";
$route['instituteprofile/(:any)/(:any)'] = "frontend/Homepage/instituteData/$1/$1";
// $route['error_exception'] = "Custom404/error_exception";
// $route['error_db'] = "Custom404/error_db";
// $route['error_general'] = "Custom404/error_general";
// $route['error_php'] = "Custom404/error_php";

/*  Frontend Routing End */
/*  Student Routing Start */
$route['student/digilocker'] = "student/dashboard/digilocker";
$route['dashboard/ajaxallVideosrating'] = "student/dashboard/ajaxallVideosrating";
$route['student/student_video_ajax/(:any)'] = "student/dashboard/student_video_ajax/$1";
$route['dashboard/ajax_studopensourceVideo/(:any)'] = "student/dashboard/ajax_studopensourceVideo/$1";
/*  Student Routing End */

/*  User Routing Start */
$route['user/Videoeditor/approve'] = "user/Videoeditor/index/approve";
$route['user/Videoeditor/reject'] = "user/Videoeditor/index/reject";
$route['user/Videoeditor/unapprove'] = "user/Videoeditor/index/unapprove";

$route['user/dashboard/approve'] = "user/dashboard/directorUploadedvideo/approve";
$route['user/dashboard/reject'] = "user/dashboard/directorUploadedvideo/reject";

$route['Videoeditor/ajax_unapprove/(:any)'] = "user/Videoeditor/ajax_unapprove/$1";
$route['Videoeditor/ajax_approved/(:any)'] = "user/Videoeditor/ajax_approved/$1";
$route['Videoeditor/ajax_reject/(:any)'] = "user/Videoeditor/ajax_reject/$1";

$route['dashboard/ajax_unapprove/(:any)'] = "user/dashboard/ajax_unapprove/$1";
$route['dashboard/ajax_approved/(:any)'] = "user/dashboard/ajax_approved/$1";
$route['dashboard/ajax_reject/(:any)'] = "user/dashboard/ajax_reject/$1";

$route['user/dashboard/dirRegister'] = "user/dashboard/liststudent/dirRegister";
$route['user/ajax_dirUnregister/(:any)'] = "user/dashboard/ajax_dirUnregister/$1";
$route['user/ajax_dirRegister/(:any)'] = "user/dashboard/ajax_dirRegister/$1";

$route['dashboard/ajax_opensourceVideo/(:any)'] = "user/dashboard/ajax_opensourceVideo/$1";

//$route['user/dashboard/paymentsuccess'] = "user/dashboard/paymenttest/paymentsuccess";
//$route['user/dashboard/paymentfail'] = "user/dashboard/paymenttest/paymentfail";

/*  User Routing End */