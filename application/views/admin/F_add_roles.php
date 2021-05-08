<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Assigned Role Mapping</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">Assigned Role Mapping</li>
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
	
	
		<div class="container-fluid" style="position: absolute;  ;right: 5px;height: top: px">
<a href="<?=base_url('admin/account');?>"  

style="position: absolute; right: 22px;bottom: 30px;"> <br> <b><b>My Account</b></b> </a>
    </div>
    	<div class="container-fluid">
		<html>
		    
		    
		    <body>
		<div style="position: absolute;  ;right: 19px;">
		    
		    

 <select id="select">
     <option value="#" selected>Login As</option>

     <option value="<?=base_url('faculty/dashboard');?>">Faculty</option>
     <option value="<?=base_url('supervisior/dashboard');?>">Supervisior</option>
</select>
<script>
 $('#select').change(function(){ 
 window.location.href = $(this).val();
});
</script></div></div>



</body></html> <hr>
	
	
	
	
	
	
	
	
	
	<!-- ============================================================== -->
	
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<?= $this->lib->notification();?>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Assign Role To Faculty</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/F_add_roles_process');?>" enctype="multipart/form-data">
							<div class="form-group">
								<label>coose Role </label>
								<select class="form-control" required name="S" id="S">
									<option selected="">Select Role</option>
									<?php
									foreach ($rs as $r)
									{
										?>

									<option value="<?=$r->RoleId;?>"> <?=$r->Role;?></option>
										
										<?php
									}
									?>

								</select>
							</div>

							<div class="form-group">
								<label>Faculty List</label>
								<select class="form-control" name="F">
									<option value="">Select Faculty</option>
									<?php
									foreach ($rs2 as $r2)
									{
									?>
									<option value="<?=$r2->UserId;?>"> <?=$r2->UserName;?></option>
										<?php
									}
									?>
								</select>
							</div>







							<div class="form-group">
								<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
				</div>

			</div>
		</div>


