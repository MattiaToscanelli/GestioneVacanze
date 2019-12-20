<?php

/**
 * Model per gestire il calendario.
 */
class CalendarioModel{

    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var Util Oggetto che mi aiuta per eseguire le query;
     */
    private $util;

    /**
     * Metodo costruttore senza parametri, istazia le variabili $connection e $util.
     */
    public function __construct(){
        require_once "application/libs/database.php";
        $this->connection = new Database();
        $this->util = new Util($this->connection);
    }

    /**
     * Metodo per caricare tutte le lezioni sul calendario.
     * @param $flag Flag = null se si devono caricare tutte le lezioni, Flag = 1 se bisgnoa caricare solo ple proprie
     * lezioni.
     */
    public function loadEvents($flag){
        $data = array();
        $query = "SELECT * FROM giorno WHERE DATE(giorno) >= DATE(NOW())";
        $result = $this->util->fetchAndExecute($query);
        foreach($result as $row) {
            $data[] = array(
                'groupId'   => 'availableForLesson',
                'start'   => $row[DB_LESSON_DAY]."T"."08:00:00",
                'end'   => $row[DB_LESSON_DAY]."T"."17:00:00",
                'rendering' => 'background',
            );
        }
        $query = "SELECT id, CONCAT(l.nome,' (',u.cognome, ')') as 'nome', ora_inizio, ora_fine, giorno, a.email 
                    FROM lezione l, assegna a, utente u 
                    WHERE l.id = a.id_lezione 
                    AND u.email = a.email 
                    AND DATE(l.giorno) >= DATE(NOW()) 
                    ORDER BY l.id;";
        $result = $this->util->fetchAndExecute($query);
        foreach($result as $row) {
            if($row[DB_USER_EMAIL]!=$_SESSION[SESSION_EMAIL]) {
                if($flag == null) {
                    $data[] = array(
                        'id' => $row[DB_LESSON_ID],
                        'title' => $row[DB_LESSON_NAME],
                        'start' => $row[DB_LESSON_DAY] . "T" . $row[DB_LESSON_START],
                        'end' => $row[DB_LESSON_DAY] . "T" . $row[DB_LESSON_END],
                        'constraint' => 'availableForLesson',
                    );
                }
            }else{
                $data[] = array(
                    'id'   => $row[DB_LESSON_ID],
                    'title'   => $row[DB_LESSON_NAME],
                    'start'   => $row[DB_LESSON_DAY]."T".$row[DB_LESSON_START],
                    'end'   => $row[DB_LESSON_DAY]."T".$row[DB_LESSON_END],
                    'constraint' => 'availableForLesson',
                    'color' => 'purple',
                );
            }
        }
        echo json_encode($data);
    }

    /**
     * Metodo per inserire una nuova lezione.
     * @param $title Nome della lezione.
     * @param $start Ora di inizio della lezione.
     * @param $end Ora di fine della lezione.
     * @param $email Email del docente che vuole inserire una lezione.
     */
    public function insertEvents($title, $start, $end, $email){
        $date = explode(" ", $start)[0];
        $selectDay = "SELECT * FROM giorno WHERE giorno='$date'";
        $day = $this->util->fetchAndExecute($selectDay);
        if($day != null) {
            $selectEvent = "SELECT * FROM lezione WHERE giorno='$date'";
            $event = $this->util->fetchAndExecute($selectEvent);
            if (count($event) < 2) {
                if ($this->checkOverlap(null,explode(" ", $start)[1],explode(" ", $end)[1],$date) == 0){
                    $query = "INSERT INTO lezione VALUES (null, '$title', '$start', '$end', '$date')";
                    $this->util->fetchAndExecute($query);
                    $selectEvent = "SELECT * FROM lezione WHERE giorno='$date' and ora_inizio='$start'";
                    $event = $this->util->fetchAndExecute($selectEvent);
                    $id = $event[0][DB_LESSON_ID];
                    $query = "INSERT INTO assegna VALUES ('" . $email . "', '$id')";
                    $this->util->fetchAndExecute($query);
                    $diff = $this->getDiffHour(explode(" ", $start)[1], explode(" ", $end)[1]);
                    if($this->getHours($email)-$diff > 0){
                        $query = "UPDATE utente set ore_lavoro=ore_lavoro-$diff where email='$email'";
                    }else{
                        $query = "UPDATE utente set ore_lavoro=0 where email='$email'";
                    }
                    $this->util->fetchAndExecute($query);
                    $hour = $this->getHours($email);
                    echo "1,$hour";
                }else {
                    echo 4;
                }
            }else{
                echo 3;
            }
        }else{
            echo 2;
        }
    }

    /**
     * Metodo per ingrandire/diminuire la durata di una lezione.
     * @param $id L'id della lezione.
     * @param $start La nuova ora di inizio della lezione.
     * @param $end La nuove ora di fine della lezione.
     * @param $email La email di chi ha effettuato la modifica.
     */
    public function resizeEvents($id, $start, $end, $email){
        if($this->isMyLessons($email,$id)) {
            $date = explode(" ", $start)[0];
            if ($this->checkOverlap($id, explode(" ", $start)[1], explode(" ", $end)[1], $date) == 0) {
                $query = "SELECT ora_fine from lezione WHERE id=$id";
                $oldEnd = $this->util->fetchAndExecute($query);
                $query = "UPDATE lezione SET ora_fine='$end' WHERE id=$id";
                $this->util->fetchAndExecute($query);
                $email = $this->getEmailByLesson($id);
                $timeOldEnd = strtotime($oldEnd[0][DB_LESSON_END] . " " . $date);
                $timeEnd = strtotime($end);
                $diff = $this->getDiffHour(explode(" ", $end)[1], $oldEnd[0][DB_LESSON_END]);
                if ($timeOldEnd > $timeEnd) {
                    $query = "UPDATE utente set ore_lavoro=ore_lavoro+$diff where email='$email'";
                } else {
                    if($this->getHours($email)+$diff > 0){
                        $query = "UPDATE utente set ore_lavoro=ore_lavoro+$diff where email='$email'";
                    }else{
                        $query = "UPDATE utente set ore_lavoro=0 where email='$email'";
                    }
                }
                $this->util->fetchAndExecute($query);
                $hour = $this->getHours($email);
                echo "1,$hour";
            } else {
                echo 2;
            }
        }else{
            echo 3;
        }
    }

    /**
     * Metodo per spostare una lezione
     * @param $id L'id della lezione.
     * @param $start La nuova ora di inizio della lezione
     * @param $end La nuova ora di fine della lezione
     * @param $email La email di chi ha effettuato la modifica.
     */
    public function updateEvents($id, $start, $end, $email){
        if($this->isMyLessons($email,$id)){
            $date = explode(" ", $start)[0];
            $selectEvent = "SELECT * FROM lezione WHERE giorno='$date'";
            $event = $this->util->fetchAndExecute($selectEvent);
            if (count($event) < 2) {
                if ($this->checkOverlap($id,explode(" ", $start)[1],explode(" ", $end)[1],$date) == 0){
                    $query = "UPDATE lezione set ora_inizio='$start', ora_fine='$end', giorno='$date' where id=$id";
                    $this->util->fetchAndExecute($query);
                    echo 1;
                }else {
                    echo 3;
                }
            }else{
                $selectEvent = "SELECT * FROM lezione WHERE giorno='$date' && id=$id";
                $event = $this->util->fetchAndExecute($selectEvent);
                if($event != null) {
                    if ($this->checkOverlap($id,explode(" ", $start)[1], explode(" ", $end)[1], $date) == 0) {
                        $query = "UPDATE lezione set ora_inizio='$start', ora_fine='$end', giorno='$date' where id=$id";
                        $this->util->fetchAndExecute($query);
                        echo 1;
                    } else {
                        echo 3;
                    }
                }else{
                    echo 2;
                }
            }
        }else{
            echo 4;
        }
    }

    /**
     * Metodo per eliminare una lezione.
     * @param $id L'id della lezione da eliminare.
     * @param $start L'ora di inizio della lezione.
     * @param $end L'ora di fine della lezione.
     * @param $email La email di chi ha effettuato l'eliminazione.
     */
    public function deleteEvents($id,$start,$end, $email){
        if($this->isMyLessons($email,$id)){
            $email = $this->getEmailByLesson($id);
            $query = "DELETE from assegna WHERE id_lezione=$id";
            $this->util->fetchAndExecute($query);
            $query = "DELETE from lezione WHERE id=$id";
            $this->util->fetchAndExecute($query);
            $diff = $this->getDiffHour(explode(" ", $start)[1], explode(" ", $end)[1]);
            $query = "UPDATE utente set ore_lavoro=ore_lavoro+$diff where email='$email'";
            $this->util->fetchAndExecute($query);
            $hour = $this->getHours($email);
            echo "1,$hour";
        }else{
            echo 2;
        }
    }

    /**
     * Metodo per controllare l'overlap tra le lezioni.
     * @param $id L'id della lezione modificata/aggiunta.
     * @param $timeNewStart La nuova ora di inizio della lezione.
     * @param $timeNewEnd La nuova ora di fine della lezione.
     * @param $dateLesson La data della lezione.
     * @return bool True se c'è l'overlap, False se non c'è l'overlap.
     */
    public function checkOverlap($id, $timeNewStart, $timeNewEnd, $dateLesson){
        $timeNewStart = strtotime($dateLesson."T".$timeNewStart);
        $timeNewEnd = strtotime($dateLesson."T".$timeNewEnd);
        $selectDay = "";
        if($id != null) {
            $selectDay = "SELECT * FROM lezione WHERE giorno='$dateLesson' and id<>$id";
        }else{
            $selectDay = "SELECT * FROM lezione WHERE giorno='$dateLesson'";
        }
        $days = $this->util->fetchAndExecute($selectDay);
        $check = 0;
        foreach ($days as $row) {
            $timeStart = strtotime($dateLesson . "T" . $row[DB_LESSON_START]);
            $timeEnd = strtotime($dateLesson . "T" . $row[DB_LESSON_END]);
            if (!(($timeNewStart >= $timeEnd) || ($timeNewEnd <= $timeStart))) {
                $check++;
            }
        }
        return $check != 0;
    }

    /**
     * Metodo per verificare se la lezione modificata è la propria.
     * @param $user La email di chi effettua la modifica
     * @param $id L'id della lezione modificata.
     * @return bool True se la lezione è sua, False se non è sua.
     */
    private function isMyLessons($user,$id){
        $query = "SELECT * from assegna WHERE id_lezione=$id AND email='$user'";
        $email = $this->util->fetchAndExecute($query);
        return ($email != null);
    }

    /**
     * Metodo per avere le ore rimanetni di un docente.
     * @param $email La email del docente.
     * @return mixed Le ore di lavoro rimanenti.
     */
    public function getHours($email){
        $query = "SELECT ore_lavoro from utente WHERE email='$email'";
        $hour = $this->util->fetchAndExecute($query);
        return $hour[0][DB_USER_HOURS];
    }

    /**
     * Metodo per ricavare la email di chi ha creato una lezione.
     * @param $id L'id della lezione.
     * @return mixed La email di chi ha creato la lezione.
     */
    private function getEmailByLesson($id){
        $query = "SELECT email from assegna WHERE id_lezione=$id";
        $email = $this->util->fetchAndExecute($query);
        return $email[0][DB_USER_EMAIL];
    }

    /**
     * Metodo per ricavare la differenza di ore tra inizio e fine.
     * @param $hourStart L'ora di inizio lezione.
     * @param $hourEnd L'ora di fine lezione
     * @return mixed La differenza fra le due ore.
     */
    private function getDiffHour($hourStart, $hourEnd){
        $query = "SELECT (TIME_TO_SEC(TIMEDIFF('$hourEnd', '$hourStart'))/3600) as 'difference'";
        $hours = $this->util->fetchAndExecute($query);
        return $hours[0]["difference"];;
    }
}