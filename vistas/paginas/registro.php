<?php
    include("head.php");
?>
<body>
    <main>
        <h1 class="titulo" >Registro</h1>
        <section class = "Ingresar">
            <form id = "formIngresar" name="formIngresar" method="post" action="">
                <h3>Ingresar Datos</h3>
                <label class="labelIngresar" for="usuario">Nombre: </label>
                <input type="text" class = "input_ingresar" name="usuario" maxlength="60" placeholder="Juan" required />
                <label class="labelIngresar" for="correo">Correo: </label>
                <input type="email" class = "input_ingresar" name="correo" maxlength="60" placeholder="juan@gmail.com" required />
                <label class="labelIngresar" for="clave">Password: </label>
                <input type = "password" class = "input_ingresar" name = "clave" required placeholder="Contraseña"/>
                <?php
                    require_once "./controladores/formularios.controlador.php";
                    $registro = controladorFormularios::ctrFormRegistro();
                ?>
                <div id="botonesIngresar" >
                    <input type="submit" class = "botonIngresar" /> 
                    <input type="reset" class = "botonIngresar" />
                </div>
            </form>
            <?php
                if ( $registro !== "" ) {
                    echo( '<div class = "mensajes" >' );
                    if ( $registro == "ok" ) {
                        echo( "<h2>Registro añadido Ok!</h2>");
                    }
                    else if ( $registro == "duplicate" ) {
                        echo( "<h2>Usuario existente!</h2>");
                    }
                    else if ( $registro == "fail" ) {
                        echo( "<h2>Fallo en el motor DBMS!</h2>");
                    }
                    else if ( $registro == "error1" || $registro == "error2" || $registro == "error3" ) {
                        switch ( $registro ) {
                            case "error1":
                                $campo = "Usuario";
                                break;
                            case "error2":
                                $campo = "Correo";
                                break;
                            case "error3":
                                $campo = "Contraseña";
                                break;
                        }
                        echo( "<h2>Campo -> $campo invalido!</h2>");
                    }
                    else {
                        //echo( "<h2>Campo -> error desconocido ?</h2>");
                    }
                    echo( '</div>');
                }
            ?>
        </section>
    </main>
</body>
</html>