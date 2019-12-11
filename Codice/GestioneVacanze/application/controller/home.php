<?php

/**
 * Controller per caricare la pagina home, in questo caso il login.
 */
class Home
{

    /**
     * Metodo per mostrare la pagina di home.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/login.php';
        require 'application/views/_template/footer.php';
    }

}
