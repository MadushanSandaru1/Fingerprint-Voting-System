<?php

    date_default_timezone_set('Asia/Colombo');
     
    session_start();
    require_once("../../connection/connection.php");
    require_once("../../email/email_test.php");

    $flag = '';
    unset($_SESSION['recoveryNic']);
    unset($_SESSION['recoveryEmail']);
    unset($_SESSION['recoveryRole']);
    unset($_SESSION['recoveryCode']);

?>

<?php

    function recoveryCodeSendByEmail($email, $acc_pwd){
        
        $heading = "FVS | Election Commission of Sri Lanka";
        $message = "<h3>FVS Account Password Recovery Code</h3><br>Dear Sir/Madam,<br><p>Your account password recovery code: <b>".$acc_pwd."</b></p>Thank You!<br><pre>Election Commission,<br>Election Secretariat,<br>Sarana Mawatha,<br>Rajagiriya,<br>Sri Lanka - 10107</pre>";

        require '../../email/PHPMailerAutoload.php';
        $credential = include('../../email/credential.php');      //credentials import

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
            $flag = "Recovery code could not be sent";
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            header("location:admin_passwordRecoveryCodeCheck.php");
            //echo 'Successfull.';
        }
    }

?>

<?php

	if(isset($_POST['recovery'])) {

		/* data for recovery */
		$upper_nic = strtoupper(mysqli_real_escape_string($con,trim($_POST['usr_nic'])));
        
        //email
        $email_query = "SELECT `email`, `role` FROM `voter` WHERE `nic` = '{$upper_nic}' AND `role` != 'voter' AND `is_deleted` = 0 LIMIT 1";

        $take_email = mysqli_query($con,$email_query);
        
        $take_email_result = mysqli_fetch_assoc($take_email);

        if($take_email) {

            if(mysqli_num_rows($take_email)==1) {
                $_SESSION['recoveryNic'] = $upper_nic;
                $_SESSION['recoveryEmail'] = $take_email_result['email'];
                $_SESSION['recoveryRole'] = $take_email_result['role'];

                $_SESSION['recoveryCode'] = rand(100000,999999);
                
                recoveryCodeSendByEmail($_SESSION['recoveryEmail'], $_SESSION['recoveryCode']);
            
            } else {
                $flag = "User does not exist";
            }

        }

	}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Password Recovery | FVS</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="../../img/logo.png"/>
        
        <!-- bootstrap jquary -->
        <script src="../../js/bootstrap.min.js"></script>
        
        <!-- bootstrap css -->
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
    
        <!-- font awesome icon -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0-11/css/all.css" rel="stylesheet">
        
        <!-- popper for tooltip -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        
        
        <!-- jquary -->        
        <script src="../../js/jquery.min.js"></script>
        
        <!-- css -->
        <link href="../../css/adminLogin.css" rel="stylesheet">
        
        <!-- google font -->
        <link href='https://fonts.googleapis.com/css?family=Baloo Chettan' rel='stylesheet'>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="pt-5 col-md-6 login-area text-center">
                    <div class="login-header">
                        <img src="../../img/logo.png" alt="logo" class="logo">
                        <p class="title">Password Recovery</p>
                    </div>
                    <div class="login-content">
                        <form action="admin_forgotPassword.php" method="post">
                            <div class="form-group">
                                <input type="text" class="input-field" name="usr_nic" placeholder="NIC Number" required id="nic">
                            </div>
                            <button type="submit" class="btn btn-outline-primary" name="recovery">Recovery    <i class="fab fa-rev"></i></button>
                        </form>

                        <div class="login-bottom-links">
                            <a href="../../admin_login.php" class="link">Administration Login</a>
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
                    <img src="../../img/ecslLogo.png" id="ecslLogo">
                </div>
            </div>
        </div>
    </body>
</html>
