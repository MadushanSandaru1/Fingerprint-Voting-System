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

        /*$ne = trim($_POST['partyNameEn']);
		$nameEn =  ucfirst($ne);*/
        
        $nic =  trim($_POST['nic']);
        
        $nameSi =  trim($_POST['nameSi']);
        
        $nameTa =  trim($_POST['nameTa']);
        
        $party =  trim($_POST['party']);
        
        $scheduleId =  trim($_POST['scheduleId']);
        
        if(isset($_FILES['image'])){
            $targetDir = "../img/voter/";
            $fileName = $_FILES['image']['name'];
            $tmpFileName = $_FILES['image']['tmp_name'];
            $pathForSave = $targetDir.$fileName;

            $status = 0;

            $status = move_uploaded_file($tmpFileName, $pathForSave);

            if($status){
                $qurey = "INSERT INTO `voter`(`nic`, `party_id`, `image`, `name_si`, `name_ta`, `schedule_id`, `is_deleted`) VALUES ('{$nic}','{$party}','{$pathForSave}','{$nameSi}','{$nameTa}','{$scheduleId}',0)";
            }
            else {
                $qurey = "INSERT INTO `voter`(`nic`, `party_id`, `name_si`, `name_ta`, `schedule_id`, `is_deleted`) VALUES ('{$nic}','{$party}','{$nameSi}','{$nameTa}','{$scheduleId}',0)";
            }
        } else {
            $qurey = "INSERT INTO `voter`(`nic`, `party_id`, `name_si`, `name_ta`, `schedule_id`, `is_deleted`) VALUES ('{$nic}','{$party}','{$nameSi}','{$nameTa}','{$scheduleId}',0)";
        }

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
                            <span class="font-weight-bold"><big>Add Voter</big><br><small>Voter</small></span>
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
                            <a href="admin_voterList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i>  Voter List</button></a>
                            <br><hr><br>
                            <!-- Form -->
                            <form action="admin_addVoter.php" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>NIC Number <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="nic">
                                            <?php
                                            
                                                $query = "SELECT * FROM `voter` WHERE `is_deleted` = 0 ORDER BY `nic`";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    while($nic = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$nic['nic']."'>".$nic['nic']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (English)<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameEn" placeholder="Name - English" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (Sinhala)<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameSi" placeholder="Name - Sinhala" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (Tamil)<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameTa" placeholder="Name - Tamil" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Image <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image">
                                            <label class="custom-file-label">Choose .png file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Party <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="party">
                                            <?php
                                            
                                                $query = "SELECT * FROM `party` WHERE `is_deleted` = 0 ORDER BY `name_en`";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    while($party = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$party['id']."'>".$party['name_en']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Schedule Id <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="scheduleId">
                                            <?php
                                            
                                                $query = "SELECT s.`id`, e.`name_en`, s.`from` FROM `election_schedule` s, `election` e WHERE e.`id` = s.`type` ORDER BY `from` DESC";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    while($schedule = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$schedule['id']."'>".strtok($schedule['from'], " ")." - ".$schedule['name_en']."</option>";
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