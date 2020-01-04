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
        $query = "UPDATE `division_officer` SET is_deleted = 1 WHERE nic='{$nic}'";

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_divisionOfficerList.php");
        }
        
	} 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Division officer List | FVS</title>
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
                            <i class="fas fa-user-tag fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Division officer List</big><br><small>Division officer</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-8'>
                                    <a href='admin_addDivisionOfficer.php' ><button type='button' class='btn btn-outline-primary'><i class='fas fa-plus'></i> Add Division Officer</button></a>
                                </div>
                                <div class="col-md-4">
                                    <form action="admin_divisionOfficerList.php" method="get">
                                        <div class="input-group">
                                            <input type="search" name="searchTxt" class="form-control" placeholder="Search NIC OR Name">
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
                                    <th scope="col">Contact</th>
                                    <th scope="col">Division</th>
                                    <th scope='col'>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    if(isset($_GET['search']) && (strlen($_GET['searchTxt'])!=0)){
                                        $search =  mysqli_real_escape_string($con,$_GET['searchTxt']);
                                        
                                        $query = "SELECT divi.name as divis ,v.nic as nic,v.name as name, v.contact as contact FROM `voter` v, `division_officer` g, `division` divi WHERE g.nic=v.nic AND g.work_divi_id=divi.id AND g.is_deleted=0 AND (v.name LIKE '{$search}%' OR v.nic LIKE '{$search}%')";
                                    }else{
                                        $query = "SELECT divi.name as divis ,v.nic as nic,v.name as name, v.contact as contact FROM `voter` v, `division_officer` g, `division` divi WHERE g.nic=v.nic AND g.work_divi_id=divi.id AND g.is_deleted=0";
                                    }

                                    $result_set = mysqli_query($con,$query);

                                    if ($result_set){
                                        if(mysqli_num_rows($result_set)>=1){
                                            while($d_officer = mysqli_fetch_assoc($result_set)){
                                                echo "<tr>";
                                                echo "<td>".$d_officer['nic']."</td>";
                                                echo "<td>".$d_officer['name']."</td>";
                                                echo "<td>".$d_officer['contact']."</td>";
                                                echo "<td>".$d_officer['divis']."</td>";

                                                echo "<td><a href='admin_divisionOfficerList.php?id={$d_officer['nic']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";

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