<?php

/**
 * Controller per caricare la pagina di errore.
 */
class Errore
{

    /**
     * Metodo per mostrare la pagina di errore.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/errore.php';
        require 'application/views/_template/footer.php';
    }

}
