<?php

date_default_timezone_set("America/Fortaleza");
session_status() !== PHP_SESSION_ACTIVE ? session_start() : null;

$ENVIRONMENT_DEFAULT = parse_ini_file('.env');

define("SHOW_ERROR", $ENVIRONMENT_DEFAULT["SHOW_ERROR"]);
define("SHOW_SQL", $ENVIRONMENT_DEFAULT["SHOW_SQL"]);

if(SHOW_ERROR == "1"){
	ini_set("display_errors",1);
	ini_set("display_startup_erros",1);
	error_reporting(E_ALL);
}

define("JWT_KEY", $ENVIRONMENT_DEFAULT["JWT_KEY"]);

/** PATHS */
define("DOMAIN", $ENVIRONMENT_DEFAULT["DOMAIN"]);
define("API", $ENVIRONMENT_DEFAULT["API"]);
define("DB", $ENVIRONMENT_DEFAULT["DB"]);
define("LIBRARY", $ENVIRONMENT_DEFAULT["LIBRARY"]);

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
