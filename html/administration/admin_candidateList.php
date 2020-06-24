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
	    
        $candidate_id =  mysqli_real_escape_string($con,$_GET['id']);
        
        //deleting record
        $query = "UPDATE `candidate` SET `is_deleted` = 1 WHERE `id` = '{$candidate_id}' LIMIT 1";

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_candidateList.php");
        }
        
	}

    if(isset($_POST['filter'])){
	    
        $schedule_id = $_POST['scheduleId'];
        
        if($_SESSION['administration_role']=='AEO'){
            $filter_query = "SELECT c.`id`, c.`nic`, c.`image`, v.`name`, c.`schedule_id`, e.`name_en`, YEAR(es.`date_from`) AS 'date_from', es.`date_from` AS 'start_time', p.`id` AS 'party_id', p.`name_en` AS 'party_name', d.`id` AS 'divi_id', d.`name` AS 'divi_name' FROM `voter` v, `candidate` c, `division` d, `district` dis, `election_schedule` es, `election` e, `party` p WHERE c.`is_deleted` = 0 AND v.`nic` = c.`nic` AND v.`divi_id` = d.`id` AND c.`party_id` = p.`id` AND c.`schedule_id` = es.`id` AND es.`type` = e.`id` AND d.`dist_id` = dis.`id` AND ((dis.`id` = {$_SESSION['administration_working_at']} AND e.`id` != 1) OR (e.`id` = 1)) AND c.`schedule_id` = {$schedule_id} ORDER BY es.`date_from` DESC";
        } else {
            $filter_query = "SELECT c.`id`, c.`nic`, c.`image`, v.`name`, c.`schedule_id`, e.`name_en`, YEAR(es.`date_from`) AS 'date_from', es.`date_from` AS 'start_time', p.`id` AS 'party_id', p.`name_en` AS 'party_name', d.`id` AS 'divi_id', d.`name` AS 'divi_name' FROM `voter` v, `candidate` c, `division` d, `district` dis, `election_schedule` es, `election` e, `party` p WHERE c.`is_deleted` = 0 AND v.`nic` = c.`nic` AND v.`divi_id` = d.`id` AND c.`party_id` = p.`id` AND c.`schedule_id` = es.`id` AND es.`type` = e.`id` AND d.`dist_id` = dis.`id` AND c.`schedule_id` = {$schedule_id} ORDER BY es.`date_from` DESC";
        }
        
	} else {
        if($_SESSION['administration_role']=='AEO'){
            $filter_query = "SELECT c.`id`, c.`nic`, c.`image`, v.`name`, c.`schedule_id`, e.`name_en`, YEAR(es.`date_from`) AS 'date_from', es.`date_from` AS 'start_time', p.`id` AS 'party_id', p.`name_en` AS 'party_name', d.`id` AS 'divi_id', d.`name` AS 'divi_name' FROM `voter` v, `candidate` c, `division` d, `district` dis, `election_schedule` es, `election` e, `party` p WHERE c.`is_deleted` = 0 AND v.`nic` = c.`nic` AND v.`divi_id` = d.`id` AND c.`party_id` = p.`id` AND c.`schedule_id` = es.`id` AND es.`type` = e.`id` AND d.`dist_id` = dis.`id` AND ((dis.`id` = {$_SESSION['administration_working_at']} AND e.`id` != 1) OR (e.`id` = 1)) ORDER BY es.`date_from` DESC";
        } else {
            $filter_query = "SELECT c.`id`, c.`nic`, c.`image`, v.`name`, c.`schedule_id`, e.`name_en`, YEAR(es.`date_from`) AS 'date_from', es.`date_from` AS 'start_time', p.`id` AS 'party_id', p.`name_en` AS 'party_name', d.`id` AS 'divi_id', d.`name` AS 'divi_name' FROM `voter` v, `candidate` c, `division` d, `district` dis, `election_schedule` es, `election` e, `party` p WHERE c.`is_deleted` = 0 AND v.`nic` = c.`nic` AND v.`divi_id` = d.`id` AND c.`party_id` = p.`id` AND c.`schedule_id` = es.`id` AND es.`type` = e.`id` AND d.`dist_id` = dis.`id` ORDER BY es.`date_from` DESC";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Candidate List | FVS</title>
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
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Candidate List</big><br><small>Candidate</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-9'>
                                    
                                    <?php
                                        if($_SESSION['administration_role']=='AEO' || $_SESSION['administration_role']=='ADMIN'){
                                    ?>
                                    <a href='admin_addCandidate.php' ><button type='button' class='btn btn-outline-primary'><i class='fas fa-plus'></i>  Add Candidate</button></a>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <form action="admin_candidateList.php" method="get">
                                        <div class="input-group">
                                            <input type="search" name="searchTxt" id="searchTxt" class="form-control" placeholder="Search">
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
                                    <form action="admin_candidateList.php" method="post">
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
                                    <th scope="col">Image</th>
                                    <th scope="col">NIC</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Party</th>
                                    <th scope="col">Schedule Id</th>
                                    <th scope='col'>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    $query = $filter_query;

                                    $result_set = mysqli_query($con,$query);

                                    if (mysqli_num_rows($result_set) >= 1) {

                                        while($candidate = mysqli_fetch_assoc($result_set)){
                                            echo "<tr>";
                                            echo "<td scope='row'><img src='".$candidate['image']."' style='height:60px;'></td>";
                                            echo "<td>".$candidate['nic']."</td>";
                                            echo "<td>".$candidate['name']."</td>";
                                            echo "<td>".$candidate['divi_id']." - ".$candidate['divi_name']."</td>";
                                            echo "<td>".$candidate['party_id']." - ".$candidate['party_name']."</td>";
                                            echo "<td>".$candidate['schedule_id']." - ".$candidate['name_en']." - ".$candidate['date_from']."</td>";
                                            
                                            if($_SESSION['administration_role']=='AEO' && $candidate['schedule_id']!=1 && $candidate['start_time'] > date('Y-m-d H:i:s')){
                                                echo "<td><a href='admin_editCandidate.php?id={$candidate['id']}'><i class='fas fa-edit mr-3' data-toggle='tooltip' title='Edit'></i></a><a href='admin_candidateList.php?id={$candidate['id']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";
                                            } else if($_SESSION['administration_role']=='ADMIN' && $candidate['schedule_id']==1 && $candidate['start_time'] > date('Y-m-d H:i:s')){
                                                echo "<td><a href='admin_editCandidate.php?id={$candidate['id']}'><i class='fas fa-edit mr-3' data-toggle='tooltip' title='Edit'></i></a><a href='admin_candidateList.php?id={$candidate['id']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";
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