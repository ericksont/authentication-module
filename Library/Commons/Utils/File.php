<?php 

class File {
    
    public static function getContents() {
	
        $json = file_get_contents('php://input');
        return json_decode($json);
		
	}

}
?>