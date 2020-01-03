<?php
    /* start the session */
	session_start();

    /* database connection page include */
    require_once('../connection/connection.php');

?>

<?php 

	$flag = '';

	if(isset($_POST['login'])) {

		/* data for login */
		$username =  mysqli_real_escape_string($con,trim($_POST['nic']));
		$pwd = mysqli_real_escape_string($con,trim($_POST['password']));
        
        /* password encrypt */
		$h_pwd = sha1($pwd);
        
        /* login query */
		$login_query = "SELECT * FROM `voter` WHERE `nic` = '{$username}' AND `role` <> 'voter'";

        /* query execute */
		$result_set = mysqli_query($con,$login_query);

        /* query result */
		if (mysqli_num_rows($result_set)==1) {
			$details = mysqli_fetch_assoc($result_set);
            
            $_SESSION['nic'] = $details['nic'];
            $_SESSION['name'] = $details['name'];
            $_SESSION['role'] = $details['role'];
            $_SESSION['name'] = $details['name'];
            $_SESSION['contact'] = $details['contact'];
            $_SESSION['b_day'] = $details['b_day'];
            $_SESSION['gender'] = $details['gender'];
            
            if($_SESSION['role']=='admin'){
                $query = "SELECT * FROM `admin` WHERE `nic` = '{$_SESSION['nic']}' AND `password` = '{$h_pwd}' LIMIT 1";
            } else if($_SESSION['role']=='Assistant Election Officer'){
                $query = "SELECT * FROM `assistant_election_officer` WHERE `nic` = '{$_SESSION['nic']}' AND `password` = '{$pwd}' LIMIT 1";
            } else if($_SESSION['role']=='Division Officer'){
                $query = "SELECT * FROM `division_officer` WHERE `nic` = '{$_SESSION['nic']}' AND `password` = '{$pwd}' LIMIT 1";
            }
            
            $result_set = mysqli_query($con,$query);
            $user_details = mysqli_fetch_assoc($result_set);
            /* if user available, user info load to session array */
            
            /* redirect to dashboard page */
            header("location:admin_dashboard.php");
            
		}
        /* if user not available, displayerror msg */
		else{
			$flag = "Incorrect nic number or password.";
		}

	}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin Login | FVS</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="../img/logo.png"/>
        
        <!-- bootstrap jquary -->
        <script src="../js/bootstrap.min.js"></script>
        
        <!-- bootstrap css -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    
        <!-- font awesome icon -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-11/css/all.css" rel="stylesheet">
        
        <!-- popper for tooltip -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        
        
        <!-- jquary -->        
        <script src="../js/jquery.min.js"></script>
        
        <!-- css -->
        <link href="../css/adminLogin.css" rel="stylesheet">
        
        <!-- google font -->
        <link href='https://fonts.googleapis.com/css?family=Baloo Chettan' rel='stylesheet'>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class=" col-md-6 login-area text-center">
                    <div class="login-header">
                        <img src="../img/logo.png" alt="logo" class="logo">
                        <p class="title">Fingerprint Voting System</p>
                    </div>
                    <div class="login-content">
                        <form action="admin_login.php" method="post">
                            <div class="form-group">
                                <input type="text" class="input-field" name="nic" placeholder="NIC Number" required id="nic">
                            </div>
                            <div class="form-group">
                                <input type="password" class="input-field" name="password" placeholder="Password" required autocomplete="off" id = "password">
                            </div>
                            <button type="submit" class="btn btn-outline-primary" name="login">Login    <i class="fa fa-lock"></i></button>
                        </form>

                        <div class="login-bottom-links">
                            <a href="#" target="_blank" class="link">Forgot Your Password?</a>
                        </div>
                        
                        <div class="login-bottom-links">
                            <a href="https://elections.gov.lk/web/en/" target="_blank" class="link">Election Commission of Sri Lanka</a>
                        </div>
                        <br/>
                        <p>
                            <?php
                                /* display error msg */
                                if($flag!=''){
                                    echo "<p style='color:#f00; margin-bottom:10px'>{$flag}</P>";		
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="image-area col-md-6">
                    <img src="../img/ecslLogo.png" id="ecslLogo">
                </div>
            </div>
        </div>
    </body>
</html>
