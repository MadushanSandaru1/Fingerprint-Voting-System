<?php
require('phpmailer/class.phpmailer.php');
$mail = new PHPMailer();
$subject = "Test Mail using PHP mailer";
$content = "<b>This is a test mail using PHP mailer class.</b>";
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port     = 587;  
$mail->Username = "your gmail username";
$mail->Password = "your gmail password";
$mail->Host     = "smtp.gmail.com";
$mail->Mailer   = "smtp";
$mail->SetFrom("vincy@phppot.com", "PHPPot");
$mail->AddReplyTo("vincy@phppot.com", "PHPPot");
$mail->AddAddress("recipient address");
$mail->Subject = $subject;
$mail->WordWrap   = 80;
$mail->MsgHTML($content);
$mail->IsHTML(true);

if(!$mail->Send()) 
	echo "Problem on sending mail";
else 
echo "Mail sent";
?>