<?php $ENVIRONMENT = parse_ini_file('/var/www/Library/Authentication/.env'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Tela de Login</title>

    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" href="/vendors/font-awesome/font-awesome.min.css" >

    <link rel="stylesheet" href="/vendors/pnotify/pnotify.css" >
    <link rel="stylesheet" href="/vendors/pnotify/pnotify.buttons.css" >
    <link rel="stylesheet" href="/vendors/pnotify/pnotify.nonblock.css" >-->

    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <div class="root">

        <!--<a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>
        <a class="hiddenanchor" id="request-pass"></a>-->

        <div class="banners" ></div>

        <div class="content">

            <section class="animate container login-form">
                <h1> Autenticação </h1>
                <form>
                    <input type="text" id="user" placeholder="E-mail" />
                    <input type="password" id="pass" placeholder="Senha" />
                    <div class="actions">
                        <a class="btn" href="javascript:;" onClick="authentication.login()">Entrar</a>
                        <!-- <a class="reset_pass" href="#request-pass">Esqueceu sua senha?</a> -->
                    </div>
                </form>
                
                <div class="separator">
                    <h1>d'Sousa</h1>                    
                </div>
                
            </section>
            
            <!--<section class="animate container request-pass">
                <h1>Recuperar Senha</h1>
                <form>
                    <input type="email" id="email" placeholder="E-mail" />
                    <a class="btn" href="#">Enviar</a>
                </form>
                <div class="separator">
                    <p class="change_link">Lembrou sua senha?
                        <a href="#signin" onClick="authentication.login()"> Login </a>
                    </p>
                    <h1>d'Sousa</h1>                    
                </div>
            </section>-->

            <div class="loading"></div>
            
        </div>

    </div>

    <script src="js/authentication.js"></script>

    <script>
        const API = '<?php print $ENVIRONMENT['API'] ?>'
    </script>

    <!--<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="/vendors/pnotify/pnotify.js"></script>
    <script src="/vendors/pnotify/pnotify.buttons.js"></script>
    <script src="/vendors/pnotify/pnotify.nonblock.js"></script>
    
    <script src="/js/environment.js"></script>
    -->
    
</body>
</html>