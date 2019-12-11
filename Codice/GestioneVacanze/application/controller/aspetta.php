<?php

/**
 * Controller per caricare la pagina aspetta.
 */
class Aspetta
{

    /**
     * Carica la pagina aspetta.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/aspetta.php';
        require 'application/views/_template/footer.php';
    }


}
