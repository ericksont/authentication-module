<?php 

require_once LIBRARY.MODULE.'/Services/UserService.php';

class UserController {
    
    function readByUser ($data){
        $action = ActionRecord::lastAction("login", array($data), 15);
        if($action->type != "SUCCESS")
            return Response::obj("ERROR","Você já fez essa solicitação!");

        $service = new UserService();
        return $service->readByUser($data);
    }

}
?>