<?php 
    
    require_once("../connection/connection.php") ;

    session_start();
    $email=$_SESSION['voter_email'] ;
    
    //calculate_votes
    if (isset($_POST['submit'])){
        
        if ($_SESSION['election_type']==1) {

           
            $cand_nic_as_key = array_search('X', $_POST); 

            //$enc_cand_nic_as_key = ($cand_nic_as_key);
            $voter_nic =  ($_SESSION['voter_nic']);

           $recode_participate = "INSERT INTO `participate`(`schedule_id`, `voter_nic`) VALUES ({$_SESSION['election_schedule_id']} , '{$voter_nic}' )";

           $recode_vote = "INSERT INTO `vote`(`schedule_id`, `candidate_id`, `divi_id`, `preference`) VALUES ({$_SESSION['election_schedule_id']}, '{$cand_nic_as_key}' , {$_SESSION['voter_divi_id']} , 1)";


            $recode_participate_result = mysqli_query($con,$recode_participate);
            $recode_vote_result = mysqli_query($con,$recode_vote);


            /*Maintain logfile*/

                // Ideitify current date
            date_default_timezone_set("Asia/Colombo");
            $curent_datetime = date('Y-m-d H:i:s');

            $logfile = fopen("file:///C:/ProgramData/".date('Y-m-d')."-".$_SESSION['election_name_en']."-log.txt", "a+");
            $log = "{$curent_datetime} {$_SESSION['election_schedule_id']} {$cand_nic_as_key} {$voter_nic} {$_SESSION['voter_divi_id']} 1";
            
            

            /*________________*/

            if ($recode_participate_result && $recode_vote_result) {
                fwrite($logfile, $log . "\n");
                fclose($logfile);
                //***************************
                
                require '../email/PHPMailerAutoload.php';
            $credential = include('../email/credential.php');   //credentials import
            
            $mail = new PHPMailer;
                //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $credential['user']  ;           // SMTP username
            $mail->Password = $credential['pass']  ;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->setFrom($email);
            $mail->addAddress($email);             // Name is optional

            $mail->addReplyTo('hello');

            $mail->isHTML(true);                                  // Set email format to HTML
            $send1="";
            $send2="";
            $mail->Subject = "Election";
            $mail->Body    = "Has been successfully voted on";
            $mail->AltBody = 'If you see this mail. please reload the page.';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }else{
                echo "<script>alert('Your password send your Email')</script>";
            }
                
                //***************************
                
                header("location:vote_success_and_logout.php");
            }else{
                fwrite($logfile, $log . " ERR\n");
                fclose($logfile);
                header("location:try_again.php");
            }
        }


    }else if (isset($_POST['cancel_vote'])) {
        
         if ($_SESSION['election_type']==1) {

                $voter_nic = ($_SESSION['voter_nic']);

                $recode_participate = "INSERT INTO `participate`(`schedule_id`, `voter_nic`) VALUES ({$_SESSION['election_schedule_id']} , '{$voter_nic}' )";

               $recode_vote = "INSERT INTO `vote`(`schedule_id`, `candidate_id`, `divi_id`, `preference`) VALUES ({$_SESSION['election_schedule_id']}, NULL , {$_SESSION['voter_divi_id']} , 0)";



                $recode_participate_result = mysqli_query($con,$recode_participate);
                $recode_vote_result = mysqli_query($con,$recode_vote);


                /*Maintain logfile*/

                // Ideitify current date
                date_default_timezone_set("Asia/Colombo");
                $curent_datetime = date('Y-m-d H:i:s');

                $logfile = fopen("file:///C:/ProgramData/".date('Y-m-d')."-".$_SESSION['election_name_en']."-canceled-log.txt", "a+");
                $log = "{$curent_datetime} {$_SESSION['election_schedule_id']} NULL {$voter_nic} {$_SESSION['voter_divi_id']} 0";
                
                /*________________*/



                if ($recode_participate_result && $recode_vote_result) {
                    fwrite($logfile, $log . "\n");
                    fclose($logfile);
                    header("location:vote_canceld.php");
                }else{
                    fwrite($logfile, $log . " ERR\n");
                    fclose($logfile);
                    header("location:try_again.php");
                }
         }
    }



    if ($_SESSION['election_type']==1) {
        
        $get_cand_parties =  "SELECT c.`nic`,c.`party_id`, p.`symbol`, v.`name` as 'name_en' , c.`name_si`,c.`name_ta` FROM `candidate`c, `voter` v, `party` p WHERE c.`nic` = v.`nic` AND p.`id` = c.`party_id`";

    } else {
        
        $get_cand_parties = "SELECT `id`, `name_en`, `name_si`, `name_ta`, `symbol`  FROM `party` WHERE  `is_deleted` = 0";

    }

    //Get available parties
    $resultset = mysqli_query($con,$get_cand_parties);


 ?>

<!DOCTYPE html>
<html>
    <head>
        <title>FVS | Ballot Paper</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!--title icon-->
        <link rel="icon" type="image/ico" href="../img/logo.png"/>
        
        <!-- bootstrap css -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        
        <!-- bootstrap javascript -->
        <script src="../js/bootstrap.min.js"></script>
        
        <!-- javascript -->
        <script src="../js/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  
  

        
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
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']." - ".date('Y'); ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']." - ".date('Y'); ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']." - ".date('Y'); ?></marquee>
        </nav>
        
        <div class="container">
            <div class="row d-flex justify-content-around mt-5 border border-light">
                
                <form method="post" action="ballotPaper.php">
                    
                        <?php

                            if ($_SESSION['election_type']==1) {
                                
                                echo "<table class=\"table table-bordered table-responsive\" id=\"dataTable\">";
                                while ($party = mysqli_fetch_assoc($resultset)) {
                                    
                                    echo "<tr>";
                                    echo "<td><img src={$party['symbol']} class='card-img' style='width:100px;'> </td>";

                                    echo "<td class='align-middle'>";
                                    if ($_SESSION['voter_language']=="S") {
                                        echo "<h5> {$party['name_si']} </h5>";
                                    }else if ($_SESSION['voter_language']=="E") {
                                        echo "<h5> {$party['name_en']} </h5>";
                                    }else if ($_SESSION['voter_language']=="T") {
                                        echo "<h5> {$party['name_ta']} </h5>";
                                    }
                                    echo "</td>";

                                    //echo "<input type='hidden' name='cand_nic' value=\"{$party['nic']}\" >";

                                    echo " <td class='align-middle text-center'> <input class=\"btn btn-outline-secondary\" type=\"text\" id=\"{$party['nic']}\" name=\"{$party['nic']}\" value=' ' onclick='mark_vote_btnX(\"{$party['nic']}\" )' style='width:80px;height:80px;font-size:30px' readonly  >  </td>";
                                    echo "</tr>";

                                }
        

                               echo "<tr>";

                                echo "<td colspan='3'> <input type=\"button\" class=\"btn btn-outline-danger\" data-toggle=\"modal\" data-target=\"#myModal\" value='ඡන්දය අවලංගු කරන්න | cancel vote | வாக்குகளை ரத்துசெய்'> </td>";
                                echo "</tr>";


                                        echo "<!-- The Modal -->
                                          <div class=\"modal fade\" id=\"myModal\">
                                            <div class=\"modal-dialog modal-dialog-centered\">
                                              <div class=\"modal-content\">
                                              
                                                <!-- Modal Header -->
                                                <div class=\"modal-header\">
                                                  <h4 class=\"modal-title\">Message</h4>
                                                  <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                                </div>
                                                
                                                <!-- Modal body -->
                                                <div class=\"modal-body\">
                                                  ඔබේ ඡන්දය අවලංගු කිරීමට තහවුරු කරන්න<br>
                                                  confirm to cancel your vote<br>
                                                  உங்கள் வாக்குகளை ரத்து செய்ய உறுதிப்படுத்தவும்
                                                </div>
                                                
                                                <!-- Modal footer -->
                                                <div class=\"modal-footer\">
                                                  <input type=\"submit\" class=\"btn btn-danger\" value='Yes' name='cancel_vote' >
                                                  <input type=\"button\" class=\"btn btn-info\" data-dismiss=\"modal\" value='No'>
                                                </div>
                                                
                                              </div>
                                            </div>
                                          </div>";


                                echo "</table>";


                            }elseif ($_SESSION['election_type']==2) {
                                
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


                            }elseif ($_SESSION['election_type']==3) {
                               
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

                            }elseif ($_SESSION['election_type']==4) {
                                
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
                    
                    
                    <button type="submit" class="btn btn-primary vote float-right mb-5" name="submit"><img src="../img/vote.png" height="80px"></button>
                </form>
            
            </div>
        </div>
    </body>
</html>