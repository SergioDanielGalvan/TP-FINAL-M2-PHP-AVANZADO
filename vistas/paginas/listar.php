<?php
    include("head.php");
?>
<?php
    include( "./modelos/generarhtmllog.php" );
?>
<body>
    <main>
        <section>
            <h1 class="titulo" >Listado Comentarios</h1>
            <?php
                //listarcomentarios();
                listadocomentarios::listar()
            ?>
        </section>
    </main>
</body>
</html>