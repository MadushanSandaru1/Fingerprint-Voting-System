<?php 
    
    require_once("../connection/connection.php") ;

    session_start();


    //calculate_votes
    if (isset($_POST['submit'])) {
        
        if ($_SESSION['election_name_en']=='Presidential Election') {

            $cand_nic_as_key = array_search('X', $_POST); 

            //$enc_cand_nic_as_key = ($cand_nic_as_key);
            $voter_nic =  ($_SESSION['nic']);

                   

           $recode_participate = "INSERT INTO `participate`(`schedule_id`, `voter_nic`) VALUES ({$_SESSION['inspector_schedule_id']} , '{$voter_nic}' )";

           echo $recode_participate;

            $recode_vote = "INSERT INTO `vote`(`schedule_id`, `candidate_id`, `preference`) VALUES ({$_SESSION['inspector_schedule_id']}, '{$cand_nic_as_key}' , 1)";

            echo $recode_vote;

            $recode_participate_result = mysqli_query($con,$recode_participate);
            $recode_vote_result = mysqli_query($con,$recode_vote);

            if ($recode_participate_result && $recode_vote_result) {
                header("location:vote_success_and_logout.php");
            }else{
                header("location:try_again.php");
            }
        }


    }



    if ($_SESSION['election_name_en']=='Presidential Election') {
        
        $get_cand_parties =  "SELECT c.`nic`,c.`party_id`, p.`symbol`, v.`name` as 'name_en' , c.`name_si`,c.`name_ta` FROM `candidate`c, `voter` v, `party` p WHERE c.`nic` = v.`nic` AND p.`id` = c.`party_id`";

    }else if ($_SESSION['election_name_en']=='Parliamentary Election') {
        
        $get_parties = "SELECT `id`, `name_en`, `name_si`, `name_ta`, `symbol`  FROM `party` WHERE  `is_deleted` = 0";

    } else if ($_SESSION['election_name_en']=='Provincial Council Elections') {
        
        $get_parties = "SELECT `id`, `name_en`, `name_si`, `name_ta`, `symbol`  FROM `party` WHERE  `is_deleted` = 0";

    } else if ($_SESSION['election_name_en']=='Local Authorities Election') {
        
        $get_parties = "SELECT `id`, `name_en`, `name_si`, `name_ta`, `symbol`  FROM `party` WHERE  `is_deleted` = 0";

    }

   

    //Get available parties
    $resultset = mysqli_query($con,$get_cand_parties);


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

            /*function highlight(){
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
            }*/


            mark_vote_btn123.vote_count = [3,2,1];
            
            function mark_vote_btn123(btn_id)
            {
                
                
                if (document.getElementById(btn_id).value==" ") {

                    if (mark_vote_btn123.vote_count.length>=1) {
                        document.getElementById(btn_id).value=mark_vote_btn123.vote_count.pop();
                        document.getElementById(btn_id).className = "btn btn-outline-danger";
                    }
                    
                }
                else{
              
                    mark_vote_btn123.vote_count.push(document.getElementById(btn_id).value);
                    document.getElementById(btn_id).value=" ";
                    document.getElementById(btn_id).className = "btn btn-outline-secondary";
                    mark_vote_btn123.vote_count.sort();
                    mark_vote_btn123.vote_count.reverse();
                    
                                     
                }
                
            }


            mark_vote_btnX.X = 0;
            function mark_vote_btnX(btn_id)
            {   
               
                
                if (document.getElementById(btn_id).value==" ") {

                    if(mark_vote_btnX.X<=0){
                        document.getElementById(btn_id).value="X";
                        document.getElementById(btn_id).className = "btn btn-outline-danger";
                        mark_vote_btnX.X = 1;
                    }
    
                }
                else{
                    
                    document.getElementById(btn_id).value=" ";
                    document.getElementById(btn_id).className = "btn btn-outline-secondary";
                    mark_vote_btnX.X = 0;
                      
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

                                    echo "<td class='align-middle'>";
                                    if ($_SESSION['language']=="S") {
                                        echo "<h5> {$party['name_si']} </h5>";
                                    }else if ($_SESSION['language']=="E") {
                                        echo "<h5> {$party['name_en']} </h5>";
                                    }else if ($_SESSION['language']=="T") {
                                        echo "<h5> {$party['name_ta']} </h5>";
                                    }
                                    echo "</td>";

                                    //echo "<input type='hidden' name='cand_nic' value=\"{$party['nic']}\" >";

                                    echo " <td class='align-middle text-center'> <input class=\"btn btn-outline-secondary\" type=\"text\" id=\"{$party['nic']}\" name=\"{$party['nic']}\" value=' ' onclick='mark_vote_btnX(\"{$party['nic']}\" )' style='width:80px;height:80px;font-size:30px' readonly  >  </td>";
                                    echo "</tr>";

                                   // echo "<tr>";
                                    //echo "<td><input type='submit' name='cancel_vote' ></td>";
                                    //echo "</tr>";


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
                                        echo "<td> <input class=\"btn btn-outline-secondary\" type='button' name='vote_btn' value='{$i}' onclick='mark_vote_btn123({$i})'>";
                                        echo "<input class=\"btn btn-outline-secondary\" type='button' id={$i} name='vote_btn' value=' ' onclick='mark_vote_btn123({$i})' > </td>";
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
                    
                    
                    <button type="submit" class="btn btn-primary vote float-right" name="submit"><img src="../img/elections.png"></button>
                </form>
            
            </div>
        </div>
    </body>
</html>