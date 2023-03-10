<?php

// require_once "../modelos/conexion_db.php";
require_once "modelos/formularios.modelo.php";

class controladorFormularios {
    private static $llave = '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$';

    /* Formulario de Registro */
    static public function ctrFormRegistro()  {
        if ( isset( $_POST[ "usuario" ] ) ) {
            if ( preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["usuario"]) &&
                filter_var( $_POST["correo"], FILTER_VALIDATE_EMAIL ) &&
                preg_match('/^[0-9a-zA-Z]+$/', $_POST["clave"]) ) {

                // Esta mal
				// preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["registroEmail"]) &&
                // Funcionan mejor
                // preg_match( '/^\\S+@\\S+\\.\\S+$/', $_POST["correo"]) &&
                // preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["correo"])

                // La forma correcta -> !filter_var( $_POST["correo"], FILTER_VALIDATE_EMAIL)

                $nombretabla = "usuarios";
                $encriptarPassword = crypt( $_POST["clave"], self::$llave);
                $datosregistro = array(
                    "usuario" => $_POST[ "usuario" ],
                    "correo" => $_POST[ "correo" ],
                    "clave" => $encriptarPassword
                );
                $respuesta = modeloFormularios::mdlRegistro( $nombretabla, $datosregistro );
            }
            else {
				if ( ! preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["usuario"]) ) {
					$respuesta = "error1";
				}
				//else if ( ! preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["correo"]) ) {
                else if ( ! filter_var( $_POST["correo"], FILTER_VALIDATE_EMAIL ) ) {
					$respuesta = "error2";
				}
				else if ( ! preg_match('/^[0-9a-zA-Z]+$/', $_POST["clave"]) ) {
					$respuesta = "error3";
				}
				else {
					$respuesta = "error ?";
				}
            }
            return $respuesta;
        }
    }

    /* Formulario de Ingreso */
    static public function ctrFormIngreso() {
        if ( isset( $_POST[ "usuario" ] ) ) {
            $nombretabla = "usuarios";

            $encriptarPassword = crypt( $_POST["clave"], self::$llave);
            $datosregistro = array(
                "usuario" => $_POST[ "usuario" ],
                "clave" => $encriptarPassword
            );

            $respuesta = modeloFormularios::mdlIngreso( $nombretabla, $datosregistro );

            return $respuesta;
        }
    }

    static public function crtActualizarRegistro() {
        if ( isset( $_POST[ "actualizarNombre" ] ) ) {
            if ( $_POST[ "actualizarNombre" ] !== "" ) {
                if ( ! isset( $_POST[ "actualizarClave" ] ) ) {
                    $password = $_POST[ "claveActual" ];
                }
                else if ( $_POST[ "actualizarClave" ] == "" ) {
                    $password = $_POST[ "claveActual" ];
                }
                else {
                    $password = $_POST[ "actualizarClave" ];
                }
            }
            $encriptarPassword = crypt( $password, self::$llave);
            $tabla = "usuarios";

            $datos = array(
                "usuario" => $_POST[ "actualizarNombre" ],
                "correo" => $_POST[ "actualizarCorreo" ],
                "clave" => $encriptarPassword
            );

            $respuesta = modeloFormularios::mdlActualizarRegistro( $tabla, $datos );
            return $respuesta;
        }
       
    }

    /* Obtener un Array de Registros */
    static public function crtSeleccionarRegistros( $item, $valor, $todos = false ) {
        $tabla = "usuarios";
        $respuesta = modeloFormularios::mdlSeleccionarRegistros( $tabla, $item, $valor, $todos );
        return $respuesta;
    }

    static public function ctrEliminarRegistro() {
        if ( isset( $_POST[ "eliminarRegistro" ] ) ) {
            $respuesta = modeloFormularios::mdlEliminarRegistro( "usuarios", $_POST[ "eliminarRegistro" ] );
            return $respuesta;
        }
    }

    static public function crtSeleccionarDatos( $item ) {
        if ( $item !== "" ) {
            $respuesta = modeloFormularios::mdlSeleccionarDatos( "usuarios", $item );
            return $respuesta;
    
        }

    }

}