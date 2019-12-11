<?php

/**
 * Controller per caricare la pagina che dice che la email è stata inviata.
 */
class emailInviata
{

    /**
     * Metodo per caricare la pagina con il messaggio di email inviata.
     */
    public function index()
    {
        require 'application/views/_template/header.php';
        require 'application/views/login/emailInviata.php';
        require 'application/views/_template/footer.php';
    }

}
