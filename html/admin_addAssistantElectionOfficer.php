<?php
    /* start the session */
	session_start();

    /* database connection page include */
    require_once('../connection/connection.php');

    /* if session is not set, redirect to login page */
    if(!isset($_SESSION['nic'])) {
	    header("location:admin_login.php");
	}

?>


<?php

    $altScs = 'none';
    $altReq = 'none';

	if(isset($_POST['saveBtn'])) {

        
        $nic =  trim($_POST['nic']);
        //$email =  trim($_POST['email']);
        $division_id=  trim($_POST['district']);
        $pwd=rand(10000,99999);
        
	$email_query="SELECT email FROM `voter` WHERE nic='{$nic}'";
	$take_emial=mysqli_query($con,$email_query);
	
	if($take_emial){
		$recode=mysqli_fetch_assoc($take_emial);
		$emial=$recode['email'];
		
	}else{
		echo "query error";
	}
		
        $query="INSERT INTO `assistant_election_officer`(nic,password,dist_id) VALUES('{$nic}','{$pwd}','{$division_id}')";
        $result=mysqli_query($con,$query);
        
        if ($result){
            $altScs = 'block';
            $altReq = 'none';
            
            require '../email/PHPMailerAutoload.php';
            $credential = include('../email/credential.php');   //credentials import
            
            $mail = new PHPMailer;
                //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $credential['user']  ;           // SMTP username
            $mail->Password = $credential['pass']  ;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->setFrom($email);
            $mail->addAddress($email);             // Name is optional

            $mail->addReplyTo('hello');

            $mail->isHTML(true);                                  // Set email format to HTML
            $send1="";
            $send2="";
            $pw="Your password is : ".$pwd;
            $mail->Subject = "Password";
            $mail->Body    = "$pw<br>";
            $mail->AltBody = 'If you see this mail. please reload the page.';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }else{
                echo "<script>alert('Your password send your Email')</script>";
            }

        }else{
            $altScs = 'none';
            $altReq = 'block';
        }

	}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Voter | FVS</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
        <script src="../js/script.js"></script>
        
        <!-- css -->
        <link href="../css/main.css" rel="stylesheet">
        
        <!-- google font -->
        <link href='https://fonts.googleapis.com/css?family=Baloo Chettan' rel='stylesheet'>
        
        <!-- email search-->
        
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
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Add Assistant Election Officer</big><br><small>Assistant Election Officer</small></span>
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
                            <a href="admin_assistantElectionOfficerList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i>Assistant Election Officer List</button></a>
                            <br><hr><br>
                            <!-- Form -->
                            <form action="admin_addAssistantElectionOfficer.php" method="post">
                                
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>NIC<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="nic">
                                            <?php
                                            
                                                $query = "SELECT * FROM `voter`";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    echo "<option value=''>NIC Search</option>";
                                                    while($voter = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$voter['nic']."'>".$voter['nic']."</option>";
                                                        //$email=$voter[email];
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                               <!-- <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Email Address<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="email">
                                            <?php
                                             	/* $query = "SELECT * FROM `voter`";
                                                
                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1){
                                                     echo "<option value=''>Email Search</option>";
                                                    while($division = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$division['email']."'>".$division['email']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>empty</option>";
                                                }*/

                                            ?>
                                        </select>
                                    </div>
                                </div>-->
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>District<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="district">
                                            <?php
                                            
                                                $query = "SELECT * FROM `district`";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1){
                                                     echo "<option value=''>District</option>";
                                                    while($district = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$district['id']."'>".$district['name']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>empty</option>";
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
