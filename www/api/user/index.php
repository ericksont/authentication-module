<?php 

$ENVIRONMENT = parse_ini_file($_ENV['LIBRARY'].'User/.dev.env');
require_once "/var/www/Library/Commons/Conf/conf.php";

header('Content-Type: application/json');

define("ACTION", $_REQUEST["action"] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if(ACTION === 'login'){
        
        $query = $_GET['user'] ?? '';
        
        $user = new UserController();
        $result = $user->readByUser($query);

        if($result->type == 'ERROR' && $result->message == 'Você já fez essa solicitação!')
            HTTP::_429();
        else if($result->type == 'ERROR' && $result->message == 'Sem permissão para essa ação!')
            HTTP::_401();
        else 
            HTTP::_200('Requisição efetuada com sucesso!',$result->data);
        
    } else HTTP::_400();

} else HTTP::_400();

?>
