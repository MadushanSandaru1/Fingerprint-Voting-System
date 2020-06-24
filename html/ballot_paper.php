<?php

    date_default_timezone_set('Asia/Colombo');

    session_start();

    require_once("../connection/connection.php") ;

    if(!isset($_SESSION['inspector_nic'])){
        header("location:../index.php");
    }

?>

<?php

    function voteInfoSendByEmail($email){
        
        $heading = "Election Commission of Sri Lanka";
        $message = "<h3>Have voted</h3><br>Dear Sir/Madam,<br><p>You have successfully voted for the ".$_SESSION['election_name_en'].".<br><br>ID of the polling center inspector:<b></b>".$_SESSION['inspector_nic']."</p><br>Thank You!<br><pre>Election Commission,<br>Election Secretariat,<br>Sarana Mawatha,<br>Rajagiriya,<br>Sri Lanka - 10107</pre>";

        require '../email/PHPMailerAutoload.php';
        $credential = include('../email/credential.php');      //credentials import

        $mail = new PHPMailer;
        $mail->isSMTP();                                    // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = $credential['user'];              // SMTP username
        $mail->Password = $credential['pass'];              // SMTP password
        $mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                  // TCP port to connect to
        $mail->setFrom($email);
        $mail->addAddress($email);                          // Name is optional

        $mail->addReplyTo('hello');

        $mail->isHTML(true);                                    // Set email format to HTML

        $mail->Subject = $heading;
        $mail->Body    = $message;
        $mail->AltBody = 'If you see this mail. please reload the page.';

        if(!$mail->send()) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

?>

<?php

    //cancel vote
    if (isset($_POST['cancel_vote'])) {
        
        $recode_participate = "INSERT INTO `participate` (`schedule_id`, `voter_nic`) VALUES ({$_SESSION['election_schedule_id']}, '{$_SESSION['voter_nic']}')";
        
        $recode_vote = "INSERT INTO `vote` (`schedule_id`, `candidate_id`, `divi_id`, `preference`) VALUES ({$_SESSION['election_schedule_id']}, NULL, {$_SESSION['voter_divi_id']} , 0)";
        
        $recode_participate_result = mysqli_query($con,$recode_participate);
        $recode_vote_result = mysqli_query($con,$recode_vote);
        
        voteInfoSendByEmail($_SESSION['voter_email']);
        
        header("location:voted_and_logout.php");
        
        /*Maintain logfile*/
        
        //Ideitify current date
        /*$curent_datetime = date('Y-m-d H:i:s');
        
        $logfile = fopen("file:///C:/ProgramData/".date('Y-m-d')."-".$_SESSION['election_name_en']."-canceled-log.txt", "a+");
        $log = "{$curent_datetime} {$_SESSION['election_schedule_id']} NULL {$_SESSION['voter_nic']} {$_SESSION['voter_divi_id']} 0";
        
        if ($recode_participate_result && $recode_vote_result) {
            fwrite($logfile, $log . "\n");
            fclose($logfile);
            header("location:vote_canceld.php");
        }else{
            fwrite($logfile, $log . " ERR\n");
            fclose($logfile);
            header("location:try_again.php");
        }*/
    }
    
    //submit votes
    if (isset($_POST['submit'])) {
        
        foreach ($_POST as $candidate_id => $vote_preference) {
            if($vote_preference >= 1 ) {
                
                $recode_vote = "INSERT INTO `vote` (`schedule_id`, `candidate_id`, `divi_id`, `preference`) VALUES ({$_SESSION['election_schedule_id']}, '{$candidate_id}', {$_SESSION['voter_divi_id']} , {$vote_preference})";
                $recode_vote_result = mysqli_query($con,$recode_vote);
                
            }
        }
        
        $recode_participate = "INSERT INTO `participate` (`schedule_id`, `voter_nic`) VALUES ({$_SESSION['election_schedule_id']}, '{$_SESSION['voter_nic']}')";
        
        $recode_participate_result = mysqli_query($con,$recode_participate);
        
        voteInfoSendByEmail($_SESSION['voter_email']);
        
        header("location:voted_and_logout.php");
        
        /*Maintain logfile*/
        
        //Ideitify current date
        /*$curent_datetime = date('Y-m-d H:i:s');
        
        $logfile = fopen("file:///C:/ProgramData/".date('Y-m-d')."-".$_SESSION['election_name_en']."-canceled-log.txt", "a+");
        $log = "{$curent_datetime} {$_SESSION['election_schedule_id']} NULL {$_SESSION['voter_nic']} {$_SESSION['voter_divi_id']} 0";
        
        if ($recode_participate_result && $recode_vote_result) {
            fwrite($logfile, $log . "\n");
            fclose($logfile);
            header("location:vote_canceld.php");
        }else{
            fwrite($logfile, $log . " ERR\n");
            fclose($logfile);
            header("location:try_again.php");
        }*/
    
    }

    if ($_SESSION['election_type']==1) {
        
        if ($_SESSION['voter_language']=="S") {
            $get_candidate_parties =  "SELECT c.`party_id`, p.`name_si` as 'party_name', p.`symbol`, c.`nic`, c.`name_si` as 'candidate_name' FROM `candidate` c, `voter` v, `party` p WHERE c.`nic` = v.`nic` AND p.`id` = c.`party_id` AND c.`schedule_id` = {$_SESSION['election_schedule_id']} AND c.`is_deleted` = 0 ORDER BY c.`party_id` ASC";
        } else if ($_SESSION['voter_language']=="E") {
            $get_candidate_parties =  "SELECT c.`party_id`, p.`name_en` as 'party_name', p.`symbol`, c.`nic`, v.`name` as 'candidate_name' FROM `candidate` c, `voter` v, `party` p WHERE c.`nic` = v.`nic` AND p.`id` = c.`party_id` AND c.`schedule_id` = {$_SESSION['election_schedule_id']} AND c.`is_deleted` = 0 ORDER BY c.`party_id` ASC";
        } else if ($_SESSION['voter_language']=="T") {
            $get_candidate_parties =  "SELECT c.`party_id`, p.`name_ta` as 'party_name', p.`symbol`, c.`nic`, c.`name_ta` as 'candidate_name' FROM `candidate` c, `voter` v, `party` p WHERE c.`nic` = v.`nic` AND p.`id` = c.`party_id` AND c.`schedule_id` = {$_SESSION['election_schedule_id']} AND c.`is_deleted` = 0 ORDER BY c.`party_id` ASC";
        }

    } else {
        
        if ($_SESSION['voter_language']=="S") {
            $get_candidate_parties =  "SELECT c.`party_id`, p.`name_si` as 'party_name', p.`symbol`, c.`nic`, c.`name_si` as 'candidate_name', c.`image` FROM `candidate` c, `voter` v, `party` p WHERE c.`nic` = v.`nic` AND p.`id` = c.`party_id` AND c.`schedule_id` = {$_SESSION['election_schedule_id']} AND v.`divi_id` = {$_SESSION['voter_divi_id']} AND c.`is_deleted` = 0 ORDER BY c.`party_id` ASC";
        } else if ($_SESSION['voter_language']=="E") {
            $get_candidate_parties =  "SELECT c.`party_id`, p.`name_en` as 'party_name', p.`symbol`, c.`nic`, v.`name` as 'candidate_name', c.`image` FROM `candidate` c, `voter` v, `party` p WHERE c.`nic` = v.`nic` AND p.`id` = c.`party_id` AND c.`schedule_id` = {$_SESSION['election_schedule_id']} AND v.`divi_id` = {$_SESSION['voter_divi_id']} AND c.`is_deleted` = 0 ORDER BY c.`party_id` ASC";
        } else if ($_SESSION['voter_language']=="T") {
            $get_candidate_parties =  "SELECT c.`party_id`, p.`name_ta` as 'party_name', p.`symbol`, c.`nic`, c.`name_ta` as 'candidate_name', c.`image` FROM `candidate` c, `voter` v, `party` p WHERE c.`nic` = v.`nic` AND p.`id` = c.`party_id` AND c.`schedule_id` = {$_SESSION['election_schedule_id']} AND v.`divi_id` = {$_SESSION['voter_divi_id']} AND c.`is_deleted` = 0 ORDER BY c.`party_id` ASC";
        }
    
    }

    //Get available parties
    $resultset = mysqli_query($con,$get_candidate_parties);

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
            
            .disabledCls {
                filter: blur(1px);
                pointer-events: none;
            }
        
        </style>
        
        <script type="application/javascript">

            //vote as 123(3 vote)
            mark_vote_btn123.vote_count = [3,2,1];
            
            function mark_vote_btn123(btn_id) {
                
                if (document.getElementById(btn_id).value==" ") {
                    if (mark_vote_btn123.vote_count.length>=1) {
                        document.getElementById(btn_id).value=mark_vote_btn123.vote_count.pop();
                        document.getElementById(btn_id).className = "btn btn-outline-danger";
                    }
                } else {
                    mark_vote_btn123.vote_count.push(document.getElementById(btn_id).value);
                    document.getElementById(btn_id).value=" ";
                    document.getElementById(btn_id).className = "btn btn-outline-secondary";
                    mark_vote_btn123.vote_count.sort();
                    mark_vote_btn123.vote_count.reverse();
                }
                
            }
            
            //vote as X(cross)
            mark_vote_btnX.X = 0;
            
            function mark_vote_btnX(btn_id) {
                
                if (document.getElementById(btn_id).value==" ") {
                    if(mark_vote_btnX.X<=0){
                        document.getElementById(btn_id).value="X";
                        document.getElementById(btn_id).className = "btn btn-outline-danger";
                        mark_vote_btnX.X = 1;
                    }
                } else{
                    document.getElementById(btn_id).value=" ";
                    document.getElementById(btn_id).className = "btn btn-outline-secondary";
                    mark_vote_btnX.X = 0;
                }
            
            }
            
            //tabel row disable
            /*$(document).ready(function() {
                $('tr td input').click( function() {
                    $('tr').not('.' + $(this).closest('tr').attr("class")).addClass("disabledCls");
                    if($('tr td input').val()==' '){
                        $('tr').removeClass("disabledCls");
                    }
                });
            });*/
        
        </script>
    </head>
    
    <body>
        
        <!-- Cancel Vote Modal -->
        <div class="modal fade" id="voteCancelModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <?php
                            if ($_SESSION['voter_language']=="S") {
                                echo "<h5 class='modal-title text-danger'>තහවුරු කිරීම</h5>";
                            } else if ($_SESSION['voter_language']=="E") {
                                echo "<h5 class='modal-title text-danger'>Confirmation</h5>";
                            } else if ($_SESSION['voter_language']=="T") {
                                echo "<h5 class='modal-title text-danger'>உறுதிப்படுத்தல்</h5>";
                            }
                        ?>
                        <button type="button" class="close  text-danger" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php
                            if ($_SESSION['voter_language']=="S") {
                                echo "<h3>ඔබේ ඡන්ද අවලංගු කිරීම තහවුරු කරනවාද?</h3>";
                            } else if ($_SESSION['voter_language']=="E") {
                                echo "<h3>Will you confirm your vote cancellation?</h3>";
                            } else if ($_SESSION['voter_language']=="T") {
                                echo "<h3>உங்கள் வாக்கு ரத்து செய்யப்பட்டதை உறுதி செய்வீர்களா?</h3>";
                            }
                        ?>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <form action="ballot_paper.php" method="post">
                        <?php
                            if ($_SESSION['voter_language']=="S") {
                                echo "<input type='submit' class='btn btn-success px-4 mr-3' value='ඔව්' name='cancel_vote' >";
                                echo "<input type='button' class='btn btn-danger px-4' value='නැත' data-dismiss='modal'>";
                            } else if ($_SESSION['voter_language']=="E") {
                                echo "<input type='submit' class='btn btn-success px-4 mr-3' value='Yes' name='cancel_vote' >";
                                echo "<input type='button' class='btn btn-danger px-4' value='No' data-dismiss='modal'>";
                            } else if ($_SESSION['voter_language']=="T") {
                                echo "<input type='submit' class='btn btn-success px-4 mr-3' value='ஆம்' name='cancel_vote' >";
                                echo "<input type='button' class='btn btn-danger px-4' value='இல்லை' data-dismiss='modal'>";
                            }
                        ?>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        
        <nav class="navbar navbar-expand-sm navbar-dark justify-content-center">
            <marquee class="navbar-brand lead" href="#"><img src="../img/elections.png"> | <?php echo $_SESSION['election_name_si']." - ".date('Y'); ?> &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_ta']." - ".date('Y'); ?>  &ensp; &ensp; &ensp;  &ensp; &ensp; &ensp;<img src="../img/elections.png"> | <?php echo $_SESSION['election_name_en']." - ".date('Y'); ?></marquee>
        </nav>
        
        <div class="container">
            <div class="row d-flex justify-content-around mt-5 border border-light">
                
                <form method="post" action="ballot_paper.php">
                    
                    <?php
                        //Presidential Election
                        if ($_SESSION['election_type']==1) {
                            echo "<table class='table table-bordered table-responsive' id='dataTable'>";

                            while ($party_info = mysqli_fetch_assoc($resultset)) {
                                echo "<tr>";
                                    echo "<td><img src='html/{$party_info['symbol']}' class='card-img' style='width:100px;'></td>";
                                    echo "<td class='align-middle'><h5>{$party_info['candidate_name']}</h5><br><h6 class='text-secondary'>{$party_info['party_name']}</h6></td>";
                                    //echo "<input type='hidden' name='cand_nic' value=\"{$party_info['nic']}\" >";
                                    echo "<td class='align-middle text-center'><input class='btn btn-outline-secondary' type='text' id='{$party_info['nic']}' name='{$party_info['nic']}' value=' ' onclick=\"mark_vote_btn123('{$party_info['nic']}')\" style='width:80px;height:80px;font-size:30px' readonly></td>";
                                echo "</tr>";
                            }
                                echo "<tr>";
                                if ($_SESSION['voter_language']=="S") {
                                    echo "<td colspan='3'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='ඡන්දය අවලංගු කරන්න'></td>";
                                } else if ($_SESSION['voter_language']=="T") {
                                    echo "<td colspan='3'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='வாக்குகளை ரத்துசெய்'></td>";
                                } else if ($_SESSION['voter_language']=="E") {
                                    echo "<td colspan='3'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='Cancel Vote'></td>";
                                }
                                echo "</tr>";

                            echo "</table>";

                        } elseif ($_SESSION['election_type']==2) {
                            
                            echo "<table class='table table-bordered table-responsive' id='dataTable'>";

                            while ($party_info = mysqli_fetch_assoc($resultset)) {
                                echo "<tr class='{$party_info['party_id']}'>";
                                    echo "<td><img src='html/{$party_info['symbol']}' class='card-img' style='width:100px;'></td>";
                                    echo "<td><img src='html/{$party_info['image']}' class='card-img' style='width:100px;'></td>";
                                    echo "<td class='align-middle'><h5>{$party_info['candidate_name']}</h5><br><h6 class='text-secondary'>{$party_info['party_name']}</h6></td>";
                                    //echo "<input type='hidden' name='cand_nic' value=\"{$party_info['nic']}\" >";
                                    echo "<td class='align-middle text-center'><input class='btn btn-outline-secondary' type='text' id='{$party_info['nic']}' name='{$party_info['nic']}' value=' ' onclick=\"mark_vote_btn123('{$party_info['nic']}')\" style='width:80px;height:80px;font-size:30px' readonly></td>";
                                echo "</tr>";
                            }
                                echo "<tr>";
                                if ($_SESSION['voter_language']=="S") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='ඡන්දය අවලංගු කරන්න'></td>";
                                } else if ($_SESSION['voter_language']=="T") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='வாக்குகளை ரத்துசெய்'></td>";
                                } else if ($_SESSION['voter_language']=="E") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='Cancel Vote'></td>";
                                }
                                echo "</tr>";

                            echo "</table>";

                        } elseif ($_SESSION['election_type']==3) {

                            echo "<table class='table table-bordered table-responsive' id='dataTable'>";

                            while ($party_info = mysqli_fetch_assoc($resultset)) {
                                echo "<tr class='{$party_info['party_id']}'>";
                                    echo "<td><img src='html/{$party_info['symbol']}' class='card-img' style='width:100px;'></td>";
                                    echo "<td><img src='html/{$party_info['image']}' class='card-img' style='width:100px;'></td>";
                                    echo "<td class='align-middle'><h5>{$party_info['candidate_name']}</h5><br><h6 class='text-secondary'>{$party_info['party_name']}</h6></td>";
                                    //echo "<input type='hidden' name='cand_nic' value=\"{$party_info['nic']}\" >";
                                    echo "<td class='align-middle text-center'><input class='btn btn-outline-secondary' type='text' id='{$party_info['nic']}' name='{$party_info['nic']}' value=' ' onclick=\"mark_vote_btn123('{$party_info['nic']}')\" style='width:80px;height:80px;font-size:30px' readonly></td>";
                                echo "</tr>";
                            }
                                echo "<tr>";
                                if ($_SESSION['voter_language']=="S") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='ඡන්දය අවලංගු කරන්න'></td>";
                                } else if ($_SESSION['voter_language']=="T") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='வாக்குகளை ரத்துசெய்'></td>";
                                } else if ($_SESSION['voter_language']=="E") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='Cancel Vote'></td>";
                                }
                                echo "</tr>";

                            echo "</table>";

                        } elseif ($_SESSION['election_type']==4) {
                            echo "<table class='table table-bordered table-responsive' id='dataTable'>";

                            while ($party_info = mysqli_fetch_assoc($resultset)) {
                                echo "<tr class='{$party_info['party_id']}'>";
                                    echo "<td><img src='html/{$party_info['symbol']}' class='card-img' style='width:100px;'></td>";
                                    echo "<td><img src='html/{$party_info['image']}' class='card-img' style='width:100px;'></td>";
                                    echo "<td class='align-middle'><h5>{$party_info['candidate_name']}</h5><br><h6 class='text-secondary'>{$party_info['party_name']}</h6></td>";
                                    //echo "<input type='hidden' name='cand_nic' value=\"{$party_info['nic']}\" >";
                                    echo "<td class='align-middle text-center'><input class='btn btn-outline-secondary' type='text' id='{$party_info['nic']}' name='{$party_info['nic']}' value=' ' onclick=\"mark_vote_btn123('{$party_info['nic']}')\" style='width:80px;height:80px;font-size:30px' readonly></td>";
                                echo "</tr>";
                            }
                                echo "<tr>";
                                if ($_SESSION['voter_language']=="S") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='ඡන්දය අවලංගු කරන්න'></td>";
                                } else if ($_SESSION['voter_language']=="T") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='வாக்குகளை ரத்துசெய்'></td>";
                                } else if ($_SESSION['voter_language']=="E") {
                                    echo "<td colspan='4'><input type='button' class='btn btn-outline-danger w-100' data-toggle='modal' data-target='#voteCancelModal' value='Cancel Vote'></td>";
                                }
                                echo "</tr>";

                            echo "</table>";
                        }
                    
                    ?>
                    
                    <button type="submit" class="btn btn-primary vote float-right mb-5" name="submit"><img src="../img/vote.png" height="80px"></button>
                </form>
            
            </div>
        </div>
        
    </body>
</html>