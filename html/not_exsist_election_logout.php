<!DOCTYPE html>
<?php

    //clear sessions
    session_start();
    $_SESSION = array();

    session_unset();



?>
<html>
    <head>
        <title>FVS</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- refresh -->
        <meta http-equiv="refresh" content="3;url=../index.php" />
        
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
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | ශ්‍රී ලංකා මැතිවරණ කොමිෂන් සභාව &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | இலங்கை தேர்தல் ஆணையம்  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | Election Commission of Sri Lanka</marquee>
        </nav>
        <div class="container">
            <div class="row rowCenter align-items-center">
                <div class="col-12 text-center mt-5">
                    <h1 class="fingerprint mt-5">මෙම අවස්ථාවේදී මැතිවරණයක් නොමැත</h1>
                    <h1 class="fingerprint mt-4 mb-4">இந்த நேரத்தில் தேர்தல் இல்லை</h1>
                    <h1 class="fingerprint mt-4 mb-5">There is no election at this time</h1>
                    <p class="mt-4"><a href="../index.php">Back to Home</a></p>
                </div>
            </div>
        </div>
    </body>
</html>