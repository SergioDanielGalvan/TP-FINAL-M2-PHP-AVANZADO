<?php

class listadocomentarios {

    static function listar() {
        require_once "./controladores/logtxt.controlador.php";
        $lecturalog = new ControladorLogComentarios( "log_comentarios.txt" );

        $texto_html = $lecturalog->leertexto();
        $comentarios = explode( "</details>",  $texto_html);
        for ( $i = 0; $i < sizeof( $comentarios ) - 1; $i++) {
            echo('<article class = "listaComentarios" >');
                echo( $comentarios[ $i] );
            echo("</article>");
        }
    
    }

}