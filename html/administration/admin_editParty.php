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

    if(isset($_GET['id'])){
        $_SESSION['editPartyId'] = $_GET['id'];
    }

    $query = "SELECT * FROM `party` WHERE `id` = {$_SESSION['editPartyId']} LIMIT 1";

    $result_set = mysqli_query($con,$query);

    if (mysqli_num_rows($result_set) >= 1) {

        while($party = mysqli_fetch_assoc($result_set)){
            $nameEn = $party['name_en'];
            $nameSi = $party['name_si'];
            $nameTa = $party['name_ta'];
            $secretaryName = $party['secretary_name'];
            $partyContact = $party['contact'];
            $startDate = $party['start_date'];
            $partyAddress = $party['address'];
            $partyColor = $party['color'];
        }
    }

    if(isset($_POST['saveBtn'])) {
        
        $ne = trim($_POST['partyNameEn']);
		$nameEn =  ucwords($ne);
        
        $nameSi =  trim($_POST['partyNameSi']);
        
        $nameTa =  trim($_POST['partyNameTa']);
        
        $sn =  trim($_POST['secretaryName']);
        $secretaryName =  strtoupper($sn);
        
        $partyContact =  trim($_POST['partyContact']);
        
        $startDate =  trim($_POST['startDate']);
        
        $partyAddress =  trim($_POST['partyAddress']);
        $partyAddress =  ucfirst($partyAddress);
        
        $partyColor =  trim($_POST['partyColor']);
        
        if(isset($_FILES['partySymbol'])){
            $target_dir = "../../img/partySymbol/";
            $fileName = $_FILES['partySymbol']['name'];
            $tmpFileName = $_FILES['partySymbol']['tmp_name'];
            $pathForSave = $target_dir.$fileName;
            $upload_pict= move_uploaded_file($_FILES["partySymbol"]["tmp_name"], "$target_dir".$_FILES["partySymbol"]["name"]);
            
            $query = "UPDATE `party` SET `name_en` = '{$nameEn}', `name_si` = '{$nameSi}', `name_ta` = '{$nameTa}', `secretary_name` = '{$secretaryName}', `contact` = '{$partyContact}', `start_date` = '{$startDate}', `address` = '{$partyAddress}', `color` = '{$partyColor}', `symbol` = '{$pathForSave}' WHERE `id` = {$_SESSION['editPartyId']}";
            
        } else {
            $query = "UPDATE `party` SET `name_en` = '{$nameEn}', `name_si` = '{$nameSi}', `name_ta` = '{$nameTa}', `secretary_name` = '{$secretaryName}', `contact` = '{$partyContact}', `start_date` = '{$startDate}', `address` = '{$partyAddress}', `color` = '{$partyColor}' WHERE `id` = {$_SESSION['editPartyId']}";
        }

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_editParty.php");
        }

	}

    if(isset($_POST['resetBtn'])) {
        header("location:admin_partyList.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Edit Party | FVS</title>
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
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Edit Party</big><br><small>Party</small></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 form">
                            <a href="admin_partyList.php" ><button type="button" class="btn btn-outline-primary"><i class="fas fa-list"></i>  Party List</button></a>
                            <br><hr><br>
                            <!-- Form -->
                            <form action="admin_editParty.php" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Party Name (English)<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="partyNameEn" value="<?php echo $nameEn; ?>" placeholder="Party Name - English" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Party Name (Sinhala)<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="partyNameSi" value="<?php echo $nameSi; ?>" placeholder="Party Name - Sinhala" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Party Name (Tamil)<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="partyNameTa" value="<?php echo $nameSi; ?>" placeholder="Party Name - Tamil" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Secretary Name<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <select class="form-control" name="secretaryName" required>
                                            <?php
                                            
                                                $query = "SELECT * FROM `voter` WHERE `is_deleted` = 0 AND `is_died` = 0 AND TIMESTAMPDIFF(YEAR, `b_day`, CURDATE()) >= 18 AND (`role` != 'ADMIN' AND `role` != 'AEO' AND `role` != 'DO')";

                                                $result_set = mysqli_query($con,$query);

                                                if (mysqli_num_rows($result_set) >= 1) {
                                                    
                                                    echo "<option value=''>Secretary Name</option>";
                                                    while($secretaryName = mysqli_fetch_assoc($result_set)){
                                                        echo "<option value='".$secretaryName['nic']."'>".$secretaryName['nic']." - ".$secretaryName['name']."</option>";
                                                    }

                                                } else {
                                                    echo "<option value='".null."'>Empty</option>";
                                                }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Contact<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="partyContact" value="<?php echo $partyContact; ?>" placeholder="Contact" pattern="0[0-9]{9}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Start Date<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="date" class="form-control" name="startDate" value="<?php echo $startDate; ?>" placeholder="Date" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Address</strong></label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control" name="partyAddress" rows="5" placeholder="Address" required><?php echo $partyAddress; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Color<sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <input type="color" class="form-control" name="partyColor" value="<?php echo $partyColor; ?>" placeholder="Color" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><strong>Symbol <sup><i class="fas fa-asterisk fa-xs"  style="color:red;"></i></sup></strong></label>
                                    <div class="col-sm-7">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="partySymbol">
                                            <label class="custom-file-label">Choose .png file</label>
                                        </div>
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