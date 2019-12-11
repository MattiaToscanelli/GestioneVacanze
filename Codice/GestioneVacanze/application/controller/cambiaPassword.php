<?php

/**
 * Controller per modificare la password
 */
class CambiaPassword
{

    /**
     * Metodo per caricare la pagina di modifica password.
     */
    public function index(){
        if(!isset($_SESSION[SESSION_CHANGE_PASSWORD])) {
            header("Location: " . URL . "errore");
        }
        require 'application/views/_template/header.php';
        require 'application/views/login/cambiaPassword.php';
        require 'application/views/_template/footer.php';
        require 'application/libs/emptySession.php';

        EmptySession::changePass();
    }

    /**
     * Metodo per modificare la password.
     * @param $email La email di chi vuole modificare la password.
     * @param $hash La hash per identificare la persona che vuole cambiare la password.
     */
    public function resetPassword($email=null,$hash=null){
        if(($email != null) && ($hash != null)) {
            $_SESSION[SESSION_SURNAME] = Util::test_input($email);
            require 'application/models/cambiaPasswordModel.php';
            $cpm = new CambiaPasswordModel();
            if ($cpm->confirm(Util::test_input($hash), Util::test_input($email))) {
                $_SESSION[SESSION_CHANGE_PASSWORD] = true;
                header("Location: " . URL . "cambiaPassword");
            } else {
                header("Location: " . URL . "errore");
            }
        }else{
            header("Location: " . URL . "errore");
        }
    }

    /**
     * Metodo per modificare la password
     */
    public function modifyPassword(){
        require 'application/models/cambiaPasswordModel.php';
        $cpm = new CambiaPasswordModel();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($cpm->modify($_SESSION[SESSION_SURNAME],$_POST[POST_PASSWORD], $_POST[POST_RE_PASSWORD])){
                require 'application/libs/emptySession.php';
                EmptySession::email();
                header("Location: ".URL."passwordCambiata");
            }else{
                header("Location: ".URL."cambiaPassword");
            }
        }else{
            header("Location: " . URL . "errore");
        }
    }

}
