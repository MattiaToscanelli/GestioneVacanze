/**
 * Metodo per verificare che le due password nel modifica password,
 * siano uguali e che rispettono i criteri di password.
 */
function checkAll(){
    var inputs = document.getElementsByTagName("input");
    var v = new Validator();
    if(v.checkPassword(inputs[0].value,inputs[1].value)){
        document.getElementById("changePassword").submit();
    }else{
        if(!v.checkPassword(inputs[1].value,inputs[1].value)){
            inputs[0].style.border = "1px solid red";
            inputs[1].style.border = "1px solid red";
            $.notify("Password non corrispondendi o non valide (8 caratteri e numero/carattere speciale)", "error");
        }else{
            inputs[0].style.border = "none";
            inputs[1].style.border = "none";
        }
    }
}

