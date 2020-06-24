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


    if(isset($_POST['filter'])){
        $election_schedule_id = $_POST['scheduleId'];
	} else {
        $election_schedule_id = "";
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Election District Results | FVS</title>
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
         
            $(document).ready(function(){
                $("#searchTxt").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("tbody tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
            
        </script>
        
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
                            <i class="fas fa-chart-pie fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Election District Results</big><br><small>Election Results</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-9'>
                                    
                                    <a href='admin_electionIslandResult.php'><button type='button' class='btn btn-outline-primary mr-3'><i class='fas fa-chart-pie'></i> All Island Results</button></a>
                                    <a href='admin_electionDivisionResult.php'><button type='button' class='btn btn-outline-primary'><i class='fas fa-chart-pie'></i> Division Results</button></a>
                                    
                                </div>
                                <div class="col-md-3">
                                    
                                </div>
                            </div>
                            
                            <br>
                            
                            <div class="row">
                                
                                <div class='col-md-2'>

                                    <h5>Schedule ID:</h5>

                                </div>
                                <div class="col-md-6">
                                    <form action="admin_electionDistrictResult.php" method="post">
                                        <div class="d-flex flex-row">
                                            <select class="form-control" name="scheduleId" required>
                                                <?php

                                                    $query = "SELECT s.*, e.`name_en` FROM `election_schedule` s, `election` e WHERE s.`is_deleted` = 0 AND s.`type` = e.`id` AND s.`date_to` < NOW() ORDER BY s.`date_from` DESC";

                                                    $result_set = mysqli_query($con,$query);

                                                    if (mysqli_num_rows($result_set) >= 1) {

                                                        echo "<option value=''>Schedule ID</option>";
                                                        while($schedule_id = mysqli_fetch_assoc($result_set)){
                                                            echo "<option value='".$schedule_id['id']."'>".$schedule_id['id']." - ".$schedule_id['name_en']." - ".$schedule_id['date_from']."</option>";
                                                        }

                                                    } else {
                                                        echo "<option value='".null."'>Empty</option>";
                                                    }

                                                ?>
                                            </select>
                                            
                                            <input type="submit" name="filter" value="Get Result" class='btn btn-outline-primary mx-3'>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <?php
                                if($election_schedule_id != ""){
                            ?>
                            
                            <br>
                            
                            <div class="row">
                                <div class='col-md-9'>
                                    
                                </div>
                                <div class="col-md-3">
                                    <form action="admin_electionDistrictResult.php" method="get">
                                        <div class="input-group">
                                            <input type="search" name="searchTxt" id="searchTxt" class="form-control" placeholder="Search">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <br>
                            
                            <!-- Table -->
                            <table class="table">
                              <tbody>
                                  <?php
                                  
                                    $query = "SELECT d.`id`, d.`name`, p.`id` AS 'prov_id', p.`name` AS 'prov_name' FROM `district` d, `province` p WHERE d.`prov_id` = p.`id`";

                                    $result_set = mysqli_query($con,$query);

                                    if (mysqli_num_rows($result_set) >= 1) {

                                        while($elecDistrict = mysqli_fetch_assoc($result_set)){
                                            echo "<tr>";
                                            echo "<th>".$elecDistrict['id']."</th>";
                                            echo "<td>".$elecDistrict['name']."</td>";
                                            echo "<td>".$elecDistrict['prov_id']." - ".$elecDistrict['prov_name']."</td>";
                                            echo "<td><a href='admin_electionResultView.php?scheduleId={$election_schedule_id}&districtId={$elecDistrict['id']}' class='btn btn-outline-primary btn-sm' data-toggle='tooltip' title='View Result' target='_blank'>View Results</a></td>";
                                            echo "<td><a href='../../report/tcpdf_lib/examples/election_result_report_format.php?scheduleId={$election_schedule_id}&districtId={$elecDistrict['id']}' class='btn btn-outline-primary btn-sm' data-toggle='tooltip' title='Get Results Report' target='_blank'>Get Results Report</a></td>";
                                            
                                            echo "</tr>";
                                            
                                        }

                                    } else {
                                        echo "<tr><td><h4 class='text-danger'>No records</h4></td></tr>";
                                    }
                                  ?>
                              </tbody>
                            </table>
                            
                            <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
        
    </body>

    </html>