<title>Login</title>
</head>
<body>
<div class="page-wrapper bg-gra-03 p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w780">
        <div class="card card-4">
            <div class="card-body">
                <h2 class="title">Login</h2>
                <form method="POST" action="<?php echo URL; ?>login/access">
                    <div class="row row-space">
                        <div class="col-2">
                            <img class="btn--radius" src="img\calendar.jpg" width="100%" height="90%">
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label class="label">Email</label>
                                <input class="input--style-4" type="email" name="email">
                            </div>
                            <div class="input-group">
                                <label class="label">Password</label>
                                <input class="input--style-4" type="password" name="password">
                                <a class="lin" href="<?php echo URL.'passwordDimenticata'; ?>">Hai dimenticato la password?</a>
                            </div>
                        </div>
                    </div>
                    <div class="p-t-15 clearfix">
                        <a class="lin--btn btn btn--radius-2 btn--blue" href="<?php echo URL.'registrazione'; ?>">Registrati</a>
                        <button class="btn--login btn btn--radius-2 btn--blue btn--right" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
