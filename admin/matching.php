<?php

include("../login/Config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Prepare Data =====================================================================================
	// Prepare company data
	$sql = 'SELECT * FROM `company_informations`';
	$result = mysqli_query($db, $sql);

	// company data
	$data = array();

	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) $data[] = $row;

	// Prepare Student data
	$sid = $_POST['sid'];
	// if (isset($_GET['id'])) {
	//     $sid = $_GET['id'];
	// }

	if($sid == 0 || $sid == -1) {
			$message = "Id sinh viên không hợp lệ, chọn lại";
		    header("Refresh: 2; url=/admin/matching.php");
    		echo $message;
    		
    		exit(); // Quit the script.
	}

	$sql = "SELECT * FROM student_aspiration_form WHERE usr_id = '$sid'";
	$result = mysqli_query($db, $sql);

	// Student data
	$studentData = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if(count($studentData)==0){
		$message = "Sinh viên này chưa hoàn thành biểu mẫu đăng ký nghuyện vọng";
		header("Refresh: 2; url=/admin/matching.php");
    	echo $message;
    	exit(); // Quit the script.
	};
	$studentData = json_encode($studentData);

	// ===================================================================================================
	// Define factors
	$skills =  array('c_c_plus_plus', 'java_j2ee', 'php', 'c_obj', 'java_android', 'rlanguage', 'matlab');
	$softSkills =  array('english', 'teamwork', 'leadership', 'researching', 'sing', 'dance');
	// define quality
	$quality = array('unknown' => 0, 'beginner' => 1, 'intermediates' => 3, 'advanced' => 5, 'expert' => 10);

	// pointing
	$points = array();

	// breaking student info
	$obj = json_decode($studentData);
	$skill_english = $obj->skill_english;

	$skill_programming = $obj->skill_programming;
	$skill_system_mng = $obj->skill_system_mng;
	$skill_certificate = $obj->skill_certificate;
	$skill_other = $obj->skill_other;
	$skill_soft_skill = $obj->skill_soft_skill;
	
	$message = 'Đánh điểm so khớp công ty ';

	for($index = 0; $index < count($data); ++$index) {
		
		// 80 work skill - 20 softsikk
		$hSkillPoint = 0;
		$sSkillPoint = 0;
		
		$ska = explode(",", $data[$index]['skills']);
		for($i = 0; $i < count($ska) -1 ; ++$i){
			if( false !== strpos($skill_programming, trim($ska[$i])) ) $hSkillPoint += 80;
			if( false !== strpos($skill_system_mng, trim($ska[$i])) ) $hSkillPoint += 40;
			if( false !== strpos($skill_certificate, trim($ska[$i])) ) $hSkillPoint += 40;
		}

		$ska = explode(",", $data[$index]['other']);
		for($i = 0; $i < count($ska) -1 ; ++$i){
			if ( false !==  strpos($skill_soft_skill, trim($ska[$i])) ) $hSkillPoint += 20;
			if ( false !==  strpos($skill_other, trim($ska[$i])) ) $hSkillPoint += 10;
		}
		
		$hSkillPoint *= 0.80;
		$sSkillPoint *= 0.20;
		$point = $hSkillPoint + $sSkillPoint;
		$points[] = $point;

		$message .= '\\n'.'Công ty ' .$data[$index]['name'] .' điểm : ' .$point;

	}
	$message .= '\\n' .'Cao hơn là tốt hơn';
	echo "<script type='text/javascript'>alert('$message');</script>";
} else {

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>So khớp nguyện vọng doanh nghiệp</title>
	<script type="text/javascript" src="../js/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/html2canvas.js"></script>
    <!-- <script type="text/javascript" src="../js/jspdf.min.js"></script>     -->
    <script type="text/javascript" src="../js/jspdf.debug.js"></script>
    <script type="text/javascript">
		function click_me() {
			html2canvas(document.body, {
   				onrendered: function(canvas) {
    			var img = canvas.toDataURL("image/png", 1.0);
    			window.open(img);
			    
			    var doc = new jsPDF({
					  orientation: 'landscape',
					  unit: 'in',
					  format: [18.21, 21.29]
					})
			    doc.addImage(img, "PNG", 0, 0);
			    doc.save("phieudangkynguyenvong.pdf");
			    
  			}	
			});

		}

</script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <style type="text/css">
        .navbar{
            height: 100px;
        }
        .link_select{
            margin: 20px 0px;
            text-decoration: underline;
        }
        <style>
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

<body >
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
                <!--         <a href="#"></a>
                    
                        <button type="submit" class="btn btn-default"><a href = "/login/logout.php">Sign Out</a></button>   -->            
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

	<form action="" method="POST" enctype="multipart/form-data">
	<div class="container">
	 Chọn sinh viên 
	 <?php 
	 	$sql = 'SELECT * FROM `users` WHERE role_id = 2' ;
		$result = mysqli_query($db, $sql);
		// while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) echo $row['id'];
	?>
		<select id="sid" name="sid" >
			<?php 
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					$id = '' .$row['id'];
					$name = ''.$row['username'];

					echo '<option value="';
					echo $id;
					echo '" >';
					echo $name;
					echo "</option>";
					// echo '<option value="' + $id + '">Select...</option>';
					// echo $row['id'];
				}
			?>
		</select>

		<input type="submit" name="search" value="So khớp"/>
	</div>
	</form>
	<div class="container">
	</div>
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