/**
 * Metodo per verificare tutti i dati della registrazione.
 */
function checkAll(){
    var inputs = document.getElementsByTagName("input");
    var v = new Validator();
    $.when(
        v.checkEmailDuplicate(inputs[3].value)
    ).done( function (json) {
        var checkE = json;
        if(v.checkName(inputs[0].value) && v.checkName(inputs[1].value) && v.checkNumber(inputs[2].value) &&
            v.checkEmail(inputs[3].value) && (checkE == 0) && v.checkPassword(inputs[4].value,inputs[5].value)){
            document.getElementById("registration_form").submit();
        }else{

            if(!v.checkName(inputs[0].value)){
                inputs[0].style.border = "1px solid red";
                $.notify("Nome non valido (3-50 caratteri, solo lettere e caratteri da scrittura)", "error");
            }else{
                inputs[0].style.border = "none";
            }
            if(!v.checkName(inputs[1].value)){
                inputs[1].style.border = "1px solid red";
                $.notify("Cognome non valido (3-50 caratteri, solo lettere e caratteri da scrittura)", "error");
            }else{
                inputs[1].style.border = "none";
            }
            if(!v.checkNumber(inputs[2].value)){
                inputs[2].style.border = "1px solid red";
                $.notify("Numero di telefono non valido (10-14 numeri)", "error");
            }else{
                inputs[2].style.border = "none";
            }
            if(!v.checkEmail(inputs[3].value)){
                inputs[3].style.border = "1px solid red";
                $.notify("Email non valida (esempio: testo@testo.testo)", "error");
            }else{
                inputs[3].style.border = "none";
            }
            if(checkE == 1){
                inputs[3].style.border = "1px solid red";
                $.notify("Email già in uso", "error");
            }else{
                if(v.checkEmail(inputs[3].value)) {
                    inputs[3].style.border = "none";
                }
            }
            if(!v.checkPassword(inputs[4].value,inputs[5].value)){
                inputs[4].style.border = "1px solid red";
                inputs[5].style.border = "1px solid red";
                $.notify("Password non corrispondendi o non valide (8 caratteri e numero/carattere speciale)", "error");
            }else{
                inputs[4].style.border = "none";
                inputs[5].style.border = "none";
            }

        }
    });
}

/**
 * Metodo per rimuovere doppi spazi, doppi cancellettim doppi trattini nel numero di telefono.
 * @param object Il numero di telefono.
 */
function fixNumber(object){
    var number = object.value;
    number = number.replace(/\s\s+/g, ' ');
    number = number.replace(/--+/g, '-');
    number = number.replace(/\s-+/g, ' ');
    number = number.replace(/-\s+/g, '-');
    number = number.replace(/##+/g, '#');
    object.value = number;
}