<!-- Page wrapper  -->

<!-- ============================================================== -->

<div class="page-wrapper">

	<!-- ============================================================== -->

	<!-- Bread crumb and right sidebar toggle -->

	<!-- ============================================================== -->

	<div class="row page-titles">

		<div class="col-md-5 align-self-center">

			<h3 class="text-themecolor">Add Udhaari</h3>
            <p class="breadcrumb-item">Click on the buttons to Add Udhaari by that Machine:</p> 
		</div>

		<div class="col-md-7 align-self-center">

			<ol class="breadcrumb">

				<li class="breadcrumb-item"><a href="<?=base_url('Admin/Dashboard');?>">Home</a></li>

				<li class="breadcrumb-item">Add Udhaari</li>
               
			</ol>

		</div>

		
	</div>

	
		<hr>

		<!-- ============================================================== -->

		<!-- Start Page Content -->

		<!-- ============================================================== -->
        <?= $this->lib->notification();?>
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
<h2>Add Udhaari</h2>
<p>Click on the buttons to Add Udhaari by that Machine:</p> -->

<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'London')" style="border-style: groove;">Card Sweeper / Fleet Machine</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')" style="border-style: groove;">Fino Machine</button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')" style="border-style: groove;">Credit Card Machine</button>
</div>

<div id="London" class="tabcontent " style="display:block">













		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Card Sweeper / Fleet Machine</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/addFleetUdhariProcess');?>" enctype="multipart/form-data">
						<div class="form-group">

                        <!-- <label>Select Machine</label>
								<select name="m_id" class="form-control" required>
								<option value="">--Select--</option> 
                                <?php
									foreach ($Machines as $Machine)
									{ $mtype = $Machine->mtype;
if($mtype == 'P'){$typ = 'Petrol';}if($mtype == 'G'){$typ = 'Gas';}if($mtype == 'D'){$typ = 'Diesel';}
										?>		
<option value="<?php echo $Machine->mid; ?>">Type-><?php echo $typ;?> && Machine Code-><?php echo $Machine->mcode;?></option>
										<?php
									}
									?>
								</select>
							 -->




                             <!-- <div class="form-group">
								<label>Select Machine Name *</label>
								<select name="machine_type" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="Petrol_and_Diesel"> Petrol And Diesel</option>
									<option value="Petrol"> Petrol</option>
									<option value="Diesel"> Diesel </option>
									<option value="Gas"> GAS </option>
								</select>
							</div> -->





							<br>




								<label>Party / Customer Name *<span class="help"> </span></label>
<input name="c_name" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							<div class="form-group">
								<label>Memo Name *</label>
<input name="memo_name" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
						

								<!-- <select name="mtype" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="Petrol_and_Diesel"> Petrol And Diesel</option>
									<option value="Petrol"> Petrol</option>
									<option value="Diesel"> Diesel </option>
									<option value="Gas"> GAS </option>
								</select> -->
							</div>

						<div class="form-group">
								<label>Gadi Number *<span class="help"> </span></label>
<input name="grid_no" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Fuel Type *<span class="help"> </span></label>
<input name="f_type" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Total Quantity in Litre *<span class="help"> </span></label>
<input name="total_quan" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Rate ( Amount in Ruppes ) *<span class="help"> </span></label>
<input name="rate" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Batch Number *<span class="help"> </span></label>
<input name="batch" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							<div class="form-group">
								<label>R.O.C Number *<span class="help"> </span></label>
<input name="roc_no" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Total Amount *<span class="help"> </span></label>
<input name="t_amount" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>


							<div class="form-group">
								<!-- <label>Total Amount *<span class="help"> </span></label> -->
<input name="machine_type" type="text" class="form-control form-control-line" value="Fleet_Machine" required>
							</div>

							<!-- <div class="form-group">
								<label>Paid by Credit Card Machine <span class="help"> </span></label>
								<input name="c_card" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Paid by Fino Bank Machine <span class="help"> </span></label>
								<input name="fino_bank" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div> -->


							
							<div class="form-group">
								<label>Remarks</label>
								<textarea name="remarks" class="form-control" rows="2" ></textarea >
							</div>
							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
                    </div>	</div>	</div>	</div>	



























</div>

<div id="Paris" class="col-12 tabcontent">

















<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Fino Machine</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/addUdhariProcess');?>" enctype="multipart/form-data">
						<div class="form-group">

                        <!-- <label>Select Machine</label>
								<select name="m_id" class="form-control" required>
								<option value="">--Select--</option> 
                                <?php
									foreach ($Machines as $Machine)
									{ $mtype = $Machine->mtype;
if($mtype == 'P'){$typ = 'Petrol';}if($mtype == 'G'){$typ = 'Gas';}if($mtype == 'D'){$typ = 'Diesel';}
										?>		
<option value="<?php echo $Machine->mid; ?>">Type-><?php echo $typ;?> && Machine Code-><?php echo $Machine->mcode;?></option>
										<?php
									}
									?>
								</select>
							 -->




                             <!-- <div class="form-group">
								<label>Select Machine Name *</label>
								<select name="machine_type" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="Petrol_and_Diesel"> Petrol And Diesel</option>
									<option value="Petrol"> Petrol</option>
									<option value="Diesel"> Diesel </option>
									<option value="Gas"> GAS </option>
								</select>
							</div> -->





							<br>




								<label>Party / Customer Name *<span class="help"> </span></label>
<input name="mcode" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							<div class="form-group">
								<label>Memo Name *</label>
<input name="mcode" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
						

								<!-- <select name="mtype" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="Petrol_and_Diesel"> Petrol And Diesel</option>
									<option value="Petrol"> Petrol</option>
									<option value="Diesel"> Diesel </option>
									<option value="Gas"> GAS </option>
								</select> -->
							</div>

						<div class="form-group">
								<label>Gadi Number *<span class="help"> </span></label>
<input name="closing" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Fuel Type *<span class="help"> </span></label>
<input name="opening" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Total Quantity in Litre *<span class="help"> </span></label>
<input name="total_amount" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Rate ( Amount in Ruppes ) *<span class="help"> </span></label>
<input name="testing" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Batch Number *<span class="help"> </span></label>
<input name="udhaar" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							<div class="form-group">
								<label>R.O.C Number *<span class="help"> </span></label>
<input name="nagad" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Total Amount *<span class="help"> </span></label>
<input name="s_card" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<!-- <div class="form-group">
								<label>Paid by Credit Card Machine <span class="help"> </span></label>
								<input name="c_card" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Paid by Fino Bank Machine <span class="help"> </span></label>
								<input name="fino_bank" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div> -->


							
							<div class="form-group">
								<label>Remarks</label>
								<textarea name="remarks" class="form-control" rows="2" ></textarea >
							</div>
							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
                    </div>	</div>	</div>	</div>	
































































































































</div>

<div id="Tokyo" class="col-12 tabcontent">
  
  





<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Credit Card Machine</h4>
						<h6 class="card-subtitle">Just add <code>as your required</code></h6>
						<form class="form-material m-t-40" method="post" action="<?=base_url('Admin/addUdhariProcess');?>" enctype="multipart/form-data">
						<div class="form-group">

                        <!-- <label>Select Machine</label>
								<select name="m_id" class="form-control" required>
								<option value="">--Select--</option> 
                                <?php
									foreach ($Machines as $Machine)
									{ $mtype = $Machine->mtype;
if($mtype == 'P'){$typ = 'Petrol';}if($mtype == 'G'){$typ = 'Gas';}if($mtype == 'D'){$typ = 'Diesel';}
										?>		
<option value="<?php echo $Machine->mid; ?>">Type-><?php echo $typ;?> && Machine Code-><?php echo $Machine->mcode;?></option>
										<?php
									}
									?>
								</select>
							 -->




                             <!-- <div class="form-group">
								<label>Select Machine Name *</label>
								<select name="machine_type" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="Petrol_and_Diesel"> Petrol And Diesel</option>
									<option value="Petrol"> Petrol</option>
									<option value="Diesel"> Diesel </option>
									<option value="Gas"> GAS </option>
								</select>
							</div> -->





							<br>




								<label>Party / Customer Name *<span class="help"> </span></label>
<input name="mcode" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							<div class="form-group">
								<label>Memo Name *</label>
<input name="mcode" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
						

								<!-- <select name="mtype" class="form-control" required>
									<option value=""> - Select Here - </option>
									<option value="Petrol_and_Diesel"> Petrol And Diesel</option>
									<option value="Petrol"> Petrol</option>
									<option value="Diesel"> Diesel </option>
									<option value="Gas"> GAS </option>
								</select> -->
							</div>

						<div class="form-group">
								<label>Gadi Number *<span class="help"> </span></label>
<input name="closing" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Fuel Type *<span class="help"> </span></label>
<input name="opening" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Total Quantity in Litre *<span class="help"> </span></label>
<input name="total_amount" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Rate ( Amount in Ruppes ) *<span class="help"> </span></label>
<input name="testing" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Batch Number *<span class="help"> </span></label>
<input name="udhaar" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>
							
							<div class="form-group">
								<label>R.O.C Number *<span class="help"> </span></label>
<input name="nagad" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Total Amount *<span class="help"> </span></label>
<input name="s_card" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<!-- <div class="form-group">
								<label>Paid by Credit Card Machine <span class="help"> </span></label>
								<input name="c_card" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div>

							<div class="form-group">
								<label>Paid by Fino Bank Machine <span class="help"> </span></label>
								<input name="fino_bank" type="text" class="form-control form-control-line" placeholder ="Some text value..." required>
							</div> -->


							
							<div class="form-group">
								<label>Remarks</label>
								<textarea name="remarks" class="form-control" rows="2" ></textarea >
							</div>
							<div class="form-group">
							<input type="submit" value="Submit" class="btn btn-lg btn-danger"></div>
						</form>
					</div>
                    </div>	</div>	</div>	</div>	



























































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

