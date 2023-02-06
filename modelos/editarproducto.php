<?php 

if ( isset( $_GET['id'] ) ) {

    include("../modelos/conexion_db.php");

    $id_producto = $_GET['id'];
    $conection = conexionDBMS::conexion();
    if ( $conection ) {
        // Checks
        $sql = "SELECT * FROM productos WHERE idproducto = " . $id_producto . ";";
        $resultado = $conection->query( $sql );
        if ( $resultado->num_rows === 0 ) {
            //header("location: listadoproductos.php?e=NotFound");
        }
        $resultado->free_result();
        $sql = "UPDATE productos SET estado = 'Finalizado' WHERE idproducto = " . $id_producto . ";";
        if ( $conection->query( $sql ) === TRUE ) {
            header("location: ../index.php?ruta=productos");
        } else {
            //header("location: listadoproductos.php?e=fail");
        }
        $conection->close();
    }
}
