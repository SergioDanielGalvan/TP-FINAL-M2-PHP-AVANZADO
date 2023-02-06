<?php

class ControladorLogComentarios {
    public $nombrearchivo;
    private $archivo;

    function __construct( $nombre = "" ) {
        $archivo = false;
        if ( $nombre == "" ) {
            $nombre = "../log_comentarios.txt";
        }
        $this->nombrearchivo = $nombre;
        if ( file_exists( $nombre ) ) {
            // Lo puedo abrir
            // Funciones de bajo nivel de PhP, modo Append
            // $this->archivo = fopen( $nombre , "a" );
        }
    }

    function __destruct() {
        // Liberar el recurso si quedó abierto.
        if ( $this->archivo !== false ) {
            // fclose( $this->archivo );
        }
    }

    function grabartexto( $texto_html = "" ) {
        if ( $texto_html !== "" ) {
            $this->archivo = fopen( $this->nombrearchivo , "a" );
            if ( $this->archivo == false ) {
                return;
            }
            fputs( $this->archivo, $texto_html );
            fclose( $this->archivo );
        }
    }

    function guardarcomentario( $usuario = "", $nombre = "", $apellido = "", $correo = "", $comentario = "" ) {
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $texto_html = "";
        if ( $usuario !== "" ) {
            $texto_html = "<details Open>";  //  <- Inicio
            $texto_html = $texto_html . "<summary>";
            $texto_html = $texto_html . $usuario . " - " . date("d-m-y h:m:s");
            $texto_html = $texto_html . "</summary>";
            $texto_html = $texto_html . "<h3> Usuario: " . $nombre;
            if ( $apellido != "" ) {
                $texto_html = $texto_html . " " . $apellido;
            }
            $texto_html = $texto_html . "</h3>";
            $texto_html = $texto_html . "<h3> Correo: " . $correo . "</h3>";
            $texto_html = $texto_html . "<p> Comentario: " . $comentario . "</p>";
            $texto_html = $texto_html . "<p> Fecha: " . date("d-m-y h:m:s") . "</p>";
            $texto_html = $texto_html . "</details>";  //  <- Separador
        }
        return $texto_html;
    }

    function leertexto() {
        $texto = "";
        if ( ! file_exists( $this->nombrearchivo ) ) {
            return $texto;
        }
        $this->archivo = fopen( $this->nombrearchivo , "r" );   // Privilegios mínimos
        if ( $this->archivo == false ) {
            return $texto;
        }
        if ( $this->archivo && filesize( $this->nombrearchivo ) > 0 ) {
            $texto = fread( $this->archivo, filesize( $this->nombrearchivo ) );
        }
        fclose( $this->archivo );
        return $texto;
    }
}