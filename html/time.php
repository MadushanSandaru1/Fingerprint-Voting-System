<?php

    date_default_timezone_set('Asia/Colombo');

    session_start();

    require_once("../connection/connection.php");

    if(!isset($_SESSION['inspector_nic'])){
        header("location:../index.php");
    }

    $get_inspectors = "SELECT `date_to` FROM `election_schedule` WHERE `is_deleted` = 0 AND '".date("Y-m-d H:i:s")."' BETWEEN `date_from` AND `date_to`";
        
    $result_inspectors = mysqli_query($con,$get_inspectors);

    if (mysqli_num_rows($result_inspectors)==1) {

        $endTime = mysqli_fetch_assoc($result_inspectors)['date_to'];
        
        $timeNow = new DateTime();
        $endTime = new DateTime($endTime);
        $interval = $timeNow->diff($endTime);
        $timeToEnd = $interval->format('%a days %H:%I:%S');

        echo "Time to end:&nbsp;<h5>".$timeToEnd."</h5>";

    } else {
        header("location:election_end_logout.php");
    }

?>