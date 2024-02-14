<?php 

require_once LIBRARY.MODULE.'/Services/AuthenticationService.php';
require_once LIBRARY.MODULE.'/Services/LogService.php';

class AuthenticationController {
    
    function login ($data){
        $action = ActionRecord::lastAction("login", array($data), 15);
        if($action->type != "SUCCESS")
            return Response::obj("ERROR","Você já fez essa solicitação!");

        $service = new AuthenticationService();
        $return = $service->login($data);

        if($return->type == 'SUCCESS') {
            $log = new LogService();
            $log->create($return->data['user'], 1);
        }

        return $return;
    }

}
?>