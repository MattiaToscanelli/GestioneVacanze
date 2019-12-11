/**
 * Metodo per verificare i dati quando viene modificato un utente nel pannello admin.
 */
function checkAll(){
    var inputs = document.getElementsByTagName("input");
    var selects = document.getElementsByTagName("select");
    var v = new Validator();
    if(v.checkName(inputs[0].value) && v.checkName(inputs[1].value) && v.checkNumber(inputs[2].value) &&
        (v.checkHours(inputs[3].value)  || selects[1].value == "Gestore" || selects[1].value == "Visualizzatore") && v.checkVerify(selects[0].value) && v.checkType(selects[1].value)){
        document.getElementById("admin_form").submit();
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
        if(!v.checkHours(inputs[3].value)){
            inputs[3].style.border = "1px solid red";
            $.notify("Numero di ore non valide (min 0 max 999 ore)", "error");
        }else{
            inputs[3].style.border = "none";
        }
        if(!v.checkVerify(selects[0].value)){
            selects[0].style.border = "1px solid red";
            $.notify("Verifica non valida", "error");
        }else{
            selects[0].style.border = "none";
        }
        if(!v.checkType(selects[1].value)){
            selects[1].style.border = "1px solid red";
            $.notify("Tipo non valido", "error");
        }else{
            selects[1].style.border = "none";
        }
    }
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

/**
 * Metodo per mostrare o no le ore nella modifica di un utente nel pannello di controllo.
 * @param object Il select che cambia il tipo di utente.
 */
function viewHourOnChange(object) {
    var type = object.value;
    if(type.localeCompare("Docente")){
        document.getElementById("hour").style.display = "none";
    }else{
        document.getElementById("hour").style.display = "block";
    }
}

/**
 * Metodo per mostrare o no le ore nella modifica di un utente nel pannello di controllo.
 * Verifica qual è il tipo iniziale dell'utente.
 */
function viewHOnLoad() {
    var type = document.getElementById("type").value;
    if(type.localeCompare("Docente")){
        document.getElementById("hour").style.display = "none";
    }else{
        document.getElementById("hour").style.display = "block";
    }
}

window.onload = function() {
    try {
        viewHOnLoad();
    }
    catch(error) {
    }
};

/**
 * Metodo per eliminare un utente.
 * @param x L'utente che si vuole eliminare.
 */
function deleteUser(x){
    if(confirm("Sei sicuro di voler eliminare questo utente?")){
        location.replace(x);
    }
}

/**
 * Metodo per eliminare un giorno.
 * @param x Il giorno che si vuole eliminare.
 */
function deleteDay(x){
    if(confirm("Sei sicuro di voler eliminare questo giorno?")){
        location.replace(x);
    }
}

/**
 * Metodo per eliminare tutti i giorni compresso oggi.
 * @param x I giorni da eliminare.
 */
function deleteDays(x){
    var today =  moment(new Date()).format("Y-MM-DD");
    if(confirm("Sei sicuro di voler eliminare tutti i giorni le lezioni fino a " + today + "?")){
        location.replace(x);
    }
}

/**
 * Metodo per verificare le ore da assegnare a tutti docenti.
 */
function checkHoursTeacher(){
    var v = new Validator();
    var hours = document.getElementById("hours_teacher").value;
    if(v.checkHours(hours)){
        document.getElementById("setHours").submit();
    }else{
        document.getElementById("hours_teacher").style.border = "1px solid red";
        $.notify("Numero di ore non valide (min 0 max 999 ore)", "error");
    }
}

/**
 * Metodo per aggiungere un giorno.
 * @param x Il giorno da aggiungere.
 */
function addDay(x) {
    var v = new Validator();
    var date = document.getElementById("dateDay").value;
    if(v.checkDate(date)){
        document.getElementById("dayPanel").submit();
        $.notify("Giorno aggiunto", "success");
    }else{
        document.getElementById("dateDay").style.border = "1px solid red";
        $.notify("Aggiungi un giorno valido (Maggiore della data odierna)", "error");
    }
}