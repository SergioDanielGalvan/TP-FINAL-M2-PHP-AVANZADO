<?php 
    session_name("TPA_FINAL");
    session_start();
    include("./vistas/paginas/head.php");
?>

<body>
    <header>
        <a href="./index.php">
            <img class = "imagenLogo" src = "./vistas/imagenes/php-logo.jpg" alt = "Logo Sitio" >
        </a>
        <nav id = "menuPrincipal">
            <ul id = "listamenu" >
                <?php
                    if ( isset( $_SESSION["usuario"] ) ) {
                        echo( '<li><a href="./index.php?ruta=inicio" >Inicio</a></li>' ) ;
                        echo( '<li><a href="./index.php?ruta=productos" >Listado Productos</a></li>' ) ;
                        echo( '<li><a href="./index.php?ruta=comentarios" >Comentarios</a></li>' ) ;
                        echo( '<li><a href="./index.php?ruta=listar" >Listar</a></li>' ) ;
                        echo( '<li><a href="./index.php?ruta=salir" >Salir</a></li>' ) ;
                        // $_SESSION["permisos"] = $datos["permisos"];
                    } 
                    else {
                        echo( '<li><a href="./index.php?ruta=ingreso" >Ingreso</a></li>' ) ;
                        echo( '<li><a href="./index.php?ruta=registro" >Registro</a></li>' ) ;
                    }
                    /*
                    <li><a href="./index.php?ruta=registro" >Registro</a></li>
                    <li><a href="./index.php?ruta=ingreso" >Ingreso</a></li>
                    <li><a href="./index.php?ruta=inicio" >Inicio</a></li>
                    <li><a href="./index.php?ruta=productos" >Listado Productos</a></li>
                    <li><a href="./index.php?ruta=comentarios" >Comentarios</a></li>
                    <li><a href="./index.php?ruta=listar" >Listar</a></li>
                    <li><a href="./index.php?ruta=salir" >Salir</a></li>
                    */
                ?>
            </ul>
        </nav>
    </header>
    <main> 
        <section >
            <?php
                if ( isset( $_GET['ruta'] ) ) {
                    switch ( $_GET['ruta'] ) {
                        case "registro":
                        case "ingreso":
                        case "inicio":
                        case "comentarios":
                        case "productos":
                        case "listar":
                        case "editar":
                        case "salir":
                            include "paginas/" .  $_GET['ruta'] . ".php";
                            break;
                        default:
                            include "paginas/e404.php";
                    }
                }
                else {
                    "paginas/registro.php";
                }
            ?>
        </section>
    </main>
    <?php 
        include("./vistas/paginas/footer.php");
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="vistas/js/script.js"></script>
</body>
</html>