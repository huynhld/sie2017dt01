<?php
	include('../login/session.php');
	$file=$_SESSION['pdf_viewed_file'];

	if (isset($_GET['type'])) {
    	$router_value = $_GET['type'];
    	if(strcmp($router_value, 'mid_term_rpt') == 0){
    		$file = $_SESSION['mid_term_rpt'];
    	}
    	if(strcmp($router_value, 'final_term_rpt') == 0){
    		$file = $_SESSION['final_term_rpt'];
    	}
    }	
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="CV.pdf"');
	@readfile($file);

?>