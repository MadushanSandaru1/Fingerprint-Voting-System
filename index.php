<!DOCTYPE html>
<?php
     
     session_start();
     require_once("connection/connection.php");
     

     $err = "";

     if(isset($_POST['submit'])){

            //Get avilable elections
            $get_current_election = "SELECT `id`,`type`,`date_to` FROM `election_schedule` WHERE  '{$curent_datetime}' between `date_from` and `date_to` and `is_deleted`= 0";
            $get_current_election_result = mysqli_query($con,$get_current_election);

            if(mysqli_num_rows($get_current_election_result)==1){
                //////
            }


            $upper_nic = strtoupper($_POST['usr_nic']);
            $enc_pwd = sha1($_POST['usr_pwd']);
            $get_inspectors = "SELECT * FROM `inspector` WHERE `nic`='{$upper_nic}' AND `password`='{$enc_pwd}' ";
            $result_inspectors = mysqli_query($con,$get_inspectors);

           
            if (mysqli_num_rows($result_inspectors)==1) {

                //add inspector id to sessions
                $_SESSION['inspector_nic'] = mysqli_fetch_assoc($result_inspectors)['nic'];

                header("location:/FVS/html/scan.php");
            }
            else{
                $err = "Incorrect NIC or Password. Try again.";
            }
           
     }

   




?>

<html>
    <head>
        <title>FVS</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        
        <!-- bootstrap javascript -->
        <script src="js/bootstrap.min.js"></script>
        
        <!-- javascript -->
        <script src="js/jquery.min.js"></script>
        
        <style>
            body {
                background-image: url("img/back.jpg");
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
            
            .rowCenter {
                height: 80vh;
            }
            
        </style>
    </head>
    
    <body>
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="img/elections.png"> | Type of election - 2019  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="img/elections.png"> | මැතිවරණ වර්ගය - 2019 &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="img/elections.png"> | தேர்தல் வகை - 2019 </marquee>
        </nav>
        <div class="container">
            <div class="row rowCenter align-items-center">
                <div class="col-7 text-center mt-5">
                    <h2 class="fingerprint mt-5">ඇඟිලි සලකුණු ඡන්ද ක්‍රමය</h2>
                    <h2 class="fingerprint mt-4 mb-4">கைரேகை வாக்களிக்கும் முறை</h2>
                    <h2 class="fingerprint mt-4 mb-5">Fingerprint Voting System</h2>
                </div>
                <div class="col-5 mt-5">
                    <form class="text-center p-5" action="index.php" method="post">
                        <input type="text" id="nic" class="form-control mb-4" placeholder="NIC" name="usr_nic">
                        <input type="password" id="pwd" class="form-control mb-4" placeholder="Password" name="usr_pwd">
                        <input type="submit" class="btn btn-primary" name="submit" value="ඇතුල් වන්න | உள்நுழைய | Log in">
                        <p class="mt-4 text-danger"><?php echo $err; ?></p>
                    </form>

                </div>
            </div>
        </div>
        
    </body>
</html>