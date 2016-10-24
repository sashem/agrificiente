<?
session_start();
include("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eventos Smart Energy Concepts</title>
<base href="http://www.agrificiente.cl/plataforma/" target="_self">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="img/ico.ico" type="image/x-icon" >
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
</head>

<body>
<?
$REFER_URL_NEXT = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<div class="subcontent">
	<div class="banner_top">
        <div>
        	<a href="index.php"><img src="img/logo.png" /></a>
        </div>
        
    </div>
    <?
    $data_evento = @mysql_query("SELECT *,
		DATE_FORMAT(fecha , '%d/%m/%Y') fecha, DATE_FORMAT(fecha , '%H:%i') horario
		FROM eventos WHERE id_evento=".$_GET['evento']." LIMIT 1");
		
	?>
    <div class="eventos_home">
	<div class="index_left eventos_div">
    	<?
        if(@mysql_num_rows($data_evento)>0){
			$row = mysql_fetch_array($data_evento);
		?>
    	<h1><?=$row['nombre']?></h1>
        <br />
        <img src="img_eventos/<?=$row['formato']?>" class="imgcenter" />
        <br />
        <div class="contenido">
            <div class="group">
                <div class="desc_evento">
                    <h4>Informaci&oacute;n del evento</h4>
                </div>
                <div class="lista_mejoras">
                    <span>Fecha</span>
                    <span><?=$row['fecha']?> - <?=$row['horario']?> hrs</span>
                </div>

                <? if($row['cupos_max']!=-1){ ?>
                <div class="lista_mejoras">
                    <span>Cupos</span>
                    <span><?=$row['cupos_max']?> &nbsp;&nbsp;
                    <?
                    $ver_si_hay_cupos_sql = mysql_query("SELECT id_evento FROM eventos_usuarios WHERE id_evento = ".$_GET['evento']."");
					$ver_invitados = mysql_query("SELECT nombre FROM invitados_eventos WHERE id_evento = ".$not['id_evento']."");
                    $cupos_usados = mysql_num_rows($ver_si_hay_cupos_sql) + mysql_num_rows($ver_invitados);
					$cupos_restantes = $row['cupos_max']-$cupos_usados;
					/*if($cupos_restantes>0){ 
						if($cupos_restantes==1){
							echo "<em>Queda 1 solo cupo</em>";
						} else {
							echo "<em>Quedan ".$cupos_restantes." cupos</em>";
						}
					}*/
					?>

                    </span>
                </div>
                <? } ?>
                <? if($row['costo']!=-1){ ?>
                <div class="lista_mejoras">
                    <span>Valor</span>
                    <span>$<?=str_replace(",",".",number_format($row['costo']))?></span>
                </div>
                <? } ?>
                
                <div class="lista_mejoras">
                    <span>Ubicaci&oacute;n</span>
                    <span><?=$row['localizacion']?></span>
                </div>
                <div class="lista_mejoras">
                    <span>Organizador</span>
                    <span><?=$row['organizador']?></span>
                </div>
                
                <div class="lista_mejoras">
                    <span>P&aacute;gina web</span>
                    <span><? if(strlen($row['pagina_web'])>9){ ?><a href="<?=$row['pagina_web']?>" target="_blank"><?=$row['pagina_web']?></a><? }?></span>
                </div>
                <div class="desc_evento">
                    <h4>Descripci&oacute;n</h4><br />
                    <?=$row['descripcion']?>
                </div>
                
            </div>
            
            
             	 	 	 	 	 	 	
            
        </div>
        <? } else { ?>
        <div id="error">Error: Este evento no existe</div>
        <? } ?>
    </div>
    <div class="index_right">

        <div class="user-form login_form login_index">
        <?
            if($_GET['error']=='inscrito'){
                ?><br /><div class="invalido">Ya est&aacute;s registrado en el evento <span>x</span></div><?
            } elseif($_GET['error']=='sincupos'){
                ?><br /><div class="invalido">Ya no hay cupos disponibles <span>x</span></div><?
            } elseif($_GET['register']=='ok') {
                ?><br /><div class="valido">Has sido registrado en el evento con &eacute;xito <span>x</span></div><?
            } elseif($_GET['unreg']=='ok') {
                ?><br /><div class="valido">Has sido dado de baja en el evento con &eacute;xito <span>x</span></div><?
            } elseif($_GET['error']=='noexiste') {
                ?><br /><div class="invalido">Evento inexistente o caducado <span>x</span></div><?
            }
        ?>
        </div>
        <?
        if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
		?>
        
        <div class="user-form login_form login_index">
        	
        	
        	<div class="titulo">
            <br />
            <strong>Ya has iniciado tu sesi&oacute;n</strong>
            </div>
        	<a href="index.php?id=profile&user=<?=$_SESSION["iduser"]?>"><img src="img/tr.gif" class="evento_profile_pic" style="background:url(<?=$_SESSION['profilepic']?>) center top; background-size:cover" /></a>
        	<br /><br />
            <? if(mysql_num_rows($data_evento)>0){ 
				$ver_existencia = mysql_query("SELECT id_evento FROM eventos_usuarios WHERE id_evento = ".$_GET['evento']." AND id_user=".$_SESSION['iduser']." LIMIT 1");
				if(mysql_num_rows($ver_existencia)>0){
					?>
					<div class="form-group" id="buttons">
                    	<input type="button" value="Ya no Asistir&eacute;" onclick="location.href='acciones.php?acc=desasistirEvento&evento=<?=$_GET['evento']?>'" />
                	</div>
					<?		
				} else {
					?>
					<div class="form-group" id="buttons">
                    	<input type="button" value="Asistir" onclick="location.href='acciones.php?acc=asistirEvento&evento=<?=$_GET['evento']?>'" />
                	</div>
					<?	
				}
			?>
            <? } ?>
            <div class="form-group">
            	<a href="index.php">Ir al sitio web</a> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="logout.php">Cerrar sesi&oacute;n</a> 
            </div>
        </div>
		<?
		} else {
		?>
        <form class="form-signin" role="form" name="form" method="post" action="entrar.php">
        <div class="user-form login_form login_index">
            <div class="titulo">
            <br /><br />
            <strong>Para inscribirte en el evento, primero debes iniciar sesi&oacute;n.<br><br>
                Si no tienes usuario, por favor reg&iacute;strate en el formulario de m&aacute;s abajo.
            </strong>
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" name="user" required autofocus>
            </div>
            <div class="form-group">
                <input type="password"  placeholder="Contrase&ntilde;a" name="pass" required>
            </div>
            <div class="form-group">
                <input type="checkbox" name="noclose" value="true" checked="checked"> No cerrar sesi&oacute;n
            </div>
            <div class="form-group" id="buttons">
                <input  name="entrar" type="submit" value="Entrar"></input>
            </div>
            <div class="form-group">
                <a href="index.php?id=lostpass">&iquest;Olvid&oacute; su Contrase&ntilde;a?</a> 
            </div>
        </div>
        	<input type="hidden" value="entrar" name="id">
            <input type="hidden" name="refer" value="<?=$REFER_URL_NEXT?>">
        </form>
        
        <form class="form-signin" role="form" name="form" method="post" action="index.php?id=registro_inscripcion">
        <div class="user-form login_form login_index">
        	<div class="titulo">
            
            
            
            
            <br />
            <strong>Registrarse como <span id="registeras">Productor</span></strong></div>
            <div class="form-group">
                <input type="text" placeholder="Nombre de empresa" name="nombre_empresa" required >
            </div>
            <div class="form-group">
                <input type="text" placeholder="Nombre de contacto" name="nombre" required >
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email de contacto" name="email" required >
            </div>


            <input type="radio" name="tipo" checked="checked" value="2" id="productor"/>
            <label for="productor" class="but-index" title="Entrar como productor" >Productor</label>
            <input type="radio" name="tipo" id="proveedor" value="1"  />
            <label for="proveedor" class="but-index" title="Entrar como proveedor" >Proveedor</label>

            <div class="form-group" style="text-align:justify;"><br>
                <p><input type="checkbox" disabled="disabled" checked="checked"> Deseo inscribirme en el evento.</p>
                <p><input type="checkbox" name="inscripcion" name=""> Deseo participar en la plataforma Agrificiente.</p>
            </div>
            <div class="form-group" id="buttons">
                <input name="registrar" type="submit" value="Registrarse">
                <input type="hidden" name="tipo" id="tipo_user" value="productor" />
                <input type="hidden" name="id_evento" value="<?=$_GET['evento']?>" />
                <input type="hidden" name="origen" value="evento" />
            </div>
            
        </div>
            <input type="hidden" name="refer" value="<?=$REFER_URL_NEXT?>">
        </form>
        <? } ?>
	</div>
    </div>
</div>
<div class="footer2"></div>
<script>
$(document).ready(function() {
	$("#productor").change(function() {
		if(this.checked) {
			document.getElementById('registeras').innerHTML = 'Productor';
			document.getElementById('tipo_user').value = 'productor';
			
		}
	});
	$("#proveedor").change(function() {
		if(this.checked) {
			document.getElementById('registeras').innerHTML = 'Proveedor';
			document.getElementById('tipo_user').value = 'proveedor';
		}
	});
});
</script>
<script>
$(document).ready(function() {
	$(".valido span").click(function() {
	  $(".valido").fadeOut("slow");
	});
	$(".invalido span").click(function() {
	  $(".invalido").fadeOut("slow");
	});
});
</script>   
            
</body>
</html>
