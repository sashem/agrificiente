<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){	
?>
<h1>Mis intereses</h1>
<div class="cxc">
<div class="contenido c2columnas cxc">
    <div class="group grid-item">
        <h2>Cat&aacute;logos</h2>
        <?
        $Ver_catalogos = mysql_query("SELECT catalogos.nombre as titulo, catalogos.id_catalogo, catalogos.archivo, DATE_FORMAT(catalogos.fecha,'%d/%m/%Y %H:%i')  as fecha
		FROM catalogos,mejoras_favoritas,mejoras_catalogos 
		WHERE mejoras_catalogos.id_mejora=mejoras_favoritas.id_mejora AND 
		catalogos.id_catalogo=mejoras_catalogos.id_catalogo AND mejoras_favoritas.id_user=".$_SESSION['iduser']." GROUP BY catalogos.id_catalogo ORDER BY catalogos.fecha DESC LIMIT 5");
		if(mysql_num_rows($Ver_catalogos)>0){
			?>
            <ul class="lista_procesos lista_intereses paddingbt10">
            <?
			while($cat = mysql_fetch_array($Ver_catalogos)){
				?>
            	<li><a href="catalogos/<?=$cat['archivo']?>"><font><?=$cat['titulo']?></font><u><i style="line-height:40px">Carga: <?=$cat['fecha']?></i></u></a></li>							
                <?
			}
			?>
            </ul>
            <?
		} else {
			echo "Tus proveedores favoritos no han agregado cat&aacute;logos";	
		}
		?>
    </div>
    
    
    <div class="group grid-item">
        <h2>Proyectos</h2>
        <?
        $ver_proyectos = mysql_query("
		SELECT proyectos.nombre as titulo, proyectos.id_proyecto, proveedores.nombre,proveedores.id_user, DATE_FORMAT(proyectos.fecha_implementacion,'%d/%m/%Y')  as fecha
		FROM proyectos,proveedores,proveedores_favoritos 
		WHERE proyectos.id_proveedor=proveedores.id_user AND proveedores_favoritos.id_proveedor=proveedores.id_user AND proveedores_favoritos.id_user=".$_SESSION['iduser']." ORDER BY proyectos.id_proyecto DESC LIMIT 5"); 
		if(mysql_num_rows($ver_proyectos)>0){
			?>
            <ul class="lista_procesos lista_intereses paddingbt10">
            <?
			while($proy = mysql_fetch_array($ver_proyectos)){
				?>
            	<li><a href="index.php?id=profile&user=<?=$proy['id_user']?>#MisProyectos"><font><?=$proy['titulo']?></font><u><?=$proy['nombre']?><br /><i>Implementaci&oacute;n: <?=$proy['fecha']?></i></u></a></li>							
                <?
			}
			?>
            </ul>
            <?
		} else {
			echo "Tus proveedores favoritos no han agregado proyectos";	
		}
		mysql_free_result($ver_proyectos);
		?>
    </div>
    
    
    
    
    <div class="group grid-item lista_intereses">
        <h2>Proveedores favoritos</h2>
        <?
		$misproveedores_fav =  mysql_query("SELECT proveedores.* FROM proveedores,proveedores_favoritos WHERE proveedores_favoritos.id_proveedor=proveedores.id_user AND proveedores_favoritos.id_user=".$_SESSION['iduser']." ORDER BY proveedores.nombre ASC");
		if(mysql_num_rows($misproveedores_fav)>0){
			while($disc = mysql_fetch_array($misproveedores_fav)){
				$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$disc['id_user']." AND principal=1 LIMIT 1");
				$pic = mysql_fetch_array($ver_pic);
				if(mysql_num_rows($ver_pic)>0){ $img_pic = "profiles/".$pic['imagen']; } else { $img_pic = "img/unknown_empresa.jpg"; }
			?>    
			<div class="comment_box">
				<span href="index.php?id=profile&user=<?=$disc['id_user']?>" style="background-image:url(<?=$img_pic?>)" class="mini_circ_pic mini_circ_pic2"></span>
				<div class="message_box_disc mini_circ_pic2">
					<a href="index.php?id=profile&user=<?=$disc['id_user']?>"><label><?=$disc['nombre']?></label></a>
				</div>
			</div>
			<?
			}
		} else {
			echo "No has agregado proveedores a tus favoritos";	
		}
		mysql_free_result($misproveedores_fav);
		?>
    </div>
    
    
    
    <div class="group grid-item lista_intereses" style="">
        <h2>Mis discusiones</h2>
        <?
		$discusiones =  mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,discusiones.id_discusion,discusiones.titulo,discusiones.mensaje,DATE_FORMAT(discusiones.fecha,'%d/%m/%Y %H:%i') as fecha 
		FROM discusiones,usuarios,rubros_mejoras,mejoras,tipos_discusion,mejoras_favoritas WHERE mejoras_favoritas.id_mejora=discusiones.id_mejora AND
		tipos_discusion.id_tipo=discusiones.id_tipo AND discusiones.id_user=usuarios.id_user AND mejoras.id_mejora=discusiones.id_mejora 
		AND mejoras.activo=1 AND usuarios.activo=1 GROUP BY discusiones.id_discusion ORDER BY discusiones.id_discusion DESC LIMIT 5");
		if(mysql_num_rows($discusiones)>0){
			while($disc = mysql_fetch_array($discusiones)){
				$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$disc['id_user']." AND principal=1 LIMIT 1");
				$pic = mysql_fetch_array($ver_pic);
				if(mysql_num_rows($ver_pic)>0){ $img_pic = "profiles/".$pic['imagen']; } else { $img_pic = "img/unknown_empresa.jpg"; }
			?>    
			<div class="comment_box">
				<span href="index.php?id=profile&user=<?=$user['id_user']?>" style="background-image:url(<?=$img_pic?>)" class="mini_circ_pic"></span>
				<div class="message_box_disc">
					<a href="index.php?id=viewthread&thread=<?=$disc['id_discusion']?>"><label><?=$disc['titulo']?></label>
					<br />
					<?
					$arreglo = explode(" ",$disc['mensaje']);
					if(count($arreglo)>19){
						$corte = 20;
						$limite = "...";	
					} else {
						$corte = count($arreglo);
						$limite = "";
					}
					for($i=0;$i<$corte;$i++){
						echo " ".$arreglo[$i];
					}
					echo $limite;
					?>
					</a>
					<i><span class="icon-clock"></span> &nbsp; <?=$disc['fecha']?><u>Autor: <?=$disc['usuarion']?></u>
					<?
					$get_messages = mysql_query("SELECT id_mensaje FROM mensajes WHERE id_discusion=".$disc['id_discusion']."");
					?>
					<u><span class="icon-bubble"></span> <?=mysql_num_rows($get_messages)?></u>
					<? mysql_free_result($get_messages); ?>
					</i>
				</div>
			</div>
			<?
			}
		} else {
			echo "No hay discusiones asociadas a tus mejoras favoritas";	
		}
		mysql_free_result($discusiones);
		?>
    </div>
    
    <div class="group grid-item">
        <h2>Mejoras favoritas</h2>
        <?
        $ver_mejoras = mysql_query("SELECT mejoras.* FROM mejoras,mejoras_favoritas 
		WHERE mejoras_favoritas.id_mejora=mejoras.id_mejora AND mejoras_favoritas.id_user=".$_SESSION['iduser']." ORDER BY mejoras.id_mejora DESC"); 
		if(mysql_num_rows($ver_mejoras)>0){
			?>
            <ul class="lista_intereses paddingbt10">
            <?
			while($mej = mysql_fetch_array($ver_mejoras)){
				?>
            	<li><a href="index.php?id=mejoras&mejora=<?=$mej['id_mejora']?>"><font><?=$mej['nombre']?></font></a></li>							
                <?
			}
			?>
            </ul>
            <?
		} else {
			echo "No has agregado mejoras a tus favoritos";	
		}
		mysql_free_result($ver_mejoras);
		?>
    </div>
</div>
</div>
<script src="js/masonry.pkgd.min.js"></script>
<script>
$(document).ready(function() {
	$('.cxc').masonry({
		itemSelector: '.grid-item'
	});
});
</script>	
<?	
}
?>