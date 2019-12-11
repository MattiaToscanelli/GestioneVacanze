<?php

/**
 * Controller per la pagina di conferma della email.
 */
class Conferma{

    /**
     * Metodo per caricare la pagina per la conferma della email.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/conferma.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per confermare la email.
     * @param $hash La hash per identificare la persona che ha verificato la email.
     * @param $email La email della persona che ha verificato la email.
     */
    public function confirm($hash = null,$email= null){
        if(($email != null) && ($hash != null)) {
            require_once 'application/models/confermaModel.php';
            $conferma_model = new ConfermaModel();
            $conferma_model->confirm(Util::test_input($hash), Util::test_input($email));
            header("Location: " . URL . "conferma");
        }else{
            header("Location: " . URL . "errore");
        }
    }

}