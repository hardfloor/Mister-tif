<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailTo = "wpmusique@gmail.com";
    $mail = new PHPMailer(true);
    
    $array = array(
        "firstnameError" => "",
        "emailError"     => "",
        "subjectError"   => "",
        "messageError"   => "",
        "isSuccess"      => true
    );

    if(empty($_POST["firstname"])) {
        $array["firstnameError"] = "Vous n'avez pas mis votre nom!";
        $array["isSuccess"] = false;
    }

    if(empty($_POST["email"])) {
        $array["emailError"] = "Ceci n'est pas un email valide!";
        $array["isSuccess"] = false;
    }

    if(empty($_POST["subject"])) {
        $array["subjectError"] = "Vous n'avez pas dit de quoi vous vouliez parler!";
        $array["isSuccess"] = false;
    }

    if(empty($_POST["message"])) {
        $array["messageError"] = "Vous ne posez aucune question ou ne faites aucune remarque!";
        $array["isSuccess"] = false;
    }

    if ($array["isSuccess"] == false){
        echo json_encode($array);
        exit;
    }

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.sendinblue.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '';
        $mail->Password   = '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
    
        $mail->setFrom($_POST["email"], $_POST["firstname"]);
        $mail->addAddress($emailTo);
    
        $mail->isHTML(true);
        $mail->Subject = $_POST["subject"];
        $mail->Body    = $_POST["message"];
        $mail->AltBody = $_POST["message"];
    
        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo "error";
    }
}

?>