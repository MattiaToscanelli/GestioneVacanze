<?php

/**
 * Controller per il calendario.
 */
class Calendario{

    /**
     * Carica la pagine del calendario e verifica che qualcuno abbia eseguito l'accesso.
     */
    public function index(){
        if(!isset($_SESSION[SESSION_NAME])){
            header("Location: ".URL."errore");
        }
        require 'application/models/calendarioModel.php';
        $c = new CalendarioModel();
        $_SESSION[SESSION_HOURS_WORK] = $c->getHours($_SESSION[SESSION_EMAIL])==0?"<bold style='color:red'>".$c->getHours($_SESSION[SESSION_EMAIL])."</bold>":$c->getHours($_SESSION[SESSION_EMAIL]);
        require 'application/views/_template/headerCalendar.php';
        require 'application/views/calendario/calendario.php';
        require 'application/views/_template/footerCalendar.php';
    }

    /**
     * Metodo per verificare che gli utenti che vogliono visualizzare questa pagina siano docenti.
     */
    public function checkDocenti(){
        if(isset($_SESSION[SESSION_TYPE])){
            if(!($_SESSION[SESSION_TYPE]=="Docente")){
                header("Location: ".URL."errore");
            }
        }else{
            header("Location: ".URL."errore");
        }
    }

    /**
     * Metodo per caricare tutte le lezioni sul calendario.
     * @param null $flag Flag per decidere quali attività caricare.
     */
    public function load($flag = null){
        if(!isset($_SESSION[SESSION_NAME])){
            header("Location: ".URL."errore");
        }
        require 'application/models/calendarioModel.php';
        $c = new CalendarioModel();
        $f = Util::test_input($flag);
        $c->loadEvents($f);
    }

    /**
     * Metodo per inserire una lezione.
     */
    public function insert(){
        $this->checkDocenti();
        require 'application/models/calendarioModel.php';
        $c = new CalendarioModel();
        $title = Util::test_input($_POST[POST_TITLE]);
        $start = Util::test_input($_POST[POST_START]);
        $end = Util::test_input($_POST[POST_END]);
        $email = Util::test_input($_SESSION[SESSION_EMAIL]);
        return $c->insertEvents($title,$start,$end,$email);
    }

    /**
     * Metodo per ingrandire/diminuire la durata di una lezione.
     */
    public function resize(){
        $this->checkDocenti();
        require 'application/models/calendarioModel.php';
        $c = new CalendarioModel();
        $start = Util::test_input($_POST[POST_START]);
        $end = Util::test_input($_POST[POST_END]);
        $id = Util::test_input($_POST[POST_ID]);
        $email = Util::test_input($_SESSION[SESSION_EMAIL]);
        return $c->resizeEvents($id,$start,$end,$email);
    }

    /**
     * Metodo per spostare una lezione.
     */
    public function update(){
        $this->checkDocenti();
        require 'application/models/calendarioModel.php';
        $c = new CalendarioModel();
        $start = Util::test_input($_POST[POST_START]);
        $end = Util::test_input($_POST[POST_END]);
        $id = Util::test_input($_POST[POST_ID]);
        $email = Util::test_input($_SESSION[SESSION_EMAIL]);
        return $c->updateEvents($id,$start,$end,$email);
    }

    /**
     * Metodo per eliminare una lezione.
     */
    public function delete(){
        $this->checkDocenti();
        require 'application/models/calendarioModel.php';
        $c = new CalendarioModel();
        $id = Util::test_input($_POST[POST_ID]);
        $start = Util::test_input($_POST[POST_START]);
        $end = Util::test_input($_POST[POST_END]);
        $email = Util::test_input($_SESSION[SESSION_EMAIL]);
        return $c->deleteEvents($id,$start,$end,$email);
    }

}

?>