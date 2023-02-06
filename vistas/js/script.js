function showHint( str ) {
    if ( str.length == 0 ) {
      	// document.getElementById("txtSugerencia").innerHTML = "";
		const a = document.getElementById("txtSugerencia");
		a.innerHTML = "";
      	return;
    } 
	else {
		console.dir( str );
		let xmlhttp;
		if ( window.XMLHttpRequest ) {
			xmlhttp = new XMLHttpRequest();
		}
		else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
		}
      	xmlhttp.onreadystatechange = function() {
        	if ( this.readyState == 4 && this.status == 200 ) {
				a.innerHTML = this.responseText;
        	}
      	}
		/*
      	xmlhttp.open( "GET", "ajax/getnombre.php?q=" + str, true );
      	xmlhttp.send();
		*/
		let datos = new FormData();
		datos.append("q", str);
		xmlhttp.open( "POST", "ajax/getnombre.php", true );
		xmlhttp.send( datos );
    }
}

function checkCorreo( correo ) {
	const a = document.getElementById("correo");
    if ( str.length == 0 ) {
		// document.getElementById("txtSugerencia").innerHTML = "";
	  a.innerHTML = "";
		return;
  	} 
	else {
		let xmlhttp;
		if ( window.XMLHttpRequest ) {
			xmlhttp = new XMLHttpRequest();
		}
		else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
		}
      	xmlhttp.onreadystatechange = function() {
        	if ( this.readyState == 4 && this.status == 200 ) {
				a.innerHTML = this.responseText;
        	}
      	}
		/*
      	xmlhttp.open( "GET", "ajax/getnombre.php?q=" + str, true );
      	xmlhttp.send();
		*/
		let datos = new FormData();
		datos.append("validarEmail", correo);
		xmlhttp.open( "POST", "ajax/formularios.ajax.php", true );
		xmlhttp.send( datos );
    }
} 

$("#correo").change( function () {
	$(".alerta").remove();

	let email = $(this).val();
	// Para chequear que el script funciona
	console.log("email", email)

	let datos = new FormData();
	datos.append("validarEmail", email);

	$.ajax( {
		url: "ajax/formularios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
		if ( respuesta ) {
			$("#email").val("");

			$("#correo").parent().after(`
						
						<div class="alerta alerta-advertencia">

								<strong>ERROR:</strong>

								El correo electrónico ya existe en la base de datos,  por favor ingrese otro diferente
						</div>

					`);
		}
		},
	});
});