<!DOCTYPE html>

<html lang="en">

<head>

  <title>SMTP</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  
</head>

<body>

<div class="col-md-3"></div>
<div class="col-md-9">


<h2>ADD SMTP FORM</h2>



<?php if ($this->session->flashdata('success')) { ?>

        <div class="alert alert-success">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong><?php echo $this->session->flashdata('success'); ?></strong>
        </div>

<?php } ?>

<?php if ($this->session->flashdata('error')) { ?>

        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong><?php echo $this->session->flashdata('error'); ?></strong>
        </div>

<?php } ?>





  <form action="<?=base_url('Admin/addSmtp/');?>" method="post" >

    

      <label for="email">SMTP Server:</label>

      <input type="text" class="form-control" name="server" id="server" placeholder="Enter details" >

    

    

      <label for="pwd">SMTP Port:</label>

      <input type="text"  class="form-control mb-2 mr-sm-2" name="port" id="port" placeholder="Enter details" >

    

    

    

      <label for="pwd">SMTP Username:</label>

      <input type="text"  class="form-control mb-2 mr-sm-2" name="Username" id="Username" placeholder="Enter details" >

    

    

    

    

      <label for="pwd">SMTP Password:</label>

      <input type="text"  class="form-control"   name="Password" id="Password" placeholder="Enter details">

    

    

    

     

   

      <label for="pwd">SMTP Set From:</label>

      <input type="text"  class="form-control" name="From" id="From" placeholder="Enter details" >

   





    

      <label for="pwd">Meta 1</label>

      <input type="text"  class="form-control" name="meta1" id="meta1" placeholder="Enter details" >

   




    

      <label for="pwd">Meta 2</label>

      <input type="text"  class="form-control" name="meta2" id="meta2" placeholder="Enter details" >

    

    

    <br><br>

    <button type="submit" class="btn btn-default">Submit</button>

  </form>
<br><br><br><br><br><br>

























<br>



</body>

</html>


