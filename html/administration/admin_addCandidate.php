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

	if(isset($_POST['saveBtn'])) {

        $nic =  trim($_POST['nic']);
        
        $nameSi =  trim($_POST['nameSi']);
        
        $nameTa =  trim($_POST['nameTa']);
        
        $party =  trim($_POST['party']);
        
        $scheduleId =  trim($_POST['scheduleId']);
        
        if(isset($_FILES['candidate_image'])){
            $target_dir = "../../img/candidate/";
            $fileName = $_FILES['candidate_image']['name'];
            $tmpFileName = $_FILES['candidate_image']['tmp_name'];
            $pathForSave = $target_dir.$fileName;
            $upload_pict= move_uploaded_file($_FILES["candidate_image"]["tmp_name"], "$target_dir".$_FILES["candidate_image"]["name"]);
            
            $query = "INSERT INTO `candidate`(`nic`, `party_id`, `image`, `name_si`, `name_ta`, `schedule_id`, `is_deleted`) VALUES ('{$nic}','{$party}','{$pathForSave}','{$nameSi}','{$nameTa}','{$scheduleId}',0)";
            
        } else {
            $query = "INSERT INTO `candidate`(`nic`, `party_id`, `image`, `name_si`, `name_ta`, `schedule_id`, `is_deleted`) VALUES ('{$nic}','{$party}','../../img/candidate/candidate_default.png','{$nameSi}','{$nameTa}','{$scheduleId}',0)";
        }

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

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add Candidate | FVS</title>
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
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Add Candidate</big><br><small>Candidate</small></span>
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
                            <a href="admin_candidateList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i>  Candidate List</button></a>
                            <br><hr><br>
                            
                            <?php
                                if($_SESSION['administration_role']=='ADMIN'){
                            ?>
                            <h4 class="text-danger">Only for Presidential Election</h4>
                            
                            <br>
                            <?php
                                } else {
                            ?>
                            <h4 class="text-danger">Only for Elections other than the Presidential Election</h4>
                            
                            <br>
                            <?php
                                }
                            ?>
                            <!-- Form -->
                            <form action="admin_addCandidate.php" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>NIC <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="nic" required>
                                            <?php
                                            
                                                if($_SESSION['administration_role']=='ADMIN'){
                                                    $query = "SELECT v.* FROM `voter` v, `district` dis, `division` d WHERE v.`divi_id` =  d.`id` AND d.`dist_id` = dis.`id` AND v.`is_deleted` = 0 AND v.`is_died` = 0 AND TIMESTAMPDIFF(YEAR, v.`b_day`, CURDATE()) >= 18 AND (v.`role` != 'ADMIN' AND v.`role` != 'AEO' AND v.`role` != 'DO')";
                                                } else if($_SESSION['administration_role']=='AEO') {
                                                    $query = "SELECT v.* FROM `voter` v, `district` dis, `division` d WHERE v.`divi_id` =  d.`id` AND d.`dist_id` = dis.`id` AND dis.`id` = {$_SESSION['administration_working_at']} AND v.`is_deleted` = 0 AND v.`is_died` = 0 AND TIMESTAMPDIFF(YEAR, v.`b_day`, CURDATE()) >= 18 AND (v.`role` != 'ADMIN' AND v.`role` != 'AEO' AND v.`role` != 'DO')";
                                                }
                                            
                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    echo "<option value=''>NIC</option>";
                                                    while($voters_for_candidate = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$voters_for_candidate['nic']."'>".$voters_for_candidate['nic']." - ".$voters_for_candidate['name']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>Empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <!--<div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (English) <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameEn1" placeholder="Name - English" readonly required>
                                    </div>
                                </div>-->
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (Sinhala) <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameSi" placeholder="Name - Sinhala" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (Tamil) <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameTa" placeholder="Name - Tamil" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Image <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="candidate_image" required>
                                            <label class="custom-file-label">Choose .png file</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Party <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="party" required>
                                            <?php
                                            
                                                $query = "SELECT * FROM `party` WHERE `is_deleted` = 0 ORDER BY `name_en`";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    echo "<option value=''>Party</option>";
                                                    while($party = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$party['id']."'>".$party['id']." - ".$party['name_en']."</option>";
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
                                            
                                                if($_SESSION['administration_role']=='ADMIN'){
                                                    $query = "SELECT s.`id`, e.`name_en`, s.`date_from` FROM `election_schedule` s, `election` e WHERE e.`id` = s.`type` AND s.`date_from` > NOW() AND e.`id` = 1 ORDER BY s.`date_from` DESC";
                                                } else if($_SESSION['administration_role']=='AEO') {
                                                    $query = "SELECT s.`id`, e.`name_en`, s.`date_from` FROM `election_schedule` s, `election` e WHERE e.`id` = s.`type` AND s.`date_from` > NOW() AND e.`id` != 1 ORDER BY s.`date_from` DESC";
                                                }
                                            
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