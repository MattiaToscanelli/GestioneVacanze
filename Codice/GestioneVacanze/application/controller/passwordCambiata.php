<?php

/**
 * Controller per mostrare la pagina che dice che la password è stata cambiata.
 */
class passwordCambiata
{

    /**
     * Metodo per caricare la pagina che dice che la password è stata cambiata.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/passwordCambiata.php';
        require 'application/views/_template/footer.php';
    }


}
