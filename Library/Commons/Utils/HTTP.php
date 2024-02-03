<?php

class HTTP {

    public static function _400() {
		http_response_code(400);
        print Response::json("ERROR",htmlentities("Requisição inválida."));
    }

    public static function _200($message="",$data="") {
		http_response_code(200);
        print Response::json("SUCCESS",htmlentities($message),$data);
    }

    public static function _429() {
		http_response_code(429);
        print Response::json("ERROR","Você já fez essa solicitação! \n Espere alguns instantes.");
    }

    public static function _401($message="Sem permissão para essa ação!",$data="") {
		http_response_code(401);
        print Response::json("ERROR",$message,$data);
    }

    public static function _500() {
		http_response_code(500);
        print Response::json("ERROR","O servidor encontrou uma situação com a qual não sabe lidar.");
    }

}

?>