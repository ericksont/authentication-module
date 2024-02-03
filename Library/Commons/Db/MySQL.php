<?php 

class MySQL {
    
	private $conn;

	function __construct($host, $port, $dbname, $user, $pass) {
		try {
			$this->conn = new PDO("mysql:host=".$host.";port=".$port.";dbname=".$dbname, $user, $pass);
			if(SHOW_ERROR === 1)
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return Response::obj("SUCCESS","Conexão realizada com sucesso!.");
		} catch (PDOException $e){
			$log = new Log();
			$log->writeTxt($e);
			return Response::obj("ERROR","Erro no processamento! \n Entre em contato com o suporte e informe a data e hora do erro.");
		}
    }

	function create ($table, $fields, $returningId) {
		
		if($table == "" || $fields == "" || empty($fields))
			$return = Response::obj("ALERT","Parâmetros obrigatórios não preenchidos!"); 
		else {
			
			$fieldsList = [];
			$valuesList = [];

			foreach ($fields as $key => $val) {

				if($val == 'null')
					unset($fields["$key"]);
				else {
					$fieldsList[] = $key;
					$valuesList[] = ":".$key;
				}
				
			}

			$sql = "INSERT INTO " .  $table  . " (".implode(",",$fieldsList).") VALUES (".implode(",",$valuesList).");";
			SHOW_SQL == "1" ? $this->printSQL($sql, $fields) : null;
			
			try {
				$rs = $this->conn->prepare($sql);
				$rs->execute($fields);

				if($returningId != "") {
					$lastId = $this->conn->lastInsertId();
					$return = Response::obj("SUCCESS","Registro inserido com sucesso!", $lastId);
				} else
					$return = Response::obj("SUCCESS","Registro inserido com sucesso!"); 
				
			} catch (PDOException $e){
				$log = new Log();
				$log->writeTxt("Método: create -- \n".$e."\n \n".json_encode(array($sql, $fields)));
				$return = Response::obj("ERROR","Erro no processamento! \n Entre em contato com o suporte e informe a data e hora do erro.");
			}
			
		}
			
		return $return;
	}

	function read ($sql, $values) {
		
		if($sql == ""){
			$return = Response::obj("ALERT","Os parâmentros obrigatórios para consulta, não foram preenchidos!");
		} else {

			SHOW_SQL == "1" ? $this->printSQL($sql, $values) : null;
				
			try{
				$list = array();
				$rs = $this->conn->prepare($sql);

				if($rs->execute($values)){
					if($rs->rowCount() > 0){
						$i = 0;
						while($row = $rs->fetch(\PDO::FETCH_OBJ)){
							$list[$i] = $row;
							$i++;
						}
					}
				}
				$return = Response::obj("SUCCESS","Lista retornada com sucesso!", $list);
			} catch (PDOException $e){
				$log = new Log();
				$log->writeTxt("Método: read -- \n".$e."\n \n".json_encode(array($sql, $values)));
				$return = Response::obj("ERROR","Erro no processamento! \n Entre em contato com o suporte e informe a data e hora do erro.");
			}
				
		} 
		
		return $return; 
		
	}

	function update($table, $fields, $condition){

		if($table == "" || $fields == "" || empty($fields))
			$return = Response::obj("ALERT","Parâmetros obrigatórios não preenchidos!"); 
		else {

			$fieldsList = [];

			foreach ($fields as $key => $val) {

				if($val == 'null')
					unset($fields["$key"]);
				else {
					$fieldsList[] = $key." = :".$key;
				}
				
			}

			$conditions = [];
			$values = [];

			foreach ($condition as $key => $val) {

				$operators = isset($val->condition) ? $val->condition : "";

				$conditions[] = $operators." ".$key." ".$val->operator." :".$key;
				$fields[$key] = $val->value;
					
			}

			$sql = "UPDATE " .  $table  . " SET ".implode(", ",$fieldsList)." WHERE ".implode(" ",$conditions).";";
			
			SHOW_SQL == "1" ? $this->printSQL($sql, $fields) : null;
			
			try {
				$rs = $this->conn->prepare($sql);
				$rs->execute($fields);

				$return = Response::obj("SUCCESS","Registro editado com sucesso!"); 
				
			} catch (PDOException $e){
				$log = new Log();
				$log->writeTxt("Método: create -- \n".$e."\n \n".json_encode(array($sql, $fields)));
				$return = Response::obj("ERROR","Erro no processamento! \n Entre em contato com o suporte e informe a data e hora do erro.");
			}
			
		}
			
		return $return;

	}	

	function physicalDelete ($table, $condition) {

		if($table == "")
			$return = Response::obj("ALERT","Parâmetros obrigatórios não preenchidos!"); 
		else {
			
			$conditions = [];
			$values = [];
			
			foreach ($condition as $key => $val) {

				$operators = isset($val->condition) ? $val->condition : "";

				$conditions[] = $operators." ".$key." ".$val->operator." :".$key;
				$values[":".$key] = $val->value;
					
			}

			$sql = "DELETE FROM ".$table." WHERE ".implode(" ",$conditions);
			SHOW_SQL == "1" ? $this->printSQL($sql, $condition) : null;

			try {
				
				$rs = $this->conn->prepare($sql);
				$rs->execute($values);

				$return = Response::obj("SUCCESS","Registro removido com sucesso!"); 
				
			} catch (PDOException $e){
				$log = new Log();
				$log->writeTxt("Método: create -- \n".$e."\n \n".json_encode(array($sql, $fields)));
				$return = Response::obj("ERROR","Erro no processamento! \n Entre em contato com o suporte e informe a data e hora do erro.");
			}

			return $return;
			
		}

	}

	function printSQL($sql, $values){
		$data = array("SQL"=>$sql, "data"=>implode(", ",$values));
		$dataString = implode("; \n", $data);
		$log = new Log();
		$log->writeTxt($dataString);
	}
	
}

?>