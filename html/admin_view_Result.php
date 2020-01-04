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
    $party_query="SELECT vt.name as name ,sum(preference) as vote from `vote` v, `voter` vt WHERE vt.nic=v.candidate_id AND v.divi_id={$divi_id} GROUP by candidate_id";
    $party_result=$con->query($party_query);

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
                   while($row=$party_result->fetch_assoc()){
                        echo  "[' ".$row['name']."' ,".$row['vote']."],";
                   }
                   
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
          title: 'Result',
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
                            <span class="font-weight-bold"><big>
                                <?php
                                    $query="SELECT * FROM `division` WHERE id={$divi_id}";
                                    $divi_result=mysqli_query($con,$query);
                                    if($divi_result){
                                        $recode=mysqli_fetch_assoc($divi_result);
                                        echo "$recode[name]";
                                    }else{
                                        echo "error";
                                    }
                                ?>
                                Division Result</big><br><small>Result</small></span>
                        </div>
                    </div>
                    
                      <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
                    
                   <!--result table -->
                   <form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Party</th>
                                    <th scope="col">Vote</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $desable_query="Select count(preference) as cot from `vote` where preference=0";
                                    $desable_result=mysqli_query($con,$desable_query);
                                
                                    if($desable_result){
                                        $recode=mysqli_fetch_assoc($desable_result);
                                        $desable=$recode['cot'];
                                    }
                                
                                    $divi_query="SELECT count(divi_id) as cot_divi FROM `voter` WHERE divi_id={$divi_id};";
                                    $divi_result=mysqli_query($con,$divi_query);
                                
                                    if($divi_result){
                                        $recode=mysqli_fetch_assoc($divi_result);
                                        $all=$recode['cot_divi'];
                                        
                                        
                                    }
                                
                                    $dis_query="SELECT vt.name,sum(preference) as vote,p.name_en p_name from `vote` v, `voter` vt, candidate c, party p WHERE p.id=c.party_id AND c.nic=v.candidate_id AND vt.nic=v.candidate_id AND v.divi_id={$divi_id} GROUP by candidate_id";
                                    $dis_result=mysqli_query($con,$dis_query);
                                    if($dis_result){
                                        $c=1;
                                        $count_vort=0;
                                        while($recode=mysqli_fetch_assoc($dis_result)){
                                            echo "<tr>";
                                            echo "<td>".$c."</td>";
                                            echo "<td>".$recode['name']."</td>";
                                            echo "<td>".$recode['p_name']."</td>";
                                            echo "<td>".$recode['vote']."</td>";
                                            echo "</tr>";
                                            $c++;
                                            $count_vort=$count_vort+$recode['vote'];
                                            
                                        }
                                        $presentag=($count_vort/$all)*100;
                                        $last_pr=number_format($presentag, 2,'.','');
                                        echo "<tr>";
                                        echo "<td colspan='3' style='background-color:#caaee8;'>Total number of votes in Division</td>";
                                        echo "<td style='background-color:#caaee8;'> $all</td>";
                                         echo "</tr>";
                                        
                                        echo "<tr>";
                                        echo "<td colspan='3' style='background-color:#caaee8;'>Total number of votes castPercentage of votes cast</td>";
                                        echo "<td style='background-color:#caaee8;'>$count_vort</td>";
                                         echo "</tr>";
                                        
                                        echo "<tr>";
                                        echo "<td colspan='3' style='background-color:#caaee8;'>Number of invalid election results</td>";
                                        echo "<td style='background-color:#caaee8;'>$desable</td>";
                                         echo "</tr>";
                                        
                                        echo "<tr>";
                                        echo "<td colspan='3' style='background-color:#caaee8;'>Percentage of votes cast</td>";
                                        echo "<td style='background-color:#caaee8;'>$last_pr%</td>";
                                         echo "</tr>"; 
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