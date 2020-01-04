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
    $divi_id=$_GET['id'];
    $party_query="select vt.name as name,SUM(`preference`) as vote from `vote` v, `voter` vt WHERE v.candidate_id=vt.nic AND vt.divi_id={$divi_id} GROUP BY `candidate_id`";
    $party_result=$con->query($party_query);
    //$party_result=mysqli_query($con,$party_query);

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
        
         
        <!--Chart-->
        
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['name','vote'],
                <?php
                  /* while($row=$party_result->fetch_assoc()){
                        echo  "[' ".$row['name']."' ,".$row['vote']."],";
                   }
                   */
                ?>
                
               /* ['Task', 'Hours per Day'],
                ['Wok',     11],
                ['Eat',      2],
                ['Commute',  2],
                ['Watch TV', 2],
                ['Sleep',    7]
                */
        ]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
        
        <!--*****-->
        
        
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
                            <span class="font-weight-bold"><big>Division Result</big><br><small>Result</small></span>
                        </div>
                    </div>
                    
                   <!--result table -->
                   <form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Vote</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    
                                    
                                    
                                    $dis_query="SELECT vt.name,sum(preference) as vote from `vote` v, `voter` vt WHERE vt.nic=v.candidate_id AND v.divi_id={$divi_id} GROUP by candidate_id";
                                    $dis_result=mysqli_query($con,$dis_query);
                                    if($dis_result){
                                        $c=1;
                                        while($recode=mysqli_fetch_assoc($dis_result)){
                                            echo "<tr>";
                                            echo "<td>".$c."</td>";
                                            echo "<td>".$recode['name']."</td>";
                                            echo "<td>".$recode['vote']."</td>";
                                           
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