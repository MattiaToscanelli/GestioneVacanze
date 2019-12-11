/**
 * Script utilizzato per mostrare il calendario ai non docenti,
 * in quanto non è possibile effetuttare modifiche.
 */
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'timeGridWeek,listMonth'
        },
        events: (URL+'Calendario/load'),
        defaultView: 'timeGridWeek',
        defaultDate: moment(new Date()).format("Y-MM-DD"),
        navLinks: true, // can click day/week names to navigate views
        locale: 'it',
        timeZone: 'local',
        firstDay: 1,
        selectable:true,
        selectHelper:true,
        /**
         * Metodo per ricavare le info di una lezione.
         * @param eventClickInfo La lezione cliccata.
         */
        eventClick:function(eventClickInfo) {
            var date = moment(eventClickInfo.event.start).format("Y-MM-DD");
            var start = moment(eventClickInfo.event.start).format("HH:mm:ss");
            var end = moment(eventClickInfo.event.end).format("HH:mm:ss");
            var title = eventClickInfo.event.title;
            alert("Lezione di "+title+"\nData: "+date+"\nOra inizio: "+start+"\nOra fine: "+end);
        }
    });
    calendar.render();
});