<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'db_cie_2017');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

mysqli_query($db, "SET character_set_results=utf8");
mb_language('uni');
mb_internal_encoding('UTF-8');
mysqli_select_db($db, DB_DATABASE);
mysqli_query($db, "set names 'utf8'");

// define role constant
define('ROLE_ADMIN', 'admin');
define('ROLE_STUDENT', 'student');
define('ROLE_BR', 'bussiness_representtatives');
define('ROLE_GUIDE', 'guide');
define('ROLE_LIC', 'lecturer_in_charge');
define('ROLE_SUPERVISOR', 'supervisor');
?>