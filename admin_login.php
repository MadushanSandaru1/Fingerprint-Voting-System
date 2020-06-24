<?php

    date_default_timezone_set('Asia/Colombo');
     
    session_start();
    require_once("connection/connection.php");
    require_once("email/email_test.php");

    $flag = '';

	if(isset($_POST['login'])) {

		/* data for login */
		$upper_nic = strtoupper(mysqli_real_escape_string($con,trim($_POST['usr_nic'])));
		$enc_pwd = sha1(mysqli_real_escape_string($con,trim($_POST['usr_pwd'])));
        
        /* login query */
		$login_query = "SELECT * FROM `voter` WHERE `nic` = '{$upper_nic}' AND `role` <> 'voter' AND `is_disabled` = 0 AND `is_died` = 0 AND `is_deleted` = 0";

        /* query execute */
		$login_query_result_set = mysqli_query($con,$login_query);

        /* query result */
		if (mysqli_num_rows($login_query_result_set)==1) {
			$login_query_details = mysqli_fetch_assoc($login_query_result_set);
            
            $_SESSION['administration_name'] = $login_query_details['name'];
            $_SESSION['administration_role'] = $login_query_details['role'];
            $_SESSION['administration_contact'] = $login_query_details['contact'];
            $_SESSION['administration_email'] = $login_query_details['email'];
            $_SESSION['administration_b_day'] = $login_query_details['b_day'];
            
            if($_SESSION['administration_role']=='ADMIN'){
                $login_query_by_role = "SELECT * FROM `admin` WHERE `nic` = '{$upper_nic}' AND `password` = '{$enc_pwd}' LIMIT 1";
            } else if($_SESSION['administration_role']=='AEO'){
                $login_query_by_role = "SELECT * FROM `assistant_election_officer` WHERE `nic` = '{$upper_nic}' AND `password` = '{$enc_pwd}' LIMIT 1";
            } else if($_SESSION['administration_role']=='DO'){
                $login_query_by_role = "SELECT * FROM `division_officer` WHERE `nic` = '{$upper_nic}' AND `password` = '{$enc_pwd}' LIMIT 1";
            }
            
            $login_query_by_role_result_set = mysqli_query($con,$login_query_by_role);
            
            if (mysqli_num_rows($login_query_by_role_result_set)==1) {
                
                if($_SESSION['administration_role']=='AEO'){
                    $_SESSION['administration_working_at'] = mysqli_fetch_assoc($login_query_by_role_result_set)['dist_id'];
                }
                else if($_SESSION['administration_role']=='DO'){
                    $_SESSION['administration_working_at'] = mysqli_fetch_assoc($login_query_by_role_result_set)['divi_id'];
                }
                
                $_SESSION['administration_nic'] = $upper_nic;
                
                /* redirect to dashboard page */
                header("location:html/administration/admin_dashboard.php");
                
            }
            else{
                $flag = "Incorrect password.";
            }
            
		}
        /* if user not available, displayerror msg */
		else{
			$flag = "User does not exist";
		}

	}

?>

<?php

	/*if(isset($_POST['forgotPwd'])){

		$email = $_POST['email'];
		$heading = $_POST['heading'];
		$message = $_POST['message'];
        
        require 'email/PHPMailerAutoload.php';
        $credential = include('email/credential.php');      //credentials import
        
        $mail = new PHPMailer;
        $mail->isSMTP();                                    // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = $credential['user'];              // SMTP username
        $mail->Password = $credential['pass'];              // SMTP password
        $mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                  // TCP port to connect to
        $mail->setFrom($email);
        $mail->addAddress($email);                          // Name is optional

        $mail->addReplyTo('hello');
        
        $mail->isHTML(true);                                    // Set email format to HTML
        
        $mail->Subject = $heading;
        $mail->Body    = $message;
        $mail->AltBody = 'If you see this mail. please reload the page.';
        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo "<script>alert('send your Email')</script>";
        }
    }*/

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Administration Login | FVS</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="img/logo.png"/>
        
        <!-- bootstrap jquary -->
        <script src="js/bootstrap.min.js"></script>
        
        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
    
        <!-- font awesome icon -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-11/css/all.css" rel="stylesheet">
        
        <!-- popper for tooltip -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        
        
        <!-- jquary -->        
        <script src="js/jquery.min.js"></script>
        
        <!-- css -->
        <link href="css/adminLogin.css" rel="stylesheet">
        
        <!-- google font -->
        <link href='https://fonts.googleapis.com/css?family=Baloo Chettan' rel='stylesheet'>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class=" col-md-6 login-area text-center">
                    <div class="login-header">
                        <img src="img/logo.png" alt="logo" class="logo">
                        <p class="title">Fingerprint Voting System</p>
                    </div>
                    <div class="login-content">
                        <form action="admin_login.php" method="post">
                            <div class="form-group">
                                <input type="text" class="input-field" name="usr_nic" placeholder="NIC Number" required id="nic">
                            </div>
                            <div class="form-group">
                                <input type="password" class="input-field" name="usr_pwd" placeholder="Password" required autocomplete="off" id = "password">
                            </div>
                            <button type="submit" class="btn btn-outline-primary" name="login">Login    <i class="fa fa-lock"></i></button>
                        </form>

                        <div class="login-bottom-links">
                            <a href="html/administration/admin_forgotPassword.php" class="link">Forgot Your Password?</a>
                        </div>
                        
                        <div class="login-bottom-links">
                            <a href="http://www.slelections.gov.lk/" target="_blank" class="link">Election Commission of Sri Lanka</a>
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
                    <img src="img/ecslLogo.png" id="ecslLogo">
                </div>
            </div>
        </div>
    </body>
</html>
