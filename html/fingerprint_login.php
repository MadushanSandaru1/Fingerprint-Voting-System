<?php

    date_default_timezone_set('Asia/Colombo');

    session_start();

    require_once("../connection/connection.php");

    if(!isset($_SESSION['inspector_nic'])){
        header("location:../index.php");
    }
    
    require_once("time_scheduler.php");

    $err = "";
    unset($_SESSION['voter_nic']);
    unset($_SESSION['voter_divi_id']);
    unset($_SESSION['voter_language']);
    unset($_SESSION['voter_email']);

    //setting
    if(isset($_POST['pwdSubmit'])){
        
        $enc_pwd = sha1($_POST['pwd']);
        
        $get_inspectors = "SELECT * FROM `inspector` WHERE `nic` = '{$_SESSION['inspector_nic']}' AND `password` = '{$enc_pwd}' AND `schedule_id` = {$_SESSION['election_schedule_id']} AND `is_deleted` = 0";
        
        $result_inspectors = mysqli_query($con,$get_inspectors);
        
        if(mysqli_num_rows($result_inspectors)==1) {
            
            header("location:inspector_setting.php");
        
        }
        else{
            //$err = "Incorrect Password. Try again.";
        }
    }

    //temporary
    if(isset($_POST['login'])) {

		//data for login
		$voter_finger_pin =  strtoupper(mysqli_real_escape_string($con,trim($_POST['voter_finger_pin'])));
        
        //login query
        $login_qurey = "SELECT * FROM `voter` WHERE `is_died` = 0 AND `is_deleted` = 0 AND (`fingerprint_R` = '{$voter_finger_pin}' OR `fingerprint_L` = '{$voter_finger_pin}')";
        
        //query execute
		$login_qurey_result = mysqli_query($con,$login_qurey);
        
        $voter_nic = mysqli_fetch_assoc($login_qurey_result)['nic'];

        $check_user_is_voted = "SELECT * FROM `participate` WHERE  `schedule_id` = {$_SESSION['election_schedule_id']} AND `voter_nic`= '{$voter_nic}'";
        $login_qurey = "SELECT * FROM `voter` WHERE `is_died` = 0 AND `is_deleted` = 0 AND `nic`= '{$voter_nic}'";
        
        //query execute
        $check_user_is_voted_result = mysqli_query($con,$check_user_is_voted);
        $login_qurey_result = mysqli_query($con,$login_qurey);

        if (mysqli_num_rows($check_user_is_voted_result) == 0) {
            
            //query result
            if (mysqli_num_rows($login_qurey_result) == 1) {
                
                $voter_details = mysqli_fetch_assoc($login_qurey_result);
                
                //age count
                $b_day=date_create($voter_details['b_day']);
                $today=date_create(date("Y-m-d"));
                $diff=date_diff($b_day,$today);
                $voter_age = $diff->format("%Y");
                
                //The administrator cannot use vote
                if($voter_details['role'] == "ADMIN") {
                    //redirect to error page
                    header("location:admin_vote_error.php");
                }
                //People under the age of 18 cannot use vote
                else if($voter_age < 18) {
                    //redirect to error page
                    header("location:age_vote_error.php");
                }
                else {
                    
                    //if user available, user info load to session array
                    $_SESSION['voter_nic'] = $voter_details['nic'];
                    $_SESSION['voter_divi_id'] = $voter_details['divi_id'];
                    $_SESSION['voter_language'] = $voter_details['language'];
                    $_SESSION['voter_email'] = $voter_details['email'];

                    // redirect to dashboard page
                    header("location:ballot_paper.php");
                    
                }
            
            }
            /* if user not available, displayerror msg */
            else{
                /* redirect to dashboard page */
               header("location:voter_not_exists_error.php");
            }

        }else{
            header("location:already_voted_error.php");
        }
        
    }
    //temporary

?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS | Fingerprint Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="../img/logo.png"/>
        
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        
        <script type="text/javascript">
	
            $(document).ready( function(){
                $('#time').load('time.php');
                refresh();
            });

            function refresh()
            {
                setTimeout( function() {
                  $('#time').load('time.php');
                  refresh();
                }, 1000);
            }

        </script>
        
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
            
            .setting {
                position: fixed;
                bottom: 5px;
                right: 5px;
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
        <div class="modal" id="inspectorSetting">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="fingerprint_login.php" method="post" name="setting">
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
        
        <div class="container-fluid">
            <div class="row d-flex justify-content-between px-5">

                <div id="time" class="d-flex flex-row">
                </div>

                <div id="setting" class="d-flex flex-row">
                    <a href=""  data-toggle="modal" data-target="#inspectorSetting"><img src="../img/settings.png"></a>
                </div>

            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fingerprint mt-5">ඔබගේ ඇඟිලි සලකුණ ඇතුළත් කරන්න</h1>
                    <h1 class="fingerprint mt-4 mb-4">உங்கள் கைரேகையைச் செருகவும்</h1>
                    <h1 class="fingerprint mt-4 mb-5">Insert your fingerprint</h1>
                    <hr>
                    
                    <img src="../img/fp.gif" class="mt-1" height="160px"><br>
                    
                    <!-- temporary -->
                    <form action="fingerprint_login.php" method="post">
                        
                        <input type="text" name="voter_finger_pin" placeholder="Finger pin" class="mt-2"  autocomplete="off" required><br>
                        
                        <input type="submit" class="btn btn-success mt-3" name="login" value="login" style="width:150px">
                        
                    </form>
                    <!-- temporary -->
                    
                    <p class="mt-4"><a href="e_card_login.php" class="btn btn-primary">e කාඩ්පත් පිවිසුම | e அட்டை அணுகல் | e-Card Access</a></p>

                </div>
            </div>
        </div>        
        
    </body>
</html>