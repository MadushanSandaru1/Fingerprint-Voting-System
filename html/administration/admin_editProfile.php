<?php

    date_default_timezone_set('Asia/Colombo');
     
    session_start();

    /* database connection page include */
    require_once('../../connection/connection.php');

    /* if session is not set, redirect to login page */
    if(!isset($_SESSION['administration_nic'])) {
        header("location:../../admin_login.php");
	}

    $altScs = 'none';
    $altReq = 'none';

    $err = '';
    $errPositionChange = '';

?>

<?php

    function passwordSendByEmail($email, $acc_pwd){
        
        $heading = "FVS | Election Commission of Sri Lanka";
        $message = "<h3>FVS Account Password</h3><br>Dear Sir/Madam,<br><p>Your account password : <b>".$acc_pwd."</b></p>Thank You!<br><pre>Election Commission,<br>Election Secretariat,<br>Sarana Mawatha,<br>Rajagiriya,<br>Sri Lanka - 10107</pre>";

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
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            //echo 'Successfull.';
        }
    }

?>

<?php

	if(isset($_POST['updatePro'])) {

        $contact = trim($_POST['contact']);
        
        $email = trim($_POST['email']);
        
        $query = "UPDATE `voter` SET `contact` = '{$contact}', `email`='{$email}' WHERE `nic` = '{$_SESSION['administration_nic']}'";

        $result = mysqli_query($con,$query);

        if ($result) {

            $altScs = 'block';
            $altReq = 'none';
            
            $_SESSION['administration_contact'] = $contact;
            $_SESSION['administration_email'] = $email;

        }
        else{
            $altScs = 'none';
            $altReq = 'block';
        }

	}

    if(isset($_POST['updatePwd'])) {
        
        if($_SESSION['administration_role']=='ADMIN'){
            $role_table = 'admin';
        }else if($_SESSION['administration_role']=='AEO'){
            $role_table = 'assistant_election_officer';
        }else if($_SESSION['administration_role']=='DO'){
            $role_table = 'division_officer';
        }
        
        $curpwd = sha1(trim($_POST['curpwd']));
        
        $n_pwd = trim($_POST['pwd']);
        $newpwd = sha1($n_pwd);
        
        $current_pwd_query = "SELECT * FROM `{$role_table}` WHERE `nic` = '{$_SESSION['administration_nic']}' AND `password` = '{$curpwd}'";
        
        $current_pwd_query_result_set = mysqli_query($con,$current_pwd_query);

        /* query result */
		if (mysqli_num_rows($current_pwd_query_result_set)==1) {
            $change_pwd_query = "UPDATE `{$role_table}` SET `password` = '{$newpwd}' WHERE `nic` = '{$_SESSION['administration_nic']}'";

            $change_pwd_query_result = mysqli_query($con,$change_pwd_query);

            if ($change_pwd_query_result) {
                
                //email
                $email_query = "SELECT `email` FROM `voter` WHERE `nic` = '{$_SESSION['administration_nic']}' LIMIT 1";

                $take_email = mysqli_query($con,$email_query);

                if($take_email) {

                    if(mysqli_num_rows($take_email)==1) {
                        $email = mysqli_fetch_assoc($take_email)['email'];

                        passwordSendByEmail($email, $n_pwd);
                    }

                }

                $altScs = 'block';
                $altReq = 'none';

            }
            else{
                $altScs = 'none';
                $altReq = 'block';
            }
        }
        else{
            $err = 'Current password is wrong.';
        }
    }

    if(isset($_POST['updateUserPosition'])) {
        
        $newUserNic = trim($_POST['newUserNic']);
        
        $currentUserPwd = sha1(trim($_POST['currentUserPwd']));
        
        if($_SESSION['administration_role']=='ADMIN'){
            $current_pwd_query = "SELECT * FROM `admin` WHERE `nic` = '{$_SESSION['administration_nic']}' AND `password` = '{$currentUserPwd}'";
        } else if($_SESSION['administration_role']=='AEO'){
            $current_pwd_query = "SELECT * FROM `assistant_election_officer` WHERE `nic` = '{$_SESSION['administration_nic']}' AND `password` = '{$currentUserPwd}'";
        } else if($_SESSION['administration_role']=='DO'){
            $current_pwd_query = "SELECT * FROM `division_officer` WHERE `nic` = '{$_SESSION['administration_nic']}' AND `password` = '{$currentUserPwd}'";
        }
        
        $current_pwd_query_result_set = mysqli_query($con,$current_pwd_query);

        /* query result */
		if (mysqli_num_rows($current_pwd_query_result_set)==1) {
            
            $pwd = rand(10000000,99999999);
            $h_pwd = sha1($pwd);
            
            $update_old_role = "UPDATE `voter` SET `role` = 'voter' WHERE `nic` = '{$_SESSION['administration_nic']}'";
            $update_old_role_result = mysqli_query($con,$update_old_role);
            
            if ($update_old_role_result) {
                if($_SESSION['administration_role']=='ADMIN'){
                    $change_user_position_query = "UPDATE `admin` SET `nic` = '{$newUserNic}', `password` = '{$h_pwd}'";
                } else if($_SESSION['administration_role']=='AEO'){
                    $change_user_position_query = "UPDATE `assistant_election_officer` SET `nic` = '{$newUserNic}', `password` = '{$h_pwd}' WHERE `dist_id` = '{$_SESSION['administration_working_at']}'";
                } else if($_SESSION['administration_role']=='DO'){
                    $change_user_position_query = "UPDATE `division_officer` SET `nic` = '{$newUserNic}', `password` = '{$h_pwd}' WHERE `divi_id` = '{$_SESSION['administration_working_at']}'";
                }
                
                $change_user_position_query_result = mysqli_query($con,$change_user_position_query);

                if ($change_user_position_query_result) {
                    
                    if($_SESSION['administration_role']=='ADMIN'){
                        $update_post = "UPDATE `voter` SET role = 'ADMIN' WHERE nic = '{$newUserNic}'";
                    } else if($_SESSION['administration_role']=='AEO'){
                        $update_post = "UPDATE `voter` SET role = 'AEO' WHERE nic = '{$newUserNic}'";
                    } else if($_SESSION['administration_role']=='DO'){
                        $update_post = "UPDATE `voter` SET role = 'DO' WHERE nic = '{$newUserNic}'";
                    }
                    
                    $result_update = mysqli_query($con,$update_post);

                    //email
                    $email_query = "SELECT `email` FROM `voter` WHERE `nic` = '{$newUserNic}' LIMIT 1";

                    $take_email = mysqli_query($con,$email_query);

                    if($take_email) {

                        if(mysqli_num_rows($take_email)==1) {
                            $email = mysqli_fetch_assoc($take_email)['email'];

                            passwordSendByEmail($email, $pwd);
                            
                            header("location:admin_logout.php");
                        }

                    }

                }
                else{
                    $altScs = 'none';
                    $altReq = 'block';
                }
            }
        
        }
        else{
            $errPositionChange = 'Password is wrong.';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Profile | FVS</title>
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
        <script src="../../js/script.js"></script>
        
        <!-- css -->
        <link href="../../css/main.css" rel="stylesheet">
        
        <!-- google font -->
        <link href='https://fonts.googleapis.com/css?family=Baloo Chettan' rel='stylesheet'>
        
        <!-- search Drop box -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
        
        <script>
            $(document).ready(function () {
                $('select').selectize({
                    sortField: 'text'
                });
            });
        </script>
        
        <script>
            $(document).ready(function(){
                $("#repwd").keyup(function(){
                    if ($("#pwd").val() != $("#repwd").val()) {
                        $("#msg").html("Password do not match").css("color","red");
                        $("#updatePwd").css("display","none");
                    }else{
                        $("#msg").html("Password matched").css("color","green");
                        $("#updatePwd").css("display","inline-block");
                    }
                });
            });
        </script>

    </head>

    <body>
        <div class="page-wrapper chiller-theme toggled">
            
            <?php
                require_once('admin_sidebar.php');
            ?><!-- sidebar-wrapper  -->
    
            <main class="page-content">
                <div class="container">
                    
                    <?php
                        require_once('admin_logoutbar.php');
                    ?><!-- logout bar  -->                    
                    
                    <div class="row topic">
                        <div class="col-md-1 topic-logo">
                            <i class="fas fa-user-edit fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Edit Profile</big><br><small>Profile</small></span>
                        </div>
                    </div>
                    <div class="row alert alert-primary successAlt" style="display: <?php echo $altScs; ?>;">
                        Save Successfully..!
                    </div>
                    <div class="row alert alert-danger requiredAlt" style="display: <?php echo $altReq; ?>;">
                        Save Unsuccessfully..!
                    </div>
                    <div class="row">
                        <div class="col-md-12 form">
                            <!-- Form -->
                            <form action="admin_editProfile.php" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>NIC Number </strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['administration_nic'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="fName" name="fName" value="<?php echo $_SESSION['administration_name'] ?>" disabled>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Contact <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $_SESSION['administration_contact'] ?>" required pattern="0[0-9]{9}">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Email <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['administration_email'] ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Birth Day <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="b_day" name="b_day" value="<?php echo $_SESSION['administration_b_day'] ?>" disabled>
                                    </div>
                                </div>                                
                                
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-7">
                                        <button type="submit" class="btn btn-success saveBtn" name="updatePro">Update Profile</button>
                                        
                                        <button type="reset" class="btn btn-danger resetBtn" name="resetPro">Reset</button>
                                    </div>
                                </div>
                            </form>
                                <hr>
                            <form action="admin_editProfile.php" method="post">
                                <h5 class="mb-4 lead">Change Password</h5>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Current Password <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" id="curpwd" name="curpwd" value="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>New Password <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" id="pwd" name="pwd" value="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Confirm New Password <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" id="repwd" name="repwd" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-7">
                                        <div id="msg" class="text-danger"><?php echo $err; ?></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-7">
                                        <button type="submit" class="btn btn-success saveBtn" name="updatePwd"  id="updatePwd">Update Password</button>
                                        <button type="reset" class="btn btn-danger resetBtn" name="resetPwd">Reset</button>
                                    </div>
                                </div>
                            </form>                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 form">
                            <!-- Form -->
                            <form action="admin_editProfile.php" method="post">
                                <h5 class="mb-4 lead">Change Position -
                                <?php
                                    if($_SESSION['administration_role']=='ADMIN'){
                                        echo "Administrator";
                                    } else if($_SESSION['administration_role']=='AEO'){
                                        echo "Assistant Election Officer [ ".$_SESSION['administration_working_at']." ]";
                                    } else if($_SESSION['administration_role']=='DO'){
                                        echo "Division Officer [ ".$_SESSION['administration_working_at']." ]";
                                    }
                                ?>
                                </h5>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>New User NIC <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="newUserNic" required>
                                            <?php
                                            
                                                $query = "SELECT * FROM `voter` WHERE `is_deleted` = 0 AND `is_died` = 0 AND TIMESTAMPDIFF(YEAR, `b_day`, CURDATE()) >= 18 AND (`role` != 'ADMIN' AND `role` != 'AEO' AND `role` != 'DO')";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    echo "<option value=''>NIC</option>";
                                                    while($voters_for_user = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$voters_for_user['nic']."'>".$voters_for_user['nic']." - ".$voters_for_user['name']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>Empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Current User Password <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" id="currentUserPwd" name="currentUserPwd" value="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-7">
                                        <div id="msg" class="text-danger"><?php echo $errPositionChange; ?></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-7">
                                        <button type="submit" class="btn btn-success saveBtn" name="updateUserPosition"  id="updateUserPosition">Update Position</button>
                                        <button type="reset" class="btn btn-danger resetBtn" name="resetPwd">Reset</button>
                                    </div>
                                </div>
                            </form>                            
                        </div>
                    </div>
                    
                </div>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
        
    </body>

    </html>