<title>Recupera Password</title>
</head>
<body>
<div class="page-wrapper bg-gra-03 p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w780">
        <div class="card card-4">
            <div class="card-body">
                <h2 class="title">Password dimenticata?</h2>
                <form method="POST" action="<?php echo URL; ?>passwordDimenticata/sendEmail">
                    <div class="row row-space">
                        <div class="col-2">
                            <img class="btn--radius" src="img\calendar.jpg" width="100%" height="90%">
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <span>Inserisci la tua email per ricevere un link di recupero password:</span>
                                <label class="label margin-top-20">Email</label>
                                <input class="input--style-4" type="email" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="p-t-15 clearfix">
                        <button class="btn--login btn btn--radius-2 btn--blue btn--right" name="sendNewPassword" type="submit">Invia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
