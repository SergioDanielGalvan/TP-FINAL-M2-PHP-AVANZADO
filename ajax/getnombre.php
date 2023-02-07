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

$conexion = conexionPDO(); 
if ( $conexion == null ) {
    return "fail";
}

$q = $_POST["q"];

$sql = "SELECT usuario FROM usuarios WHERE permisos = 'user' AND usuario LIKE '" . $q ."%' ORDER BY usuario ASC;";
$cmdSP = $conexion->prepare( $sql );
$cmdSP->execute();
$a = $cmdSP->fetchAll();
$cmdSP->closeCursor();
$cmdSP = null;
$conexion = null;

/*
echo( "<pre>" );
  print_r( $a );
  //var_dump( $a );
  echo("");
echo( "</pre>" );

require_once "../controladores/formularios.controlador.php";

$item = "usuario";
$a = ControladorFormularios::crtSeleccionarDatos( $item );
*/

$hint = "";

// lookup all hints from array if $q is different from ""
if ( $q !== "" ) {
  $q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name["usuario"], 0, $len))) {
      if ($hint === "") {
        $hint = $name["usuario"];
      } else {
        $hint = $hint . ", " . $name["usuario"];
      }
    }
  }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "sin sugerencia" : "sugerencia -> " . $hint;
?>