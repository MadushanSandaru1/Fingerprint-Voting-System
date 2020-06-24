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
    $mailaltScs = 'none';
    $mailaltReq = 'none';

?>

<?php

    function passwordSendByEmail($email, $acc_pwd, $start_time, $stop_time){
        
        $heading = "FVS | Election Commission of Sri Lanka";
        $message = "<h3>FVS Account Password</h3><br>Dear Sir/Madam,<br><p>Election start time : <b>".$start_time."</b><br>Election deadline : <b>".$stop_time."</b><br><br>Your account password : <b>".$acc_pwd."</b></p><br>*** This account is valid only during the election period. ***<br>Thank You!<br><pre>Election Commission,<br>Election Secretariat,<br>Sarana Mawatha,<br>Rajagiriya,<br>Sri Lanka - 10107</pre>";

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
            $mailaltScs = 'none';
            $mailaltReq = 'block';
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $mailaltScs = 'block';
            $mailaltReq = 'none';
        }
    }

?>

<?php

    if(isset($_POST['saveBtn'])) {

        
        $nic =  trim($_POST['nic']);
        $schedule_id =  trim($_POST['scheduleId']);
        
        $pwd=rand(10000000,99999999);
        $h_pwd = sha1($pwd);
        
        $add_inspector_query = "INSERT INTO `inspector`(`nic`, `password`, `schedule_id`) VALUES ('{$nic}','{$h_pwd}','{$schedule_id}')";
        $add_inspector_result = mysqli_query($con,$add_inspector_query);
        
        if($add_inspector_result) {
            
            //email send
            $email_query="SELECT `email` FROM `voter` WHERE `nic` = '{$nic}' LIMIT 1";

            $take_email=mysqli_query($con,$email_query);

            if($take_email) {

                if(mysqli_num_rows($take_email)==1) {
                    $email = mysqli_fetch_assoc($take_email)['email'];
                    
                    $shcedule_info_query="SELECT * FROM `election_schedule` WHERE `is_deleted` = 0 AND `id` = {$schedule_id}";
                    $shcedule_info_result=mysqli_query($con,$shcedule_info_query);
                    $shcedule_info = mysqli_fetch_assoc($shcedule_info_result);
                    
                    passwordSendByEmail($email, $pwd, $shcedule_info['date_from'], $shcedule_info['date_to']);
                }

            } else {
                $mailaltScs = 'none';
                $mailaltReq = 'block';
            }
            
            $altScs = 'block';
            $altReq = 'none';

        }else{
            $altScs = 'none';
            $altReq = 'block';
        }
    
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Inspector | FVS</title>
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
                            <i class="fas fa-user-tag fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Add Inspector</big><br><small>Inspector</small></span>
                        </div>
                    </div>
                    
                    <div class="row alert alert-primary successAlt" style="display: <?php echo $altScs; ?>;">
                        Save Successfully..!
                    </div>
                    <div class="row alert alert-danger requiredAlt" style="display: <?php echo $altReq; ?>;">
                        Save Unsuccessfully..!
                    </div>
                    <div class="row alert alert-primary successAlt" style="display: <?php echo $mailaltScs; ?>;">
                        Email was sent successfully..!
                    </div>
                    <div class="row alert alert-danger requiredAlt" style="display: <?php echo $mailaltReq; ?>;">
                        Failed to send email..!
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 form">
                            <a href="admin_inspectorList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i> Inspector List</button></a>
                            <br><hr><br>
                            <!-- Form -->
                            <form action="admin_addInspector.php" method="post">
                                
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>NIC <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="nic" required>
                                            <?php
                                            
                                                $query = "SELECT * FROM `voter` v, `district` dis, `division` d WHERE v.`divi_id` =  d.`id` AND d.`dist_id` = dis.`id` AND dis.`id` = {$_SESSION['administration_working_at']} AND v.`is_deleted` = 0 AND v.`is_died` = 0 AND TIMESTAMPDIFF(YEAR, v.`b_day`, CURDATE()) >= 18 AND (v.`role` != 'ADMIN' AND v.`role` != 'AEO' AND v.`role` != 'DO')";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    echo "<option value=''>NIC</option>";
                                                    while($voters_for_inspector = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$voters_for_inspector['nic']."'>".$voters_for_inspector['nic']." - ".$voters_for_inspector['name']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>Empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Schedule Id <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="scheduleId" required>
                                            <?php
                                            
                                                $query = "SELECT s.`id`, e.`name_en`, s.`date_from` FROM `election_schedule` s, `election` e WHERE e.`id` = s.`type` AND s.`date_from` > NOW() ORDER BY s.`date_from` DESC";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    echo "<option value=''>Schedule Id</option>";
                                                    
                                                    while($schedule = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$schedule['id']."'>".strtok($schedule['date_from'], " ")." - ".$schedule['name_en']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>Empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                               
                                
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-7">
                                        <button type="reset" class="btn btn-secondary resetBtn">Reset</button>
                                        <button type="submit" class="btn btn-success saveBtn" name="saveBtn">Save</button>
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
