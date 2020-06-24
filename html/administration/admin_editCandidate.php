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

    if(isset($_GET['id'])){
        $_SESSION['editCandidateId'] = $_GET['id'];
    }

    $query = "SELECT c.*, v.`name` FROM `candidate` c, `voter` v WHERE c.`id` = {$_SESSION['editCandidateId']} AND c.`nic` = v.`nic` LIMIT 1";

    $result_set = mysqli_query($con,$query);

    if (mysqli_num_rows($result_set) >= 1) {

        while($candidate = mysqli_fetch_assoc($result_set)){
            $nic = $candidate['nic'];
            $image = $candidate['image'];
            $nameEn = $candidate['name'];
            $nameSi = $candidate['name_si'];
            $nameTa = $candidate['name_ta'];
        }
    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                

	if(isset($_POST['saveBtn'])) {
        
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
            
            $query = "UPDATE `candidate` SET `party_id` = '{$party}', `image` = '{$pathForSave}', `name_si` = '{$nameSi}', `name_ta` = '{$nameTa}', `schedule_id` = '{$scheduleId}' WHERE `id` = {$_SESSION['editCandidateId']}";
            
        } else {
            $query = "UPDATE `candidate` SET `party_id` = '{$party}', `image` = '../../img/candidate/candidate_default.png',  `name_si` = '{$nameSi}', `name_ta` = '{$nameTa}', `schedule_id` = '{$scheduleId}' WHERE `id` = {$_SESSION['editCandidateId']}";
        }

        $result = mysqli_query($con,$query);

        if ($result) {

            $altScs = 'block';
            $altReq = 'none';
            
            header("location:admin_candidateList.php");

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
                            <span class="font-weight-bold"><big>Edit Candidate</big><br><small>Candidate</small></span>
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
                            <a href="admin_candidateList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i>  Candidate List</button></a>
                            <br><hr><br>
                            <!-- Form -->
                            <form action="admin_editCandidate.php" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>NIC <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nic" value="<?php echo $nic; ?>" placeholder="NIC" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (English) <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameEn" value="<?php echo $nameEn; ?>" placeholder="Name - English" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (Sinhala) <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameSi" value="<?php echo $nameSi; ?>" placeholder="Name - Sinhala" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Name (Tamil) <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nameTa" value="<?php echo $nameTa; ?>" placeholder="Name - Tamil" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Image <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="candidate_image">
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
                                            
                                                $query = "SELECT s.`id`, e.`name_en`, s.`date_from` FROM `election_schedule` s, `election` e WHERE e.`id` = s.`type` AND s.`date_from` > CURDATE() ORDER BY s.`date_from` DESC";

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
                                        <button type="submit" class="btn btn-secondary resetBtn" name="resetBtn">Cancel</button>
                                        <button type="submit" class="btn btn-success saveBtn" name="saveBtn">Update</button>
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