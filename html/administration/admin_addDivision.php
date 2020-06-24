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

<?php
    
    $altScs = 'none';
    $altReq = 'none';

    if(isset($_POST['saveBtn'])){
        
        $distric_id = $_POST['distric_id'];
        
        $d_name = $_POST['d_name'];
        $d_name = ucwords($d_name);
        
        $query="INSERT INTO `division`(name,dist_id) VALUES('{$d_name}','{$distric_id}')";
        $result=mysqli_query($con,$query);
        
        if ($result) {
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
        <title>Add Division | FVS</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
                           <i class="fas fa-bezier-curve"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Add Division</big><br><small>Division</small></span>
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
                            <a href="admin_divisionList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i>  Division List</button></a>
                            <br><hr><br>
                            <!-- Form -->
                            <form action="admin_addDivision.php" method="POST">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>District<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="distric_id">
                                            <?php
                                            
                                                $query = "SELECT * FROM `district`";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    while($district = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$district['id']."'>".$district['name']."</option>";
                                                    }   

                                                } else {
                                                    echo "<option value='".null."'>Empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Division Name<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="d_name" placeholder="Name - English" required>
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