<?php 

require_once LIBRARY.MODULE.'/Services/LoginService.php';

class AuthenticationService {
    
    function login ($data){
        $login = new LoginService();
        return $login->login($data);
    }

    

}
?>