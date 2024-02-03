<?php 

$ENVIRONMENT = parse_ini_file($_ENV['LIBRARY'].'Authentication/.dev.env');
require_once $_ENV['LIBRARY']."Commons/Conf/conf.php";

header('Content-Type: application/json');

define("ACTION", $_REQUEST["action"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(ACTION === 'login'){

        $data = File::getContents();
        
        if ($data !== null) {
            
            $authentication = new AuthenticationController();
            $result = $authentication->login($data);
            
            if($result->type == 'ERROR' && $result->message == 'Campos obrigatórios não preenchidos'){
                HTTP::_400();
            } else if($result->type == 'ERROR' && $result->message == 'Você já fez essa solicitação!'){
                HTTP::_429();
            } else if($result->type == 'ERROR' && ($result->message == 'Usuário e senha inválidos!')){
                HTTP::_401($result->message, $result->data);
            } else HTTP::_200($result->message, $result->data);

        } else HTTP::_400();
    } else HTTP::_400();
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
} else HTTP::_400();

?>
