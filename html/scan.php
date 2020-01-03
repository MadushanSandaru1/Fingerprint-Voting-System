<?php

    /* database connection page include */
    require_once('../connection/connection.php');
    
    require_once("time_scheduler.php");

    if(isset($_POST['login'])) {

		/* data for login */
		$code =  mysqli_real_escape_string($con,trim($_POST['code']));
        
        /* login query */
		$login_qurey = "SELECT * FROM `voter` WHERE `is_deleted` = 0 AND `is_died` = 0 AND `fingerprint_R` = '$code' OR  `fingerprint_L` = '$code'";

        /* query execute */
		$result_set = mysqli_query($con,$login_qurey);

        /* query result */
		if (mysqli_num_rows($result_set)==1) {
			$details = mysqli_fetch_assoc($result_set);
            
            /* if user available, user info load to session array */
			$_SESSION = array();
            $_SESSION['nic'] = $details['nic'];
            $_SESSION['divi_id'] = $details['divi_id'];
            $_SESSION['language'] = $details['language'];
            
            /* redirect to dashboard page */
            header("location:ballotPaper.php");
            
		}
        /* if user not available, displayerror msg */
		else{
            /* redirect to dashboard page */
            header("location:try_again.php");
		}
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS</title>
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
            
            .fingerprint {
                color: #6f2c91;
                font-weight: bold;
            }
            
            .setting {
                position: fixed;
                bottom: 5px;
                right: 5px;
            }
        
        </style>
    </head>
    
    <body>
        <?php
                                            
            /*$query = "SELECT es.*, e.`name_si`, e.`name_ta`, e.`name_en` FROM `election_schedule` es,`election` e WHERE es.`id` = {$_SESSION['inspector_schedule_id']} AND es.`type` = e.`id`";

            $result_set = mysqli_query($con,$query);

            if (mysqli_num_rows($result_set) >= 1) {

                $eName = mysqli_fetch_assoc($result_set);
                $_SESSION['election_name_si'] = $eName['name_si'];
                $_SESSION['election_name_ta'] = $eName['name_ta'];
                $_SESSION['election_name_en'] = $eName['name_en'];

            }*/
            $_SESSION['election_name_si'] = $current_elec_name_array['name_si'];
            $_SESSION['election_name_ta'] = $current_elec_name_array['name_ta'];
            $_SESSION['election_name_en'] = $current_elec_name_array['name_en'];

        ?>
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']; ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']; ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']; ?></marquee>
        </nav>
        
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fingerprint mt-5">ඔබගේ ඇඟිලි සලකුණ ඇතුළත් කරන්න</h1>
                    <h1 class="fingerprint mt-4 mb-4">உங்கள் கைரேகையைச் செருகவும்</h1>
                    <h1 class="fingerprint mt-4 mb-5">Insert your fingerprint</h1>
                    <hr>
                    <form action="scan.php" method="post">
                        
                        <img src="../img/fingerprint.png" class="mt-5"><br>

                        <input type="text" name="code" placeholder="Test code" class="mt-3"><br>
                        
                        <input type="submit" class="btn btn-success mt-3" name="login" value="login" style="width:150px">
                    </form>
                </div>
            </div>
        </div>
        
        <!-- The Modal -->
        <div class="modal" id="setting">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="setting.php" method="post" name="setting">
                            <div class="form-group">
                                <input type="password" class="form-control pwd" id="pwd" placeholder="Enter password" name="pwd">
                            </div>
                            <button type="submit" class="btn btn-primary"><img src="../img/ok.png"></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        
    </body>
</html>