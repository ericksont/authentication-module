<?php

date_default_timezone_set("America/Fortaleza");
session_status() !== PHP_SESSION_ACTIVE ? session_start() : null;

define("SHOW_ERROR", $_ENV["SHOW_ERROR"]);
define("SHOW_SQL", $_ENV["SHOW_SQL"]);

if(SHOW_ERROR == "1"){
	ini_set("display_errors",1);
	ini_set("display_startup_erros",1);
	error_reporting(E_ALL);
}

define("JWT_KEY", $_ENV["JWT_KEY"]);

/** PATHS */
define("DOMAIN", $_ENV["DOMAIN"]);
define("API", $_ENV["API"]);
define("DB", $_ENV["DB"]);
define("LIBRARY", $_ENV["LIBRARY"]);

if(isset($ENVIRONMENT)){

	isset($ENVIRONMENT["MODULE"]) ? define("MODULE", $ENVIRONMENT["MODULE"]) : null;

	/** DATA BASE */
	isset($ENVIRONMENT["DB_TYPE"]) ? define("DB_TYPE", $ENVIRONMENT["DB_TYPE"]) : null;
	isset($ENVIRONMENT["DB_HOST"]) ? define("DB_HOST", $ENVIRONMENT["DB_HOST"]) : null;
	isset($ENVIRONMENT["DB_PORT"]) ? define("DB_PORT", $ENVIRONMENT["DB_PORT"]) : null;
	isset($ENVIRONMENT["DB_NAME"]) ? define("DB_NAME", $ENVIRONMENT["DB_NAME"]) : null;
	isset($ENVIRONMENT["DB_USER"]) ? define("DB_USER", $ENVIRONMENT["DB_USER"]) : null;
	isset($ENVIRONMENT["DB_PASS"]) ? define("DB_PASS", $ENVIRONMENT["DB_PASS"]) : null;
}

/** AUTOLOADER TO CLASSES */
function autoLoader($className){

	$directories = array(
		LIBRARY."Commons/Utils/",
		LIBRARY.MODULE."/Controllers/"
	);

	foreach($directories as $directory){
		$path = $directory.sprintf('%s.php', $className);
		if(file_exists($path)){
			include_once $path;
			return;
		} else {
			$return = Response::obj("ERROR","Não foi possível encontrar o arquivo da Classe!",$path);
		}
	}
	return $return;
}
spl_autoload_register('autoLoader');
?>
