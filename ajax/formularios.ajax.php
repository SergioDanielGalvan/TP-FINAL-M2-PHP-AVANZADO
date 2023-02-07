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

require_once "../controladores/formularios.controlador.php";

/*---Clase de AJAX ---*/

class AjaxFormularios{

	/* Validar email existente*/	
	public $validarEmail;

	public function ajaxValidarEmail() {

		$item = "correo";
		$valor = $this->validarEmail;

		$respuesta = ControladorFormularios::crtSeleccionarRegistros( $item, $valor );

		echo json_encode( $respuesta );
	}

}

/* ---Objeto de AJAX que recibe la variable POST -----*/

if ( isset( $_POST["validarEmail"] ) ) {

	$valEmail = new AjaxFormularios();
	$valEmail -> validarEmail = $_POST["validarEmail"];
	$valEmail -> ajaxValidarEmail();
}
