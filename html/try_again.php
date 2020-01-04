<?php
    session_start();

    $tmp_inspector_schedule_id = $_SESSION['inspector_schedule_id'];
    $tmp_inspector_nic = $_SESSION['inspector_nic'];
    $tmp_election_name_si =  $_SESSION['election_name_si'];
    $tmp_election_name_ta =  $_SESSION['election_name_ta'];
    $tmp_election_name_en =  $_SESSION['election_name_en'];

    $_SESSION = array();

    session_unset();

    $_SESSION['inspector_schedule_id'] = $tmp_inspector_schedule_id;
    $_SESSION['inspector_nic'] = $tmp_inspector_nic;
    $_SESSION['election_name_si'] = $tmp_election_name_si;
    $_SESSION['election_name_ta'] = $tmp_election_name_ta;
    $_SESSION['election_name_en'] = $tmp_election_name_en;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- refresh -->
        <meta http-equiv="refresh" content="3;url=scan.php" />
        
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
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']; ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']; ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']; ?></marquee>
        </nav>
        <div class="container">
            <div class="row rowCenter align-items-center">
                <div class="col-12 text-center mt-5">
                    <h1 class="fingerprint mt-5">කරුණාකර නැවත උත්සාහ කරන්න</h1>
                    <h1 class="fingerprint mt-4 mb-4">மீண்டும் முயற்சி செய்</h1>
                    <h1 class="fingerprint mt-4 mb-5">Please try again</h1>
                </div>
            </div>
        </div>
    </body>
</html>