<?php
    /* start the session */
	session_start();

    /* database connection page include */
    require_once('../connection/connection.php');

    /* if session is not set, redirect to login page */
    if(!isset($_SESSION['nic'])) {
	    header("admin_location:login.php");
	}

?>

<?php
     
    //count voters
    $query = "SELECT COUNT(*) AS 'votersCount' FROM `voter` WHERE `is_deleted` = 0";

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

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard | FVS</title>
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
                    
                    <a href="admin_voterList.php" class="btn" id="deptCount">
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
                    
                    <a href="admin_partyList.php" class="btn" id="deptCount">
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
                    
                    <a href="#" class="btn" id="deptCount">
                        <div class="card img-fluid border-info mb-3" style="width: 18rem;height: 10rem;box-shadow: 4px 4px 4px rgba(130,138,145, 0.5);">
                            <i  <?php
                                    echo "class='fas fa-project-diagram fa-7x'";
                                ?>

                               style="color:gainsboro;position:absolute; bottom:0; right:0;"></i>
                            <div class="card-body card-img-overlay text-info">
                                <?php
                                    echo "<h4 class='card-title'>Division</h4>";
                                ?>

                                <h1>
                                    <?php
                                        echo $divisionC['divisionsCount'];
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