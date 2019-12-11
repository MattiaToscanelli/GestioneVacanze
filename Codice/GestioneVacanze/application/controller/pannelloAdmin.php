<?php

/**
 * Controller per il pannello admin.
 */
class PannelloAdmin{

    /**
     * Metodo per caricare la pagina di pannello admin. Verifica anche che l'utente che vuole visualizzare la pagina sia
     * un Gestore
     */
    public function index(){
        $this->checkAdmin();

        require_once 'application/models/pannelloAdminModel.php';
        $pannelloAdminModel = new PannelloAdminModel();
        $users = $pannelloAdminModel->getAll();
        $days = $pannelloAdminModel->getAllDay();

        require 'application/views/_template/headerCalendar.php';
        require 'application/views/calendario/pannelloAdmin.php';
        require 'application/views/_template/footerCalendar.php';
        require 'application/libs/emptySession.php';

        EmptySession::modify();
        EmptySession::err();

    }

    /**
     * Metodo per vericare che gli utenti che vogliono visualizzare questa pagina siano Gestori.
     */
    public function checkAdmin(){
        if(isset($_SESSION[SESSION_TYPE])){
            if(!($_SESSION[SESSION_TYPE]=="Gestore")){
                header("Location: ".URL."errore");
                exit;
            }
        }else{
            header("Location: ".URL."errore");
            exit;
        }
    }

    /**
     * Metodo per aggiungere un giorno.
     */
    public function addDay(){
        $this->checkAdmin();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $day = Util::test_input($_POST[POST_WORKING_DAY]);
            require_once 'application/models/pannelloAdminModel.php';
            $pannello_admin_model = new PannelloAdminModel();
            if (!$pannello_admin_model->addDay($day, $_SESSION[SESSION_EMAIL])) {
                $_SESSION[SESSION_ERR] = "Giorno non valido o già aggiunto";
            }
        }
        header("Location: ".URL."pannelloAdmin");
    }

    /**
     * Metodo per eliminare un giorno.
     * @param $day Il giorno da eliminare.
     */
    public function deleteDay($day){
        $this->checkAdmin();
        require_once 'application/models/pannelloAdminModel.php';
        $pannello_admin_model = new PannelloAdminModel();
        $pannello_admin_model->removeDay($day, $_SESSION[SESSION_EMAIL]);
        header("Location: ".URL."pannelloAdmin");
    }

    /**
     * Metodo per eliminare tutti i giorni fino ad oggi. (oggi compreso).
     */
    public function deleteDays(){
        $this->checkAdmin();
        require_once 'application/models/pannelloAdminModel.php';
        $pannello_admin_model = new PannelloAdminModel();
        $pannello_admin_model->removeAllDay();
        $_SESSION[SESSION_ERR] = "Giorni eliminati";
        header("Location: ".URL."pannelloAdmin");
    }

    /**
     * Metodo per eliminare un utente.
     * @param $user la email dell'utente da eliminare.
     */
    public function deleteUser($user){
        $this->checkAdmin();
        require_once 'application/models/pannelloAdminModel.php';
        $pannello_admin_model = new PannelloAdminModel();
        if(!$pannello_admin_model->deleteUser($user, $_SESSION[SESSION_EMAIL])){
            $_SESSION[SESSION_ERR] = "Non puoi eliminare questo utente";
        }
        header("Location: ".URL."pannelloAdmin");
    }

    /**
     * Metodo per modificare un utente.
     * @param $user La email dell'utente da modificare.
     */
    public function modifyUser($user){
        $this->checkAdmin();
        require_once 'application/models/pannelloAdminModel.php';
        $pannello_admin_model = new PannelloAdminModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = array();
            array_push($data,Util::test_input($_POST[POST_FIRST_NAME]));
            array_push($data,Util::test_input($_POST[POST_LAST_NAME]));
            array_push($data,Util::test_input($_POST[POST_PHONE_NUMBER]));
            array_push($data,Util::test_input($_POST[POST_HOURS]));
            array_push($data,Util::test_input($_POST[POST_VERIFY]));
            array_push($data,Util::test_input($_POST[POST_TYPE]));
            $pannello_admin_model->modifyUser($user, $data, $_SESSION[SESSION_EMAIL]);
        }else {
            $result = $pannello_admin_model->getAllData($user, $_SESSION[SESSION_EMAIL]);
            if ($result == null) {
                $_SESSION[SESSION_ERR] = "Non puoi modificare questo utente";
            } else {
                $_SESSION[SESSION_MODIFY] = true;
                $_SESSION[SESSION_FIRST_NAME] = $result[0][DB_USER_NAME];
                $_SESSION[SESSION_LAST_NAME] = $result[0][DB_USER_SURNAME];
                $_SESSION[SESSION_PHONE_NUMBER] = $result[0][DB_USER_PHONE];
                $_SESSION[SESSION_WORK_HOURS] = $result[0][DB_USER_HOURS];
                $_SESSION[SESSION_USER_TYPE] = $result[0][DB_USER_TYPE];
                $_SESSION[SESSION_VERIFY] = $result[0][DB_USER_VERIFY];
                $_SESSION[SESSION_EMAIL_MODIFY] = $result[0][DB_USER_EMAIL];
            }
        }
        header("Location: ".URL."pannelloAdmin");
    }

    /**
     * Metodo per settare in una volta sola tutte le ore dei docenti.
     */
    public function setAllHours(){
        $this->checkAdmin();
        require_once 'application/models/pannelloAdminModel.php';
        $pannello_admin_model = new PannelloAdminModel();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $hours = Util::test_input($_POST[POST_HOURS_TEACHER]);
            if(!$pannello_admin_model->modifyHours($hours)){
                $_SESSION[SESSION_ERR] = "Ore non valide";
            }
        }
        header("Location: ".URL."pannelloAdmin");
    }

}

?>