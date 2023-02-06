<?php

// require_once "./controladores/logtxt.controlador.php";
require_once "../controladores/logtxt.controlador.php";

date_default_timezone_set("America/Argentina/Buenos_Aires");
if ( isset( $_POST['nombre'] ) ) {

    $lecturalog = new ControladorLogComentarios( "../log_comentarios.txt" );

    $texto_html = "<details Open>";  //  <- Inicio
    $texto_html = $texto_html."<summary>";
    $texto_html = $texto_html.$_POST['nombre']." - ".date("d-m-y h:m:s");
    $texto_html = $texto_html."</summary>";
    $texto_html = $texto_html."<h3> Usuario: ".$_POST['nombre'];
    if ( $_POST['apellido'] != "" ) {
        $texto_html = $texto_html." ".$_POST['apellido'];
    }
    $texto_html = $texto_html."</h3>";
    $texto_html = $texto_html."<h3> Correo: ".$_POST['correo']."</h3>";
    $texto_html = $texto_html."<p> Comentario: ".$_POST['comentario']."</p>";
    $texto_html = $texto_html."<p> Fecha: ".date("d-m-y h:m:s")."</p>";
    $texto_html = $texto_html."</details>";  //  <- Separador

    $lecturalog->grabartexto( $texto_html );

    header("location: ../index.php?ruta=comentarios");
}
else {
    header("Location: ../index.php?ruta=comentarios");
}
