<?
if(isset($_GET['mejora']) && is_numeric($_GET['mejora'])){
	$ver_mejoras = mysql_query("SELECT * FROM mejoras WHERE id_mejora=".$_GET['mejora']." AND mejoras.activo=1 LIMIT 1");
    
	if(mysql_num_rows($ver_mejoras)>0){
		$mejora = mysql_fetch_array($ver_mejoras);
		
		$ver_rubros_asociados = mysql_query("SELECT rubros_mejoras.*,rubros.nombre FROM rubros_mejoras,rubros WHERE rubros_mejoras.id_rubro=rubros.id_rubro AND rubros_mejoras.id_mejora=".$mejora['id_mejora']."");
?>
<?
	$ver_favorito = mysql_query("SELECT id_user FROM mejoras_favoritas WHERE id_user=".$_SESSION['iduser']." AND id_mejora=".$mejora['id_mejora']." LIMIT 1");
	if(mysql_num_rows($ver_favorito)>0){ $esFav= "fav_active"; $addto = "Eliminar de favoritos"; $linkFav= "delMejoraFavorite"; } else { $esFav= ""; $addto = "Agregar a favoritos"; $linkFav= "addMejoraFavorite"; }
	mysql_free_result($ver_favorito);
	?>
	<? if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){ ?>
    <a href="acciones.php?acc=<?=$linkFav?>&mejora=<?=$mejora['id_mejora']?>" class="icon-heart favorite <?=$esFav?>" title="<?=$addto?>"></a>
	<? } ?>
       
    <h1 class="noborder"><?=$mejora['nombre']?></h1>
    
     
    <div class="contenido">
        <h3>Descripci&oacute;n</h3>
        <div class="group descripcion">
            <? if(strlen($mejora['descripcion'])>1){ echo $mejora['descripcion']; } else { echo "Sin descripci&oacute;n"; }?>
		</div>
   	</div>
    
    <?
    if(mysql_num_rows($ver_rubros_asociados)>0){
	?>
    <h2>Rubros asociados</h2>
   	<div class="contenido <? if((mysql_num_rows($ver_rubros_asociados)%2)==0){ ?>c2columnas<? } ?>">
    
    	<? while($rub = mysql_fetch_array($ver_rubros_asociados)){ ?>
        <div class="group">
        	<h4><?=$rub['nombre']?></h4><br />
            <ul>
                <li>
                    <label>M&iacute;nimo ahorro te&oacute;rico:</label>
                    <span><?
                    if($rub['ahorro_min']>0){
                    	echo $rub['ahorro_min'];
                    }else{
                    	echo "-"; 
                    }?> %</span>
                </li>
                <li>
                    <label>M&aacute;ximo ahorro te&oacute;rico:</label>
                    <span><?
                    if($rub['ahorro_max']>0){
                    	echo $rub['ahorro_max'];
                    } else {
                    	echo "-"; 
                    }?> %</span>
                </li>
                <li>
                    <label>Periodo de retorno m&iacute;nimo:</label>
                    <span><?
                    if($rub['pri_min']>0){
                    	echo $rub['pri_min'];
                    } else {
                    	echo "-";
                    } ?> a&ntilde;os</span>
                </li>
                <li>
                    <label class="tooltip">Periodo de retorno m&aacute;ximo: <div class="tooltiptext">Número de años que se demora en recuperar el monto invertido</div></label>
                    <span><?
                    if($rub['pri_max']>0){
                    	echo $rub['pri_max'];
                    } else {
                    	echo "-";
                    }?> a&ntilde;os</span>
                </li>
                <li>
                    <label>Fuente:</label>
                    <span><?if(strlen($rub['fuente'])>0) echo $rub['fuente']; else echo "-";?></span>
                </li>
			</ul>
            <br /><br />
		</div>
        <? } ?>
        
   </div>   
   <?
   }
   ?><h2>Proveedores activos</h2>
   <div class="bajada">Conoce proveedores de esta mejora </div>

   <div class="contenido">     
        <div class="group circ_box">
        	<?
            $proveedores = mysql_query("SELECT proveedores.* FROM proveedores,mejoras_proveedores WHERE mejoras_proveedores.id_proveedor=proveedores.id_user AND mejoras_proveedores.id_mejora=".$mejora['id_mejora']." AND RAND()<(SELECT ((8/COUNT(*))*10) FROM proveedores) ORDER BY RAND() LIMIT 8");
            
            if(mysql_num_rows($proveedores)>0){
                while($prov = mysql_fetch_array($proveedores)){
                	$activo = mysql_fetch_array(mysql_query("SELECT activo FROM usuarios WHERE id_user=".$prov['id_user']));
                	if($activo[0]==1){
						$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$prov['id_user']." AND principal=1 LIMIT 1");
						$pic = mysql_fetch_array($ver_pic);
						if(strlen($pic['imagen'])>10){
							$profile_pic = "profiles/".$pic['imagen'];
						} else { 
							$profile_pic = "img/unknown_empresa.jpg";
						}
						?>
						<div class="circ_pic_out nomargintop">
							<a href="index.php?id=profile&amp;user=<?=$prov['id_user']?>" style="background-image:url(<?=$profile_pic?>)" class="circ_pic"></a>
							<div class="ratingblock">
								<span><?=$prov['nombre']?></span>
							</div>
						</div>
						<?
					}	
            	}
			} else {
				echo "No hay proveedores activos";	
			}
			?>
		</div>
    </div>
    
    <div class="contenido">
   		<div class="group">
        	<h1>Discusiones<a name="discusiones"></a>
            	<a href="index.php?id=newthread&mejora=<?=$_GET['mejora']?>" class="btn floatright">Abrir tema</a>
            </h1>
        </div>
        <div class="group">
        	<?
            $ver_discusiones = mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,discusiones.id_discusion,discusiones.titulo,discusiones.mensaje,DATE_FORMAT(discusiones.fecha,'%d/%m/%Y %H:%i') as fecha FROM discusiones,usuarios,rubros_mejoras,rubros WHERE discusiones.id_user=usuarios.id_user AND rubros_mejoras.id_rubro=rubros.id_rubro AND rubros_mejoras.id_mejora=discusiones.id_mejora AND discusiones.id_mejora=".$_GET['mejora']." AND usuarios.activo=1 AND rubros.activo=1 GROUP BY discusiones.id_discusion ORDER BY discusiones.id_discusion DESC LIMIT 5");
			if(mysql_num_rows($ver_discusiones)>0){
				$hay_discus = true;
				while($disc = mysql_fetch_array($ver_discusiones)){
					$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$disc['id_user']." AND principal=1 LIMIT 1");
					$pic = mysql_fetch_array($ver_pic);
					if(mysql_num_rows($ver_pic)>0){ $img_pic = "profiles/".$pic['imagen']; } else { $img_pic = "img/unknown_empresa.jpg"; }
					?>
					
					<div class="comment_box">
						<a href="index.php?id=profile&user=<?=$user['id_user']?>" style="background-image:url(<?=$img_pic?>)" class="mini_circ_pic"></a>
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
				$hay_discus = false;
				echo '<br><br><h4>No hay discusiones para esta mejora</h4>';	
			}
			
			if(mysql_num_rows($ver_discusiones)>5){
				?><a href="index.php?id=discusiones&mejora=<?=$_GET['mejora']?>" class="btn ">Ver todos</a><?
			}
			?>
        </div>
    </div>
	<?
	} else {
		echo "<div id='error'>Esta mejora no existe</div>";	
	}
} else {
	echo "<div id='error'>Error en identificador</div>";	
}
?>
