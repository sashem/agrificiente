<? 
session_start();
$referencia = $_POST['refer'];
include_once("config.php");
include_once("functions.php");

function funcion($mensaje){
	$mensaje = str_replace("<","&lt;",$mensaje);
	$mensaje = str_replace(">","&gt;",$mensaje);
	$mensaje = str_replace("\'","&#39;",$mensaje);
	$mensaje = str_replace('\"',"&quot;",$mensaje);
	$mensaje = str_replace("\\\\","&#92",$mensaje);
	return $mensaje;
}

if(trim($_POST["user"]) != "" && trim($_POST["pass"]) != ""){

	$nick2 = funcion(limpiar2(trim($_POST["user"])));
	$clave2 = funcion(md5($_POST['pass']));

	$result3 = mysql_query("select id_user,clave,email,tipo from usuarios where email='".$nick2."' AND activo=1 LIMIT 1");
	
	if(mysql_num_rows($result3)>0){
		$row = mysql_fetch_array($result3);
		
			
		if(strcmp($row['clave'], $clave2) == 0){
	
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
			
			/* SET COOKIES */
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
			/* SET COOKIES */
			?>
            <html>
            <title>Iniciando sesi&oacute;n</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <link type="text/css" rel="stylesheet" href="css/style.css" />
            
            <body>
            <br><br><br> 
			<center><br><br><br>Has iniciado sesi&oacute;n correctamente<br><br>Ahora ser&aacute;s redireccionado a la p&aacute;gina principal.</center>
			<?
			if(isset($_POST['refer']) && $_POST['refer']!=NULL && $_POST['refer']!=""){	
			?>
				<SCRIPT LANGUAGE="javascript">location.href = "<?=$_POST['refer']?>";</SCRIPT>
			<? } else { ?>
				<SCRIPT LANGUAGE="javascript">location.href = "index.php";</SCRIPT>
			<?
			}
		} else {
			?>
            <html>
            <title>Error de sesi&oacute;n</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
            <link type="text/css" rel="stylesheet" href="css/style.css" />
            <body>
            <br><br><br> 
			<center><br><br>Error: Los datos son incorrectos</center>
            <?
		}
	} else {	
		?>
        <html>
        <title>Error de sesi&oacute;n</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <body>
        <br><br><br> 
        <center><br><br>El usuario no existe o se encuentra suspendido</center>
        <?
	}

	
	mysql_free_result($result3);
} else {
	?>
    <html>
    <title>Error de sesi&oacute;n</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <body>
    <br><br><br> 
	<center><br><br>Error: Debe especificar un Email y Contrase&ntilde;a</center>
    <?
}

mysql_close($dbh);

?>
<br><br><br>

<center><a href="javascript:history.go(-1)"><b>Volver Atr&aacute;s</b></a></center><br><br>
</body>
</html>