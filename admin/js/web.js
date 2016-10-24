function openbox(code) {
	var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=550, height=389, top=85, left=140";
	window.open("http://www.youtube.com/v/"+code,"",opciones);
}

function ajax() {
	var xmlhttp=false;
	try	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e){
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); }

	return xmlhttp;
}

function verComunas(idregion){
		document.getElementById('comunas').innerHTML = "<img src='../img/loading.gif' border='0' style='margin-bottom:0px'>";
		peticion = ajax();
		url = "funciones.php?acc=region&idregion="+idregion;
		peticion.open("POST", url, true);
		peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
		peticion.send(url);
		peticion.onreadystatechange = function () {
			if (peticion.readyState == 4) {
				var respuesta = peticion.responseText;
				document.getElementById('aviso').style.display = 'none';
				document.getElementById('comunas').style.display = '';
				document.getElementById('comunas').innerHTML = respuesta;
			}
		}		
}

function verComunas2(idregion,comuna){
	document.getElementById('comunas').innerHTML = "<img src='../img/loading.gif' border='0' style='margin-bottom:0px'>";
	if(idregion==""){
		document.getElementById('comunas').style.display = 'none';
		document.getElementById('aviso').style.display = '';
		
	} else {
		peticion = ajax();
		url = "funciones.php?acc=region2&idregion="+idregion+"&comuna="+comuna;
		peticion.open("POST", url, true);
		peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
		peticion.send(url);
		peticion.onreadystatechange = function () {
			if (peticion.readyState == 4) {
				var respuesta = peticion.responseText;
				document.getElementById('aviso').style.display = 'none';
				document.getElementById('comunas').style.display = '';
				document.getElementById('comunas').innerHTML = respuesta;
			}
		}
	}
}