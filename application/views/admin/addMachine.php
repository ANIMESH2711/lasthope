<!--  Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Tell us your requirement . </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">Tell us your requirement . </li>
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
						<h4 class="card-title">Tell us your requirement . </h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/addMachineProcess');?>" enctype="multipart/form-data">
						<div class= "row">

							<div class="form-group col-md-6">
	<label class="text-white text-center">which city u from ? / आप किस शहर से है ? </label>
								<select onchange="choice11(this)" name="cat_id" class="form-control" required>
								<option value="">--Select--</option>
								
    <option value="Andhra_Pradesh">Andhra Pradesh</option>
<option value="Andaman_and_Nicobar">Andaman and Nicobar Islands</option>
<option value="Arunachal_Pradesh">Arunachal Pradesh</option>
<option value="Assam">Assam</option>
<option value="Bihar">Bihar</option>
<option value="Chandigarh">Chandigarh</option>
<option value="Chhattisgarh">Chhattisgarh</option>
<option value="Dadar_and_Nagar_Haveli">Dadar and Nagar Haveli</option>
<option value="Daman_and_Diu">Daman and Diu</option>
<option value="Delhi">Delhi</option>
<option value="Lakshadweep">Lakshadweep</option>
<option value="Puducherry">Puducherry</option>
<option value="Goa">Goa</option>
<option value="Gujarat">Gujarat</option>
<option value="Haryana">Haryana</option>
<option value="Himachal_Pradesh">Himachal Pradesh</option>
<option value="Jammu_and_Kashmir">Jammu and Kashmir</option>
<option value="Jharkhand">Jharkhand</option>
<option value="Karnataka">Karnataka</option>
<option value="Kerala">Kerala</option>
<option value="Madhya_Pradesh">Madhya Pradesh</option>
<option value="Maharashtra">Maharashtra</option>
<option value="Manipur">Manipur</option>
<option value="Meghalaya">Meghalaya</option>
<option value="Mizoram">Mizoram</option>
<option value="Nagaland">Nagaland</option>
<option value="Odisha">Odisha</option>
<option value="Punjab">Punjab</option>
<option value="Rajasthan">Rajasthan</option>
<option value="Sikkim">Sikkim</option>
<option value="Tamil_Nadu">Tamil Nadu</option>
<option value="Telangana">Telangana</option>
<option value="Tripura">Tripura</option>
<option value="U_P">Uttar Pradesh</option>
<option value="Uttarakhand">Uttarakhand</option>
<option value="West_Bengal">West Bengal</option>
	
                                <?php
									// foreach ($rs as $Machine)
									// { 
										?>		
<!-- <option value="<?php echo $Machine->c_id; ?>"><?php echo strtoupper($Machine->c_name) ;?></option> -->
										<?php
									// }
									?>
								</select>
							</div>

							<script type="text/javascript">
  //  $(document).ready(function(){
function choice1(select) {
  // $('#seccion_exp2'+form_id+'').empty();
  var crc_id  =$tu_id = select.options[select.selectedIndex].value;
//  alert(crc_id) ;
  
var dataString = 'crc_id='+crc_id;
$.ajax({
       		type: "POST",
       		url: '<?php echo base_url();?>Admin/append_sub/',
       		data: dataString,
           success:function(result){
             
              result = JSON.parse(result);
             sub_cat = result.append_sub;
              // console.log(subjects);
             if(sub_cat !== ''){ 
              $('#seccion_exp').empty().append(
         '<option value="" selected>---Select Pincode ---</option>'
           )
		   sub_cat.forEach((object2, itr) => {

                if((object2.s_id == 'null') || (object2.pincode == 'null')){ }
                if((object2.s_id !== 'null') || (object2.pincode !== 'null')){
              //  $('#seccion_exp2'+form_id+'option:not(:first)').empty();
         $('#seccion_exp').append(
         '<option value="'+object2.s_id+'">'+object2.pincode+'</option>'
           )
                }
           }) 
              }
              if(sub_cat ==''){
                $('#seccion_exp').empty().append(
         '<option value="">---Select Pincode ---</option>'
           )

                alert('No Pincode available');  }
        
            }
        });     
      // console.log(courses);
        }
        
</script>
<div class="form-group col-md-6">
<label class="text-white text-center" >Select your Pincode ? / आपका पिनकोड ? </label>
<!-- <select class="select2 form-control" name="sub_cat" id="seccion_exp" required>
			<option value=""  selected>--Select--</option></select> -->
<input name="sub_cat" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							
			</div>


			<!-- <div class="form-group col-md-12">
								<label>Name <span class=""> </span></label>
								<input name="name" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div> -->
							
							<div class="form-group col-md-6">
								<label class="text-white text-center">Nearest Landmark ( Nearest Famous Place ) <span class=""> </span></label>
								<input name="price" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							
							<div class="form-group col-md-6">
<label class="text-white text-center" >Supportive Image ( कोई ऐसी फोटो जो मददगार को आपकी बात समझने में मदद करे।  )<span class="help"> </span></label>
								<input name="img" type="file" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

    
							
							<div class="form-group col-md-12">
								<label class="text-white text-center">What you need ? / अपनी जरुरत बताये ।  </label>
								<textarea name="remarks" class="form-control" rows="4" ></textarea >
							</div>
					</div>
							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
				</div>

			</div>
		</div>

