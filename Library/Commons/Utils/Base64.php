<?php 

class Base64 {
    
    public static function urlEncode ($data=""){
        $base64 = base64_encode($data);
        $base64Url = str_replace(['+', '/', '='], ['-', '_', ''], $base64);
        return $base64Url;
    }

}
?>