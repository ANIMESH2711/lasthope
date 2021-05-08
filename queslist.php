<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">ALL Question</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">ALL Uploaded Question List</li>
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
		<a href="<?=base_url('Admin/Addques');?>" class="btn btn-block btn-lg btn-danger col-2"> Add New </a>
		<hr>
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<div class="row">
			<div class="col-12"><div style="border-style: double;;">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">ALL Uploaded Question List</h4>
						
						<div class="table-responsive m-t-40">
							<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th>S.no</th>
									<th>Question Code</th>
									<th>Question Title</th>
									<th>Question</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th>S.no</th>
									<th>Subject Code</th>
									<th>Question Title</th>
									<th>Question</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
								</tfoot>
								<tbody>
								<?php
								$i=1;
								foreach ($rs as $r)
								{
									if($r->status==0)
									{
										$status = 'Approve';
										$btnStatus = 'Unapprove';
										$btnClass  = 'danger';
									}
									else{
										$status = 'Unapprove';
										$btnStatus = 'Approve';
										$btnClass  = 'success';
									}
									?>
									<tr>
										<td><?=$i;?></td>
										<td><?=$r->subjectcode;?></td>
										<td><?=$r->name;?></td>
										<td><?=$r->about;?></td>
										<td><?=$status;?></td>
										<td><a  class="btn btn-primary" href="<?=base_url('Admin/queslist');?>">
												Approve
											</a> |
											<a onclick="return confirm('Are you sure to <?=$btnStatus;?> this Question');" class="btn btn-<?=$btnClass;?>" href="<?=base_url('Admin/queslist');?>">
												<?=$btnStatus;?></i>
											</a>
											</td>
									</tr>
									<?php
									$i++;
								}
								?>

								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		</div></div>
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
