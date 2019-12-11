<title>Cambia Password</title>
</head>
<body>
<div class="page-wrapper bg-gra-03 p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w780">
        <div class="card card-4">
            <div class="card-body">
                <h2 class="title">Modifica la tua password</h2>
                <form method="POST" action="<?php echo URL; ?>cambiaPassword/modifyPassword" id="changePassword">
                    <div class="row row-space">
                        <div class="col-2">
                            <img class="btn--radius" src="img\calendar.jpg" width="100%" height="90%">
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Nuova Password:</label>
                                <input class="input--style-4" type="password" name="password">
                            </div>
                            <div class="input-group">
                                <label class="label">Ripeti Password</label>
                                <input class="input--style-4" type="password" name="re_password">
                            </div>
                        </div>
                    </div>
                    <div class="p-t-15 clearfix">
                        <button class="btn--login btn btn--radius-2 btn--blue btn--right" name="login" type="button" onclick="checkAll()">Cambia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/changePassword.js"></script>
