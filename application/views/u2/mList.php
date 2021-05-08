<!-- Page wrapper  -->

<!-- ============================================================== -->

<div class="page-wrapper">

	<!-- ============================================================== -->

	<!-- Bread crumb and right sidebar toggle -->

	<!-- ============================================================== -->

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">Old requirement List . </h3>

		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>

				<li class="breadcrumb-item">Old requirement List . </li>

			</ol>

		</div>

		<div>

			<button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>

		</div>

	</div>


	<div class="container-fluid" >
	
<a href="<?=base_url('u1/addRequest');?>" class="btn btn-block btn-lg btn-danger col-4">Add</a>
</div>


<div class="container-fluid">



		<hr>

		<!-- ============================================================== -->

		<!-- Start Page Content -->

		<!-- ============================================================== -->

		<div class="row">

			<div class="col-12">

				<div class="card text-white">

					<div class="card-body">
					<?= $this->lib->notification();?>
						<h4 class="card-title">Old requirement List . </h4>

						<div class="table-responsive m-t-40">

							<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

								<thead>

								<tr>

									<th>S.no</th>

									<th>Name </th><th style="display:none">Name </th>
									<th> Nearest Landmark & Pincode </th>
									<th>View Details</th>	
										<th>Phone</th>								
								
									<th>Supportive Image</th>


<!-- 
								
									<th>Remark</th>
									<th>Edit</th> -->

								</tr>

								</thead>

								<tfoot>

								<tr>

								<th>S.no</th>

									<th >Name </th><th style="display:none">Name </th>
									<th> Nearest Landmark & Pincode </th>
									<th>View Details</th>	
										<th>Phone</th>								
								
									<th>Supportive Image</th>

								</tr>

								</tfoot>

								<tbody>

								<?php

								$i=1;

								foreach ($rs as $r)

								{
									?>

									<tr>

										<td><?=$i;?></td>

										<td><?=strtoupper($r->name);?></td>

										<td style="display:none"><?=$r->sub_cat_id;?></td>
										<td><?=strtoupper($r->price);?> ( <?=$r->sub_cat_id;?> )</td>
										
<td> <input type="hidden" id="p_name<?=$i;?>" value="<?=$r->name;?>" >
	<a class="btn btn-success" onclick="createLink(<?=$r->p_id;?> ,<?=$i;?> ,<?=$r->sub_cat_id	;?>)">
												View Details
											</a>
<!-- <a  class="btn btn-primary" href="<?=base_url('Admin/edit_product/'.$r->p_id);?>">
												Edit
											</a> -->
											</td>
											<td><?=$r->phone;?></td>  		
<td><div class="col-md-12 text-center" style="text-align:center">
<img src="<?php echo base_url();?>img/<?=$r->img;?>" alt="Product_img" width="100" height="100">

</div>
<br><div class="col-md-12 text-center" style="text-align:center">
<!-- <a  class="btn btn-primary " style="text-align:center" href="<?php echo base_url();?>img/<?=$r->img;?>">
												View Image
											</a>  -->
<a class="btn btn-success" onclick="createLink11(<?=$r->p_id;?> ,<?=$i;?> ,<?=$r->sub_cat_id	;?>)">View Image</a>
</div></td>
									
									
									
									
										<!-- <td><?=$r->remark;?></td>
<td><a  class="btn btn-primary" href="<?=base_url('Admin/edit_product/'.$r->p_id);?>">
												Edit
											</a> |

											<a onclick="return confirm('Are you sure to Delete this records');" class="btn btn-danger" href="<?=base_url('Admin/delete_product/'.$r->p_id);?>">

											Delete</i>

</a></td> -->
									</tr>

									<?php

									$i++;

								}

								?>

<style>
</style>



<script>
				function createLink(p_id ,i , Pincode){
												
				var dataString = '&p_id='+p_id+'&Pincode='+Pincode;
				
				var url = '<?php echo base_url(); ?>img/' ;
												// $("#loader1").show();Details
												$.ajax({
													type: 'POST',
													url: '<?php echo base_url(); ?>Admin/viewDetails/',
													data:dataString,        
													success: function (response) {
														var data = JSON.parse(response);
														var img = data.viewDetails;
														var baseurl ='<?php echo base_url();?>img/'	;													console.log(data);
														if(data.success == 'done'){
		// var p_name = data.name ; var price = data.price ; var commission = data.commision ; var link = data.linkUri ;
		
			$('.bcd').html(html); 
		var html = "";i = i+1 ;
			 c	= i ;
    html += `
	
<div class="card bg-light"> <div class="card-body text-center"> 


 <div  class="col-md-10" style="word-wrap: break-word !"><h3 class="-text"><b> City : ` + data.city + `</b>
 </h3></div><div class="row">
 <div class="col-md-6">
	 <h6 class="card-text"><b> Pincode : ` + data.pincode + ` </b></h6></div>	
	  <div class="col-md-6">  <h6 class="card-text"><b> Landmark : ` + data.landmark + ` </b></h6></div>
</div> <div class="col-12"  class="text-white" >
<br>
 <label ><b><b> Requirement :</b></b></label>
 <textarea class="form-control text-center text-white"   style="background-color: black;color:#fff !important;width:100%; height:325px !important;word-wrap: break-word ! ; text-align:center" readonly>
		 ` + data.detail + `
</textarea>

    </div>
   <hr><div class="row" >


</div> </div> </div> 
`;					$("#modal").html("");
			$('.bcd').html(html); 
			// name = document.getElementById("1").style.display = "block";
			// document.getElementById("1").style.height = '350px';
			$('#myModal').modal();
															// alert(html); 	
														}else{
															alert('Something went wrong try again later .');
														}
													}
												});
					}
											</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  <h4 class="modal-title" id="myModalLabel">View Detail</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="bcd modal-body" id="modal">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>    					
</script>


<script>
				function createLink11(p_id ,i , Pincode){
												
				var dataString = '&p_id='+p_id+'&Pincode='+Pincode;
				
				var url = '<?php echo base_url(); ?>img/' ;
												// $("#loader1").show();Details
												$.ajax({
													type: 'POST',
													url: '<?php echo base_url(); ?>Admin/viewDetails/',
													data:dataString,        
													success: function (response) {
														var data = JSON.parse(response);
														var img = data.viewDetails;
														var baseurl ='<?php echo base_url();?>img/'	;													console.log(data);
														if(data.success == 'done'){
		// var p_name = data.name ; var price = data.price ; var commission = data.commision ; var link = data.linkUri ;
		
			$('.bcd').html(html); 
		var html = "";
		html += `  <div class="w3-content w3-display-container">`
  
		img.forEach((object, i) => {
			i = i+1 ;
			 c	= i ;				 
				  });
	html += ` <input type="text" id="img_cnt" value="`+c+`" hidden>`;
  
		img.forEach((object, i) => {
html += `<img class="mySlides"  id="`+ ( i + 1 ) +`"  src="`+ baseurl  +  object.img  + `" style="width:100%" style="height:;max-height: ;overflow: hidden;" > `;
			 
				  });


				 

    html += `
	<!--<button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
  <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
</div>  --> ` ;
				$("#modal").html("");
			$('.bcd').html(html); 
			// name = document.getElementById("1").style.display = "block";
			// document.getElementById("1").style.height = '350px';
			$('#myModal').modal();
															// alert(html); 	
														}else{
															alert('Something went wrong try again later .');
														}
													}
												});
					}
											</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  <h4 class="modal-title" id="myModalLabel">View Detail</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="bcd modal-body" id="modal">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>    					
</script>
<script>

var slideIndex = 1 ;
function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var y = document.getElementById("img_cnt").value;
 
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  	var slider = slideIndex ;
	  var numItems = $('.mySlides').length;	 
  	if((slider > y) || (slider == 0)){
		name = document.getElementById("1").style.display = "block";
			document.getElementById("1").style.height = '350px';
			slideIndex = 1 ;
	  }
	  else{
  name = document.getElementById(slideIndex).style.display = "block";
  document.getElementById(slideIndex).style.height = '350px';
	  }
//   x[slideIndex-1].style.display = "block";  
//   x[slideIndex-1].style.height = '350px';  
}
</script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
.mySlides {display:none;}
</style>



											<!-- sample modal content -->
											<style>
    *[tooltip]:focus:after {
  content: attr(tooltip);
  display:block; color:white;
  font-size: 25px;
  position: absolute;    
}
.fa.fa-instagram {
  color: transparent;
  background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
  background: -webkit-radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
  background-clip: text;
  -webkit-background-clip: text;
}
</style>





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

