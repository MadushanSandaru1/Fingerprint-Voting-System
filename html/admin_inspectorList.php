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


    if(isset($_GET['id'])){
	    
        $nic = $_GET['id'];
        
        //deleting record
        $query = "UPDATE `grama_niladhari` SET is_deleted = 1 WHERE nic='{$nic}'";

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_assistantElectionOfficerList..php");
        }
        
	} 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Inspector List | FVS</title>
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
                    
                    
                    <div class="row topic">
                        <div class="col-md-1 topic-logo">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Inspector List</big><br><small>Inspector</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-8'>
                                    <a href='admin_addInspector.php'><button type='button' class='btn btn-outline-primary'><i class='fas fa-plus'></i> Add Inspector</button></a>
                                </div>
                                <div class="col-md-4">
                                    <form action="admin_inspectorList.php" method="get">
                                        <div class="input-group">
                                            <input type="search" name="searchTxt" class="form-control" placeholder="Search Name OR NIC">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="submit" name="search"><i class="fas fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <!-- Table -->
                            <table class="table">
                              <thead>
                                <tr>
                                    <th scope="col">NIC</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Schedule ID</th>
                                    <th scope='col'>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    if(isset($_GET['search']) && (strlen($_GET['searchTxt'])!=0)){
                                        $search =  mysqli_real_escape_string($con,$_GET['searchTxt']);
                                        
                                        $query = "SELECT i.*, v.`name`, d.`name` AS 'divi_name' FROM `voter` v, `inspector` i, `division` d WHERE i.`is_deleted` = 0 AND v.`nic` = i.`nic` AND v.`divi_id` = d.`id` AND (i.`nic` LIKE '{$search}%' OR v.`name` LIKE '{$search}%')";
                                    }else{
                                        $query = "SELECT i.*, v.`name`, d.`name` AS 'divi_name' FROM `voter` v, `inspector` i, `division` d WHERE i.`is_deleted` = 0 AND v.`nic` = i.`nic` AND v.`divi_id` = d.`id`";
                                    }

                                    $result_set = mysqli_query($con,$query);

                                    if ($result_set){
                                        if(mysqli_num_rows($result_set)>=1){
                                            while($inspector = mysqli_fetch_assoc($result_set)){
                                                echo "<tr>";
                                                echo "<td>".$inspector['nic']."</td>";
                                                echo "<td>".$inspector['name']."</td>";
                                                echo "<td>".$inspector['divi_name']."</td>";
                                                echo "<td>".$inspector['schedule_id']."</td>";

                                                echo "<td><a href='admin_inspectorList.php?id={$inspector['nic']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";

                                                echo "</tr>";

                                            }
                                        }else{
                                            echo "<tr><td><h4 class='text-danger'>No records</h4></td></tr>";
                                        }

                                    } else {
                                        echo "<tr><td><h4 class='text-danger'>No records</h4></td></tr>";
                                    }
                                  ?>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
        
    </body>

    </html>