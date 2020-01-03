<?php 
    
    require_once("../connection/connection.php") ;

    session_start();

    $get_parties = "SELECT `id`, `name_en`, `name_si`, `name_ta`,  `color`, `symbol`  FROM `party` WHERE  `is_deleted` = 0;";


    //Get available parties
    $resultset = mysqli_query($con,$get_parties);


 ?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="../img/logo.png"/>
        
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
        
        <script type="application/javascript">

            function highlight(){
                var table = document.getElementById('dataTable');
                for (var i=0;i < table.rows.length;i++){
                    table.rows[i].onclick= function () {
                        if(!this.hilite){
                            this.origColor=this.style.backgroundColor;
                            this.style.backgroundColor='#C7017F';
                            this.hilite = true;
                        }
                        else{
                            this.style.backgroundColor=this.origColor;
                            this.hilite = false;
                    }
                }
             }
            }


            mark_vote_btn.vote_count = [3,2,1];
            
            function mark_vote_btn(btn_id)
            {
                
                if (document.getElementById(btn_id).value==" ") {

                    if (mark_vote_btn.vote_count.length>=1) {
                        document.getElementById(btn_id).value=mark_vote_btn.vote_count.pop();
                        document.getElementById(btn_id).className = "btn btn-outline-danger";
                    }
    
                }
                else{
              
                    mark_vote_btn.vote_count.push(document.getElementById(btn_id).value);
                    document.getElementById(btn_id).value=" ";
                    document.getElementById(btn_id).className = "btn btn-outline-secondary";
                    mark_vote_btn.vote_count.sort();
                    mark_vote_btn.vote_count.reverse();
                   
                    
                }
                
            }



        </script>
    </head>
    
    <body>
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']; ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']; ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']; ?></marquee>
        </nav>
        
        <div class="container">
            <div class="row d-flex justify-content-around mt-5 border border-light">
                
                <form method="post" action="ballotPaper.php">
                    
                        <?php

                            if ($_SESSION['election_name_en']=='Presidential Election') {
                                
                                echo "<table class=\"table table-bordered table-responsive\" id=\"dataTable\">";
                                while ($party = mysqli_fetch_assoc($resultset)) {
                                    
                                    echo "<tr>";
                                    echo "<td><img src={$party['symbol']} class='card-img' style='width:100px;'> </td>";
                                    echo "<td class='align-middle'> 
                                            <h5> {$party['name_si']} </h5>
                                            <h5> {$party['name_ta']} </h5>
                                            <h5> {$party['name_en']} </h5>
                                         </td>";
                                    echo " <td class='align-middle text-center'> </td>";
                                    echo "</tr>";

                                }
                                echo "</table>";

                            }elseif ($_SESSION['election_name_en']=='Parliamentary Election') {
                                
                                echo "<table class=\"table table-bordered table-responsive\" id=\"dataTable\">";
                                while ($party = mysqli_fetch_assoc($resultset)) {

                                     /*echo "<tr onclick='highlight()'>
                                    <td scope='row'><img src={$party['symbol']} class='card-img' style='width:100px;'></td>
                                    <td class='align-middle'><h5>{$party['name_en']}</h5></td>
                                    <td class='align-middle text-center' style='width:130px;color:rgba(0, 0, 0, 0.0);'><font class='display-3 font-weight-bolder' id='a'>X</font></td>
                                    </tr>";*/

                                }
                                echo "</table>";

                                //
                                echo "<table class=\"table table-bordered table-responsive\" id=\"dataTable\">";
                                
                                    for ($i=1; $i < 30; $i++) { 

                                        if($i%6==1){echo "<tr>";}
                                        echo "<div class=\"btn-group\">";
                                        echo "<td> <input class=\"btn btn-outline-secondary\" type='button' name='vote_btn' value='{$i}' onclick='mark_vote_btn({$i})'>";
                                        echo "<input class=\"btn btn-outline-secondary\" type='button' id={$i} name='vote_btn' value=' ' onclick='mark_vote_btn({$i})' > </td>";
                                        echo "</div>";
                                        if($i%6==0){echo "</tr>";}

                                    } 
                                
                                echo "</table>";


                            }elseif ($_SESSION['election_name_en']=='Provincial Council Elections') {
                               
                                echo "<table class=\"table table-bordered table-responsive\" id=\"dataTable\">";
                                while ($party = mysqli_fetch_assoc($resultset)) {

                                     echo "<tr onclick='highlight()'>
                                    <td scope='row'><img src={$party['symbol']} class='card-img' style='width:100px;'></td>
                                    <td class='align-middle'><h5>{$party['name_en']}</h5></td>
                                    <td class='align-middle text-center' style='width:130px;color:rgba(0, 0, 0, 0.0);'><font class='display-3 font-weight-bolder' id='a'>X</font></td>
                                    </tr>";

                                }
                                echo "</table>";

                                //
                                echo "<table class=\"table table-bordered table-responsive\" id=\"dataTable\">";
                                
                                    for ($i=1; $i < 30; $i++) { 

                                        if($i%6==1){echo "<tr>";}
                                        echo "<div class=\"btn-group\">";
                                        echo "<td> <input class=\"btn btn-outline-secondary\" type='button' name='vote_btn' value='{$i}' onclick='mark_vote_btn({$i})'>";
                                        echo "<input class=\"btn btn-outline-secondary\" type='button' id={$i} name='vote_btn' value=' ' onclick='mark_vote_btn({$i})' > </td>";
                                        echo "</div>";
                                        if($i%6==0){echo "</tr>";}

                                    } 
                                
                                echo "</table>";

                            }elseif ($_SESSION['election_name_en']=='Local Authorities Election') {
                                
                                echo "<table class=\"table table-bordered table-responsive\" id=\"dataTable\">";
                                while ($party = mysqli_fetch_assoc($resultset)) {

                                     echo "<tr onclick='highlight()'>
                                    <td scope='row'><img src={$party['symbol']} class='card-img' style='width:100px;'></td>
                                    <td class='align-middle'><h5>{$party['name_en']}</h5></td>
                                    <td class='align-middle text-center' style='width:130px;color:rgba(0, 0, 0, 0.0);'><font class='display-3 font-weight-bolder' id='a'>X</font></td>
                                    </tr>";

                                }
                                echo "</table>";

                                //
                                echo "<table class=\"table table-bordered table-responsive\" id=\"dataTable\">";
                                
                                    for ($i=1; $i < 30; $i++) { 

                                        if($i%6==1){echo "<tr>";}
                                        echo "<div class=\"btn-group\">";
                                        echo "<td> <input class=\"btn btn-outline-secondary\" type='button' name='vote_btn' value='{$i}' onclick='mark_vote_btn({$i})'>";
                                        echo "<input class=\"btn btn-outline-secondary\" type='button' id={$i} name='vote_btn' value=' ' onclick='mark_vote_btn({$i})' > </td>";
                                        echo "</div>";
                                        if($i%6==0){echo "</tr>";}

                                    } 
                                
                                echo "</table>";
                            }

                            //<table class="table table-bordered table-responsive" id="dataTable">
                            /*while ($party = mysqli_fetch_assoc($resultset)){
                                echo "<tr onclick='highlight()'>
                                    <td scope='row'><img src={$party['symbol']} class='card-img' style='width:100px;'></td>
                                    <td class='align-middle'><h5>{$party['name_en']}</h5></td>
                                    <td class='align-middle text-center' style='width:130px;color:rgba(0, 0, 0, 0.0);'><font class='display-3 font-weight-bolder' id='a'>X</font></td>
                                    </tr>";
                            }*/
                            //</table>
                         ?>
                    
                    
                    <button type="submit" class="btn btn-primary vote float-right"><img src="../img/elections.png"></button>
                </form>
            
            </div>
        </div>
    </body>
</html>