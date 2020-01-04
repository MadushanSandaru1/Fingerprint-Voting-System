<?php
    /* start the session */
	session_start();

    /* database connection page include */
    require_once('../connection/connection.php');

    /* if session is not set, redirect to login page */
    if(!isset($_SESSION['nic'])) {
	    header("admin_location:login.php");
	}

?>

<?php
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard | FVS</title>
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
        
        
        
        <style>
            .btn{
                background-color: #8767db;
            }
        </style>
        
        
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
                    
                    
                    <div class="row topic mb-4">
                        <div class="col-md-1 topic-logo">
                            <i class="fas fa-tachometer-alt fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <span class="font-weight-bold"><big>Election Division</big><br><small>Division</small></span>
                        </div>
                    </div>
                    
                   <!--result table -->
                   <form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">District</th>
                                    <th scope="col">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    $divi_id=$_GET['id'];
                                    
                                    $dis_query="SELECT * FROM `division` WHERE dist_id={$divi_id}";
                                    $dis_result=mysqli_query($con,$dis_query);
                                    if($dis_result){
                                        $c=1;
                                        while($recode=mysqli_fetch_assoc($dis_result)){
                                            echo "<tr>";
                                            echo "<td>".$c."</td>";
                                            echo "<td>".$recode['name']."</td>";
                                            echo "<td>"."<a href='admin_view_Result.php?id={$recode['id']}'><input type='button' class='btn' value='View Result'></a>"."</td>";
                                            echo "</tr>";
                                            $c++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </form>   
                    <!--result table -->
                    
                    
                </div>
            </main>
            <!-- page-content" -->
        </div>
        <!-- page-wrapper -->
        
    </body>

    </html>