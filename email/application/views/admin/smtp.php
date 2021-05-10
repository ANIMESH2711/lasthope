<!DOCTYPE html>

<html lang="en">

<head>

  <title>SMTP</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
 <h2 style="text-align:center">Smtp List</h2>
  <!-- Trigger the modal with a button -->
  <div style="text-align:center">
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">View Smtp</button></div>





<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">SMTP LIST</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">










<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>S.no</th>
        <th>SMTP SERVER</th>
        <th>SMTP PORT</th>
        <th width="200px">SMTP USERNAME</th>
        <th>SMTP PASSWORD</th>
        <th>SMTP FROM ID</th>
        <th>META 1</th>
        <th>META 2</th>
        
      </tr>
    </thead>
    <tbody>
      <tr><?php $i =1;
         foreach($rk as $rs){ ?>
        <td><?=$rs->id;?></td>
        <td><?=$rs->server;?></td>
        <td><?=$rs->port;?></td>
        <td style="width:200px !important"><?=$rs->Username;?></td>
        <td><?=$rs->Password;?></td>   
        <td><?=$rs->From_id;?></td>
        <td><?=$rs->meta1;?></td>
        <td><?=$rs->meta2;?></td>
       <?php $i++;
       }?>
        
        
        
        
      </tr>
      
    </tbody>
  </table>
</div>













<style>
    
table {
    border-collapse: collapse;
    width: 300px;
    overflow-x: scroll;
    display: block;
}

thead, tbody {
    /*display: block;*/
}
tbody {
    overflow-y: scroll;
    overflow-x: hidden;
    height: 280px;
}
td, th {
    /*min-width: 100px;*/
    height: 25px;
    border: dashed 1px lightblue;
    overflow:visible;
    /*text-overflow: ellipsis;*/
    /*max-width: 100px;*/
}
    
    
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



<script>
    
    $('table').on('scroll', function () {
    $("table > *").width($("table").width() + $("table").scrollLeft());
});
    
</script>






















      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>













<br><br><br><br>


<div class="col-md-3"></div>

<div class="col-md-9">

<div class="row gutters-20">
		<div class="col-md-10">
			<?php echo form_open_multipart(base_url('Admin/csvProcess'), [ 'method' => 'post', 'class' => 'form-horizontal' ]) ?>
			<label>SMTP ID: Select (SMTP ID) from SMTP List</label>  <br>
            <input type = "text" name = "smtp_id" />
         <br />
      <br>
      
      	<div class="col-md-10">

			
					<div class="row align-items-center">
						<div class="col-6">
						
							<input type="file" name="excel_file" value="" class="form-control">
						</div>
					</div>
				</div>
		</div>

		<div class="col-lg-6 col-12">
			<div class="col-6"><br><br>
				<button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i>Upload csv</button>
			</div>

     <?php echo form_close(); ?>
		</div>
	</div>





</div>

<br><br><br><br><br><br><br><br><br><br>
</div>



</body>

</html>

