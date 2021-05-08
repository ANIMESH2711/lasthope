<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"><meta charset="UTF-8" />
</head>
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
<h3 class="text-center"> EZEETUTORS.COM</H3>

<hr>
<div class="container-fluid" style="all:initial">
            <marquee behavior="scroll" direction="left" scrollamount="7"><h3 style="color:white;"><strong>NOTE :
</strong> हम इस वेबसाइट से मिले हुए किसी भी व्यक्ति की पहचान की जिम्मेदारी नहीं लेते है ।  
मदद करने और मदद लेने वाले एक दूसरे की पहचान की जाँच कर ले ।   </h3></marquee>
           
<marquee behavior="scroll" direction="left" scrollamount="7"><h3 style="color:white;"><strong>NOTE :
</strong> We do not know any one which you meet by this website make sure their IDENTITY by urself .
</h3></marquee>
            
</div>

<?php if ($this->session->flashdata('category_success')) { ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('category_success') ?> </div>
    <?php } ?>

    <?php if ($this->session->flashdata('category_error')) { ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>
<?php } ?>


<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">

   
	<h4 class="card-title mt-3 text-center">जरूरतमंद यहाँ रजिस्टर करे।  Register if u need help . </</h4>
	<!-- <p class="text-center">Get started with your free account</p> -->
	<p>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
		<!-- <a onclick="myFunction2()" href="<?=base_url('User/studentSignup');?>" class="btn btn-block btn-twitter" style="color:white"> <i class="fas fa-chalkboard-teacher"></i>   TEACHER / MENTOR</a>
		<a  onclick="myFunction()" href="<?=base_url('User/teacherSignup');?>"  class="btn btn-block btn-facebook" style="color:white"> <i class="fas fa-user-graduate"></i>  PARENT / STUDENT </a> -->
	</p>
	<!-- <p class="divider-text">
        <span class="bg-light">OR</span>
    </p> -->
  <div id="student" style="display:none">

</div>



<div id="teacher" >
<!-- <p> <b> Parent / Student Registration </b> </p> -->

<form method="post" class="form-horizontal form-material" id="loginform" action="<?=base_url('User/dtSignUpProcess');?>">
	
  
<div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
		</div>
		<select class="form-control" style="max-width: 90px;">
		    <option selected>+91</option>
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
		    <span class="input-group-text"> <i class="fa fa-envelope"> </i> </span>
		 </div>
        <input name="email" type="email"  class="form-control" placeholder="Email address( not mandatory ) " >
    </div> <!-- form-group//( NOT MANDATORY ) -->

    <input name="role" type="text" value="1"   class="form-control" placeholder="Email address " hidden>
    
     <!-- form-group// -->
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-building"> City</i> </span>
		</div>
		<select name="city"  class="form-control" required>
    <option value="Andhra_Pradesh">Andhra Pradesh</option>
<option value="Andaman_and_Nicobar_Islands">Andaman and Nicobar Islands</option>
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
<option value="Uttar_Pradesh">Uttar Pradesh</option>
<option value="Uttarakhand">Uttarakhand</option>
<option value="West_Bengal">West Bengal</option>
		</select>
	</div> 
  
  
  
<!-- 
  <div class="form-group input-group">
  <div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-clock"> Age</i> </span>
		</div>
        <input name="age" id="age"  class="form-control" placeholder="Enter Your Age" type="text" required>
    </div>  -->
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password" id="password"  class="form-control" placeholder="Create password" type="password" required>
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

</div> 
</article>
<p class="text-center">Have an account? <a href="<?=base_url();?>">Log In</a> </p>    

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