<!--  Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Add Udhari status</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">Add Udhari status</li>
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
						<!-- <h4 class="card-title">Card Sweeper / Fleet Machine</h4> -->
						<h6 class="card-subtitle">  <code> Fields With * Sign Are mandatory</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/addFleetUdhariProcess');?>" enctype="multipart/form-data">
						<div class="form-group">

                       


						<div class="row">

                             <div class="form-group col-12">
								<label>Select Card Machine Type *</label>
								<select name="machine_type" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="Fleet_Machine"> Card Sweeper / Fleet Machine</option>
									<option value="Fino_Machine"> Fino Machine</option>
									<option value="Credit_Card_Machine"> Credit Card Machine </option>
									<!-- <option value="Gas"> GAS </option> -->
								</select>
							</div>





							<br>
							<div class="form-group col-6">
 				<label>Select Customer *</label>
								<select name="c_name" class="form-control" required>
								<option value="">--Select--</option> 
                                <?php
									foreach ($customers as $customer)
									{ 	?>		
<option value="<?php echo $customer->uid; ?>"> Customer name -> <?php echo $customer->name?></option>
										<?php
									}
									?>
								</select>
								</div>
				<br><br>
<!-- 
								<label>Party / Customer Name *<span class="help"> </span></label>
<input name="c_name" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							 -->
							<div class="form-group col-6">
								<label>Memo Name *</label>
<input name="memo_name" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
						

							
							</div>

						<div class="form-group col-6">
								<label>Gadi Number *<span class="help"> </span></label>
<input name="grid_no" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group col-6">
								<label>Fuel Type *<span class="help"> </span></label>
<!-- <input name="f_type" type="text" class="form-control form-control-line" placeholder ="Some text value..." required> -->

	<select name="f_type" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="Petrol_and_Diesel"> Petrol And Diesel</option>
									<option value="Petrol"> Petrol</option>
									<option value="Diesel"> Diesel </option>
									<option value="Gas"> GAS </option>
								</select>


							</div>

							<div class="form-group col-6">
								<label>Total Quantity in Litre *<span class="help"> </span></label>
<input name="total_quan" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group col-6">
								<label>Rate ( Amount in Ruppes ) *<span class="help"> </span></label>
<input name="rate" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group col-6">
								<label>Batch Number *<span class="help"> </span></label>
<input name="batch" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							<div class="form-group col-6">
								<label>R.O.C Number *<span class="help"> </span></label>
<input name="roc_no" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group col-6">
								<label>Total Amount *<span class="help"> </span></label>
<input name="t_amount" type="number" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>


							<!-- <div class="form-group">
								<label>Total Amount *<span class="help"> </span></label>
<input name="machine_type" type="text" class="form-control form-control-line" value="Fleet_Machine" required>
							</div> -->

							<!-- <div class="form-group">
								<label>Paid by Credit Card Machine <span class="help"> </span></label>
								<input name="c_card" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Paid by Fino Bank Machine <span class="help"> </span></label>
								<input name="fino_bank" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div> -->


							
							<div class="form-group col-12">
								<label>Remarks</label>
								<textarea name="remarks" class="form-control" rows="2" ></textarea >
							</div>
							<div class="form-group col-12">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
                    </div>	</div>	</div>	</div>		</div>	


