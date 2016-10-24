function nuevoAjax() {
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
function enviarFormulario(url, formid){
         var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i < Formulario.elements.length;i++) {
         cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         sepCampos="&";
		 }

  peticion = nuevoAjax();
  peticion.open("POST", url, true);
  peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  peticion.send(cadenaFormulario);
  peticion.onreadystatechange = function () {
	  if (peticion.readyState == 4) {
	  	
	  	document.getElementById('estado').innerHTML = peticion.responseText;
	  	
	  }
	  
  }
}



function enviarForm(url, formid){
         var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i < Formulario.elements.length;i++) {
         cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         sepCampos="&";
		 }

  peticion = nuevoAjax();
  peticion.open("POST", url, true);
  peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  peticion.send(cadenaFormulario);
  peticion.onreadystatechange = function () {
	  if (peticion.readyState == 4) {
	  	
	  	document.getElementById('estadodatos').innerHTML = peticion.responseText;
	  	
	  }
	  
  }
}

function enviarMail(url, formid){
         var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i < Formulario.elements.length;i++) {
         cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         sepCampos="&";
		 }

  peticion = nuevoAjax();
  peticion.open("POST", url, true);
  peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  peticion.send(cadenaFormulario);
  peticion.onreadystatechange = function () {
	  if (peticion.readyState == 4) {
	  	
	  	document.getElementById('estadomail').innerHTML = peticion.responseText;
	  	
	  }
	  
  }
}

function enviarDNI(url, formid){
         var Formulario = document.getElementById(formid);
         var longitudFormulario = Formulario.elements.length;
         var cadenaFormulario = ""
         var sepCampos
         sepCampos = ""
         for (var i=0; i < Formulario.elements.length;i++) {
         cadenaFormulario += sepCampos+Formulario.elements[i].name+'='+encodeURI(Formulario.elements[i].value);
         sepCampos="&";
		 }

  peticion = nuevoAjax();
  peticion.open("POST", url, true);
  peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  peticion.send(cadenaFormulario);
  peticion.onreadystatechange = function () {
	  if (peticion.readyState == 4) {
	  	
	  	document.getElementById('estadoDNI').innerHTML = peticion.responseText;
	  	
	  }
	  
  }
}

function desplegar_opciones(dire,campo){
	peticion = nuevoAjax();
  	peticion.open("POST", dire, true);
  	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  	peticion.send(dire);
  	peticion.onreadystatechange = function () {
		if (peticion.readyState == 4) {
	  		document.getElementById(campo).innerHTML = peticion.responseText;
		}
	}
}


function cambiar_orden_cat(campo,category,orden){
	var dire = "functions/funciones.php?c=modifyordercat&cat="+category+"&orden="+orden;
	peticion = nuevoAjax();
  	peticion.open("POST", dire, true);
  	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
  	peticion.send(dire);
  	peticion.onreadystatechange = function () {
		if (peticion.readyState == 4) {
	  		document.getElementById(campo).value = peticion.responseText;
			location.reload(true);
		}
	}
	
}
function change_color(identificador){
	document.getElementById(identificador).className = 'change_color_dos';
}
function change_color_dos(identificador){
	document.getElementById(identificador).className = 'change_color';
}

function edit_talla(idTalla,talla,elemento){
	
	document.getElementById('subcategoria_'+idTalla).innerHTML = '<input type="text" size="21" name="titulo" value="'+talla+'" class="registro borders_select" onblur="salirTalla('+idTalla+',this.value,\''+talla+'\')" id="focus_'+idTalla+'" />';
	//document.getElementById('focus_'+idTalla).focus();
	var SearchInput = $('#focus_'+idTalla+'');
	SearchInput.val(SearchInput.val());
	var strLength= SearchInput.val().length;
	SearchInput.focus();
	SearchInput[0].setSelectionRange(strLength, strLength);

}
function salirTalla(idTalla,nuevatalla,antiguo){
	if(trim(nuevatalla) == ""){
		document.getElementById('subcategoria_'+idTalla).innerHTML = antiguo;
	} else {
	document.getElementById('subcategoria_'+idTalla).innerHTML = "<img src='icons/loading.gif' border='0' style='margin-bottom:0px'>";

	peticion = nuevoAjax();
	url = "functions/acciones.php?acc=updatetalla&antiguo="+antiguo+"&id="+idTalla+"&talla="+corregirjs2(corregirjs(nuevatalla));
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
		if (peticion.readyState == 4) {
			var respuesta = peticion.responseText;
			document.getElementById('subcategoria_'+idTalla).innerHTML = respuesta;
		}
	}
	}
}

function trim(strr){
	var lal = strr;
	return lal.replace(/^\s+/g,'').replace(/\s+$/g,'');
}
function corregirjs2(str){
	str = str.replace(/&aacute;/g, "a");
	str = str.replace(/&eacute;/g, "e");
	str = str.replace(/&iacute;/g, "i");
	str = str.replace(/&oacute;/g, "o");
	str = str.replace(/&uacute;/g, "u");
	str = str.replace(/&Aacute;/g, "A");
	str = str.replace(/&Eacute;/g, "E");
	str = str.replace(/&Iacute;/g, "I");
	str = str.replace(/&Oacute;/g, "O");
	str = str.replace(/&Uacute;/g, "U");
	str = str.replace(/&ntilde;/g, "n");
	str = str.replace(/&Ntilde;/g, "N");
	str = str.replace(/&iquest;/g, "¿");
	str = str.replace(/&deg;/g, "º");
	str = str.replace(/&prime;/g, "'");
	
	return str;
}

function corregirjs(str){
	str = str.replace(/á/g,"&aacute;");
	str = str.replace(/é/g,"&eacute;");
	str = str.replace(/í/g,"&iacute;");
	str = str.replace(/ó/g,"&oacute;");
	str = str.replace(/ú/g,"&uacute;");
	str = str.replace(/Á/g,"&Aacute;");
	str = str.replace(/É/g,"&Eacute;");
	str = str.replace(/Í/g,"&Iacute;");
	str = str.replace(/Ó/g,"&Oacute;");
	str = str.replace(/Ú/g,"&Uacute;");
	str = str.replace(/ñ/g,"&ntilde;");
	str = str.replace(/Ñ/g,"&Ntilde;");
	str = str.replace(/¿/g,"&iquest;");
	str = str.replace(/º/g,"&deg;");
	str = str.replace(/'/g,"&prime;");
	
	return str;
}

function deleteInvitado(idInvitado){

	peticion = nuevoAjax();
	url = "funciones.php?acc=deleteInvitado&idInvitado="+idInvitado;
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
		if (peticion.readyState == 4) {
			var respuesta = peticion.responseText;
			console.log(respuesta);
			location.reload();
		}
	}
}

function eliminarRubroMejora(idRubroMejora){
	peticion = nuevoAjax();
	url = "funciones.php?acc=deleteRubroMejora&idRubroMejora="+idRubroMejora;
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
		if (peticion.readyState == 4) {
			var respuesta = peticion.responseText;
		}
	}
}

function eliminarRubroOperacion(idRubroOperacion){
	peticion = nuevoAjax();
	url = "funciones.php?acc=deleteRubroOperacion&idRubroOperacion="+idRubroOperacion;
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
		if (peticion.readyState == 4) {
			var respuesta = peticion.responseText;
		}
	}
}


var posicionCampo=1;
function addCampo(){
	var obj = document.getElementById('sel').innerHTML;
    nuevaFila = document.getElementById("tabla").insertRow(-1);
    nuevaFila.id=posicionCampo;
    nuevaCelda=nuevaFila.insertCell(-1);
	
	/*
	nuevaCelda.innerHTML=  '<td><select type="text" name="valor['+posicionCampo+']">'+document.getElementById('valorID').innerHTML+'</select></td>';
	nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML=  '<td><select type="text" name="idrubro['+posicionCampo+']">'+obj+'</select></td>';
    nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML= '<td><input type="text" name="ahorro_min['+posicionCampo+']" placeholder="20.60"></td>'; 
    nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML='<td><input type="text" name="ahorro_max['+posicionCampo+']" placeholder="50.50"></td>';
	nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML= '<td><input type="text" name="pri_min['+posicionCampo+']" placeholder="1"></td>'; 
    nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML='<td><input type="text" name="pri_max['+posicionCampo+']" placeholder="7"></td>';
	nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML = '<td><input type="text" name="fuente['+posicionCampo+']" placeholder="Fuente"></td>';
	*/
	nuevaCelda.innerHTML=  '<td><select type="text" name="valor[]">'+document.getElementById('valorID').innerHTML+'</select></td>';
	nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML=  '<td><select type="text" name="idrubro[]">'+obj+'</select></td>';
    nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML= '<td><input type="text" name="ahorro_min[]" placeholder="20.60"></td>'; 
    nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML='<td><input type="text" name="ahorro_max[]" placeholder="50.50"></td>';
	nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML= '<td><input type="text" name="pri_min[]" placeholder="1"></td>'; 
    nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML='<td><input type="text" name="pri_max[]" placeholder="7"></td>';
	nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML = '<td><input type="text" name="fuente[]" placeholder="Fuente"></td>';
	
    nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML = "<td><a class='btn btn-primary' onclick='eliminarCampo(this)'><span class='glyphicon glyphicon-trash'></span></a></td>";
    posicionCampo++;
}


function eliminarCampo(obj){
    var oTr = obj;
    while(oTr.nodeName.toLowerCase()!='tr'){
   		oTr=oTr.parentNode;
    }

    var root = oTr.parentNode;
    root.removeChild(oTr);
}




var posicionCampo2=1;
function addCampo2(){
	var obj = document.getElementById('sel2').innerHTML;
    nuevaFila = document.getElementById("tabla2").insertRow(-1);
    nuevaFila.id=posicionCampo2;
    nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML=  '<td><input type="text" name="orden[]" placeholder="0"></td>';
	nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML=  '<td><select type="text" name="idrubro[]">'+obj+'</select></td>';
    nuevaCelda=nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML= '<td><input type="text" name="consumo_especifico[]" placeholder="20.60"></td>'; 
    nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML = '<td><input type="text" name="fuente[]" placeholder="Fuente"></td>';
    nuevaCelda=nuevaFila.insertCell(-1);
    nuevaCelda.innerHTML = '<td><input class="producto" type="text" name="producto[]" placeholder="Producto"></td>';
    nuevaCelda=nuevaFila.insertCell(-1);
    //id="producto"

    nuevaCelda.innerHTML = "<td><a class='btn btn-primary' onclick='eliminarCampo2(this)'><span class='glyphicon glyphicon-trash'></span></a></td>";
    posicionCampo2++;
}


function eliminarCampo2(obj){
    var oTr = obj;
    while(oTr.nodeName.toLowerCase()!='tr'){
   		oTr=oTr.parentNode;
    }
    var root = oTr.parentNode;
    root.removeChild(oTr);
}