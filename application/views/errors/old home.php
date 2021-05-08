<!DOCTYPE html>
<html>
<title>PETROL PUMP</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<style>
body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

<!-- w3-content defines a container for fixed size centered content, 
and is wrapped around the whole page content, except for the footer in this example -->
<div class="w3-content" style="max-width:1400px">

<!-- Header -->
<header class="w3-container w3-center w3-padding-32"> 
  <h1><b>Petrol Pump</b></h1>
  <p>Welcome to OUR <span class="w3-tag">PETROL PUMP</span></p>
</header>

<!-- Grid -->
<div class="w3-row">

<!-- Blog entries -->
<div class="w3-col l8 s12">
  <!-- Blog entry -->
  <div class="w3-card-4 w3-margin w3-white">
    <img src="https://petrolpump.freelovechat.in/img/refueling-car_1426-1790.jpg" alt="Nature" style="width:100%">
    <div class="w3-container">
      <h3><b>Our services</b></h3>
      <h5>Petrol <span class="w3-opacity">And Other Fuels</span></h5>
    </div>

    <div class="w3-container">
      <p>We do as we promise </p>
      <div class="w3-row">
        <!-- <div class="w3-col m8 s12">
          <p><button class="w3-button w3-padding-large w3-white w3-border"><b>READ MORE »</b></button></p>
        </div> -->
        <!-- <div class="w3-col m4 w3-hide-small">
          <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-tag">0</span></span></p>
        </div> -->
      </div>
    </div>
  </div>
  <hr>

  <!-- Blog entry -->
  <div class="w3-card-4 w3-margin w3-white">
  <img src="https://petrolpump.freelovechat.in/img/15.jpg" alt="Norway" style="width:100%">
    <div class="w3-container">
      <h3><b>Thousands of satisfied custOMERS</b></h3>
      <h5>“If you fuel your journey on the opinions of others, you are going to run out of gas.” <span class="w3-opacity">Always</span></h5>
    </div>

    <div class="w3-container">
      <p>Water and petrol both come from the earth, and though they seem to be alike and even the same, they are in nature and purpose exact opposites, for the one extinguishes fire and the other adds fuel to it. So also the world and its treasures, the heart and its thirst for God are alike His creation. Now the result of the attempt to satisfy the heart with the wealth and pride and honours of this world is the same as if one tried to put out a fire with petrol, for the heart can only find ease and satisfaction in Him who created both it and the longing desire of which it is conscious.</p>
      <div class="w3-row">
        <div class="w3-col m8 s12">
          <p><button class="w3-button w3-padding-large w3-white w3-border"><b>READ MORE »</b></button></p>
        </div>
        <div class="w3-col m4 w3-hide-small">
          <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-badge">2</span></span></p>
        </div>
      </div>
    </div>
  </div>
<!-- END BLOG ENTRIES -->
</div>

<!-- Introduction menu -->
<div class="w3-col l4">


<div class="container-right" style="position: relative ;  text-align:center;">          
  <!-- <button type="button" class="btn btn-default btn-lg">Large Default Button</button> -->
  <!-- <a href="<?=base_url('Admin/adminLogin');?>"><button type="button" class="btn btn-primary btn-block-lg-right">Admin LOGIN</button></a>       -->

  <!-- <form action=" Admin/adminLogin">
  <!-- <button type="button" class="btn btn-primary btn-block-lg-right">Admin LOGIN</button>      -->
  <!-- <input type="submit" class="btn btn-primary btn-block-lg-right" value="Admin LOGIN" /> -->
<!-- </form> --> 
<form method="" action="<?php  echo base_url(); ?>Admin/adminLogin">
       <button id="submit-buttons" class="btn btn-primary btn-block-lg-right" type="submit" ​​​​​>Admin LOGIN</button>
</form>

</div>

  <!-- About Card -->
  <div class="w3-card w3-margin w3-margin-top">
  <img src="https://petrolpump.freelovechat.in/img/11.jpg" style="width:100%">
    <div class="w3-container w3-white">
      <h4><b>Petrol Pump</b></h4>
      <p>Just me, myself and I, exploring the universe of uknownment. I have a heart of love and a interest of lorem ipsum and mauris neque quam blog. I want to share my world with you.</p>
    </div>
  </div><hr>
  
  <!-- Posts -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding">
      <h4>Popular Products</h4>
    </div>
    <ul class="w3-ul w3-hoverable w3-white">
      <li class="w3-padding-16">
        <img src="/w3images/workshop.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Petrol</span><br>
        <span>Drive Long</span>
      </li>
      <li class="w3-padding-16">
        <img src="/w3images/gondol.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Diesel</span><br>
        <span>Pirates Of the Way</span>
      </li> 
      <li class="w3-padding-16">
        <img src="/w3images/skies.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Gas</span><br>
        <span>Cheap and Best</span>
      </li>   
      <!-- <li class="w3-padding-16 w3-hide-medium w3-hide-small">
        <img src="/w3images/rock.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
        <span class="w3-large">Mingsum</span><br>
        <span>Lorem ipsum dipsum</span>
      </li>   -->
    </ul>
  </div>
  <hr> 
 
  <!-- Labels / tags -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding">
      <h4>Tags</h4>
    </div>
    <div class="w3-container w3-white">
     <p><!--<span class="w3-tag w3-black w3-margin-bottom">Travel</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">New York</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">London</span> -->
      <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Petrol</span> 
      <!-- <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">NORWAY</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">DIY</span> -->
      <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Diesel</span> 
      <!-- <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Baby</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Family</span> -->
      <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Gas</span>
       <!-- <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Clothing</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Shopping</span> -->
      <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Others</span> 
      <!-- <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Games</span> -->
    </p>
	</div>
	<div class="container">          
  <!-- <button type="button" class="btn btn-default btn-lg">Large Default Button</button>
  <button type="button" class="btn btn-primary btn-lg">Large Info Button</button>       -->
</div>
  </div>
  
<!-- END Introduction Menu -->
</div>

<!-- END GRID -->
</div><br>

<!-- END w3-content -->
</div>



<!-- Footer -->
<footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
  <!-- <button class="w3-button w3-black w3-disabled w3-padding-large w3-margin-bottom">Previous</button>
  <button class="w3-button w3-black w3-padding-large w3-margin-bottom">Next »</button>
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p> -->
</footer>

</body>
</html>
