<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Tela de Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="/css/style.css">
    
</head>
<body>
    <div class="root">

        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>
        <a class="hiddenanchor" id="request-pass"></a>

        <div class="banners" ></div>
        <div class="content">

            <section class="animate container login-form">
                <h1> Autenticação </h1>
                <form>
                    <input type="text" placeholder="Username" />
                    <input type="password" placeholder="Password" />
                    <div class="actions">
                        <a class="btn" href="javascript:;" onClick="authentication.login()">Entrar</a>
                        <a class="reset_pass" href="#request-pass">Esqueceu sua senha?</a>
                    </div>
                </form>
                
                <div class="separator">
                    <h1>d'Sousa</h1>                    
                </div>

                <div class="loading loading_login_form"></div>
                
            </section>
            
            <section class="animate container request-pass">
                <h1>Recuperar Senha</h1>
                <form>
                    <input type="email" placeholder="E-mail" />
                    <a class="btn" href="#">Enviar</a>
                </form>
                <div class="separator">
                    <p class="change_link">Lembrou sua senha?
                        <a href="#signin" > Login </a>
                    </p>

                    <h1>d'Sousa</h1>                    
                </div>
            </section>
            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="/js/authentication.js"></script>
    
</body>
</html>