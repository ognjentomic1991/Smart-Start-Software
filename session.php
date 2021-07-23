<?php 
	// ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
	session_start();
	function lang($a, $b){
		if($_SESSION['s_lang']=="gr"){ echo $a; 	}
		else if($_SESSION['s_lang']=="en"){ echo $b; }
	}
	if(!isset($_SESSION['s_lang'])){ $_SESSION['s_lang']="gr"; }
	if(isset($_GET['lang'])){
		if($_GET['lang'] == "gr" || $_GET['lang'] == "en"){ $_SESSION['s_lang']=$_GET['lang']; }
		else{ return; }
	}
	if(!isset($_SESSION['first_run'])){ 	$_SESSION['first_run'] = 1;}

	for($i = 1; $i >= 5; $i++){
		if(!isset($_SESSION['contact_round_'.$i])){ $_SESSION['contact_round_'.$i] = rand(10000000, 99999999); }
	}

	if(!isset($_SESSION['user_id'])){$_SESSION['user_id'] = NULL;}
	if(!isset($_SESSION['gdpr'])){$_SESSION['gdpr'] = 0;}

	if(!isset($_SESSION['order_by_default'])){$_SESSION['order_by_default']="date";}
	if(isset($_GET['order_by'])){$_SESSION['order_by_default']=$_GET['order_by'];}
?>

