<?php

/**
 * Model per cambiare la password.
 */
class CambiaPasswordModel{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var Util Oggetto che mi aiuta per eseguire le query;
     */
    private $util;

    /**
     * @var Validator Velidatore per vari input.
     */
    private $validator;

    /**
     * Metodo costruttore senza parametri, istanzia le variabili $connection, $util e $validator.
     */
    function __construct(){
        require_once "application/libs/database.php";
        require_once "application/libs/validator.php";
        $this->connection = new Database();
        $this->validator = new Validator($this->connection);
        $this->util = new Util($this->connection);
    }

    /**
     * Metodo per confermare la email quando si vuole cambiare la password.
     * @param $hash La hash per identificare la persona che ha verificato la email.
     * @param $email La email della persona che ha verificato la email.
     * @return bool True se l'identificazione dell'utente è andato a buone fine, False se non è andato a buon fine.
     */
    public function confirm($hash,$email){
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

    /**
     * Metodo per modificare la password.
     * @param $email La email di chi vuole modificare la password.
     * @param $password1 La nuova password che si vuole impostare.
     * @param $password2 Nuovamente la password che si vuole impostare
     * @return bool True se il cambiamento della password è andato a buone fine, False se non è andato a buon fine.
     */
    public function modify($email, $password1, $password2){
        if($this->validator->checkPassword($password1,$password2)){
            $password = password_hash($password1,PASSWORD_DEFAULT);
            $updateUsers = "UPDATE utente SET password='$password' WHERE email='$email'";
            $this->util->fetchAndExecute($updateUsers);
            return true;
        }
        return false;
    }
}