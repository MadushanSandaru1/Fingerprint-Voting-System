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
     
    //count voters
    if($_SESSION['administration_role']=='ADMIN'){
        $query = "SELECT COUNT(*) AS 'votersCount' FROM `voter` WHERE `is_died` = 0 AND `is_deleted` = 0 AND TIMESTAMPDIFF(YEAR, `b_day`, CURDATE()) >= 18";
    } else if($_SESSION['administration_role']=='AEO'){
        $query = "SELECT COUNT(v.`nic`) AS 'votersCount' FROM `voter` v, `division` divi, `district` dist WHERE v.`divi_id` = divi.`id` AND divi.`dist_id` = dist.`id` AND v.`is_died` = 0 AND v.`is_deleted` = 0 AND TIMESTAMPDIFF(YEAR, v.`b_day`, CURDATE()) >= 18 AND dist.`id` = {$_SESSION['administration_working_at']}";
    } else if($_SESSION['administration_role']=='DO'){
        $query = "SELECT COUNT(*) AS 'votersCount' FROM `voter` WHERE `is_died` = 0 AND `is_deleted` = 0 AND TIMESTAMPDIFF(YEAR, `b_day`, CURDATE()) >= 18 AND `divi_id` = {$_SESSION['administration_working_at']}";
    }

    $result_set = mysqli_query($con,$query);

    if (mysqli_num_rows($result_set) >= 1) {

        $voterC = mysqli_fetch_assoc($result_set);

    } else {
        echo "<option value='".null."'>000</option>";
    }

    //count parties
    $query = "SELECT COUNT(*) AS 'partiesCount' FROM `party` WHERE `is_deleted` = 0";

    $result_set = mysqli_query($con,$query);

    if (mysqli_num_rows($result_set) >= 1) {

        $partyC = mysqli_fetch_assoc($result_set);

    } else {
        echo "<option value='".null."'>000</option>";
    }

    //count division
    $query = "SELECT COUNT(*) AS 'divisionsCount' FROM `division`";

    $result_set = mysqli_query($con,$query);

    if (mysqli_num_rows($result_set) >= 1) {

        $divisionC = mysqli_fetch_assoc($result_set);

    } else {
        echo "<option value='".null."'>000</option>";
    }

    //count division_officer
    if($_SESSION['administration_role']=='ADMIN'){
        $query = "SELECT COUNT(*) AS 'divisionOfficerCount' FROM `division_officer`";
    } else if($_SESSION['administration_role']=='AEO'){
        $query = "SELECT COUNT(divof.`divi_id`) AS 'divisionOfficerCount' FROM `division_officer` divof, `division` divi, `district` dist WHERE divof.`divi_id` = divi.`id` AND divi.`dist_id` = dist.`id` AND dist.`id` = {$_SESSION['administration_working_at']}";
    }

    $result_set = mysqli_query($con,$query);

    if (mysqli_num_rows($result_set) >= 1) {

        $divisionOfficerC = mysqli_fetch_assoc($result_set);

    } else {
        echo "<option value='".null."'>000</option>";
    }

    //count assistant_election_officer
    $query = "SELECT COUNT(*) AS 'assistantElectionOfficerCount' FROM `assistant_election_officer`";

    $result_set = mysqli_query($con,$query);

    if (mysqli_num_rows($result_set) >= 1) {

        $assistantElectionOfficerC = mysqli_fetch_assoc($result_set);

    } else {
        echo "<option value='".null."'>000</option>";
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard | FVS</title>
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
                    
                    
                    <div class="row topic mb-4">
                        <div class="col-md-1 topic-logo">
                            <i class="fas fa-tachometer-alt fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Dashboard</big><br><small>Home</small></span>
                        </div>
                    </div>
                    
                    <a class="btn" id="voterCount">
                        <div class="card img-fluid border-warning mb-3" style="width: 18rem;height: 10rem;box-shadow: 4px 4px 4px rgba(130,138,145, 0.5);">
                            <i  <?php
                                    echo "class='fas fa-user fa-7x'";
                                ?>
                               
                               style="color:gainsboro;position:absolute; bottom:0; right:0;"></i>
                            <div class="card-body card-img-overlay text-warning">
                                <?php
                                    echo "<h4 class='card-title'>Voters</h4>";
                                ?>
                                
                                <h1>
                                    <?php
                                        echo $voterC['votersCount'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </a>                    
                    
                    <a class="btn" id="partyCount">
                        <div class="card img-fluid border-secondary mb-3" style="width: 18rem;height: 10rem;box-shadow: 4px 4px 4px rgba(130,138,145, 0.5);">
                            <i  <?php
                                    echo "class='fas fa-building fa-7x'";
                                ?>
                               
                               style="color:gainsboro;position:absolute; bottom:0; right:0;"></i>
                            <div class="card-body card-img-overlay text-secondary">
                                <?php
                                    echo "<h4 class='card-title'>Party</h4>";
                                ?>
                                
                                <h1>
                                    <?php
                                        echo $partyC['partiesCount'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                    
                    <a class="btn" id="doCount" style="display:<?php if($_SESSION['administration_role'] == 'DO') echo "none"; ?>;">
                        <div class="card img-fluid border-info mb-3" style="width: 18rem;height: 10rem;box-shadow: 4px 4px 4px rgba(130,138,145, 0.5);">
                            <i  <?php
                                    echo "class='fas fa-user-tie fa-7x'";
                                ?>

                               style="color:gainsboro;position:absolute; bottom:0; right:0;"></i>
                            <div class="card-body card-img-overlay text-info">
                                <?php
                                    echo "<h4 class='card-title'>Divisions Officer</h4>";
                                ?>

                                <h1>
                                    <?php
                                        echo $divisionOfficerC['divisionOfficerCount'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                    
                    <a class="btn" id="aeoCount" style="display:<?php if($_SESSION['administration_role'] != 'ADMIN') echo "none"; ?>;">
                        <div class="card img-fluid border-danger mb-3" style="width: 18rem;height: 10rem;box-shadow: 4px 4px 4px rgba(130,138,145, 0.5);">
                            <i  <?php
                                    echo "class='fas fa-user-tie fa-7x'";
                                ?>

                               style="color:gainsboro;position:absolute; bottom:0; right:0;"></i>
                            <div class="card-body card-img-overlay text-danger">
                                <?php
                                    echo "<h4 class='card-title'>Assistant Election Officer</h4>";
                                ?>

                                <h1>
                                    <?php
                                        echo $assistantElectionOfficerC['assistantElectionOfficerCount'];
                                    ?>
                                </h1>
                            </div>
                        </div>
                    </a>
                    
                    <!-- -------------------------- -->
                    
                    
                </div>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
        
    </body>

    </html>