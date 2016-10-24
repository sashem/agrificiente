<?php
error_reporting(0);
//$dbh=mysql_connect("localhost","devcamch_wpadmin","Aig761656163.");
$dbh=mysql_connect("localhost","root","");
mysql_select_db("devcamch_wp");
mysql_query("SET NAMES 'utf8'");
//$menu_select = "SELECT * FROM wp1e_posts where post_type LIKE 'nav_menu_item' ORDER BY menu_order";

$menu_select = "select * from (select d.*,e.name,e.slug from(SELECT p.id,txr.term_taxonomy_id, p.post_title, p.post_name, p.guid, p.menu_order, n.post_name as n_name, n.post_title as n_title, pp.meta_value as menu_parent,pt.meta_value as type
FROM wp1e_term_relationships as txr 
INNER JOIN wp1e_posts as p ON txr.object_id = p.ID 
LEFT JOIN wp1e_postmeta as m ON p.ID = m.post_id 
LEFT JOIN wp1e_postmeta as pl ON p.ID = pl.post_id AND pl.meta_key = '_menu_item_object_id' 
LEFT JOIN wp1e_postmeta as pp ON p.ID = pp.post_id AND pp.meta_key = '_menu_item_menu_item_parent'
LEFT JOIN wp1e_postmeta as pt ON p.ID = pt.post_id AND pt.meta_key = '_menu_item_object'
LEFT JOIN wp1e_posts as n ON pl.meta_value = n.ID 
WHERE p.post_status='publish' 
AND p.post_type = 'nav_menu_item' AND m.meta_key = '_menu_item_url') d
LEFT JOIN wp1e_terms as e on d.term_taxonomy_id=e.term_id) i where i.term_taxonomy_id = 6 ORDER BY i.menu_order ASC" ;

//ORDER BY pp.meta_value
//$menu_items = ;

$menu = [];
$menu_query = mysql_query($menu_select);

while($item = mysql_fetch_array($menu_query)){
    //echo mb_detect_encoding($item["post_title"]);
    if($item["menu_parent"]!=0){
        if(!$menu[$item["menu_parent"]]["childs"]){$menu[$item["menu_parent"]]["childs"]=[];}
        $menu[$item["menu_parent"]]["childs"][$item["id"]]=[
            "titulo"=>$item["post_title"],
            "link"=>$item["n_name"]
            ];
    }
    else{$menu[$item["id"]] = [
            "titulo"=>$item["post_title"],
            "link"=>$item["n_name"]
            ];
        }
}

//echo "<pre>";
//print_r($menu);
//echo "</pre>";

//print_r($menu_items);
//echo "AAAAAAH!";

session_start();

include_once("config.php");


if(isset($_COOKIE['idkey']) && isset($_COOKIE['userkey']) && !isset($_SESSION['iduser']) && !isset($_SESSION['email']) && ($_COOKIE['idkey']!="" && $_COOKIE['userkey']!="") && ($_COOKIE['idkey']!="/" || $_COOKIE['idkey']!="")){
	$DBKEYCookie = mysql_query("SELECT * FROM cookies WHERE `ckey`='".$_COOKIE["userkey"]."' AND id_user=".$_COOKIE['idkey']." LIMIT 1");
	if(mysql_num_rows($DBKEYCookie)>0){
		$DBKEYUSERINFO = mysql_query("SELECT id_user,email,tipo FROM usuarios WHERE id_user=".$_COOKIE['idkey']." LIMIT 1");
		if(mysql_num_rows($DBKEYUSERINFO)>0){
			$keyinfous = mysql_fetch_array($DBKEYUSERINFO);
			$_SESSION['iduser'] = $keyinfous['id_user'];
			$_SESSION['email'] = $keyinfous['email'];
			$_SESSION['tipo'] = $keyinfous['tipo'];
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
		}
	}
}

//VISTAS PROTEGIDAS POR SESIÓN
//if((isset($_SESSION["iduser"]) && isset($_SESSION["email"])) || $_GET['id']=='registro' || $_GET['id']=='lostpass'){
	
include_once("functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<base href="http://www.agrificiente.cl/plataforma/" target="_self">-->
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Energy Concepts</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link href="css/icones.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="img/ico.ico" type="image/x-icon" >

<? if($_GET['id']=='home' || $_GET['id']=='newthread' || $_GET['id']=='users'){ ?>
<link rel="stylesheet" href="css/cs-select.css">
<link rel="stylesheet" href="css/cs-skin-border.css">
<? } ?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script src="js/slick.min.js"></script>
<link rel="stylesheet" href="css/menu.css">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/slick.css">
<link rel="stylesheet" href="css/slick-theme.css">

<? if($_GET['id']=='addproyecto' || $_GET['id']=='editproyecto'){ ?>
<link href="css/glDatePicker.default.css" rel="stylesheet" type="text/css">
<script src="js/glDatePicker.js"></script>
<? } ?>



</head>



<body>
    <div id='cssmenu'>
        <ul class="FirstOpen">   
            <li><a href="index.php?id=home" class="enlace <? if($_GET['id']=='home' || !isset($_GET['id'])){ ?>activo<? }?>">Rubros</a></li>
            <li><a href="index.php?id=users&us=empresas" class="enlace <? if($_GET['us']=='empresas'){ ?>activo<? }?>">Productores</a></li>
            <li><a href="index.php?id=users&us=proveedores" class="enlace <? if($_GET['us']=='proveedores'){ ?>activo<? }?>">Proveedores</a></li>
            <li><a href="index.php?id=discusiones" class="enlace <? if($_GET['id']=='discusiones'){ ?>activo<? }?>">Discusiones</a></li>
            <li><a href="index.php?id=diagnostico" class="enlace <? if($_GET['id']=='diagnostico'){ ?>activo<? }?>">Diagn&oacute;stico</a></li>
            <li><a href="index.php?id=eventix" class="enlace <? if($_GET['id']=='eventos'){ ?>activo<? }?>">Eventos</a></li>
            <? if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){ ?>                         
            <li class='has-sub'><a href='#'>Mi cuenta</a>
                <ul>
                    <li><a href="index.php?id=profile&user=<?=$_SESSION["iduser"]?>"><span class="icon-user"></span> Mi Perfil</a></li>
                    <li><a href="index.php?id=editprofile"><span class="icon-pencil"></span> Editar Perfil</a></li>
                    <li><a href="index.php?id=intereses"><span class="icon-pencil"></span> Mis Intereses</a></li>
                    <? if($_SESSION['tipo']==2){ ?><li><a href="index.php?id=mismejoras"><span class="icon-pushpin"></span> Mis Mejoras</a></li><? } ?>
                    <li><a href="logout.php"><span class="icon-switch"></span> Salir</a></li>
                </ul>
            </li>
            <? } else { ?>
            <!--<li><a href="index.php" class="enlace">Entrar</a></li>-->
            <? } ?>
        </ul>
    </div>
    
    
    <?

    if(isset($_SESSION['sinmejoras']) || $_SESSION['sinmejoras']=="NO"){
	   ?>
    	<div class="warning"><center>No has seleccionado a&uacute;n las mejoras que provees. <a href="index.php?id=mismejoras"><strong>Seleccionalas aqu&iacute;</strong></a></center></div>
        <?
	} 
	?>
            <div class="webpage">
                <div class="webtop">
                    

                    <div class="top-logo-container"><a class="logo_header" href="index.php"><img src="img/logo.png" border="0" class="logoimg" /></a></div>
                    
                    <nav role="navigation" class="site-navigation main-navigation primary use-sticky-menu">
                        <div class="main-menu">
                            <ul class="menu">
                            <? foreach ($menu as $item){
                                if($item["childs"]) $cl = "menu-item-has-children"
                                ?>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom <?=$cl?>"> 
                                    <a href="http://www.agrificiente.cl/<?=$item["link"]?>"><?=$item["titulo"]?></a>
                                    <? if($item["childs"]){ ?>
                                        <ul class="submenu" style=""> 
                                        <? foreach($item["childs"] as $submenu_item){ ?>
                                            <li class="menu-item menu-item-type-post_type menu-item-object-page">
                                                <a href="http://www.agrificiente.cl/<?=$submenu_item["link"]?>">
                                                    <?=$submenu_item["titulo"]?>
                                                </a>
                                            </li>    
                                        <? } ?>
                                        </ul> 
                                    <? } ?>
                                </li>

                            <?}?>
                            </ul>
                        </div>
                    </nav>

                    <!--<div class="menutop menuxi">
                        <ul>
                            <li class="nivel1"><a href="index.php?id=home" class="enlace <? if($_GET['id']=='home'){ ?>activo<? }?>">Rubros</a></li>
                            <li class="nivel1"><a href="index.php?id=users&us=empresas" class="enlace <? if($_GET['us']=='empresas'){ ?>activo<? }?>">Productores</a></li>
                            <li class="nivel1"><a href="index.php?id=users&us=proveedores" class="enlace <? if($_GET['us']=='proveedores'){ ?>activo<? }?>">Proveedores</a></li>
                            <li class="nivel1"><a href="index.php?id=discusiones" class="enlace <? if($_GET['id']=='discusiones' || $_GET['id']=='newthread'){ ?>activo<? }?>">Discusiones</a></li>
                            <li class="nivel1"><a href="index.php?id=diagnostico" class="enlace <? if($_GET['id']=='diagnostico'){ ?>activo<? }?>">Diagn&oacute;stico</a></li>
                            <li class="nivel1"><a href="index.php?id=eventix" class="enlace <? if($_GET['id']=='eventos'){ ?>activo<? }?>">Eventos</a></li>
                        </ul>
                    </div>-->
                    <div class="menuxi" style="float:right;">
                        <? if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){ ?>
                            <ul>
                                <li class="nivel1"><a href="#" class="enlace"><span class="icon-cog align-icotop"></span></a>
                                    <ul class="menu-propio">
                                    	<li><a href="index.php?id=profile&user=<?=$_SESSION["iduser"]?>"><span class="icon-user"></span> Mi Perfil</a></li>
                                        <li><a href="index.php?id=editprofile"><span class="icon-pencil"></span> Editar Perfil</a></li>
                                        <li><a href="index.php?id=intereses"><span class="icon-star-full"></span> Mis intereses</a></li>
                                        <? if($_SESSION['tipo']==2){ ?><li><a href="index.php?id=mismejoras"><span class="icon-pushpin"></span> Mis Mejoras</a></li><? } ?>
                                        <li><a href="logout.php"><span class="icon-switch"></span> Salir</a></li>
                                    </ul>
                                </li>
                                <li class="nivel11"><a href="index.php?id=profile&user=<?=$_SESSION["iduser"]?>"><img src="img/tr.gif" style="background:url(<?=$_SESSION['profilepic']?>) center top; background-size:cover" /></a></li>
                            </ul>
                        <? } else { ?>
                            <ul>
                                <!--<li class="nivel1"><a href="index.php" class="enlace">Entrar</a></li>-->
                            </ul>
                        <? } ?>
                    </div>
                </div>
            </div>
    	
                	
            <div class="webpage2">
            
                <div class="content">
                <?
                if(!isset($_GET['id']) || $_GET['id']=="") {
                    //@include("modules/home.php");
                    include_once("portada.php");
                } else {
                    if(file_exists("modules/".$_GET['id'].".php")) {
                        $id = htmlspecialchars(trim($_GET['id']));
                        $id = eregi_replace("<[^>]*>","",$id) ;
                        $id = eregi_replace(".*//","",$id) ;
                        @include("modules/".$_GET['id'].".php");
                    } else {
                        @include("modules/404.php");
                    }
                }
                ?>
                </div>
                
                <div class="footer">
					
					<!--<div id="middle">
                    Proyecto Smart Energy Concepts. Desarrollado por CAMCHAL. <br>
                    El Bosque Norte 440. Oficina 1302. Las Condes. Santiago. <br>
                    Tel. 56 (2) 2203 53 20 <br>
                    proyectos@camchal.cl<br>
					</div>-->
                </div>
            </div>


<? if($_GET['id']=='profile' || $_GET['id']=='diagnostico'){ ?>
<script>
$(document).ready(function() {
	$(".valido span").click(function() {
	  $(".valido").fadeOut("slow");
	});
	$(".invalido span").click(function() {
	  $(".invalido").fadeOut("slow");
	});
	$(".valido span").click(function() {
	  $(".valido").fadeOut("slow");
	});
});
</script>
<? } ?>


</body>
</html>
<? 
//} else {
	//include_once("portada.php");	
//}
?>
<? mysql_close($dbh); ?>
