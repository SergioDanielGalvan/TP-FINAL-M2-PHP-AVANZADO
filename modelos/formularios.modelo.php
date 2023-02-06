<?php

require_once "./modelos/conexion_db.php";

class modeloFormularios {
    static public function mdlRegistro( $tabla, $datos ) {

        $conexion = conexionDBMS::conexionPDO(); 
        if ( $conexion == null ) {
            return "fail";
        }

        $sql = "SELECT * FROM $tabla WHERE usuario = '" . $datos['usuario'] . "' ORDER BY usuario ASC;";
        $resultado = $conexion->query( $sql );

        if ( ! $resultado )  {
            return "fail";
        }
        $count = $resultado->fetchColumn();
        if ( $count > 1 ) {
            return "duplicate";
        }

        $cmdSP = $conexion->prepare("INSERT INTO $tabla (usuario, correo, clave) VALUES (:usuario, :correo, :clave)");

        $cmdSP->bindParam( ":usuario",  $datos["usuario"], PDO::PARAM_STR);
        $cmdSP->bindParam( ":correo",  $datos["correo"], PDO::PARAM_STR);
        $cmdSP->bindParam( ":clave",  $datos["clave"], PDO::PARAM_STR);

        if ( $cmdSP->execute() ) {
            $cmdSP->closeCursor();
            return "ok";
        }
        else {
            print_r( conexionDBMS::conexionPDO()->errorInfo() );
            $cmdSP->closeCursor();
            return "fail";
        }
    }

    static public function mdlIngreso( $tabla, $datos ) {

        if ( $datos["usuario"] == "" ) {
            return "uv";
        }

        $conexion = conexionDBMS::conexionPDO(); 
        if ( $conexion == null ) {
            return "fail";
        }

        $sql = "SELECT * FROM $tabla WHERE usuario =  '" . $datos["usuario"] . "';";
        $cmdSP = $conexion->prepare( $sql );
        $cmdSP->execute();

        $resultado = $cmdSP->fetch( PDO::FETCH_ASSOC );

        if ( ! $resultado )  {
            return "ui";
        }
        if ( (int) $resultado == 0 ) {
            return "ui";    // Usuario incorrecto
        }
        else if ( $resultado['intentos'] > 10 ) {
            return "ub";    // Usuario bloqueado
        }

        $sql = "UPDATE $tabla SET intentos = :intentos, fechaultimologin = CURRENT_TIMESTAMP() WHERE usuario = :usuario;";
        $cmdSP2 = $conexion->prepare( $sql );
        $data = [
            'usuario' => $resultado["usuario"],
            'intentos' => $resultado['intentos']
        ];
        if ( $resultado["clave"] !== $datos["clave"] ) {
            // Incremento errores
            $data['intentos'] = $data['intentos'] + 1;
            $cmdSP2->execute( $data );
            return "pi";    // Contraseña incorrecta
        }
        // Pongo a cero errores
        $data['intentos'] = 0;
        $cmdSP2->execute( $data );

        // Inicio session
        $_SESSION["usuario"] = $resultado["usuario"];
        $_SESSION["permisos"] = $resultado["permisos"];

        // Liberando recursos
        $cmdSP = null;
        $cmdSP2 = null;
        $conexion = null;

        return "ok";
   }

   static public function mdlSeleccionarRegistros( $tabla, $item, $valor ) {
        $strSQL = "";
        if ( $item == null && $valor == null ) {
            $strSQL = "SELECT *, DATE_FORMAT( fechaalta, '%d-%m-%Y' ) AS fecha, DATE_FORMAT( fechaultimologin, '%d-%m-%Y' ) AS ultimoingreso FROM $tabla WHERE permisos = 'user' ORDER BY usuario DESC;";
        }
        else {
            $strSQL = $strSQL = "SELECT *, DATE_FORMAT( fechaalta, '%d-%m-%Y' ) AS fechaalta, DATE_FORMAT( fechaultimologin, '%d*%m-%Y' ) AS ultimoingreso FROM $tabla WHERE $item = :$item AND permisos = 'user' ORDER BY usuario DESC;";;
        }
        $conexion = conexionDBMS::conexionPDO(); 
        if ( $conexion == null ) {
            return false;
        }

        $cmdSP = $conexion->prepare( $strSQL );
        if ( $item !== null  ) {
            $cmdSP->bindParam(":" . $item, $valor, PDO::PARAM_STR);
        }
        $cmdSP->execute();
        // Liberando recursos
        return ( $item == null  ) ? $cmdSP->fetchAll() : $cmdSP->fetch();
    }

    static public function mdlEditarRegistro( $tabla, $datos ) {
    
        $conexion = conexionDBMS::conexionPDO(); 
        if ( $conexion == null ) {
            return "fail";
        }

        $sql = "SELECT * FROM $tabla WHERE usuario = '" . $datos['usuario'] . "' ORDER BY usuario ASC;";
        $resultado = $conexion->query( $sql );

        if ( ! $resultado )  {
            return "fail";
        }
        $count = $resultado->fetchColumn();
        if ( $count > 1 ) {
            return "duplicate";
        }

        $cmdSP = $conexion->prepare("UPDATE $tabla SET (correo = :correo, clave = :clave) WHERE usuario = :usuario;");

        $cmdSP->bindParam( ":correo",  $datos["correo"], PDO::PARAM_STR);
        $cmdSP->bindParam( ":clave",  $datos["clave"], PDO::PARAM_STR);

        if ( $cmdSP->execute() ) {
            $cmdSP->closeCursor();
            return "ok";
        }
        else {
            print_r( conexionDBMS::conexionPDO()->errorInfo() );
            $cmdSP->closeCursor();
            return "fail";
        }
    }

    static public function mdlEliminarRegistro( $tabla, $usuario ) {
        if ( $tabla == null ) {
            $tabla = "usuarios";
        }
        else if ( $tabla == "" ) {
            $tabla = "usuarios";
        }
        if ( $usuario == null ) {
            return false;
        }
        else if ( $usuario == "" ) {
            return false;
        }

        $strSQL = "DELETE FROM $tabla WHERE usuario = :usuario;";
        $conexion = conexionDBMS::conexionPDO(); 
        if ( $conexion == null ) {
            return false;
        }
        $cmdSP = $conexion->prepare( $strSQL );
        $cmdSP->bindParam(":" . $usuario, $usuario, PDO::PARAM_STR);
        $cmdSP->execute();
        // Liberando recursos
        $cmdSP = null;
        return true;
    }

    static public function mdlActualizarRegistro( $tabla, $datos ) {
    
        $conexion = conexionDBMS::conexionPDO(); 
        if ( $conexion == null ) {
            return "fail";
        }

        $sql = "SELECT * FROM $tabla WHERE usuario = '" . $datos['usuario'] . "' ORDER BY usuario ASC;";
        $resultado = $conexion->query( $sql );

        if ( ! $resultado )  {
            return "fail";
        }
        $count = $resultado->fetchColumn();
        if ( $count > 1 ) {
            return "duplicate";
        }

        $cmdSP = $conexion->prepare("UPDATE $tabla SET (correo = :correo, clave = :clave) WHERE usuario = :usuario;");

        $cmdSP->bindParam( ":usuario",  $datos["usuario"], PDO::PARAM_STR);
        $cmdSP->bindParam( ":correo",  $datos["correo"], PDO::PARAM_STR);
        $cmdSP->bindParam( ":clave",  $datos["clave"], PDO::PARAM_STR);

        if ( $cmdSP->execute() ) {
            $cmdSP->closeCursor();
            return "ok";
        }
        else {
            print_r( conexionDBMS::conexionPDO()->errorInfo() );
            $cmdSP->closeCursor();
            return "fail";
        }
    }

    static public function mdlSeleccionarDatos( $tabla = "usuarios", $item = "usuario") {

        $conexion = conexionDBMS::conexionPDO(); 
        if ( $conexion == null ) {
            return "fail";
        }
        if ( $tabla == "" ) {
            $tabla = "usuarios";
        }
        if ( $tabla == "" ) {
            $tabla = "usuarios";
        }

        $sql = "SELECT $item FROM $tabla ORDER BY $item ASC";
        $resultado = $conexion->query( $sql );
        return $resultado;
    }

}