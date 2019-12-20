<?php

/**
 * Importo le classi per utilizzare PHPMailer.
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Unisco le classi per usufuire dei metodi di PHPMailer.
 */
require 'application/libs/PHPMailer/Exception.php';
require 'application/libs/PHPMailer/PHPMailer.php';
require 'application/libs/PHPMailer/SMTP.php';

class SendMail{

    /**
     * @var PHPMailer Instaza per utilizzare la classe PHPMailer.
     */
    private $mail;

    /**
     * @var string La email per inviare le mail.
     */
    private $username = EMAIL_EMAIL;

    /**
     * @var string La password per accedere alla mail.
     */
    private $password = PASSWORD_MAIL;

    /**
     * Metodo costruttore con 2 parametri.
     * Perpara il tutto per il login.
     * @param $username L'username per l'accesso alla email.
     * @param $password La password per l'accesso alla email.
     * @throws Exception Eccezione tirata se non riesce a collegarsi al client di posta elettronica.
     */
    function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 2;
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->username;
        $this->mail->Password = $this->password;
        $this->mail->CharSet = 'UTF-8';
        $this->mail->setFrom($this->username, "GestioneVacanze");
    }

    /**
     * Metodo per inviare una mail.
     * @param $email La email a cui si vuole inviare la mail.
     * @param $sub Oggetto della mail.
     * @param $body Il contenuto della mail.
     * @throws Exception Eccezione tirata se non riesce a collegarsi al client di posta elettronica.
     */
    public function mailSend($email, $sub, $body){
        $this->mail->addAddress($email);
        $this->mail->Subject = $sub;
        $this->mail->msgHTML($body);
        if(!$this->mail->send()){
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        }else{
            echo "Message sent!";
        }
    }
}