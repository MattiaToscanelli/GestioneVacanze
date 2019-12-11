<title>Pannello Admin</title>
</head>
<body>
<div class="page-wrapper bg-gra-03 p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w1280">
        <div class="card card-4">
            <div class="card-body">
                <div class="p-t-15 clearfix">
                    <i class="fa fa-sign-out home-btn" aria-hidden="true" onclick="location.replace('<?php echo URL.'logout'; ?>')"></i>
                    <i class="m-r-10 fa fa-home home-btn" aria-hidden="true" onclick="location.replace('<?php echo URL.'calendario'; ?>')"></i>
                </div>
                <div>
                </div>
                <h1 class="title">Pannello Admin</h1>
                <div class="row row-space margin-top-20">
                    <h3 class="title p-t-40">Gestione Utenti:</h3>
                </div>
                <div class="table-responsive module">
                    <table class="table">
                        <thead class="dark">
                        <tr>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Telefono</th>
                            <th>Ore Lavoro Rimanenti</th>
                            <th>Tipo</th>
                            <th>Verificato</th>
                            <th>Email</th>
                            <th>Modifica</th>
                            <th>Elimina</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td style="text-align: center"><?php echo $user[DB_USER_NAME]; ?></td>
                                <td style="text-align: center"><?php echo $user[DB_USER_SURNAME]; ?></td>
                                <td style="text-align: center"><?php echo $user[DB_USER_PHONE]; ?></td>
                                <td style="text-align: center"><?php echo $user[DB_USER_HOURS]; ?></td>
                                <td style="text-align: center"><?php echo $user[DB_USER_TYPE]; ?></td>
                                <td style="text-align: center"><?php echo ($user[DB_USER_VERIFY]==1?"&#10004":"&#10006"); ?></td>
                                <td style="text-align: center"><?php echo $user[DB_USER_EMAIL]; ?></td>
                                <td style="text-align: center"><a href="<?php echo URL.'pannelloAdmin/modifyUser/'.$user[DB_USER_EMAIL]; ?>"class="l-black"><i class="fa fa-pencil-square-o"></i></a></td>
                                <td style="text-align: center"><a onclick="deleteUser('<?php echo URL.'pannelloAdmin/deleteUser/'.$user[DB_USER_EMAIL]; ?>')" class="l-black pointer"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if(isset($_SESSION[SESSION_MODIFY])): ?>
                <form method="POST" action="<?php echo URL.'pannelloAdmin/modifyUser/'.$_SESSION[SESSION_EMAIL_MODIFY]; ?>" id="admin_form" class="margin-top-20">
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Nome</label>
                                <input class="input--style-4" type="text" name="first_name" value="<?php echo $_SESSION[SESSION_FIRST_NAME]; ?>">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Cognome</label>
                                <input class="input--style-4" type="text" name="last_name" value="<?php echo $_SESSION[SESSION_LAST_NAME]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Numero Telefono</label>
                                <input class="input--style-4" type="text" name="phone_number" onkeydown="fixNumber(this)" value="<?php echo $_SESSION[SESSION_PHONE_NUMBER]; ?>">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Verificato</label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select name="verify">
                                        <option <?php echo ($_SESSION[SESSION_VERIFY]==0)?'selected':''; ?>>Non verificato</option>
                                        <option <?php echo ($_SESSION[SESSION_VERIFY]==1)?'selected':''; ?>>Verificato</option>
                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Tipo</label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select name="type" id="type" onchange="viewHourOnChange(this)">
                                        <option <?php echo ($_SESSION[SESSION_USER_TYPE]=='Gestore')?'selected':''; ?>>Gestore</option>
                                        <option <?php echo ($_SESSION[SESSION_USER_TYPE]=='Docente')?'selected':''; ?>>Docente</option>
                                        <option <?php echo ($_SESSION[SESSION_USER_TYPE]=='Visualizzatore')?'selected':''; ?>>Visualizzatore</option>
                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2" id="hour">
                            <div class="input-group">
                                <label class="label">Ore rimanenti</label>
                                <input class="input--style-4" type="number" name="hours" value="<?php echo $_SESSION[SESSION_WORK_HOURS]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="p-t-15 clearfix">
                        <input type="button" class="lin--btn btn btn--radius-2 btn--blue btn--panel-admin" style="float: right" onclick="checkAll()" value="Modifica"/>
                    </div>
                </form>
                <?php endif; ?>
                <div class="row row-space margin-top-20">
                    <h3 class="title p-t-70">Reimposta ore di lavoro per docenti:</h3>
                </div>
                <form method="POST" action="<?php echo URL.'pannelloAdmin/setAllHours'; ?>" id="setHours">
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Ore di lavoro:</label>
                                <input id="hours_teacher" class="input--style-4" type="number" name="hours_teacher">
                            </div>
                        </div>
                    </div>
                    <div class="p-t-15 clearfix">
                        <input type="button" class="lin--btn btn btn--radius-2 btn--blue btn--panel-admin" value="Modifica" onclick="checkHoursTeacher()"/>
                    </div>
                </form>
                <div class="row row-space margin-top-20">
                    <h3 class="title p-t-70">Gestione Calendario:</h3>
                </div>
                <div class="row row-space">
                    <div id='calendar'></div>
                </div>
                <div class="row row-space m-t-20">
                    <h3 class="title p-t-70">Giorni disponibili per lezioni:</h3>
                </div>
                <div class="table-responsive module">
                    <table class="table">
                        <thead class="dark">
                        <tr>
                            <th>Giorno</th>
                            <th>Elimina</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($days as $day): ?>
                            <tr>
                                <?php foreach ($day as $row): ?>
                                    <td style="text-align: center"><?php echo $row; ?></td>
                                <?php endforeach; ?>
                                <td style="text-align: center"><a onclick="deleteDay('<?php echo URL.'pannelloAdmin/deleteDay/'.$day["giorno"]; ?>')" class="l-black pointer"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <form id="dayPanel" method="post" action="<?php echo URL.'pannelloAdmin/addDay'; ?>">
                    <div class="row row-space p-t-20 p-b-60">
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Giorno lezione</label>
                                <div class="input-group-icon">
                                    <input id="dateDay" class="input--style-4 js-datepicker" type="text" name="working_day" readonly>
                                    <i class="fa fa-calendar-o input-icon js-btn-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-t-15 clearfix">
                        <a class="lin--btn btn btn--radius-2 btn--red" onclick="deleteDays('<?php echo URL.'pannelloAdmin/deleteDays'; ?>')">Elimina Tutti</a>
                        <input type="button" class="lin--btn btn btn--radius-2 btn--blue btn--panel-admin" onclick="addDay()" value="Aggiungi"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/managementPanelAdmin.js"></script>