<?
//if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
if(isset($_GET['user']) && is_numeric($_GET['user'])){
	$ver_tipo_user = mysql_query("SELECT id_user,tipo,email,nombre,telefono,cargo FROM usuarios WHERE id_user=".$_GET['user']." LIMIT 1");
	if(mysql_num_rows($ver_tipo_user)>0){
		$us = mysql_fetch_array($ver_tipo_user);
		if($us['tipo']==1){
			$empresa = mysql_query("SELECT * FROM empresas WHERE id_user=".$us['id_user']." LIMIT 1");
			$row = mysql_fetch_array($empresa);
			
			$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$us['id_user']." AND principal=1 LIMIT 1");
			$pic = mysql_fetch_array($ver_pic);
			
		?>
        <div class="circ_pic_out circulo_profile">
            <? if(strlen($pic['imagen'])>10){
                $profile_pic = "profiles/".$pic['imagen'];
            } else { 
                $profile_pic = "img/unknown_empresa.jpg";
            }
            ?>
            <span href="index.php?id=profile&user=<?=$user['id_user']?>" style="background-image:url(<?=$profile_pic?>)" class="circ_pic"></span>
            <? if(($us['id_user']==$_SESSION['iduser'])){ ?>
            <form method="post" action="acciones.php?acc=cargarimg" id="targetTI" enctype="multipart/form-data">
                <a class="custom-input-file icon-camera pos_pencil_edit">
                <input name="imagen_publica" id="fileTI" class="input-file" type="file">
                </a>
            </form>
            <? } ?>
        </div>
		<h1>Empresa: <?=$row['nombre']?>
		<? if($us['id_user']==$_SESSION['iduser']){ ?><a href="index.php?id=editprofile" class="iconedit"><span class="icon-pencil"></span> &nbsp; Editar</a><? } ?>
		</h1>
		<br />
        
		
		<div class="contenido">
			<h3>Datos Empresa</h3>
			<div class="group">
				<ul>
					<li><label>Nombre</label><span><?=$row['nombre']?></span></li>
					<li><label>Tel&eacute;fono</label><span><?=$row['telefono']?></span></li>
					<li><label>Email</label><span><?=$row['email']?></span></li>
					<li><label>Sitio web</label><span><a href="<?=$row['web']?>" target="_blank"><?=$row['web']?></a></span></li>
					<li><label>Rubro</label><span><?=$row['rubro']?></span></li>
				</ul>        
			</div>
		</div>
		
		
		<div class="contenido">
			<h3>Datos Usuario</h3>
			<div class="group">
				<ul>
					<li><label>Nombre</label><span><?=$us['nombre']?></span></li>
					<li><label>Tel&eacute;fono</label><span><?=$us['telefono']?></span></li>
					<li><label>Email</label><span><?=$us['email']?></span></li>
					<li><label>Cargo</label><span><?=$us['cargo']?></span></li>
				</ul>        
			</div>
		</div>
		
        
        <h1>Mis Buenas pr&aacute;cticas
        <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?><a href="index.php?id=addpractica" class="iconedit"><span class="icon-plus"></span> &nbsp;Agregar Buena Pr&aacute;ctica</a><? } ?>
        </h1>
        <div class="contenido">
            <br />
            <?
            $buenas_practicas = mysql_query("SELECT buenas_practicas.*,empresas.nombre FROM buenas_practicas,empresas WHERE buenas_practicas.id_empresa=empresas.id_user AND buenas_practicas.id_empresa=".$_GET['user']." ORDER BY id_buena_practica DESC");
            if(mysql_num_rows($buenas_practicas)>0){
                ?>
                <div class="group noborder buenas_practicas proyectos_li">
                    <ul>
                <?
                while($bpr = mysql_fetch_array($buenas_practicas)){
                    if(strlen($bpr['img_folder'])>3){ $imagen_practica = "buenas_practicas/".$bpr['img_folder']; } else { $imagen_practica = "img/unknown_practica.png"; }
                    ?>
                    <li>
                        <label><a href="index.php?id=bpracticas&practica=<?=$bpr['id_buena_practica']?>"><img src="<?=$imagen_practica?>" class="img_mejora" /></a></label>
                        <span><br />
                            <h4><a href="index.php?id=bpracticas&practica=<?=$bpr['id_buena_practica']?>"><?=$bpr['titulo']?></a></h4><br />
                            Empresa: <?=$bpr['nombre']?><br />
                            Ahorro energ&eacute;tico: <?=$bpr['ahorro_energetico']?>%<br />
                            Ahorro econ&oacute;mico: <?=$bpr['ahorro_economico']?>%<br />
                            <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?><a href="index.php?id=editpractica&practica=<?=$bpr['id_buena_practica']?>" class="btn">Editar</a><? } ?>
                            <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?> 
                            <a href="acciones.php?acc=delpractica&practica=<?=$bpr['id_buena_practica']?>" class="btn">Eliminar</a>
                            <? } ?>
                        </span>
                    </li>
                    <?
                }
                ?>
                    </ul>
                </div>
                <?
            } else {
                if(isset($_SESSION['iduser']) && ($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser']))){ ?>
				<br />No has cargado buenas pr&aacute;cticas por el momento
				<? } else { ?>
                <br />Sin pr&aacute;cticas por el momento
                <? 
				}
            }
            ?>  
        </div>
        
        
        
        
        
        
        
        
        
		<? 
		} elseif($us['tipo']==2){ 
		
			$proveedor = mysql_query("SELECT * FROM proveedores WHERE id_user=".$us['id_user']." LIMIT 1");
			$row = mysql_fetch_array($proveedor);
			$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$us['id_user']." AND principal=1 LIMIT 1");
			$pic = mysql_fetch_array($ver_pic);
			
		?>
        <? if($_GET['Fav']=='nok'){ ?>
        <div class="invalido marginbottom">No puedes agregarte a ti a favoritos<span>x</span></div>
        <? } elseif($_GET['Fav']=='ok') { ?>
        <div class="valido marginbottom">Proveedor agregado a tus favoritos<span>x</span></div>
        <? } ?>
        
        <div class="circ_pic_out circulo_profile">
            <? if(strlen($pic['imagen'])>10){
                $profile_pic = "profiles/".$pic['imagen'];
            } else { 
                $profile_pic = "img/unknown_empresa.jpg";
            }
            ?>
            <span href="index.php?id=profile&user=<?=$user['id_user']?>" style="background-image:url(<?=$profile_pic?>)" class="circ_pic"></span>
            <? if($us['id_user']==$_SESSION['iduser']){ ?>
            <form method="post" action="acciones.php?acc=cargarimg" id="targetTI" enctype="multipart/form-data">
                <a class="custom-input-file icon-pencil pos_pencil_edit">
                <input name="imagen_publica" id="fileTI" class="input-file" type="file">
                </a>
            </form>
            <? } ?>
        </div>
        <?
        $ver_favorito = mysql_query("SELECT id_user FROM proveedores_favoritos WHERE id_user=".$_SESSION['iduser']." AND id_proveedor=".$_GET['user']." LIMIT 1");
		if(mysql_num_rows($ver_favorito)>0){ $esFav= "fav_active"; $addto = "Eliminar de favoritos"; $linkFav= "delFavorite"; } else { $esFav= ""; $addto = "Agregar a favoritos"; $linkFav= "addFavorite"; }
		mysql_free_result($ver_favorito);
		?>
		<? if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){ ?>
            <a href="acciones.php?acc=<?=$linkFav?>&user=<?=$us['id_user']?>" class="icon-heart favorite <?=$esFav?>" title="<?=$addto?>"></a>
        <? } ?>
		<h1>Proveedor: <?=$row['nombre']?>
		<? if($us['id_user']==$_SESSION['iduser']){ ?><a href="index.php?id=editprofile" class="iconedit"><span class="icon-pencil"></span> &nbsp; Editar</a><? } ?>
		</h1>
		
        <div class="ratingblock">
            <ul id="unit_ul1" class="unit-rating" style="width:110px;">	
                <li class="current-rating" style="width:<?=get_rating($row['valoracion'])?>px;"></li>
            </ul>
        </div>
		
        <? if(strlen($row['descripcion'])>0){?>
        <div class="descripcion">
            <? echo $row["descripcion"]; ?>
        </div>
		<? } ?>

		<div class="contenido">
			<h3>Datos Usuario</h3>
			<div class="group">
				<ul>
                	<li><label>Nombre</label><span><?=$us['nombre']?></span></li>
					<li><label>Tel&eacute;fono</label><span><?=$us['telefono']?></span></li>
					<li><label>Email</label><span><?=$us['email']?></span></li>
					<li><label>Cargo</label><span><?=$us['cargo']?></span></li>
				
				</ul>
            </div>
            <br />
            <h3>Datos Proveedor</h3>
			<div class="group">  
                <ul>
                	<li><label>Nombre</label><span><?=$row['nombre']?></span></li>
					<li><label>Tel&eacute;fono</label><span><?=$row['telefono']?></span></li>
					<li><label>Email</label><span><?=$row['email']?></span></li>
					<li><label>Sitio web</label><span><a href="<?=$row['web']?>" target="_blank"><?=$row['web']?></a></span></li>   
                </ul>    
			</div>
		</div>
        
        <a href="#" name="MisProyectos"></a>
        <h1>Proyectos
        <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?><a href="index.php?id=addproyecto" class="iconedit"><span class="icon-plus"></span> &nbsp;Agregar Proyecto</a><? } ?>
        </h1>
        <div class="contenido">
            <br />
            
            <?
            $proyectos = mysql_query("SELECT proyectos.* FROM proyectos,usuarios WHERE  proyectos.id_proveedor = usuarios.id_user AND usuarios.id_user=".$us['id_user'].""); 
			if(mysql_num_rows($proyectos)>0){
                ?>
                <div class="group noborder buenas_practicas proyectos_li">
                    <ul>
                <?
                while($proy = mysql_fetch_array($proyectos)){
                    if(strlen($proy['img_folder'])>3){ $imagen_practica = "proyectos/".$proy['img_folder']; } else { $imagen_practica = "img/unknown_practica.png"; }
                    ?>
                    <li>
                        <label><a href="index.php?id=proyectos&proyecto=<?=$proy['id_proyecto']?>"><img src="<?=$imagen_practica?>" class="img_mejora" /></a></label>
                        <span><br />
                        	<h4><a href="index.php?id=proyectos&proyecto=<?=$proy['id_proyecto']?>"><?=$proy['nombre']?></a></h4><br />
                            <label>Ahorro global</label><span><?=$proy['porcentaje_ahorro']?>%</span><br />
                            <label>Payback esperado</label><span><?=$proy['payback_esperado']?> a&ntilde;os</span><br />
                        	<? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?>
                            <a href="index.php?id=editproyecto&proyecto=<?=$proy['id_proyecto']?>" class="btn">Modificar</a>
                            <? } ?>
                            <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?> 
                            <a href="acciones.php?acc=delproyecto&proyecto=<?=$proy['id_proyecto']?>" class="btn">Eliminar</a>
                            <? } ?>
                       	</span>
                    </li>
                    <?
                }
                ?>
                    </ul>
                </div>
                <?
            } else {
                ?><br />No hay proyectos<?
            }
            ?>  
        </div>
        
        
		<a href="#" name="MisCatalogos"></a>
		<h1>Cat&aacute;logos y promociones
        <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?>
        <a href="index.php?id=addcatalogo" class="iconedit"><span class="icon-plus"></span> &nbsp;Agregar Cat&aacute;logo</a>
		<? } ?>
       	</h1>
		<div class="contenido">
			<br />
            <?
            $catalogos = mysql_query("SELECT *,DATE_FORMAT(fecha, '%d/%m/%Y') as fecha FROM catalogos WHERE id_proveedor = ".$us['id_user'].""); 
			if(mysql_num_rows($catalogos)>0){
                ?>
                <div class="group noborder buenas_practicas proyectos_li catalogos">
                    <ul>
                <?
                while($cat = mysql_fetch_array($catalogos)){
                    if(strlen($bpr['img_folder'])>3){ $imagen_practica = "proyectos/".$bpr['img_folder']; } else { $imagen_practica = "img/unknown_practica.png"; }
                    ?>
                    <li>
                        <h4><a href="catalogos/<?=$cat['archivo']?>"><?=$cat['nombre']?></a></h4><br />
                        <span class="icon-clock"></span> &nbsp; <?=$cat['fecha']?><br />
                        <a href="catalogos/<?=$cat['archivo']?>" class="btn" target="_blank">Descargar</a>
                        <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?>
                        <a href="acciones.php?acc=delcatalogo&catalogo=<?=$cat['id_catalogo']?>" class="btn">Eliminar</a>
                        <? } ?>
                    </li>
                    <?
                }
                ?>
                    </ul>
                </div>
                <?
            } else {
                ?><br />No hay cat&aacute;logos por el momento<?
            }
            ?>
		</div>
        
        
        
        
        
        
        
        
        
        
        <h1>Mejoras que provee
        <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?>
        <a href="index.php?id=mismejoras" class="iconedit"><span class="icon-plus"></span> &nbsp;Editar</a>
		<? } ?>
       	</h1>
		<div class="contenido">
			<br />
            <?
			$veR_mejoras = mysql_query("SELECT * FROM mejoras,mejoras_proveedores WHERE mejoras_proveedores.id_proveedor = ".$us['id_user']." AND mejoras.id_mejora=mejoras_proveedores.id_mejora AND mejoras.activo=1 
                /*AND mejoras_proveedores.id_proveedor=".$_SESSION['iduser']."*/ ORDER BY nombre ASC");
			if(mysql_num_rows($veR_mejoras)>0){
				?>
				<div class="twocols">
					<ul class="mismejoras">
					<?
					while($mejora = mysql_fetch_array($veR_mejoras)){
						
						$ver_mejoras_marcadas = mysql_query("SELECT id_mejora FROM mejoras_proveedores WHERE id_proveedor=".$_SESSION['iduser']." AND id_mejora=".$mejora['id_mejora']." LIMIT 1");
						$marcado = '';
						//if(mysql_num_rows($ver_mejoras_marcadas)>0){ $marcado = 'checked="checked"'; } 
						?>
						<li>
							<span class="icon-pushpin"></span>
							<a href="index.php?id=mejoras&mejora=<?=$mejora['id_mejora']?>"> &nbsp; <?=$mejora['nombre']?></a>
						</li>
						<?
					}
					?>
					</ul>
				</div>
				<br />
				<?
			} else {
				echo '<div id="error">No hay mejoras en la base de datos.</div>';	
			}
			?>
		</div>
        
        
        
        
        
        
        <h1>Evaluaciones</h1><a name="votes"></a>
        <? if($_GET['error']=='alreadyexists'){ ?>
        <div class="invalido">Ya votaste por este proveedor. Para reintentar, debes eliminar tu voto anterior.<span>x</span></div>
        <? } elseif($_GET['error']=='own'){ ?>
		<div class="invalido">No puedes votar por ti.<span>x</span></div>
		<? } ?>       
        <div class="contenido">
        	<br />
            <div class="group2">
                <?
                display_evaluaciones_proveedor($_GET['user']);
				?>
                <br /><br />
                <script src="js/validacion.js"></script>
                <? 
                     if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){ 
                        $accion_voto =  "acciones.php?acc=vote";
                     }else{
                        $accion_voto =  "acciones.php?acc=vote";
                     }
                ?>
                <? if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){ ?>
                    <form method="post" action="acciones.php?acc=vote" name="formi" onsubmit="return ValidarEvalProveedor()">
                    <h2>Eval&uacute;a este proveedor</h2>
                	<label>Nota de 1 a 5</label><br>
                    <div class="ratingblock">
                        <span style="display:none">
                        <input type="radio" name="rating" id="st-1" value="1" />
                        <input type="radio" name="rating" id="st-2" value="2" />
                        <input type="radio" name="rating" id="st-3" value="3" />
                        <input type="radio" name="rating" id="st-4" value="4" />
                        <input type="radio" name="rating" id="st-5" value="5" />
                        </span>
                        
                        <ul id="unit_ul1" class="unit-rating noborder" style="width:110px;">	
                            <li id="currentStar" class="current-rating" style="width:0px;"></li>
                            <?
                            for($i=1;$i<=5;$i++){ 
                            ?>
                            <li><label for="st-<?=$i?>" onclick="updateStaring(<?=$i?>)"><a class="r<?=$i?>-unit rater"><?=$i?></a></label></li>
                            <? } ?>
                        </ul>
                    </div>
                    <br /><br />
                    <label>Justifica tu calificaci&oacute;n</label><br /><br />
                    <textarea name="mensaje" class="justify"></textarea>
                    <div id="buttons"><input type="submit" name="vote" value="Evaluar Proveedor"></div>
                    <input type="hidden" name="proveedor" value="<?=$_GET['user']?>" />
                   	</form> 
                <? } ?>                
                
                
                    
            </div>
        </div>
		<? 
		} 
	} else {
		echo "<div id='error'>No existe usuario</div>";
	}
} else {
	echo "<div id='error'>Error de usuario</div>";
}
?>      
<script>
$(document).ready(function() {
	$('#fileTI').change(function() {
	  $('#targetTI').submit();
	});
});
</script>
<?
//}
?>
