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

	if(isset($_POST['updatePro'])) {

        $fn = trim($_POST['fName']);
		$fName =  ucfirst($fn);
        
		$contact = trim($_POST['contact']);
        
        $b_day = trim($_POST['b_day']);
        
        $gender = trim($_POST['gender']);
        
        $qurey = "UPDATE `voter` SET `name`='{$fName}',`contact`='{$contact}',`b_day`='{$b_day}',`gender`='{$gender}' WHERE `nic` = '{$_SESSION['nic']}'";

        $result = mysqli_query($con,$qurey);

        if ($result) {

            $altScs = 'block';
            $altReq = 'none';
            
            $_SESSION['name'] = $fName;
            $_SESSION['contact'] = $contact;
            $_SESSION['b_day'] = $b_day;
            $_SESSION['gender'] = $gender;

        }
        else{
            $altScs = 'none';
            $altReq = 'block';
        }

	}

    if(isset($_POST['updatePwd'])) {
        
        $p = trim($_POST['pwd']);
        $pwd = sha1($p);
        
        $qurey = "UPDATE `admin` SET `password` = '{$pwd}' WHERE `nic` = '{$_SESSION['nic']}'";

        $result = mysqli_query($con,$qurey);

        if ($result) {

            $altScs = 'block';
            $altReq = 'none';

        }
        else{
            $altScs = 'none';
            $altReq = 'block';
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
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['nic'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="fName" name="fName" value="<?php echo $_SESSION['name'] ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Contact <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $_SESSION['contact'] ?>" required pattern="0[0-9]{9}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Birth Day <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="b_day" name="b_day" value="<?php echo $_SESSION['b_day'] ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Gender <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $_SESSION['gender'] ?>" required>
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
                                        <div id="msg"></div>
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
                </div>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
        
    </body>

    </html>