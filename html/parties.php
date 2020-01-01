<?php 
    
    require_once("../connection/connection.php") ;

    $get_parties = "SELECT `id`, `name_en`, `name_si`, `name_ta`,  `color`, `symbol`  FROM `party` WHERE  `is_deleted` = 0;";


    //Get available parties
    $resultset = mysqli_query($con,$get_parties);


 ?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- bootstrap css -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        
        <!-- bootstrap javascript -->
        <script src="../js/bootstrap.min.js"></script>
        
        <!-- javascript -->
        <script src="../js/jquery.min.js"></script>
        
        <style>
            body {
                background-image: url("../img/back.jpg");
                background-attachment: fixed;
                background-position: top;
                background-repeat: no-repeat;
                background-size: cover;
            }
            
            nav {
                background-image: linear-gradient(to right,  rgba(111,44,145,1),rgba(199,1,127,1));
            }
            
            .card {
                padding-left: 5px;
                width: 400px;
                color: black;
            }
            
            a:hover {
                text-decoration: none;
            }
            
            .card img {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    
    <body>
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center fixed-top">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | Type of election - 2019  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | මැතිවරණ වර්ගය - 2019 &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | தேர்தல் வகை - 2019 </marquee>
        </nav>
        <div class="container-fluid">
            <div class="row d-flex justify-content-around mt-5">
                    
                <!--a href="candidates.php">
                    <div class="card border-dark mt-4 ml-1" style="background-image: linear-gradient(to right, purple, white, white">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="../img/partySymbol/party_default.png" class="card-img">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title">පක්ෂයේ නම</h6>
                                    <h6 class="card-title">கட்சியின் பெயர்</h6>
                                    <h6 class="card-title">Name of the party</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a-->


                <?php

                    while ($party = mysqli_fetch_assoc($resultset)) {
                        
                        #var_dump($party);
                        echo "<a href=\"candidates.php?id={$party['id']}\">";
                        echo "<div class=\"card border-dark mt-4 ml-1\" style=\"background-image: linear-gradient(to right, {$party['color']}, white, white\">";
                        echo "<div class=\"row no-gutters\">";
                        echo "<div class=\"col-md-4\">";
                        echo "<img src={$party['symbol']} class=\"card-img\">";
                        echo "</div>";
                        echo "<div class=\"col-md-8\">";
                        echo "<div class=\"card-body\">";
                        echo "<h6 class=\"card-title\">{$party['name_si']}</h6>";
                        echo "<h6 class=\"card-title\">{$party['name_en']}</h6>";
                        echo "<h6 class=\"card-title\">{$party['name_ta']}</h6>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</a>";

                    }



                ?>
            
            </div>
        </div>
    </body>
</html>