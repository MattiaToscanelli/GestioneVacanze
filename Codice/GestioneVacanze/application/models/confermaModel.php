<?php

/**
 * Model per confermare la email.
 */
class ConfermaModel{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var Util Oggetto che mi aiuta per eseguire le query;
     */
    private $util;

    /**
     * Metodo costruttore senza parametri, instanza le varibili $connection e $util.
     */
    function __construct(){
        require_once "application/libs/database.php";
        $this->connection = new Database();
        $this->util = new Util($this->connection);
    }

    /**
     * Metodo per confermare la email.
     * @param $hash La hash per identificare la persona che ha verificato la email.
     * @param $email La email della persona che ha verificato la email.
     * @return bool True se la email è stata confermata, False se non è stata confermata.
     */
    function confirm($hash,$email){
        $selectCheck = "select * from utente where email='$email' AND hash_mail='$hash'";
        $result = $this->util->fetchAndExecute($selectCheck);
        if($result != null) {
            $updateUsers = "UPDATE utente SET hash_mail='0', verifica_email=1 WHERE email='$email'";
            $this->util->fetchAndExecute($updateUsers);
            return true;
        }else{
            return false;
        }
    }

}