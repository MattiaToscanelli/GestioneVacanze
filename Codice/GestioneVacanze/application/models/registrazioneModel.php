<?php

/**
 * Model per la registrazione degli utenti.
 */
class RegistrazioneModel{

    /**
     * @var Il|string Nome dell'utente.
     */
    private $name = "";

    /**
     * @var Il|string Cognome dell'utente.
     */
    private $surname = "";

    /**
     * @var Il|string Numero di telefono dell'utente.
     */
    private $number = "";

    /**
     * @var La|string Email dell'utente.
     */
    private $email = "";

    /**
     * @var La|string Password dell'utente.
     */
    private $password1 = "";

    /**
     * @var Nuovamenre|string Nuovamente la passwor dell'utente.
     */
    private $password2 = "";

    /**
     * @var Database Connessione al database.
     */
    private $connection;

    /**
     * @var Validator Validatore degli input.
     */
    private $validator;

    /**
     * @var Util Oggetto che mi aiuta per eseguire le query;
     */
    private $util;

    /**
     * Metodo costrutto con 6 parametri. Instanzia le varibili $name, $surname, $number, $email, $password1 e $password2.
     * @param $name Il nome dell'utente.
     * @param $surname Il congnome dell'utente.
     * @param $number Il numero di telefono dell'utente.
     * @param $email La email dell'utente.
     * @param $password1 La password dell'utente.
     * @param $password2 Nuovamenre la password dell'utente.
     */
    public function __construct($name, $surname, $number, $email, $password1, $password2){
        require_once "application/libs/database.php";
        require_once "application/libs/validator.php";
        $this->connection = new Database();
        $this->name = $name;
        $this->surname = $surname;
        $this->number = $number;
        $this->email = $email;
        $this->password1 = $password1;
        $this->password2 = $password2;
        $this->validator = new Validator($this->connection);
        $this->util = new Util($this->connection);
    }

    /**
     * Metodo per verificare che tutti gli input nella registrazione sono validi.
     * @return bool True se sono tutti validi, False se non sono validi.
     */
    function checkAll(){
        return $this->validator->checkName($this->name) && $this->validator->checkName($this->surname) &&
            $this->validator->checkEmail($this->email) && $this->validator->checkNumber($this->number) &&
            $this->validator->checkPassword($this->password1,$this->password2);
    }

    /**
     * Metodo per inserire un utente all'interno del database.
     * @return bool True se la query è andata a buon fine, False se non è andata a buon fine.
     */
    function insertUser(){
        if($this->checkAll()) {
            $hash = md5(rand(1000,5000));
            require 'application/libs/sendMail.php';
            $body = "Benvenuto/a $this->name $this->surname,<br>
                     la rigranzio per essersi iscritto al sito web per la gestione delle lezioni durante le vacanze scolastiche!<br><br>
                     <a href='".URL."conferma/confirm/$hash/$this->email'> Per verificare la sua mail clicchi questo link!</a>";
            try{
                $s = new SendMail("gestione.vacanze2019@gmail.com","Progetto1");
                $s->mailSend($this->email,"Verifica la tua email",$body);
                $password = password_hash($this->password1, PASSWORD_DEFAULT);
                $insertUser = "INSERT INTO utente (email,nome,cognome,numero_telefono,ore_lavoro,tipo,verificato,password,verifica_email,hash_mail) 
                             VALUES ('$this->email','$this->name','$this->surname','$this->number',0,'Visualizzatore',0,'$password',0,'$hash')";
                $this->util->fetchAndExecute($insertUser);
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
?>