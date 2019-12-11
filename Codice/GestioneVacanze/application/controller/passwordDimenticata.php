<?php

/**
 * Controller per impostare una nuova password.
 */
class PasswordDimenticata
{

    /**
     * Metodo per caricare la pagina per impostare una nuova password.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/passwordDimenticata.php';
        require 'application/views/_template/footer.php';
        require 'application/libs/emptySession.php';

        EmptySession::err();
    }

    /**
     * Metodo per inviare la mail di recupero password.
     */
    public function sendEmail()
    {
        if ($_SERVER["REQUEST_METHOD"] = "POST") {
            require 'application/models/passwordDimeticataModel.php';
            $pdm = new PasswordDimeticataModel(Util::test_input($_POST[POST_EMAIL]));
            if ($pdm->sendEmail()) {
                header("Location: " . URL . "emailInviata");
            } else {
                $_SESSION[SESSION_ERR] = "Email inesistente!";
                header("Location: " . URL . "PasswordDimenticata");
            }
        } else {
            header("Location: " . URL . "errore");
        }
    }

}
?>