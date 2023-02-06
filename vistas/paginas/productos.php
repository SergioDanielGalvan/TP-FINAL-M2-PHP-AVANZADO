<?php
    include("head.php");
?>
<body>
    <main>
        <h1 class="titulo" >Listado Productos</h1>
        <section id = "seccionLista" >
            <?php
                include("./modelos/listaproductos.php");
                //listaproductos();
                productos::listarproductos();
            ?>
        </section>
            <?php 
                if ( isset( $_GET['e'] ) ) {
                    echo( '<div id="mensajeError" >' );
                    if ( $_GET['e'] === "Ok" ) {
                        echo( "<h3>Mensaje: Registro eliminado!</h3>" );
                    }
                    else if ( $_GET['e'] === "OkUpdate" ) {
                        echo( "<h3>Mensaje: Registro actualizado!</h3>" );
                    }
                    else if ( $_GET['e'] === "fail" ) {
                        echo( "<h3>Mensaje: Fallo al eliminar!</h3>" );
                    }
                    else if ( $_GET['e'] === "NotFound" ) {
                        echo( "<h3>Mensaje: Registro no encontrado!</h3>" );
                    }
                    else {
                        echo( "<h3>Mensaje: ".$_GET['e']." no especificado</h3>" );
                    }
                    echo( "</div>" );
                }
            ?>
    </main>
</body>
</html>