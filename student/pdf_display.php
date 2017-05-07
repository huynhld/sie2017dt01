<?php
	include('/login/session.php');
	$file=$_SESSION['pdf_viewed_file'];
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="File.pdf"');
	@readfile($file);

?>
