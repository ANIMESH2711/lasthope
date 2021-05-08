<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<h3 class="text-center"> EZEETUTOERS.COM</H3>

<hr>


<div class="container-fluid">
            <marquee behavior="scroll" direction="left" scrollamount="7"><h3 style="color:red;"><strong>NOTE :
</strong> हम इस वेबसाइट से मिले हुए किसी भी व्यक्ति की पहचान की जिम्मेदारी नहीं लेते है ।  
मदद करने और मदद लेने वाले एक दूसरे की पहचान की जाँच कर ले ।  We do not know any one which you meet by this website make sure their IDENTITY by urself .
             </h3></marquee>
            </div>

<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Help Each other and Be safe .</h4>
	<!-- <p class="text-center">Get started with your free account</p> -->
	<p>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

  <form method="post" class="form-horizontal form-material" id="loginform" action="<?=base_url('User/confirm_otp_process');?>">
	
<?php if ($this->session->flashdata('category_success')) { ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('category_success') ?> </div>
    <?php } ?>

    <?php if ($this->session->flashdata('category_error')) { ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>
<?php } ?>

  <div class="form-group input-group" >
    	<div class="input-group-prepend" >
		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
		</div>
		<select class="custom-select" style="max-width: 70px;">
		    <option selected="">+91</option>
		    <!-- <option value="1">+972</option>
		    <option value="2">+198</option>
		    <option value="3">+701</option> -->
		</select>
    	<input name="phone" class="form-control" minlength="10" value="<?=$phone; ?>" maxlength="10" placeholder="Phone number" type="text" required readonly>
    </div>

    <div class="form-group input-group" >
    	<div class="input-group-prepend" >
    
  
		    <span class="input-group-text"> <i class="fa fa-lock"> Confirm OTP</i> </span>
		</div>
		
    	<input name="otp" class="form-control" placeholder="Phone number" value="<?php if(!empty($rs[0]->otp)){echo $rs[0]->otp ;} ;?>" type="text" required>
    </div>


    <div class="form-group">
    <div >
        <button  type="submit" class="btn btn-block btn-twitter"> <i class="fa fa-key" aria-hidden="true"></i></i>   Send OTP </button>
        </div> </div> <!-- form-group// -->      
    <!-- <p class="text-center">Have an account? <a href="">Log In</a> </p>                                                                  -->
</form>

  
<!-- <a onclick="myFunction()"  class="btn btn-block btn-twitter" style="color:white"> <i class="fa fa-key" aria-hidden="true"></i></i>   Send OTP</a> -->
	</p>
	<!-- <p class="divider-text">
        <span class="bg-light">OR</span>
    </p> -->
 
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