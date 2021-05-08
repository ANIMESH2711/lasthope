<!-- Page wrapper  -->

<!-- ============================================================== -->

<div class="page-wrapper">

	<!-- ============================================================== -->

	<!-- Bread crumb and right sidebar toggle -->

	<!-- ============================================================== -->

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">All Pending Udhari List By Machine</h3>
      <p>Click on the buttons to see list of that machine:</p>
		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>

				<li class="breadcrumb-item">All Pending Udhari List By Machine</li>

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
	
<a href="<?=base_url('Admin/add_udhari_list/');?>" class="btn btn-block btn-lg btn-danger col-4">Add</a>
</div>


		<hr>

		<!-- ============================================================== -->

		<!-- Start Page Content -->

		<!-- ============================================================== -->

		<div class="row">

			<div class="col-12">


            <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
</head>
<body>
<!-- 
<h2>Udhaari List By Machine</h2>
<p>Click on the buttons to see list of that machine:</p> -->

<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'London')" style="border-style: groove;">Card Sweeper / Fleet Machine</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')" style="border-style: groove;">Fino Machine</button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')" style="border-style: groove;">Credit Card Machine</button>
</div>

<div id="London" class="tabcontent " style="display:block">
<div class="card">

<div class="card-body">
<?=$this->lib->notification();?>
    <h4 class="card-title">Card Sweeper / Fleet Machine</h4>
    <!-- <a href="javascript:createPDF('myTable2')" class="btn btn-secondary">Export to pdf</a> -->

    
    
    <div class="row">

			<div class="col-12">

				<div class="card">

					<div class="card-body">

						<!-- <h4 class="card-title">Machine List</h4> -->

						<div class="table-responsive m-t-40">

							<!-- <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%"> -->
              <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

<thead>

<tr>

    <th>S.no</th>
    <th>Party Name</th>
    <th>Memo no</th>
    
    <th>Gadi no  </th>
    <th>Fuel Type</th>

    <th>Quantity</th>
    <th> Rate ( in Rupees )</th>
    <th>Batch no.</th>
    <th>Roc no  </th>
    
    <th>Total Amout</th>
    <th> Paided Amount</th>
    <th> Remarks</th>
    <th> Created at</th>
    <!-- <th>batch_no</th>
    <th>roc_no  </th> -->
    

    <!-- <th>Action</th> -->
</tr>

</thead>

<tfoot>

<tr>

<th>S.no</th>
    <th>Party Name</th>
    <th>Memo no</th>
    
    <th>Gadi no  </th>
    <th>Fuel Type</th>

    <th>Quantity</th>
    <th> Rate ( in Rupees )</th>
    <th>Batch no.</th>
    <th>Roc no  </th>
    
    <th>Total Amout</th>
    <th> Paided Amount</th>
    <th> Remarks</th>
    <th> Created at</th>
   

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

        $status = 'Pending Amount';

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

        <td><?=$r->customer_name;?></td>
        <td><?=$r->memo_no;?></td>
        
    <td><?=strtoupper($r->gadi_no);?>  </td>
        <td><?=$r->fuel_type;?></td>

        <td><?=$r->quantity;?></td>
        <td><?=$r->rate;?></td>
<td><?php echo $r->batch_no; ?></td>

<td><?php echo $r->roc_no; ?></td>

<td><?php echo $r->total_amout; ?></td>

<td><?php if(($r->total_amout <= $r->amount_paided)){echo $r->total_amout;}else{?>
	<form  method="post" action="<?=base_url('Admin/update_payment');?>" enctype="multipart/form-data">
						
	<label>Enter Paided Amount</label><br>
<input type="text"  class="form-control" name="amount_paided" placeholder="Enter amount Paided" id="amount_paided" style="background-color: yellow;" required>
	<input type="text" id="ud_id" name="ud_id" value="<?=$r->ud_id;?>" hidden>
  <input type="text" id="total_amount" name="total_amount" value="<?=$r->total_amout;?>" >
 
  <br>
  <input class="btn btn-info" type="submit" value="Submit">
	<!-- <h5 class="btn btn-info"  id="allformsubmit" onclick="validationFunction()">Submit</h5> -->
	</form>
	<?php
	}?></td>

<td><?php echo $r->meta; ?></td>


<td><?=date($r->created_at);?>  </td>
        <!-- <th><a  class="btn btn-primary" href="<?=base_url('Admin/EditFaculty/'.$r->ud_id);?>">

                Edit

            </a> |

            <a onclick="return confirm('Are you sure to <?=$btnStatus;?> this records');" class="btn btn-<?=$btnClass;?>" href="<?=base_url('Admin/Disable/m_action/'.$r->ud_id.'/'.$r->ud_id.'/FacultyList');?>">

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

		<!-- ============================================================== -->

		<!-- End PAge Content -->

		<!-- ============================================================== -->









    
    
    
    
    
    </div>

</div>



</div>

</div>




</div>

<div id="Paris" class="tabcontent">



























































































































		<div class="row">

			<div class="col-12">

				<div class="card">

					<div class="card-body">

						<h4 class="card-title">Machine List</h4>

						<div class="table-responsive m-t-40">

							<!-- <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%"> -->
              <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

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

		<!-- ============================================================== -->

		<!-- End PAge Content -->

		<!-- ============================================================== -->

























  <h3>Paris</h3>
  <p>Paris is the capital of France.</p> 
</div>

<div id="Tokyo" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
   
</body>
</html> 















				
		
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

