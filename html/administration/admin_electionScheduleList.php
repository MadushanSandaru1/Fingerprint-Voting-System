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


    if(isset($_GET['id'])) {
	    
        $id =  mysqli_real_escape_string($con,$_GET['id']);
        
        //deleting record
        $query = "UPDATE `election_schedule` SET is_deleted = 1 WHERE id = '{$id}' LIMIT 1";

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_electionScheduleList.php");
        }
        
	} 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Election Schedule List | FVS</title>
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
                            <i class="far fa-calendar-alt fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Election Schedule List</big><br><small>Election Schedule</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-9'>
                                    <a href='admin_addElectionSchedule.php' ><button type='button' class='btn btn-outline-primary'><i class='fas fa-plus'></i>  Add Election Schedule</button></a>
                                </div>
                                <div class="col-md-3">
                                    <form action="admin_electionScheduleList.php" method="get">
                                        <div class="input-group">
                                            <input type="search" name="searchTxt" id="searchTxt" class="form-control" placeholder="Search">
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
                                    <th scope="col">Election Type</th>
                                    <th scope="col">Date - From</th>
                                    <th scope="col">Date - To</th>
                                    <th scope='col'>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    $query = "SELECT s.*, e.`name_en` FROM `election_schedule` s, `election` e WHERE s.`is_deleted` = 0 AND s.`type` = e.`id` ORDER BY s.`date_from` DESC";

                                    $result_set = mysqli_query($con,$query);

                                    if (mysqli_num_rows($result_set) >= 1) {

                                        while($elecSchedule = mysqli_fetch_assoc($result_set)){
                                            echo "<tr>";
                                            echo "<td>".$elecSchedule['id']."</td>";
                                            echo "<td>".$elecSchedule['name_en']."</td>";
                                            echo "<td>".$elecSchedule['date_from']."</td>";
                                            echo "<td>".$elecSchedule['date_to']."</td>";
                                            
                                            if($elecSchedule['date_from'] > date('Y-m-d H:i:s')){
                                                echo "<td><a href='admin_editElectionSchedule.php?id={$elecSchedule['id']}'><i class='fas fa-edit mr-3' data-toggle='tooltip' title='Edit'></i></a><a href='admin_electionScheduleList.php?id={$elecSchedule['id']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";
                                            }
                                            
                                            echo "</tr>";
                                            
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