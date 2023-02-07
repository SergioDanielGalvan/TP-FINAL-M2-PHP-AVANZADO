    <main>
        <h1 class="titulo" >Ingresar</h1>
        <section>
            <form method = "POST" id="formIngresar" action="" >
                <h3> Ingreso </h3>
                <label class = "labelIngresar" for = "usuario" >Usuario: </label>
                <!--
                <input type = "text" id="inputIngresar" class = "input_ingresar" name = "usuario" value = "" required autofocus />
                -->
                <input type = "text" class = "input_ingresar" name = "usuario" onkeyup="showHint( this.value )" value = "" required autofocus />
                <p><span id="txtSugerencia"></span></p>
                <label class = "labelIngresar" for = "clave" >Clave: </label>
                <input type = "password" class = "input_ingresar" name = "clave" required placeholder="Contraseña"/>
                <div id="botonesIngresar" >
                    <input type="submit" class = "botonIngresar"  name = "ingresar" value = "Ingresar" /> 
                    <input type="reset" class = "botonIngresar" />
                </div>
                <?php
                    require_once "./controladores/formularios.controlador.php";
                    $registro = controladorFormularios::ctrFormIngreso()
                ?>
            </form>
            <?php
                if ( $registro !== "" ) {
                    echo( '<div class = "mensajes" >' );
                    if ( $registro == "ok" ) {
                        echo( "<h2>Ingreso usuario Ok!</h2>");
                        echo '<script>
                            setTimeout(function(){
                                window.location = "index.php?ruta=inicio";
                            },3000);
                            if ( window.history.replaceState ) {
                                window.history.replaceState( null, null, window.locations.href );
                            }
                            window.locations = "index.php?ruta=inicio";
                            </script>';
                    }
                    else if ( $registro == "ui" ) {
                        echo( "<h2>Usuario inexistente!</h2>");
                    }
                    else if ( $registro == "uv" ) {
                        echo( "<h2>Usuario vacío</h2>");
                    }
                    else if ( $registro == "ub" ) {
                        echo( "<h2>Usuario bloqueado!</h2>");
                    }
                    else if ( $registro == "pi" ) {
                        echo( "<h2>Clave errónea!</h2>");
                    }
                    else if ( $registro == "fail" ) {
                        echo( "<h2>Fallo en el motor DBMS!</h2>");
                    }
                    echo( '</div>');
                }
            ?>
        </section>
    </main>
