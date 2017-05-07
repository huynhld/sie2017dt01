<?php
header("Cache-Control: private, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Fri, 4 Jun 2010 12:00:00 GMT");
include("config.php");
session_start();
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $myusername = mysqli_real_escape_string($db, $_POST['username']);
    $mypassword = mysqli_real_escape_string($db, $_POST['password']);

    $sql = "SELECT id, active, role_id  FROM users WHERE username = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $id = $row['id'];
    $active = $row['active'];
    $role_id = $row['role_id'];
    
    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if ($count == 1 and $active == 1) {
//        session_register("myusername");
        $_SESSION['login_user'] = $myusername;
        $_SESSION['id'] = $id;
        header("location: welcome.php");
    } else {
        if($active == 0){
            $error = "Access denied. Contact Admin for more information";
        }else
            $error = "Your Login Name or Password is invalid";
        
    }
}
?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Đăng nhập</title>
<style>
form {
    border: 3px solid #f1f1f1;
}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}



.container {
  margin:auto;
    padding: 100px;

}
.bound{
  width:50%;
  margin:auto;
}

</style>
</head>
<body>

<h2 style="text-align:center;">Đăng nhập</h2>

<form action="" method="post">

  <div class="container" >
  <div class="bound">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit">Login</button>

  </div>
  </div>

  
</form>

</body>
</html>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="../js/login.js"></script>

</body>
</html>
