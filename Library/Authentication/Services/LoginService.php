<?php 

class LoginService {

    private $attempts = 3;
    
    function login ($data){

        $user = $data->user ?? '';
        $pass = $data->pass ?? '';
        $project = $data->project ?? '';

        if($user != "" && $pass != "" && $project != ""){

            $token = $this->generateToken();
            $APIResult = $this->verifyUser($user, $pass, $token);
                        
            if($APIResult->type === "SUCCESS") {

                var_dump($APIResult->data);
                
                // Agora verificar se ja tem alguma sessão em aberto e pega o token...
                //$session = new SessionController();
                //$session->loadByUser($APIResult->data);



                // senão tiver sessão ou se a sessão não for mais valida
                
                
                
                
                
                // gera o token e grava na tabela de sessões

                $return = Response::obj("SUCCESS","Usuário logou no sistema",$APIResult);

            } else if ($this->attempts <= $session) 
                $return = Response::obj("ERROR","Senha bloqueada por excesso de tentativas!",["tentativa"=>$session,"total_tentativas"=>$this->attempts]);
            else
                $return = Response::obj("ERROR","Usuário e senha inválidos!",["tentativa"=>$session,"total_tentativas"=>$this->attempts]);

        } else 
            $return = Response::obj("ERROR","Campos obrigatórios não preenchidos",$data);
        
        return $return;
		
    }

    private function generateToken() {
        $payloadData = [
            'sub' => 'authentication',
            'projects' => 'AUTHENTICATION',
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