<?php 

class JWT {

    public static function generateToken($payload) {
        
        $payload['created'] = date("Y-m-d H:i:s");
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($payload);

        $base64UrlHeader = Base64::urlEncode($header);
        $base64UrlPayload = Base64::urlEncode($payload);

        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, JWT_KEY, true);
        $base64UrlSignature = Base64::urlEncode($signature);

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;
        
    }
    
    
	public static function check($token) {
        if (isset($token)) {
            if(strpos($token, 'Bearer ') === 0){
                
                $token = substr($token, 7);
                
                if (self::checkJWT($token) === true && self::checkExpTime($token) === true){
                    if(self::checkSession($token)) {

                        $token = explode('.', $token)[1];
                        $payload = json_decode(base64_decode($token), true);
                        $result = Response::obj('SUCCESS','JWT válido!', $payload);

                    } else 
                        $result = Response::obj('ERROR','Sem permissão para essa ação!');  
                } else 
                    $result = Response::obj('ERROR','Sem permissão para essa ação!');  
            } else 
                $result = Response::obj('ERROR','Campos obrigatórios não preenchidos!');    
        } else 
            $result = Response::obj('ERROR','Campos obrigatórios não preenchidos!');
        return $result;
    }

    private static function checkJWT($token){
        
        $tokenParts = explode('.', $token);
        if (count($tokenParts) !== 3) 
            return false;
        
        list($headerBase64, $payloadBase64, $signatureBase64) = $tokenParts;
        
        $header = json_decode(base64_decode($headerBase64), true);
        $payload = json_decode(base64_decode($payloadBase64), true);

        if (!$header || !$payload) 
            return false;
        
        $calculateSignature = hash_hmac('sha256', $headerBase64 . '.' . $payloadBase64, JWT_KEY, true);
        $calculateSignatureBase64 = rtrim(strtr(base64_encode($calculateSignature), '+/', '-_'), '=');
        
        if ($signatureBase64 !== $calculateSignatureBase64) 
            return false;

        return true;
        
    }

    private static function checkExpTime($token){

        $token = explode('.', $token);
        $payload = $token[1];
        $payload = json_decode(base64_decode($payload), true);
        
        if (isset($payload["exp"])) {
            $currentTime = time();
            return $currentTime > $payload["exp"] ? false : true;
        } 
        return false;
    }

    private static function checkSession($token){

        $token = explode('.', $token);
        $payload = $token[1];
        $payload = json_decode(base64_decode($payload), true);
        
        if (isset($payload["sub"]) && $payload["sub"] == 'authentication') {
            return true;
        } else {
            // verificar no banco de dados
        }
        return false;
    }

}
?>