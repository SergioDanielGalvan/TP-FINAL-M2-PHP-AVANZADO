<?php
 include "./controladores/formularios.controlador.php";

if ( isset( $_SESSION["usuario"] ) ) {
	$item = "usuario";
	$valor = $_GET["usuario"];
	$usuario = ControladorFormularios::crtSeleccionarRegistros( $item, $valor);
}
else {
	echo '<script>window.location = "index.php?ruta=ingreso";</script>';
	}
?>

<section class = "Ingresar" >
	<h1 class="titulo" >Editar Datos</h1>
	<form method = "post" id = "formIngresar" >

		<label class="labelIngresar" for="usuario">Nombre: <?php echo $usuario["usuario"]; ?></label></br>
		<label class="labelIngresar" for="correo">Correo: </label>
        <input type="email" class = "input_ingresar" value="<?php echo $usuario["correo"]; ?>" name="actualizarCorreo" maxlength="60" placeholder="juan@gmail.com" required />
        <label class="labelIngresar" for="clave">Password: </label>
        <input type = "password" class = "input_ingresar" name = "actualizarClave" required placeholder="Contraseña"/>
		<input type="hidden" name="actualizarNombre" value="<?php echo $usuario["usuario"]; ?>" >
		<input type="hidden" name="claveActual" value="<?php echo $usuario["clave"]; ?>" name="claveActual" >

		<?php

        $actualizar = ControladorFormularios::crtActualizarRegistro();

		if ( $actualizar == "ok" ) {

			echo '<script>
			if ( window.history.replaceState ) {
				window.history.replaceState( null, null, window.location.href );
			}
			</script>';

			echo '<div class="alert alert-success">El usuario ha sido actualizado</div>
			<script>
				setTimeout(function(){
					window.location = "index.php?pagina=inicio";
				},3000);
			</script>
			';
		}

		?>
	
		<button type="submit" class="botonIngresar">Actualizar</button>

	</form>

</section>