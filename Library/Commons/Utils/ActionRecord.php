<?php

class ActionRecord {

    public static function lastAction($action,$data=null,$time=null) {
		
        $validTime = true;
        if($time !== null && is_int($time)){
            $now = new DateTime();
            $now->modify('-'.$time.' second');
            
            if(isset($_SESSION["action"]["time"]) && strtotime($_SESSION["action"]["time"]) > strtotime($now->format("Y-m-d H:i:s")))
                $validTime = false;
        }
        
        if(isset($_SESSION["action"]) && $_SESSION["action"]["name"] == $action && $_SESSION["action"]["data"] == $data && $validTime === false){
            $return = Response::obj("ALERT", "Ação já efetuada!");
        } else {
            $return = Response::obj("SUCCESS", "A ação pode ser efetuada novamente!");
            $_SESSION["action"]["name"] = $action;
            $_SESSION["action"]["data"] = $data;
            $time = new DateTime();
            $_SESSION["action"]["time"] = $time->format("Y-m-d H:i:s");
        }

        return $return;

    }

}

?>