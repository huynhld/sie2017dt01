<?php
include('../login/session.php');

if (strcmp($_SESSION['role'], "student") == 0) {}
else{
    session_destroy();
    header("Refresh: 3; url=/login/login.php");
    echo '<h3>Access deined - you do not have access to this page</h3>';
    echo 'You will be redirected in 3 seconds';
    //include ('includes/footer.html');
    exit(); // Quit the script.
} 

define('STUDENT_UPDATE_CV', 'update_cv');
define('STUDENT_LIST_TOPIC', 'list_topics');
define('STUDENT_FILL_ASPIRATION_FORM', 'fill_aspiration_form');
define('STUDENT_FEED_BACK', 'feed_back');
define('STUDENT_SUBMIT_FORM', 'submit_report');
define('STUDENT_VIEW_STATUS', 'view_status');
define('STUDENT_VIEW_POINT', 'view_point');

?>
<?php

	if (isset($_GET['router'])) {
    	$router_value = $_GET['router'];
    	
    	if(strcmp($router_value, STUDENT_UPDATE_CV) == 0){ 
    		echo 'c1v';
    		header("location:update_cv.php");
    	}else if(strcmp($router_value, STUDENT_LIST_TOPIC) == 0){ 
    		echo '2cv';
            header("location:view_list_topics.php");
    	}else if(strcmp($router_value, STUDENT_FILL_ASPIRATION_FORM) == 0){ 
    		echo '3cv';
            header("location:fill_aspiration_form.php");
    	}else if(strcmp($router_value, STUDENT_FEED_BACK) == 0){ 
    		echo '4cv';
            header("location:feed_back.php");
    	}else if(strcmp($router_value, STUDENT_SUBMIT_FORM) == 0){ 
    		echo '5cv';
            header("location:submit_report.php");
    	}else if(strcmp($router_value, STUDENT_VIEW_STATUS) == 0){ 
    		//echo '    <a href="download.php?filename=BM01_2_6_CongtyChamcong.xls"> Tải mẫu chấm công</a>';
    	}else if(strcmp($router_value, STUDENT_VIEW_POINT) == 0){ 
    		header("location:view_score.php");
        }

	}else{
    	// Fallback behaviour goes here
    	//echo 'ab';
		// return;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script type="text/javascript" src="../js/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <style type="text/css">
        .navbar{
            height: 100px;
        }
        .link_select{
            margin: 20px 0px;
            text-decoration: underline;
        }
        .img-footer{
            float: right;
            position: absolute;
            top: 0;
            right: 0;
        }
        .container{
            background-color: #f8f8f8;
            border-color: #e7e7e7;
            margin: 10px auto;
            
        }
        .row{
            padding: : 20px;
            margin: auto;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing:border-box}
body {font-family: Verdana,sans-serif;}
.mySlides {display:none}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 13px;
  width: 13px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>
</head>
<body>
    <!--header-->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- <div class="container-fluid"> -->
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        <img alt="Brand" src="../image/logo1.png" style="width: 80px; height: 95px; margin: -10px -5px;">
                    </a>
                    <a class="navbar-brand" href="#">
                        <img alt="Brand" src="../image/logo2.png" style="width: 120px; height: 90px; margin: -10px -5px;">
                    </a>
                </div>
        
                <!-- Collect the nav links, forms, and other content for toggling -->
                <!-- <div class="collapse navbar-collapse navbar-ex1-collapse"> -->
                    <div class="row">
                    <div class="col-xs-12 col-lg-8 " style="text-align: center">
                        <h2 style="margin-top: 5px;">Trường Đại Học Bách Khoa Hà Nội</h2>
                        <h3 style="margin-top: 5px;">Viện đào tạo quốc tế</h3>
                    </div>
                    <div class="col-xs-12 col-lg-3 col-lg-offset-8 bottom-align-text " style="position: absolute; bottom: 0;">
                        <a href="#">Welcome Student |</a>
                    
                        <button type="submit" class="btn btn-default"><a href = "/login/logout.php">Sign Out</a></button>              
                    </div>          
                <!-- </div> -->
            </div>
        </nav>
    <!--header-->
<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="/img/slideshow/img1.jpg" style="width:100%; height: 80%">
  <div class="text"></div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="/img/slideshow/img2.jpg" style="width:100%; height: 80%">
  <div class="text"></div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="/img/slideshow/img3.jpg" style="width:100%; height: 80%">
  <div class="text"></div>
</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>

<script>
var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex> slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 3000); // Change image every 2 seconds
}
</script>
    <div class="container">
        <div class="row text-left">
            <!-- <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 link_select">
                <a href = "index.php?router=<?= STUDENT_UPDATE_CV?>">Thêm/ Sửa CV</a>
            </div> -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 link_select">
                <a href = "index.php?router=<?= STUDENT_SUBMIT_FORM?>">Nộp báo cáo thực tập</a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 link_select">
                <a href = "index.php?router=<?= STUDENT_LIST_TOPIC?>">Đề tài thực tập</a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 link_select">
                <!-- <a href = "index.php?router=<?= STUDENT_VIEW_STATUS?>">Tình trạng TT</a> -->
            <a href="../guide/download.php?filename=BM01_2_6_CongtyChamcong.xls">Tình trạng TT</a> 
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 link_select">
                <a href = "index.php?router=<?= STUDENT_FILL_ASPIRATION_FORM?>">Điền mẫu đăng kí NVTT</a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 link_select">
                <a href = "index.php?router=<?= STUDENT_VIEW_POINT?>">Xem điểm thực tập</a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 link_select">
                <a href = "index.php?router=<?= STUDENT_FEED_BACK?>">Phản hồi về TTTT</a>
            </div>

        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <footer>    
        <div class="col-xs-12 col-md-12 footer-content">
            <div class="container">
                <div class="row"><div class="col-sm-12"><div class="padd"> <img class="img-footer" src="http://sie.vn/wp-content/themes/hueman/img/logonho.png" alt="logo sie"><div class="sie-info"><p style="font-size:13px;">Add: Room 201, D7 Building, HUST | No.1, Dai Co Viet Street, Hanoi, Vietnam.</p><p>Tel:(+84)04.3868.3407 &amp; 3868.2261 | Fax:(+84)04.3868.3409</p><p>Email: info@sie.edu.vn | Website: http://sie.hust.edu.vn</p></div></div><div class="grid one-half last"></div></div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
