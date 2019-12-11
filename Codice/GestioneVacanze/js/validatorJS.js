/**
 * Classe per convalidare i dati lato client
 */
class Validator {

    /**
     * Metodo per controllare un nome.
     * @param val Il nome da controllare.
     * @returns {boolean} True se è valido, False se non è valido.
     */
    checkName(val) {
        var regexName = /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]{2}[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/;
        return (regexName.test(val) && val.length <= 50);
    }

    /**
     * Metodo per controllare una email.
     * @param val La email da controllare.
     * @returns {boolean} True se è valida, False se non è valida.
     */
    checkEmail(val) {
        var regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return regexEmail.test(val);
    }

    /**
     * Metodo per controllare un numero di telefono.
     * @param val Il numero di telefono da controllare.
     * @returns {boolean} True se è valido, False se non è valido.
     */
    checkNumber(val) {
        val = val.replace(/ /g, "");
        val = val.replace(/-/g, "");
        var regexNumber = /^[\+]?[0-9-#]{10,14}$/;
        return regexNumber.test(val);
    }

    /**
     * Metodo per verificare se la password rispetta i criteri e se è uguale per i due campi
     * @param val1 La prima password.
     * @param val2 La seconda password.
     * @returns {boolean} True se sono valide, False se non sono valide.
     */
    checkPassword(val1, val2) {
        var regexLetter = /[a-zA-Z]/;
        var regexDigit = /\d/;
        var regexSpecial = /[^a-zA-Z\d]/;
        return (regexDigit.test(val1) || regexSpecial.test(val1)) &&
            regexLetter.test(val1) && val1.length >= 8 &&
            val1 == val2;
    }

    /**
     * Metodo per controllare le ore di lavoro dei docenti.
     * @param val Le ore di lavoro da controllare.
     * @returns {boolean} True se sono valide, False se non sono valide.
     */
    checkHours(val) {
        var regexNumber = /^[0-9]{1,3}$/;
        return val > -1 && val < 999 && regexNumber.test(val);
    }

    /**
     * Metodo per controllare un tipo di utente.
     * @param val Il tipo di utente da controllare.
     * @returns {boolean} True se è valido, False se non è valido.
     */
    checkType(val) {
        return val == "Gestore" || val == "Docente" || val == "Visualizzatore";
    }

    /**
     * Metodo per controllare se il dato inserito sia Verificato/Non verificato.
     * @param val Il dato da controllare.
     * @returns {boolean} True se è valido, False se non è valido.
     */
   checkVerify(val) {
        return val == "Non verificato" || val == "Verificato";
   }

    /**
     * Metodo per controllare se una email è già presente nel database.
     * @param val La email da verificare.
     * @returns {*|jQuery|{getAllResponseHeaders, abort, setRequestHeader, readyState, getResponseHeader, overrideMimeType, statusCode}} 0 se non è presente, 1 se è presente.
     */
   checkEmailDuplicate(val) {
        var email = val;
        var response;
        return ($.ajax({
            url: (URL+"Registrazione/emailExist"),
            type: "POST",
            dataType: "json",
            data: {email: email},
            success: function (text) {
                response = text;
            }
        }));
   }

    /**
     * Metodo per verificare una data.
     * @param x La data da verificare.
     * @returns {boolean} True se la data è valida, False se non è valida.
     */
   checkDate(x) {
        var date = x.split("/");
        if (date.length > 2) {
            if (!isNaN(date[0]) && !isNaN(date[1]) && !isNaN(date[2])) {
                var today = new Date().setHours(0, 0, 0, 0);
                var data = new Date(date[2], date[1] - 1, date[0]);
                return today <= data;
            }
        }
        return false;
   }

    /**
     * Metodo per verificare la lunghezza in ore di una lezione del calendario.
     * @param start L'ora d'inizio.
     * @param end L'ora di fine,
     * @returns {null|boolean} True se le due ore sono valide, null se non sono valide.
     */
    checkEvent(start, end){
        var s = new Date(start).setHours(0,0,0,0);
        var e = new Date(end).setHours(0,0,0,0);
        var st = new Date(start);
        var en = new Date(end);
        var hStart = st.getHours();
        var hEnd = en.getHours();
        var diffTime = en.getTime() - st.getTime();
        var diffHour = diffTime / (1000 * 60 * 60);
        var today = new Date().setHours(0,0,0,0);
        if(s == e && diffHour <= 4 && hStart >= 8 && (hEnd < 17 || (hEnd == 17 && en.getMinutes() == 0)) && today <= s){
            return true;
        }else{
            return null;
        }
    }
}
