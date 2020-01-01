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


    if(isset($_GET['id'])) {
	    
        $id =  mysqli_real_escape_string($con,$_GET['id']);
        
        //deleting record
        $query = "UPDATE `candidate` SET is_deleted = 1 WHERE id = '{$id}' LIMIT 1";

        $result = mysqli_query($con,$query);

        if($result) {
            header("location:admin_candidateList.php");
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
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Candidate List</big><br><small>Candidate</small></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form">
                            <div class="row">
                                <div class='col-md-8'>
                                    <a href='admin_addCandidate.php' ><button type='button' class='btn btn-outline-primary'><i class='fas fa-plus'></i>  Add Candidate</button></a>
                                </div>
                                <div class="col-md-4">
                                    <form action="admin_candidateList.php" method="get">
                                        <div class="input-group">
                                            <input type="search" name="searchTxt" class="form-control" placeholder="Search">
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
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">NIC</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Party</th>
                                    <th scope="col">Division</th>
                                    <th scope="col">Schedule Id</th>
                                    <th scope='col'>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  
                                    if(isset($_GET['search']) && (strlen($_GET['searchTxt'])!=0)){
                                        $search =  mysqli_real_escape_string($con,$_GET['searchTxt']);
                                        
                                        $query = "SELECT c.`id`, c.`image`, v.`name`, c.`nic`, v.`contact`, c.`party_id`, c.`schedule_id`, v.`divi_id`  FROM `candidate` c, `voter` v  WHERE  c.`is_deleted` = 0 AND c.`nic` = v.`nic` AND v.`name` LIKE '{$search}%' OR c.`nic` LIKE '{$search}%' ORDER BY v.`name`";
                                    } else {
                                        $query = "SELECT c.`id`, c.`image`, v.`name`, c.`nic`, v.`contact`, c.`party_id`, c.`schedule_id`, v.`divi_id` FROM `candidate` c, `voter` v WHERE c.`is_deleted` = 0 AND c.`nic` = v.`nic` ORDER BY v.`name`";
                                    }

                                    $result_set = mysqli_query($con,$query);

                                    if (mysqli_num_rows($result_set) >= 1) {

                                        while($candidate = mysqli_fetch_assoc($result_set)){
                                            echo "<tr>";
                                            echo "<td scope='row'><img src='".$candidate['image']."' style='height:60px;'></td>";
                                            echo "<td>".$candidate['name']."</td>";
                                            echo "<td>".$candidate['nic']."</td>";
                                            echo "<td>".$candidate['contact']."</td>";
                                            echo "<td>".$candidate['party_id']."</td>";
                                            echo "<td>".$candidate['divi_id']."</td>";
                                            echo "<td>".$candidate['schedule_id']."</td>";
                                            
                                            echo "<td><a href='admin_editCandidate.php?id={$candidate['id']}'><i class='fas fa-edit mr-3' data-toggle='tooltip' title='Edit'></i></a><a href='admin_candidateList.php?id={$candidate['id']}' onclick=\"return confirm('Are you sure to delete this information ?');\"><i class='fas fa-trash-alt' data-toggle='tooltip' title='Delete' style='color:red;'></i></a></td>";
                                            
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