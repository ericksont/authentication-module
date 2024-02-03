<?php 

class Request {

    const GET = 'GET';
    const POST = 'POST';
    
    public static function api ($method, $url, $token='', $data=[]){

        if ($method === self::GET && !empty($data)) 
            $url .= '?' . http_build_query($data);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $header = self::prepareHeaders($token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if($method === self::POST) {
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($data)) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $result = curl_exec($ch);

        $response = self::handleResponse($ch, $result);

        curl_close($ch);
        
        return $response;
		
    }

    private static function prepareHeaders($token) {
        $headers = ['Content-Type: application/json'];
        if ($token !== '') 
            $headers[] = 'Authorization: Bearer ' . $token;
        return $headers;
    }

    private static function handleResponse($ch, $result) {
        if (curl_error($ch)) {
            $type = 'ERROR';
            $message = 'Erro na requisição cURL';
            $result = curl_error($ch);
        } else {
            $type = 'SUCCESS';
            $message = 'Requisição realizada!';
        }
        return Response::obj($type, $message, $result);
    }

}
?>