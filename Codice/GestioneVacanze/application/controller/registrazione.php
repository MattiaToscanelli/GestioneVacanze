<?php

/**
 * Controller per la registrazione.
 */
class Registrazione
{

    /**
     * Metodo per caricare la pagina di registrazione
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/registrazione.php';
        require 'application/views/_template/footer.php';
    }

    /**
     * Metodo per inserire un nuovo utente nel database.
     */
    public function insert(){
        require_once 'application/models/registrazioneModel.php';

        $name = $surname = $number = $email = $password1 = $password2 = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $name = Util::test_input($_POST[POST_FIRST_NAME]);
            $surname = Util::test_input($_POST[POST_LAST_NAME]);
            $number = Util::test_input($_POST[POST_PHONE_NUMBER]);
            $email = Util::test_input($_POST[POST_EMAIL]);
            $password1 = Util::test_input($_POST[POST_PASSWORD]);
            $password2 = Util::test_input($_POST[POST_RE_PASSWORD]);
            $rm = new RegistrazioneModel($name, $surname, $number, $email, $password1, $password2);
            if($rm->insertUser()){
                header("Location: ".URL."aspetta");
            }else{
                header("Location: ".URL."errore");
            }
        }else{
            header("Location: ".URL."errore");
        }
    }

    /**
     * Metodo per verificare se la email inserita nella registarzione è già utilizzata da qualcun'altro.
     */
    public function emailExist(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once 'application/models/loginModel.php';
            $loginModel = new LoginModel();
            $email = Util::test_input($_POST[POST_EMAIL]);
            $result = $loginModel->getUserA($email);
        }else{
            header("Location: ".URL."errore");
        }
    }
}
