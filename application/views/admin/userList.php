<!-- Page wrapper  -->

<!-- ============================================================== -->

<div class="page-wrapper">

	<!-- ============================================================== -->

	<!-- Bread crumb and right sidebar toggle -->

	<!-- ============================================================== -->

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">User List</h3>

		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>

				<li class="breadcrumb-item">User List</li>

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

	
	<div class="container-fluid" >
	
<a href="<?=base_url('Admin/addUser/');?>" class="btn btn-block btn-lg btn-danger col-4">Add</a>
</div>

			<!-- <div class="container-fluid" style="position: absolute;  ;right: 5px;height: top: px"> 

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







</body></html>





	

	

	

	

	<!-- ============================================================== -->







<!--  

<!DOCTYPE html>

<html>

<title>buttons</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<body>





<div class="container-fluid">

<!--a href="<?=base_url('admin/dashboard');?>" class="w3-button w3-blue"

		style="position: absolute; right: 29%;height:100px;text-align: center;"><b>

		<b>Dashboard<br></a>

<a href="<?=base_url('Admin/AddFSM');?>" class="btn btn-block btn-lg btn-danger col-2"> Add New </a>










<a href="<?=base_url('Admin/AddFSM');?>" class="w3-button w3-red" 

style="position: absolute; right: 69%;height:100px;text-align: center;">&nbsp<b><b><br>

Add New&nbsp</a>





<a href="<?=base_url('Admin/FacultyList/');?>" class="w3-button w3-blue" 

style="position: absolute; right: 57%; height:100px;text-align: center;">&nbsp<b><b><br>All Faculty</b></b>&nbsp</a>

<a href="<?=base_url('Admin/SubjectList');?>" class="w3-button w3-blue" 

style="position: absolute; right: 40%;height:100px;text-align: center;">&nbsp<b><b><br>

All Subject&nbsp</a>

	<a href="<?=base_url('Admin/SSList/');?>" class="w3-button w3-blue"

	style="position: absolute; right: 20%;height:100px;text-align: center;">&nbsp<b><b><br>All Supervisior&nbsp</a>

	

	

	

	

	<!--<a href="<?=base_url('Supervisior/RequestQuestion');?>" class="w3-button w3-blue"

		style="position: absolute; right: 29%;height:100px;text-align: center;"><b><b><br></a>

	<a href="<?=base_url('Supervisior/RequestQuestion');?>" class="w3-button w3-blue"

		style="position: absolute; right: 11%;height:100px;text-align: center;"><b><b><br>

		Question Selectection <br>For Allocation</a>-->





		<!-- <br><br><br><br> 

</div>

</body>

</html>
	-->



		<hr>

		<!-- ============================================================== -->

		<!-- Start Page Content -->

		<!-- ============================================================== -->

		<div class="row">

			<div class="col-12">

				<div class="card">

					<div class="card-body">

						<h4 class="card-title">User List</h4>

						<div class="table-responsive m-t-40">

							<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

								<thead>

								<tr>

									<th>S.no</th>

									<th>User ID </th>

									<th>User Name</th>

									<th>Contact</th>
									<th>Adress</th>

								</tr>

								</thead>

								<tfoot>

								<tr>

								<th>S.no</th>

									<th>User ID </th>

									<th>User Name</th>

									<th>Contact</th>
									<th>Adress</th>

								</tr>

								</tfoot>

								<tbody>

								<?php

								$i=1;

								foreach ($rs as $r)

								{

									if($r->status == 0)

									{

										$status = 'Enable';

										$btnStatus = 'Disable';

										$btnClass  = 'danger';

									}

									else{

										$status = 'Disable';

										$btnStatus = 'Enable';

										$btnClass  = 'success';

									}

									?>

									<tr>

										<td><?=$i;?></td>

										<td><?=$r->user_id;?></td>

										<td><?=$r->name;?></td>
										<td><?=$r->phone;?></td>
										<td><?=$r->adress;?></td>

										<!-- <td><a  class="btn btn-primary" href="<?=base_url('Admin/EditFaculty/'.$r->uid);?>">

												Edit

											</a> |

											<a onclick="return confirm('Are you sure to <?=$btnStatus;?> this records');" class="btn btn-<?=$btnClass;?>" href="<?=base_url('Admin/Disable/m_action/'.$r->uid.'/'.$r->uid.'/FacultyList');?>">

												<?=$btnStatus;?></i>

											</a>

										</td> -->

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

		</div>

		<!-- ============================================================== -->

		<!-- End PAge Content -->

		<!-- ============================================================== -->

