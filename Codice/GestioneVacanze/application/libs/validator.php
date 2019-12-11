<?php

/**
 * Classe utile per la Validazione dei dati.
 */
class Validator
{
    /**
     * @var Database Connessione per il database.
     */
    private $connection;

    /**
     * @var Util Oggetto che mi aiuta per eseguire le query;
     */
    private $util;

    /**
     * Metodo costrruttore con un parametro, instazia le variabili $connection e $util.
     * @param $connection La connessione al database.
     */
    public function __construct($connection){
        require_once "application/libs/util.php";
        $this->connection = $connection;
        $this->util = new Util($connection);
    }

    /**
     * Metodo per verificare un nome.
     * @param $val Il nome da verificare.
     * @return bool True se il nome è valido, False non è valido.
     */
    function checkName($val){
        return (preg_match('/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]{2}[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.\'-]+$/', $val) && count($val)<=50);
    }

    /**
     * Metodo per verificare se una email esiste già nel database.
     * @param $val La email da verificare.
     * @return bool True se la email esiste, False se non esiste.
     */
    function checkEmailExists($val){
        $selectUsers = "SELECT nome FROM utente WHERE email='$val'";
        $users = $this->util->fetchAndExecute($selectUsers);
        return count($users)>0;
    }

    /**
     * Metodo per verificare se una data aggiunta dal pannello admin è già presente.
     * @param $val La data da inserire.
     * @return bool True se la data è già stata aggiunta, False se non è ancora stata aggiunta.
     */
    function checkDateExists($val){
        $selectGiorni = "SELECT giorno FROM giorno WHERE giorno='$val'";
        $days = $this->util->fetchAndExecute($selectGiorni);
        return count($days)>0;
    }

    /**
     * Metodo per verificare se una email è valida.
     * @param $val La email da verificare.
     * @return bool True se la email è valida, False se non è valida.
     */
    function checkEmail($val){
        return preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $val) && !$this->checkEmailExists($val);
    }

    /**
     * Metodo per verificare se un numero di telefono è valido.
     * @param $val Il numero da verificare.
     * @return false|int True se il numero è valido, False se non è valdio.
     */
    function checkNumber($val){
        $val = str_replace(" ", "", $val);
        $val = str_replace("-", "", $val);
        return preg_match('/^[\+]?[0-9-#]{10,14}$/', $val);
    }

    /**
     * Metodo per verificare se due password sono uguali e rispetta i criteri di sicurezza.
     * @param $val1 La prima password.
     * @param $val2 La password ripetuta.
     * @return bool True se le password sono uguali e rispettano i criteri di sicurezza, False se non sono uguali o
     * non rispettano i criteri.
     */
    function checkPassword($val1,$val2){
        $regexLetter = '/[a-zA-Z]/';
        $regexDigit   = '/\d/';
        $regexSpecial = '/[^a-zA-Z\d]/';
        return (preg_match($regexDigit,$val1) || preg_match($regexSpecial,$val1)) &&
            preg_match($regexLetter,$val1) && strlen($val1) >= 8 &&
            $val1 == $val2;
    }

    /**
     * Metodo per verificare le ore di lavoro di un docente.
     * @param $val Le ore di lavoro di un docente.
     * @return bool True se le ore inserite sono valide, False se le ore non sono valide.
     */
    function checkHours($val){
        return $val > -1 && $val < 999;
    }

    /**
     * Metodo per verificae il tipo di un utente.
     * @param $val Il tipo da verificare.
     * @return bool True se il tipo è valido, False se non è valido.
     */
    function checkType($val){
        return $val == "Gestore" || $val == "Docente" || $val == "Visualizzatore";
    }

    /**
     * Metodo per verificare il tipo di verifica di account.
     * @param $val Il tipo di veridica di account.
     * @return bool True se la verificae è valida, False se non è valida.
     */
    function checkVerify($val){
        return $val == "Verificato" || $val == "Non verificato";
    }

    /**
     * Metodo per verificare che la data aggiunta sia maggiore della data odierna e che non ci sia gia nel database.
     * @param $val La data inserita da verificare.
     * @return bool True se la data è valida, False se non è valida.
     */
    function checkDateCalendarInsert($val){
        $dataN = explode("/", $val);
        if(count($dataN) > 2){
            if(is_numeric($dataN[2]) && is_numeric($dataN[1]) && is_numeric($dataN[0])){
                $day = $dataN[2] ."-" .$dataN[1] ."-" .$dataN[0];
                $d = DateTime::createFromFormat('Y-m-d', $day);
                if(checkdate($dataN[1],$dataN[0],$dataN[2]) && $d->format('Y-m-d') === $day){
                    try {
                        $today = new DateTime();
                        return (($d > $today) && (!($this->checkDateExists($day))));
                    }catch (Exception $e){
                        return false;
                    }
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}