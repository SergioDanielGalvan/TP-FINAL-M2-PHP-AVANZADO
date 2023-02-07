<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

// Otros
$strError = "";
$codeError = 0;

function conexionPDO() {
	$url = "localhost";
	$user = "root";
	$password = "";
	$nombre_base = "utn-2023";
	$port = 3306;
  
	$strconection = "mysql:host=" . $url . ";port=" . $port . "; dbname=" . $nombre_base;
	$conection = null;
  
	try {
	  // $conection = new PDO( $strconection, self::$user, self::$password);
	  $conection = new PDO( $strconection, $user, $password);
	  $strError = "";
	  $codeError = 0;
	}
	catch (PDOException $e) {
	  $strError = $e->getMessage();
	  $codeError = $e->getCode();
	  echo( "Error: " . $strError);
	}
	return $conection;
}

/* ---Objeto de AJAX que recibe la variable POST -----*/

if ( isset( $_POST["validarEmail"] ) ) {
	if ( $_POST["validarEmail"] == "" ) {
		return "fail";
	}
	if ( ! filter_var( $_POST["validarEmail"], FILTER_VALIDATE_EMAIL ) ) {
		return "fail";
	}
	$correo = $_POST["validarEmail"];
}

$conexion = conexionPDO(); 
if ( $conexion == null ) {
    return "fail";
}

$sql = "SELECT usuario FROM usuarios WHERE correo = '" . $correo ."';";
$cmdSP = $conexion->prepare( $sql );
$cmdSP->execute();
$a = $cmdSP->fetch( PDO::FETCH_ASSOC );
$cmdSP->closeCursor();
$cmdSP = null;
$conexion = null;

echo (int) $a;