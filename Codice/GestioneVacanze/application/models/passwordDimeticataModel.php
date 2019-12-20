<?php

/**
 * Model per la richiesta di una nuova password.
 */
class PasswordDimeticataModel{

    /**
     * @var Database Connessione al database.
     */
    private $connection;

    /**
     * @var La email dell'utente che vuole recuperare la password.
     */
    private $email;

    /**
     * @var Util Oggetto che mi aiuta per eseguire le query.
     */
    private $util;

    /**
     * Metodo costruttore con 1 parametro. Instanzia le varibaili $connection, $util e $email.
     * @param $email La email di chi vuole richiedere il recupero password.
     */
    function __construct($email){
        require_once "application/libs/database.php";
        $this->connection = new Database();
        $this->util = new Util($this->connection);
        $this->email = $email;
    }

    /**
     * Metodo per inviare una mail di recupero password.
     * @return bool True se la mail è stata inviata, False se la mail non è stata inviata.
     */
    function sendEmail(){
        $selectCheck = "select * from utente where email='$this->email'";
        $result = $this->util->fetchAndExecute($selectCheck);
        if($result != null) {
            $hash = md5(rand(1000,5000));
            $updateUsers = "UPDATE utente SET hash_mail='$hash' WHERE email='$this->email'";
            require 'application/libs/sendMail.php';
            $body = "Ciao ".$result[0][DB_USER_NAME]." ".$result[0][DB_USER_SURNAME].",<br>
                     Recentemente è stata richiesta la procedura di modifica password!<br><br>
                     <a href='".URL."cambiaPassword/resetPassword/$this->email/$hash'> Per modificare la tua password clicca questo link!</a>";
            try {
                $s = new SendMail();
                $s->mailSend($this->email, "Modifica la password", $body);
                $this->util->fetchAndExecute($updateUsers);
            } catch (Exception $e){
                header("Location: ".URL."errore");
                exit;
            }
            return true;
        }else{
            return false;
        }
    }

}