<?php
include('session.php');
?>
<?php
	$role =  $_SESSION['role'];

	if(strcmp($role, ROLE_ADMIN) == 0){
		
	}else if(strcmp($role, ROLE_STUDENT) == 0){
		header("location:../student/index.php");
	}else if(strcmp($role, ROLE_BR) == 0){
		echo 'br';
	}else if(strcmp($role, ROLE_GUIDE) == 0){
		echo 'Hello guide';
		echo "<h1></h1>";
	    header("Refresh: 2; url=/guide/index.php");
	    echo '<p></p>';
	    echo "<br>";
	    echo '<p>Đợi chút để chuyển tới trang dành cho người quản lý tại doanh nghiệp</p>';

	}else if(strcmp($role, ROLE_LIC) == 0){
		echo 'lic';
	}else if(strcmp($role, ROLE_SUPERVISOR) == 0){
		echo 'super';
	}

?>
<html">

<head>
    <title>Welcome </title>
</head>

<body>
<h2><a href = "logout.php">Sign Out</a></h2>
</body>

</html>