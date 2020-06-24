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

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Division List | FVS</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
        
        <script>
         
            $(document).ready(function(){
                $("#searchTxt").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("tbody tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
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
                            <i class="fas fa-bezier-curve"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Division List</big><br><small>Division</small></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-9'>
                                    
                                    <?php
                                        if($_SESSION['administration_role']=='ADMIN'){
                                    ?>
                                    <!--a href='admin_addDivision.php' ><button type='button' class='btn btn-outline-primary mr-3'><i class='fas fa-plus'></i>  Add Division</button></a-->
                                    <a href='../../report/tcpdf_lib/examples/division_report_format.php' target="_blank"><button type='button' class='btn btn-outline-primary'><i class='far fa-file-alt'></i>  Get Report</button></a>
                                    <?php
                                        }
                                    ?>
                                    
                                </div>
                                <div class="col-md-3">
                                    <form action="admin_DivisionList.php" method="get">
                                        <div class="input-group">
                                            <input type="search" name="searchTxt" id="searchTxt" class="form-control" placeholder="Search...">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <!-- Table -->
                            <table class="table">
                              <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">District</th>
                                    <th scope="col">Province</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    if($_SESSION['administration_role']=='AEO'){
                                        $query = "SELECT dv.`id` as 'id', dv.`name` as 'dv_name', d.`name` as 'd_name', d.`id` as 'd_id', p.`id` as 'p_id', p.`name` as 'p_name' FROM `province` p, `district` d, `division` dv WHERE p.`id` = d.`prov_id` AND d.`id` = dv.`dist_id` AND d.`id` = {$_SESSION['administration_working_at']}";
                                    } else {
                                        $query = "SELECT dv.`id` as 'id', dv.`name` as 'dv_name', d.`name` as 'd_name', d.`id` as 'd_id', p.`id` as 'p_id', p.`name` as 'p_name' FROM `province` p, `district` d, `division` dv WHERE p.`id` = d.`prov_id` AND d.`id` = dv.`dist_id`";
                                    }

                                    $result_set = mysqli_query($con,$query);

                                    if (mysqli_num_rows($result_set) >= 1) {
                                        $count=1;
                                        while($division = mysqli_fetch_assoc($result_set)){
                                            echo "<tr>";
                                            echo "<th>".$division['id']."</th>";
                                            echo "<td>".$division['dv_name']."</td>";
                                            echo "<td>".$division['d_id']." - ".$division['d_name']."</td>";
                                            echo "<td>".$division['p_id']." - ".$division['p_name']."</td>";
                                            
                                            echo "</tr>";
                                            
                                            $count++;
                                            
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