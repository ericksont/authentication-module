<?php 

require_once DB;

class SessionService {
    
    function loadByUser($user, $browser) {
        $sql = "SELECT token
                    FROM sessions
                    WHERE user = UNHEX(:user)
                        AND browser = :browser";
        $db = new Db();
        
        $result = $db->read($sql, [":user"=>$user->id, ":browser"=>$browser]);
        
        if($result->type == 'SUCCESS'){
            if(!empty($result->data) || count($result->data) == 1){
                return Response::obj("SUCCESS","Sessão encontrada!", $result->data[0]);
            } else {
                return Response::obj("ALERT","Sessão não encontrada!", ["sql"=>$sql,"dados"=>[":user"=>$user->id, ":browser"=>$browser]]);
            }
        } else {
            return Response::obj("ERROR","Falha ao consultar dados!", ["sql"=>$sql,"dados"=>[":user"=>$user->id, ":browser"=>$browser]]);
        }
    }

    function createSession($user, $browser) {

        $date = date("Y-m-d H:i:s");
        $currentTimestamp = strtotime($date);
                        
        $payload = array(
            'created' => $date
            , 'exp' => strtotime('+6 days', $currentTimestamp)
            , 'id' => $user->id
            , 'name' => $user->name
        );

        $token = JWT::generateToken($payload);
        
        $db = new Db();
        $result = $db->create("sessions", ["user"=>hex2bin($user->id), "date"=>$date, "browser"=>$browser, "token"=>$token], "id");

        if($result->type == "SUCCESS")
            return Response::obj("SUCCESS","Sessão iniciada!",$token);
        else 
            return Response::obj("ERROR","Falha ao criar dados!", $result->data);
    }

}
?>