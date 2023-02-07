function showHint( str ) {
	const a = document.getElementById("txtSugerencia");
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
		datos.append("q", str);
		xmlhttp.open( "POST", "ajax/getnombre.php", true );
		xmlhttp.send( datos );
    }
}

function checkCorreo( correo ) {
	const a = document.getElementById("correo");
	const n = document.getElementById("ingresoRegistro");
    if ( correo.length == 0 ) {
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
		xmlhttp.dataType = "text";
	  	xmlhttp.onreadystatechange = function( respuesta ) {
		if ( this.readyState == 4 && this.status == 200 ) {
			const a = parseInt( xmlhttp.responseText );
			nodop = document.querySelector( "#areaMensajes" );
			if ( a > 0 ) {
				// console.log( typeof a );
				if ( nodop == null ) {
					nodop = document.createElement("div");
					nodop.classList.add('mensajes');
					nodop.setAttribute("id", "areaMensajes");
					nodoh = document.createElement("h2");
					nodoh.textContent = "eMail/Correo existente!";
					nodop.appendChild( nodoh );
					n.appendChild( nodop );
				}
				else {
					if ( nodop.childElementCount == 0 ) {
						nodoh = document.createElement("h2");
						nodoh.textContent = "eMail/Correo existente!";
						nodop.appendChild( nodoh );
						n.appendChild( nodop );
					}
					else {
						nodop.firstElementChild.innerHTML = "eMail/Correo existente!";
					}
				}
				/*
				echo( '<div class = "mensajes" >' );
					echo( "<h2>eMail/Correo existente!</h2>");
				echo( '</div>');
				*/
			}
			else {
				if ( nodop !== null ) {
					if ( nodop.childElementCount !== 0 ) {
						nodop.firstElementChild.innerHTML = "";
					}
				}
			}
		}
	  	}

		let datos = new FormData();
		datos.append("validarEmail", correo);
		xmlhttp.open( "POST", "ajax/getmail.php", true );
		xmlhttp.send( datos );
	}
}

function checkCorreo1( correo ) {
	const a = document.getElementById("correo");
	const n = document.getElementById("ingresoRegistro");
    if ( correo.length == 0 ) {
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
      	xmlhttp.onreadystatechange = function( respuesta ) {
        	if ( this.readyState == 4 && this.status == 200 ) {
				console.log( "respuesta ->" + respuesta + "<-" );
				console.dir( ( respuesta.responseXML == null) ? "Si": "No" );
				if ( respuesta ) {
					nodop = document.querySelector( "#areaMensajes" );
					if ( nodop == null ) {
						nodop = document.createElement("div");
						nodop.classList.add('mensajes');
						nodop.setAttribute("id", "areaMensajes");
						nodoh = document.createElement("h2");
						nodoh.textContent = "eMail/Correo existente!";
						nodop.appendChild( nodoh );
						n.appendChild( nodop );
					}
					else {
						if ( nodop.childElementCount = 0 ) {
							nodoh = document.createElement("h2");
							nodoh.textContent = "eMail/Correo existente!";
							nodop.appendChild( nodoh );
							n.appendChild( nodop );
						}
					}
					/*
					echo( '<div class = "mensajes" >' );
						echo( "<h2>eMail/Correo existente!</h2>");
					echo( '</div>');
					*/
				}
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

$("#correo1").change( function () {
	$(".alerta").remove();

	let email = $(this).val();
	// Para chequear que el script funciona
	//console.log("email", email)

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