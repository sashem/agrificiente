<?php
@session_start();
$fecha = date('Y-m-d H:i:s');
@include("../config.php");

function limpiar($str) {
	$banchars = array ("'", ",", ";", "--", ")", "(","\n","\r", "\\");
	$banwords = array (" or "," OR "," Or "," oR "," and ", " AND "," aNd "," aND "," AnD "); 
	if ( eregi ( "[a-zA-Z0-9]+", $str ) ) {
		$str = str_replace ( $banchars, '', ( $str ) );
		$str = str_replace ( $banwords, '', ( $str ) );
	} else {
		$str = NULL;
	}
	$str = trim($str);
	$str = strip_tags($str);
	$str = stripslashes($str);
	$str = addslashes($str);
	$str = htmlspecialchars($str);
	return $str;
}


function ir($str) {
	?><script>location.href='<?=$str?>'</script><?
}

function limpiar2($str) {
	$banchars = array ("'", ",", "--", ")", "(","\n","\r", "\\");
	$banwords = array (" or "," OR "," Or "," oR "," and ", " AND "," aNd "," aND "," AnD "); 
	if ( eregi ( "[a-zA-Z0-9]+", $str ) ) {
		$str = str_replace ( $banchars, '', ( $str ) );
		$str = str_replace ( $banwords, '', ( $str ) );
	} else {
		$str = NULL;
	}
	$str = trim($str);
	$str = strip_tags($str);
	$str = stripslashes($str);
	$str = addslashes($str);
	return $str;
}
function limpiar4($str) {
	$banchars = array ("'", ",", "--", ")", "(","","\r", "\\");
	$banwords = array (" or "," OR "," Or "," oR "," and ", " AND "," aNd "," aND "," AnD "); 
	if ( eregi ( "[a-zA-Z0-9]+", $str ) ) {
		$str = str_replace ( $banchars, '', ( $str ) );
		$str = str_replace ( $banwords, '', ( $str ) );
	} else {
		$str = NULL;
	}
	$str = trim($str);
	$str = strip_tags($str);
	$str = stripslashes($str);
	$str = addslashes($str);
	return $str;
}
/*
function corregir($str) {
	if ( eregi ( "[a-zA-Z0-9ñÑ]+", $str ) ) {
		$str = str_replace ( 'á', '&aacute;', ( $str ) );
		$str = str_replace ( 'é', '&eacute;', ( $str ) );
		$str = str_replace ( 'í', '&iacute;', ( $str ) );
		$str = str_replace ( 'ó', '&oacute;', ( $str ) );
		$str = str_replace ( 'ú', '&uacute;', ( $str ) );
		$str = str_replace ( 'Á', '&Aacute;', ( $str ) );
		$str = str_replace ( 'É', '&Eacute;', ( $str ) );
		$str = str_replace ( 'Í', '&Iacute;', ( $str ) );
		$str = str_replace ( 'Ó', '&Oacute;', ( $str ) );
		$str = str_replace ( 'Ú', '&Uacute;', ( $str ) );
		$str = str_replace ( 'ñ', '&ntilde;', ( $str ) );
		$str = str_replace ( 'Ñ', '&Ntilde;', ( $str ) );
		$str = str_replace ( '¿', '&iquest;', ( $str ) );	
	} else {
		$str = NULL;
	}
	return $str;
}*/

function corregir($str){
	$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a','â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
	$str = strtr($str, $unwanted_array);
	
	if ( eregi ( "[a-zA-Z0-9ñÑ,;.:()]+", $str ) ) {
		$str = str_replace ( 'á', '&aacute;', ( $str ) );
		$str = str_replace ( 'é', '&eacute;', ( $str ) );
		$str = str_replace ( 'í', '&iacute;', ( $str ) );
		$str = str_replace ( 'ó', '&oacute;', ( $str ) );
		$str = str_replace ( 'ú', '&uacute;', ( $str ) );
		$str = str_replace ( 'Á', '&Aacute;', ( $str ) );
		$str = str_replace ( 'É', '&Eacute;', ( $str ) );
		$str = str_replace ( 'Í', '&Iacute;', ( $str ) );
		$str = str_replace ( 'Ó', '&Oacute;', ( $str ) );
		$str = str_replace ( 'Ú', '&Uacute;', ( $str ) );
		$str = str_replace ( 'ñ', '&ntilde;', ( $str ) );
		$str = str_replace ( 'Ñ', '&Ntilde;', ( $str ) );
		$str = str_replace ( '¿', '&iquest;', ( $str ) );
		$str = str_replace ( '°', '&deg;', ( $str ) );	
		$str = str_replace ( "'", "&#39;", ( $str ) );
		$str = str_replace ( '¡', '&iexcl;', ( $str ) );
		$str = str_replace ( '"', '&quot;', ( $str ) );	
		$str = str_replace ( '`', '', ( $str ) );
		$str = str_replace ( '¬', '&not;', ( $str ) );
		$str = str_replace ( '®', '&reg;', ( $str ) );
		$str = str_replace ( '©', '&copy;', ( $str ) );
		$str = str_replace ( '¨', '&uml;', ( $str ) );
		$str = str_replace ( '£', '&pound;', ( $str ) );
		$str = str_replace ( '¢', '&cent;', ( $str ) );
		$str = str_replace ( 'º', '&ordm;', ( $str ) );
		$str = str_replace ( '»', '&raquo;', ( $str ) );
		$str = str_replace ( '·', '&middot;', ( $str ) );
		$str = str_replace ( '÷', '&divide;', ( $str ) );
		$str = str_replace ( '€', '&euro;', ( $str ) );
		$str = str_replace ( '™', '&#8482;', ( $str ) );
		$str = str_replace ( '(', '&#40;', ( $str ) );
		$str = str_replace ( ')', '&#41;', ( $str ) );
		$str = str_replace ( '$', '&#36;', ( $str ) );
		$str = str_replace ( '%', '&#37;', ( $str ) );
		$str = str_replace ( '*', '&#42;', ( $str ) );
		$str = str_replace ( '+', '&#43;', ( $str ) );
		$str = str_replace ( ':', '&#58;', ( $str ) );
		$str = str_replace ( '^', '&#94;', ( $str ) );
		$str = str_replace ( '~', '&#126;', ( $str ) );
		$str = str_replace ( '{', '&#123;', ( $str ) );
		$str = str_replace ( '}', '&#125;', ( $str ) );
		$str = str_replace ( '|', '&#124;', ( $str ) );
	} else {
		$str = NULL;
	}
	
	return $str;
}

function invcorregir($str) {
	if ( eregi ( "[a-zA-Z0-9]+", $str ) ) {
		$str = str_replace ( '&aacute;', 'á', ( $str ) );
		$str = str_replace ( '&eacute;', 'é', ( $str ) );
		$str = str_replace ( '&iacute;', 'í', ( $str ) );
		$str = str_replace ( '&oacute;', 'ó', ( $str ) );
		$str = str_replace ( '&uacute;', 'ú', ( $str ) );
		$str = str_replace ( '&Aacute;', 'Á', ( $str ) );
		$str = str_replace ( '&Eacute;', 'É', ( $str ) );
		$str = str_replace ( '&Iacute;', 'Í', ( $str ) );
		$str = str_replace ( '&Oacute;', 'Ó', ( $str ) );
		$str = str_replace ( '&Uacute;', 'Ú', ( $str ) );
		$str = str_replace ( '&ntilde;', 'ñ', ( $str ) );
		$str = str_replace ( '&Ntilde;', 'Ñ', ( $str ) );
		$str = str_replace ( '&iquest;', '¿', ( $str ) );	
	} else {
		$str = NULL;
	}
	return $str;
}

function soloPorcentajes($str) {
	if ( eregi ( "[0-9.]", $str ) ) {
		$str = str_replace ( '%', '', ( $str ) );
		$str = str_replace ( ',', '.', ( $str ) );
	} else {
		$str = NULL;
	}
	return $str;
}
function corregirEsp($str){
	if ( eregi ( "[a-zA-Z0-9ñÑ,;.]+", $str ) ) {
		$str = str_replace ( 'á', '&aacute;', ( $str ) );
		$str = str_replace ( 'é', '&eacute;', ( $str ) );
		$str = str_replace ( 'í', '&iacute;', ( $str ) );
		$str = str_replace ( 'ó', '&oacute;', ( $str ) );
		$str = str_replace ( 'ú', '&uacute;', ( $str ) );
		$str = str_replace ( 'Á', '&Aacute;', ( $str ) );
		$str = str_replace ( 'É', '&Eacute;', ( $str ) );
		$str = str_replace ( 'Í', '&Iacute;', ( $str ) );
		$str = str_replace ( 'Ó', '&Oacute;', ( $str ) );
		$str = str_replace ( 'Ú', '&Uacute;', ( $str ) );
		$str = str_replace ( 'ñ', '&ntilde;', ( $str ) );
		$str = str_replace ( 'Ñ', '&Ntilde;', ( $str ) );
		$str = str_replace ( '¿', '&iquest;', ( $str ) );
		$str = str_replace ( '°', '&deg;', ( $str ) );	
		$str = str_replace ( "'", "&#39;", ( $str ) );
		$str = str_replace ( '¡', '&iexcl;', ( $str ) );
		$str = str_replace ( '"', '&quot;', ( $str ) );	
		$str = str_replace ( '`', '', ( $str ) );
		$str = str_replace ( '¬', '&not;', ( $str ) );
		$str = str_replace ( '®', '&reg;', ( $str ) );
		$str = str_replace ( '©', '&copy;', ( $str ) );
		$str = str_replace ( '¨', '&uml;', ( $str ) );
		$str = str_replace ( '£', '&pound;', ( $str ) );
		$str = str_replace ( '¢', '&cent;', ( $str ) );
		$str = str_replace ( 'º', '&ordm;', ( $str ) );
		$str = str_replace ( '»', '&raquo;', ( $str ) );
		$str = str_replace ( '·', '&middot;', ( $str ) );
		$str = str_replace ( '÷', '&divide;', ( $str ) );
		$str = str_replace ( '€', '&euro;', ( $str ) );
		$str = str_replace ( '™', '&#8482;', ( $str ) );
		$str = str_replace ( '(', '&#40;', ( $str ) );
		$str = str_replace ( ')', '&#41;', ( $str ) );
		$str = str_replace ( '$', '&#36;', ( $str ) );
		$str = str_replace ( '%', '&#37;', ( $str ) );
		$str = str_replace ( '*', '&#42;', ( $str ) );
		$str = str_replace ( '+', '&#43;', ( $str ) );
		$str = str_replace ( ':', '&#58;', ( $str ) );
		$str = str_replace ( '^', '&#94;', ( $str ) );
		$str = str_replace ( '~', '&#126;', ( $str ) );
		$str = str_replace ( '{', '&#123;', ( $str ) );
		$str = str_replace ( '}', '&#125;', ( $str ) );
		$str = str_replace ( '|', '&#124;', ( $str ) );
	} else {
		$str = NULL;
	}
	
	return $str;
}
function cargar_contenido(){
	$id = $_GET['id'];
	if (!isset($id)) {
    	include("modules/control.php");
    } else {
		if(file_exists("modules/".$id.".php")) {
			$id = htmlspecialchars(trim($id));
        	$id = eregi_replace("<[^>]*>","",$id) ;
        	$id = eregi_replace(".*//","",$id) ;
       		include("modules/".$id.".php");
    	} else {
        	include("modules/control.php");
    	}
	}
}



function email($nombre,$email,$asunto,$mensaje){
	//$to = "chilebjk@gmail.com";
	$to = "linkini@gmail.com";
	$from = $email;
	$subject = $asunto;
	$mensaje = str_replace("\n","<br>",$mensaje);
	$message = "
	<strong>Nombre:</strong> ".$nombre."<br>
	<strong>Email:</strong> ".$from."<br>
	<strong>Mensaje:</strong><br>
	".$mensaje."<br>
	";
	
	$headers= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From:<".$from.">";
	mail($to, $subject, $message, $headers);
}

function image_exists($url)
{
    if(@getimagesize($url)){
    	return 1;
    } else {
        return 0;
 }
}

function cargarPDF($file_imagen){

	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "../img";
	$size_max = 36700000000000000000000000;
	$seedx = str_replace("-","",rand(000,999));
	$archivo_name = "precios_".date('YmdHis')."_".$seedx.".".$extension;
	
	$verify = mysql_query("SELECT pdf as imagen FROM admin WHERE id=1");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		$archivo1 = $rr['imagen'];
		$carpeta = "../img/";
		if(file_exists($carpeta.$archivo1)){
			@unlink($carpeta.$archivo1);
		}
	}
	
	if($file_imagen['size'] <= $size_max){
		if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
			chmod($carpeta_index.'/'.$archivo_name, 0777);
			$SQL_ADDFOTO = "UPDATE admin SET pdf='".$archivo_name."'";
			mysql_query($SQL_ADDFOTO);
		}
	} else {
		echo 'Error: Ha superado el l&iacute;mite de peso por archivo';
	}
}

function cargarfotoEvento($file_imagen,$evento){
	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "../eventos/";
	$size_max = 36700000;
	$seedx = str_replace("-","",rand(00,99));
	$archivo_name = date('YmdHis')."_".$seedx.".".$extension;
	//eliminar las anteriores
	$ver_anteriores = mysql_query("SELECT id_evento FROM eventos WHERE id_evento=".$evento."");
	while($imgant = mysql_fetch_array($ver_anteriores)){
		eliminar_foto_evento($imgant['id_evento']);
	}
	
	if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
		if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
			$SQL_ADDFOTO = "UPDATE eventos SET formato='".$archivo_name."' WHERE id_evento=".$evento."";
			mysql_query($SQL_ADDFOTO);
		}
	} else {
		echo 'Error: Ha superado el l&iacute;mite de peso por foto';
	}
}
function eliminar_foto_evento($evento){
	$verify = mysql_query("SELECT id_evento,formato as imagen FROM eventos WHERE id_evento=".$evento."");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		$archivo1 = $rr['imagen'];
		$carpeta = "../eventos/";
		if(file_exists($carpeta.$archivo1)){
			@unlink($carpeta.$archivo1);
		}
		return $rr['id_evento'];
	}
}



function cargarfotoRubro($file_imagen,$principal,$rubro){
	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "../rubros/";
	$size_max = 36700000;
	$seedx = str_replace("-","",rand(00,99));
	$archivo_name = date('YmdHis')."_".$seedx.".".$extension;
	//eliminar las anteriores
	$ver_anteriores = mysql_query("SELECT id_img FROM imagenes_rubros WHERE id_rubro=".$rubro."");
	while($imgant = mysql_fetch_array($ver_anteriores)){
		eliminar_foto_rubro($imgant['id_img'],$rubro);
	}
	
	if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
		if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
			$fecha = date("Y-m-d H:i:s");
			$SQL_ADDFOTO = "INSERT INTO imagenes_rubros (imagen,id_rubro,principal) VALUES ('".$archivo_name."','".$rubro."','1')";
			mysql_query($SQL_ADDFOTO);
		}
	} else {
		echo 'Error: Ha superado el l&iacute;mite de peso por foto';
	}
}

function eliminar_foto_rubro($idimg,$rubro){
	$verify = mysql_query("SELECT id_img,imagen,principal FROM imagenes_rubros WHERE id_rubro=".$rubro." AND id_img=".$idimg."");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		$archivo1 = $rr['imagen'];
		$carpeta = "../rubros/";
		if(file_exists($carpeta.$archivo1)){
			unlink($carpeta.$archivo1);
		}
		$sql_del_img = "DELETE FROM imagenes_rubros WHERE id_rubro=".$rubro." AND id_img=".$idimg."";
		mysql_query($sql_del_img);
		return $rr['id_img'];
	}
}


function cargarIconoRubro($file_imagen,$rubro){
	session_start();
	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "../iconos/";
	$size_max = 36700000;
	$seedx = str_replace("-","",rand(00,99));
	$archivo_name = "icon-".date('mdHis')."_".$seedx.".".$extension;

	if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
		if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
			$SQL_ADDFOTO = "UPDATE rubros SET imagen='".$archivo_name."' WHERE id_rubro=".$rubro."";
			mysql_query($SQL_ADDFOTO);
		}
	} else {
		echo 'Error: Ha superado el l&iacute;mite de peso por foto';
	}
}


function cargarDiagramaRubro($file_imagen,$rubro){
	session_start();
	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "../rubros/";
	$size_max = 36700000;
	$seedx = str_replace("-","",rand(00,99));
	$archivo_name = "diag".date('YmdHis')."_".$seedx.".".$extension;

	eliminar_diagrama_rubro($rubro);
	if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
		if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
			$fecha = date("Y-m-d H:i:s");
			$SQL_ADDFOTO = "UPDATE rubros SET diagrama_flujo='".$archivo_name."' WHERE id_rubro=".$rubro."";
			mysql_query($SQL_ADDFOTO);
		}
	} else {
		echo 'Error: Ha superado el l&iacute;mite de peso por foto';
	}
}

function eliminar_diagrama_rubro($rubro){
	session_start(); 
	$verify = mysql_query("SELECT diagrama_flujo as imagen FROM rubros WHERE id_rubro=".$rubro."");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		$archivo1 = $rr['imagen'];
		if(strlen($archivo1)>1){
			$carpeta = "../rubros/";
			if(file_exists($carpeta.$archivo1)){
				unlink($carpeta.$archivo1);
			}
		}
		$sql_del_img = "UPDATE rubros SET diagrama_flujo='' WHERE id_rubro=".$rubro."";
		mysql_query($sql_del_img);
	}
}





function cargarfotoProducto($file_imagen,$id_categoria){

	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "../albumes";
	$size_max = 36700000;
	$seedx = str_replace("-","",rand(00000,99999));
	$archivo_name = date('YmdHis')."_".$seedx.".".$extension;
	
	if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
		if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
			$SQL_ADDFOTO = "INSERT INTO imagenes (id_categoria,imagen) VALUES ('".$id_categoria."','".$archivo_name."')";
			mysql_query($SQL_ADDFOTO);
			resize_fotoProducto($archivo_name);
			resize_mini_fotoProducto($archivo_name);
		}
	} else {
		echo 'Error: Ha superado el l&iacute;mite de peso por foto';
	}
}

function resize_mini_fotoProducto($archivo_name){
	$directorio = "../albumes/";
	$archivo_name = $archivo_name;
	$pot = $directorio.$archivo_name;
	$pot2 = $directorio."mini_".$archivo_name;
	$partes = explode('.',$archivo_name) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num];
										
	if($extension=="jpg" or $extension=="JPG" or $extension=="jpeg" or $extension=="JPEG" or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG'){ $original = imagecreatefromjpeg($pot); }
	if($extension=="gif" or $extension=="GIF"){ $original = imagecreatefromgif($pot); }	
	if($extension=="png" or $extension=="PNG"){ $original = imagecreatefrompng($pot); }						
	$ancho = imagesx($original);
	$alto = imagesy($original);
	
	$new_alto = 320;
	
	if($alto>$new_alto){
		$new_ancho = round(($new_alto*$ancho)/$alto); 
		$thumb = imagecreatetruecolor($new_ancho,$new_alto);
	} else {
		$new_ancho = $ancho;
		$new_alto = $alto;
		$thumb = imagecreatetruecolor($new_ancho,$new_alto);
	}
	
	if($extension=="jpg" or $extension=="JPG" or $extension=="jpeg" or $extension=="JPEG" or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG'){ 
		$original = imagecreatefromjpeg($pot); 
		$thumb = imagecreatetruecolor($new_ancho,$new_alto);
		imagecopyresampled($thumb, $original, 0, 0, 0, 0, $new_ancho, $new_alto, $ancho, $alto); 
		imagejpeg($thumb,$pot2,90); 
	}
	if($extension=="gif" or $extension=="GIF"){ 
		imagecopyresampled($thumb, $original, 0, 0, 0, 0, $new_ancho, $new_alto, $ancho, $alto); 
		imagegif($thumb,$pot2,90); 
	}
	if($extension=="png" or $extension=="PNG"){ 
		$im = imagecreatefrompng($pot);
		$srcWidth = imagesx($original);
		$srcHeight = imagesy($original);
		$nWidth = $new_ancho;
		$nHeight = $new_alto;
		$newImg = imagecreatetruecolor($nWidth, $nHeight);
		imagealphablending($newImg, false);
		imagesavealpha($newImg,true);
		$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
		imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
		imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight,$srcWidth, $srcHeight);
		imagepng($newImg, $pot2);
	}
}
function resize_fotoProducto($archivo_name){
	
	$directorio = "../albumes/";
	ini_set('gd.jpeg_ignore_warning', 1);
	ini_set('memory_limit', '10000M'); //Raise to 512 MB
	ini_set('max_execution_time', '6000000'); //Raise to 512 MB
	$pot = $directorio.$archivo_name;
	$archivo_name = $archivo_name;
	$partes = explode('.',$archivo_name);
	$num = count($partes) - 1 ;
	$extension = $partes[$num];
										
	if($extension=="jpg" or $extension=="JPG" or $extension=="jpeg" or $extension=="JPEG" or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG'){ $original = imagecreatefromjpeg($pot); }
	if($extension=="gif" or $extension=="GIF"){ $original = imagecreatefromgif($pot); }	
	if($extension=="png" or $extension=="PNG"){ $original = imagecreatefrompng($pot); }						
	$ancho = imagesx($original);
	$alto = imagesy($original);
	
	$new_alto = 800;
	
	if($alto>$new_alto){
		$new_ancho = round(($new_alto*$ancho)/$alto); 
		$thumb = imagecreatetruecolor($new_ancho,$new_alto);
	} else {
		$new_ancho = $ancho;
		$new_alto = $alto;
		$thumb = imagecreatetruecolor($new_ancho,$new_alto);
	}
	if($extension=="jpg" or $extension=="JPG" or $extension=="jpeg" or $extension=="JPEG" or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG'){ 
		$original = imagecreatefromjpeg($pot); 
		$thumb = imagecreatetruecolor($new_ancho,$new_alto);
		imagecopyresampled($thumb, $original, 0, 0, 0, 0, $new_ancho, $new_alto, $ancho, $alto); 
		imagejpeg($thumb,$pot,90); 
	}
	if($extension=="gif" or $extension=="GIF"){ 
		imagecopyresampled($thumb, $original, 0, 0, 0, 0, $new_ancho, $new_alto, $ancho, $alto); 
		imagegif($thumb,$pot,90); 
	}
	if($extension=="png" or $extension=="PNG"){ 
		$im = imagecreatefrompng($pot);
		$srcWidth = imagesx($original);
		$srcHeight = imagesy($original);
		$nWidth = $new_ancho;
		$nHeight = $new_alto;
		$newImg = imagecreatetruecolor($nWidth, $nHeight);
		imagealphablending($newImg, false);
		imagesavealpha($newImg,true);
		$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
		imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
		imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight,$srcWidth, $srcHeight);
		imagepng($newImg, $pot);
	}
}
	

	
function bmp2gd($src, $dest = false){
    if(!($src_f = fopen($src, "rb"))){
        return false;
    }
 
	if(!($dest_f = fopen($dest, "wb"))){
        return false;
    }

	$header = unpack("vtype/Vsize/v2reserved/Voffset", fread( $src_f, 14));
 
	$info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant",
	fread($src_f, 40));
	 
	extract($info);
	extract($header);
	 
	if($type != 0x4D42){
		return false;
	}
 
	$palette_size = $offset - 54;
	$ncolor = $palette_size / 4;
	$gd_header = "";
 
	$gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF";
	$gd_header .= pack("n2", $width, $height);
	$gd_header .= ($palette_size == 0) ? "\x01" : "\x00";
	if($palette_size) {
		$gd_header .= pack("n", $ncolor);
	}
	
	$gd_header .= "\xFF\xFF\xFF\xFF";
	fwrite($dest_f, $gd_header);
	 
	if($palette_size){
		$palette = fread($src_f, $palette_size);
		$gd_palette = "";
		$j = 0;
		while($j < $palette_size)
		{
			$b = $palette{$j++};
			$g = $palette{$j++};
			$r = $palette{$j++};
			$a = $palette{$j++};
			$gd_palette .= "$r$g$b$a";
		}
		$gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);
		fwrite($dest_f, $gd_palette);
	}
 
	$scan_line_size = (($bits * $width) + 7) >> 3;
	$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 0x03) : 0;
	 
	for($i = 0, $l = $height - 1; $i < $height; $i++, $l--){
		fseek($src_f, $offset + (($scan_line_size + $scan_line_align) * $l));
		$scan_line = fread($src_f, $scan_line_size);
		if($bits == 24){
			$gd_scan_line = "";
			$j = 0;
			while($j < $scan_line_size)
			{
				$b = $scan_line{$j++};
				$g = $scan_line{$j++};
				$r = $scan_line{$j++};
				$gd_scan_line .= "\x00$r$g$b";
			}
		}
		elseif($bits == 8){
			$gd_scan_line = $scan_line;
		}
		elseif($bits == 4){
			$gd_scan_line = "";
			$j = 0;
			while($j < $scan_line_size)
			{
				$byte = ord($scan_line{$j++});
				$p1 = chr($byte >> 4);
				$p2 = chr($byte & 0x0F);
				$gd_scan_line .= "$p1$p2";
			}
			$gd_scan_line = substr($gd_scan_line, 0, $width);
		}
		elseif($bits == 1){
			$gd_scan_line = "";
			$j = 0;
			while($j < $scan_line_size){
				$byte = ord($scan_line{$j++});
				$p1 = chr((int) (($byte & 0x80) != 0));
				$p2 = chr((int) (($byte & 0x40) != 0));
				$p3 = chr((int) (($byte & 0x20) != 0));
				$p4 = chr((int) (($byte & 0x10) != 0));
				$p5 = chr((int) (($byte & 0x08) != 0));
				$p6 = chr((int) (($byte & 0x04) != 0));
				$p7 = chr((int) (($byte & 0x02) != 0));
				$p8 = chr((int) (($byte & 0x01) != 0));
				$gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";
			}
			$gd_scan_line = substr($gd_scan_line, 0, $width);
		}
		fwrite($dest_f, $gd_scan_line);
	}
	fclose($src_f);
	fclose($dest_f);
	return true;
}
 

function ImageCreateFromBmp($filename){
    $tmp_name = tempnam("", "GD");
    if(bmp2gd($filename, $tmp_name)){
        $img = imagecreatefromgd($tmp_name);
        unlink($tmp_name);
        return $img;
    }
    return false;
}

function eliminar_foto($idimg){
	$verify = mysql_query("SELECT id_img,imagen,principal FROM imagenes WHERE id_img=".$idimg."");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		
		$archivo1 = $rr['imagen'];
		$archivo2 = "mini_".$rr['imagen'];
		$carpeta = "../profiles/";
		if(file_exists($carpeta.$archivo1)){
			unlink($carpeta.$archivo1);
			
		}
		if(file_exists($carpeta.$archivo2)){
			unlink($carpeta.$archivo2);
		}
		$sql_del_img = "DELETE FROM imagenes WHERE id_img=".$idimg."";
		mysql_query($sql_del_img);
		return $rr['id_img'];
	}
}
		
function paginar_resultados($get_id,$total_paginas,$pagina,$orden){
?>
<div class="contenedor_paginas">
  		<ul class="pagination">
        <?
        if(($pagina - 1) > 0) {
            echo '<li><a href="index.php?id='.$get_id.'&pag='.($pagina-1).$orden.'">Anterior</a></li>';
        }
        if($total_paginas<=10){		
            for ($i=1; $i<=$total_paginas; $i++){
                if ($pagina == $i){
                    echo '<li class="active"><a href="#">'.$pagina.'</a></li>';
                } else {
                    echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
                }
            } 
        } else {
            if(($total_paginas-$pagina)<3){
                $move = 9;
            } elseif($pagina<5){
                $move = 9;
            } else {
                $move = 7;
            }
            if((($pagina+$move)<=$total_paginas) && ($pagina-$move)>0){
                if(($pagina-$move)>1){ echo "<li><a>...</a></li>";	 }
                for ($i=($pagina-$move); $i<=($pagina+$move); $i++){
                    if ($pagina == $i){
                        echo '<li class="active"><a href="#"><strong>'.$pagina.'</strong></a></li>';
                    } else {
                        echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
                    }
                } 
                if(($pagina+$move)<$total_paginas){ echo "<li><a>...</a></li>";	 }
            } elseif(($pagina+$move)>=$total_paginas && $pagina+$move<$total_paginas){		 /////// edited
            //} elseif(($pagina+$move)>$total_paginas){		
                echo "<li><a>...</a></li>";	
                for ($i=($pagina-$move-1); $i<=($total_paginas); $i++){
                    if ($pagina == $i){
                        echo '<li class="active"><a href="#"><strong>'.$pagina.'</strong></a></li>';
                    } else {
						if($i>0){ ///////////////
                        	echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
						} /////////////////////
                        //echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
                    }
                } 
            } else {
                for ($i=1; $i<=($pagina+$move+1); $i++){
                    if ($pagina == $i){
                        echo '<li class="active"><a href="#"><strong>'.$pagina.'</strong></a></li>';
                    } else {
						if($i<=$total_paginas && $i>($pagina-$move)){ ///////////////
                        	echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
						}
                        
                    }
                } 
                //echo "<li><a>...</a></li>";	
				if(($pagina+$move)<$total_paginas){ echo "<li><a>...</a></li>"; } //// edited
            }
        }
        if(($pagina + 1)<=$total_paginas) {
            echo "<li><a href='index.php?id=".$get_id."&pag=".($pagina+1).$orden."'>Siguiente</a></li>";
        }
    
        ?>
        </ul>
</div>
<?
}

if(isset($_GET['acc']) && $_GET['acc']!=NULL && $_GET['acc']!="" && isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
	if($_GET['acc']=="updatecontrol" && isset($_POST['actualizar'])){
		
		if($_FILES['imagen']['name'] != "" && strlen($_FILES['imagen']['name'])>1){
				cargarPDF($_FILES['imagen']);
		}
		
		if(trim($_POST['pass'])==NULL){
			$accadmin = "UPDATE admin SET user_name = '".$_POST['user']."', email = '".$_POST['email']."', updated='".$fecha."' WHERE id=1";
		} elseif(trim($_POST['pass'])!=NULL && strlen($_POST['pass'])>1 && strlen($_POST['pass2'])>1) {
			if($_POST['pass']==$_POST['pass2']){
				$accadmin = "UPDATE admin SET user_name = '".$_POST['user']."', user_password = '".md5($_POST['pass'])."', email = '".$_POST['email']."', updated = '".$fecha."' WHERE id=1";
			} else {
				echo "ERROR: Las contrase&ntilde;as no coinciden<br>";
			}
		} else {
			$accadmin = "UPDATE admin SET user_name = '".$_POST['user']."', email = '".$_POST['email']."', updated='".$fecha."' WHERE id=1";
		}
		
		if(strlen(trim($_POST['pdfpass']))>3){
			mysql_query("UPDATE admin SET clave_pdf = '".md5($_POST['pdfpass'])."' WHERE id=1");

		}
		$resca = mysql_query($accadmin);
		if($resca){
			?><script>location.href='index.php?id=control';</script><?
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}

		
	}

	elseif($_GET['acc']=="deleteInvitado" && isset($_GET['idInvitado'])){
		echo "ok";
		echo($_GET['idInvitado']);
		$sql_del_invitado = "DELETE FROM invitados_eventos WHERE id_invitado = ".$_GET['idInvitado']."";
		$delete_query = mysql_query($sql_del_invitado);
		if($delete_query){
			echo "Invitado borrado";
		}
	}

	elseif($_GET['acc']=="principal" && isset($_GET['categoria']) && isset($_GET['photo'])){
		mysql_query("UPDATE imagenes SET principal=0 WHERE id_categoria=".$_GET['categoria']."");	
		$comment = "UPDATE imagenes SET principal=1 WHERE id_categoria=".$_GET['categoria']." AND id_img=".$_GET['photo']."";
		$ss = mysql_query($comment);
		if($ss){
			?><script>location.href='index.php?id=verfotos&categoria=<?=$_GET['categoria']?>';</script><?
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	
	elseif($_GET['acc']=="editProyectoC" && isset($_POST['guardar'])){
		$proyecto = "UPDATE proyectos_consultados SET nombre='".corregir($_POST['nombre'])."',
		porcentaje='".$_POST['porcentaje']."',
		id_rubro=".$_POST['idrubro']."
		WHERE id_pc = ".$_POST['idpc']."";
		$edit_proyecto = mysql_query($proyecto);
		if($edit_proyecto){
			?><script>location.href='index.php?id=proyectos';</script><?
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	elseif($_GET['acc']=="delProyectoC" && isset($_GET['proyecto']) && is_numeric($_GET['proyecto'])){
		$proyecto = "DELETE FROM proyectos_consultados WHERE id_pc = ".$_GET['proyecto']."";
		$del_proyecto = mysql_query($proyecto);
		if($del_proyecto){
			?><script>location.href='index.php?id=proyectos';</script><?
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	elseif($_GET['acc']=="addProyectoC" && isset($_POST['agregar']) && is_numeric($_POST['idrubro']) && isset($_POST['idrubro'])){
		$proyecto = "INSERT INTO proyectos_consultados (id_rubro,nombre,porcentaje) VALUES ('".$_POST['idrubro']."','".corregir($_POST['nombre'])."','".$_POST['porcentaje']."')";
		$add_proyecto = mysql_query($proyecto);
		if($add_proyecto){
			?><script>location.href='index.php?id=proyectos';</script><?
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	
	elseif($_GET['acc']=="addProceso" && isset($_POST['guardar'])){
		$post_calor = $_POST['uso_calor'];
		$post_frio = $_POST['uso_frio'];
		$post_electricidad = $_POST['uso_electricidad'];
		$post_combustible = $_POST['uso_combustible'];
		
		$operacion = "INSERT INTO operaciones (nombre,descripcion,uso_calor,uso_frio,uso_electricidad,uso_combustible) VALUES 
		('".corregir($_POST['nombre'])."','".$_POST['descripcion']."','".$post_calor."','".$post_frio."','".$post_electricidad."','".$post_combustible."')";
		
		$edit_operacion = mysql_query($operacion);
		
		$ver_operacion_agregada = mysql_query("SELECT id_operacion FROM operaciones ORDER BY id_operacion DESC LIMIT 1");
		if(mysql_num_rows($ver_operacion_agregada)>0){
			$vm = mysql_fetch_array($ver_operacion_agregada);
			for($i=0;$i<count($_POST['idrubro']);$i++){
				if(is_numeric($_POST['idrubro'][$i]) && strlen($_POST['consumo_especifico'][$i])>0 && strlen($_POST['producto'][$i])>0){
					$sql_add_act = "INSERT INTO rubros_operaciones (id_rubro,id_operacion,consumo_especifico,orden,fuente,producto) 
					VALUES ('".$_POST['idrubro'][$i]."','".$vm['id_operacion']."','".soloPorcentajes($_POST['consumo_especifico'][$i])."','".$_POST['orden'][$i]."','".corregir($_POST['fuente'][$i])."','".corregir($_POST['producto'][$i])."')"; 
					mysql_query($sql_add_act);
				}
			}
		}
		
		if($edit_operacion){
			if($_POST['guardar']=="Guardar y cerrar"){
				$url = 'index.php?id=procesos';
			}elseif($_POST['guardar']=="Guardar"){
			  	$url = 'index.php?id=procesoedit&proceso='.$vm['id_operacion'];
			}
			echo "<script>location.href='".$url."';</script>";
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	elseif($_GET['acc']=="editProceso" && isset($_POST['guardar'])){
		$post_calor = $_POST['uso_calor'];
		$post_frio = $_POST['uso_frio'];
		$post_electricidad = $_POST['uso_electricidad'];
		$post_combustible = $_POST['uso_combustible'];
		
		$add_Sql = "";
		if(is_numeric($_POST['uso_calor'])){ $add_Sql .= "uso_calor=".$post_calor.","; } else { $add_Sql .= "uso_calor=0,";  }
		if(is_numeric($_POST['uso_frio'])){ $add_Sql .= "uso_frio=".$post_frio.","; } else { $add_Sql .= "uso_frio=0,";  }
		if(is_numeric($_POST['uso_electricidad'])){ $add_Sql .= "uso_electricidad=".$post_electricidad.","; } else { $add_Sql .= "uso_electricidad=0,";  }
		if(is_numeric($_POST['uso_combustible'])){ $add_Sql .= "uso_combustible=".$post_combustible.","; } else { $add_Sql .= "uso_combustible=0,";  }
		
		$operacion = "UPDATE operaciones SET nombre='".corregir($_POST['nombre'])."',
		".$add_Sql."
		descripcion='".$_POST['descripcion']."'
		WHERE id_operacion = ".$_POST['idoperacion']."";

		$edit_operacion = mysql_query($operacion);
		
		for($i=0;$i<count($_POST['idrubro']);$i++){
			if(is_numeric($_POST['idrubro'][$i]) && strlen($_POST['consumo_especifico'][$i])>0 && strlen($_POST['producto'][$i])>0){
				
				/*$ver_Existe_rubro_operacion = mysql_query("
					SELECT id_operacion 
					FROM rubros_operaciones 
					WHERE id_rubro=".$_POST['idrubro'][$i]." 
						AND id_operacion=".$_POST['idoperacion']."
						AND producto='".$_POST['producto'][$i]."'"
						);*/
				$ver_Existe_rubro_operacion = mysql_query("
					SELECT id_operacion 
					FROM rubros_operaciones
					WHERE id_rubro_operacion=".$_POST['idrubrooperacion'][$i]
					);

				if(mysql_num_rows($ver_Existe_rubro_operacion)>0){ //SI YA EXISTE LA OPERACIÓN
					//update
					$sql_add_act = "UPDATE rubros_operaciones 
					SET 
					producto='".corregir($_POST['producto'][$i])."',
					fuente='".corregir($_POST['fuente'][$i])."',
					id_rubro='".$_POST['idrubro'][$i]."', orden='".$_POST['orden'][$i]."',
					consumo_especifico='".soloPorcentajes($_POST['consumo_especifico'][$i])."'
					WHERE id_rubro_operacion=".$_POST['idrubrooperacion'][$i];
					// id_rubro = ".$_POST['idrubro'][$i]." AND id_operacion=".$_POST['idoperacion']."AND producto='".$_POST['producto'][$i]."'";
				} else { // inserto
					$sql_add_act = "INSERT INTO rubros_operaciones (id_rubro,id_operacion,consumo_especifico,orden,fuente,producto) 
					VALUES ('".$_POST['idrubro'][$i]."','".$_POST['idoperacion']."','".soloPorcentajes($_POST['consumo_especifico'][$i])."','".$_POST['orden'][$i]."','".corregir($_POST['fuente'][$i])."','".corregir($_POST['producto'][$i])."')"; 
				}
				$edit_mejora_operacion = mysql_query($sql_add_act);
			}
		}
		if($edit_operacion){
			if($_POST['guardar']=="Guardar y cerrar"){
				$url = 'index.php?id=procesos';
			}elseif($_POST['guardar']=="Guardar"){
			  	$url = 'index.php?id=procesoedit&proceso='.$_POST['idoperacion'];
			}
			echo "<script>location.href='".$url."';</script>";
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	
	elseif($_GET['acc']=="editMejoraRubro" && isset($_POST['guardar'])){
		$mejora = "UPDATE mejoras SET nombre='".corregir($_POST['nombre_mejora'])."',
		descripcion='".$_POST['descripcion']."',
		uso_calor='".$_POST['uso_calor']."',
		uso_frio='".$_POST['uso_frio']."',
		uso_electricidad='".$_POST['uso_electricidad']."',
		uso_combustible='".$_POST['uso_combustible']."'
		WHERE id_mejora = ".$_POST['idmejora']."";
		$edit_mejora = mysql_query($mejora);
		/* evitar duplicidad con SQL:
		ALTER IGNORE TABLE rubros_mejoras
		ADD UNIQUE INDEX idx_rubros_mejoras (id_rubro,id_mejora);
		*/
		
		for($i=0;$i<count($_POST['valor']);$i++){
			if(strlen($_POST['valor'][$i])>0 && is_numeric($_POST['idrubro'][$i]) && strlen($_POST['ahorro_min'][$i])>0 && strlen($_POST['ahorro_max'][$i])>0 && strlen($_POST['pri_min'][$i])>0 && strlen($_POST['pri_max'][$i])>0){
				$ver_Existe_rubro_mejora = mysql_query("SELECT id_mejora FROM rubros_mejoras WHERE id_rubro=".$_POST['idrubro'][$i]." AND id_mejora=".$_POST['idmejora']."");
				
				if(mysql_num_rows($ver_Existe_rubro_mejora)>0){
					//update
					$sql_add_act = "UPDATE rubros_mejoras SET ahorro_min='".soloPorcentajes($_POST['ahorro_min'][$i])."',
					ahorro_max='".soloPorcentajes($_POST['ahorro_max'][$i])."',
					pri_min='".soloPorcentajes($_POST['pri_min'][$i])."',
					pri_max='".soloPorcentajes($_POST['pri_max'][$i])."',
					fuente='".corregir($_POST['fuente'][$i])."',
					valoracion='".$_POST['valor'][$i]."'
					WHERE id_rubro = ".$_POST['idrubro'][$i]." AND id_mejora=".$_POST['idmejora']."";
				} else { // inserto
					$sql_add_act = "INSERT INTO rubros_mejoras (id_rubro,id_mejora,ahorro_min,ahorro_max,pri_min,pri_max,valoracion,fuente) 
					VALUES ('".$_POST['idrubro'][$i]."','".$_POST['idmejora']."','".soloPorcentajes($_POST['ahorro_min'][$i])."','".soloPorcentajes($_POST['ahorro_max'][$i])."',
					'".soloPorcentajes($_POST['pri_min'][$i])."','".soloPorcentajes($_POST['pri_max'][$i])."','".$_POST['valor'][$i]."','".corregir($_POST['fuente'][$i])."')"; 
				}
				//echo $sql_add_act."<br><br>";
				$edit_mejora_rubro = mysql_query($sql_add_act);
			}
		}

		if($edit_mejora){
			if($_POST['guardar']=="Guardar y Cerrar"){
				$url = 'index.php?id=mejoras&gm=2';
			}elseif($_POST['guardar']=="Guardar"){
			  	$url = 'index.php?id=rubromedit&mejora='.$_POST['idmejora'];
			}
			echo "<script>location.href='".$url."';</script>";
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	elseif($_GET['acc']=="deleteRubroMejora" && isset($_GET['idRubroMejora']) && is_numeric($_GET['idRubroMejora'])){
		include_once("../config.php");
		mysql_query("DELETE FROM rubros_mejoras WHERE id_rubro_mejora=".$_GET['idRubroMejora']."");
	}
	elseif($_GET['acc']=="deleteRubroOperacion" && isset($_GET['idRubroOperacion']) && is_numeric($_GET['idRubroOperacion'])){
		include_once("../config.php");
		mysql_query("DELETE FROM rubros_operaciones WHERE id_rubro_operacion=".$_GET['idRubroOperacion']."");
	}
	elseif($_GET['acc']=="addMejoraRubro" && isset($_POST['guardar'])){
		$mejora = "INSERT INTO mejoras (nombre,descripcion,uso_calor,uso_frio,uso_electricidad,uso_combustible) VALUES 
		('".corregir($_POST['nombre_mejora'])."','".$_POST['descripcion']."','".$_POST['uso_calor']."','".$_POST['uso_frio']."','".$_POST['uso_electricidad']."','".$_POST['uso_combustible']."')";
		$add_mejora = mysql_query($mejora);
		
		$ver_mejora_agregada = mysql_query("SELECT id_mejora FROM mejoras ORDER BY id_mejora DESC LIMIT 1");
		if(mysql_num_rows($ver_mejora_agregada)>0){
			$vm = mysql_fetch_array($ver_mejora_agregada);
			for($i=0;$i<count($_POST['valor']);$i++){
				if(strlen($_POST['valor'][$i])>0 && is_numeric($_POST['idrubro'][$i]) && strlen($_POST['ahorro_min'][$i])>0 && strlen($_POST['ahorro_max'][$i])>0 && strlen($_POST['pri_min'][$i])>0 && strlen($_POST['pri_max'][$i])>0){
					$sql_add_act = "INSERT INTO rubros_mejoras (id_rubro,id_mejora,ahorro_min,ahorro_max,pri_min,pri_max,valoracion,fuente) 
						VALUES ('".$_POST['idrubro'][$i]."','".$vm['id_mejora']."','".soloPorcentajes($_POST['ahorro_min'][$i])."','".soloPorcentajes($_POST['ahorro_max'][$i])."',
						'".soloPorcentajes($_POST['pri_min'][$i])."','".soloPorcentajes($_POST['pri_max'][$i])."','".$_POST['valor'][$i]."','".corregir($_POST['fuente'][$i])."')"; 
					mysql_query($sql_add_act);
				}
			}
		}
		
		if($add_mejora){
			if($_POST['guardar']=="Guardar y cerrar"){
				$url = 'index.php?id=mejoras';
			}elseif($_POST['guardar']=="Guardar"){
			  	$url = 'index.php?id=mejorasedit&mejora='.$vm['id_mejora'];
			}
			echo "<script>location.href='".$url."';</script>";
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	
	elseif($_GET['acc']=="editrubro" && isset($_POST['guardar'])){
		$rubro = "UPDATE rubros SET nombre='".corregir($_POST['nombre'])."',
		descripcion='".$_POST['descripcion']."', 	
		consumo_especifico_min='".$_POST['consumo_especifico_min']."', 
		consumo_especifico_max='".$_POST['consumo_especifico_max']."', 	
		consumo_electrico='".$_POST['consumo_electrico']."', 	
		consumo_comb='".$_POST['consumo_comb']."'
		WHERE id_rubro = ".$_POST['idrubro']."";
		$edit = mysql_query($rubro);
		
		if(strlen($_FILES['imagen_publica']['name'])>3){
			$partesx = explode('.',$_FILES['imagen_publica']['name']);
			$numx = count($partesx) - 1;
			$extensionx = $partesx[$numx];
			if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
				cargarfotoRubro($_FILES['imagen_publica'],1,$_POST['idrubro']);
			}
		} 
			
		if(strlen($_FILES['diagrama_flujo']['name'])>3){
			$partesx = explode('.',$_FILES['diagrama_flujo']['name']);
			$numx = count($partesx) - 1;
			$extensionx = $partesx[$numx];
			if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
				cargarDiagramaRubro($_FILES['diagrama_flujo'],$_POST['idrubro']);
			}
		}
		
		if(strlen($_FILES['icono']['name'])>3){
			$partesx = explode('.',$_FILES['icono']['name']);
			$numx = count($partesx) - 1;
			$extensionx = $partesx[$numx];
			if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
				cargarIconoRubro($_FILES['icono'],$_POST['idrubro']);
			}
		}
		
		
		if($edit){
			?><script>location.href='index.php?id=rubros';</script><?
		} else {
			echo "ERROR: No se pudo actualizar la base de datos<br>";
		}
	}
	
	
	elseif($_GET['acc']=="addrubro" && isset($_POST['agregar'])){
		$rubro = "INSERT INTO rubros 
		(nombre,descripcion,consumo_especifico_min,consumo_especifico_max,consumo_electrico,consumo_comb)
		VALUES
		('".$_POST['nombre']."','".$_POST['descripcion']."','".$_POST['consumo_especifico_min']."','".$_POST['consumo_especifico_max']."','".$_POST['consumo_electrico']."','".$_POST['consumo_comb']."')
		";
		$add = mysql_query($rubro);
		if($add){
			$ver_id_rubro = mysql_query("SELECT id_rubro FROM rubros ORDER BY id_rubro DESC LIMIT 1");
			$rb = mysql_fetch_array($ver_id_rubro);
			
			if(strlen($_FILES['imagen_publica']['name'])>3){
				$partesx = explode('.',$_FILES['imagen_publica']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarfotoRubro($_FILES['imagen_publica'],1,$rb['id_rubro']);
				}
			} 
		
		
			if(strlen($_FILES['diagrama_flujo']['name'])>3){
				$partesx = explode('.',$_FILES['diagrama_flujo']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarDiagramaRubro($_FILES['diagrama_flujo'],$rb['id_rubro']);
				}
			}
			
			if(strlen($_FILES['icono']['name'])>3){
				$partesx = explode('.',$_FILES['icono']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarIconoRubro($_FILES['icono'],$rb['id_rubro']);
				}
			}
			?><script>location.href='index.php?id=rubros';</script><?
		}
		
	}
	
	elseif($_GET['acc']=="delrubro" && isset($_GET['rubro']) && is_numeric($_GET['rubro'])){
		/*$ver_anteriores = mysql_query("SELECT id_img FROM imagenes_rubros WHERE id_rubro=".$_GET['rubro']."");
		while($imgant = mysql_fetch_array($ver_anteriores)){
			eliminar_foto_rubro($imgant['id_img'],$_GET['rubro']);
		}
		eliminar_diagrama_rubro($_GET['rubro']);*/
		mysql_query("UPDATE rubros SET activo=0 WHERE id_rubro=".$_GET['rubro']."");
		?><script>location.href='index.php?id=rubros';</script><?
	}
	
	elseif($_GET['acc']=="activarRubro" && isset($_GET['rubro']) && is_numeric($_GET['rubro'])){
		mysql_query("UPDATE rubros SET activo=1 WHERE id_rubro=".$_GET['rubro']."");
		?><script>location.href='index.php?id=rubros';</script><?
	}
	
	
	elseif($_GET['acc']=="suspendMejRubro" && isset($_GET['mejora']) && $_GET['mejora']!=""){
		mysql_query("UPDATE mejoras SET activo=0 WHERE id_mejora=".$_GET['mejora']."");
		?><script>location.href='index.php?id=mejoras'</script><?
	} elseif($_GET['acc']=="unsuspendMejRubro" && isset($_GET['mejora']) && $_GET['mejora']!=""){
		mysql_query("UPDATE mejoras SET activo=1 WHERE id_mejora=".$_GET['mejora']."");
		?><script>location.href='index.php?id=mejoras'</script><?	
	}
	
	
	
	
	elseif($_GET['acc']=="borrarevento" && isset($_GET['evento']) && is_numeric($_GET['evento'])){
		mysql_query("DELETE FROM eventos WHERE id_evento=".$_GET['evento']."");
		mysql_query("DELETE FROM eventos_usuarios WHERE id_evento=".$_GET['evento']."");
		?><script>location.href='index.php?id=eventos&pag=<?=$_GET['pag']?>';</script><?
	}
	elseif($_GET['acc']=="addevento" && isset($_POST['agregar'])){
		$arr_fecha_t = explode("-",$_POST['fecha']);
		$date_t = $arr_fecha_t[2]."-".$arr_fecha_t[1]."-".$arr_fecha_t[0]." ".$_POST['hora'].":00";
		$evento = "INSERT INTO eventos 
		(nombre,fecha,descripcion,cupos_max,localizacion,pagina_web,organizador,costo)
		VALUES
		('".corregir($_POST['nombre'])."','".$date_t."','".$_POST['descripcion']."','".$_POST['cupos_max']."','".corregir($_POST['localizacion'])."','".$_POST['pagina_web']."','".corregir($_POST['organizador'])."','".str_replace(".","",$_POST['costo'])."')
		";
		$add = mysql_query($evento);
		if($add){
			$ver_id_evento = mysql_query("SELECT id_evento FROM eventos ORDER BY id_evento DESC LIMIT 1");
			$rb = mysql_fetch_array($ver_id_evento);
			
			if(strlen($_FILES['formato']['name'])>3){
				$partesx = explode('.',$_FILES['formato']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarfotoEvento($_FILES['formato'],$rb['id_evento']);
				}
			} 
			?><script>location.href='index.php?id=eventos';</script><?
		}
	}
	
	
	elseif($_GET['acc']=="editevento" && isset($_POST['guardar'])){
		
		$arr_fecha_t = explode("-",$_POST['fecha']);
		$date_t = $arr_fecha_t[2]."-".$arr_fecha_t[1]."-".$arr_fecha_t[0]." ".$_POST['hora'].":00";
		//echo $date_t;
		//die();
		$evento = "UPDATE eventos SET 
		nombre='".corregir($_POST['nombre'])."',
		fecha='".$date_t."',
		descripcion='".$_POST['descripcion']."',
		cupos_max='".$_POST['cupos_max']."',
		localizacion='".corregir($_POST['localizacion'])."',
		pagina_web='".$_POST['pagina_web']."',
		organizador='".corregir($_POST['organizador'])."',
		costo='".str_replace(".","",$_POST['costo'])."'
		WHERE id_evento=".$_POST['id_evento']."
		";
		$add = mysql_query($evento);
		if($add){
			
			if(strlen($_FILES['formato']['name'])>3){
				$partesx = explode('.',$_FILES['formato']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarfotoEvento($_FILES['formato'],$_POST['id_evento']);
				}
			} 
			?><script>location.href='index.php?id=eventos';</script><?
		}
	}
	
	
	
	
	
	
	elseif($_GET['acc']=="delproceso" && isset($_GET['proceso']) && $_GET['proceso']!=""){
		mysql_query("UPDATE operaciones SET activo=0 WHERE id_operacion=".$_GET['proceso']."");
		?><script>location.href='index.php?id=procesos&pag=<?=$_GET['pag']?>#op<?=$_GET['proceso']?>'</script><?
	} elseif($_GET['acc']=="activarProceso" && isset($_GET['proceso']) && $_GET['proceso']!=""){
		mysql_query("UPDATE operaciones SET activo=1 WHERE id_operacion=".$_GET['proceso']."");
		?><script>location.href='index.php?id=procesos&pag=<?=$_GET['pag']?>#op<?=$_GET['proceso']?>'</script><?	
	}
	elseif($_GET['acc']=="borrarProceso" && isset($_GET['proceso']) && $_GET['proceso']!=""){
		mysql_query("DELETE FROM operaciones WHERE id_operacion=".$_GET['proceso']."");
		mysql_query("DELETE FROM rubros_operaciones WHERE id_operacion=".$_GET['proceso']."");
		?><script>location.href='index.php?id=procesos&pag=<?=$_GET['pag']?>'</script><?
	}
	elseif($_GET['acc']=="updatePhotos" && isset($_POST['guardar']) && isset($_POST['cat']) && is_numeric($_POST['cat'])){
		$desc = $_POST['desc'];
		$id_img = $_POST['id_img'];
		for($i=0;$i<count($id_img);$i++){
				$descripcion = str_replace("\n","<br>",$desc[$i]);
				mysql_query("UPDATE imagenes SET descripcion='".corregir($descripcion)."' WHERE id_img=".$id_img[$i]."");
		}
		
		?><script>location.href='index.php?id=verfotos&categoria=<?=$_POST['cat']?>';</script><?
	}
	

	
	
	elseif($_GET['acc']=="uploadPhoto" && isset($_GET['categoria']) && $_GET['categoria']!="" && $_GET['categoria']!=NULL  && is_numeric($_GET['categoria'])){
		if(isset($_FILES["myfile"])){
			$ret = array();
			$error = $_FILES["myfile"]["error"];
			if(!is_array($_FILES["myfile"]['name'])){ //single file
				cargarfotoProducto($_FILES["myfile"],$_GET['categoria']);
			} else {
				$fileCount = count($_FILES["myfile"]['name']);
				for($i=0; $i < $fileCount; $i++)
				{
					cargarfotoProducto($_FILES["myfile"][$i],$_GET['categoria']);
				}
			}
			echo json_encode($ret);
		}
	}
	
	elseif($_GET['acc']=="suspend" && isset($_GET['user']) && $_GET['user']!="" && $_GET['user']!=NULL && is_numeric($_GET['user'])){
		mysql_query("UPDATE usuarios SET activo=0 WHERE id_user=".$_GET['user']."");
		?><script>location.href='index.php?id=users&pag=<?=$_GET['pag']?>'</script><?
		
	} elseif($_GET['acc']=="unsuspend" && isset($_GET['user']) && $_GET['user']!="" && $_GET['user']!=NULL && is_numeric($_GET['user'])){
		mysql_query("UPDATE usuarios SET activo=1 WHERE id_user=".$_GET['user']."");
		?><script>location.href='index.php?id=users&pag=<?=$_GET['pag']?>'</script><?
		
	} 
	elseif($_GET['acc']=='delpicture' && is_numeric($_GET['photo']) && strlen($_GET['photo'])>0){
		$idprod = eliminar_foto($_GET['photo']);
		if(is_numeric($idprod)){
			mysql_query("DELETE FROM comentarios WHERE id_img=".$_GET['photo']."");
			mysql_query("DELETE FROM votos WHERE id_img=".$_GET['photo']."");
			if(isset($_GET['user']) && is_numeric($_GET['user'])){
				?><script>location.href='index.php?id=userficha&user=<?=$_GET['user']?>#pictures'</script><?
			} else {
				?><script>location.href='index.php?id=fotos&pag=<?=$_GET['pag']?>'</script><?
			}
		} else {
			?><script>location.href='index.php'</script><?
		}
	}
	elseif($_GET['acc']=="userlogin" && isset($_GET['user']) && $_GET['user']!="" && $_GET['user']!=NULL && is_numeric($_GET['user'])){
		@session_start();
		@include("../config.php");
		
		$result3 = mysql_query("select id_user,email,tipo from usuarios where id_user=".$_GET['user']." AND activo=1 LIMIT 1");
		$row3 = mysql_fetch_array($result3);
		$_SESSION['iduser'] = $row3['id_user'];
		$_SESSION['email'] = $row3['email'];
		$_SESSION['tipo'] = $row3['tipo'];
		
		$img = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$_SESSION['iduser']." and principal=1 LIMIT 1");
		$pic = mysql_fetch_array($img);
		if(strlen($pic['imagen'])>10){
			$_SESSION['profilepic'] = "profiles/".$pic['imagen'];
		} else {
			$_SESSION['profilepic'] = "img/unknown.png";	
		}
		?>
		<SCRIPT LANGUAGE="javascript">location.href = "../index.php?id=profile&user=<?=$_GET['user']?>";</SCRIPT>
		<?
	}

	
}
?>