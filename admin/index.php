<?php
session_start();
include("../config.php");

/*
if(isset($_GET['gm']) && is_numeric($_GET['gm']) && $_GET['gm']<6 && $_GET['gm']>=0){
	$_SESSION['gmenu'] = $_GET['gm'];
} else {
	if(!isset($_SESSION['gmenu'])){
		$_SESSION['gmenu'] = 1;
	}
}*/

if(isset($_SESSION['adminuser']) and isset($_SESSION['adminid'])){
include("funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/uploadfilemulti.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/admin.js"></script>
<script type="text/javascript" src="js/validacion.js"></script>

<script type="text/javascript" language="JavaScript1.2" src="js/bootstrap.js"></script>
<link href="css/bootstrap.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../slidebars/slidebars.min.css">

<script src="js/bootstrap3-typeahead.min.js"></script>

<link href="css/glDatePicker.default.css" rel="stylesheet" type="text/css">
<script src="js/glDatePicker.js"></script>

<link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="js/jquery.dataTables.min.js"></script>


<title>Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">


</head>

<body>
<div id="sb-site">
    <div class="top-side-bar">
        <div class="top-side-bar-in">
            <div class="sb-toggle-left navbar-left push-mobile">
                <div class="navicon-line"></div>
                <div class="navicon-line"></div>
                <div class="navicon-line"></div>
            </div>
            <div class="sb-icones">
                <script>
				if (document.referrer == "") {
					
				} else {
					document.write("<span onclick='history.back();' class='glyphicon glyphicon-chevron-left'></span>");
				}
				</script>
                <a href="index.php?id=users&gm=2" class="<? if($_GET['id']=='users' || $_GET['id']=='userficha' || $_GET['id']=='useredit'){ echo 'activem'; } ?>"><span class="glyphicon glyphicon-user"></span></a>
            </div>
            <div class="sidebar-logo">
                <a href="index.php?id=privacy"><span class="icon-cog align-icotop mobileicontop"></span></a>
            </div>
        </div>
    </div>



    <div class="new_top_banner">Panel de Admin</div>
    <div style="width:100%; clear:both;">
        <div class="new_menu border_right_bottom shadow">
            
            <div style="clear:both"></div>
            
            <div class="new_menu_title border_left_bottom border_left"><a href="#collapse1" data-toggle="collapse" data-parent="#accordion" aria-expanded="false"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>&nbsp; Men&uacute; Principal</a></div>
            <ul class="new_menu_enlaces panel-collapse collapse in" id="collapse1">
                <li><a href="index.php?id=control&gm=1">Configuraci&oacute;n</a><? if($_GET['id']=='control' || $_GET['id']=='' || !isset($_GET['id'])){ ?><span class="new_alt"></span><? } ?></li>
                <li><a href="../index.php" target="_blank">Visitar web</a></li>
                <li><a href="logout.php">Cerrar sesi&oacute;n</a></li>
            </ul>
            <div class="new_menu_title border_left_bottom border_left"><a href="#collapse2" data-toggle="collapse" data-parent="#accordion" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp; Administraci&oacute;n</a></div>
            <ul class="new_menu_enlaces panel-collapse collapse in" id="collapse2">
                <li><a href="index.php?id=users&gm=2" class="texto">Usuarios</a><? if($_GET['id']=='users' || $_GET['id']=='userficha' || $_GET['id']=='useredit'){ ?><span class="new_alt"></span><? } ?></li>
                <li><a href="index.php?id=rubros&gm=2" class="texto">Rubros</a><? if($_GET['id']=='rubros' || $_GET['id']=='rubroadd' || $_GET['id']=='rubroedit'){ ?><span class="new_alt"></span><? } ?></li>
                <li><a href="index.php?id=mejoras&gm=2" class="texto">Mejoras en rubro</a><? if($_GET['id']=='mejoras' || $_GET['id']=='rubromedit' || $_GET['id']=='rubromadd'){ ?><span class="new_alt"></span><? } ?></li>
                <li><a href="index.php?id=procesos&gm=2" class="texto">Procesos</a><? if($_GET['id']=='procesos' || $_GET['id']=='procesoedit'){ ?><span class="new_alt"></span><? } ?></li>
                <li><a href="index.php?id=eventos&gm=2" class="texto">Eventos</a><? if($_GET['id']=='eventos' || $_GET['id']=='eventoadd'  || $_GET['id']=='eventousers' || $_GET['id']=='eventoedit'){ ?><span class="new_alt"></span><? } ?></li>
                <li><a href="index.php?id=diagnosticos&gm=2" class="texto">Diagn&oacute;sticos</a><? if($_GET['id']=='diagnosticos' || $_GET['id']=='verdiagnostico'){ ?><span class="new_alt"></span><? } ?></li>
            </ul>
            
            
        </div>
        <div class="new_content_page">
           
                    
                    <?
                    if (!isset($_GET['id'])) {
                        include("modules/control.php");
                    } else {
                        if(file_exists("modules/".$_GET['id'].".php")) {
                            $id = htmlspecialchars(trim($_GET["id"]));
                            $id = eregi_replace("<[^>]*>","",$id) ;
                            $id = eregi_replace(".*//","",$id) ;
                            include("modules/".$id.".php");
                        } else {
                            include("modules/control.php");
                        }
                    }
                    ?>
                    <br /><br /><br />
                    
        </div>
    </div>

</div>

<div class="sb-slidebar sb-left sb-style-push" style="z-index:9999">

    <ul>      
    	<li><a href="index.php?id=control&gm=1" class="<? if($_GET['id']=='control' || $_GET['id']=='' || !isset($_GET['id'])){ ?>activo<? } ?>">Configuraci&oacute;n</a></li>         
        <li><a href="index.php?id=users&gm=2" class="<? if($_GET['id']=='users' || $_GET['id']=='userficha' || $_GET['id']=='useredit'){ ?>activo<? } ?>">Usuarios</a></li>
        <li><a href="index.php?id=rubros&gm=2" class="<? if($_GET['id']=='rubros' || $_GET['id']=='rubroadd' || $_GET['id']=='rubroedit'){ ?>activo<? } ?>">Rubros</a></li>
        <li><a href="index.php?id=mejoras&gm=2" class="<? if($_GET['id']=='mejoras' || $_GET['id']=='rubromedit' || $_GET['id']=='rubromadd'){ ?>activo<? } ?>">Mejoras en rubro</a></li>
        <li><a href="index.php?id=procesos&gm=2" class="<? if($_GET['id']=='procesos' || $_GET['id']=='procesoedit'){ ?>activo<? } ?>">Procesos</a></li>
        <li><a href="index.php?id=eventos&gm=2" class="<? if($_GET['id']=='eventos' || $_GET['id']=='eventoadd'  || $_GET['id']=='eventousers' || $_GET['id']=='eventoedit'){ ?>activo<? } ?>">Eventos</a></li>
        <li><a href="index.php?id=diagnosticos&gm=2" class="<? if($_GET['id']=='diagnosticos' || $_GET['id']=='verdiagnostico'){ ?>activo<? } ?>">Diagn&oacute;sticos</a></li>
        <li><a href="logout.php"><span class="icon-switch"></span> Salir</a></li>
        
        
    </ul>
</div>

<script src="../slidebars/slidebars.min.js"></script>
<script>
(function($) {
	$(document).ready(function() {
		$.slidebars();
	});
}) (jQuery);
</script>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<?          
mysql_close($dbh);
?>


<?
if($_GET['id']=='useredit'){ ?>
<script type="text/javascript" src="js/range.js"></script>
<script>
    (function () {

        var selector = '[data-rangeSlider]',
            elements = document.querySelectorAll(selector);

        // Example functionality to demonstrate a value feedback
        function valueOutput(element) {
            var value = element.value,
                output = element.parentNode.getElementsByTagName('output')[0];
            output.innerHTML = value;
        }

        for (var i = elements.length - 1; i >= 0; i--) {
            valueOutput(elements[i]);
        }

        Array.prototype.slice.call(document.querySelectorAll('input[type="range"]')).forEach(function (el) {
            el.addEventListener('input', function (e) {
                valueOutput(e.target);
            }, false);
        });


        rangeSlider.create(elements, {

            // Callback function
            onInit: function () {
            },

            // Callback function
            onSlideStart: function (value, percent,  position) {
                console.info('onSlideStart', 'value: ' + value, 'percent: ' + percent, 'position: ' + position);
            },

            // Callback function
            onSlide: function (value, percent,  position) {
                console.log('onSlide', 'value: ' + value, 'percent: ' + percent, 'position: ' + position);
            },

            // Callback function
            onSlideEnd: function (value, percent,  position) {
                console.warn('onSlideEnd', 'value: ' + value, 'percent: ' + percent, 'position: ' + position);
            }
        });

    })();
</script>
<? } 
?>
</body>
</html>

<?
} else {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>Admin</title>
</head>

<body bgcolor="#f0f0f0">
<br /><br /><br />
<script language="javascript" src="js/hash.js"></script>
<form name="form" id="form" action="login.php" method="post" onsubmit="document.getElementById('hash').value = hex_md5(document.getElementById('loginpass').value);">


<div class="login-form">
	<div class="titulo">Panel de Admin</div>
    <div class="form-group">
        <label>Usuario</label>
        <input type="text" name="loginadmin">
    </div>
    <div class="form-group">
        <label>Contrase&ntilde;a</label>
        <input type="password" id="loginpass">
    </div>
    <div class="form-group">
    	<input type="submit" class="btn btn-lg" name="entrar" value="Iniciar sesi&oacute;n">
    </div>
</div>

<?
if(isset($_GET['error']) && $_GET['error']=="false"){
?>
<br /><br />
<center><font class="error"><strong>Error</strong>: datos incorrectos</font></center>
<br /><br />
<? } ?>

<input type="hidden" name="hash" id="hash">
<input type="hidden" name="referer" value="<?='index.php?'.$_SERVER['QUERY_STRING'];?>" />
</form>

<div class="copyr">
<a href="http://www.segurihost.com/" onclick="return !window.open(this.href);">
    &copy; ACP por Segurihost 2005-<?=date("Y")?> - Todos los derechos reservados
</a>
</div>
</body>
</html>
<?
}
?>