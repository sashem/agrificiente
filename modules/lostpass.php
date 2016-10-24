

<h1>Recuperar Contrase&ntilde;a</h1>

<?
$dominio_mail = "lala.com";
define('lostpass_no_clave_pedida',"El usuario no ha pedido un cambio de clave.", true);
define('lostpass_estimado',"Hola ", true);
define('lostpass_new_pass',"Tu nueva contrase&ntilde;a es", true);
define('lostpass_exito_pass01',"Tu contrase&ntilde;a ha sido cambiada con &eacute;xito", true);
define('lostpass_exito_pass02',"Recibir&aacute;s un correo con la informaci&oacute;n de la nueva contrase&ntilde;a.", true);
define('lostpass_exito_pass03',"Ir a mi cuenta", true);
define('lostpass_pass_modify',"Contrase&ntilde;a modificada", true);
define('lostpass_solicitud',"Has solicitado un cambio de contrase&ntilde;a y para ello debes generar una nueva.\n\nHaz clic en el siguiente enlace para cambiar tu contrase&ntilde;a", true);
define('lostpass_sol_pass',"Solicitud de clave", true);
define('lostpass_sent',"Tu nueva contrase&ntilde;a ha sido enviada", true);
define('lostpass_no_exists_client',"No existe el usuario", true);
define('lostpass_insert_email',"Ingresa tu e-mail para enviarte la solicitud de cambio de contrase&ntilde;a", true);
define('lostpass_solicitud_button',"Solicitar contrase&ntilde;a", true);
define('lostpass_accountemail',"E-Mail", true);
define('lostpass_goback',"Volver Atr&aacute;s", true);

if(isset($_GET['ac']) && $_GET['ac']=="cambiar"){

	$infoquery = mysql_query("SELECT * FROM users WHERE id_user=".$_GET['idx']." and pass='".$_GET['hash']."'");
	$info = mysql_fetch_array($infoquery);
	if(mysql_num_rows($infoquery)==0){
 		echo "<br><br><strong>Error:</strong> ".lostpass_no_clave_pedida."<br><br><br><br><br><br>";
 	} else {
		$randpass = rand(0000000,9999999);
		$randpassmd5=md5($randpass);
		mysql_query("UPDATE users SET password='$randpassmd5' WHERE id_user=".$_GET['idx']."");
		//$headers = 'From: no-reply@'.str_replace('www.','',$_SERVER['SERVER_NAME']);
		$URL_DIRex = $_SERVER['SERVER_NAME'];
		$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$URL_DIR = dirname($url);
		$headers = "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: noreply@".$dominio_mail;
			
		$mensaje = lostpass_estimado." ".($info['nombre']).",<br><br>".lostpass_new_pass.": ".$randpass."<br><br>Saludos,<br>Equipo Camchal";
		echo "<br>".lostpass_exito_pass01.".<br>".lostpass_exito_pass02."<br><br><a href='index.php?id=login'><strong>".lostpass_exito_pass03."</strong></a>";
		mail($info['email'], "".lostpass_pass_modify."", $mensaje, $headers);

	}
} else {
	if(isset($_POST['emailcliente']) && isset($_POST['recordar']) && $_POST['emailcliente']!=NULL){

		$infoquery = mysql_query("SELECT * FROM users WHERE email='".$_POST['emailcliente']."'");
		$info = mysql_fetch_array($infoquery);
		
		if(mysql_num_rows($infoquery) != 0){

			$msg = "<br>".lostpass_estimado." ".($info['nombre']).",<br><br>".lostpass_solicitud.":<br><br>";
			
			$URL_DIRex = $_SERVER['SERVER_NAME'];
			$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$URL_DIR = dirname($url);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: noreply@".$dominio_mail;
			$mensaje = $URL_DIR."/index.php?id=lostpass&idx=".$info['id_user']."&hash=".$info['password']."&ac=cambiar";
			
			mail($info['email'], "".lostpass_sol_pass."", $msg.$mensaje."<br><br>Saludos,<br>Equipo Camchal", $headers);
			echo lostpass_sent.".<br><br><br><a href='index.php?id=login'><i>Iniciar sesi&oacute;n</i></a><br><br>";

		} else {
			echo "<br><strong>Error:</strong> ".lostpass_no_exists_client."";
		}
		
	} else {

?>


<form action="index.php?id=lostpass" method="post" name="form" id="form">
<div class="user-form login_form">
        <div><?=lostpass_insert_email?><br /><br /></div>
        <div class="form-group">
            <label><?=lostpass_accountemail?></label>
            <input name="emailcliente" type="email" class="form-control" size="30" required autofocus placeholder="Ingrese su email">
        </div>
       	<div class="form-group" id="buttons"><br />
        	<input class="boton" name="recordar" type="submit" value="<?=lostpass_solicitud_button?>">
        </div>
    </div>
        
	
</form>

<?
	}
}
?>
