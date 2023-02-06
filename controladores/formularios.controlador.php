<?php

// require_once "../modelos/conexion_db.php";
require_once "modelos/formularios.modelo.php";

class controladorFormularios {
    private static $llave = '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$';

    /* Formulario de Registro */
    static public function ctrFormRegistro()  {
        if ( isset( $_POST[ "usuario" ] ) ) {
            if ( preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["usuario"]) &&
                preg_match( '/^\\S+@\\S+\\.\\S+$/', $_POST["correo"]) &&
                preg_match('/^[0-9a-zA-Z]+$/', $_POST["clave"]) ) {

                // Esta mal
				// preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["registroEmail"]) &&

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
				else if ( ! preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["correo"]) ) {
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

            if ( $respuesta == "ok" ) {
                $datos = modeloFormularios::mdlSeleccionarRegistros( $nombretabla, "usuario", $_POST[ "usuario" ] );
                $_SESSION["usuario"] = $datos["usuario"];
                $_SESSION["permisos"] = $datos["permisos"];
            }
            else {
                /*/
                echo '<script>
                        if ( window.history.replaceState ) {
                            window.history.replaceState( null, null, window.locations.href );
                        }
                      </script>';
                echo '<div class="alert" >Error el ingresar mail o contraseña</div>';
                */
            }

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
    static public function crtSeleccionarRegistros( $item, $valor ) {
        $tabla = "usuarios";
        $respuesta = modeloFormularios::mdlSeleccionarRegistros( $tabla, $item, $valor );
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