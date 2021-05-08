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
<div class="container-fluid">
            <marquee behavior="scroll" direction="left" scrollamount="7"><h3 style="color:red;"><strong>NOTE :
</strong> हम इस वेबसाइट से मिले हुए किसी भी व्यक्ति की पहचान की जिम्मेदारी नहीं लेते है ।  
मदद करने और मदद लेने वाले एक दूसरे की पहचान के जिम्मेदार खुद होंगे।  We do not know any one which you meet by this website make sure their IDENTITY by urself .
             </h3></marquee>
             
            </div>
<h4 class="card-title mt-3 text-center">U WANT TO JOIN US FOR ? / आप किस लिए हमसे जुड़ना चाहते है।    </h4>

<div class="card bg-light col-sm-12">
<article class="card-body mx-auto" style="max-width: 100%;">

<div <?php if(!empty($flash)){?> style="display:none" <?php } ?>>

	<!-- <p class="text-center">Get started with your free account</p> -->
	<p>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
		<a  href="<?=base_url('User/u1Signup');?>" class="btn btn-block btn-twitter" style="color:white">
    <i class="fas fa-restroom"></i> आपको मदद चाहिए ।<br>  You need help ?  </a>
		<a   href="<?=base_url('User/u2Signup');?>"  class="btn btn-block btn-facebook" style="color:white">
    <i class="fas fa-user-md"></i>  किसी जरूरतमंद की मदद करने के लिए ।<br> you want to help someone ? </a> 
	</p></div>
 

 <div class="card bg-light ">
<article class="card-body mx-auto" style="max-width: 100%;">

<?= $this->lib->notification();?>

<?php if ($this->session->flashdata('category_success')) { ?>
        <div class="alert alert-success"> <?= $this->session->flashdata('category_success') ?> </div>
    <?php } ?>

    <?php if ($this->session->flashdata('category_error')) { ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('category_error') ?> </div>
<?php } ?>
<div >
<form method="post" class="form-horizontal form-material" id="loginform" action="<?=base_url('Admin/Auth');?>">
					<h3 class="box-title m-b-20">Sign In</h3>
					<div class="form-group ">
						<div class="col-xs-12">
	<input name="username" class="form-control" type="text" required="" minlength="10" maxlength="10" placeholder="Your Phone Number"> </div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<input name="password" class="form-control" type="password" required="" placeholder="Password"> </div>
					</div>
					<div class="form-group row">
						<div class="col-md-12 font-14">
							<div class="checkbox checkbox-primary pull-left p-t-0">
								<input id="checkbox-signup" type="checkbox">
								<label for="checkbox-signup"> Remember me </label>
							</div> <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><!-- <i class="fa fa-lock m-r-5"></i> --> Forgot pwd?</a> </div>
					</div>
					<div class="form-group text-center m-t-20">
						<div class="col-xs-12">
							<button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
						</div>

				</form>
  
  
  </div></div>
  </div></div>






</div>




</div> 
</article>
<!-- <h3 class="text-center">Have an account? <a href="<?=base_url();?>">Log In</a> </h3>     -->

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