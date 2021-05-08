<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Subject</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">Subject List</li>
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
						<h4 class="card-title">Edit Subject</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/EditSubjectProcess');?>" enctype="multipart/form-data">
							<?php
							foreach ($rs as $r)
							{
								?>
								<div class="form-group">
									<label>Subject Code<span class="help"> e.g. "NCS-501"</span></label>
									<input name="CCode" type="text" class="form-control form-control-line" value="<?=$r->subjectcode;?>">
								</div>
								<div class="form-group">
									<label>Name</label>
									<input name="CName" type="text" class="form-control form-control-line" value="<?=$r->name;?>">
								</div>
								<div class="form-group">
									<label>Subject Type</label>
									<select name="CType" class="form-control" required>
										<option value=""> - Select Here - </option>
										<option value="0" <?php if($r->type==0){echo 'selected';}?> > Lecture</option>
										<option value="1" <?php if($r->type==1){echo 'selected';}?>> Lab </option>
										<option value="2" <?php if($r->type==2){echo 'selected';}?>> Training </option>
									</select>
								</div>

								<div class="form-group">
									<label>Remarks</label>
									<textarea name="CAbout" class="form-control" rows="5"><?=$r->about;?></textarea>
								</div>
								<div class="form-group">
									<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
								<?php
							}
							?>
							<input type="hidden" name="id" value="<?=$r->id;?>">

						</form>
					</div>
				</div>

			</div>
		</div>

