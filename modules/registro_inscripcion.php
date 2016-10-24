<?
if(isset($_POST['registrar'])){
	include_once("acciones.php");
	
	if($_POST['inscripcion']){ //$nombre_empresa,$nombre_contacto,$email_contacto,$telefono_contacto,$cargo,$tipo_user,$void=false
		$registro_exitoso = registro($_POST['nombre_empresa'],$_POST['nombre'],$_POST['email'],"","",$_POST['tipo'],true);
	}
	else{
		$errores = [];
		if(strlen($_POST['nombre_empresa'])<1){
			$errores[] = "Ingrese nombre de su empresa.";
		}
		/*if(strlen($cargo)<1){
			$errores[] = "Ingrese su cargo.";
		}*/
		if(strlen($_POST['nombre'])<1){
			$errores[] = "Ingrese nombre de contacto.";
		}
		if(strlen($_POST['email'])<1){
			$errores[] = "Ingrese email de contacto.";
		}
		$ver_Existe_evento = mysql_query("SELECT cupos_max FROM eventos WHERE id_evento=".$_GET['evento']." AND NOW()<=fecha LIMIT 1");
		$cupos_total = mysql_result($ver_Existe_evento,0);
		$ver_si_hay_cupos_sql = mysql_query("SELECT id_evento FROM eventos_usuarios WHERE id_evento = ".$_GET['evento']."");
		$ver_invitados = mysql_query("SELECT nombre FROM invitados_eventos WHERE id_evento = ".$not['id_evento']."");
		$cupos_usados = mysql_num_rows($ver_si_hay_cupos_sql) + mysql_num_rows($ver_invitados);
		if(($cupos_total-$cupos_usados)<=0){
				$errores[] = "No quedan cupos disponibles.";
		}
		/*if(strlen($telefono_contacto)<1){
			$errores[] = "Ingrese tel&eacute;fono de contacto.";
		}*/
		if(count($errores)>0){
			?>
			El sistema no puede proceder con su registro.<br /><br />
			<?
			for($i=0;$i<count($errores);$i++){
				echo $errores[$i]."<br />";	
			}
		}

		if(count($errores)==0){

			$sql_registro_invitado = mysql_query("INSERT INTO invitados_eventos (id_evento,empresa,nombre,email) VALUES ('".$_POST['id_evento']."','".$_POST['nombre_empresa']."','".$_POST['nombre']."','".$_POST['email']."')");
			if($sql_registro_invitado){
				$dominio_mail = $_SERVER['HTTP_HOST'];//"aiguasol.com";
				$URL_DIRex = $_SERVER['SERVER_NAME'];
				$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

				$evento_query = mysql_query("Select nombre,fecha from eventos where id_evento=".$_POST['id_evento']."");
				$evento = mysql_fetch_array($evento_query);				

				$URL_DIR = dirname($url);
				//$headers = "Content-type: text/html; charset=utf-8\r\n";
				$headers ="Reply-To: Equipo de agrificiente <iwunderlich@acee.camchal.cl>\r\n" ;
				$headers .="Return-Path: Equipo de agrificiente <iwunderlich@acee.camchal.cl>\r\n" ;
				$headers .= "From: Equipo de agrificiente <iwunderlich@acee.camchal.cl> \r\n";//.$dominio_mail;
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .="Sender: Un mensaje del Equipo de agrificiente <iwunderlich@acee.camchal.cl>\r\n" ;
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .='X-Mailer: PHP/' . phpversion(). "\r\n";
				
				$msg = "<br>
				Estimad@ ".$_POST['nombre'].",<br><br>
				Tu inscripci&oacute;n al evento: ".trim($evento["nombre"])." para el día ".$evento["fecha"]." Ha sido exitosa.<br>
				<br>
				¡No te olvides de asistir!";

				//echo $msg;
				//die();

				$sent_mail = mail(trim($_POST['email']), "Inscripción correcta al evento", $msg."<br><br>Saludos,<br>Equipo de Smart Energy Concepts.", $headers);
				
				?><script>location.href='evento.php?evento=<?=$_POST['id_evento']?>&register=ok'</script><?
			}
			else{
				echo "Ha ocurrido un error con nuestra base de datos, por favor inténtelo más tarde.";
			}
		}
	}

	
	//echo $registro_exitoso;
	//die();

	if($registro_exitoso==1){ //si el registro anduvo bien, iniciamos sesión.
		
		//$nick2 = funcion(limpiar2(trim($_POST["user"])));
		//$clave2 = funcion(md5($_POST['pass']));
		
		$result3 = mysql_query("select id_user,clave,email,tipo from usuarios where email='".$_POST['email']."' AND activo=1 LIMIT 1");
		if(mysql_num_rows($result3)>0){
				$row = mysql_fetch_array($result3);
				
					
				if(true){ //porque ya se creó el usuario
			
					$_SESSION['iduser'] = $row['id_user'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['tipo'] = $row['tipo']; /// empresa o proveedor
					
					
					$img = @mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$_SESSION['iduser']." and principal=1 LIMIT 1");
					$pic = @mysql_fetch_array($img);
					if(strlen($pic['imagen'])>10){
						$_SESSION['profilepic'] = "profiles/".$pic['imagen'];
					} else {
						$_SESSION['profilepic'] = "img/unknown.png";	
					}
					if($_SESSION['tipo']==2){
						$ver_mejoras_marcadas = mysql_query("SELECT id_mejora FROM mejoras_proveedores WHERE id_proveedor=".$_SESSION['iduser']." LIMIT 1");
						if(mysql_num_rows($ver_mejoras_marcadas)>0){ } else {
							$_SESSION['sinmejoras'] = "NO";	
						}
					}
					
					/* SET COOKIES ###########################################################################*/
					if(isset($_POST['noclose']) && $_POST['noclose']=="true"){
						$timekey = 3600*24*365*2; // cookie de 2 años
						$key = md5($_SESSION['iduser'].$_SESSION['email']);
						$keyuser = $_SESSION['iduser'];
						$keymail = $_SESSION['email'];
						$keydb = mysql_query("SELECT id_user FROM cookies WHERE id_user=".$_SESSION['iduser']." LIMIT 1");
						if(mysql_num_rows($keydb)>0){
							mysql_query("UPDATE cookies SET email='".$keymail."', `ckey`='".$key."' WHERE id_user=".$_SESSION['iduser']."");	
							//echo "update";
							setcookie("userkey", $key, time()+$timekey, "/");
							setcookie("idkey", $keyuser, time()+$timekey, "/");
						} else {
							$ldbinsertcookie = mysql_query("INSERT INTO cookies (email,`ckey`,id_user) VALUES ('".$keymail."','".$key."','".$_SESSION['iduser']."')");	
							if($ldbinsertcookie){
								setcookie("userkey", $key, time()+$timekey, "/");
								setcookie("idkey", $keyuser, time()+$timekey, "/");
							} else {
								//echo "cookieerror";	
							}
						}
					} else {
						mysql_query("DELETE FROM cookies WHERE id_user=".$_SESSION['iduser']." AND email='".$_SESSION['email']."'");	
					}
					/* SET COOKIES ###########################################################################*/

					//elseif($_GET['acc']=='asistirEvento' && isset($_GET['evento']) && is_numeric($_GET['evento']))
					?>
					<script>location.href="acciones.php?acc=asistirEvento&evento=<?=$_POST['id_evento']?>";</script>
					<?
					//si se inició la sesión	
					
				} else {
					//CLAVE INCORRECTA RARO
				}
		} else {	
			//USUARIO NO EXISTE
		}

	}

}
?>