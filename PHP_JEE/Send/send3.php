<?php
 
require 'class.phpmailer.php';

$mail = new PHPMailer();
$mail->IsHTML(true); // if you are going to send HTML formatted emails
$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
$mail->From = "Export";
$mail->FromName = "Sage";
$mail->addAddress("ronald2000fr@gmail.com","User 2");
$mail->Subject = "Versement distant";
$mail->Body = "Bien vouloir confirmer le montant de 10000 du client : lol";

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}?>