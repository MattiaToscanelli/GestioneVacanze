<?php

/**
 * Classe che mi permette di eseguire le query in modo sicuro.
 */
class Util{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * Metodo costruttore con 1 parametri.
     * @param $connection Connessione per il database.
     */
    public function __construct($connection){
        $this->connection = $connection;
    }

    /**
     * Metodo per eseguire e organizzare una query in un array.
     * @param $query La query da eseguire.
     * @return array L'array con il risultato della query in un array.
     */
    public function fetchAndExecute($query){
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $pdo){
            header("Location:" . URL . "errore");
        }
    }

    /**
     * Metodo per rendere "pulito" un input.
     * @param $data Il dato da revisionare.
     * @return string Il dato revisionato.
     */
    public static function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}