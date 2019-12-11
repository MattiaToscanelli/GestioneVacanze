<?php

/**
 * Controller per la pagina di logout.
 */
class Logout
{

    /**
     * Metodo per caricare la pagina di logout.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/logout.php';
        require 'application/views/_template/footer.php';
        require 'application/libs/emptySession.php';
        EmptySession::stop();
    }


}
