<?php

    date_default_timezone_set('Asia/Colombo');

    session_start();

    require_once("../connection/connection.php");

    if(!isset($_SESSION['inspector_nic'])){
        header("location:../index.php");
    }

?>

<?php

    //election ended or not
    $status = false;

    $get_inspectors = "SELECT `date_to` FROM `election_schedule` WHERE `is_deleted` = 0 AND '".date("Y-m-d H:i:s")."' BETWEEN `date_from` AND `date_to`";
        
    $result_inspectors = mysqli_query($con,$get_inspectors);

    if (mysqli_num_rows($result_inspectors)==1) {
        $status = true;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS | Already Voted Error</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- refresh -->
        <?php
            if ($status) {
        ?>
        <meta http-equiv="refresh" content="3;url=fingerprint_login.php" />
        <?php
            } else {
        ?>
        <meta http-equiv="refresh" content="3;url=election_end_logout.php" />
        <?php
            }
        ?>
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="../img/logo.png"/>
        
        <!-- bootstrap css -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        
        <!-- bootstrap javascript -->
        <script src="../js/bootstrap.min.js"></script>
        
        <!-- javascript -->
        <script src="../js/jquery.min.js"></script>
        
        <style>
            body {
                background-image: url("../img/back.jpg");
                background-position: top;
                background-repeat: no-repeat;
                background-size: cover;
            }
            
            nav {
                background-image: linear-gradient(to right,  rgba(111,44,145,1),rgba(199,1,127,1));
            }
            
            .fingerprint {
                color: #6f2c91;
                font-weight: bold;
            }
            
            .rowCenter {
                height: 80vh;
            }
            
        </style>
    </head>
    
    <body>
        
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']." - ".date('Y'); ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']." - ".date('Y'); ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']." - ".date('Y'); ?></marquee>
        </nav>
        
        <div class="container">
            <div class="row rowCenter align-items-center">
                <div class="col-12 text-center mt-5">
                    <h1 class="fingerprint mt-5">ඔබ දැනටමත් මෙම ඡන්ද විමසීමේදී ඡන්දය ප්‍රකාශ කර ඇත</h1>
                    <h1 class="fingerprint mt-4 mb-4">இந்த வாக்கெடுப்பில் நீங்கள் ஏற்கனவே வாக்களித்தீர்கள்</h1>
                    <h1 class="fingerprint mt-4 mb-5">you already voted on this poll</h1>
                </div>
            </div>
        </div>
    </body>
</html>