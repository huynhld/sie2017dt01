<?php
	include('../login/session.php');
	if (strcmp($_SESSION['role'], "guide") == 0) {}
	else{
		session_destroy();
	    header("Refresh: 3; url=/login/login.php");
	    echo '<h3>Access deined - you do not have access to this page</h3>';
	    echo 'You will be redirected in 3 seconds';
	    //include ('includes/footer.html');
	    exit(); // Quit the script.
	} 

	define('GUIDE_FILE_TIMEKEEPING', 'timekeeping'); 	// chấm công
	define('GUIDE_FILE_SYLLABUS', 'syllabus');			// đề cương chi tiết
	$type = GUIDE_FILE_SYLLABUS;

	$upload_status = '';
	// Kiểm tra CV đã được up lên chưa.
	$_SESSION['pdf_viewed_file'] = '';
	$user_id = $_SESSION['user_id'];
	$ses_sql = mysqli_query($db, "select location from guide_upload_file where usr_id = '$user_id' and type = '$type' order by datetime desc limit 1");
	$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
	$_SESSION['pdf_viewed_file'] = $row['location'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$target_dir = "../uploads/";

	$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 5000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($fileType != "pdf" ) {
	    echo "Sorry, only pdf files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    // re-new target location
	    $unique_value = date('mdY_His', time());
	    $target_file = $target_dir.$unique_value.".pdf";
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	        $sql = "INSERT INTO `guide_upload_file` (`id`, `usr_id`, `type`, `datetime`, `location`) VALUES (NULL, '$user_id', '$type', '$unique_value', '$target_file');";
	        $result = mysqli_query($db, $sql);

	        $upload_status = "Upload file thành công";
	        
	        header("Refresh: 3; url=index.php");
	  		echo '<h3>Upload file thành công</h3>';
	  		echo '<p>Chuyển lại trang sau 3 giây</p>';
	  		//include ('includes/footer.html');
	  		//header('Location: ../student/update_cv.php');
	  		exit(); // Quit the script.
	        
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>Đại diện doanh nghiệp cập nhật đề cương chi tiết</title>
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
<form action="" method="post" enctype="multipart/form-data">
	<div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $upload_status; ?></div>
	
	<br/>
    	Upload đề cương chi tiết (* chỉ sử dụng định dạng pdf để thuận tiện cho việc hiển thị )
    <br/>
    <input type="file" name="fileToUpload" id="fileToUpload" accept = ".pdf" >
    <br/>
    <input type="submit" value="Upload File" name="submit">

    <br/>
    <a href="/utils/pdf_display.php">Hiển thị đề cương chi tiết đã tải lên</a>
</form>
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