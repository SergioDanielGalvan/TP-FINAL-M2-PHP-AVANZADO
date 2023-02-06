<?php

if ( !isset( $_SESSION["usuario"] ) ) {

	echo '<script>window.location = "index.php?ruta=ingreso";</script>';

	return;

}
else {

	if( $_SESSION["usuario"] == "" ){

		echo '<script>window.location = "index.php?ruta=ingreso";</script>';

		return;
	}
	
}

require_once "./controladores/formularios.controlador.php";
$usuarios = ControladorFormularios::crtSeleccionarRegistros( null, null);

?>
<table class="tabla">
	<thead>
		<tr>
			<th>#</th>
			<th>Nombre</th>
			<th>Email</th>
			<th>Fecha</th>
			<th>Ultimo Ingreso</th>
			<th>Acciones</th>
		</tr>
	</thead>

	<tbody>

	<?php foreach ($usuarios as $key => $value): ?>

		<tr>
			<td><?php echo ($key+1); ?></td>
			<td><?php echo $value["usuario"]; ?></td>
			<td><?php echo $value["correo"]; ?></td>
			<td><?php echo $value["fecha"]; ?></td>
            <td><?php echo $value["ultimoingreso"]; ?></td>
			<td>

			<div>
				<div class = "linkEditar" >
					<a href="index.php?ruta=editar&usuario=<?php echo $value["usuario"]; ?>" class="botonIngresar">Editar</a>
				</div>
				<!-- 
				<a href="./vistas/paginas/editar.php?<?php echo $value["usuario"]; ?>" class="boton_editar">Editar</a>
				-->

				<form method="post">
					<input type="hidden" value="<?php echo $value["usuario"]; ?>" name="eliminarRegistro">
					<button type="submit" class="botonIngresar">Borrar</button>
					<?php

						$eliminar = new ControladorFormularios();
						$eliminar -> ctrEliminarRegistro();

					?>
				</form>			
			</div>

			</td>
		</tr>
		
	<?php endforeach ?>	
	
	</tbody>
</table>