<title>Registrazione</title>
</head>
<body>
<div class="page-wrapper bg-gra-03 p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w780">
        <div class="card card-4">
            <div class="card-body">
                <h2 class="title">Registrazione</h2>
                <form method="POST" action="<?php echo URL."registrazione/insert/";?>" id="registration_form">
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Nome</label>
                                <input class="input--style-4" type="text" name="first_name">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Cognome</label>
                                <input class="input--style-4" type="text" name="last_name">
                            </div>
                        </div>
                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Numero Telefono</label>
                                <input class="input--style-4" type="text" name="phone_number" onkeydown="fixNumber(this)">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">E-mail</label>
                                <input id="email" class="input--style-4" type="email" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Password</label>
                                <input class="input--style-4" type="password" name="password">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Ripeti Password</label>
                                <input class="input--style-4" type="password" name="re_password">
                            </div>
                        </div>
                    </div>
                    <div class="p-t-15 clearfix">
                        <button class="btn btn--radius-2 btn--blue btn--right btn--register" type="button" onclick="checkAll()">Registrati</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 <script src="js/registration.js"></script>
