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
        $query = "UPDATE `party` SET is_deleted = 1 WHERE id = '{$id}' LIMIT 1";

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_partyList.php");
        }
        
	} 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Party List | FVS</title>
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
                            <i class="fas fa-building fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Party List</big><br><small>Party</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-9'>
                                    <a href='admin_addParty.php' ><button type='button' class='btn btn-outline-primary mr-3'><i class='fas fa-plus'></i>  Add Party</button></a>
                                    <a href='../../report/tcpdf_lib/examples/party_report_format.php' target="_blank"><button type='button' class='btn btn-outline-primary'><i class='far fa-file-alt'></i>  Get Report</button></a>
                                </div>
                                <div class="col-md-3">
                                    <form action="admin_partyList.php" method="get">
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
                                    <th scope="col">Symbol</th>
                                    <th scope="col"></th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Secretary</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">Address</th>
                                    
                                    <th scope='col'>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    $query = "SELECT * FROM `party` WHERE `is_deleted` = 0 ORDER BY `name_en`";

                                    $result_set = mysqli_query($con,$query);

                                    if (mysqli_num_rows($result_set) >= 1) {

                                        while($party = mysqli_fetch_assoc($result_set)){
                                            echo "<tr>";
                                            echo "<td scope='row'><img src='".$party['symbol']."' style='height:60px;'></td>";
                                            echo "<td><i class='fas fa-circle' style='color:".$party['color'].";cursor: pointer;' data-toggle='tooltip' title='".$party['color']."' ></i></td>";
                                            echo "<td>".$party['name_en']."</td>";
                                            echo "<td>".$party['secretary_name']."</td>";
                                            echo "<td>".$party['contact']."</td>";
                                            echo "<td>".$party['start_date']."</td>";
                                            echo "<td>".$party['address']."</td>";
                                            
                                            echo "<td><a href='admin_editParty.php?id={$party['id']}'><i class='fas fa-edit mr-3' data-toggle='tooltip' title='Edit'></i></a><a href='admin_partyList.php?id={$party['id']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";
                                            
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