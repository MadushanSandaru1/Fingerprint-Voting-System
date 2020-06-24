<?php

    date_default_timezone_set('Asia/Colombo');
     
    session_start();

    /* database connection page include */
    require_once('../../connection/connection.php');

    /* if session is not set, redirect to login page */
    if(!isset($_SESSION['administration_nic'])) {
	    header("location:../../admin_login.php");
	}

    $status = false;

?>

<?php

    $altScs = 'none';
    $altReq = 'none';

	if(isset($_POST['saveBtn'])) {

        $electionType =  $_POST['electionType'];
        
        $dateFrom =  trim($_POST['dateFrom']);
        
        $dateTo =  trim($_POST['dateTo']);
        
        $query = "INSERT INTO `election_schedule`(`type`, `date_from`, `date_to`) VALUES ('{$electionType}','{$dateFrom}','{$dateTo}')";

        $result = mysqli_query($con,$query);

        if ($result) {
            
            //change voter's e-card pin
            $change_pin_select_query = "SELECT * FROM `voter` WHERE `is_deleted` = 0 AND `is_died` = 0";
            $change_pin_select_result_set = mysqli_query($con,$change_pin_select_query);

            if (mysqli_num_rows($change_pin_select_result_set) >= 1) {

                while($change_pin_select_voter = mysqli_fetch_assoc($change_pin_select_result_set)){
                    $change_pin_update_query = "UPDATE `voter` SET `e_card_pin`= ".rand(100000000000,999999999999)." WHERE `nic` = '{$change_pin_select_voter['nic']}'";
                    $change_pin_update_result_set = mysqli_query($con,$change_pin_update_query);
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

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Election Schedule | FVS</title>
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
                            <i class="far fa-calendar-alt fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Add Election Schedule</big><br><small>Election Schedule</small></span>
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
                            <a href="admin_electionScheduleList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i>  Election Schedule List</button></a>
                            <br><hr><br>
                            
                            <?php
                                $schedule_status_query = "SELECT s.*, e.`name_en` FROM `election_schedule` s, `election` e WHERE s.`is_deleted` = 0 AND s.`type` = e.`id` AND s.`date_to` > NOW() ORDER BY s.`date_from` DESC";
                            
                                $schedule_status_result_set = mysqli_query($con,$schedule_status_query);
                            
                                if (mysqli_num_rows($schedule_status_result_set) >= 1) {
                                    $status = true;
                            ?>
                            <h4 class="text-danger">An election has already been scheduled</h4>
                            
                            <br>
                            <?php
                                }
                            ?>
                            
                            <!-- Form -->
                            <form action="admin_addElectionSchedule.php" method="post">
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Election Type <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="electionType" required <?php if($status) echo 'disabled'; ?>>
                                            <?php
                                            
                                                $query = "SELECT * FROM `election` ORDER BY `id`";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    echo "<option value=''>Election Type</option>";
                                                    while($election = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$election['id']."'>".$election['name_en']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>Empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Date - From <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="datetime-local" class="form-control" name="dateFrom" placeholder="Date - From" required <?php if($status) echo 'disabled'; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Date - To <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="datetime-local" class="form-control" name="dateTo" placeholder="Date - To" required <?php if($status) echo 'disabled'; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-7">
                                        <button type="reset" class="btn btn-secondary resetBtn" <?php if($status) echo 'disabled'; ?>>Reset</button>
                                        <button type="submit" class="btn btn-success saveBtn" name="saveBtn" <?php if($status) echo 'disabled'; ?>>Save</button>
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