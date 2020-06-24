<?php

    date_default_timezone_set('Asia/Colombo');
     
    session_start();

    /* database connection page include */
    require_once('../../connection/connection.php');

    /* if session is not set, redirect to login page */
    if(!isset($_SESSION['administration_nic'])) {
	    header("location:../../admin_login.php");
	}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Profile | FVS</title>
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
                            <span class="font-weight-bold"><big>About You</big><br><small>Profile</small></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 form">
                            <!-- Form -->
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><strong>NIC </strong></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['administration_nic'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><strong>Name <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="fName" name="fName" value="<?php echo $_SESSION['administration_name'] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><strong>Contact <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $_SESSION['administration_contact'] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><strong>Email <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                <div class="col-sm-7">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['administration_email'] ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><strong>Birth Day <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="b_day" name="b_day" value="<?php echo $_SESSION['administration_b_day'] ?>" readonly>
                                </div>
                            </div>
                            
                            <?php
                                if($_SESSION['administration_role']!='ADMIN'){
                                    if($_SESSION['administration_role']=='AEO'){
                                        $query = "SELECT `name` FROM `district` WHERE `id` = {$_SESSION['administration_working_at']}";
                                    } else {
                                        $query = "SELECT `name` FROM `division` WHERE `id` = {$_SESSION['administration_working_at']}";
                                    }

                                    $result_set = mysqli_query($con,$query);

                                    $working_at_name = mysqli_fetch_assoc($result_set)['name'];
                            ?>
                            
                            <hr class="my-5">
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"><strong>Working at <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="b_day" name="b_day" value="<?php echo $_SESSION['administration_working_at']." - ".$working_at_name; ?>" readonly>
                                </div>
                            </div>
                            
                            <?php
                                }
                            ?>
                                
                        </div>
                    </div>
                </div>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
        
    </body>

    </html>