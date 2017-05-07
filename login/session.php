<?php
include('config.php');
session_start();
if (!isset($_SESSION['login_user'])) {
    //header("Location: ../login/login.php");
    echo "<h1></h1>";
    header("Refresh: 3; url=/login/login.php");
    echo '<p>Bạn chưa đăng nhập. Hãy đăng nhập để tiếp tục làm việc</p>';
    echo "<br>";
    echo '<p>Đợi một chút để chuyển tới trang đăng nhập</p>';
    exit();
}

$user_check = $_SESSION['login_user'];

$ses_sql = mysqli_query($db, "select id, username, role_id from users where username = '$user_check' ");

$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

$_SESSION['user_id'] = $row['id'];

// get user role
$role_id = $row['role_id'];
$role_sql = mysqli_query($db, "select role.name from role where id = '$role_id' and active = 1");
$row = mysqli_fetch_array($role_sql, MYSQLI_ASSOC);
$count = mysqli_num_rows($role_sql);

if($count == 1){}
	else{
		echo "<h1></h1>";
	    header("Refresh: 3; url=/login/login.php");
	    echo '<p>Acess denied.</p>';
	    echo "<br>";
	    echo '<p>Đợi một chút để chuyển tới trang đăng nhập</p>';
	    exit();	
	}

$_SESSION['role'] = $row['name'];


?>
