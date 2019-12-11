<?php

/**
 * Controller per il login.
 */
class Login{

    /**
     * Metodo per caricare la pagina di login.
     */
    public function index(){
        require 'application/views/_template/header.php';
        require 'application/views/login/login.php';
        require 'application/views/_template/footer.php';
        require 'application/libs/emptySession.php';

        EmptySession::err();
    }

    /**
     * Metodo per effettuare il login.
     */
    public function access() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = Util::test_input($_POST[POST_EMAIL]);
            $password = $_POST[POST_PASSWORD];
            require_once 'application/models/loginModel.php';
            $loginModel = new LoginModel();
            $result = $loginModel->getUser($email);
            if (count($result) > 0) {
                if (password_verify($password, $result[0][DB_USER_PASSWORD])) {
                    if ($result[0][DB_USER_VERIFY] == 1) {
                        $_SESSION[SESSION_TYPE] = $result[0][DB_USER_TYPE];
                        $_SESSION[SESSION_NAME] = $result[0][DB_USER_NAME];
                        $_SESSION[SESSION_SURNAME] = $result[0][DB_USER_SURNAME];
                        $_SESSION[SESSION_EMAIL] = $email;
                        header("Location:" . URL . "calendario");
                    } else {
                        header("Location:" . URL . "aspetta");
                    }
                } else {
                    $_SESSION[SESSION_ERR] = "Email o password non corretti!";
                    header("Location:" . URL . "login");
                }
            } else {
                $_SESSION[SESSION_ERR] = "Email o password non corretti!";
                header("Location:" . URL . "login");
            }
        }else{
            header("Location:" . URL . "errore");
        }
    }

}

?>