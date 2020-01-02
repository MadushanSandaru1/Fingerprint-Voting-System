<?php
    
    require_once("time_scheduler.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="../img/logo.png"/>
        
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        
        <style>
            body {
                background-image: url("../img/back.jpg");
                background-position: top;
                background-repeat: no-repeat;
                background-size: cover;
            }
            
            nav {
                background-image: linear-gradient(to right,  rgba(111,44,145,1),rgba(199,1,127,1));
            }
            
            .fingerprint {
                color: #6f2c91;
                font-weight: bold;
            }
            
            .setting {
                position: fixed;
                bottom: 5px;
                right: 5px;
            }
        
        </style>
    </head>
    
    <body>
        <?php
                                            
            $query = "SELECT es.*, e.`name_si`, e.`name_ta`, e.`name_en` FROM `election_schedule` es,`election` e WHERE es.`id` = {$_SESSION['inspector_schedule_id']} AND es.`type` = e.`id`";

            $result_set = mysqli_query($con,$query);

            if (mysqli_num_rows($result_set) >= 1) {

                $eName = mysqli_fetch_assoc($result_set);
                $_SESSION['election_name_si'] = $eName['name_si'];
                $_SESSION['election_name_ta'] = $eName['name_ta'];
                $_SESSION['election_name_en'] = $eName['name_en'];

            }

        ?>
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']; ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']; ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']; ?></marquee>
        </nav>
        
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="fingerprint mt-5">ඔබගේ ඇඟිලි සලකුණ ඇතුළත් කරන්න</h1>
                    <h1 class="fingerprint mt-4 mb-4">உங்கள் கைரேகையைச் செருகவும்</h1>
                    <h1 class="fingerprint mt-4 mb-5">Insert your fingerprint</h1>
                    <hr>
                    <a href="ballotPaper.php"><button type="button" class="btn btn-success">Matched</button></a><img src="../img/fingerprint.png" class="mt-5"><a href="try_again.php"><button type="button" class="btn btn-danger">Not matched</button></a>
                    <a href="#" class="setting" data-toggle="modal" data-target="#setting"><img src="../img/settings.png"></a>
                </div>
            </div>
        </div>
        
        <!-- The Modal -->
        <div class="modal" id="setting">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="setting.php" method="post" name="setting">
                            <div class="form-group">
                                <input type="password" class="form-control pwd" id="pwd" placeholder="Enter password" name="pwd">
                            </div>
                            <button type="submit" class="btn btn-primary"><img src="../img/ok.png"></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        
    </body>
</html>