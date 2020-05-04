<?php
// send mail for user approval
function send_mail($receiver_email)
{
 
    //PHPMailer Object
    $mail = new PHPMailer; // php mailer class to be added to the root folder or preffered folder

    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    // optional
    // used only when SMTP requires authentication  
    $mail->SMTPAuth = true;
    $mail->Username = 'username/sender_email';
    $mail->Password = 'username password';

    //From email address and name
    $mail->From = "sender's email";
    $mail->FromName = "sender's name";

    //To address and name
    $mail->addAddress($receiver_email); //Recipient name is optional

    //Address to which recipient will reply
    $mail->addReplyTo("sender_email or other", "Reply");
    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Email test was Successful";
    $mail->Body = "<i>$msg</i>";
    $mail->AltBody = "This is the plain text version of the email content";

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message has been sent successfully";
    
    }
}
 

?>