<?php
// Conexión a RDMS MySQL

class productos {
    private $conection;
    private $error;
    
    function __construct() {
        $error = "";
    }

    function __destruct() {
        // Liberar el recurso si quedó abierto.
        if ( $this->conection  ) {
            // fclose( $this->archivo );
            //mysqli_close( $this->conection );
            $this->conection->close();
        }
    }

    static function listarproductos() {
        include("conexion_db.php");
        $error = "";
        $conection = conexionDBMS::conexion();
        if ( $conection ) {
            $sql = "SELECT * FROM productos ORDER BY idproducto ASC;";
            $resultado = $conection->query( $sql );
            if ( $resultado->num_rows > 0 ) {
                for ( $num_fila = 0; $num_fila < $resultado->num_rows; $num_fila++) {
                    $resultado->data_seek( $num_fila );
                    $fila = $resultado->fetch_assoc();
                    echo( '<div class = "ListadoProducto">' );
                        echo( "<h2>".$fila['codigo']."</h2>" );
                        echo( "<h2>Precio: u$ " . $fila['precio'] . "</h2>" );
                        echo( '<h2>Estado: '.$fila['estado']."</h2>" );
                        echo( '<p>Descripción: '.$fila['descripcion']."</p>" );
                        echo( '<img src="./vistas/imagenes/'.$fila['imagen'].'" alt="' . $fila['codigo'] . '" >' );
                        echo( '<div id="botones" >' );
                        echo( '<div id="botonEliminar" >' );
                            echo( '<a href="./modelos/eliminarproducto.php?id=' . $fila["idproducto"] . '">Eliminar</a>');
                        echo( "</div>" );
                        // Para admin y usuarios, solo sí no está finalizado
                        if ( $fila['estado'] == "Procesando" ) {
                            echo( '<div id="botonActualizar" >' );
                                echo( '<a href="./modelos/editarproducto.php?id=' . $fila["idproducto"] . '">Actualizar</a>');
                            echo( "</div>" );
                        }
                        echo( "</div>" );
                    echo( "</div>" );
                }
            }
            else {
                echo( '<div class = "ListadoProducto">' );
                    echo( "<h2>No hay datos en la Base</h2>" );
                echo( "</div>" );
            }
            $conection->close();
        }
        else {
            $error = "Fallo de conexión a MySQL";
        }
    }

    static function eliminarproducto( $id_producto = ""  ) {
        if ( $id_producto !== "" ) {
            include("../controladores/conexion_db.php");
            $error = "";
            $conection = conexionDBMS::conexion();
            if ( $conection ) {
                // Checks
                $sql = "SELECT idproducto FROM productos WHERE idproducto = " . $id_producto . ";";
                $resultado = $conection->query( $sql );
                if ( $resultado->num_rows === 0 ) {
                    $error = "Producto no encontrado";
                    $resultado->free_result();
                }
                else {
                    $resultado->free_result();
                    $sql = "DELETE FROM productos WHERE idproducto = " . $id_producto . ";";
                    if ( $conection->query($sql) === TRUE ) {
                        $conection->close();
                        return true;
                    } else {
                        $error = "Fallo al eliminar";
                    }
                }
                $conection->close();
            }
        }
        return false;
    }
     
    static function cambiarestado( $id_producto = "" ) {
        if ( $id_producto !== "" ) {
            include("../controladores/conexion_db.php");
            $error = "";
            $conection = conexionDBMS::conexion();
            if ( $conection ) {
                // Checks
                $sql = "SELECT * FROM productos WHERE idproducto = " . $id_producto . ";";
                $resultado = $conection->query( $sql );
                if ( $resultado->num_rows === 0 ) {
                    $error = "Producto no encontrado";
                    $resultado->free_result();
                } else {
                    $resultado->free_result();
                    $sql = "UPDATE productos SET estado = 'Finalizado' WHERE idproducto = " . $id_producto . ";";
                    if ( $conection->query( $sql ) === TRUE ) {
                        $conection->close();
                        return true;
                        // header("location: ../index.php?ruta=productos");
                    } else {
                        //header("location: listadoproductos.php?e=fail");
                        $error = "Fallo al actualizar";
                    }
                }
                $conection->close();
            }
        }
        return false;
    }

}
