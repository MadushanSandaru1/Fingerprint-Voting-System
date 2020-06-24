<?php

    date_default_timezone_set('Asia/Colombo');

    session_start();

    require_once("../connection/connection.php");

    if(!isset($_SESSION['inspector_nic'])){
        header("location:../index.php");
    }

    $err = "";

    if(isset($_POST['pwdSubmit'])){
        
        $enc_pwd = sha1($_POST['pwd']);
        
        $get_inspectors = "SELECT * FROM `inspector` WHERE `nic` = '{$_SESSION['inspector_nic']}' AND `password` = '{$enc_pwd}' AND `schedule_id` = {$_SESSION['election_schedule_id']} AND `is_deleted` = 0";
        
        $result_inspectors = mysqli_query($con,$get_inspectors);
        
        if(mysqli_num_rows($result_inspectors)==1) {
            
            header("location:election_end_logout.php");
        
        }
        else{
            $err = "Incorrect Password. Try again.";
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS | Inspector Setting</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="../img/logo.png"/>
        
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        
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
            
            .card {
                background-image: linear-gradient(to right,  rgba(111,44,145,1),rgba(199,1,127,1));
            }
            
            a:hover .card {
                text-decoration: none;
                background-image: linear-gradient(to right,rgba(199,1,127,1), rgba(111,44,145,1));
            }
            
            a:hover {
                text-decoration: none;
            }
            
            input.pwd {
                outline: 0;
                border-width: 0 0 1px;
                border-color: #6f2c91;
            }
            
            .myBtn {
                flex: 1 1 auto;
                padding: 20px;
                text-align: center;
                text-transform: uppercase;
                transition: 0.5s;
                color: white;
                text-shadow: 0px 0px 10px rgba(0,0,0,0.2);
                border-radius: 15px;
                background-image: linear-gradient(to right, #6f2c91, #c7017f);
            }

            .myBtn:hover {
                background-image: linear-gradient(to right, #c7017f, #6f2c91);
                text-decoration: none;
                color: white;
            }
            
            #err {
                color: red;
            }
            
        </style>
    </head>
    
    <body>
        
        <!-- The Modal -->
        <div class="modal" id="endElection">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="inspector_setting.php" method="post" name="setting">
                            <div class="form-group">
                                <input type="password" class="form-control pwd" id="pwd" placeholder="Enter password" name="pwd" required>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary w-50" name="pwdSubmit"><img src="../img/ok.png"></button>
                            </center>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']." - ".date('Y'); ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']." - ".date('Y'); ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']." - ".date('Y'); ?></marquee>
        </nav>
        
        <div class="container p-5">
            
            <div class="row mt-5 d-flex justify-content-around">
                <a href="" class="myBtn col-5" data-toggle="modal" data-target="#endElection"><h4>මැතිවරණය අවසන් කරන්න<br><br>தேர்தலை முடிக்கவும்<br><br>End the election</h4></a>
            </div>
            
            <div class="row mt-5 d-flex justify-content-around">
                <a href="fingerprint_login.php" class="btn btn-primary">Back</a>
            </div>
            
            <div class="row mt-5 d-flex justify-content-around">
                <p id="err"><?php echo $err; ?></p>
            </div>
            
        </div>
    </body>
</html>