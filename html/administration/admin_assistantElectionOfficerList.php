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
        <title>Assistant Election Officer List | FVS</title>
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
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Assistant Election Officer List</big><br><small>Assistant Election Officer</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-9'>
                                    <a href='admin_changeAssistantElectionOfficer.php'><button type='button' class='btn btn-outline-primary mr-3'><i class='fas fa-plus'></i> Change Assistant Election Officer</button></a>
                                    <a href='../../report/tcpdf_lib/examples/aeo_report_format.php' target="_blank"><button type='button' class='btn btn-outline-primary'><i class='far fa-file-alt'></i>  Get Report</button></a>
                                </div>
                                <div class="col-md-3">
                                    <form action="admin_assistantElectionOfficerList.php" method="get">
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
                                    <th scope="col">District ID</th>
                                    <th scope="col">District Name</th>
                                    <th scope="col">NIC</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Contact</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    $query = "SELECT a.`dist_id`, d.`name` AS 'd_name', v.`nic`, v.`name`, v.`contact` FROM `assistant_election_officer` a, `voter` v, `district` d WHERE v.`nic` = a.`nic` AND a.`dist_id` = d.`id`";

                                    $result_set = mysqli_query($con,$query);

                                    if ($result_set){
                                        if(mysqli_num_rows($result_set)>=1){
                                            while($d_officer = mysqli_fetch_assoc($result_set)){
                                                echo "<tr>";
                                                echo "<th>".$d_officer['dist_id']."</th>";
                                                echo "<td>".$d_officer['d_name']."</td>";
                                                echo "<td>".$d_officer['nic']."</td>";
                                                echo "<td>".$d_officer['name']."</td>";
                                                echo "<td>".$d_officer['contact']."</td>";

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