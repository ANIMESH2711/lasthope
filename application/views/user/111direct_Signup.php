<!--<head>-->
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--</head>-->
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
<article class="card-body mx-auto" style="max-width: 100%;width: 100%;">
	<h4 class="card-title mt-3 text-center">Teacher/ Mentor Signup</h4>


<style>
* {box-sizing: border-box}

/* Set height of body and the document to 100% */
body, html {
  height: 100%;
  width: 100%;
  margin: 0;
  font-family: Arial;
}

/* Style tab links */
.tablink {
  background-color: #555;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 33%;
}

.tablink:hover {
  background-color: #777;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: white;
  display: none;
  padding: 100px 20px;
  height: 100%;
}

#Home {background-color: green;}
#News {background-color: green;}
#Contact {background-color: green;}
#About {background-color: green;}
</style>


<!-- <button class="tablink" onclick="openPage('Home', this, 'red')">Home</button> -->

<button class="tablink" onclick="openPage('News', this, 'green')" id="defaultOpen">Personal Info</button>
<button class="tablink" id="2" onclick="openPage('Contact', this, 'blue')">Preferred Schedules</button>
<button class="tablink" id="3" onclick="openPage('About', this, 'orange')">Teaching Intrest</button>

<div id="Home" class="tabcontent">
  <!-- <h3>Home</h3>
  <p>Home is where the heart is..</p> -->
</div>

<div id="News" class="tabcontent">
  <!-- <h3>News</h3> -->

  <div class="row" >
  <!-- <div class="col-md-2"></div> -->
  <div class="col-md-12">
  <div class="card bg-light"  >

  <p style="color:black;text-align:center;"><b>Personal Info </b></p> <br>

  <form method="post" class="form-horizontal form-material" id="loginform" enctype="multipart/form-data" action="<?=base_url('User/signUpTeacherProcess2');?>">
	 
  <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="name" type="text" class="form-control" placeholder="Enter Full name" >
    </div>

 
    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
		 </div>
        <input name="phone" type="text" class="form-control" value="<?=$phone;?>" required readonly>
    </div> 

    <div class="form-group input-group">
		<div class="input-group-prepend">
<span class="input-group-text"> <i class="fa fa-id-badge">&nbsp;&nbsp;Profile Img&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i> </span>
		 </div>
        <input name="img" type="file" class="form-control"  >
    </div>

    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-id-card">&nbsp;Photo Id Card</i> </span>
		 </div>
        <input name="id_img" type="file" class="form-control"  >
    </div>

    <label class="input-group-text" for="cars">Select Your Gender :</label><br>
  <div class="row" ><div class="col-6">
  <input type="checkbox" style="margin-left:50%"  id="male" name="gender" value="M"><br>
  <label for="male" style="color:black;" class="input-group-text">Male</label>
  </div><div class="col-6">
  <input type="checkbox" style="margin-left:50%"  id="female" name="gender" value="F"><br>
  <label for="female" style="color:black;" class="input-group-text">Female</label>
</div>
</div><br>

  
  
  <label class="input-group-text" for="cars">Tution Offered :</label><br>
  <div class="row" ><div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="Home1" name="tut_type_h" value="1"><br>
  <label for="Home1" style="color:black;" class="input-group-text">Home</label>
  </div><div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="Coaching" name="tut_type_c" value="1"><br>
  <label for="Coaching" style="color:black;" class="input-group-text">Coaching</label>
</div><div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="Online" name="tut_type_o" value="1"><br>
  <label for="Online" style="color:black;" class="input-group-text">Online</label>
</div>
<!-- <div class="col-3">
  <input type="checkbox" style="margin-left:50%"  id="Any_type" name="tut_type" value="Online"><br>
  <label for="Online" style="color:black;" class="input-group-text">Any</label>
</div> -->
</div>
<script>
$('input[name="gender" ]').on('change', function() {
   $('input[name="gender"]').not(this).prop('checked', false);
});
</script>
  
  <br>

  <label class="input-group-text" for="cars">Highest Qualification :</label>

<select name="quali" class="form-control"  id="quali">
<option selected disabled>-- Select --</option>
  <option value="12">Intermediate</option>
  <option value="grd">Graduation</option>
  <option value="pg">Post Graduation</option>
  <option value="phd">P.H.D</option>
  <!-- <option value="other">Other</option> -->
</select>
<br>
<label class="input-group-text" for="cars">Other Professional Qualification :</label>


<select name="other_quali" class="form-control"  id="other_quali">
<option selected disabled>-- Select --</option>
  <option value="game_teacher">Game Teacher</option>
  <option value="music_teacher">Music Teacher</option>
  <option value="yoga_teacher">Yoga Teacher</option>
  
</select>




    <hr>
    <div style="text-align:center;">
    <p class="btn btn-primary btn-block"  onclick="changetab('Contact', 2 , 'blue')">Save and Next</p> 
    </div>  

  </div> </div>
  <!-- <div class="col-md-2"></div> -->
  </div>

  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <style> #content-desktop {display: ;}
@media screen and (max-width: 768px) {
#content-desktop {display: ;}
}</style>


<script>
                          function changetab(pageName,elmnt,color){
                              // var adhaar = document.getElementById("adhaar").value ;
                              // var n = adhaar.length;
                var n = 14 ;              
  if(n >= '12'){   
    var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  document.getElementById(elmnt).style.backgroundColor = color;
  document.getElementById(elmnt).click();
  }
  else{ alert('Please Fill Adhaar Number in 12 digit format')}
                            }
                            </script>
</div>

<div id="Contact" class="tabcontent">
  <!-- <h3>Contact</h3> -->
  
  <div class="row" >
  <!-- <div class="col-md-2"></div> -->
  <div class="col-md-12">
  <div class="card bg-light"  >

  <p style="color:black;text-align:center;"><b>Preferred Schedules </b></p> <br>
  <!-- <label style="color:black;" class="input-group-text" style="color:black;text-align:center;">Select Preffered Time to Teach :</label>
<select name="time" class="form-control"  id="time">
<option selected>-- Select --</option>
  <option value="morning">Morning</option>
  <option value="noon">Afternoon</option>
  <option value="eve">Evening</option>
  <option value="night">Night</option>
  <option value="any">Any Time</option>
</select> -->

<div class="col-12">
  <label class="input-group-text" for="1">Select Preffered Time to Teach :</label><br>
  <div class="row" ><div class="col-4">

  <input type="checkbox" style="margin-left:50%" class="time"  id="t_morning" name="t_morning" value="1"><br>
  <label for="t_morning" style="color:black;" class="input-group-text">Morning</label>
  </div><div class="col-4">

  <input type="checkbox" style="margin-left:50%" class="time"  id="t_noon" name="t_noon" value="1"><br>
  <label for="t_noon" style="color:black;" class="input-group-text">Afternoon</label>
</div><div class="col-4">

  <input type="checkbox" style="margin-left:50%" class="time"  id="t_evening" name="t_evening" value="1"><br>
  <label for="t_evening" style="color:black;" class="input-group-text">Evening</label>
</div>

</div></div>
<br>



<div class="col-12"><div class="row" >
<div class="col-4">
  <input type="checkbox" style="margin-left:50%" class="time"  id="t_night" name="t_night" value="1"><br>
  <label for="t_night" style="color:black;" class="input-group-text">Night</label>
</div>
<div class="col-4">
  <input type="checkbox" style="margin-left:50%" class="any_time"  id="any_time" name="any_time" value="1"><br>
  <label for="any_time" style="color:black;" class="input-group-text">Any Time</label>
</div> </div></div>

<!-- <button class="btn btn-danger" style="margin-left:auto;margin-right:auto;" type="button" >Or You can Select :</button> <br> -->

<!-- <label class="input-group-text"  > </label> -->
<!-- <div style="margin-left:auto;margin-right:auto;" >
<input type="checkbox" style="margin-left:50%"  id="any_time11" name="any_time" value="any_time"><br>
  <label for="any_time11" style="color:black;" class="input-group-text">Any Time</label>
</div> -->
<br>
<script>
$('input[class="any_time"]').on('change', function() {
   $('input[class="time"]').not(this).prop('checked', false);
});
</script>
<script>
$('input[class="time"]').on('change', function() {
   $('input[class="any_time"]').not(this).prop('checked', false);
});
</script>



<p style="color:black;text-align:center;"><b> Select Your Teaching language :</b></p>

<div style="margin-left:auto;margin-right:auto;" >
<div class="row" ><div class="col-6">
  <input type="checkbox" style="margin-left:50%"  id="hindi" name="lang_h" value="1"><br>
  <label for="hindi" style="color:black;" class="input-group-text">Hindi</label>
  </div><div class="col-6">
  <input type="checkbox" style="margin-left:50%"  id="english" name="lang_en" value="1"><br>
  <label for="english" style="color:black;" class="input-group-text">English</label>
</div></div>
</div>

<script>
$('input[name="lang11"]').on('change', function() {
   $('input[name="lang11"]').not(this).prop('checked', false);
});
</script>

<hr>
<div style="text-align:center;">
    <p class="btn btn-primary btn-block"  onclick="changetab('About', 3 , 'yellow')">Save and Next</p> 
    </div>  

  </div> </div>
  <!-- <div class="col-md-2"></div> -->
  </div>

  
</div>

<div id="About" class="tabcontent">
 
<div class="row" >
  <!-- <div class="col-md-2"></div> -->
  <div class="col-md-12">
  <div class="card bg-light"  >

  <p style="color:black;text-align:center;"><b>Teaching Intrest </b></p> <br>


  <label class="input-group-text" for="cars">Select Board :</label><br>
  <div class="row" ><div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="CBSE" name="CBSE" value="1"><br>
  <label for="CBSE" style="color:black;" class="input-group-text">CBSE</label>
  </div><div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="ICSE" name="ICSE" value="1"><br>
  <label for="ICSE" style="color:black;" class="input-group-text">ICSE</label>
</div><div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="OTHER" name="OTHER" value="1"><br>
  <label for="OTHER" style="color:black;" class="input-group-text">OTHER</label>
</div>
</div>

<br>

<!-- <p style="color:black;text-align:center;"><b>Preferred Classes </b></p> <br> -->

<div class="col-12">
  <label class="input-group-text" for="1">Select Preferred Classes  :</label><br>
  <div class="row" ><div class="col-4">

  <input type="checkbox" style="margin-left:50%"  id="a" name="c1" value="1"><br>
  <label for="a" style="color:black;" class="input-group-text">UPTO 1 st</label>
  </div><div class="col-4">

  <input type="checkbox" style="margin-left:50%"  id="b" name="c2" value="1"><br>
  <label for="b" style="color:black;" class="input-group-text">2 - 5</label>
</div><div class="col-4">

  <input type="checkbox" style="margin-left:50%"  id="c" name="c6" value="1"><br>
  <label for="c" style="color:black;" class="input-group-text">6 - 7</label>
</div>

</div></div>
<br>

<div class="col-12"><div class="row" >
<div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="d" name="c8" value="1"><br>
  <label for="d" style="color:black;" class="input-group-text">8</label>
</div>
<div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="e" name="c9" value="1"><br>
  <label for="e" style="color:black;" class="input-group-text">9</label>
</div><div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="f" name="c10" value="1"><br>
  <label for="f" style="color:black;" class="input-group-text">10</label>
</div> </div></div>
<br>

<div class="col-12"><div class="row" >
<div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="g" name="c11" value="1"><br>
  <label for="g" style="color:black;" class="input-group-text">11</label>
</div><div class="col-4">
  <input type="checkbox" style="margin-left:50%"  id="h" name="c12" value="1"><br>
  <label for="h" style="color:black;" class="input-group-text">12</label>
</div>
</div>
<hr>
<div class="form-group">
    <div id="submit1" style="display:">
        <button  type="submit" class="btn btn-primary btn-block"> Create Account  </button>
        </div> </div> <!-- form-group// -->      
    <!-- <p class="text-center">Have an account? <a href="">Log In</a> </p>                                                                  -->
</form>

  <!-- <div class="col-md-2"></div> -->
  </div>


</div>




<script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
  






	<p>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
		<!-- <a onclick="myFunction2()" href="<?=base_url('User/studentSignup');?>" class="btn btn-block btn-twitter" style="color:white"> <i class="fas fa-chalkboard-teacher"></i>   TEACHER / MENTOR</a>
		<a  onclick="myFunction()" href="<?=base_url('User/teacherSignup');?>"  class="btn btn-block btn-facebook" style="color:white"> <i class="fas fa-user-graduate"></i>  PARENT / STUDENT </a> -->
	</p>
	<!-- <p class="divider-text">
        <span class="bg-light">OR</span>
    </p> -->













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