<?php
    /* start the session */
	session_start();

    /* empty the session array */
	$_SESSION  = array();
   
    /* empty the cookies */
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name() , '', time()-86400, '/');
	}

    /* stop the session */
	session_destroy();

    /* redirect to login page */
	header("location:../../admin_login.php");
?>