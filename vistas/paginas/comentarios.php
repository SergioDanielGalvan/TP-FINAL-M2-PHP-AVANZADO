
    <h1 class = "titulo" >Ingreso</h1>
    <main>
        <section class = "Ingresar">
            <form id = "formIngresar" name="formIngresar" method="post" action="./modelos/guardarcomentario.php">
                <h3>Ingresar Comentario</h3>
                <label class="labelIngresar" for="nombre">Nombre: </label>
                <input type="text" class = "input_ingresar" name="nombre" maxlength="60" placeholder="Juan" required />
                <label class="labelIngresar" for="apellido">Apellido: </label>
                <input type="text" class = "input_ingresar" name="apellido" maxlength="60" placeholder="Pérez" />
                <label class="labelIngresar" for="correo">Correo: </label>
                <input type="email" class = "input_ingresar" name="correo" maxlength="60" placeholder="juan@perez.com" required />
                <label class="labelIngresar" for="comentario">Comentario: </label>
                <textarea class="textareaIngresar" name="comentario" cols="60" rows="3"></textarea>
                <div id="botonesIngresar" >
                    <input type="submit" class = "botonIngresar" /> 
                    <input type="reset" class = "botonIngresar" />
                </div>
            </form>
        </section>
        <section id="mensajes" >
            <?php 
            echo( "<div>" );
            if ( isset( $_GET['e'] ) ) {
                $resultado = $_GET['e'];
                if ( $resultado === "DI" ) {
                    echo( "<h3>Datos Incompletos!</h3>" );
                }
                else if ( $resultado === "Fail" ) {
                    echo( "<h3>Fallo apertura fichero!</h3>" );
                }
                else {
                    // $resultado === "Ok"
                    echo( "<h3>Datos grabados exitosamente</h3>" );
                }
            }
            echo( "</div>" );
            ?>
        </section>
    </main>
