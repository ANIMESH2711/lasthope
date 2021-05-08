<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
<style>

.divider-text {
    position: relative;
    text-align: center;
    margin-top: 15px;
    margin-bottom: 15px;
}
.divider-text span {
    padding: 7px;
    font-size: 12px;
    position: relative;   
    z-index: 2;
}
.divider-text:after {
    content: "";
    position: absolute;
    width: 100%;
    border-bottom: 1px solid #ddd;
    top: 55%;
    left: 0;
    z-index: 1;
}

.btn-facebook {
    background-color: #405D9D;
    color: #fff;
}
.btn-twitter {
    background-color: #42AEEC;
    color: #fff;
}


</style>

<div class="container">
<!-- <br>  <p class="text-center">More bootstrap 4 components on <a href="http://bootstrap-ecommerce.com/"> Bootstrap-ecommerce.com</a></p> -->
<br>
<h3 class="text-center"> EZEETUTOERS.COM</H3>

<hr>



<?php if ($this->session->flashdata('category_success')) { ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('category_success') ?> </div>
    <?php } ?>

    <?php if ($this->session->flashdata('category_error')) { ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>
<?php } ?>


<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Teacher/ Mentor Signup</h4>
	<!-- <p class="text-center">Get started with your free account</p> -->
	<p>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
		<!-- <a onclick="myFunction2()" href="<?=base_url('User/studentSignup');?>" class="btn btn-block btn-twitter" style="color:white"> <i class="fas fa-chalkboard-teacher"></i>   TEACHER / MENTOR</a>
		<a  onclick="myFunction()" href="<?=base_url('User/teacherSignup');?>"  class="btn btn-block btn-facebook" style="color:white"> <i class="fas fa-user-graduate"></i>  PARENT / STUDENT </a> -->
	</p>
	<!-- <p class="divider-text">
        <span class="bg-light">OR</span>
    </p> -->
   
<script>
function myFunction() {
  var x = document.getElementById("student");
  var y = document.getElementById("teacher");
  y.style.display = "none";
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function myFunction2() {
  var x = document.getElementById("teacher");
  var y = document.getElementById("student");
  y.style.display = "none";
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
<div id="student" style="display:none">

<script>
//  function confirm() {
  $('#pwd, #cpwd').on('keyup', function () {
  //  alert('ok');
   var password = $('#pwd').val() ;
   var c_password = $('#cpwd').val() ; 
   var y = document.getElementById("submit22");   

  if (password == c_password ) {
    y.style.display = "block";
    $('#message22').html('Password is Matching').css('color', 'green');
   
  } else {
  y.style.display = "none";
    $('#message22').html('Password is Not Matching').css('color', 'red');
  }
// };
});
</script>




</div>



















<div id="teacher" >
<p> <b> Teacher / Mentor Registration </b> </p>

<form method="post" class="form-horizontal form-material" id="loginform" action="<?=base_url('User/signUpTeacherProcess');?>">
	
  
<div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
		</div>
		<select class="custom-select" style="max-width: 70px;">
		    <option selected="">+91</option>
		    <!-- <option value="1">+972</option>
		    <option value="2">+198</option>
		    <option value="3">+701</option> -->
		</select>
    	<input name="phone" class="form-control" value="<?=$phone; ?>" minlength="10" maxlength="10" placeholder="Phone number" type="text" readonly required>
    </div>



  
  
  <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="name" type="text" class="form-control" placeholder="Full name" required>
    </div> <!-- form-group// -->
    <!-- <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-image"> Profile Picture</i> </span>
		 </div>
    <input name="img" type="file" class="form-control form-control-line" placeholder="Some text value..." required=""> -->
    <!-- <input name="img" type="file" class="form-control form-control-line" placeholder ="Some text value..." required> -->
    <!-- </div> -->

    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"> Log Id</i> </span>
		 </div>
        <input name="email" type="email"  class="form-control" placeholder="Email address" required>
    </div> <!-- form-group// -->

    
     <!-- form-group// -->
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
		</div>
		<select name="subject"  class="form-control" required>
			<option selected="" disable> Select Main Subject</option>
			<option value="Mathematics">Mathematics</option>
			<option value="Science">Science</option>
			<option value="Health">Health</option>
      
      <option value="Physical_Education">Physical Education</option>
			<option value="Art">Art</option>
			<option value="Music"> Music</option>
			<!-- <option value="volvo"> Music</option> -->

      <option value="Dramatics">Dramatics</option>
			<option value="Dance">Dance</option>
			<option value="English">English</option>

      <option value="Social_Studies">Social Studies</option>
			<option value="Computer_Science">Computer Science</option>
      <option value="Chemistry">Chemistry</option>
			<option value="Organic_Chemistry">Organic Chemistry</option>
      <option value="In_Organic_Chemistry">In Organic Chemistry</option>

      <option value="Botany">Botany</option>
			<option value="Zoology">Zoology</option>
			<option value="Biology">Biology</option>
		</select>
	</div> 
  
  
  

  <div class="form-group input-group">
  <div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-clock"> Age</i> </span>
		</div>
        <input name="age" id="age"  class="form-control" placeholder="Enter Your Age" type="text" required>
    </div> 
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password" id="password"  class="form-control" placeholder="Create password" type="password">
    </div> 
  <!-- form-group end.// -->
    <!-- 
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input  name="cpassword"  id="confirm_password" class="form-control" placeholder="Repeat password" type="password">
    </div> 
    <span id='message'></span> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <div class="form-group">
    <div id="submit1" style="display:">
        <button  type="submit" class="btn btn-primary btn-block"> Create Account  </button>
        </div> </div> <!-- form-group// -->      
    <!-- <p class="text-center">Have an account? <a href="">Log In</a> </p>                                                                  -->
</form>
<script>
//  function confirm() {
  $('#password, #confirm_password').on('keyup', function () {
  //  alert('ok');
   var password = $('#password').val() ;
   var c_password = $('#confirm_password').val() ; 
   var y = document.getElementById("submit11");   

  if (password == c_password ) {
    y.style.display = "block";
    $('#message').html('Password is Matching').css('color', 'green');
   
  } else {
  y.style.display = "none";
    $('#message').html('Password is Not Matching').css('color', 'red');
  }
// };
});
</script>

</div> 
</article>
<p class="text-center">Have an account? <a href="<?=base_url('User/userLogin');?>">Log In</a> </p>    

</div>
<!-- card.// -->

</div> 
<!--container end.//-->

<!-- <br><br> -->
<!-- <article class="bg-secondary mb-3">  
<div class="card-body text-center">
    <h3 class="text-white mt-3">Bootstrap 4 UI KIT</h3>
<p class="h5 text-white">Components and templates  <br> for Ecommerce, marketplace, booking websites 
and product landing pages</p>   <br>
<p><a class="btn btn-warning" target="_blank" href="http://bootstrap-ecommerce.com/"> Bootstrap-ecommerce.com  
 <i class="fa fa-window-restore "></i></a></p>
</div>
<br><br>
</article> -->