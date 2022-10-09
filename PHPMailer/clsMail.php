<?php
/////////////////////////////////////FUNCION DE PHPMAILER PARA CORREO/////////////////////////////////////////
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

class clsMail{

    private $mail = null;

    function __construct(){
    $this->mail=new PHPMailer();
    $this->mail->isSMTP();
    $this->mail->SMTPAuth = true;
    $this->mail->SMTPSecure ='tls';
    $this->mail->Host = "smtp.gmail.com";
    $this->mail->Port = 587;

    $this->mail->Username="axelayala2222@gmail.com";                           
    $this->mail->Password="bupgcormkrhugibc";
    }

    public function metEnviar(string $titulo, string $nombre, string $correo, string $asunto, string $bodyphp){ 
        $this->mail->setFrom("axelayala2222@gmail.com", $titulo);
        $this->mail->addAddress($correo, $nombre);
        $this->mail->Subject=$asunto;
        $this->mail->Body=$bodyphp;
        $this->mail->isHTML(true);
        $this->mail->CharSet="UTF-8";

        return $this->mail->send();
    }
}




?>