<title>Calendario</title>
</head>
<body>
<div class="page-wrapper bg-gra-03 p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w1280">
        <div class="card card-4">
            <div class="card-body">
                <div class="p-t-15 clearfix">
                    <i class="fa fa-sign-out home-btn" aria-hidden="true" onclick="location.replace('<?php echo URL.'logout'; ?>')"></i>
                </div>
                <h1 class="title">Bentornato/a <?php echo $_SESSION[SESSION_NAME]." ".$_SESSION[SESSION_SURNAME]; ?></h1>
                <?php if($_SESSION[SESSION_TYPE] == "Docente"): ?>
                    <div class="row row-space p-b-20">
                        <h4 id="ore_lavoro">Ore di lezione rimanenti: <?php echo $_SESSION[SESSION_HOURS_WORK] ?></h4>
                    </div>
                <?php endif; ?>
                <div id="cal" class="row row-space">
                    <div id='calendar'></div>
                </div>
                <div class="p-t-15 clearfix">
                    <a class="lin--btn btn btn--radius-2 btn--blue btn--right" onclick="window.print()">Stampa</a>
                </div>
                <?php if($_SESSION[SESSION_TYPE] == "Gestore"): ?>
                <div class="row row-space m-t-20">
                    <h3 class="title">Gestione pagina:</h3>
                </div>
                <div class="row row-space">
                    <span>Clicca il bottone rosso per accedere alla pagina di amministrazioen dove potrai gestire gli
                    registrati al sito e aggiungere/modificare/rimovere giorni di lezione.</span>
                </div>
                <div class="p-t-15 clearfix">
                    <a id="btn--admin" class="lin--btn btn btn--radius-2 btn--red" href="<?php echo URL.'pannelloAdmin'; ?>">Pannello Admin</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>