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
            
        </style>
    </head>
    
    <body>
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | Type of election - 2019  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | මැතිවරණ වර්ගය - 2019 &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | தேர்தல் வகை - 2019 </marquee>
        </nav>
        <div class="container">
            
<!-- Default form login -->
<div class="row d-flex justify-content-around h-100">
<div class="col-5 mt-5">
<form class="text-center border border-primary p-5" action="#!">

<!-- Email -->
<input type="text" id="userId" class="form-control mb-4" placeholder="Id">

<!-- Password -->
<input type="password" id="pwd" class="form-control mb-4" placeholder="Password">

<!-- Sign in button -->
<a href="html/scan.html" class="myBtn my-4">ඇතුල් වන්න | உள்நுழைய | Log in</a>

</form>
</div>
</div>
<!-- Default form login -->
            
            
        </div>
    </body>
</html>