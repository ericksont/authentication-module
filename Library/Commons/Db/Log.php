<?php 

class Log {
    
    function writeTxt($txt) {
        $message = date("d/m/Y H:i:s")." ---------------------------------------------- \n";
        $message .= $txt."\n\n\n";

        $fp = fopen(LIBRARY."Commons/logs.txt", "a");
        fwrite($fp, $message);
        fclose($fp); 
    }
    
}

?>