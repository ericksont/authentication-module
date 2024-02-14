<?php

    require_once DB;

    class LogService {

        private $table = "logs";

        function create($user, $action, $values="") {

            $date = date("Y-m-d H:i:s");

            $db = new Db();
            $return = $db->create($this->table, ["user"=>hex2bin($user->id), "date"=>$date, "action"=>$action], 'id');

            if($values != "")
                $db->create('logs_values', ["log"=>$return->data, "value"=>$values]);

            return $return;

        }

    }

?>