<?
$SF_LIMITE_MENSAJERIA = 60;
if($_GET['id']=='leer'){
	function restar_notify_mensaje($id_user){
		mysql_query("UPDATE notificaciones SET mensajes=mensajes-1 WHERE id_user=".$id_user." AND mensajes>0");
		//mysql_query("UPDATE notificaciones SET mensajes=0 WHERE id_user=".$id_user." AND mensajes<0");
	}
}
function soloNumericos($str) {
	if ( eregi ( "[0-9.]", $str ) ) {
		$str = str_replace ( '%', '', ( $str ) );
		$str = str_replace ( ',', '.', ( $str ) );
	} else {
		$str = NULL;
	}
	return $str;
}
function consulta_mensajes($id_user){
	if(isset($_SESSION['iduser'])){
		$ver_mensajes_privados = mysql_query("SELECT mensajes FROM notificaciones WHERE id_user=".$id_user." LIMIT 1");
		if(mysql_num_rows($ver_mensajes_privados)>0){
			$obtener = mysql_fetch_array($ver_mensajes_privados);
			mysql_free_result($ver_mensajes_privados);
			if($obtener['mensajes']==0){
				return '';
			} elseif($obtener['mensajes']>99){
				return '<span class="new_notificacion">99+</span>';
			} else {
				return '<span class="new_notificacion">'.$obtener['mensajes'].'</span>';
			}
		} else {
			return '';
		}
	}
}
function get_rating($valor){
	$total = 110;
	$full = 5;
	$rating = $valor;
	$final = ($total*$rating)/$full;
	return $final;
}

function display_evaluaciones_proveedor($proveedor){
	$ver_replys = mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,evaluacion_proveedores.id_voto,evaluacion_proveedores.nota,evaluacion_proveedores.id_proveedor,evaluacion_proveedores.mensaje,DATE_FORMAT(evaluacion_proveedores.fecha,'%d/%m/%Y %H:%i') as fecha FROM evaluacion_proveedores,usuarios WHERE evaluacion_proveedores.id_user=usuarios.id_user AND usuarios.activo=1 AND evaluacion_proveedores.id_padre=0 AND evaluacion_proveedores.id_proveedor=".$proveedor." ORDER BY evaluacion_proveedores.id_voto DESC");
	if(mysql_num_rows($ver_replys)>0){
		$i=0;
		while($replys = mysql_fetch_array($ver_replys)){
		$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$replys['id_user']." AND principal=1 LIMIT 1");
		$pic = mysql_fetch_array($ver_pic);
		if(mysql_num_rows($ver_pic)>0){ $img_pic = "profiles/".$pic['imagen']; } else { $img_pic = "img/unknown_empresa.jpg"; }
			if(($i+1)==mysql_num_rows($ver_replys)){ echo '<a name="lastone"></a>'; }
		?>
		<div class="comment_box"><a href="#" name="ma<?=$replys['id_voto']?>"></a>
			<a href="index.php?id=profile&user=<?=$replys['id_user']?>" style="background-image:url(<?=$img_pic?>)" class="mini_circ_pic"></a>
			<div class="message_box_disc">
            	<?
                for($i=0;$i<$replys['nota'];$i++){ echo '<span class="icon-star-full"></span>'; }
				?>
                <? if(($replys['id_user']==$_SESSION['iduser']) || isset($_SESSION['adminuser'])){ ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a onclick="editVoto('Vt<?=$replys['id_voto']?>',<?=$replys['id_voto']?>,<?=$replys['id_proveedor']?>)" style="cursor:pointer" title="Editar comentario"><span class="icon-pencil"></span></a> &nbsp;&nbsp;&nbsp;
                <a onClick="if(!confirm('&iquest;Seguro de eliminar este comentario?')) { return false; }" href="acciones.php?acc=delvoto&voto=<?=$replys['id_voto']?>&proveedor=<?=$replys['id_proveedor']?>" title="Eliminar comentario"><span class="icon-bin"></span></a>
                <? } ?>
                <br />
				<span id="Vt<?=$replys['id_voto']?>"><?=$replys['mensaje']?></span><br />
				<i><span class="icon-clock"></span> &nbsp; <?=$replys['fecha']?><u>Autor: <?=$replys['usuarion']?></u>
				<u><a onclick="document.getElementById('m<?=$replys['id_voto']?>').style.display=''">Responder</a></u></i>
			</div>
            
			<?
			$ver_replys2 = mysql_query("
			SELECT usuarios.nombre as usuarion,usuarios.id_user,evaluacion_proveedores.id_voto,evaluacion_proveedores.mensaje,
			DATE_FORMAT(evaluacion_proveedores.fecha,'%d/%m/%Y %H:%i') as fecha FROM evaluacion_proveedores,usuarios WHERE 
			evaluacion_proveedores.id_user=usuarios.id_user AND usuarios.activo=1 AND evaluacion_proveedores.id_padre=".$replys['id_voto']." AND 
			evaluacion_proveedores.id_proveedor=".$proveedor." ORDER BY evaluacion_proveedores.id_voto ASC");
			
			while($replys2 = mysql_fetch_array($ver_replys2)){
				?>
				<div class="replyto"><a href="#" name="ma<?=$replys2['id_voto']?>"></a>
				<span class="icon-bubble"></span> <a href="index.php?id=profile&user=<?=$replys2['id_user']?>"><?=$replys2['usuarion']?></a>
                <? if(($replys2['id_user']==$_SESSION['iduser']) || isset($_SESSION['adminuser'])){ ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a onclick="editVoto('Vt<?=$replys2['id_voto']?>',<?=$replys2['id_voto']?>,<?=$replys['id_proveedor']?>)" style="cursor:pointer" title="Editar comentario"><span class="icon-pencil"></span></a> &nbsp;&nbsp;&nbsp;
                <a onClick="if(!confirm('&iquest;Seguro de eliminar este comentario?')) { return false; }" href="acciones.php?acc=delvoto&voto=<?=$replys2['id_voto']?>&proveedor=<?=$replys['id_proveedor']?>" title="Eliminar comentario"><span class="icon-bin"></span></a>
                <? } ?>
                <br />
				<span id="Vt<?=$replys2['id_voto']?>"><?=$replys2['mensaje']?></span>
				</div>
				<?
			}
			?>
			<span id="m<?=$replys['id_voto']?>" style="display:none">
			<form method="post" action="acciones.php?acc=replytovote">
				<input type="text" class="reply_box" name="mensaje" placeholder="Responder al usuario" />
				<input type="submit" name="replyt" class="btn floatright reply_button" value="Responder">
				<input type="hidden" name="id_padre" value="<?=$replys['id_voto']?>" />
				<input type="hidden" name="proveedor" value="<?=$proveedor?>" /> 
			</form>
			</span>
		</div>
	<?
		$i++;
		}
		mysql_free_result($ver_replys);
		mysql_free_result($ver_replys2);
	} else {
		echo "<center><br>No hay respuestas en este hilo<br></center>";
	}
			
}
/*
function consulta_accesos($id_user){
	if(isset($_SESSION['iduser'])){
		$ver_accesos_privados = mysql_query("SELECT accesos FROM notificaciones WHERE id_user=".$id_user." LIMIT 1");
		if(mysql_num_rows($ver_accesos_privados)>0){
			$obtener = mysql_fetch_array($ver_accesos_privados);
			mysql_free_result($ver_accesos_privados);
			if($obtener['accesos']==0){
				return '';
			} elseif($obtener['accesos']>99){
				return '<span class="new_notificacion">99+</span>';
			} else {
				return '<span class="new_notificacion">'.$obtener['accesos'].'</span>';
			}
		} else {
			return '';
		}
	}
}

function consulta_accesos_perfil($id_user){
	if(isset($_SESSION['iduser'])){
		$ver_accesos_privados = mysql_query("SELECT accesos_perfil FROM notificaciones WHERE id_user=".$id_user." LIMIT 1");
		if(mysql_num_rows($ver_accesos_privados)>0){
			$obtener = mysql_fetch_array($ver_accesos_privados);
			mysql_free_result($ver_accesos_privados);
			if($obtener['accesos_perfil']==0){
				return '';
			} elseif($obtener['accesos_perfil']>99){
				return '<span class="new_notificacion">99+</span>';
			} else {
				return '<span class="new_notificacion">'.$obtener['accesos_perfil'].'</span>';
			}
		} else {
			return '';
		}
	}
}
*/
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
function limpiar($str) {
	$banchars = array ("'", "--", "(","\n","\r", "\\");
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
function limpiar3($str) {
	$banchars = array ("'", ",", "--", ")", "(","\n","\r", "\\");
	$banwords = array (" or "," OR "," Or "," oR "," and ", " AND "," aNd "," aND "," AnD "); 
	if ( eregi ( "[a-zA-Z0-9]+", $str ) ) {
		$str = str_replace ( $banchars, '', ( $str ) );
		$str = str_replace ( $banwords, '', ( $str ) );
	} else {
		$str = NULL;
	}
	$str = trim($str);
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
if(($_GET['id']=='profile' && ((is_numeric($_GET['user']) && strlen($_GET['user'])>0) || strlen($_GET['nickname'])>0)) || $_GET['id']=='viewphoto'){
	function hasAccess($id_user){
		session_start();
		$ver_acceso = mysql_query("SELECT id_user_solicita FROM accesos WHERE id_user_solicita=".$_SESSION['iduser']." AND id_user_owner=".$id_user."");
		if(mysql_num_rows($ver_acceso)>0){
			return true;	
		} else {
			return false;
		}
	}
}
if($_GET['id']=='registro'){
	function update_KPI($usuarios,$imagenes,$contactos,$relatos,$confesiones){
		if($usuarios==true){
			$cant_users = mysql_query("SELECT id_user FROM users WHERE activo=1 AND suspendido=0");
			$cantidad = mysql_num_rows($cant_users);
			mysql_query("UPDATE kpi SET usuarios=".$cantidad." WHERE id_kpi=1");
			mysql_free_result($cant_users);
		} elseif($imagenes==true) {
			$cant_img = mysql_query("SELECT id_img FROM imagenes WHERE id_album=1");
			$cantidad = mysql_num_rows($cant_img);
			mysql_query("UPDATE kpi SET imagenes=".$cantidad." WHERE id_kpi=1");
			mysql_free_result($cant_img);
		} elseif($contactos==true) {
			$cant_con = mysql_query("SELECT id_contacto FROM contactos WHERE CURDATE()<=contactos.finaliza");
			$cantidad = mysql_num_rows($cant_con);
			mysql_query("UPDATE kpi SET contactos=".$cantidad." WHERE id_kpi=1");
			mysql_free_result($cant_con);
		} elseif($relatos==true) {
			$cant_rel = mysql_query("SELECT id_relato FROM relatos");
			$cantidad = mysql_num_rows($cant_rel);
			mysql_query("UPDATE kpi SET relatos=".$cantidad." WHERE id_kpi=1");
			mysql_free_result($cant_rel);
		} elseif($confesiones==true) {
			$cant_conf = mysql_query("SELECT id_confesion FROM confesiones");
			$cantidad = mysql_num_rows($cant_conf);
			mysql_query("UPDATE kpi SET confesiones=".$cantidad." WHERE id_kpi=1");
			mysql_free_result($cant_conf);
		}
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


function paginar_resultados_ajax($capa,$total_paginas,$pagina,$rubro){

?>
<div class="contenedor_paginas">
  		<ul class="pagination">
        <?
        if(($pagina - 1) > 0) {
           	?>
            <li><a onclick="cargar_mejoras(<?=$rubro?>,'<?=$capa?>',<?=($pagina-1)?>)">Ant</a></li>
            <?
        }
        if($total_paginas<=10){		
            for ($i=1; $i<=$total_paginas; $i++){
                if ($pagina == $i){
                    //echo '<li class="active"><a href="#">'.$pagina.'</a></li>';
					?><li class="active"><a href="#"><?=$i?></a></li><?
                } else {
                    //echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
					?><li><a onclick="cargar_mejoras(<?=$rubro?>,'<?=$capa?>',<?=($i)?>)"><?=$i?></a></li><?
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
                        //echo '<li class="active"><a href="#"><strong>'.$pagina.'</strong></a></li>';
						?><li><a onclick="cargar_mejoras(<?=$rubro?>,'<?=$capa?>',<?=($pagina)?>)"><?=$pagina?></a></li><?
                    } else {
                       	// echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
						?><li><a onclick="cargar_mejoras(<?=$rubro?>,'<?=$capa?>',<?=($i)?>)"><?=$i?></a></li><?
                    }
                } 
                if(($pagina+$move)<$total_paginas){ echo "<li><a>...</a></li>";	 }
            } elseif(($pagina+$move)>=$total_paginas && $pagina+$move<$total_paginas){	
                echo "<li><a>...</a></li>";	
                for ($i=($pagina-$move-1); $i<=($total_paginas); $i++){
                    if ($pagina == $i){
                        //echo '<li class="active"><a href="#"><strong>'.$pagina.'</strong></a></li>';
						?><li class="active"><a href="#"><?=$pagina?></a></li><?
                    } else {
						if($i>0){
                        	//echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
							?><li><a onclick="cargar_mejoras(<?=$rubro?>,'<?=$capa?>',<?=($i)?>)"><?=$i?></a></li><?
						} 
                        //echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
                    }
                } 
            } else {
                for ($i=1; $i<=($pagina+$move+1); $i++){
                    if ($pagina == $i){
                        //echo '<li class="active"><a href="#"><strong>'.$pagina.'</strong></a></li>';
						?><li class="active"><a href="#"><?=$pagina?></a></li><?
                    } else {
						if($i<=$total_paginas && $i>($pagina-$move)){ ///////////////
                        	//echo "<li><a href='index.php?id=".$get_id."&pag=".$i.$orden."'>".$i."</a></li>";
							?><li><a onclick="cargar_mejoras(<?=$rubro?>,'<?=$capa?>',<?=($i)?>)"><?=$i?></a></li><?
						}
                        
                    }
                } 
                //echo "<li><a>...</a></li>";	
				if(($pagina+$move)<$total_paginas){ echo "<li><a>...</a></li>"; } //// edited
            }
        }
        if(($pagina + 1)<=$total_paginas) {
            //echo "<li><a href='index.php?id=".$get_id."&pag=".($pagina+1).$orden."'>Siguiente</a></li>";
			?>
            <li><a onclick="cargar_mejoras(<?=$rubro?>,'<?=$capa?>',<?=($pagina+1)?>)">Sig</a></li>
            <?
        }
    
        ?>
        </ul>
</div>
<?
}


if($_GET['c']=="verNick" && strlen($_GET['nickn'])>2 && isset($_GET['nickn'])){
	@include("config.php");
	$ver_nick = mysql_query("SELECT nickname FROM users WHERE nickname='".trim($_GET['nickn'])."'");
	if(mysql_num_rows($ver_nick)>0){
		echo "si";	
	} else {
		echo "no";
	}
	mysql_free_result($ver_nick);
}
if($_GET['c']=="verNick2" && strlen($_GET['nickn'])>2 && isset($_GET['nickn'])){
	@session_start();
	@include("config.php");
	$ver_nick = mysql_query("SELECT nickname FROM users WHERE nickname='".trim($_GET['nickn'])."' AND id_user<>".$_SESSION['iduser']."");
	if(mysql_num_rows($ver_nick)>0){
		echo "si";	
	} else {
		echo "no";
	}
	mysql_free_result($ver_nick);
}
?>