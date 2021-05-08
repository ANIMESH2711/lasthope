<script type="text/javascript" src="<?=base_url();?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/ckfinder/ckfinder.js"></script>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><b><b>Add Question</b></b></h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item"><b><b>Add Question</b></b></li>
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
<a href="<?=base_url('Faculty/Addques/');?>" class="w3-button w3-blue" style="position: absolute; right: 70%;"> <br><br> &nbsp&nbsp&nbsp&nbsp <b><b>   Add New </b> </b>&nbsp&nbsp&nbsp  <br><br> </a>

<a href="<?=base_url('Faculty/myallques/');?>" class="w3-button w3-blue" style="position: absolute; right: 57%;"> <br><br><b><b>My All Question</b></b><br><br> </a>
<a href="<?=base_url('Faculty/pendingqueslist');?>" class="w3-button w3-blue" style="position: absolute; right: 45%;"> <br><br> <b>&nbsp<b>Under Review</b></b> <br><br> </a>

<a href="<?=base_url('Faculty/approved_question');?>" class="w3-button w3-blue" style="position: absolute; right: 33%;height:"> <br><br><b>&nbsp&nbsp&nbsp<b> Approved</b>&nbsp&nbsp&nbsp</b> <br><br> </a>


<a href="<?=base_url('Faculty/unapproved_question');?>" class="w3-button w3-blue" style="position: absolute; right: 22%;"><br><br> <b>&nbsp&nbsp&nbsp<b>Rejected </b></b>&nbsp&nbsp&nbsp<br><br> </a>
<a href="<?=base_url('Faculty/Dashboard');?>" class="w3-button w3-blue" style="position: absolute; right: 10%;height:"><br><br><b>&nbsp&nbsp<b> My Account</b></b>&nbsp&nbsp <br><br></a>



<div style="position: absolute; right: 1%;height:">
<h5><b><b>Login as</b></b></h5><br>
 <select id="select">
     <option value="<?=base_url('faculty/Dashboard');?>" selected>Faculty</option>
     <option value="<?=base_url('supervisior/supervisior_dashboard');?>">Supervisior</option>
     <option value="<?=base_url('admin/dashboard');?>">Admin</option>
</select>
<script>
 $('#select').change(function(){ 
 window.location.href = $(this).val();
});
</script>


</div>
</div>
</body>
</html><br><br><br>		<hr>


	
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<?= $this->lib->notification();?>
		<div class="row">
			<div class="col-12"><div style="border-style: double;">
				<div class="card">
					<div class="card-body">
						
						<h4 class="card-title"><b><b>Add Question</b></b></h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Faculty/Addquesprocess');?>" enctype="multipart/form-data">
							
							
							<div class="form-group">
								<label>Question Topic</label>
								<select name="CType" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="0"> physics</option>
									<option value="1"> chemistry </option>
									<option value="2"> Biology </option>
								</select>
							</div>
							<div class="form-group">
								<?php echo form_textarea(array('name' => 'CName', 'id' => 'desc', 'class' => "ckeditor", 'value' => set_value('txtdescription','',false))); ?>
							</div>


							<div class="form-group">
								<label>Answer</label>
								<textarea name="CAbout" class="form-control" rows="12"></textarea>
							</div>
						
							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
				</div>

			</div>
		</div>
</div>
