<?php 

class Response {
    
    public static function json ($type="", $message="", $data=null){

        $result = self::obj($type, $message, $data);
        return json_encode($result);
		
    }

	public static function obj ($type="", $message="", $data=null){
        
        $obj = new stdClass();

        if($type=="" || $message==""){    
            $obj->type = "ERROR";
            $obj->typeDescription = "Erro";
            $obj->message = "Não foi possível carregar o retorno da solicitação. \n Verifiquer a chamada ao retorno.";
            $obj->data = "";
        } else if($type!="SUCCESS" && $type!="ERROR" && $type!="ALERT"){
            $obj->type = "ERROR";
            $obj->typeDescription = "Erro";
            $obj->message = "Não foi informado um tipo de retorno correto.";
            $obj->data = "";
        } else {
            if($type == "SUCCESS")
                $typeDescription = "Sucesso";
            else if($type == "ERROR")
                $typeDescription = "Erro";
            else if($type == "ALERT")
                $typeDescription = "Alerta";

            $obj->type = $type;
            $obj->typeDescription = $typeDescription;
            $obj->message = $message;
            $obj->data = $data;
        }
        
        return $obj;
		
    }

}
?>