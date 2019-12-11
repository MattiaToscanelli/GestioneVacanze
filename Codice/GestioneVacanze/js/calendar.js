/**
 * Script utilizzato per mostrare il calendario ai docenti,
 * in quanto è possibile effetuttare modifiche.
 */
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var x = 0;
    var v = new Validator();
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        events: (URL+'Calendario/load'),
        customButtons: {
            personal: {
                text: 'Personale/Completo',
                click: function() {
                    if(x%2==0) {
                        calendar.removeAllEventSources();
                        calendar.addEventSource((URL+'Calendario/load/1'));
                        x++;
                    }else{
                        calendar.removeAllEventSources();
                        calendar.addEventSource((URL+'Calendario/load'));
                        x++;
                    }
                }
            }
        },
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'timeGridWeek,listMonth,personal'
        },
        editable: true,
        defaultView: 'timeGridWeek',
        defaultDate: moment(new Date()).format("Y-MM-DD"),
        navLinks: true, // can click day/week names to navigate views
        locale: 'it',
        timeZone: 'local',
        firstDay: 1,
        selectable:true,
        selectHelper:true,
        /**
         * Metodo per aggiunta di una lezione.
         * @param selectionInfo La lezione aggiunta.
         */
        select: function(selectionInfo) {
            var title = prompt("Inserisci un nome alla lezione");
            if(title) {
                if(v.checkName(title)){
                    var start = moment(selectionInfo.start).format("Y-MM-DD HH:mm:ss");
                    var end = moment(selectionInfo.end).format("Y-MM-DD HH:mm:ss");
                    if(v.checkEvent(start, end) != null) {
                        $.ajax({
                            url: (URL+"Calendario/insert"),
                            type: "POST",
                            data: {title: title, start: start, end: end},
                            success: function (response) {
                                if(response.includes(",")){
                                    $.notify("Lezione Aggiunta", "success");
                                    document.getElementById("ore_lavoro").innerHTML = "Ore di lezione rimanenti: " + response.split(',')[1];
                                }else if(response == "2"){
                                    $.notify("Giorno non disponibile per lezioni (Solo in spazi verdi)", 'error');
                                }else if(response == "3"){
                                    $.notify("Massimo due lezioni al giorno", 'error');
                                }else if(response == "4"){
                                    $.notify("Non ci possono essere due lezioni nello stesso momento", 'error');
                                }
                                calendar.refetchEvents();
                            }
                        })
                    }else{
                        $.notify("Lezione non valida (Min 1, Max. 4 ore, nell'intervallo 8-17 e nei giorni verdi)", 'error');
                    }
                }else{
                    $.notify("Nome lezione non valido (Min 3 caratteri)", 'error');
                }
            }
        },
        /**
         * Metodo per ingrandire/ridurre un lezione.
         * @param eventResizeInfo La lezione modificata.
         */
        eventResize: function(eventResizeInfo) {
            var start = moment(eventResizeInfo.event.start).format("Y-MM-DD HH:mm:ss");
            var end = moment(eventResizeInfo.event.end).format("Y-MM-DD HH:mm:ss");
            var id = eventResizeInfo.event.id;
            if(v.checkEvent(start, end) != null) {
                $.ajax({
                    url:(URL+"Calendario/resize"),
                    type:"POST",
                    data:{start:start, end:end, id:id},
                    success: function (response) {
                        if(response.includes(",")){
                            $.notify("Lezione Aggiornata", "success");
                            document.getElementById("ore_lavoro").innerHTML = "Ore di lezione rimanenti: " + response.split(',')[1];
                        }else if(response == "2"){
                            $.notify("Non ci possono essere due lezioni nello stesso momento", 'error');
                        }else if(response == "3"){
                            $.notify("Non puoi modificare attività di altri", 'error');
                        }
                        calendar.refetchEvents();
                    }
                })
            }else{
                $.notify("Lezione non valida (Min 1, Max. 4 ore, nell'intervallo 8-17)", 'error');
                calendar.refetchEvents();
            }
        },
        /**
         * Metodo per spostare una lezione.
         * @param eventDropInfo La lezione spostata.
         */
        eventDrop:function(eventDropInfo) {
            var start = moment(eventDropInfo.event.start).format("Y-MM-DD HH:mm:ss");
            var end = moment(eventDropInfo.event.end).format("Y-MM-DD HH:mm:ss");
            var id = eventDropInfo.event.id;
            if(v.checkEvent(start, end) != null) {
                $.ajax({
                    url: (URL+"Calendario/update"),
                    type: "POST",
                    data: {start: start, end: end, id: id},
                    success: function (response) {
                        if (response == "1") {
                            $.notify("Lezione Spostata", "success");
                        } else if (response == "2") {
                            $.notify("Massimo due lezioni al giorno", 'error');
                        } else if (response == "3") {
                            $.notify("Non ci possono essere due lezioni nello stesso momento", 'error');
                        }else if(response == "4"){
                            $.notify("Non puoi modificare attività di altri", 'error');
                        }
                        calendar.refetchEvents();
                    }
                });
            }else{
                $.notify("Lezione non valida (Min 1, Max. 4 ore, nell'intervallo 8-17)", 'error');
                calendar.refetchEvents();
            }
        },
        /**
         * Metodo per eliminare una lezione.
         * @param eventClickInfo La lezione eliminata.
         */
        eventClick:function(eventClickInfo) {
            if(confirm("Sei sicuro di voler eliminare questa lezione?")) {
                var start = moment(eventClickInfo.event.start).format("Y-MM-DD HH:mm:ss");
                var end = moment(eventClickInfo.event.end).format("Y-MM-DD HH:mm:ss");
                var id = eventClickInfo.event.id;
                $.ajax({
                    url:(URL+"Calendario/delete"),
                    type:"POST",
                    data:{id:id, start:start, end:end},
                    success:function(response) {
                        if(response.includes(",")){
                            $.notify("Lezione Eliminata", "success");
                            document.getElementById("ore_lavoro").innerHTML = "Ore di lezione rimanenti: " + response.split(',')[1];
                        }else if(response == "2") {
                            $.notify("Non puoi modificare attività di altri", 'error');
                        }
                        calendar.refetchEvents();
                    }
                })
            }
        }
    });
    calendar.render();

});

