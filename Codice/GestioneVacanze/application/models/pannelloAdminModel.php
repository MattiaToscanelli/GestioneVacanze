<?php

/**
 * Model oer gestire il pannello admin.
 */
class PannelloAdminModel{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var Util Oggetto che mi aiuta per eseguire le query;
     */
    private $util;

    /**
     * @var Validator Validatore degli input.
     */
    private $validator;

    /**
     * Metodo costruttore senza parametri, instanza le varibili $connection, $util e $connection.
     */
    function __construct(){
        require_once "application/libs/database.php";
        require_once "application/libs/validator.php";
        $this->connection = new Database();
        $this->util = new Util($this->connection);
        $this->validator = new Validator($this->connection);
    }

    /**
     * Metodo per ricavare tutti i dati degli utenti verificati.
     * @return array I dati degli utenti verificati.
     */
    public function getAll(){
        $selectUsers = "SELECT nome, cognome, numero_telefono, ore_lavoro, tipo, verificato, email FROM utente WHERE verifica_email=1 ORDER BY cognome";
        $users = $this->util->fetchAndExecute($selectUsers);
        return $users;
    }

    /**
     * Metodo per ricavare tutti i giorni disponibili per le lezioni.
     * @return array I giorni disponibili.
     */
    public function getAllDay(){
        $selectDays = "SELECT * FROM giorno ORDER BY giorno";
        $days = $this->util->fetchAndExecute($selectDays);
        return $days;
    }

    /**
     * Metodo per aggiungere un giorno per le lezioni.
     * @param $day Il giorno da aggiungere.
     * @param $userEmail La email di chi aggiunge il giorno.
     * @return bool True se la query è andata a buon fine, False se la query è fallita.
     */
    function addDay($day, $userEmail){
        if($this->validator->checkDateCalendarInsert($day)) {
            $dataN = explode("/", $day);
            $day = $dataN[2] ."-" .$dataN[1] ."-" .$dataN[0];
            $insertDay = "INSERT INTO giorno VALUES ('$day')";
            $this->util->fetchAndExecute($insertDay);
            $insertDay = "INSERT INTO aggiunge VALUES ('$userEmail','$day')";
            $this->util->fetchAndExecute($insertDay);
            return true;
        }else{
            return false;
        }
    }

    /**
     * Metodo per rimuovere un giorno lavorativo.
     * @param $day Il giorno da rimuovere.
     */
    function removeDay($day, $userEmail){
        $selectIdEvent = "SELECT id from lezione where giorno='$day'";
        $ids = $this->util->fetchAndExecute($selectIdEvent);
        foreach ($ids as $id){
            $query = "DELETE from assegna WHERE id_lezione='".$id[DB_LESSON_ID]."'";
            $this->util->fetchAndExecute($query);
            $query = "DELETE from lezione WHERE id='".$id[DB_LESSON_ID]."'";
            $this->util->fetchAndExecute($query);
        }
        $deleteAggiunge = "DELETE FROM aggiunge WHERE giorno='$day'";
        $this->util->fetchAndExecute($deleteAggiunge);
        $deleteDay = "DELETE FROM giorno WHERE giorno='$day'";
        $this->util->fetchAndExecute($deleteDay);
    }

    /**
     * Metodo per eliminare un utente.
     * @param $user La email dell'utente da eliminare.
     * @param $userEmail La email di chi effettua l'eliminazione.
     * @return bool
     */
    function deleteUser($user, $userEmail){
        if($user != $userEmail){
            $selectUsers = "DELETE FROM utente WHERE email='$user'";
            $this->util->fetchAndExecute($selectUsers);
            return true;
        }else{
            return false;
        }
    }

    /**
     * Metodo per modificare un utente.
     * @param $user La email dell'utente da modificare.
     * @param array $data I dati da modificare.
     * @param $userEmail L'utente che esegue la modifica.
     * @return bool True se la query è andata a buon fine, False se è fallita.
     */
    function modifyUser($user, array $data, $userEmail){
        if($this->validator->checkName($data[0]) && $this->validator->checkName($data[1]) &&
            $this->validator->checkNumber($data[2]) && $this->validator->checkVerify($data[4]) &&
            $this->validator->checkHours($data[3]) && $this->validator->checkType($data[5])) {
            $hours = 0;
            if($data[3] == '' || $data[5]!="Docente"){
                $hours = 0;
            }else{
                $hours = $data[3];
            }
            $verify = "";
            if($data[4] == "Verificato"){
                $verify = 1;
            }else if($data[4] == "Non verificato"){
                $verify = 0;
            }
            if($user != $userEmail){
                $selectUsers = "UPDATE utente SET nome='$data[0]', cognome='$data[1]',
                            numero_telefono='$data[2]', ore_lavoro=$hours,
                            tipo='$data[5]', verificato=$verify WHERE email='$user'";
                $this->util->fetchAndExecute($selectUsers);
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * Metodo per ricavare tutti i dati di un utente.
     * @param $user L'email dell'utente che si vuole ricavare i dati.
     * @param $userEmail L'utente che vuole modificare.
     * @return array|null True se la query è andata a buon fine, False se è fallita.
     */
    function getAllData($user, $userEmail){
        if($user != $userEmail){
            $selectUser = "SELECT * FROM utente WHERE email='$user'";
            $result = $this->util->fetchAndExecute($selectUser);
            if($result != null) {
                return $result;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    /**
     * Metodo per modificare le ore di lavoro a tutti i docenti.
     * @param $hours L'ora da impostare
     * @return bool True se la query è andata a buon fine, False se è fallita.
     */
    function modifyHours($hours){
        if($this->validator->checkHours($hours)){
            $updateUtente = "UPDATE utente SET ore_lavoro=$hours WHERE tipo='Docente'";
            $this->util->fetchAndExecute($updateUtente);
            return true;
        }
        return false;
    }

    /**
     * Metodo per rimuovere tutti i giorni di lavoro fino alla giornata odierna.
     */
    function removeAllDay(){
        $selectIdEvents = "SELECT id from lezione WHERE DATE(giorno) < DATE(NOW())";
        $ids = $this->util->fetchAndExecute($selectIdEvents);
        foreach ($ids as $id){
            $query = "DELETE from assegna WHERE id_lezione='".$id[DB_LESSON_ID]."'";
            $this->util->fetchAndExecute($query);
            $query = "DELETE from lezione WHERE id='".$id[DB_LESSON_ID]."'";
            $this->util->fetchAndExecute($query);
        }
        $deleteAggiunge = "DELETE FROM aggiunge WHERE DATE(giorno) < DATE(NOW())";
        $this->util->fetchAndExecute($deleteAggiunge);
        $deleteDay = "DELETE FROM giorno WHERE DATE(giorno) < DATE(NOW())";
        $this->util->fetchAndExecute($deleteDay);
    }
}

?>