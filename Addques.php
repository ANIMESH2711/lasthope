<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Add Question</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">Add Question</li>
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
			<div class="col-12"><div style="border-style: double;">
				<div class="card">
					<div class="card-body">
						
						<h4 class="card-title">Add Question</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/Addquesprocess');?>" enctype="multipart/form-data">
							<div class="form-group">
								<label>Question Code<span class="help"> </span></label>
								<input name="CCode" type="text" class="form-control form-control-line" placeholder ="Some text value...">
							</div>
							<div class="form-group">
								<label>Question Title</label>
								<input name="CName" type="text" class="form-control form-control-line" placeholder ="Some text value...">
							</div>
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
								<label>Question</label>
								<textarea name="CAbout" class="form-control" rows="22"></textarea>
							</div>
							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
				</div>

			</div>
		</div>
</div>
