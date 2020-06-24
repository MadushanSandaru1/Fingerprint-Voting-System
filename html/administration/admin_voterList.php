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
	    
        $voter_id = $_GET['id'];
        
        //deleting record
        $query = "UPDATE `voter` SET `is_deleted` = 1 WHERE `nic` = '{$voter_id}'";

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_voterList.php");
        }
        
	}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Voter List | FVS</title>
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
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Voter List</big><br><small>Voter</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-9'>
                                    
                                    <?php
                                        if($_SESSION['administration_role']=='DO'){
                                    ?>
                                    <a href='admin_addVoter.php' ><button type='button' class='btn btn-outline-primary mr-3'><i class='fas fa-plus'></i>  Add Voter</button></a>
                                    
                                    <?php
                                            $schedule_status_query = "SELECT s.*, e.`name_en` FROM `election_schedule` s, `election` e WHERE s.`is_deleted` = 0 AND s.`type` = e.`id` AND s.`date_to` > NOW() ORDER BY s.`date_from` DESC";

                                            $schedule_status_result_set = mysqli_query($con,$schedule_status_query);

                                            if (mysqli_num_rows($schedule_status_result_set) >= 1) {
                                                $election_info = mysqli_fetch_assoc($schedule_status_result_set);
                                    ?>
                                    <a href='../../report/tcpdf_lib/examples/list_of_voters_for_election.php?date_from=<?php echo $election_info['date_from']; ?>' target="_blank"><button type='button' class='btn btn-outline-primary mr-3'><i class='far fa-file-alt'></i>  List of voters - <?php echo $election_info['name_en']." (".substr($election_info['date_from'],0,7).")"; ?></button></a>
                                    <?php
                                            }
                                    ?>
                                    
                                    <?php
                                        }
                                    ?>
                                    
                                    <a href='../../report/tcpdf_lib/examples/voter_report_format.php' target="_blank"><button type='button' class='btn btn-outline-primary'><i class='far fa-file-alt'></i>  Get Report</button></a>
                                
                                </div>
                                <div class="col-md-3">
                                    <form action="admin_voterList.php" method="get">
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
                                    <th scope="col">NIC</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">District</th>
                                    <th scope='col'>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    if($_SESSION['administration_role']=='ADMIN'){
                                        $query = "SELECT v.`nic`, v.`name`, v.`gender`, d.`id` AS 'divi_id', d.`name` AS 'divi_name', dis.`id` AS 'dist_id', dis.`name` AS 'dist_name' FROM `voter` v, `district` dis, `division` d WHERE v.`divi_id` =  d.`id` AND d.`dist_id` = dis.`id` AND v.`is_deleted` = 0 AND v.`is_died` = 0 AND TIMESTAMPDIFF(YEAR, v.`b_day`, CURDATE()) >= 18 ORDER BY v.`nic`";
                                    } else if($_SESSION['administration_role']=='AEO'){
                                        $query = "SELECT v.`nic`, v.`name`, v.`gender`, d.`id` AS 'divi_id', d.`name` AS 'divi_name', dis.`id` AS 'dist_id', dis.`name` AS 'dist_name' FROM `voter` v, `district` dis, `division` d WHERE v.`divi_id` =  d.`id` AND d.`dist_id` = dis.`id` AND dis.`id` = {$_SESSION['administration_working_at']} AND v.`is_deleted` = 0 AND v.`is_died` = 0 AND TIMESTAMPDIFF(YEAR, v.`b_day`, CURDATE()) >= 18 ORDER BY v.`nic`";
                                    } else if($_SESSION['administration_role']=='DO'){
                                        $query = "SELECT v.`nic`, v.`name`, v.`gender`, d.`id` AS 'divi_id', d.`name` AS 'divi_name', dis.`id` AS 'dist_id', dis.`name` AS 'dist_name' FROM `voter` v, `district` dis, `division` d WHERE v.`divi_id` =  d.`id` AND d.`dist_id` = dis.`id` AND v.`divi_id` = {$_SESSION['administration_working_at']} AND v.`is_deleted` = 0 AND v.`is_died` = 0 AND TIMESTAMPDIFF(YEAR, v.`b_day`, CURDATE()) >= 18 ORDER BY v.`nic`";
                                    }
                                    

                                    $result_set = mysqli_query($con,$query);

                                    if (mysqli_num_rows($result_set) >= 1) {

                                        while($voter = mysqli_fetch_assoc($result_set)){
                                            echo "<tr>";
                                            echo "<td>".$voter['nic']."</td>";
                                            echo "<td>".$voter['name']."</td>";
                                            echo "<td>".$voter['gender']."</td>";
                                            echo "<td>".$voter['divi_id']." - ".$voter['divi_name']."</td>";
                                            echo "<td>".$voter['dist_id']." - ".$voter['dist_name']."</td>";
                                            
                                            if($_SESSION['administration_role']=='DO'){
                                                echo "<td><a href='admin_editVoter.php?id={$voter['nic']}'><i class='fas fa-edit mr-3' data-toggle='tooltip' title='Edit'></i></a><a href='admin_voterList.php?id={$voter['nic']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";
                                            } else {
                                                echo "<td></td>";
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