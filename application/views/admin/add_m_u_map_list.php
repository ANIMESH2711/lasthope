<!--  Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Add Mapping</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">Add Mapping</li>
			</ol>
		</div>
		<div>
			<button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- End Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<?= $this->lib->notification();?>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Add Mapping</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/add_m_u_map_listProcess');?>" enctype="multipart/form-data">
							
							<div class="form-group">
								<label>Select Machine</label>
								<select name="m_id" class="form-control" required>
								<option value="">--Select--</option> 
                                <?php
									foreach ($Machines as $Machine)
									{ $mtype = $Machine->mtype;
if($mtype == 'P'){$typ = 'Petrol';}if($mtype == 'G'){$typ = 'Gas';}if($mtype == 'D'){$typ = 'Diesel';}
										?>		
<option value="<?php echo $Machine->mid; ?>">Type-><?php echo $typ;?> && Machine Code-><?php echo $Machine->mcode;?></option>
										<?php
									}
									?>
								</select>
							

							<br><br>

							<label>Select User</label>
								<select name="u_id" class="form-control" required>
								<option value="">--Select--</option> 
                                <?php
									foreach ($users as $user)
									{ $mtype = $Machine->mtype;
if($mtype == 'P'){$typ = 'Petrol';}if($mtype == 'G'){$typ = 'Gas';}if($mtype == 'D'){$typ = 'Diesel';}
										?>		
<option value="<?php echo $user->uid; ?>">Type-><?php echo $user->name;?> && User ID-><?php echo $user->user_id;?></option>
										<?php
									}
									?>
								</select>
							<br><br>


							
								<label>Select Shift</label>
								<select name="shift" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="first_shift"> First Shift ( 5 am to 8pm )</option>
									<option value="second_shift"> First Shift ( 8pm to 5am )</option>
									
								</select>
							
								<br><br>
						
								<label>Reading of Machine at the time of Allotment<span class="help"> </span></label>
								<input name="reading" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							



<br><br>

							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
						</div>
					</div>
				</div>

			</div>
		</div>

