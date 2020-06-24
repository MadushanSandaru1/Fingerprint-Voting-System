<?php

	require_once("../connection/connection.php") ;

    if(!isset($_SESSION['inspector_nic'])){
        header("location:../index.php");
    }

	// Ideitify current date
	date_default_timezone_set("Asia/Colombo");
	$curent_datetime = date('Y-m-d H:i:s');

	//Ideintfy availabel election
	$get_current_election = "SELECT `date_to` FROM `election_schedule` WHERE  '{$curent_datetime}' between `date_from` and `date_to` and `is_deleted` = 0";
	$get_current_election_result = mysqli_query($con,$get_current_election);

	if(mysqli_num_rows($get_current_election_result)==1){

		//election type and expire time
		$elec = mysqli_fetch_assoc($get_current_election_result);

		//Automaticaly logout went election time over

		$d1 = new DateTime($curent_datetime, new DateTimeZone("Asia/Colombo"));
		$t1 = $d1->getTimestamp();

		$d2 = new DateTime($elec['date_to'], new DateTimeZone("Asia/Colombo"));
		$t2 = $d2->getTimestamp();

		$sec = $t2 - $t1;
		
		header("Refresh:{$sec}; url=election_end_logout.php");

	}

?>
