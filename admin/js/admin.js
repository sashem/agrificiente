$(document).ready(function() {
	if($('#main_table')) $('#main_table').DataTable({"pageLength": 100});
} );

function menu(tag){
	obj = document.getElementById(tag);
	if( obj.style.display != '' ) obj.style.display='';
	else obj.style.display='none';
}
function amenu(tag){
	obj = document.getElementById(tag);
	if(obj.style.display==''){
		obj.style.display='none';
	} else {
		obj.style.display='';
	}
}
function quitar(tag){
	obj = document.getElementById(tag);
	obj.style.display='none';
}
function validar(evt){
	var nav4 = window.Event ? true : false;
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57) || key == 46);
}
function reemplazarPuntos(){
	var str = document.getElementById('num').value;
	i=0
	while(i<=6){
	str = str.replace('.','');
	i++;
	}
	document.getElementById('num').value = str;
}


var numero = 0; 
evento = function (evt) {
	return (!evt) ? event : evt;
}
addCampo = function () { 
   	nDiv = document.createElement('div');
   	nDiv.className = 'archivo';
   	nDiv.id = 'file' + (++numero);
   	nCampo = document.createElement('input');
   	nCampo.name = 'archivo[]';
   	nCampo.type = 'file';
   	a = document.createElement('a');
   	a.name = nDiv.id;
   	a.href = '#';
   	a.onclick = elimCamp;
   	a.innerHTML = 'Eliminar';
   	nDiv.appendChild(nCampo);
   	nDiv.appendChild(a);
   	container = document.getElementById('adjuntos');
   	container.appendChild(nDiv);
}
elimCamp = function (evt){
	evt = evento(evt);
	nCampo = rObj(evt);
	div = document.getElementById(nCampo.name);
	div.parentNode.removeChild(div);
}
rObj = function (evt) { 
	return evt.srcElement ?  evt.srcElement : evt.target;
}

function SetAllCheckBoxes(chkbox){
	for (var i=0;i < document.forms["form"].elements.length;i++){
		var elemento = document.forms[0].elements[i];
		if (elemento.type == "checkbox"){
			elemento.checked = chkbox.checked
		}
	}
}
function mostrar_lang(id_lang,intlang,total,code,actual_lang){
	var i;
	for(i=1; i<=total; i++){
		document.getElementById(id_lang+i).style.display = "none";
	}
	document.getElementById(id_lang+intlang).style.display = "";
	document.getElementById(actual_lang).innerHTML = code;
	//document.getElementById(id_lang).style.display = "";
}

function mostrar_lang2(id_lang,intlang,total,code,actual_lang){
	var i;
	alert(id_lang+intlang);
	for(i=1; i<=total; i++){
		document.getElementsByClassName(id_lang+i).style.display = "none";
	}
	document.getElementsByClassName(id_lang+intlang).style.display = "";
	document.getElementById(actual_lang).innerHTML = code;
}
