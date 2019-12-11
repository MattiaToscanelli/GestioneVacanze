<?php

class Database extends PDO{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;


    public function __construct()
    {
        try{
            $dns = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            parent::__construct($dns, $this->user, $this->pass);
            $this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }catch (PDOException $pdoe){
            header("Location:" . URL . "errore");
        }
    }
}

?>