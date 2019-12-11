<?php

/**
 * Model per gestire il login.
 */
class LoginModel{

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
     * Metodo utilizzato per ricavare tutte le info di un utente, dunque per effettuare il login.
     * @param $email La email dell'utente che vuole accedere.
     * @return array I dati dell'utente.
     */
    function getUser($email){
        $selectAccess = "select * from utente where email='$email'";
        $result = $this->util->fetchAndExecute($selectAccess);
        return $result;
    }

    /**
     * Metodo utilizzato per sapere se la email inserita nella registrazione è già utilizzata.
     * @param $email La email dell'utente che vuole registrarsi.
     */
    function getUserA($email){
        $selectAccess = "select * from utente where email='$email'";
        $result = $this->util->fetchAndExecute($selectAccess);
        if(count($result)>0){
            echo 1;
        }else{
            echo 0;
        }
    }
}

?>