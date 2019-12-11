<?php

/**
 * Configurazione
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */

/**
 * Configurazione di : Error reporting
 * Utile per vedere tutti i piccoli problemi in fase di sviluppo, in produzione solo quelli gravi
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Configurazione di : URL del progetto
 */
define('URL', 'http://localhost/GestioneVacanze/');
define('APPLICATION', 'application/');

/**
 * Costate per l'accesso per il database.
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'gestione_vacanze');


/**
 * Costanti per Le variabili di sessione.
 */
define('SESSION_ERR', 'err');
define('SESSION_MODIFY', 'modify');
define('SESSION_NAME', 'name');
define('SESSION_EMAIL_MODIFY', 'emailM');
define('SESSION_TYPE', 'type');
define('SESSION_SURNAME', 'surname');
define('SESSION_EMAIL', 'email');
define('SESSION_FIRST_NAME', 'first_name');
define('SESSION_LAST_NAME', 'last_name');
define('SESSION_PHONE_NUMBER', 'phone_number');
define('SESSION_WORK_HOURS', 'work_hours');
define('SESSION_USER_TYPE', 'user_type');
define('SESSION_VERIFY', 'verify');
define('SESSION_HOURS_WORK', 'hours_work');
define('SESSION_CHANGE_PASSWORD', 'changePassword');

/**
 * Costanti per Le variabili di post.
 */
define('POST_FIRST_NAME', 'first_name');
define('POST_LAST_NAME', 'last_name');
define('POST_PHONE_NUMBER', 'phone_number');
define('POST_EMAIL', 'email');
define('POST_PASSWORD', 'password');
define('POST_RE_PASSWORD', 're_password');
define('POST_VERIFY', 'verify');
define('POST_HOURS', 'hours');
define('POST_WORKING_DAY', 'working_day');
define('POST_HOURS_TEACHER', 'hours_teacher');
define('POST_TYPE', 'type');
define('POST_START', 'start');
define('POST_END', 'end');
define('POST_TITLE', 'title');
define('POST_ID', 'id');

/**
 * Costanti per le variabili del database.
 */
define('DB_USER_NAME', 'nome');
define('DB_USER_SURNAME', 'cognome');
define('DB_USER_PHONE', 'numero_telefono');
define('DB_USER_HOURS', 'ore_lavoro');
define('DB_USER_TYPE', 'tipo');
define('DB_USER_VERIFY', 'verificato');
define('DB_USER_EMAIL', 'email');
define('DB_USER_PASSWORD', 'password');
define('DB_LESSON_ID', 'id');
define('DB_LESSON_NAME', 'nome');
define('DB_LESSON_START', 'ora_inizio');
define('DB_LESSON_END', 'ora_fine');
define('DB_LESSON_DAY', 'giorno');


/**
 * Importo la classe per i metodi utili.
 */
require_once 'application/libs/util.php';



