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

$upload_status = '';
// Kiểm tra CV đã được up lên chưa.
$_SESSION['pdf_viewed_file'] = '';
$user_id = $_SESSION['user_id'];
$ses_sql = mysqli_query($db, "select location from student_cv where s_id = '$user_id' order by datetime desc limit 1");
$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
$_SESSION['pdf_viewed_file'] = $row['location'];
echo $_SESSION['pdf_viewed_file'] ;
//return;


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
	        $sql = "INSERT INTO student_cv (s_id, datetime, location) VALUES ('$user_id', '$unique_value', '$target_file')";
	        $result = mysqli_query($db, $sql);

	        $upload_status = "Upload file thành công";
	        
	        header("Refresh: 3; url=/student/update_cv.php");
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
	<meta charset="utf-8">
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
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
	<div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $upload_status; ?></div>
	<a href="/student/index.php">Quay lại</a>
	<br/>
    	Upload CV của bạn
    <br/>
    <input type="file" name="fileToUpload" id="fileToUpload" accept = ".pdf" >
    <br/>
    <input type="submit" value="Upload File" name="submit">

    <br/>
    <a href="/utils/pdf_display.php">Hiển thị CV đã tải lên</a>
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