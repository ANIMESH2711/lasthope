<!-- Page wrapper  -->

<!-- ============================================================== -->

<div class="page-wrapper">

	<!-- ============================================================== -->

	<!-- Bread crumb and right sidebar toggle -->

	<!-- ============================================================== -->

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">Machine User Map List</h3>

		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>

				<li class="breadcrumb-item">Machine User Map List</li>

			</ol>

		</div>

		<div>

			<button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>

		</div>

	</div>

	<!-- ============================================================== -->

	<!-- End Bread crumb and right sidebar toggle -->

	<!-- ==============================================================  -->

	<!-- ============================================================== -->

	<!-- Container fluid  -->

	<!-- ============================================================== -->

	
	<div class="container-fluid" >
	
<a href="<?=base_url('Admin/add_m_u_map_list/');?>" class="btn btn-block btn-lg btn-danger col-4">Add</a>
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
					<?=$this->lib->notification();?>
						<h4 class="card-title">Machine User Map List</h4>
						<a href="javascript:createPDF('myTable2')" class="btn btn-secondary">Export to pdf</a>
      
						<div class="table-responsive m-t-40">

							<table id="myTable2" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

								<thead>

								<tr>

									<th>S.no</th>
									<th>User Name</th>
									<th>User Id</th>
									
									<th>Shift  </th>
									<th>Machine Code </th>

									<th>Machine Name</th>
									<th> Machine Reading at Start</th>
									<th>Machine Reading at End</th>
									<th>Created At  </th>
									

									<!-- <th>Action</th> -->
								</tr>

								</thead>

								<tfoot>

								<tr>

								<th>S.no</th>
								<th>User Name</th>
									<th>User Id</th>
								
									<th>Shift  </th>
									<th>Machine Code </th>

									<th>Machine Name</th>
									<th>Machine Reading at Start</th>
									<th>Machine Reading at End</th>
									<th>Created At  </th>

									<!-- <th>Action</th> -->

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

										<td><?=$r->name;?></td>
										<td><?=$r->user_id;?></td>
										
									<td><?=strtoupper($r->shift);?>  </td>
										<td><?=$r->mcode;?></td>

										<td><?=$r->mname;?></td>
										<td><?=$r->reading;?></td>
<td><?php if(!empty($r->reading_at_end)){echo $r->reading_at_end;}else{?>
	<form  method="post" action="<?=base_url('Admin/update_end_time');?>" enctype="multipart/form-data">
						
	<label>Enter Closing Reading</label><br>
<input type="text"  class="form-control" name="end_reading" placeholder="Enter Closing Reading" id="guest_name" style="background-color: yellow;" required>
	<input type="text" id="map_id" name="map_id" value="<?=$r->id;?>" hidden>
 
  <br>
  <input class="btn btn-info" type="submit" value="Submit">
	<!-- <h5 class="btn btn-info"  id="allformsubmit" onclick="validationFunction()">Submit</h5> -->
	</form>
	<?php
	}?></td>
<td><?=date($r->map_created_at);?>  </td>
										<!-- <th><a  class="btn btn-primary" href="<?=base_url('Admin/EditFaculty/'.$r->mid);?>">

												Edit

											</a> |

											<a onclick="return confirm('Are you sure to <?=$btnStatus;?> this records');" class="btn btn-<?=$btnClass;?>" href="<?=base_url('Admin/Disable/m_action/'.$r->mid.'/'.$r->mid.'/FacultyList');?>">

												<?=$btnStatus;?></i>

											</a>

										</th> -->

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
		
<script>
    $(document).ready(function() {
        $('#myTable2').DataTable({
			"lengthMenu": [ [10, 50, 100,500,-1], [10, 50, 100, 500, "All"] ]
		});
		
    });
    </script>
	
    <script>
    function download_table_as_csv(table_id) {
      // Select rows from table_id
      var rows = document.querySelectorAll('table#' + table_id + ' tr');
      // Construct csv
      var csv = [];
      for (var i = 0; i < rows.length; i++) {
          var row = [], cols = rows[i].querySelectorAll('td, th');
          for (var j = 0; j < cols.length; j++) {
              // Clean innertext to remove multiple spaces and jumpline (break csv)
              var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
              // Escape double-quote with double-double-quote (see https://stackoverflow.com/questions/17808511/properly-escape-a-double-quote-in-csv)
              data = data.replace(/"/g, '""');
              // Push escaped string
              row.push('"' + data + '"');
          }
          csv.push(row.join(';'));
      }
      var csv_string = csv.join('\n');
      // Download it
      var filename = 'urise_Time_Table'+ new Date().toLocaleDateString() + '.csv';
      var link = document.createElement('a');
      link.style.display = 'none';
      link.setAttribute('target', '_blank');
      link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
      link.setAttribute('download', filename);
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
  }

  function createPDF(tableId) {
         var sTable = document.getElementById(tableId).innerHTML;


         var style = "<style>";
         style = style + "table {width: 100%;font: 17px Calibri;}";
         style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
         style = style + "padding: 2px 3px;text-align: center;}";
         style = style + "</style>";

         // CREATE A WINDOW OBJECT.
         var win = window.open('', '', 'height=700,width=700');

         win.document.write('<html><head>');
         win.document.write('<title>Time_Table</title>');   // <title> FOR PDF HEADER.
         win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
         win.document.write('</head>');
         win.document.write('<body><h1 style="text-decoration: underline;text-align:center;"><b>Urise Time Table</b></h1>');
         win.document.write('<table>');
         win.document.write(sTable);
         win.document.write('<table>');
         win.document.write('</body></html>');

         win.document.close(); 	// CLOSE THE CURRENT WINDOW.

         win.print();    //  PRINT THE CONTENTS.
     }

    
    
    
    </script>



		<!-- ============================================================== -->

		<!-- End PAge Content -->

		<!-- ============================================================== -->

