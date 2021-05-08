<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">  
	<meta name="author" content="">
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('assets/be/');?>images/favicon.png">
	<title> :: User Dashboard :: </title>
	<!-- Bootstrap Core CSS -->
	<link href="<?=base_url('assets/be/');?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- morris CSS -->
	<link href="<?=base_url('assets/be/');?>plugins/morrisjs/morris.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="<?=base_url('assets/be/');?>css/style.css" rel="stylesheet">
	<!-- You can change the theme colors from here -->
	<link href="<?=base_url('assets/be/');?>css/colors/blue-dark.css" id="theme" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- All Jquery -->
	<!-- ============================================================== -->
	<script src="<?=base_url('assets/be/');?>plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap tether Core JavaScript -->
	<script src="<?=base_url('assets/be/');?>plugins/bootstrap/js/popper.min.js"></script>
	<script src="<?=base_url('assets/be/');?>plugins/bootstrap/js/bootstrap.min.js"></script>
</head>

<body class="fix-header fix-sidebar card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
	<svg class="circular" viewBox="25 25 50 50">
		<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
	<!-- ============================================================== -->
	<!-- Topbar header - style you can find in pages.scss -->
	<!-- ============================================================== -->
	<header class="topbar">
		<nav class="navbar top-navbar navbar-expand-md navbar-light">
			<!-- ============================================================== -->
			<!-- Logo -->
			<!-- ============================================================== -->
			<div class="navbar-header">
			<!-- ::	Teacher / Mentor Dashboard :: -->

			</div>
			<!-- ============================================================== -->
			<!-- End Logo -->
			<!-- ============================================================== -->
			<div class="navbar-collapse">
				<!-- ============================================================== -->
				<!-- toggle and nav items -->
				<!-- ============================================================== -->
				<ul class="navbar-nav mr-auto mt-md-0">
					<!-- This is  -->
					<li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
					<li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
					<!-- ============================================================== -->

					<!-- ============================================================== -->
				</ul>
				<!-- ============================================================== -->
				<!-- User profile and search -->
				<!-- ============================================================== -->
				<ul class="navbar-nav my-lg-0">
					<!-- ============================================================== -->
					<!-- Profile -->
					<!-- ============================================================== -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?=base_url('assets/be/');?>images/users/1a.jpg" alt="user" class="profile-pic" /></a>
						<div class="dropdown-menu dropdown-menu-right scale-up">
							<ul class="dropdown-user">
								<li>
									<div class="dw-user-box">
										<div class="u-img"><img src="<?=base_url('assets/be/');?>images/users/1a.jpg" alt="user"></div>
										<div class="u-text">
											<h4>Teacher / Mentor</h4>
											<p class="text-muted">User@gmail.com</p><a href="pages-profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
									</div>
								</li>
								<li role="separator" class="divider"></li>
								<li><a href="#"><i class="ti-user"></i> My Profile</a></li>
								<li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
								<li><a href="#"><i class="ti-email"></i> Inbox</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?=base_url('User/Logout');?>"><i class="fa fa-power-off"></i> Logout</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<!-- ============================================================== -->
	<!-- End Topbar header -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- Left Sidebar - style you can find in sidebar.scss  -->
	<!-- ============================================================== -->
	<aside class="left-sidebar">
		<!-- Sidebar scroll-->
		<div class="scroll-sidebar">
			<!-- User profile -->
			<div class="user-profile" style="background: url(../assets/images/background/user-info.jpg) no-repeat;">
				<!-- User profile image -->
				<div class="profile-img"> <img src="<?=base_url('assets/be/images/users/1a.jpg');?>" alt="user" /> </div>
				<!-- User profile text-->
				<div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Teacher / Mentor</a>
					<div class="dropdown-menu animated flipInY">
						<a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
						<a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
						<a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
						<div class="dropdown-divider"></div> <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
						<div class="dropdown-divider"></div> <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
					</div>
				</div>
			</div>
			<!-- End User profile text-->
			<!-- Sidebar navigation-->
			<nav class="sidebar-nav">
				<ul id="sidebarnav">
				
				<li><a href="<?=base_url('Admin/addMachine/');?>">Tell us your requirement . </a></li>
				<li><a href="<?=base_url('Admin/dashboard/');?>">Old requirement status</a></li>
				<!-- <li><a href="<?=base_url('User/addMachine/');?>">Add New Product</a></li>
				<li><a href="<?=base_url('User/dashboard/');?>">Product List</a></li> -->

				<!-- <li><a href="<?=base_url('User/addUser/');?>">Add New User</a></li>
				<li><a href="<?=base_url('User/userList/');?>">User List</a></li>

				<li><a href="<?=base_url('User/add_m_u_map_list/');?>">Add Machine User Mapping</a></li>
				<li><a href="<?=base_url('User/m_u_map_list/');?>">Machine User Mapping List</a></li>

				<li><a href="<?=base_url('User/addCustomer/');?>">Add Customer</a></li>
				<li><a href="<?=base_url('User/customer_list/');?>"> Customer List</a></li>

				<li><a href="<?=base_url('User/add_udhari_list/');?>">Add Udhari </a></li>
				<li><a href="<?=base_url('User/udhari_list/');?>">Udhari List</a></li> -->

				
			
					<!-- <li class="nav-small-cap">User</li>

					
					
					<li><a href="<?=base_url('User/SSList/');?>"> Supervisors</a></li>
			<li><a href="<?=base_url('User/SubjectList/');?>">Subjects</a></li>


			<li><a href="<?=base_url('User/chapterlist/');?>">Chapters</a></li>


			<li><a href="<?=base_url('User/topiclist/');?>">Topic</a></li>
				<li><a href="<?=base_url('User/F_add_roles/');?>">Roles Assignment</a></li>
			
			<li><a href="<?=base_url('User/FSMList/');?>">Faculty Subject Mapping</a></li>
						
							
				<li><a href="<?=base_url('User/queslist/');?>">All Questions</a></li>

					 -->
							

							



						</ul>
					</li>

				</ul>
			</nav>
			<!-- End Sidebar navigation -->
		</div>
		<!-- End Sidebar scroll-->
		<!-- Bottom points-->
		<div class="sidebar-footer">
			<!-- item-->
			<a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
			<!-- item-->
			<a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
			<!-- item-->
			<a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
		</div>
		<!-- End Bottom points-->
	</aside>
	<!-- ============================================================== -->
	<!-- End Left Sidebar - style you can find in sidebar.scss  -->
