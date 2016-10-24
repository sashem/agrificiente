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
function mostrar_producto(producto){
	//console.log(producto);
	$(".lista_procesos").addClass("invisible");
	$("#"+producto).removeClass("invisible");
	$(".btn_producto").removeClass("activo");
	$("#btn_"+producto).addClass("activo");
	$("#"+producto).first().children("li").first().children("a").click();
}
function updateStaring(numero){
	var n = numero*22;
	document.getElementById('currentStar').style.width = n+"px";
}
function ValidarEvalProveedor(){
	var mensaje = true;
	var nota = true;
	mensaje = valMensaje(document.formi.mensaje.value);
	nota = valNota(document.formi.rating.value);
	if( nota == false){
		alert("Debes darle una nota al proveedor");
		return false;
	} if(mensaje == false) {
		alert("Debes justificar tu nota");
		return false;
	} 
	return true;
	
}
function valNota(valor){
	if(containNum(valor)==1){
		return true;
	} else {
		return false;
	}
}

function valMensaje(valor){
	if(trim(valor) == ""){
		return false;
	} else {
		return true;/*
		if(valor.length<2){
			return false;
		} else {	
			return true;
		}*/
	}
}
function trim(strr){
	var lal = strr;
	return lal.replace(/^\s+/g,'').replace(/\s+$/g,'');
}
function containNum(text){
	var numbers="0123456789";
	for(i=0; i<text.length; i++){
      if (numbers.indexOf(text.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;	
}

function checkNick(nickname,field){

	document.getElementById('estado').innerHTML = "&nbsp;&nbsp; <img src='img/loading.gif'>";
	var nick = nickname;
	var respuesta;
	var url = "functions.php?c=verNick&nickn="+nick;
	peticion = nuevoAjax();
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
 	if (peticion.readyState == 4) {
	  	respuesta = peticion.responseText;
		if(respuesta=='si'){
			document.getElementById('estado').innerHTML = ' &nbsp;&nbsp; <font style="color:#cc0000">Ya existe el usuario</font>';
			document.getElementById(field).style.borderColor = '#cc0000';
			document.getElementById(field).style.backgroundColor = '#ffdddd';
			//document.getElementById("Submit").disabled = true;
		} else {
			document.getElementById('estado').innerHTML = '';
			document.getElementById(field).style.borderColor = '#C7D6DB';
			document.getElementById(field).style.backgroundColor = '#F8F8F8';	
			//document.getElementById("Submit").disabled = false;
		}
	  	
	  	
	}
	  
  }
}
function ficha_operacion(rubro,operacion){
	$(".item_proceso").removeClass("btn_activo");
	$("#op_"+rubro+"_"+operacion).addClass("btn_activo");
	document.getElementById('detalle_ficha_proceso').innerHTML = "&nbsp;&nbsp; <img src='img/loading.gif'>";
	var respuesta;
	var url = "acciones.php?acc=fichaOperacion&rubro="+rubro+"&operacion="+operacion;
	peticion = nuevoAjax();
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
 	if (peticion.readyState == 4) {
	  	respuesta = peticion.responseText;
		document.getElementById('detalle_ficha_proceso').innerHTML = respuesta;
	}
	  
  }
}


function guardarDiagnostico(){
	document.getElementById("diag").action = "acciones.php?acc=cargarDiagnostico";
	document.getElementById("diag").submit();
}
function cargarDataDiagnostico(idImpres,diagnostico){
	document.getElementById(idImpres).innerHTML = "&nbsp;&nbsp; <img src='img/loading.gif'>";
	var respuesta;
	var url = "acciones.php?acc=cargarDataDiagnostico&diagnostico="+diagnostico;
	peticion = nuevoAjax();
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
		if (peticion.readyState == 4) {
			respuesta = peticion.responseText;
			document.getElementById(idImpres).innerHTML = respuesta;
		}
  	}
}
function getTipoC(idcombustible,idImpres){

	document.getElementById(idImpres).innerHTML = "&nbsp;&nbsp; <img src='img/loading.gif'>";
	var respuesta;
	var url = "acciones.php?acc=getTipoC&idcombustible="+idcombustible;
	peticion = nuevoAjax();
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
 	if (peticion.readyState == 4) {
	  	respuesta = peticion.responseText;
		document.getElementById(idImpres).innerHTML = respuesta;
	}
	  
  }
}

function getUniProd(idrubro,idImpres){

	document.getElementById(idImpres).innerHTML = "&nbsp;&nbsp; <img src='img/loading.gif'>";
	var respuesta;
	var url = "acciones.php?acc=getUniProductiva&idrubro="+idrubro;
	peticion = nuevoAjax();
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
 	if (peticion.readyState == 4) {
	  	respuesta = peticion.responseText;
		document.getElementById(idImpres).innerHTML = respuesta;
	}
	  
  }
}




function checkCheckBox(f){
	if (f.agree.checked == false ){
		alert('Debes aceptar nuestros terminos y condiciones');
		return false;
	}	else {
		return true;
	}
}

function editVoto(identif,idVoto,proveedor){
	var escrito = document.getElementById(identif).innerHTML;
	var idField = "textEdit"+idVoto;
	//var textinput = document.getElementById("textEdit"+idVoto).value;
	document.getElementById(identif).innerHTML = "<form method='post' action='acciones.php?acc=editVoto'><input type='hidden' name='idvoto' value='"+idVoto+"'><input type='hidden' name='proveedor' value='"+proveedor+"'><input type='text' name='mensaje' id='"+idField+"' class='reply_box2' value='"+escrito+"'><input type='submit' class='btn floatright reply_button' value='Guardar'></form>";
}

function completeMejoras(){
	var chk_arr =  document.getElementsByName("idmejora[]");
	var chklength = chk_arr.length;             
	var n_checked = 0;
	for(k=0;k<chklength;k++)
	{
		if (chk_arr[k].checked) {
			n_checked = n_checked+1;
        }
	} 
	//alert("Seleccionados: "+n_checked);
	if(n_checked>3){ // error
		alert("Puedes seleccionar un maximo de 3 mejoras");
		return false;
	} else {
		return true;
	}
}

function cargar_mejoras(idrubro,capaid,pagina){

	document.getElementById(capaid).innerHTML = "&nbsp;&nbsp; <img src='img/loading.gif'>";
	var respuesta;
	var url = "acciones.php?acc=cargar_mejoras&idrubro="+idrubro+"&pagina="+pagina+"&capa="+capaid;
	peticion = nuevoAjax();
	peticion.open("POST", url, true);
	peticion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
	peticion.send(url);
	peticion.onreadystatechange = function () {
		if (peticion.readyState == 4) {
			respuesta = peticion.responseText;
			document.getElementById(capaid).innerHTML = respuesta;
		}
  	}
}