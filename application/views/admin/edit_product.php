<!--  Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Bread crumb and right sidebar toggle -->
	<!-- ============================================================== -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Edit Product</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>
				<li class="breadcrumb-item">Edit Product</li>
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
						<h4 class="card-title">Edit Product</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/editMachineProcess');?>" enctype="multipart/form-data">
						<div class= "row">

							<div class="form-group col-md-6">
								<label>Catagory </label>
								<select onchange="choice1(this)" name="cat_id" class="form-control" required>
								<option value="">--Select--</option> 
                                <?php
									foreach ($all_cat as $Machine)
									{ 
										?>		
<option value="<?php echo $Machine->c_id; ?>" <?php if( $Machine->c_id == $p_detail[0]->cat_id){ ?> selected <?php } ?> )><?php echo strtoupper($Machine->c_name) ;?></option>
										<?php
									}
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
         '<option value="" selected>---Select Sub Category---</option>'
           )
		   sub_cat.forEach((object2, itr) => {

                if((object2.cat_id == 'null') || (object2.name == 'null')){ }
                if((object2.cat_id !== 'null') || (object2.name !== 'null')){
              //  $('#seccion_exp2'+form_id+'option:not(:first)').empty();
         $('#seccion_exp').append(
         '<option value="'+object2.cat_id+'">'+object2.s_name+'</option>'
           )
                }
           }) 
              }
              if(sub_cat ==''){
                $('#seccion_exp').empty().append(
         '<option value="">---Select Sub Category---</option>'
           )

                alert('No Product available');  }
        
            }
        });     
      // console.log(courses);
        }
        
</script>
<div class="form-group col-md-6">
								<label>Sub Catogery <span class="help"> </span></label>
                                <select name="sub_cat" id="seccion_exp" class="form-control" required>
								<option value="">--Select--</option> 
                                <?php
									foreach ($available_sub_cat as $sub)
									{ 
										?>		
<option value="<?php echo $sub->s_id; ?>" <?php if( $sub->s_id == $p_detail[0]->sub_cat_id){ ?> selected <?php } ?> )><?php echo strtoupper($sub->s_name) ;?></option>
										<?php
									}
									?>
								</select>
			</div>


			<div class="form-group col-md-6">
								<label>Name <span class=""> </span></label>
								<input name="name" type="text" value="<?=$p_detail[0]->name;?>" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
                           
								
	<input name="p_id" type="text" value="<?=$p_detail[0]->p_id;?>" class="form-control form-control-line" placeholder ="Some text value..." hidden>
    <input name="file_name" type="text" value="<?=$p_detail[0]->img;?>" class="form-control form-control-line" placeholder ="Some text value..." hidden>	
							<div class="form-group col-md-6">
								<label>Price<span class=""> </span></label>
								<input name="price" type="text" value="<?=$p_detail[0]->price;?>" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							
							<div class="form-group col-md-12">
								<label>Image<span class="help"> </span></label>
								<input name="img" value="<?=$p_detail[0]->img;?>" type="file" class="form-control form-control-line" placeholder ="Some text value..." >
                                <img src="<?php echo base_url();?>img/<?=$p_detail[0]->img;?>" alt="Product_img" width="100" height="100">
							</div>


							
							<div class="form-group col-md-12">
								<label>Remarks</label>
								<textarea name="remarks" class="form-control" rows="4" ><?=$p_detail[0]->remark;?></textarea >
							</div>
					</div>
							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
				</div>

			</div>
		</div>

