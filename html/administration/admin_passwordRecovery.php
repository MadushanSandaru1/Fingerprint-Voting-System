<?php

    date_default_timezone_set('Asia/Colombo');
     
    session_start();
    require_once("../../connection/connection.php");
    require_once("../../email/email_test.php");

    $flag = '';

?>

<?php

    function newPasswordSendByEmail($email, $acc_pwd){
        
        $heading = "FVS | Election Commission of Sri Lanka";
        $message = "<h3>FVS Account Password</h3><br>Dear Sir/Madam,<br><p>Your account password: <b>".$acc_pwd."</b></p>Thank You!<br><pre>Election Commission,<br>Election Secretariat,<br>Sarana Mawatha,<br>Rajagiriya,<br>Sri Lanka - 10107</pre>";

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
            $flag = "Email could not be sent";
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            
            unset($_SESSION['recoveryNic']);
            unset($_SESSION['recoveryEmail']);
            unset($_SESSION['recoveryRole']);
            unset($_SESSION['recoveryCode']);
            
            header("location:../../admin_login.php");
            //echo 'Successfull.';
        }
    }

?>

<?php

	if(isset($_POST['recovery'])) {

		/* data for recovery */
		$new_pwd = strtoupper(mysqli_real_escape_string($con,trim($_POST['new_pwd'])));
        $h_pwd = sha1($new_pwd);
        
        if($_SESSION['recoveryRole']=='ADMIN'){
            $role_table = 'admin';
        }else if($_SESSION['recoveryRole']=='AEO'){
            $role_table = 'assistant_election_officer';
        }else if($_SESSION['recoveryRole']=='DO'){
            $role_table = 'division_officer';
        }
        
        $change_pwd_query = "UPDATE `{$role_table}` SET `password` = '{$h_pwd}' WHERE `nic` = '{$_SESSION['recoveryNic']}'";

        $change_pwd_query_result = mysqli_query($con,$change_pwd_query);

        if ($change_pwd_query_result) {

            newPasswordSendByEmail($_SESSION['recoveryEmail'], $new_pwd);

        } else {
            $flag = "Password could not be changed.";
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
        
        <script>
            $(document).ready(function(){
                $("#repwd").keyup(function(){
                    if ($("#pwd").val() != $("#repwd").val()) {
                        $("#msg").html("Password do not match").css("color","red");
                        $("#recoveryBtn").attr("disabled", true);
                    }else{
                        $("#msg").html("Password matched").css("color","green");
                        $("#recoveryBtn").removeAttr("disabled");
                    }
                });
            });
        </script>

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
                        <form action="admin_passwordRecovery.php" method="post">
                            <div class="form-group">
                                <input type="password" class="input-field" name="new_pwd" placeholder="New Password" required autocomplete="off" id = "pwd">
                            </div>
                            <div class="form-group">
                                <input type="password" class="input-field" name="confirm_pwd" placeholder="Confirm Password" required autocomplete="off" id = "repwd">
                            </div>
                            
                            <div id="msg"></div>
                            
                            <button type="submit" class="btn btn-outline-primary" name="recovery" id="recoveryBtn">Change Password    <i class="fas fa-key"></i></button>
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
