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

    if(isset($_GET['id'])){
        $_SESSION['editScheduleId'] = $_GET['id'];
    }

    $query = "SELECT * FROM `election_schedule` WHERE `id` = '{$_SESSION['editScheduleId']}' LIMIT 1";

    $result_set = mysqli_query($con,$query);

    if (mysqli_num_rows($result_set) >= 1) {

        while($elecSchedule = mysqli_fetch_assoc($result_set)){
            $id = $elecSchedule['id'];
            $dateFrom = $elecSchedule['date_from'];
            $dateTo = $elecSchedule['date_to'];
        }
    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                

	if(isset($_POST['saveBtn'])) {
        
        $electionType =  $_POST['electionType'];
        
        $dateFrom =  trim($_POST['dateFrom']);
        
        $dateTo =  trim($_POST['dateTo']);
        
        $query = "UPDATE `election_schedule` SET `type` = {$electionType}, `date_from` = '{$dateFrom}', `date_to` = '{$dateTo}' WHERE `id` = '{$_SESSION['editScheduleId']}'";
        

        $result = mysqli_query($con,$query);

        if ($result) {

            $altScs = 'block';
            $altReq = 'none';

        }
        else{
            $altScs = 'none';
            $altReq = 'block';
        }

	}

    if(isset($_POST['resetBtn'])) {
        header("location:admin_candidateList.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Candidate | FVS</title>
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
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Edit Election Schedule</big><br><small>Election Schedule</small></span>
                        </div>
                    </div>
                    <div class="row alert alert-primary successAlt" style="display: <?php echo $altScs; ?>;">
                        Update Successfully..!
                    </div>
                    <div class="row alert alert-danger requiredAlt" style="display: <?php echo $altReq; ?>;">
                        Update Unsuccessfully..!
                    </div>
                    <div class="row">
                        <div class="col-md-12 form">
                            <a href="admin_electionScheduleList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i>  Election Schedule List</button></a>
                            <br><hr><br>
                            <!-- Form -->
                            <form action="admin_editElectionSchedule.php" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Election Type <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="electionType">
                                            <?php
                                            
                                                $query = "SELECT * FROM `election` ORDER BY `id`";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    while($election = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$election['id']."'>".$election['name_en']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Date - From<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="datetime-local" class="form-control" name="dateFrom" placeholder="Date - From" value="value="<?php echo $dateFrom; ?>"" min="<?php echo date('Y-m-d');?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Date - To<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="datetime-local" class="form-control" name="dateTo" placeholder="Date - To" min="<?php echo date('Y-m-d') . 'T' . date("H:i:s");?>" required>
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