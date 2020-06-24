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

    //election info
    $schedule_status_query = "SELECT s.*, e.`name_en` FROM `election_schedule` s, `election` e WHERE s.`is_deleted` = 0 AND s.`type` = e.`id` AND s.`id` = {$_GET['scheduleId']}";

    $schedule_status_result_set = mysqli_query($con,$schedule_status_query);

    if (mysqli_num_rows($schedule_status_result_set) >= 1) {
        $election_info = mysqli_fetch_assoc($schedule_status_result_set);
    }

    //location type
    if(isset($_GET['divisionId'])) {
        $location_type = "Division";
        $location_info_query = "SELECT `id`, `name` FROM `division` WHERE `id` = {$_GET['divisionId']}";
    } else if(isset($_GET['districtId'])) {
        $location_type = "District";
        $location_info_query = "SELECT `id`, `name` FROM `district` WHERE `id` = {$_GET['districtId']}";
    } else {
        header("location:admin_electionDistrictResult.php");
    }

    //location info
    $location_info_result_set = mysqli_query($con,$location_info_query);

    while($location_info = mysqli_fetch_assoc($location_info_result_set)){
        $location_id = $location_info['id'];
        $location_name = $location_info['name'];
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Election Results View | FVS</title>
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
                            <span class="font-weight-bold"><big>Election Results View</big><br><small>Election Results</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-12'>
                                    <a href="../../report/tcpdf_lib/examples/election_result_report_format.php?scheduleId=<?php echo $_GET['scheduleId']; ?>&<?php if(isset($_GET['divisionId'])) {echo 'divisionId='.$_GET['divisionId'];} else {echo 'districtId='.$_GET['districtId'];} ?>" class="btn btn-outline-primary btn-sm" data-toggle='tooltip' title='Get Results Report' target='_blank'>Get Results Report</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-md-12'>
                                    <center>
                                        <h3><?php echo $election_info['name_en']." (".substr($election_info['date_from'],0,7).")"; ?></h3>
                                        <h5><?php echo $location_name.' '.$location_type.' - '.$location_id; ?></h5>
                                    </center>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class='col-md-3'>
                                </div>
                                <div class='col-md-6'>
                                    <table class="table table-striped">
                                        
                                        <?php
                                        
                                            //votes info
                                            if(isset($_GET['divisionId'])) {
                                                $registered_vote_count_query = "SELECT COUNT(*) AS 'votersCount' FROM `voter` WHERE `is_died` = 0 AND `is_deleted` = 0 AND TIMESTAMPDIFF(YEAR, `b_day`, '".substr($election_info['date_from'],0,10)."') >= 18 AND `divi_id` = {$_GET['divisionId']}";
                                            } else if(isset($_GET['districtId'])) {
                                                $registered_vote_count_query = "SELECT COUNT(v.`nic`) AS 'votersCount' FROM `voter` v, `division` divi, `district` dist WHERE v.`divi_id` = divi.`id` AND divi.`dist_id` = dist.`id` AND v.`is_died` = 0 AND v.`is_deleted` = 0 AND TIMESTAMPDIFF(YEAR, v.`b_day`, '".substr($election_info['date_from'],0,10)."') >= 18 AND dist.`id` = {$_GET['districtId']}";
                                            }
                                        
                                            $registered_vote_count_result_set = mysqli_query($con,$registered_vote_count_query);

                                            if (mysqli_num_rows($registered_vote_count_result_set) >= 1) {
                                                $registered_vote_count = mysqli_fetch_assoc($registered_vote_count_result_set);
                                            }
                                        
                                            if(isset($_GET['divisionId'])) {
                                                $declared_vote_count_query = "SELECT count(p.`id`) AS 'declaredTotal' FROM `participate` p, `voter` v WHERE v.`nic` = p.`voter_nic` AND p.`schedule_id` = {$_GET['scheduleId']} AND v.`divi_id` = {$_GET['divisionId']}";
                                            } else if(isset($_GET['districtId'])) {
                                                $declared_vote_count_query = "SELECT count(p.`id`) AS 'declaredTotal' FROM `participate` p, `voter` v, `division` divi WHERE v.`nic` = p.`voter_nic` AND v.`divi_id` = divi.`id` AND p.`schedule_id` = {$_GET['scheduleId']} AND divi.`dist_id` = {$_GET['districtId']}";
                                            }

                                            $declared_vote_count_result_set = mysqli_query($con,$declared_vote_count_query);

                                            if (mysqli_num_rows($declared_vote_count_result_set) >= 1) {
                                                $declared_vote_count = mysqli_fetch_assoc($declared_vote_count_result_set);
                                            }
                                        
                                            if(isset($_GET['divisionId'])) {
                                                $rejected_vote_count_query = "SELECT SUM(case when `candidate_id` IS NULL then 1 else 0 end) AS 'rejectedTotal' FROM `vote` WHERE `schedule_id` = {$_GET['scheduleId']} AND `divi_id` = {$_GET['divisionId']}";
                                            } else if(isset($_GET['districtId'])) {
                                                $rejected_vote_count_query = "SELECT SUM(case when v.`candidate_id` IS NULL then 1 else 0 end) AS 'rejectedTotal' FROM `vote` v, `division` divi WHERE v.`divi_id` = divi.`id` AND v.`schedule_id` = {$_GET['scheduleId']} AND divi.`dist_id` = {$_GET['districtId']}";
                                            }

                                            $rejected_vote_count_result_set = mysqli_query($con,$rejected_vote_count_query);

                                            if (mysqli_num_rows($rejected_vote_count_result_set) >= 1) {
                                                $rejected_vote_count = mysqli_fetch_assoc($rejected_vote_count_result_set);
                                            }
                                        
                                        ?>
                                        
                                        <tbody>
                                            <tr>
                                                <td><h5>Registered Votes</h5></td>
                                                <td style="text-align:right"><h5><?php echo $registered_vote_count['votersCount']; ?></h5></td>
                                                <td style="text-align:right"></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Declared Votes</h5></td>
                                                <td style="text-align:right"><h5><?php echo $declared_vote_count['declaredTotal']; ?></h5></td>
                                                <td style="text-align:right"><h5><?php echo number_format(($declared_vote_count['declaredTotal']/$registered_vote_count['votersCount']*100),2); ?> %</h5></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Valid Votes</h5></td>
                                                <td style="text-align:right"><h5><?php echo $declared_vote_count['declaredTotal']-$rejected_vote_count['rejectedTotal']; ?></h5></td>
                                                <td style="text-align:right"><h5><?php echo number_format((($declared_vote_count['declaredTotal']-$rejected_vote_count['rejectedTotal'])/$declared_vote_count['declaredTotal']*100),2); ?> %</h5></td>
                                            </tr>
                                            <tr>
                                                <td><h5>Rejected Votes</h5></td>
                                                <td style="text-align:right"><h5><?php echo $rejected_vote_count['rejectedTotal']; ?></h5></td>
                                                <td style="text-align:right"><h5><?php echo number_format(($rejected_vote_count['rejectedTotal']/$declared_vote_count['declaredTotal']*100),2); ?> %</h5></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class='col-md-12'>
                                    
                                    <!-- result chart -->
                                    <center>
                                        <div id="piechart" style="width: 100%; height: 400px;"></div>
                                    </center>
                                    
                                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                    
                                    <script type="text/javascript">
                                        // Load google charts
                                        google.charts.load('current', {'packages':['corechart']});
                                        google.charts.setOnLoadCallback(drawChart);
                                        
                                        // Draw the chart and set the chart values
                                        function drawChart() {
                                            var data = google.visualization.arrayToDataTable([
                                                ['Task', 'Hours per Day'],
                                                <?php
                                                    if(isset($_GET['divisionId'])) {
                                                        $query = "SELECT p.`id`, p.`name_en`, p.`symbol`, p.`color`, COUNT(a.`id`) AS 'no_of_votes' FROM `vote` a, `candidate` c, `voter` v, `party` p WHERE a.`candidate_id` = c.`nic` AND c.`nic` = v.`nic` AND c.`party_id` = p.`id` AND a.`divi_id` = {$_GET['divisionId']} AND a.`schedule_id` = {$_GET['scheduleId']} GROUP BY p.`id` ORDER BY COUNT(a.`id`) DESC";
                                                    } else if(isset($_GET['districtId'])) {
                                                        $query = "SELECT p.`id`, p.`name_en`, p.`symbol`, p.`color`, COUNT(a.`id`) AS 'no_of_votes' FROM `vote` a, `candidate` c, `voter` v, `party` p, `division` divi WHERE a.`candidate_id` = c.`nic` AND c.`nic` = v.`nic` AND c.`party_id` = p.`id` AND a.`divi_id` = divi.`id` AND divi.`dist_id` = {$_GET['districtId']} AND a.`schedule_id` = {$_GET['scheduleId']} GROUP BY p.`id` ORDER BY COUNT(a.`id`) DESC";
                                                    }
                                                
                                                    $exec = mysqli_query($con,$query);
                                                
                                                    while($row = mysqli_fetch_array($exec)){
                                                        echo "['".$row['id']." - ".$row['name_en']."',".$row['no_of_votes']."],";
                                                    }
                                                ?>
                                            ]);
                                            
                                            // Optional; add a title and set the width and height of the chart
                                            //var options = {'title':'My Average Day', 'width':900, 'height':500};
                                            var options = {
                                                slices: {
                                                    <?php
                                                    
                                                        if(isset($_GET['divisionId'])) {
                                                            $query = "SELECT p.`id`, p.`name_en`, p.`symbol`, p.`color`, COUNT(a.`id`) AS 'no_of_votes' FROM `vote` a, `candidate` c, `voter` v, `party` p WHERE a.`candidate_id` = c.`nic` AND c.`nic` = v.`nic` AND c.`party_id` = p.`id` AND a.`divi_id` = {$_GET['divisionId']} AND a.`schedule_id` = {$_GET['scheduleId']} GROUP BY p.`id` ORDER BY COUNT(a.`id`) DESC";
                                                        } else if(isset($_GET['districtId'])) {
                                                            $query = "SELECT p.`id`, p.`name_en`, p.`symbol`, p.`color`, COUNT(a.`id`) AS 'no_of_votes' FROM `vote` a, `candidate` c, `voter` v, `party` p, `division` divi WHERE a.`candidate_id` = c.`nic` AND c.`nic` = v.`nic` AND c.`party_id` = p.`id` AND a.`divi_id` = divi.`id` AND divi.`dist_id` = {$_GET['districtId']} AND a.`schedule_id` = {$_GET['scheduleId']} GROUP BY p.`id` ORDER BY COUNT(a.`id`) DESC";
                                                        }

                                                        $exec = mysqli_query($con,$query);
                                                    
                                                        $i = 0;

                                                        while($row = mysqli_fetch_array($exec)){
                                                            echo "".$i.": {color: '".$row['color']."'},";
                                                            $i++;
                                                        }
                                                    ?>
                                                }
                                            };
                                            
                                            // Display the chart inside the <div> element with id="piechart"
                                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <!-- Table -->
                                <table class="table">
                                  <thead>
                                    <tr>
                                        <?php
                                            if($election_info['type'] == 1) {
                                        ?>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">Party Name</th>
                                        <th scope="col">Candidate NIC</th>
                                        <th scope="col">Candidate Name</th>
                                        <th scope="col">No. of Votes</th>
                                        <th scope="col">Percentage</th>
                                        <?php
                                            } else {
                                        ?>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">Candidate NIC</th>
                                        <th scope="col">Candidate Name</th>
                                        <th scope="col">Party</th>
                                        <th scope="col">No. of Votes</th>
                                        <th scope="col">Percentage</th>
                                        <?php
                                            }
                                        ?>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <?php

                                        if(isset($_GET['divisionId'])) {
                                            $votes_query = "SELECT a.`candidate_id`, v.`nic`, v.`name`, c.`image`, p.`id`, p.`name_en`, p.`symbol`, COUNT(a.`id`) AS 'no_of_votes' FROM `vote` a, `candidate` c, `voter` v, `party` p WHERE a.`candidate_id` = c.`nic` AND c.`nic` = v.`nic` AND c.`party_id` = p.`id` AND a.`divi_id` = {$_GET['divisionId']} AND a.`schedule_id` = {$_GET['scheduleId']} GROUP BY a.`candidate_id` ORDER BY COUNT(a.`id`) DESC";
                                        } else if(isset($_GET['districtId'])) {
                                            $votes_query = "SELECT a.`candidate_id`, v.`nic`, v.`name`, c.`image`, p.`id`, p.`name_en`, p.`symbol`, COUNT(a.`id`) AS 'no_of_votes' FROM `vote` a, `candidate` c, `voter` v, `party` p, `division` divi WHERE a.`candidate_id` = c.`nic` AND c.`nic` = v.`nic` AND c.`party_id` = p.`id` AND a.`divi_id` = divi.`id` AND divi.`dist_id` = {$_GET['districtId']} AND a.`schedule_id` = {$_GET['scheduleId']} GROUP BY a.`candidate_id` ORDER BY COUNT(a.`id`) DESC";
                                        }

                                        $votes_result_set = mysqli_query($con,$votes_query);

                                        if (mysqli_num_rows($votes_result_set) >= 1) {

                                            while($no_of_votes_info = mysqli_fetch_assoc($votes_result_set)){
                                                echo "<tr>";

                                                if($election_info['type'] == 1) {
                                                    echo "<th><img src='".$no_of_votes_info['symbol']."' style='height:60px;'></th>";
                                                    echo "<th><img src='".$no_of_votes_info['image']."' style='height:60px;'></th>";
                                                    echo "<td>".$no_of_votes_info['id']." - ".$no_of_votes_info['name_en']."</td>";
                                                    echo "<td>".$no_of_votes_info['nic']."</td>";
                                                    echo "<td>".$no_of_votes_info['name']."</td>";
                                                    echo "<td>".$no_of_votes_info['no_of_votes']."</td>";
                                                    echo "<td>".number_format(($no_of_votes_info['no_of_votes']/($declared_vote_count['declaredTotal']-$rejected_vote_count['rejectedTotal'])*100),2)." %</td>";
                                                } else {
                                                    echo "<th><img src='".$no_of_votes_info['symbol']."' style='height:60px;'></th>";
                                                    echo "<th><img src='".$no_of_votes_info['image']."' style='height:60px;'></th>";
                                                    echo "<td>".$no_of_votes_info['nic']."</td>";
                                                    echo "<td>".$no_of_votes_info['name']."</td>";
                                                    echo "<td>".$no_of_votes_info['id']." - ".$no_of_votes_info['name_en']."</td>";
                                                    echo "<td>".$no_of_votes_info['no_of_votes']."</td>";
                                                    echo "<td>".number_format(($no_of_votes_info['no_of_votes']/($declared_vote_count['declaredTotal']-$rejected_vote_count['rejectedTotal'])*100),2)." %</td>";
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
                    
                </div>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
        
    </body>

    </html>