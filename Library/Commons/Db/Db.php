<?php 

require LIBRARY."Commons/Db/Log.php";

require_once "MySQL.php";

class Db {

    private $db;
    
	function __construct() {
        if(DB_TYPE === "MySQL")
            $this->db = new MySQL(DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS);
	}

    function create ($table, $fields=array(), $returningId = "") {
        return $this->db->create($table, $fields, $returningId);
    }

    function read ($sql, $values=array()) {
        return $this->db->read($sql, $values);
    }

    function update($table, $fields, $condition){
        return $this->db->update($table, $fields, $condition);
    }

    function physicalDelete ($table, $condition=array()) {
        return $this->db->physicalDelete($table, $condition);
    }

}

?>