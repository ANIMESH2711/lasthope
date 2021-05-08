<!-- Page wrapper  -->

<!-- ============================================================== -->

<div class="page-wrapper">

	<!-- ============================================================== -->

	<!-- Bread crumb and right sidebar toggle -->

	<!-- ============================================================== -->

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">Admin Dashboard</h3>

		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>

				<li class="breadcrumb-item">Admin Dashboard</li>

			</ol>

		</div>

		<div>

			<!-- <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button> -->

		</div>

	</div>

	<!-- ============================================================== -->

	<!-- End Bread crumb and right sidebar toggle -->

<div class="container-fluid">


<a href="<?=base_url('Admin/AddFSM');?>" class="btn btn-block btn-lg btn-danger col-2"> Add New </a> 

</div>
			<hr>

		<!-- ============================================================== -->

		<!-- Start Page Content -->

		<!-- ============================================================== -->

		<div class="row">

			<div class="col-12">

				<div class="card">

					<div class="card-body">

						<h4 class="card-title">Product  List</h4>

						<div class="table-responsive m-t-40">

							<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

								<thead>

								<tr>

									<th>S.no</th>

									<th>Product Number </th>

									<th>Attached Person</th>
                                    <th>At Time</th>

									<th>Action</th>

								</tr>

								</thead>

								<tfoot>

								<tr>

                                <th>S.no</th>

                            <th>Machine Number </th>

                            <th>Attached Person</th>
                            <th>At Time</th>
                            <th>Action</th>

								</tr>

								</tfoot>

								<tbody>

								<?php

								
									?>

									<tr>

										<td></td>

										<td></td>

										<td></td>
                                        
                                        <td></td>

										<td><a  class="btn btn-primary" href="<?=base_url('Admin/EditFaculty/');?>">

												Edit

											</a> |

<a onclick="return confirm('Are you sure to <?php ?> this records');" class="btn btn-<?php ?>" href="<?=base_url('Admin/Disable/m_Faculty/');?>">

												</i>

											</a>

										</td>

									</tr>

									<?php


							

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

