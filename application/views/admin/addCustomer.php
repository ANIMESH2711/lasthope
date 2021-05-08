<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Add User</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">Add Customer</li>
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
						<h4 class="card-title">Add Customer</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/addCustomerProcess');?>" enctype="multipart/form-data">
							<!-- <div class="form-group">
								<label>Machine Code<span class="help"> -</span></label>
								<input name="mcode" type="text" class="form-control form-control-line" placeholder ="Some text value...">
							</div> -->
							<div class="form-group">
								<label>Name</label>
								<input name="name" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>User ID</label>
								<input name="user_id" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div> 

							<div class="form-group">
								<label>Phone</label>
								<input id="phone" name="phone"  type="number" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
                            <div class="form-group">
								<label>Email ID</label>
								<input id="email" name="email"  type="email" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							

							<div class="form-group">
								<label>Adress</label>
								<textarea name="adress" class="form-control" rows="2" required></textarea > 
							</div>
							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
				</div>

			</div>
		</div>

		<script>        
           jQuery(document).ready(function () {
      jQuery("#phone").keypress(function (e) {
         var length = jQuery(this).val().length;
       if(length > 9) {
            return false;
       } else if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
       } else if((length == 0) && (e.which == 48)) {
            return false;
       }
      });
    });
       </script>

