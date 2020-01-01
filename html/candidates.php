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
            
            .card {
                padding-left: 5px;
                width: 400px;
            }
            
            .card img {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            
            .vote {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 150px;
            }
        </style>
        
    </head>
    
    <body>
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center fixed-top">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | Type of election - 2019  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | මැතිවරණ වර්ගය - 2019 &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | தேர்தல் வகை - 2019 </marquee>
        </nav>
        <div class="container">
            <div class="row mt-5">
                <div class="col-12 mt-3">
                    <form class="border border-light p-5" action="candidates.html" method="post">
                        
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="number01" name="candidates">
                            <label class="custom-control-label" for="number01"><h5>01 - අපේක්ෂකයාගේ නම | வேட்பாளரின் பெயர் | Name of the candidate</h5></label>
                        </div>
                        
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="number02" name="candidates">
                            <label class="custom-control-label" for="number02"><h5>02 - අපේක්ෂකයාගේ නම | வேட்பாளரின் பெயர் | Name of the candidate</h5></label>
                        </div>
                        
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="number03" name="candidates">
                            <label class="custom-control-label" for="number03"><h5>03 - අපේක්ෂකයාගේ නම | வேட்பாளரின் பெயர் | Name of the candidate</h5></label>
                        </div>
                        
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="number04" name="candidates">
                            <label class="custom-control-label" for="number04"><h5>04 - අපේක්ෂකයාගේ නම | வேட்பாளரின் பெயர் | Name of the candidate</h5></label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary vote"><img src="../img/elections.png"></button>
                        
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>