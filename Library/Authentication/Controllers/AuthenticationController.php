<?php 

require_once LIBRARY.MODULE.'/Services/AuthenticationService.php';

class AuthenticationController {
    
    function login ($data){
        $action = ActionRecord::lastAction("login", array($data), 15);
        if($action->type != "SUCCESS")
            return Response::obj("ERROR","Você já fez essa solicitação!");

        $service = new AuthenticationService();
        return $service->login($data);
    }

}
?>