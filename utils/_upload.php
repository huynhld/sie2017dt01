<?php
    include('../login/session.php');
?> 

<?php
$target_dir = "../uploads/";

$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx" ) {
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
    $user_id = $_SESSION['user_id'];
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $sql = "INSERT INTO student_cv (s_id, datetime, location) VALUES ('$user_id', '$unique_value', '$target_file')";
        $result = mysqli_query($db, $sql);

        header('Location: ../student/index.php');
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>