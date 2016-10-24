<?
//include("config.php");

function randomPassword() {
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$pass = array();
	$alphaLength = strlen($alphabet) - 1;
	for ($i = 0; $i < 8; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return implode($pass);
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

function registro($nombre_empresa,$nombre_contacto,$email_contacto,$telefono_contacto,$cargo,$tipo_user,$void=false){
	echo "<br><br>";
	if($_POST['origen']=="evento"){
		$url_ir_a = $_POST['refer'];	
	} else {
		$url_ir_a = "index.php";
	}

	$errores = array();
	if(strlen($nombre_empresa)<1){
		$errores[] = "Ingrese nombre de su empresa.";
	}
	/*if(strlen($cargo)<1){
		$errores[] = "Ingrese su cargo.";
	}*/
	if(strlen($nombre_contacto)<1){
		$errores[] = "Ingrese nombre de contacto.";
	}
	if(strlen($email_contacto)<1){
		$errores[] = "Ingrese email de contacto.";
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
		
		?><br /><br /><span id="buttons"><a href="index.php">Volver</a></span><?
	} else {
		$claveus = randomPassword();
		$clavemd5 = md5($claveus);
		
		if($tipo_user=='proveedor'){
			$tipo_user = 2;
		} else { // productor
			$tipo_user = 1;
		}
		//echo $claveus."- md5: ".$clavemd5;
		
		//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);	

		//echo $sent_mail;
		


		$sql_reg = "INSERT INTO usuarios
		(email,clave,nombre,telefono,cargo,tipo) VALUES
		('".$email_contacto."','".$clavemd5."','".corregir($nombre_contacto)."','".$telefono_contacto."','".$cargo."','".$tipo_user."')
		";

		$buscar_duplicado = 'SELECT nombre FROM usuarios WHERE email="'.$email_contacto.'"';
		//echo mysql_num_rows(mysql_query($buscar_duplicado));

		if(mysql_num_rows(mysql_query($buscar_duplicado))>0){
			echo "El mail que está intentando registrar, ya se encuentra utilizado. <br>
				Si cree que existe algún error en nuestro registro, por favor comuníquese con la administración.";
			?><br /><br /><br /><br /><span id="buttons"><a href="<?=$url_ir_a?>">Volver</a></span><?
			die();	
		}

		$buscar_empresa_duplicada = "SELECT usuarios.id_user, usuarios.email from usuarios, empresas WHERE usuarios.id_user = empresas.id_user AND lower(empresas.nombre) = '".strtolower($nombre_empresa)."'";

		$buscar_proveedor_duplicado = "SELECT usuarios.id_user, usuarios.email from usuarios, proveedores WHERE usuarios.id_user = proveedores.id_user AND lower(proveedores.nombre) = '".strtolower($nombre_empresa)."'";
		//echo $buscar_empresa_duplicada;
		
		$empresa_duplicada = mysql_query($buscar_empresa_duplicada);
		if(mysql_num_rows($empresa_duplicada)>0){
			$empresa_duplicada = mysql_fetch_array($empresa_duplicada);
			echo "La empresa que está intentando registrar, ya est&aacute; registrada al correo ".$empresa_duplicada['email']." <br>
				Si cree que existe algún error en nuestro registro, por favor comuníquese con la administración.";
			?><br /><br /><br /><br /><span id="buttons"><a href="<?=$url_ir_a?>">Volver</a></span><?
			die();	
		}


		$proveedor_duplicado = mysql_query($buscar_proveedor_duplicado); 
		if(mysql_num_rows($proveedor_duplicado)>0){
			$proveedor_duplicado = mysql_fetch_array($proveedor_duplicado);
			echo "La empresa que está intentando registrar, ya est&aacute; registrada al correo ".$proveedor_duplicado['email']." <br>
				Si cree que existe algún error en nuestro registro, por favor comuníquese con la administración.";
			?><br /><br /><br /><br /><span id="buttons"><a href="<?=$url_ir_a?>">Volver</a></span><?
			die();	
		}


		//die();

		$insertar = mysql_query($sql_reg);
		if($insertar){
			$veruser = mysql_query("SELECT id_user FROM usuarios WHERE email='".trim($email_contacto)."' LIMIT 1");
			//echo "SELECT id_user FROM usuarios WHERE email=".trim($email_contacto)." LIMIT 1";


			if(mysql_num_rows($veruser)>0){
			
				$dominio_mail = $_SERVER['HTTP_HOST'];//"aiguasol.com";
				$URL_DIRex = $_SERVER['SERVER_NAME'];
				$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

				$URL_DIR = dirname($url);
				//$headers = "Content-type: text/html; charset=utf-8\r\n";
				$headers ="Reply-To: Equipo de agrificiente <iwunderlich@acee.camchal.cl>\r\n" ;
				$headers .="Return-Path: Equipo de agrificiente <iwunderlich@acee.camchal.cl>\r\n" ;
				$headers .= "From: Equipo de agrificiente <iwunderlich@acee.camchal.cl> \r\n";//.$dominio_mail;
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .="Sender: Un mensaje del Equipo de agrificiente <iwunderlich@acee.camchal.cl>\r\n" ;
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .='X-Mailer: PHP/' . phpversion(). "\r\n";
				
				
				$msg = "
				<br>Bienvenid@ ".corregir($nombre_contacto).",<br><br>
				Tu registro en la plataforma de Agrificiente ha sido exitoso,<br><br>
				por favor, ingresa a la plataforma de agrificiente mediante los siguientes datos:<br><br>
				Usuario/Email: ".trim($email_contacto)."<br>
				Contrase&ntilde;a: ".$claveus."
				";

				$sent_mail = mail(trim($email_contacto), "Registro exitoso, datos de ingreso", $msg."<br><br>Saludos,<br>Equipo de Smart Energy Concepts.", $headers);

				//echo $msg;
			
				$user = mysql_fetch_array($veruser);
				if($tipo_user==2){
					$sql_registro_e = "INSERT INTO proveedores (id_user,nombre,email) VALUES ('".$user['id_user']."','".$nombre_empresa."','".$email_contacto."')";
					
				} else { // productor
					$sql_registro_e = "INSERT INTO empresas (id_user,nombre,email) VALUES ('".$user['id_user']."','".$nombre_empresa."','".$email_contacto."')";
				}
				//echo $sql_registro_e;
				$insert_empresa = mysql_query($sql_registro_e);
				
				if(!$void){
					if($insert_empresa){
						
						echo "
						Felicitaciones, su registro ha sido completado.<br><br> 
						Hemos enviado informaci&oacute;n de acceso a <strong>".$email_contacto."</strong>.<br>
						Si no llega el mensaje a su bandeja de entrada en los próximos minutos,<br>
						<strong>Por favor revise su bandeja de SPAM.</strong>
						";
						
						?><br /><br /><br /><br /><span id="buttons"><a href="<?=$url_ir_a?>">Iniciar sesi&oacute;n</a></span><?


					} else {
						echo "Su usuario ha sido registrado, pero ocurri&oacute; un problema al registrar la empresa.<br><br>
						Cont&aacute;ctese con el administrador para revisar el problema.";
						?><br /><br /><br /><br /><span id="buttons"><a href="<?=$url_ir_a?>">Volver al inicio</a></span><?	
					}
				}else{
					if($insert_empresa){
						return 1;
					}else{
						return 0;
					}
				}

				// enviar email
			} else {
				echo "Su usuario ha sido registrado, pero ocurri&oacute; un problema al registrar la empresa.<br><br>
				Cont&aacute;ctese con el administrador para revisar el problema.";
				?><br /><br /><br /><br /><span id="buttons"><a href="<?=$url_ir_a?>">Volver al inicio</a></span><?	
			}
		} else {
			echo "Error al registrar.";
			?><br /><br /><br /><br /><span id="buttons"><a href="<?=$url_ir_a?>">Volver a registrarse</a></span><?	
		}
		echo "<br /><br />";
	}
}


function cargarPicBPractica($file_imagen,$idpractica){
	session_start();
	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "buenas_practicas/";
	$size_max = 36700000;
	$seedx = str_replace("-","",rand(00000,99999));
	$archivo_name = "bp".date('YmdHis')."_".$seedx.".".$extension;

	eliminar_pic_bPractica($idpractica);
	if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
		if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
			$fecha = date("Y-m-d H:i:s");
			$SQL_ADDFOTO = "UPDATE buenas_practicas SET img_folder='".$archivo_name."' WHERE id_buena_practica=".$idpractica."";
			mysql_query($SQL_ADDFOTO);
		}
	} else {
		echo 'Error: Ha superado el l&iacute;mite de peso por foto';
	}
}

function cargarCatalogo($file_imagen,$idcatalogo){
	session_start();
	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "catalogos/";
	$size_max = 36700000;
	$seedx = str_replace("-","",rand(000,999));
	$archivo_name = "cat".date('YmdHis')."_".$seedx.".".$extension;
	eliminarCatalogo($idcatalogo);
	if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
		$SQL_ADDA = "UPDATE catalogos SET archivo='".$archivo_name."' WHERE id_catalogo=".$idcatalogo."";
		mysql_query($SQL_ADDA);
	} else {
		echo 'Error: No se pudo cargar el archivo';
	}
}

function eliminarCatalogo($idcatalogo){
	session_start(); 
	$verify = mysql_query("SELECT archivo as imagen FROM catalogos WHERE id_catalogo=".$idcatalogo."");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		$archivo1 = $rr['imagen'];
		if(strlen($archivo1)>1){
			$carpeta = "catalogos/";
			if(file_exists($carpeta.$archivo1)){
				unlink($carpeta.$archivo1);
			}
		}
		$sql_del_arc = "UPDATE catalogos SET archivo='' WHERE id_catalogo=".$idpractica."";
		mysql_query($sql_del_arc);
	}
}

function eliminarProyecto($idproyecto){
	session_start(); 
	$verify = mysql_query("SELECT img_folder as imagen FROM proyectos WHERE id_proyecto=".$idproyecto."");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		$archivo1 = $rr['imagen'];
		if(strlen($archivo1)>1){
			$carpeta = "proyectos/";
			if(file_exists($carpeta.$archivo1)){
				unlink($carpeta.$archivo1);
			}
		}
		$sql_del_arc = "UPDATE proyectos SET img_folder='' WHERE id_proyecto=".$idproyecto."";
		mysql_query($sql_del_arc);
	}
}

function eliminar_pic_bPractica($idpractica){
	session_start(); 
	$verify = mysql_query("SELECT img_folder as imagen FROM buenas_practicas WHERE id_buena_practica=".$idpractica."");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		$archivo1 = $rr['imagen'];
		if(strlen($archivo1)>1){
			$carpeta = "buenas_practicas/";
			if(file_exists($carpeta.$archivo1)){
				unlink($carpeta.$archivo1);
			}
		}
		$sql_del_img = "UPDATE buenas_practicas SET img_folder='' WHERE id_buena_practica=".$idpractica."";
		mysql_query($sql_del_img);
	}
}
	
function cargarPicProyecto($file_imagen,$idproyecto){
	session_start();
	$image = $file_imagen['name'];
	$partes = explode('.',$file_imagen['name']) ;
	$num = count($partes) - 1 ;
	$extension = $partes[$num] ;
	$carpeta_index = "proyectos/";
	$size_max = 36700000;
	$seedx = str_replace("-","",rand(00000,99999));
	$archivo_name = "pr".date('YmdHis')."_".$seedx.".".$extension;
	eliminar_pic_proyecto($idproyecto);
	if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
		if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
			$SQL_ADDFOTO = "UPDATE proyectos SET img_folder='".$archivo_name."' WHERE id_proyecto=".$idproyecto."";
			mysql_query($SQL_ADDFOTO);
		}
	} else {
		echo 'Error: Ha superado el l&iacute;mite de peso por foto';
	}
}

function eliminar_pic_proyecto($idproyecto){
	session_start(); 
	$verify = mysql_query("SELECT img_folder as imagen FROM proyectos WHERE id_proyecto=".$idproyecto."");
	if(mysql_num_rows($verify)>0){
		$rr = mysql_fetch_array($verify);
		$archivo1 = $rr['imagen'];
		if(strlen($archivo1)>1){
			$carpeta = "proyectos/";
			if(file_exists($carpeta.$archivo1)){
				unlink($carpeta.$archivo1);
			}
		}
		$sql_del_img = "UPDATE proyectos SET img_folder='' WHERE id_proyecto=".$idproyecto."";
		mysql_query($sql_del_img);
	}
}

		
if(isset($_GET['acc']) && strlen(trim($_GET['acc']))>0){
	session_start();
	@include_once("config.php");
	
	//if(isset($_SESSION['iduser'])){
	
		if($_GET['acc']=='fichaOperacion' && isset($_GET['rubro']) && is_numeric($_GET['rubro']) && isset($_GET['operacion']) && is_numeric($_GET['operacion'])){
			
			$operaciones_ficha = mysql_query("SELECT operaciones.*,rubros_operaciones.consumo_especifico as consumo_especifico FROM operaciones,rubros_operaciones WHERE rubros_operaciones.id_operacion = operaciones.id_operacion AND rubros_operaciones.id_rubro=".$_GET['rubro']." AND operaciones.id_operacion=".$_GET['operacion']." LIMIT 1");
			if(mysql_num_rows($operaciones_ficha)>0){
				while($op = mysql_fetch_array($operaciones_ficha)){
					?>
	                <h3><?=$op['nombre']?></h3>
	                <?if(is_numeric($op['consumo_especifico'])&&$op['consumo_especifico']>0){?> <strong>Consumo: <?=$op['consumo_especifico'];?> kWh/l.</strong> <? } ?>
					<?=$op['descripcion']?>
	                <br /><br />
	                
	                <? if($op['uso_calor']==1 || $op['uso_frio']==1 || $op['uso_electricidad']==1 || $op['uso_combustible']==1){ ?>
	                    <h3>Usos</h3>
	                    <? if($op['uso_calor']==1){ ?><img src="img/tr.gif" class="icon-37" /><? } ?>
	                    <? if($op['uso_frio']==1){ ?><img src="img/tr.gif" class="icon-36" /><? } ?>
	                    <? if($op['uso_electricidad']==1){ ?><img src="img/tr.gif" class="icon-26" /><? } ?>
	                    <? if($op['uso_combustible']==1){ ?><img src="img/tr.gif" class="icon-25" /><? } ?>
	                   <br /><br /> 
					<?
					}
					?>
	                
	                <h3>Mejoras de consumo</h3>
	                <?
					$agregar_fuente = ""; $agregar_fuente2 = ""; $agregar_fuente3 = ""; $agregar_fuente4 = "";
					if($op['uso_calor']==1){ $agregar_fuente = "uso_calor=1 OR "; } 
	                if($op['uso_frio']==1){ $agregar_fuente2 = "uso_frio=1 OR "; } 
	                if($op['uso_electricidad']==1){ $agregar_fuente3 = "uso_electricidad=1 OR "; } 
	                if($op['uso_combustible']==1){ $agregar_fuente4 = "uso_combustible=1 OR "; } 
	                 /*   
					$consulta_calores = "SELECT rubros_operaciones.id_rubro,rubros_mejoras.id_rubro_mejora,operaciones.id_operacion ,mejoras.id_mejora,mejoras.nombre,
					operaciones.uso_calor,operaciones.uso_frio,operaciones.uso_electricidad,operaciones.uso_combustible
					FROM rubros_operaciones,operaciones,mejoras,rubros_mejoras
					WHERE rubros_operaciones.id_operacion=operaciones.id_operacion
					AND rubros_mejoras.id_rubro=rubros_operaciones.id_rubro
					AND mejoras.id_mejora = rubros_mejoras.id_mejora 
					AND mejoras.activo=1 AND (".$agregar_fuente.$agregar_fuente2.$agregar_fuente3.$agregar_fuente4." uso_calor=2)
					GROUP BY mejoras.id_mejora ORDER BY rubros_mejoras.valoracion DESC LIMIT 10";
					*/
					$consulta_calores = "SELECT mejoras.id_mejora,mejoras.nombre,
					mejoras.uso_calor,mejoras.uso_frio,mejoras.uso_electricidad,mejoras.uso_combustible
					FROM mejoras,rubros_mejoras
					WHERE /*mejoras.id_mejora = rubros_mejoras.id_mejora  AND */
					mejoras.activo=1 AND (".$agregar_fuente.$agregar_fuente2.$agregar_fuente3.$agregar_fuente4." uso_calor=2)
					GROUP BY mejoras.id_mejora ORDER BY rubros_mejoras.valoracion DESC LIMIT 10";
					
					//echo $consulta_calores."<br><br>";
					$msql = mysql_query($consulta_calores);
					if(mysql_num_rows($msql)>0){
						?>
	                    <ul class="lista_procesos lista_procesos_energia">
	                    <?
						while($rfi = mysql_fetch_array($msql)){
							?><li><label><a href="index.php?id=mejoras&mejora=<?=$rfi['id_mejora']?>"><?=$rfi['nombre']?></a></label><span><?
							if($rfi['uso_calor']==1){ ?><img src="img/tr.gif" class="icon-37" /><? } ?>
							<? if($rfi['uso_frio']==1){ ?><img src="img/tr.gif" class="icon-36" /><? } ?>
	                        <? if($rfi['uso_electricidad']==1){ ?><img src="img/tr.gif" class="icon-26" /><? } ?>
	                        <? if($rfi['uso_combustible']==1){ ?><img src="img/tr.gif" class="icon-25" /><? } 
							echo "</span></li>";
							//echo "(Cal:".$rfi['uso_calor']." Frio:".$rfi['uso_frio']." Elec:".$rfi['uso_electricidad']." Comb:".$rfi['uso_combustible'].")<br />";
						}
						?>
						</ul>
						<?
					} else {
						echo "No hay mejoras";
					}
					
					
				}
			} else {
				?><li><a><font>Sin ficha</font></a></li><?
			}		
		}
		
		elseif($_GET['acc']=='asistirEvento' && isset($_GET['evento']) && is_numeric($_GET['evento'])){
			if(isset($_SESSION['iduser'])){
				$ver_Existe_evento = mysql_query("SELECT cupos_max FROM eventos WHERE id_evento=".$_GET['evento']." AND NOW()<=fecha LIMIT 1");
				if(mysql_num_rows($ver_Existe_evento)>0){
					$cupos_total = mysql_result($ver_Existe_evento,0);
					$ver_si_hay_cupos_sql = mysql_query("SELECT id_evento FROM eventos_usuarios WHERE id_evento = ".$_GET['evento']."");
					$ver_invitados = mysql_query("SELECT nombre FROM invitados_eventos WHERE id_evento = ".$not['id_evento']."");

					$cupos_usados = mysql_num_rows($ver_si_hay_cupos_sql) + mysql_num_rows($ver_invitados);
					if(($cupos_total-$cupos_usados)>0){
						//veo si ya puso asistir
						$ver_existencia = mysql_query("SELECT id_evento FROM eventos_usuarios WHERE id_evento = ".$_GET['evento']." AND id_user=".$_SESSION['iduser']." LIMIT 1");
						if(mysql_num_rows($ver_existencia)>0){ //si ya estaba inscrito, entonces no se inscribe
							?><script>location.href='evento.php?evento=<?=$_GET['evento']?>&error=inscrito'</script><?	
						} else { //si no estaba inscribo, entonces se inscribe
							mysql_query("INSERT INTO eventos_usuarios (id_evento,id_user) VALUES ('".$_GET['evento']."','".$_SESSION['iduser']."')");
							
							$user_query = mysql_query("select id_user,nombre,clave,email,tipo from usuarios where id_user='".$_SESSION['iduser']."' AND activo=1 LIMIT 1");
							$user = mysql_fetch_array($user_query);
							$evento_query = mysql_query("Select nombre,fecha from eventos where id_evento=".$_GET['evento']."");
							$evento = mysql_fetch_array($evento_query);
							$email_contacto = $user["email"];
							$nombre_contacto = $user["nombre"];
							$nombre_evento = $evento["nombre"];
						
							//mail al inscrito
							$dominio_mail = $_SERVER['HTTP_HOST'];//"aiguasol.com";
							$URL_DIRex = $_SERVER['SERVER_NAME'];
							$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];



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
							Estimad@ ".$nombre_contacto.",<br><br>
							Tu inscripci&oacute;n al evento: ".trim($nombre_evento)." para el día ".$evento["fecha"]." Ha sido exitosa.<br>
							<br>
							¡No te olvides de asistir!";

							//echo $msg;
							//die();

							$sent_mail = mail(trim($email_contacto), "Inscripción correcta al evento", $msg."<br><br>Saludos,<br>Equipo de Smart Energy Concepts.", $headers);



							?><script>location.href='evento.php?evento=<?=$_GET['evento']?>&register=ok'</script><?	
						}
					} else {
						?><script>location.href='evento.php?evento=<?=$_GET['evento']?>&error=sincupos'</script><?	
					}
				} else {
					?><script>location.href='evento.php?evento=<?=$_GET['evento']?>&error=noexiste'</script><?	
				}
			} else {
			?><script>history.back()</script>
	        <?	
			}
		}
		
		elseif($_GET['acc']=='desasistirEvento' && isset($_GET['evento']) && is_numeric($_GET['evento'])){
			if(isset($_SESSION['iduser'])){
				$ver_Existe_evento = mysql_query("SELECT cupos_max FROM eventos WHERE id_evento=".$_GET['evento']." AND NOW()<=fecha LIMIT 1");
				if(mysql_num_rows($ver_Existe_evento)>0){
					@mysql_query("DELETE FROM eventos_usuarios WHERE id_evento=".$_GET['evento']." AND id_user=".$_SESSION['iduser']."");
					?><script>location.href='evento.php?evento=<?=$_GET['evento']?>&unreg=ok'</script><?	
				} else {
					?><script>location.href='evento.php?evento=<?=$_GET['evento']?>&error=noexiste'</script><?	
				}
			} else {
			?><script>history.back()</script>
	        <?	
			}
		}
		
		elseif($_GET['acc']=='addtema' && isset($_POST['create'])){
			
			include("functions.php");
			if(!is_numeric($_POST['tipo'])){
				?><script>location.href='index.php?id=newthread&mejora=<?=$_POST['mejora']?>&error=notype'</script><?
			} else {
				$ver_mejoras = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora,mejoras.descripcion as descripcion, rubros_mejoras.* FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND rubros_mejoras.id_rubro_mejora=".$_POST['mejora']." LIMIT 1");
	    		if(mysql_num_rows($ver_mejoras)>0){
					$insertar = mysql_query("INSERT INTO discusiones (titulo,mensaje,id_tipo,id_user,id_mejora,fecha) 
					VALUES ('".corregir($_POST['titulo'])."','".$_POST['mensaje']."','".$_POST['tipo']."','".$_SESSION['iduser']."','".$_POST['mejora']."','".date("Y-m-d H:i:s")."')
					");
					if($insertar){
						?><script>location.href='index.php?id=mejoras&mejora=<?=$_POST['mejora']?>#discusiones'</script><?
					} else {
						?><script>location.href='index.php?id=newthread&mejora=<?=$_POST['mejora']?>&error=unknown'</script><?
					}
				}
			}
		}
		
		elseif($_GET['acc']=='editVoto' && is_numeric($_POST['idvoto'])){
			mysql_query("UPDATE evaluacion_proveedores SET mensaje='".$_POST['mensaje']."' WHERE id_user=".$_SESSION['iduser']." AND id_voto=".$_POST['idvoto']."");
			?><script>location.href='index.php?id=profile&user=<?=$_POST['proveedor']?>#ma<?=$_POST['idvoto']?>'</script><?
		} 
		
		elseif($_GET['acc']=='delvoto' && is_numeric($_GET['voto'])){
			if(isset($_SESSION['adminuser'])){
				if(mysql_query("DELETE FROM evaluacion_proveedores WHERE id_voto=".$_GET['voto']."")){
					mysql_query("DELETE FROM evaluacion_proveedores WHERE id_padre=".$_GET['voto']."");
					
					$ver_avg = mysql_query("SELECT AVG(nota) FROM evaluacion_proveedores WHERE id_proveedor=".$_GET['proveedor']."");
					$promedio = mysql_result($ver_avg,0);
					if(mysql_num_rows($ver_avg)>0){
						mysql_query("UPDATE proveedores SET valoracion='".$promedio."' WHERE id_user=".$_GET['proveedor']."");
					} else {
						mysql_query("UPDATE proveedores SET valoracion='0' WHERE id_user=".$_GET['proveedor']."");
					}
					?><script>location.href='index.php?id=profile&user=<?=$_GET['proveedor']?>#votes'</script><?
				} else {
					?><script>location.href='index.php?id=profile&user=<?=$_GET['proveedor']?>#votes'</script><?
				}
			} else {
				if(mysql_query("DELETE FROM evaluacion_proveedores WHERE id_user=".$_SESSION['iduser']." AND id_voto=".$_GET['voto']."")){
					mysql_query("DELETE FROM evaluacion_proveedores WHERE id_padre=".$_GET['voto']."");
					
					$ver_avg = mysql_query("SELECT AVG(nota) FROM evaluacion_proveedores WHERE id_proveedor=".$_GET['proveedor']."");
					$promedio = mysql_result($ver_avg,0);
					if(mysql_num_rows($ver_avg)>0){
						mysql_query("UPDATE proveedores SET valoracion='".$promedio."' WHERE id_user=".$_GET['proveedor']."");
					} else {
						mysql_query("UPDATE proveedores SET valoracion='0' WHERE id_user=".$_GET['proveedor']."");
					}
					
					?><script>location.href='index.php?id=profile&user=<?=$_GET['proveedor']?>#votes'</script><?
				} else {
					?><script>location.href='index.php?id=profile&user=<?=$_GET['proveedor']?>#votes'</script><?
				}
			}	
		}
		
		elseif($_GET['acc']=='vote' && isset($_POST['vote'])){
			
			include("functions.php");
			if(!is_numeric($_POST['proveedor']) || !is_numeric($_POST['rating']) || $_POST['rating']<1 || $_POST['rating']>5){
				?><script>history.back()</script><?
			} else {
				
				if($_POST['proveedor']==$_SESSION['iduser']){
					?><script>location.href='index.php?id=profile&user=<?=$_POST['proveedor']?>&error=own#votes'</script><?
				} else {
					$ver_existencia = mysql_query("SELECT id_user FROM proveedores WHERE id_user=".$_POST['proveedor']." LIMIT 1");
					if(mysql_num_rows($ver_existencia)>0){
						$ver_si_Existe_voto = mysql_query("SELECT * FROM evaluacion_proveedores WHERE id_proveedor=".$_POST['proveedor']." AND id_user=".$_SESSION['iduser']." AND id_padre=0");
						if(mysql_num_rows($ver_si_Existe_voto)>0){
							?><script>location.href='index.php?id=profile&user=<?=$_POST['proveedor']?>&error=alreadyexists#votes'</script><?
						} else {
							$insertar = mysql_query("INSERT INTO evaluacion_proveedores (id_proveedor,nota,mensaje,id_user) 
							VALUES ('".$_POST['proveedor']."','".$_POST['rating']."','".corregir($_POST['mensaje'])."','".$_SESSION['iduser']."')
							");
							if($insertar){
								$ver_avg = mysql_query("SELECT AVG(nota) FROM evaluacion_proveedores WHERE id_proveedor=".$_POST['proveedor']."");
								$promedio = mysql_result($ver_avg,0);
								if(mysql_num_rows($ver_avg)>0){
									mysql_query("UPDATE proveedores SET valoracion='".$promedio."' WHERE id_user=".$_POST['proveedor']."");
								} else {
									mysql_query("UPDATE proveedores SET valoracion='0' WHERE id_user=".$_POST['proveedor']."");
								}
								?><script>location.href='index.php?id=profile&user=<?=$_POST['proveedor']?>#votes'</script><?
							} else {
								?><script>location.href='index.php?id=profile&user=<?=$_POST['proveedor']?>&error=unknown'</script><?
							}
						}
					}
				}
				
			}
		}
		
		elseif($_GET['acc']=='replytovote' && isset($_POST['replyt'])){
			
			include("functions.php");
			if(!is_numeric($_POST['proveedor']) || !is_numeric($_POST['id_padre'])){
				?><script>history.back()</script><?
			} else {
				$ver_existencia = mysql_query("SELECT id_user FROM evaluacion_proveedores WHERE id_proveedor=".$_POST['proveedor']." AND id_voto=".$_POST['id_padre']." LIMIT 1");
	    		if(mysql_num_rows($ver_existencia)>0){
					
					
					$insertar = mysql_query("INSERT INTO evaluacion_proveedores (mensaje,id_user,id_proveedor,fecha,id_padre) 
					VALUES ('".corregir($_POST['mensaje'])."','".$_SESSION['iduser']."','".$_POST['proveedor']."','".date("Y-m-d H:i:s")."','".$_POST['id_padre']."')
					");
					if($insertar){
						?><script>location.href='index.php?id=profile&user=<?=$_POST['proveedor']?>#ma<?=$_POST['id_padre']?>'</script><?
					} else {
						?><script>location.href='index.php?id=profile&user=<?=$_POST['proveedor']?>&error=unknown'</script><?
					}
					
					
				}
			}
		}
		
		elseif($_GET['acc']=='replythread' && isset($_POST['reply'])){
			
			include("functions.php");
			if(strlen($_POST['mensaje'])<1){
				?><script>location.href='index.php?id=viewthread&thread=<?=$_POST['thread']?>&error=nomsg'</script><?
			} else {
				$ver_existencia = mysql_query("SELECT discusiones.id_discusion FROM discusiones WHERE id_discusion=".$_POST['thread']." LIMIT 1");
	    		if(mysql_num_rows($ver_existencia)>0){
					$insertar = mysql_query("INSERT INTO mensajes (mensaje,id_user,id_discusion,fecha,id_padre) 
					VALUES ('".$_POST['mensaje']."','".$_SESSION['iduser']."','".$_POST['thread']."','".date("Y-m-d H:i:s")."','0')
					");
					if($insertar){
						?><script>location.href='index.php?id=viewthread&thread=<?=$_POST['thread']?>#lastone'</script><?
					} else {
						?><script>location.href='index.php?id=viewthread&thread=<?=$_POST['thread']?>&error=unknown'</script><?
					}
				}
			}
		}
		
		elseif($_GET['acc']=='replyto' && isset($_POST['replyt'])){
			
			include("functions.php");
			if(strlen($_POST['mensaje'])<1){
				?><script>location.href='index.php?id=viewthread&thread=<?=$_POST['thread']?>&error=nomsg'</script><?
			} else {
				$ver_existencia = mysql_query("SELECT id_discusion FROM mensajes WHERE id_discusion=".$_POST['thread']." AND id_mensaje=".$_POST['idmsg']." LIMIT 1");
	    		if(mysql_num_rows($ver_existencia)>0){
					$insertar = mysql_query("INSERT INTO mensajes (mensaje,id_user,id_discusion,fecha,id_padre) 
					VALUES ('".corregir($_POST['mensaje'])."','".$_SESSION['iduser']."','".$_POST['thread']."','".date("Y-m-d H:i:s")."','".$_POST['idmsg']."')
					");
					if($insertar){
						?><script>location.href='index.php?id=viewthread&thread=<?=$_POST['thread']?>#me<?=$_POST['idmsg']?>'</script><?
					} else {
						?><script>location.href='index.php?id=viewthread&thread=<?=$_POST['thread']?>&error=unknown'</script><?
					}
				}
			}
		}
		
		elseif($_GET['acc']=='cargarcoverRubro' && (isset($_FILES['imagen_publica']))){
			function cargarfotoRubro($file_imagen,$principal,$rubro){
				session_start();
				$image = $file_imagen['name'];
				$partes = explode('.',$file_imagen['name']) ;
				$num = count($partes) - 1 ;
				$extension = $partes[$num] ;
				$carpeta_index = "rubros/";
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
				session_start();
				$verify = mysql_query("SELECT id_img,imagen,principal FROM imagenes_rubros WHERE id_rubro=".$rubro." AND id_img=".$idimg."");
				if(mysql_num_rows($verify)>0){
					$rr = mysql_fetch_array($verify);
					$archivo1 = $rr['imagen'];
					$carpeta = "rubros/";
					if(file_exists($carpeta.$archivo1)){
						unlink($carpeta.$archivo1);
					}
					$sql_del_img = "DELETE FROM imagenes_rubros WHERE id_rubro=".$rubro." AND id_img=".$idimg."";
					mysql_query($sql_del_img);
					return $rr['id_img'];
				}
			}
			
			
			if(strlen($_FILES['imagen_publica']['name'])>3){
				$partesx = explode('.',$_FILES['imagen_publica']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarfotoRubro($_FILES['imagen_publica'],1,$_POST['rubro']);
					
					?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>'</script><?
				} else {
					?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>'</script><?
				}
			} else {
				?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>&error=noupload'</script><?
			}	
		}

		elseif($_GET['acc']=='cargarImgProcesoRubro' && (isset($_FILES['imagen_publica']))){
			function cargarImgProcesoRubro($file_imagen,$rubro){
				session_start();
				$image = $file_imagen['name'];
				$partes = explode('.',$file_imagen['name']) ;
				$num = count($partes) - 1 ;
				$extension = $partes[$num] ;
				$carpeta_index = "rubros/";
				$size_max = 36700000;
				$seedx = str_replace("-","",rand(00,99));
				$archivo_name = "proceS".date('YmdHis')."_".$seedx.".".$extension;
				if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
					if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
						$fecha = date("Y-m-d H:i:s");
						$SQL_ADDFOTO = "UPDATE rubros SET img_proceso='".$archivo_name."' WHERE id_rubro=".$rubro."";
						mysql_query($SQL_ADDFOTO);
					}
				} else {
					echo 'Error: Ha superado el l&iacute;mite de peso por foto';
				}
			}
			if(strlen($_FILES['imagen_publica']['name'])>3){
				$partesx = explode('.',$_FILES['imagen_publica']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarImgProcesoRubro($_FILES['imagen_publica'],$_POST['rubro']);
					?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>#proCesoPic'</script><?
				} else {
					?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>#proCesoPic'</script><?
				}
			} else {
				?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>&error=noupload'</script><?
			}
		}
		
		elseif($_GET['acc']=='cargarDiagramaRubro' && (isset($_FILES['imagen_publica']))){
			function cargarDiagramaRubro($file_imagen,$rubro){
				session_start();
				$image = $file_imagen['name'];
				$partes = explode('.',$file_imagen['name']) ;
				$num = count($partes) - 1 ;
				$extension = $partes[$num] ;
				$carpeta_index = "rubros/";
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
						$carpeta = "rubros/";
						if(file_exists($carpeta.$archivo1)){
							unlink($carpeta.$archivo1);
						}
					}
					$sql_del_img = "UPDATE rubros SET diagrama_flujo='' WHERE id_rubro=".$rubro."";
					mysql_query($sql_del_img);
				}
			}
			
			
			if(strlen($_FILES['imagen_publica']['name'])>3){
				$partesx = explode('.',$_FILES['imagen_publica']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarDiagramaRubro($_FILES['imagen_publica'],$_POST['rubro']);
					
					?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>#diagramafl'</script><?
				} else {
					?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>#diagramafl'</script><?
				}
			} else {
				?><script>location.href='index.php?id=verrubro&rubro=<?=$_POST['rubro']?>&error=noupload'</script><?
			}	
		}
		
		elseif($_GET['acc']=='cargarPicProyecto' && (isset($_FILES['imagen_publica']))){
			if(strlen($_FILES['imagen_publica']['name'])>3){
				$partesx = explode('.',$_FILES['imagen_publica']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarPicProyecto($_FILES['imagen_publica'],$_POST['idproyecto']);
					
					?><script>location.href='index.php?id=proyectos&proyecto=<?=$_POST['idproyecto']?>#imgg'</script><?
				} else {
					?><script>location.href='index.php?id=proyectos&proyecto=<?=$_POST['idproyecto']?>#imgg'</script><?
				}
			} else {
				?><script>location.href='index.php?id=proyectos&proyecto=<?=$_POST['idproyecto']?>&error=noupload'</script><?
			}
		}

		elseif($_GET['acc']=='addproyecto' && (isset($_POST['agregar']))){
			include_once("functions.php");
			if($_SESSION['tipo']==2){
				$arr_fecha_t = explode("-",$_POST['fecha_implementacion']);
				$date_t = $arr_fecha_t[2]."-".$arr_fecha_t[1]."-".$arr_fecha_t[0];
				
				$update_proyecto = "INSERT INTO proyectos
				(nombre,descripcion,localizacion,empresa,recurso,tipo_energia,capacidad_instalada,procesos_intervenidos,energia_ahorro,porcentaje_ahorro,
				inversion,payback_esperado,tipo_financiamiento,fecha_implementacion,subsidio,modelo_negocio,rol_proveedor,id_proveedor,id_rubro) 
				VALUES
				('".corregir($_POST['nombre'])."','".corregir(str_replace("\n","<br>",$_POST['descripcion']))."','".corregir($_POST['localizacion'])."','".corregir($_POST['empresa'])."',
				'".corregir($_POST['recurso'])."','".($_POST['tipo_energia'])."','".($_POST['capacidad_instalada'])."','".corregir(str_replace("\n","<br>",$_POST['procesos_intervenidos']))."',
				'".soloPorcentajes($_POST['energia_ahorro'])."','".soloPorcentajes($_POST['porcentaje_ahorro'])."','".($_POST['inversion'])."',
				'".($_POST['payback_esperado'])."','".corregir(str_replace("\n","<br>",$_POST['tipo_financiamiento']))."','".$date_t."',
				'".($_POST['subsidio'])."','".corregir(str_replace("\n","<br>",$_POST['modelo_negocio']))."','".corregir($_POST['rol_proveedor'])."','".($_SESSION['iduser'])."','".($_POST['id_rubro'])."')";
				
				if(mysql_query($update_proyecto)){
					
					$last_one = mysql_query("SELECT id_proyecto FROM proyectos WHERE id_proveedor=".$_SESSION['iduser']." ORDER BY id_proyecto DESC LIMIT 1");
					if(mysql_num_rows($last_one)>0){
						$rpp = mysql_fetch_array($last_one);
						if(strlen($_FILES['img_folder']['name'])>3){
							$partesx = explode('.',$_FILES['img_folder']['name']);
							$numx = count($partesx) - 1;
							$extensionx = $partesx[$numx];
							if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
								cargarPicProyecto($_FILES['img_folder'],$rpp['id_proyecto']);
							} 
						} 
						
						
						
						
						//////////////////////////////// Email //////////////////////////////////
						$Ver_proyectos = mysql_query("
						SELECT proyectos.nombre as titulo, proyectos.id_proyecto, usuarios.nombre as nombreuser,usuarios.id_user,usuarios.email as email_user
						FROM proyectos,usuarios,proveedores_favoritos 
						WHERE proyectos.id_proveedor=proveedores_favoritos.id_proveedor AND proveedores_favoritos.id_user=usuarios.id_user AND 
						proveedores_favoritos.id_proveedor=".$_SESSION['iduser']." AND proyectos.id_proyecto=".$rpp['id_proyecto'].""); 
						
						
						$data_proveedor = mysql_query("SELECT nombre FROM usuarios WHERE id_user=".$_SESSION['iduser']." LIMIT 1");
						$nombre_proveedor = mysql_result($data_proveedor,0);
						
						if(mysql_num_rows($Ver_proyectos)>0){
							while($inter = mysql_fetch_array($Ver_proyectos)){
							
								$url_web = "http://".$_SERVER['HTTP_HOST'];
							
								$mensaje_email = "
								Estimado ".$inter['nombreuser'].",<br>
								El proveedor ".$nombre_proveedor.", acaba de subir un nuevo nuevo proyecto titulado:
								<br>
								".$inter['titulo']." 
								<br>
								Si quieres revisarlo, puedes visitar el siguiente link:<br>
								<a href='".$url_web."/index.php?id=proyectos&proyecto=".$inter['id_proyecto']."'>".$url_web."/index.php?id=proyectos&proyecto=".$inter['id_proyecto']."</a>
								<br><br>
								Recuerda que para ver los proyectos, debes haber iniciado sesi&oacute;n.
								<br><br>
								Saludos del equipo de Smart Energy Concept.
								";
								
								$headers = "Content-type: text/html; charset=utf-8\r\n";
								$headers .= "From: noreply@".$_SERVER['HTTP_HOST'];
								$asunto = "Nuevo proyecto en Smart Energy Concept";
								mail(trim($inter['email_user']),$asunto, $mensaje_email, $headers);
								//echo $mensaje_email."<br><br>".$inter['email_user']."<br>".$headers."<br><br><br>-----------------------------<br>";
							}
						}
							//////////////////////////////// Email //////////////////////////////////
						
						
						
						
						?><script>location.href='index.php?id=proyectos&proyecto=<?=$rpp['id_proyecto']?>'</script><?
					} else {
						?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?
					}
				} else {
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?
				}
			} else {
				?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?	
			}
		}
		elseif($_GET['acc']=='editproyecto' && (isset($_POST['guardar']))){
			include_once("functions.php");
			if($_SESSION['tipo']==2){
				if(strlen($_FILES['img_folder']['name'])>3){
					$partesx = explode('.',$_FILES['img_folder']['name']);
					$numx = count($partesx) - 1;
					$extensionx = $partesx[$numx];
					if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
						cargarPicProyecto($_FILES['img_folder'],$_POST['idproyecto']);
					} 
				}
				$arr_fecha_t = explode("-",$_POST['fecha_implementacion']);
				$date_t = $arr_fecha_t[2]."-".$arr_fecha_t[1]."-".$arr_fecha_t[0];
				
				$update_proyecto = "UPDATE `proyectos` SET
				`nombre` = '".corregir($_POST['nombre'])."',
				`descripcion` = '".corregir(str_replace("\n","<br>",$_POST['descripcion']))."',
				`localizacion` = '".corregir($_POST['localizacion'])."',
				`empresa` = '".corregir($_POST['empresa'])."',
				`recurso` = '".corregir($_POST['recurso'])."',
				`tipo_energia` = '".$_POST['tipo_energia']."',
				`capacidad_instalada` = '".$_POST['capacidad_instalada']."',
				`procesos_intervenidos` = '".corregir(str_replace("\n","<br>",$_POST['procesos_intervenidos']))."',
				`energia_ahorro` = '".soloPorcentajes($_POST['energia_ahorro'])."',
				`porcentaje_ahorro` = '".soloPorcentajes($_POST['porcentaje_ahorro'])."',
				`inversion` = '".$_POST['inversion']."',
				`payback_esperado` = '".$_POST['payback_esperado']."',
				`tipo_financiamiento` = '".corregir(str_replace("\n","<br>",$_POST['tipo_financiamiento']))."',
				`fecha_implementacion` = '".$date_t."',
				`subsidio` = '".($_POST['subsidio'])."',
				`modelo_negocio` = '".corregir(str_replace("\n","<br>",$_POST['modelo_negocio']))."',
				`rol_proveedor` = '".corregir($_POST['rol_proveedor'])."',
				`id_rubro` = '".$_POST['id_rubro']."'
				WHERE
				`id_proveedor` = '".$_SESSION['iduser']."' AND `id_proyecto` = '".$_POST['idproyecto']."'";
				//ini_set('display_errors',0);
				//error_reporting(E_ALL);
				//echo($update_proyecto);die();
				//$aux = mysql_query($update_proyecto);
				$result = mysql_query($update_proyecto) or trigger_error(mysql_error()." ".$update_proyecto);
				if($result){
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>#MisProyectos'</script><?	
				} else {
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>#MisProyectos'</script><?	
				}
			} else {
				?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?	
			}
		}
		
		elseif($_GET['acc']=='getTipoC' && isset($_GET['idcombustible']) && is_numeric($_GET['idcombustible'])){
			$respC = mysql_query("SELECT id_unidad,unidad FROM unidades WHERE tipo=(SELECT tipo_unidad FROM combustibles WHERE id_combustible=".$_GET['idcombustible'].")");
			while($combc = mysql_fetch_array($respC)){
				?>
	            <option value="<?=$combc['id_unidad']?>"><?=$combc['unidad']?></option>
	            <?	
			}
		}
		
		elseif($_GET['acc']=='delproyecto' && (isset($_GET['proyecto']) && is_numeric($_GET['proyecto']))){
			if($_SESSION['tipo']==2){

				$update_proyecto = "DELETE FROM proyectos WHERE id_proyecto=".$_GET['proyecto']."";
				
				eliminarProyecto($_GET['proyecto']);
				if(mysql_query($update_proyecto)){
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>#MisProyectos'</script><?
				} else {
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>&error=notDelete#MisProyectos'</script><?
				}
			} else {
				?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?	
			}
		}

		elseif($_GET['acc']=='getUniProductiva' && isset($_GET['idrubro']) && is_numeric($_GET['idrubro'])){
			$respC = mysql_query("SELECT unidad_productiva FROM rubros WHERE id_rubro=".$_GET['idrubro']." LIMIT 1");
			$combc = mysql_fetch_array($respC);
			if($combc['unidad_productiva']==0){
				?>
				<option value="kg">kg</option>
	            <option value="ton">Ton</option>
				<?
			} else {
				?>
	            <option value="litro">Litros</option>
	            <option value="m3">Metros c&uacute;bicos</option>
	            <?
			}
		}
		
		elseif($_GET['acc']=='cargarDataDiagnostico' && isset($_GET['diagnostico']) && is_numeric($_GET['diagnostico'])){
			$mi_diagnostico = mysql_query("SELECT diagnosticos.*,rubros.nombre as rubro FROM diagnosticos,rubros WHERE diagnosticos.id_rubro=rubros.id_rubro AND id_empresa=".$_SESSION['iduser']." AND id_diagnostico=".$_GET['diagnostico']." LIMIT 1");
			if(mysql_num_rows($mi_diagnostico)>0){
				$di = mysql_fetch_array($mi_diagnostico);
				$maximos = mysql_query("SELECT consumo_especifico_min as min,consumo_especifico_max as max FROM rubros WHERE id_rubro=".$di['id_rubro']."");
				if(mysql_num_rows($maximos)>0){
					$max = mysql_fetch_array($maximos);
					
					
					$tipo_U_productiva = mysql_query("SELECT unidad_productiva FROM rubros WHERE id_rubro=".$di['id_rubro']."");
					if(mysql_result($tipo_U_productiva,0)==0){
						$unidad_productiva = 'kg';
					} else {
						$unidad_productiva = 'litro';
					}
					$texto_consumo_especifico = $di['consumo_especifico']." kWh/".$unidad_productiva;
					$texto_generacion_especifica = $di['generacion_especifica']." kgCO2/".$unidad_productiva;
					?>
	                <h1>Resultados</h1>
					<br /><br />
	                <table>
	                	<tr>
	                    	<td width="170">Rubro:</td>
	                        <td colspan="2"><?=$di['rubro']?></td>
	                    </tr>
	                    <tr>
	                    	<td>Producci&oacute;n:</td>
	                        <td><?=str_replace(".000","",$di['produccion_anual'])?></td><td><?=$di['unidad_produccion']?></td>
	                    </tr>
	                    <tr>
	                    	<td>Consumo el&eacute;ctrico:</td>
	                        <td><?=str_replace(".000","",$di['consumo_electrico'])?></td><td>
	                        	<?
	                            if($di['unidad_consumo_electrico']=='0'){ echo 'kWh/a&ntilde;o'; } 
	                            elseif($di['unidad_consumo_electrico']=='1'){ echo 'MWh/a&ntilde;o"'; } 
								?>
	                        </td>
	                    </tr>
	                	<?
	                    $total_combustibles = 3;
						for($i=1;$i<=$total_combustibles;$i++){
							$tipo_comb = "tipo_combustible_".$i;
							$unidad_comb = "unidad_combustible_".$i;
							$cantidad_comb = "cantidad_combustible_".$i;
							$consulta_data = "SELECT combustible,unidad FROM combustibles,unidades WHERE id_combustible=".$di[$tipo_comb]." AND id_unidad=".$di[$unidad_comb]." LIMIT 1";
							$sql_comb = mysql_query($consulta_data);
							$arr_comb = mysql_fetch_array($sql_comb);
							if($di[$tipo_comb]>0){
							?>
							<tr>
								<td><?=$arr_comb['combustible']?></td>
								<td><?=str_replace(".000","",$di[$cantidad_comb])?></td>
								<td><?=$arr_comb['unidad']?></td>
							</tr>
							<?
							}
						}
						?>
					</table>
	                <br />
	                
					<table>
						<tr>
							<td width="170">Consumo espec&iacute;fico</td>
							<td><?=$texto_consumo_especifico?></td>
						</tr>
						<tr>
							<td>Generaci&oacute;n de CO<sub>2</sub></td>
							<td><?=$di['generacion_total']?> kg</td>
						</tr>
						<tr>
							<td>Generaci&oacute;n espec&iacute;fica</td>
							<td><?=$texto_generacion_especifica?></td>
						</tr>
						<tr>
							<td>Consumo Total</td>
							<td><?=$di['consumo_total']?> kWh</td>
						</tr>
					</table>
					<br />
					<?
					$posicion_actual = $di['consumo_especifico'];
					$m_error = 4.55;
					$indice_actual = ($posicion_actual*100)/$max['max'];
					if($posicion_actual==$max['min']){
						$indice_actual = ($max['min']+$m_error)-2;
					}
					if($posicion_actual<=$max['max'] && $posicion_actual>=$max['min']){
						?>
	                    <link href="css/style.css" rel="stylesheet" type="text/css" />
						<div class="barra_diagnostico">
	                        <span class="min_diagnostico"><?=$max['min']?></span>
	                        <span class="max_diagnostico"><?=$max['max']?></span>
	                        <span class="posicion_diag" style="right:<?=($indice_actual-$m_error)?>%"><?=number_format($posicion_actual,3)?></span>
	                        <span class="icon-location diaglocation" style="right:<?=($indice_actual-$m_error)?>%"></span>
	                    </div>
						<?
						if($indice_actual<=50 && $indice_actual>=20){
							?><img src="iconos/diag_piola.png" width="60" align="left" style="margin:0px 15px 0px 0px" /><?
							echo "Tu consumo energ&eacute;tico es competitivo dentro de la industria, sin embargo, todav&iacute;a puede ser mejor. Si quieres saber c&oacute;mo ser m&aacute;s competitivo, entra a ver las mejoras que te proponemos para tu industria.";	
						}
						elseif($indice_actual>50){
							?><img src="iconos/diag_mal.png" width="60" align="left" style="margin:0px 15px 0px 0px" /><?
							echo "Tu consumo energ&eacute;tico es muy alto dentro de la industria, sin embargo, puedes mejorarlo. Si quieres saber c&oacute;mo, entra a ver las mejoras que te proponemos para tu industria.";	
						}elseif($indice_actual<20){
							?><img src="iconos/diag_bien.png" width="60" align="left" style="margin:0px 15px 0px 0px" /><?
							echo "Felicidades: Tu consumo energ&eacute;tico es muy bajo dentro de la industria. Si quieres saber c&oacute;mo disminuirla aun m&aacute;s, entra a ver las mejoras que te proponemos para tu industria.";	
						}
					} else {
						echo "<br><br>Est&aacute;s fuera del rango. Tu consumo debiese estar entre <strong>".$max['min']."</strong> y <strong>".$max['max']."</strong>. Comun&iacute;cate con el administrador para resolver el problema.";
					}
				}
					
			}
		}
		
		elseif($_GET['acc']=='cargarDiagnostico'){
			/*echo "Rubro: ".$_POST['idrubro']."<br>Consumo espec.:";
			echo $_POST['produccion']."<br>Unidad cons. especif.:";
			echo $_POST['unidad_produccion']."<br>Consumo electrico: ";
			echo $_POST['consumo_electrico']."<br>Unidad consum Electr.";
			echo $_POST['unidad_consumo_electrico']."<br><br><br>";*/
			
			$cols = array('kwh_kg','kwh_ton','kwh_l','kwh_m3');
			for($i=0;$i<count($_POST['tipo_combustible']);$i++){
				//echo $_POST['tipo_combustible'][$i]	." - ".$_POST['cantidad_combustible'][$i]." - ".$_POST['unidad_combustible'][$i]."<br><br>";
				if($i==0){ $comb_1 = $_POST['tipo_combustible'][$i]; $unidad_1 = $_POST['unidad_combustible'][$i]; $cantidad_1 = $_POST['cantidad_combustible'][$i]; }
				if($i==1){ $comb_2 = $_POST['tipo_combustible'][$i]; $unidad_2 = $_POST['unidad_combustible'][$i]; $cantidad_2 = $_POST['cantidad_combustible'][$i]; }
				if($i==2){ $comb_3 = $_POST['tipo_combustible'][$i]; $unidad_3 = $_POST['unidad_combustible'][$i]; $cantidad_3 = $_POST['cantidad_combustible'][$i]; }
			}
			
			if(isset($unidad_1) && is_numeric($unidad_1) && $unidad_1>0){
				$columna1 = mysql_query("SELECT col_energia FROM unidades WHERE id_unidad =".$unidad_1."");
				$row = mysql_fetch_array($columna1);
				$col_1 = $cols[($row['col_energia']-1)];
				$consumo_comsutible_1 = mysql_query("SELECT ".$col_1." FROM combustibles WHERE id_combustible = ".$comb_1."");
				$row = mysql_fetch_array($consumo_comsutible_1);
				$print_1 = $row[$col_1]*$cantidad_1;
			} else {
				$print_1 = 0;	
			}
			
			if(isset($unidad_2) && is_numeric($unidad_2) && $unidad_2>0){
				$columna2 = mysql_query("SELECT col_energia FROM unidades WHERE id_unidad =".$unidad_2."");
				$row = mysql_fetch_array($columna2);
				$col_2 = $cols[($row['col_energia']-1)];
				$consumo_comsutible_2 = mysql_query("SELECT ".$col_2." FROM combustibles WHERE id_combustible = ".$comb_2."");
				$row = mysql_fetch_array($consumo_comsutible_2);
				$print_2 = $row[$col_2]*$cantidad_2; 
			} else {
				$print_2 = 0;	
			}
			
			if(isset($unidad_3) && is_numeric($unidad_3) && $unidad_3>0){
				$columna3 = mysql_query("SELECT col_energia FROM unidades WHERE id_unidad =".$unidad_3."");
				$row = mysql_fetch_array($columna3);
				$col_3 = $cols[($row['col_energia']-1)];
				$consumo_comsutible_3 = mysql_query("SELECT ".$col_3." FROM combustibles WHERE id_combustible = ".$comb_3."");
				$row = mysql_fetch_array($consumo_comsutible_3);
				$print_3 = $row[$col_3]*$cantidad_3;
			} else {
				$print_3 = 0;	
			}
			
			$consumo_total_combustible = $print_1+$print_2+$print_3;
			//echo "<br>TOTAL: ".$consumo_total_combustible;
			
			$consumo_electrico = $_POST['consumo_electrico']*($_POST['unidad_consumo_electrico']==0?1:1000);
			//echo "<br>CE:".$consumo_electrico;
			
			if(isset($comb_1) && is_numeric($comb_1) && $comb_1>0){
				$co2_1 = mysql_query("SELECT kgco2_kWh FROM combustibles WHERE id_combustible=".$comb_1."");
				if(mysql_num_rows($co2_1)>0){
					$total_co2_1 = mysql_result($co2_1,0)*$print_1;
				} else {
					$total_co2_1 = 0;	
				}
			} else {
				$total_co2_1 = 0;	
			}
			
			if(isset($comb_2) && is_numeric($comb_2) && $comb_2>0){
				$co2_2 = mysql_query("SELECT kgco2_kWh FROM combustibles WHERE id_combustible=".$comb_2."");
				if(mysql_num_rows($co2_1)>0){
					$total_co2_2 = mysql_result($co2_2,0)*$print_2;
				} else {
					$total_co2_2 = 0;	
				}
			} else {
				$total_co2_2 = 0;
			}
			
			if(isset($comb_3) && is_numeric($comb_3) && $comb_3>0){
				$co2_3 = mysql_query("SELECT kgco2_kWh FROM combustibles WHERE id_combustible=".$comb_3."");
				if(mysql_num_rows($co2_1)>0){
					$total_co2_3 = mysql_result($co2_3,0)*$print_3;
				} else {
					$total_co2_3 = 0;	
				}
			} else {
				$total_co2_3 = 0;
			}
			
			$co2_electrico = mysql_query("SELECT kgco2_kWh FROM combustibles WHERE id_combustible=13");
			$total_co2_electrico = mysql_result($co2_electrico,0)*$consumo_electrico;
			
			//echo $total_co2_3."<br><br>";
			$consumo_total_co2 = $total_co2_1+$total_co2_2+$total_co2_3+$total_co2_electrico;
			//echo "<br>Total consumo co2: ".$consumo_total_co2;
			
			if($_POST['unidad_produccion']=='kg' || $_POST['unidad_produccion']=='litro'){
				$var_prod = $_POST['produccion']*1;	
			} else {
				$var_prod = $_POST['produccion']*1000;
			}
			$tipo_U_productiva = mysql_query("SELECT unidad_productiva FROM rubros WHERE id_rubro=".$_POST['idrubro']."");
			if(mysql_result($tipo_U_productiva,0)==0){ //solido
				$unidad_productiva = 'kg';
			} else {
				$unidad_productiva = 'litro';
			}
			
			$consumo_especifico = ($consumo_total_combustible+$consumo_electrico)/$var_prod;
			$texto_consumo_especifico = $consumo_especifico." kWh/".$unidad_productiva;
			$db_consumo_especifico = "kWh/".$unidad_productiva; // ADD
			//echo "Consumo especifico de energ&iacute;a: ".$texto_consumo_especifico;
			
			
			$generacion_especifica = $consumo_total_co2/$var_prod;
			$texto_generacion_especifica = $generacion_especifica." kgCO2/".$unidad_productiva;
			$db_generacion_especifica = "kgCO2/".$unidad_productiva; // ADD
			//echo "<br>Generacion especifica de CO2: ".$texto_generacion_especifica;
			
			
			$CONSUMO_TOTAL = $consumo_total_combustible+$consumo_electrico; // [consumo_total]
			$GENERACION_TOTAL = $consumo_total_co2; // [generacion_total]
			$GENERACION_ESPECIFICA = $generacion_especifica; // [generacion_especifica]
			$CONSUMO_ESPECIFICOx = $consumo_especifico; // [consumo_especifico]
			
			$maximos = mysql_query("SELECT consumo_especifico_min as min,consumo_especifico_max as max FROM rubros WHERE id_rubro=".$_POST['idrubro']."");
			if(mysql_num_rows($maximos)>0){
				$max = mysql_fetch_array($maximos);
				/*echo "MIN: ".$max['min']."<br>";
				echo "MAX: ".$max['max']."<br><br>";
				
				echo "Consumo especifico: ".$texto_consumo_especifico."<br>";
				echo "Generaci&oacute;n de CO<sub>2</sub>: ".$GENERACION_TOTAL." kg<br>";
				echo "Generacion especifica: ".$texto_generacion_especifica."<br>";
				echo "Consumo Total: ".$CONSUMO_TOTAL." kWh<br><br>";
				
				echo "tu posici&oacute;n: ".$CONSUMO_ESPECIFICOx;*/
				
				if($CONSUMO_ESPECIFICOx<=$max['max'] && $CONSUMO_ESPECIFICOx>=$max['min']){
					$sql_add = "INSERT INTO diagnosticos 
					(id_rubro,id_empresa,consumo_especifico,tipo_combustible_1,cantidad_combustible_1,unidad_combustible_1,tipo_combustible_2,cantidad_combustible_2,
					unidad_combustible_2,tipo_combustible_3,cantidad_combustible_3,unidad_combustible_3,consumo_electrico,unidad_consumo_electrico,produccion_anual,
					unidad_produccion,generacion_especifica,generacion_total,consumo_total) VALUES
					('".$_POST['idrubro']."','".$_SESSION['iduser']."','".$CONSUMO_ESPECIFICOx."',
					'".$comb_1."','".$cantidad_1."','".$unidad_1."',
					'".$comb_2."','".$cantidad_2."','".$unidad_2."',
					'".$comb_3."','".$cantidad_3."','".$unidad_3."',
					'".$_POST['consumo_electrico']."','".$_POST['unidad_consumo_electrico']."','".$_POST['produccion']."',
					'".$_POST['unidad_produccion']."','".$GENERACION_ESPECIFICA."','".$GENERACION_TOTAL."','".$CONSUMO_TOTAL."')";
					//echo $sql_add;
					$agregar_diagnostico = mysql_query($sql_add);
					if($agregar_diagnostico){
						?><script>location.href='index.php?id=diagnostico&status=ok#Results'</script><?
					} else {
						?><script>location.href='index.php?id=diagnostico&error=db#Results'</script><?
					}
				} else {
					?><script>location.href='index.php?id=diagnostico&error=outrange#Results'</script><?
				}
				
			}
			
			/*
			echo "<br><br><pre>";
			print_r($_POST);
			echo "</pre>";*/
		}
		
		elseif($_GET['acc']=='cargarPicBPractica' && (isset($_FILES['imagen_publica']))){
			if(strlen($_FILES['imagen_publica']['name'])>3){
				$partesx = explode('.',$_FILES['imagen_publica']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarPicBPractica($_FILES['imagen_publica'],$_POST['bpractica']);
					
					?><script>location.href='index.php?id=bpracticas&practica=<?=$_POST['bpractica']?>#imgg'</script><?
				} else {
					?><script>location.href='index.php?id=bpracticas&practica=<?=$_POST['bpractica']?>#imgg'</script><?
				}
			} else {
				?><script>location.href='index.php?id=bpracticas&practica=<?=$_POST['bpractica']?>&error=noupload'</script><?
			}
		}
		
		elseif($_GET['acc']=='editpractica' && (isset($_POST['guardar']))){
			include_once("functions.php");
			if($_SESSION['tipo']==1){
				if(strlen($_FILES['img_folder']['name'])>3){
					$partesx = explode('.',$_FILES['img_folder']['name']);
					$numx = count($partesx) - 1;
					$extensionx = $partesx[$numx];
					if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
						cargarPicBPractica($_FILES['img_folder'],$_POST['idpractica']);
					} 
				} 
				$update_bpractica = "UPDATE buenas_practicas SET
				`id_rubro` = '".$_POST['idrubro']."',
				`titulo` = '".corregir($_POST['titulo'])."',
				`diagnostico_inicial` = '".corregir(str_replace("\n","<br>",$_POST['diagnostico_inicial']))."',
				`resultado` = '".corregir(str_replace("\n","<br>",$_POST['resultado']))."',
				`financiamiento` = '".corregir(str_replace("\n","<br>",$_POST['financiamiento']))."',
				`solucion` = '".corregir(str_replace("\n","<br>",$_POST['solucion']))."',
				`inversion` = '".($_POST['inversion'])."',
				`amortizacion` = '".($_POST['amortizacion'])."',
				`consumo_proceso_previo` = '".($_POST['consumo_proceso_previo'])."',
				`consumo_proceso_posterior` = '".($_POST['consumo_proceso_posterior'])."',
				`ahorro_energetico` = '".soloPorcentajes($_POST['ahorro_energetico'])."',
				`ahorro_economico` = '".soloPorcentajes($_POST['ahorro_economico'])."'
				WHERE id_buena_practica=".$_POST['idpractica']." AND id_empresa=".$_SESSION['iduser']."";
				
				$n_mejoras = $_POST['idmejora'];
				$mejoras = [];
				$insert_mejoras = [];
				$o_mejoras = mysql_query("SELECT * FROM buenas_practicas_mejoras WHERE id_buena_practica = ".$_POST['idpractica']);
				
				while($o_mejora = mysql_fetch_array($o_mejoras)){ array_push($mejoras, $o_mejora["id_mejora"]); }

				foreach($n_mejoras as $n_mejora){
					if(array_search($n_mejora,$mejoras) === false){ //si la mejora nueva ya estaba no hago nada
														  			//si la mejora no estaba entonces la inserto
						array_push($insert_mejoras, "(".$_POST['idpractica'].",".$n_mejora.")");
					}
				}
				
				$delete_mejoras = array_diff($mejoras, $n_mejoras);
				if(count($insert_mejoras)>0){
					$insert_mejoras_query = "INSERT INTO buenas_practicas_mejoras(id_buena_practica,id_mejora) 
						VALUES ".implode(",",$insert_mejoras);
					$mejoras_insertadas = mysql_query($insert_mejoras_query); echo "</br>";
				}
				if(count($delete_mejoras)>0){
				$delete_mejoras_query = "DELETE FROM buenas_practicas_mejoras 
					WHERE id_buena_practica = ".$_POST['idpractica']." AND id_mejora IN (".implode(",",$delete_mejoras).")";
				}
				
				$mejoras_borradas =   mysql_query($delete_mejoras_query);

				if(mysql_query($update_bpractica)){
					?><script>location.href='index.php?id=bpracticas&practica=<?=$_POST['idpractica']?>'</script><?
				} else {
					?><script>location.href='index.php?id=bpracticas&practica=<?=$_POST['idpractica']?>'</script><?
				}
			} else {
				?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?	
			}
		}
		
		elseif($_GET['acc']=='delpractica' && (isset($_GET['practica']) && is_numeric($_GET['practica']))){
			$owner_id = mysql_fetch_array(mysql_query("SELECT id_empresa FROM buenas_practicas where id_buena_practica = ".$_GET['practica']." LIMIT 1"));
			//echo $owner_id["id_empresa"]; die();
			if($_SESSION['tipo']==2 || $owner_id["id_empresa"] == $_SESSION['iduser']){
				
				$update_practica = "DELETE FROM buenas_practicas WHERE id_buena_practica=".$_GET['practica']."";
				
				$update_mejoras_practicas = "DELETE FROM buenas_practicas_mejoras where id_buena_practica=".$_GET['practica']."";
				//eliminarProyecto($_GET['proyecto']);
				if(mysql_query($update_practica) && mysql_query($update_mejoras_practicas)){
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>#MisProyectos'</script><?
				} else {
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>&error=notDelete#MisProyectos'</script><?
				}
			} else {
				?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?	
			}
		}

		elseif($_GET['acc']=='addpractica' && (isset($_POST['agregar']))){
			include_once("functions.php");
			if($_SESSION['tipo']==1){
				//print_r($_POST["idmejora"]); die();
				$update_bpractica = "INSERT INTO buenas_practicas 
				(id_rubro,titulo,diagnostico_inicial,resultado,financiamiento,solucion,inversion,amortizacion,consumo_proceso_previo,consumo_proceso_posterior,ahorro_energetico,ahorro_economico,id_empresa)
				VALUES
				('".$_POST['idrubro']."','".corregir($_POST['titulo'])."','".corregir(str_replace("\n","<br>",$_POST['diagnostico_inicial']))."',
				'".corregir(str_replace("\n","<br>",$_POST['resultado']))."','".corregir(str_replace("\n","<br>",$_POST['financiamiento']))."','".corregir(str_replace("\n","<br>",$_POST['solucion']))."',
				'".($_POST['inversion'])."','".($_POST['amortizacion'])."','".($_POST['consumo_proceso_previo'])."','".($_POST['consumo_proceso_posterior'])."',
				'".soloPorcentajes($_POST['ahorro_energetico'])."','".soloPorcentajes($_POST['ahorro_economico'])."','".$_SESSION['iduser']."')";
				
				if(mysql_query($update_bpractica)){
					
					$last_one = mysql_query("SELECT id_buena_practica FROM buenas_practicas WHERE id_empresa=".$_SESSION['iduser']." ORDER BY id_buena_practica DESC LIMIT 1");
					if(mysql_num_rows($last_one)>0){
						$rpp = mysql_fetch_array($last_one);
						if(strlen($_FILES['img_folder']['name'])>3){
							$partesx = explode('.',$_FILES['img_folder']['name']);
							$numx = count($partesx) - 1;
							$extensionx = $partesx[$numx];
							if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
								cargarPicBPractica($_FILES['img_folder'],$rpp['id_buena_practica']);
							} 
						} 
						
						if(count($_POST["idmejora"]) > 0){
							$practicas_mejoras = [];
							foreach($_POST["idmejora"] as $id_mejora){
								array_push($practicas_mejoras,"('".$rpp['id_buena_practica']."','".$id_mejora."')");
							}
							$update_practicas_mejoras = "
								INSERT INTO buenas_practicas_mejoras(id_buena_practica,id_mejora) 
								VALUES ".implode(",",$practicas_mejoras);
							//echo($update_practicas_mejoras); die();
							mysql_query($update_practicas_mejoras);
						}
					?>
					<script>location.href='index.php?id=bpracticas&practica=<?=$rpp['id_buena_practica']?>'</script><?
					} else {
						?>
						<script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?
					}
				} else {
					?>
					<script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?
				}
			} else {
				?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?	
			}
		}
		
		elseif($_GET['acc']=='updateMejoras' && (isset($_POST['updateP']))){
			if($_SESSION['tipo']==2){
				mysql_query("DELETE FROM mejoras_proveedores WHERE id_proveedor=".$_SESSION['iduser']."");
				for($i=0;$i<count($_POST['idmejora']);$i++){
					mysql_query("INSERT INTO mejoras_proveedores (id_mejora,id_proveedor) VALUES ('".$_POST['idmejora'][$i]."','".$_SESSION['iduser']."')");
				}
				$ver_mejoras_marcadas = mysql_query("SELECT id_mejora FROM mejoras_proveedores WHERE id_proveedor=".$_SESSION['iduser']." LIMIT 1");
				if(mysql_num_rows($ver_mejoras_marcadas)>0){
					$_SESSION['sinmejoras'] = "";
					unset($_SESSION['sinmejoras']);	
				} else {
					$_SESSION['sinmejoras'] = "NO";	
				}
				?><script>location.href='index.php?id=mismejoras'</script><?
			}
			?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?
		}
		
		elseif($_GET['acc']=='addFavorite' && isset($_GET['user']) && is_numeric($_GET['user'])){
			//ver que corresponda a proveedor.
			if($_GET["user"]==$_SESSION['iduser']){
				?><script>location.href='index.php?id=profile&user=<?=$_GET['user']?>&Fav=nok'</script><?
			} else {
				$ver_tipo_user = mysql_query("SELECT tipo FROM usuarios WHERE id_user=".$_GET["user"]." LIMIT 1");
				if(mysql_num_rows($ver_tipo_user)>0){
					$us = mysql_fetch_array($ver_tipo_user);
					if($us['tipo']==2){ 
						mysql_query("INSERT INTO proveedores_favoritos (id_user,id_proveedor) VALUES ('".$_SESSION['iduser']."','".$_GET['user']."')");
						?><script>location.href='index.php?id=profile&user=<?=$_GET['user']?>&Fav=ok'</script><?
					}
				}
				mysql_free_result($ver_tipo_user);
			}
		}
		
		elseif($_GET['acc']=='delFavorite' && isset($_GET['user']) && is_numeric($_GET['user'])){
			mysql_query("DELETE FROM proveedores_favoritos WHERE id_user=".$_SESSION['iduser']." AND id_proveedor=".$_GET['user']."");
			?><script>location.href='index.php?id=profile&user=<?=$_GET['user']?>'</script><?		
		}
		
		elseif($_GET['acc']=='addMejoraFavorite' && isset($_GET['mejora']) && is_numeric($_GET['mejora'])){
			//ver que exista mejora.
			$ver_existe_mejora = mysql_query("SELECT id_mejora FROM mejoras WHERE id_mejora=".$_GET["mejora"]." LIMIT 1");
			if(mysql_num_rows($ver_existe_mejora)>0){
				mysql_query("INSERT INTO mejoras_favoritas (id_user,id_mejora) VALUES ('".$_SESSION['iduser']."','".$_GET['mejora']."')");
				?><script>location.href='index.php?id=mejoras&mejora=<?=$_GET['mejora']?>'</script><?	
			} else {
				?><script>location.href='index.php?id=mejoras&mejora=<?=$_GET['mejora']?>'</script><?
			}
			mysql_free_result($ver_existe_mejora);	
		}
		
		elseif($_GET['acc']=='delMejoraFavorite' && isset($_GET['mejora']) && is_numeric($_GET['mejora'])){
			mysql_query("DELETE FROM mejoras_favoritas WHERE id_user=".$_SESSION['iduser']." AND id_mejora=".$_GET['mejora']."");
			?><script>location.href='index.php?id=mejoras&mejora=<?=$_GET['mejora']?>'</script><?			
		}
		
		elseif($_GET['acc']=='addcatalogo' && (isset($_POST['agregar']))){
			include_once("functions.php");
			if($_SESSION['tipo']==2){
				$update_catalogo = "INSERT INTO catalogos (nombre,id_proveedor) VALUES ('".corregir($_POST['titulo'])."','".$_SESSION['iduser']."')";
				
				if(count($_POST['idmejora'])>3){
					?><script>location.href='index.php?id=addcatalogo&error=limit'</script><?
				} else {
					if(mysql_query($update_catalogo)){
						
						$last_one = mysql_query("SELECT id_catalogo FROM catalogos WHERE id_proveedor=".$_SESSION['iduser']." ORDER BY id_catalogo DESC LIMIT 1");
						if(mysql_num_rows($last_one)>0){
							$rpp = mysql_fetch_array($last_one);
							
							for($i=0;$i<count($_POST['idmejora']);$i++){
								mysql_query("INSERT INTO mejoras_catalogos (id_catalogo,id_mejora) VALUES ('".$rpp['id_catalogo']."','".$_POST['idmejora'][$i]."')");
							}
							if(strlen($_FILES['archivo']['name'])>3){
								cargarCatalogo($_FILES['archivo'],$rpp['id_catalogo']);
							} 
							// email informando a usuarios / seguidores de que se ha subido un catalogo de su interés. Segun mejoras favoritas!
							
							//////////////////////////////// Email //////////////////////////////////
							$Ver_catalogos = mysql_query("SELECT catalogos.nombre as titulo, usuarios.id_user as id_user, catalogos.id_catalogo, usuarios.nombre as nameuser, 
							usuarios.email as email_user, catalogos.archivo
							FROM catalogos,mejoras_favoritas,mejoras_catalogos,usuarios
							WHERE mejoras_catalogos.id_mejora=mejoras_favoritas.id_mejora AND mejoras_favoritas.id_user=usuarios.id_user AND usuarios.correo_catalogos=1 AND 
							catalogos.id_catalogo=mejoras_catalogos.id_catalogo AND catalogos.id_catalogo=".$rpp['id_catalogo']." GROUP BY mejoras_favoritas.id_user");
							
							$data_proveedor = mysql_query("SELECT nombre FROM usuarios WHERE id_user=".$_SESSION['iduser']." LIMIT 1");
							$nombre_proveedor = mysql_result($data_proveedor,0);
							
							if(mysql_num_rows($Ver_catalogos)>0){
								while($inter = mysql_fetch_array($Ver_catalogos)){
								
									$mis_mejoras = "";
									$texto_mis_mejoras = "";
									$intereses_que_calzan = mysql_query("SELECT mejoras.nombre as titulo 
									FROM mejoras,mejoras_favoritas,mejoras_catalogos
									WHERE mejoras_catalogos.id_mejora=mejoras_favoritas.id_mejora AND mejoras_favoritas.id_mejora=mejoras.id_mejora 
									AND mejoras_favoritas.id_user=".$inter['id_user']." AND mejoras_catalogos.id_catalogo=".$rpp['id_catalogo']."");
									if(mysql_num_rows($intereses_que_calzan)>0){
										while($inc = mysql_fetch_array($intereses_que_calzan)){
											$mis_mejoras .= "- ".$inc['titulo']."<br>";	
										}
									}
									if(mysql_num_rows($intereses_que_calzan)>1){
										$texto_mis_mejoras = "tus intereses en";
									} else {
										$texto_mis_mejoras = "tu inter&eacute;s en";
									}
								
									$url_web = "http://".$_SERVER['HTTP_HOST'];
								
									$mensaje_email = "
									Estimado ".$inter['nameuser'].",<br>
									El proveedor ".$nombre_proveedor.", acaba de subir un nuevo cat&aacute;logo que calza con ".$texto_mis_mejoras .":
									<br><br>
									".$mis_mejoras." 
									<br>
									Si quieres revisarlo, puedes visitar el siguiente link:<br>
									<a href='".$url_web."/index.php?id=profile&user=".$_SESSION['iduser']."#MisCatalogos'>".$url_web."/index.php?id=profile&user=".$_SESSION['iduser']."#MisCatalogos</a>
									<br><br>
									Recuerda que para descargar los cat&aacute;logos, debes haber iniciado sesi&oacute;n.
									<br><br>
									Saludos del equipo de Smart Energy Concept.
									";
									
									$headers = "Content-type: text/html; charset=utf-8\r\n";
									$headers .= "From: noreply@".$_SERVER['HTTP_HOST'];
									$asunto = "Nuevo catalogo en Smart Energy Concept";
									mail(trim($inter['email_user']),$asunto, $mensaje_email, $headers);
									//echo $mensaje_email."<br><br>".$inter['email_user']."<br>".$headers."<br><br><br>-----------------------------<br>";
								}
							}
							//////////////////////////////// Email //////////////////////////////////
							
							?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>#MisCatalogos'</script><?	
						} else {
							?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>#MisCatalogos'</script><?
						}
					} else {
						?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>#MisCatalogos'</script><?
					}
					
				}
					
			} else {
				?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?	
			}
		}
		
		elseif($_GET['acc']=='cargarimg' && (isset($_FILES['imagen_publica']))){
		
			function cargarfotoProducto($file_imagen,$principal){
				session_start();
				$image = $file_imagen['name'];
				$partes = explode('.',$file_imagen['name']) ;
				$num = count($partes) - 1 ;
				$extension = $partes[$num] ;
				$carpeta_index = "profiles/";
				$size_max = 36700000;
				$seedx = str_replace("-","",rand(000000000000000000,999999999999999999));
				$archivo_name = date('YmdHis')."_".$_SESSION['iduser'].$seedx.".".$extension;
				//eliminar las anteriores
				$ver_anteriores = mysql_query("SELECT id_img FROM imagenes WHERE id_user=".$_SESSION['iduser']." AND principal=1");
				while($imgant = mysql_fetch_array($ver_anteriores)){
					eliminar_foto_prod($imgant['id_img']);
				}
				
				if($file_imagen['size'] <= $size_max && !file_exists($carpeta_index.'/'.$archivo_name) && $extension == 'jpg' or $extension == 'gif' or $extension == 'GIF' or $extension == 'JPG' or $extension=='jpeg' or $extension=='JPEG' or $extension=='pjpeg' or $extension=='PJPEG' or $extension=='pjpg' or $extension=='PJPG' or $extension=='png' or $extension=='PNG'){
					if(move_uploaded_file($file_imagen['tmp_name'],$carpeta_index.'/'.$archivo_name)){
						$fecha = date("Y-m-d H:i:s");
						$SQL_ADDFOTO = "INSERT INTO imagenes (imagen,id_user,principal) VALUES ('".$archivo_name."','".$_SESSION['iduser']."','1')";
						mysql_query($SQL_ADDFOTO);
						resize_fotoProducto($archivo_name);
						//resize_mini_fotoProducto($archivo_name);
					}
				} else {
					echo 'Error: Ha superado el l&iacute;mite de peso por foto';
				}
			}
				
			function eliminar_foto_prod($idimg){
				session_start();
				$verify = mysql_query("SELECT id_img,imagen,principal FROM imagenes WHERE id_user=".$_SESSION['iduser']." AND id_img=".$idimg."");
				if(mysql_num_rows($verify)>0){
					$rr = mysql_fetch_array($verify);
					if($rr['principal']==1){ $_SESSION['profilepic'] = "img/unknown.png"; }
					
					$archivo1 = $rr['imagen'];
					$carpeta = "profiles/";
					if(file_exists($carpeta.$archivo1)){
						unlink($carpeta.$archivo1);
						
					}
					$sql_del_img = "DELETE FROM imagenes WHERE id_user=".$_SESSION['iduser']." AND id_img=".$idimg."";
					mysql_query($sql_del_img);
					return $rr['id_img'];
				}
			}

			function resize_fotoProducto($archivo_name){
				session_start();
				$directorio = "profiles/";
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
				
				$new_alto = 600;
				
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
					imagejpeg($thumb,$pot,85); 
				}
				if($extension=="gif" or $extension=="GIF"){ 
					imagecopyresampled($thumb, $original, 0, 0, 0, 0, $new_ancho, $new_alto, $ancho, $alto); 
					imagegif($thumb,$pot,85); 
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
			
			
			if(strlen($_FILES['imagen_publica']['name'])>3){
				$partesx = explode('.',$_FILES['imagen_publica']['name']);
				$numx = count($partesx) - 1;
				$extensionx = $partesx[$numx];
				if($extensionx == 'jpg' or $extensionx == 'gif' or $extensionx == 'GIF' or $extensionx == 'JPG' or $extensionx=='jpeg' or $extensionx=='JPEG' or $extensionx=='pjpeg' or $extensionx=='PJPEG' or $extensionx=='pjpg' or $extensionx=='PJPG' or $extensionx=='png' or $extensionx=='PNG' or $extensionx=='bmp' or $extensionx=='BMP'){
					cargarfotoProducto($_FILES['imagen_publica'],1);
					
					$img = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$_SESSION['iduser']." and principal=1 LIMIT 1");
					$pic = mysql_fetch_array($img);
					if(strlen($pic['imagen'])>10){
						$_SESSION['profilepic'] = "profiles/".$pic['imagen'];
					} else {
						$_SESSION['profilepic'] = "img/unknown.png";
					}
					mysql_free_result($img);
					
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?
				} else {
					?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?
				}
			} else {
				?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>&error=noupload'</script><?
			}
				
		}
		elseif($_GET['acc']=='cargar_mejoras' && isset($_GET['idrubro']) && is_numeric($_GET['idrubro']) && isset($_GET['pagina']) && strlen($_GET['capa'])>5 && is_numeric($_GET['pagina'])){
		include_once("functions.php");
		if($_GET['capa']=='mejoras_especificas'){
			$registros = 5;
			$pagina = $_GET['pagina'];
			$inicio = ($pagina - 1) * $registros;
			$kpi_resp = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora, rubros_mejoras.valoracion as valoracion, rubros_mejoras.id_rubro_mejora as id_rubro_mejora FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND mejoras.activo=1 AND rubros_mejoras.id_rubro=".$_GET['idrubro']." ORDER BY rubros_mejoras.valoracion DESC");
			$kpi = mysql_fetch_array($kpi_resp);
			$total_r = mysql_num_rows($kpi_resp);
			mysql_free_result($kpi_resp);
			$total_paginas = ceil($total_r / $registros);
			$mejoras_rubro = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora, rubros_mejoras.valoracion as valoracion, rubros_mejoras.id_rubro_mejora as id_rubro_mejora FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND mejoras.activo=1 AND rubros_mejoras.id_rubro=".$_GET['idrubro']." ORDER BY rubros_mejoras.valoracion DESC LIMIT ".$inicio.",".$registros."");

		} else {
			$registros = 5;
			$pagina = $_GET['pagina'];
			$inicio = ($pagina - 1) * $registros;
			
			$kpi_resp = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora, rubros_mejoras.valoracion as valoracion, rubros_mejoras.id_rubro_mejora as id_rubro_mejora FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND mejoras.activo=1 AND rubros_mejoras.id_rubro=0  ORDER BY rubros_mejoras.valoracion DESC");
			$kpi = mysql_fetch_array($kpi_resp);
			$total_r = mysql_num_rows($kpi_resp);
			mysql_free_result($kpi_resp);
			$total_paginas = ceil($total_r / $registros);
			
			
			$mejoras_rubro = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora, rubros_mejoras.valoracion as valoracion, rubros_mejoras.id_rubro_mejora as id_rubro_mejora FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND mejoras.activo=1 AND rubros_mejoras.id_rubro=0  ORDER BY rubros_mejoras.valoracion DESC LIMIT ".$inicio.",".$registros."");
            
		}
		if(mysql_num_rows($mejoras_rubro)>0){
			while($mejora = mysql_fetch_array($mejoras_rubro)){
				?>
				<div class="lista_mejoras">
					<span>
					<a href="index.php?id=mejoras&mejora=<?=$mejora['id_mejora']?>"><?=$mejora['nombremejora']?></a>
					</span>
					<span></span>
				</div>
				<?
			}
		} else {
			?><div class="lista_mejoras"><br />No hay mejoras para este rubro<br /><br /></div><?	
		}
        paginar_resultados_ajax($_GET['capa'],$total_paginas,$_GET['pagina'],$_GET['idrubro']);
	}
	
	//}
	
}
?>