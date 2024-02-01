<?php 

require_once DB;

class UserService {
    
    function readByUser ($user){

        $sql = "SELECT HEX(id) as id, name, password 
                    FROM `users`
                    WHERE user = :user
                        AND status = 1";
                        
        $db = new Db();
        $result = $db->read($sql, [":user"=>$user]);
        
        if($result->type == 'SUCCESS'){
            if(!empty($result->data) || count($result->data) == 1){
                return Response::obj("SUCCESS","Usuário encontrado!", $result->data[0]);
            } else {
                return Response::obj("ERROR","Usuário não encontrado!", ["sql"=>$sql,"dados"=>[":user"=>$user]]);
            }
        } else {
            return Response::obj("ERROR","Falha ao consultar dados!", ["sql"=>$sql,"dados"=>[":user"=>$user]]);
        }
    }

}
?>