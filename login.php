<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Energy Concepts</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="img/ico.ico" type="image/x-icon" >
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
</head>

<body>
<?
$REFER_URL_NEXT = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//$REFER_URL_NEXT = "http://".$_SERVER['HTTP_HOST']."/plataforma/index.php?".$_GET['ref'];
//echo($REFER_URL_NEXT);
?>
<div class="subcontent">
	<h2 class="centered_title">Debe iniciar sesión para ingresar a esta sección del sitio</h2>
    <div class="login_container">
        
        <form class="form-signin" role="form" name="form" method="post" action="entrar.php">
        <div class="user-form login_form login_index">
            <div class="titulo">
            <br /><br />
            <strong>Si ya tienes usuario, inicia sesi&oacute;n aqu&iacute;</strong>
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
        
        <form class="form-signin" role="form" name="form" method="post" action="index.php?id=registro">
        <div class="user-form login_form login_index">
        	<div class="titulo">
            
            <input type="radio" name="tipo" checked="checked" value="2" id="productor"/>
            <label for="productor" class="but-index" title="Entrar como productor" >Productor</label>
            <input type="radio" name="tipo" id="proveedor" value="1"  />
            <label for="proveedor" class="but-index" title="Entrar como proveedor" >Proveedor</label>
            
            <br /><br />
            <strong>Registrarse como <span id="registeras">Productor</span></strong></div>
            <div class="form-group">
                <input type="text" placeholder="Nombre de empresa" name="nombre_empresa" required >
            </div>
            <div class="form-group">
                <input type="text" placeholder="Cargo" name="cargo" required >
            </div>
            <div class="form-group">
                <input type="text" placeholder="Nombre de contacto" name="nombre" required >
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email de contacto" name="email" required >
            </div>
            <div class="form-group">
                <input type="text" placeholder="Tel&eacute;fono de contacto" name="telefono" required >
            </div>
            <div class="form-group" id="buttons">
                <input name="registrar" type="submit" value="Registrarse"></input>
                <input type="hidden" name="tipo" id="tipo_user" value="productor" />
            </div>
            
            
        </div>
            <input type="hidden" name="refer" value="<?=$REFER_URL_NEXT?>">
        </form>
        
	</div>
    
</div>
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
    
            
</body>
</html>
