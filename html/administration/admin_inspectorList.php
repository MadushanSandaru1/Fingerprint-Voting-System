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
	    
        $inspector_id = $_GET['id'];
        
        //deleting record
        $query = "UPDATE `inspector` SET `is_deleted` = 1 WHERE `id` = '{$inspector_id}'";

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_inspectorList.php");
        }
        
	}

    if(isset($_POST['filter'])){
	    
        $schedule_id = $_POST['scheduleId'];
        
        if($_SESSION['administration_role']=='AEO'){
            $filter_query = "SELECT i.`id`, i.`nic`, v.`name`, i.`schedule_id`,e.`name_en`, YEAR(es.`date_from`) AS 'date_from', es.`date_from` AS 'start_time', d.`id` AS 'divi_id', d.`name` AS 'divi_name' FROM `voter` v, `inspector` i, `division` d, `district` dis, `election_schedule` es, `election` e WHERE i.`is_deleted` = 0 AND v.`nic` = i.`nic` AND v.`divi_id` = d.`id` AND i.`schedule_id` = es.`id` AND es.`type` = e.`id` AND d.`dist_id` = dis.`id` AND dis.`id` = {$_SESSION['administration_working_at']} AND es.`date_to` >= CURDATE() AND i.`schedule_id` = {$schedule_id} ORDER BY es.`date_from` DESC, i.`nic` ASC";
        } else {
            $filter_query = "SELECT i.`id`, i.`nic`, v.`name`, i.`schedule_id`,e.`name_en`, YEAR(es.`date_from`) AS 'date_from', es.`date_from` AS 'start_time', d.`id` AS 'divi_id', d.`name` AS 'divi_name' FROM `voter` v, `inspector` i, `division` d, `election_schedule` es, `election` e WHERE i.`is_deleted` = 0 AND v.`nic` = i.`nic` AND v.`divi_id` = d.`id` AND i.`schedule_id` = es.`id` AND es.`type` = e.`id` AND i.`schedule_id` = {$schedule_id} ORDER BY es.`date_from` DESC, i.`nic` ASC";
        }
        
	} else {
        if($_SESSION['administration_role']=='AEO'){
            $filter_query = "SELECT i.`id`, i.`nic`, v.`name`, i.`schedule_id`,e.`name_en`, YEAR(es.`date_from`) AS 'date_from', es.`date_from` AS 'start_time', d.`id` AS 'divi_id', d.`name` AS 'divi_name' FROM `voter` v, `inspector` i, `division` d, `district` dis, `election_schedule` es, `election` e WHERE i.`is_deleted` = 0 AND v.`nic` = i.`nic` AND v.`divi_id` = d.`id` AND i.`schedule_id` = es.`id` AND es.`type` = e.`id` AND d.`dist_id` = dis.`id` AND dis.`id` = {$_SESSION['administration_working_at']} AND es.`date_to` >= CURDATE() ORDER BY es.`date_from` DESC, i.`nic` ASC";
        } else {
            $filter_query = "SELECT i.`id`, i.`nic`, v.`name`, i.`schedule_id`,e.`name_en`, YEAR(es.`date_from`) AS 'date_from', es.`date_from` AS 'start_time', d.`id` AS 'divi_id', d.`name` AS 'divi_name' FROM `voter` v, `inspector` i, `division` d, `election_schedule` es, `election` e WHERE i.`is_deleted` = 0 AND v.`nic` = i.`nic` AND v.`divi_id` = d.`id` AND i.`schedule_id` = es.`id` AND es.`type` = e.`id` ORDER BY es.`date_from` DESC, i.`nic` ASC";
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
                            <i class="fas fa-user-tag fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Inspector List</big><br><small>Inspector</small></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-9'>
                                    
                                    <?php
                                        if($_SESSION['administration_role']=='AEO'){
                                    ?>
                                            <a href='admin_addInspector.php'><button type='button' class='btn btn-outline-primary'><i class='fas fa-plus'></i> Add Inspector</button></a>
                                    <?php
                                        }
                                    ?>
                                    
                                </div>
                                <div class="col-md-3">
                                    <form action="admin_inspectorList.php" method="get">
                                        <div class="input-group">
                                            <input type="search" name="searchTxt" id="searchTxt" class="form-control" placeholder="Search...">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <br>
                            
                            <div class="row">
                                
                                <div class='col-md-2'>

                                    <h5>Schedule ID:</h5>

                                </div>
                                <div class="col-md-6">
                                    <form action="admin_inspectorList.php" method="post">
                                        <div class="d-flex flex-row">
                                            <select class="form-control" name="scheduleId">
                                                <?php

                                                    $query = "SELECT s.*, e.`name_en` FROM `election_schedule` s, `election` e WHERE s.`is_deleted` = 0 AND s.`type` = e.`id` ORDER BY s.`date_from` DESC";

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
                                            
                                            <input type="submit" name="filter" value="Filter" class='btn btn-outline-primary mx-3'>
                                            
                                            <input type="submit" name="reset" value="Reset" class='btn btn-outline-primary mx-3'>
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
                                  
                                    $query = $filter_query;

                                    $result_set = mysqli_query($con,$query);

                                    if ($result_set){
                                        if(mysqli_num_rows($result_set)>=1){
                                            while($inspector = mysqli_fetch_assoc($result_set)){
                                                echo "<tr>";
                                                echo "<td>".$inspector['nic']."</td>";
                                                echo "<td>".$inspector['name']."</td>";
                                                echo "<td>".$inspector['divi_id']." - ".$inspector['divi_name']."</td>";
                                                echo "<td>".$inspector['schedule_id']." - ".$inspector['name_en']." ".$inspector['date_from']."</td>";

                                                if($_SESSION['administration_role']=='AEO' && $inspector['start_time'] > date('Y-m-d H:i:s')){
                                                    echo "<td><a href='admin_inspectorList.php?id={$inspector['id']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";
                                                } else {
                                                    echo "<td></td>";
                                                }

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