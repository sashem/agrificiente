<?php
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']="1"){

$select = mysql_query("SELECT user_name,email FROM admin WHERE id=1");
$row = mysql_fetch_array($select);
?>
<h1>Configuraci&oacute;n General</h1>

<form method="POST" action="funciones.php?acc=updatecontrol" autocomplete="OFF" enctype="multipart/form-data">
<div class="user-form form_extend2">
	<div class="titulo">Datos de acceso</div>
    <div class="form-group">
        <label>Usuario</label>
        <input type="text" name="user" value="<?=$row['user_name']?>">
    </div>
    <div class="form-group">
        <label>E-Mail</label>
        <input type="text" name="email" size="40" value="<?=$row['email']?>">
    </div>
    <div class="form-group">
        <label>Contrase&ntilde;a</label>
        <input type="password" name="pass">
    </div>
    <div class="form-group">
        <label>Confirmar Contrase&ntilde;a</label>
        <input type="password" name="pass2">
    </div>
    <div class="form-group" id="buttons">
    	<input type="submit" name="actualizar" value="Actualizar" class="send">
    </div>
</div>
</form>
<?
} else {
	?><script>location.href='http://www.google.cl';</script><?
}
?>
