<?php $ENVIRONMENT = parse_ini_file('/var/www/Library/Authentication/.dev.env'); ?>
<!DOCTYPE html>
<html lang="en">

    <?php require_once 'requires/head.php'; ?>

    <body>
        <div class="root">

            <div class="banners" ></div>

            <div class="content">

                <section class="animate container login-form">
                    <h1> Autenticação </h1>
                    <form>
                        <input type="text" id="user" placeholder="E-mail" />
                        <input type="password" id="pass" placeholder="Senha" />
                        <div class="actions">
                            <a class="btn" href="javascript:;" onClick="authentication.login()">Entrar</a>
                        </div>
                    </form>
                    
                    <div class="separator">
                        <h1>d'Sousa</h1>                    
                    </div>
                    
                </section>
            
                <div class="loading"></div>
                
            </div>

        </div>

        <script src="js/authentication.js"></script>

        <script>
            document.title = document.title + ' | Autenticação '
            const API = '<?php print $ENVIRONMENT['API'] ?>'
        </script>
        
    </body>
</html>