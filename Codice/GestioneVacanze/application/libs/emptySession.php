<?php

/**
 * Classe utile per la gestione delle sessioni.
 */
class EmptySession{

    /**
     * Metodo che mi permette di svuotare tutte le variabili di sessione per la modifica di un utente nel pannello admin.
     */
    public static function modify(){
        unset($_SESSION[SESSION_MODIFY]);
        unset($_SESSION[SESSION_FIRST_NAME]);
        unset($_SESSION[SESSION_LAST_NAME]);
        unset($_SESSION[SESSION_PHONE_NUMBER]);
        unset($_SESSION[SESSION_WORK_HOURS]);
        unset($_SESSION[SESSION_USER_TYPE]);
        unset($_SESSION[SESSION_VERIFY]);
    }

    /**
     * Metodo che mi permette di distruggere la sessione. (usato per il logout)
     */
    public static function stop(){
        session_destroy();
    }

    /**
     * Metodo che mi permette di utilizzare la pagina cambia password.
     */
    public static function changePass(){
        unset($_SESSION[SESSION_CHANGE_PASSWORD]);
    }

    /**
     * Metodo che mi permette di gestire gli errori in modo visibile all'utente.
     */
    public static function err(){
        unset($_SESSION[SESSION_ERR]);
    }

    /**
     * Metodo che mi permette di svuotare la variabile di sessione utilizzata nel cambia password.
     */
    public static function email(){
        unset($_SESSION[SESSION_SURNAME]);
    }
}

?>