<?php 

class SessionService {
    
    function loadByUser($user) {
        

        // Agora verificar se ja tem alguma sessão em aberto e pega o token...
        // user, date, ip, browser
        
        $sql = "SELECT token
                    FROM `sessions`
                    WHERE user = UNHEX(:user)";
        $db = new Db();
        
        $result = $db->read($sql, [":user"=>$user->id]);
        
        if($result->type == 'SUCCESS'){
            if(!empty($result->data) || count($result->data) == 1){
                return Response::obj("SUCCESS","Sessão encontrada!", $result->data[0]);
            } else {
                return Response::obj("ERROR","Sessão não encontrada!", ["sql"=>$sql,"dados"=>[":user"=>$user->id]]);
            }
        } else {
            return Response::obj("ERROR","Falha ao consultar dados!", ["sql"=>$sql,"dados"=>[":user"=>$user->id]]);
        }
    }

    

}
?>