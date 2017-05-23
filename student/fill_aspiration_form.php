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
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// 1. Thong tin chung
	$name = $_POST['ho_ten'];
	$class = $_POST['lop'];
	$student_id = $_POST['shsv'];
	$gender = $_POST['gender'];
	$address = $_POST['dia_chi'];

	// 2. Ky nang
	$skill_english = $_POST['ky_nang_tieng_anh'];
	$has_c_c_plus_plus = 0;
	$has_java_j2ee = 0;
	$has_php = 0;
	$has_c_obj = 0;
	$has_java_android = 0;

	$skill_system_mng = $_POST['ky_nang_qtht_gtm'];
	$skill_certificate = $_POST['chung_chi_chuyen_mon'];
	$skill_other = $_POST['mo_ta_khac'];
	$skill_soft_skill = $_POST['ky_nang_mem'];
	if(isset($_POST['ki_nang'])){
		if(in_array('c_c_plus_plus', $_POST['ki_nang'])) $has_c_c_plus_plus = 1;
		if(in_array('java_j2ee', $_POST['ki_nang'])) $has_java_j2ee = 1;
		if(in_array('php', $_POST['ki_nang'])) $has_php = 1;
		if(in_array('c_obj', $_POST['ki_nang'])) $has_c_obj = 1;
		if(in_array('java_android', $_POST['ki_nang'])) $has_java_android = 1;
	}
	// TODO: fill programing here
	$skill_programming = '';
	if($has_c_c_plus_plus == 1) $skill_programming .= "c_c_plus_plus";
	if($has_java_j2ee == 1) $skill_programming .= "has_java_j2ee";
	if($has_php == 1) $skill_programming .= "php";
	if($has_c_obj == 1) $skill_programming .= "c_obj";
	if($has_java_android == 1) $skill_programming .= "java_android";

	// 3. Kỹ năng muốn học hỏi
	$kng_wantt_learn = $_POST['ky_nang_muon_hoc'];

	// 4. Thon tin DVTT
	$has_internship_company = 0;
	$int_name = '';
	$int_address = '';
	$int_pic = '';
	$int_phone = '';
	$int_email = '';
	$int_dfrom = '';
	$int_dto = '';

	if(isset($_POST['has_dvtt'])){ 
		$has_internship_company = 1;
		$int_name = $_POST['dvtt_congty'];
		$int_address = $_POST['dvtt_dia_chi'];
		$int_pic = $_POST['dvtt_nguoi_phu_trach'];
		$int_phone = $_POST['dvtt_dien_thoai'];
		$int_email = $_POST['dvtt_email'];
		$int_dfrom = $_POST['dvtt_dfrom'];
		$int_dto = $_POST['dvtt_dto'];

	}
	
	// TODO: check validate

	// Insert to DB
	$usr_id = $_SESSION['id'];
	$_gender = 0;
	if(strcmp($gender, "male")) $_gender = 0;
	else $_gender = 1;
	
	$unique_value = date('mdY_His', time());
	$sql = "INSERT INTO `student_aspiration_form` (`usr_id`, `datetime`,`name`, `class`, `student_id`, `gender`, `address`, `skill_english`, `skill_programming`, `skill_system_mng`, `skill_certificate`, `skill_other`, `skill_soft_skill`, `kng_wantt_learn`, `has_internship_company`, `int_name`, `int_address`, `int_pic`, `int_phone`, `int_email`, `int_dfrom`, `int_dto`) VALUES ('$usr_id', '$unique_value', '$name', '$class', '$student_id', '$_gender', '$address', '$skill_english', '$skill_programming', '$skill_system_mng', '$skill_certificate', '$skill_other', '$skill_soft_skill', '$kng_wantt_learn', '$has_internship_company', '$int_name', '$int_address', '$int_pic', '$int_phone', '$int_email', '$int_dfrom', '$int_dto');";
	

	$result = mysqli_query($db, $sql);
}

	// View filled.
	$usr_id = $_SESSION['id'];
	$sql = "SELECT * FROM student_aspiration_form WHERE usr_id = $usr_id ORDER BY datetime desc LIMIT  1";
	$result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);
    
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	//echo $row["datetime"];
	//echo $row["gender"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PHIẾU ĐĂNG KÝ NGUYỆN VỌNG THỰC TẬP</title>
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

	<form action="" method="post" enctype="multipart/form-data">

	<div class="container">
	<br>
    <button type="button" id="cmd" onclick="click_me()">Tải về phiếu đăng ký nguyện vọng</button>
    <br>
    <br>
	<div class="row" style="text-align: center;">

		<h1>PHIẾU ĐĂNG KÝ NGUYỆN VỌNG THỰC TẬP</h1>
	</div>
<?php if($count > 0 ) { ?>
		<h3>1. Thông tin chung</h3>

			Họ tên <input type="text" name="ho_ten" id="ho_ten" required="true" value="<?=$row["name"]?>">
			&nbsp;Lớp <input type="text" name="lop" required="true" value="<?=$row["class"]?>">
			&nbsp;&nbsp;Số hiệu sinh viên  <input type="text" name="shsv" required="true" value="<?=$row["student_id"]?>">
			<br>
			<br>
			Giới tính<select name="gender">
					  <option value="male" selected="<?php if(strcmp($row["gender"], "0")==0) echo "true"; else echo "false"; ?>">Nam</option>
					  <option value="female" selected="<?php if(strcmp($row["gender"], "1")==0) echo "true"; else echo "false"; ?>">Nữ</option>
					</select>
			
			&nbsp;&nbsp;Địa chỉ <input type="text" name="dia_chi" required="true" size="75" value="<?=$row["address"]?>">
			<br>
			<hr>
		<h3>2. Kỹ năng</h3>
		<table >
			<tr>
				<th>Kỹ năng tiếng anh </th>
				<td>
					<input type="text" name="ky_nang_tieng_anh" required="true" placeholder="(Trường hợp không có ghi là không có)" size="60" value="<?=$row["skill_english"]?>">
			
				</td>
			</tr>
			<tr>
				<th>Kỹ năng lập trình</th>
			
				<td>
					<input type="checkbox" name="ki_nang[]" value="c_c_plus_plus" <?php if(strpos($row["skill_programming"], "c_plus_plus") != false) echo "checked"; ?> >C/C++
					&nbsp;
					<input type="checkbox" name="ki_nang[]" value="java_j2ee" <?php if(strpos($row["skill_programming"], "java_j2ee") != false) echo "checked"; ?>>java J2EE
					&nbsp;
					<input type="checkbox" name="ki_nang[]" value="php" <?php if(strpos($row["skill_programming"], "php") != false) echo "checked"; ?>>PHP
					&nbsp;
					<input type="checkbox" name="ki_nang[]" value="c_obj" <?php if(strpos($row["skill_programming"], "c_obj") != false) echo "checked"; ?> >C-Objective(iOS)
					&nbsp;
					<input type="checkbox" name="ki_nang[]" value="java_android" <?php if(strpos($row["skill_programming"], "java_android") != false) echo "checked"; ?> >Java (Android)
				</td>
			</tr>

			<tr>
				<th>Kỹ năng quản trị hệ thống, quản trị mạng</th>
				<td><textarea name="ky_nang_qtht_gtm" cols="40" rows="5" required="true" ><?=$row["skill_system_mng"]?></textarea></td>
			</tr>
			
			<tr>
				<th>Các chứng chỉ chuyên môn (IBM, Microsoft, Cisco, Oracle, ...)</th>
				<td><textarea name="chung_chi_chuyen_mon" cols="40" rows="5" required="true"><?=$row["skill_certificate"]?></textarea></td>
			</tr>
			
			<tr>
				<th>Mô tả khác (kiến - hệ điều hành, database, ...)</th>
				<td><textarea name="mo_ta_khac" cols="40" rows="5" required="true"><?=$row["skill_other"]?></textarea></td>
			</tr>
			
			<tr>
				<th>Kỹ năng mềm:</th>
				<td><textarea name="ky_nang_mem" cols="40" rows="5" required="true"><?=$row["skill_soft_skill"]?></textarea></td>
			</tr>
		</table>

			<hr>
		<h3>3. Những kiến thức, kỹ năng muốn học hỏi ( nêu càng cụ thể càng tốt) </h3>
			<textarea name="ky_nang_muon_hoc" cols="80" rows="5" required="true"><?=$row["kng_wantt_learn"]?></textarea>
			<br>
			<hr>
		<h3>4. Thông tin ĐVTT ( nếu sinh viên đã có địa chỉ thực tập  ) </h3>
			<input type="checkbox" name="has_dvtt" <?php if(strcmp($row["has_internship_company"], "1") == 0) echo "checked";?> > Đã có đơn vị thực tập
			<br>
			
			Tên đầy đủ cơ quan, công ty &nbsp;&nbsp;<input type="text" name="dvtt_congty" value="<?=$row["int_name"]?>">
			
			&nbsp;&nbsp;Địa chỉ <input type="text" name="dvtt_dia_chi" size="43" value="<?=$row["int_address"]?>">
			<br>
			<br>
			Người phụ trách <input type="text" name="dvtt_nguoi_phu_trach" value="<?=$row["int_pic"]?>">
			&nbsp;&nbsp;Điện thoại &nbsp;<input type="tel" name="dvtt_dien_thoai" value="<?=$row["int_phone"]?>">
			&nbsp;Email <input type="email" name="dvtt_email" value="<?=$row["int_email"]?>">
			<br>
			<br>
			Thời gian thực tập
			<br>
			&nbsp;Từ ngày <input type="date" name="dvtt_dfrom" value="<?=$row["int_dfrom"]?>">&nbsp;&nbsp; Đến ngày <input type="date" name="dvtt_dto" value="<?=$row["int_to"]?>">
			<br>
			<br>
		<input type="submit" value=" Cập nhật "/><br/>
	</div>		
<?php }else { ?>
			<h3>1. Thông tin chung</h3>

			Họ tên <input type="text" name="ho_ten" id="ho_ten" required="true">
			&nbsp;Lớp <input type="text" name="lop" required="true">
			&nbsp;&nbsp;Số hiệu sinh viên  <input type="text" name="shsv" required="true">
			<br>
			<br>
			Giới tính<select name="gender">
					  <option value="male">Nam</option>
					  <option value="female">Nữ</option>
					</select>
			
			&nbsp;&nbsp;Địa chỉ <input type="text" name="dia_chi" required="true" size="75">
			<br>
			<hr>
		<h3>2. Kỹ năng</h3>
		<table >
			<tr>
				<th>Kỹ năng tiếng anh </th>

				<td>
					<input type="text" name="ky_nang_tieng_anh" required="true" placeholder="(Trường hợp không có ghi là không có)" size="60">
			
				</td>
			</tr>
			<tr>
				<th>Kỹ năng lập trình</th>
			
				<td>
					<input type="checkbox" name="ki_nang[]" value="c_c_plus_plus">C/C++
					&nbsp;
					<input type="checkbox" name="ki_nang[]" value="java_j2ee">java J2EE
					&nbsp;
					<input type="checkbox" name="ki_nang[]" value="php">PHP
					&nbsp;
					<input type="checkbox" name="ki_nang[]" value="c_obj">C-Objective(iOS)
					&nbsp;
					<input type="checkbox" name="ki_nang[]" value="java_android">Java (Android)
				</td>
			</tr>

			<tr>
				<th>Kỹ năng quản trị hệ thống, quản trị mạng</th>
				<td><textarea name="ky_nang_qtht_gtm" cols="40" rows="5" required="true"></textarea></td>
			</tr>
			
			<tr>
				<th>Các chứng chỉ chuyên môn (IBM, Microsoft, Cisco, Oracle, ...)</th>
				<td><textarea name="chung_chi_chuyen_mon" cols="40" rows="5" required="true"></textarea></td>
			</tr>
			
			<tr>
				<th>Mô tả khác (kiến - hệ điều hành, database, ...)</th>
				<td><textarea name="mo_ta_khac" cols="40" rows="5" required="true"></textarea></td>
			</tr>
			
			<tr>
				<th>Kỹ năng mềm:</th>
				<td><textarea name="ky_nang_mem" cols="40" rows="5" required="true"></textarea></td>
			</tr>
		</table>

			<hr>
		<h3>3. Những kiến thức, kỹ năng muốn học hỏi ( nêu càng cụ thể càng tốt) </h3>
			<textarea name="ky_nang_muon_hoc" cols="80" rows="5" required="true"></textarea>
			<br>
			<hr>
		<h3>4. Thông tin ĐVTT ( nếu sinh viên đã có địa chỉ thực tập  ) </h3>
			<input type="checkbox" name="has_dvtt" > Đã có đơn vị thực tập
			<br>
			
			Tên đầy đủ cơ quan, công ty &nbsp;&nbsp;<input type="text" name="dvtt_congty">
			
			&nbsp;&nbsp;Địa chỉ <input type="text" name="dvtt_dia_chi" size="43">
			<br>
			<br>
			Người phụ trách <input type="text" name="dvtt_nguoi_phu_trach">
			&nbsp;&nbsp;Điện thoại &nbsp;<input type="tel" name="dvtt_dien_thoai">
			&nbsp;Email <input type="email" name="dvtt_email">
			<br>
			<br>
			Thời gian thực tập
			<br>
			&nbsp;Từ ngày <input type="date" name="dvtt_dfrom">&nbsp;&nbsp; Đến ngày <input type="date" name="dvtt_dto">
			<br>
			<br>
		<input type="submit" value=" Đăng ký "/><br/>
		<h3>Viện đào tạo Quốc Tế</h3>
	</div>	
<?php } ?>

		
	
	</form>
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