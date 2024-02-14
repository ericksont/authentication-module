<?php 

require_once LIBRARY.MODULE.'/Services/SessionService.php';

class LoginService {

    private $attempts = 3;
    
    function login ($data){

        $user = $data->user ?? '';
        $pass = $data->pass ?? '';
        $project = $data->project ?? '';

        if($user != "" && $pass != "" && $project != ""){

            $token = $this->generateToken('AUTHENTICATION');
            $APIResult = $this->verifyUser($user, $pass, $token);
                        
            if($APIResult->type === "SUCCESS") {

                $browser = $_SERVER['HTTP_USER_AGENT'];
                
                $session = new SessionService();
                $result = $session->loadByUser($APIResult->data, $browser);
                $user = $APIResult->data;
                
                if($result->type == 'SUCCESS'){

                    unset($user->password);
                    $return = Response::obj("SUCCESS","Sessão encontrada!", ["user"=>$user, "token"=>$result->data->token]);

                } else if($result->type == 'ALERT'){
                    
                    $result = $session->createSession($user, $browser);
                    
                    if($result->type == "SUCCESS") {

                        unset($user->password);
                        $return = Response::obj("SUCCESS","Usuário entrou no sistema!", ["user"=>$user, "token"=>$result->data]);

                    } else $return = Response::obj("ERROR","Falha ao cadastrar dados!", $result->data);
                } else $return = Response::obj("ERROR","Falha ao consultar dados!", $result->data);

            } else
                $return = Response::obj("ERROR","Usuário e senha inválidos!");

        } else 
            $return = Response::obj("ERROR","Campos obrigatórios não preenchidos",$data);
        
        return $return;
		
    }

    private function generateToken($project) {
        $payloadData = [
            'sub' => 'authentication',
            'projects' => $project,
            'roles' => 'LOGIN',
            'exp' => time() + 60
        ];
        return JWT::generateToken($payloadData);
    }

    private function verifyUser($user, $pass, $token){
        $result = Request::api('GET',API.'user/login',$token,['user'=>$user]);
        $dbpass = json_decode($result->data)->data !== "" ? json_decode($result->data)->data->password : "";
        $verify = password_verify($pass, $dbpass) ? true : false;

        if($verify === true)
            $result = Response::obj("SUCCESS","Usuário retornado com sucesso",json_decode($result->data)->data);
        else
            $result = Response::obj("ERROR","Usuário não encontrado");
        return $result;
    }

}
?>