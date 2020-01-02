<?php
    
    session_start();

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
            
            .card {
                background-image: linear-gradient(to right,  rgba(111,44,145,1),rgba(199,1,127,1));
            }
            
            a:hover .card {
                text-decoration: none;
                background-image: linear-gradient(to right,rgba(199,1,127,1), rgba(111,44,145,1));
            }
            
            a:hover {
                text-decoration: none;
            }
            
            input.pwd {
                outline: 0;
                border-width: 0 0 1px;
                border-color: darkgray;
            }
            
            .myBtn {
                flex: 1 1 auto;
                padding: 20px;
                text-align: center;
                text-transform: uppercase;
                transition: 0.5s;
                color: white;
                text-shadow: 0px 0px 10px rgba(0,0,0,0.2);
                border-radius: 15px;
                background-image: linear-gradient(to right, #6f2c91, #c7017f);
            }

            .myBtn:hover {
                background-image: linear-gradient(to right, #c7017f, #6f2c91);
                text-decoration: none;
                color: white;
            }
            
            .row {
                height: 80vh;
            }
            
        </style>
    </head>
    
    <body>
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']; ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']; ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']; ?></marquee>
        </nav>
        <div class="container">
            <div class="row mt-5 d-flex justify-content-around align-items-center">
                
                <a href="end.php" class="myBtn col-5" data-toggle="modal" data-target="#endElection"><h4>මැතිවරණය අවසන් කරන්න<br><br>தேர்தலை முடிக்கவும்<br><br>End the election</h4></a>
                
                <a href="" class="myBtn col-5"><h4>ප්‍රකාශිත ඡන්ද ප්‍රතිශතය<br><br>பதிவான வாக்குகளின் சதவீதம்<br><br>Percentage of votes cast</h4></a>
                
                <!-- The Modal -->
                <div class="modal" id="endElection">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="end.php" method="post" name="setting">
                                    <div class="form-group">
                                        <input type="password" class="form-control pwd" id="pwd" placeholder="Enter password" name="pwd">
                                    </div>
                                    <button type="submit" class="btn btn-primary"><img src="../img/ok.png"></button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </body>
</html>