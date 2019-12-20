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

    public function access($email, $password) {
        $result = $this->getUser($email);
        if (count($result) > 0) {
            if (password_verify($password, $result[0][DB_USER_PASSWORD])) {
                if ($result[0][DB_USER_VERIFY] == 1) {
                    return 1;
                } else {
                    return 2;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    /**
     * Metodo utilizzato per ricavare tutte le info di un utente, dunque per effettuare il login.
     * @param $email La email dell'utente che vuole accedere.
     * @return array I dati dell'utente.
     */
    public function getUser($email){
        $selectAccess = "select * from utente where email='$email'";
        $result = $this->util->fetchAndExecute($selectAccess);
        return $result;
    }

    /**
     * Metodo utilizzato per sapere se la email inserita nella registrazione è già utilizzata.
     * @param $email La email dell'utente che vuole registrarsi.
     */
    public function getUserA($email){
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