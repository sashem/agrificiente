<?
if(isset($_GET['rubro']) && is_numeric($_GET['rubro'])){
	$ver_rubros = mysql_query("SELECT * FROM rubros WHERE id_rubro=".$_GET['rubro']." AND activo=1");
	if(mysql_num_rows($ver_rubros)>0){
		$rubro = mysql_fetch_array($ver_rubros);
?>

    <h1><?=$rubro['nombre']?></h1>
    <br />
    <?
    $ver_img_rubro = mysql_query("SELECT imagen FROM imagenes_rubros WHERE id_rubro=".$_GET['rubro']."");
	if(mysql_num_rows($ver_img_rubro)>0){
		$rubimg = mysql_fetch_array($ver_img_rubro);
		$cover_rubro = "rubros/".$rubimg['imagen'];	
	} else {
		$cover_rubro = "img/bgp.png";
	}
    ?>
    <div style="background:url(<?=$cover_rubro?>) center no-repeat;" class="cover_rubro">
    <? if(isset($_SESSION['adminid'])){ ?>
    <form method="post" action="acciones.php?acc=cargarcoverRubro" id="targetTI" enctype="multipart/form-data">
        <a class="custom-input-file icon-camera pos_pencil_edit">
        <input name="imagen_publica" id="fileTI" class="input-file" type="file">
        <input name="rubro" type="hidden" value="<?=$_GET['rubro']?>">
        </a>
    </form>
    <?
    }
    ?>
    </div>     
    <h1>Informaci&oacute;n principal</h1>
    <div class="bajada">Resumen de la sistematización de la información y expone la distribución energética del sector. <br>Identificando fuente energética predominante, proceso más energointensivo, equipos más relevante y rango del indice energético general </div>
    <div class="contenido descripcion">
        <div class="group"><br />
            <? if(strlen($rubro['descripcion'])>3){ echo $rubro['descripcion']; } else { echo "Sin descripci&oacute;n."; } ?>
        </div>
    </div>    
    <div class="contenido c3560">    
        <!--<div class="group">
            </br></br><strong class="title-group">Consumo espec&iacute;fico</strong>
            <ul>
                <li>
                    <span><?=$rubro['consumo_especifico_min']?>-<?=$rubro['consumo_especifico_max']?> kWh/l</span>
                </li>
            </ul>
        
            <br /><strong class="title-group">Consumo por fuente de energ&iacute;a</strong>
            <ul>
                <li>
                    <label>Consumo el&eacute;ctrico:</label>
                    <span><?=$rubro['consumo_electrico']?>% <img src="img/tr.gif" class="icon-26 consumoul" /></span>
                </li>
                <li>
                    <label>Consumo combustible:</label>
                    <span><?=$rubro['consumo_comb']?>% <img src="img/tr.gif" class="icon-25 consumoul" /></span>
                </li>
            </ul>
        </div>-->
        
        
        
        <!--<div class="group"><a name="diagramafl"></a>
            <?
            if(strlen($rubro['diagrama_flujo'])>1){
                $diagrama_rubro = "rubros/".$rubro['diagrama_flujo'];   
            } else {
                $diagrama_rubro = "img/unknown_practica.png";
            }
            ?>
            <img src="<?=$diagrama_rubro?>" class="imgcenter" style="max-height:350px;" />
            <? if(isset($_SESSION['adminid'])){ ?>
            <div class="diagrama_box_edit">
            <form method="post" action="acciones.php?acc=cargarDiagramaRubro" id="targetTI2" enctype="multipart/form-data">
                <a class="custom-input-file icon-camera pos_pencil_edit">
                <input name="imagen_publica" id="fileTI2" class="input-file" type="file">
                <input name="rubro" type="hidden" value="<?=$_GET['rubro']?>">
                </a>
            </form>
            </div>
            <? } ?>
        </div>-->
    </div>

    <h1>Mejoras posibles</h1>
    <div class="bajada">Conoce algunas de tus opciones para mejorar tu consumo energético.</div>
    <div class="contenido c2columnas">
        <div class="group">
            <div class="lista_mejoras">
                <span><strong>Mejoras del rubro</strong></span>
                <div class="bajada">Mejoras sugeridas especificamente para tu rubro. </div>
            </div>

            <span id="mejoras_especificas">
			<?
			$registros = 5;
			$inicio = 0;
			$pagina = 1;
			$kpi_resp = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora, rubros_mejoras.valoracion as valoracion, rubros_mejoras.id_rubro_mejora as id_rubro_mejora FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND mejoras.activo=1 AND rubros_mejoras.id_rubro=".$rubro['id_rubro']." ORDER BY rubros_mejoras.valoracion DESC");
			$kpi = mysql_fetch_array($kpi_resp);
			$total_r = mysql_num_rows($kpi_resp);
			mysql_free_result($kpi_resp);
			$total_paginas = ceil($total_r / $registros);
		
            $mejoras_rubro = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora, rubros_mejoras.valoracion as valoracion, rubros_mejoras.id_rubro_mejora as id_rubro_mejora FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND mejoras.activo=1 AND rubros_mejoras.id_rubro=".$rubro['id_rubro']." ORDER BY rubros_mejoras.valoracion DESC LIMIT ".$inicio.",".$registros."");
            if(mysql_num_rows($mejoras_rubro)>0){
                while($mejora = mysql_fetch_array($mejoras_rubro)){
                    ?>
                    <div class="lista_mejoras">
                        <span>
                        <a href="index.php?id=mejoras&mejora=<?=$mejora['id_mejora']?>"><?=$mejora['nombremejora']?></a>
                        </span>
                        <span></span>
                    </div>
                    <?
                }
            } else {
                ?><div class="lista_mejoras"><br />No hay mejoras para este rubro<br /><br /></div><?	
            }
            paginar_resultados_ajax('mejoras_especificas',$total_paginas,$pagina,$_GET['rubro']);
			?>
            </span>
        </div>
        
        
        <div class="group">
            <div class="lista_mejoras">
                <span><strong>Mejoras generales</strong></span>
                <div class="bajada">Mejoras sugeridas aplicables para el sector agroalimentario en general.</div>
            </div>
            
            <span id="mejoras_general">
			<?
			$kpi_resp = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora, rubros_mejoras.valoracion as valoracion, rubros_mejoras.id_rubro_mejora as id_rubro_mejora FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND mejoras.activo=1 AND rubros_mejoras.id_rubro=0  ORDER BY rubros_mejoras.valoracion DESC");
			$kpi = mysql_fetch_array($kpi_resp);
			$total_r = mysql_num_rows($kpi_resp);
			mysql_free_result($kpi_resp);
			$total_paginas = ceil($total_r / $registros);
			/*$registros = 5;
			$inicio = 0;
			$pagina = 1;*/
			
            $mejoras_rubro = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora, rubros_mejoras.valoracion as valoracion, rubros_mejoras.id_rubro_mejora as id_rubro_mejora FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND mejoras.activo=1 AND rubros_mejoras.id_rubro=0  ORDER BY rubros_mejoras.valoracion DESC LIMIT ".$inicio.",".$registros."");
            if(mysql_num_rows($mejoras_rubro)>0){
                while($mejora = mysql_fetch_array($mejoras_rubro)){
                    ?>
                    <div class="lista_mejoras">
                        <span>
                        <a href="index.php?id=mejoras&mejora=<?=$mejora['id_mejora']?>"><?=$mejora['nombremejora']?></a>
                        </span>
                        <span></span>
                    </div>
                    <?
                }
            } else {
                ?><div class="lista_mejoras"><br />No hay mejoras para este rubro<br /><br /></div><?	
            }
			paginar_resultados_ajax('mejoras_general',$total_paginas,$pagina,$_GET['rubro']);
			
            ?>
            </span>
        </div>
    </div>
    
    <a href="#" name="proCesoPic"></a>
    <h1>Procesos</h1>
    <div class="bajada">Etapas operacionales tipo, identificadas para tu rubro.</div>
    <br />
			  

    <?
    if(strlen($rubro['img_proceso'])>3){
		$cover_rubroOper = "rubros/".$rubro['img_proceso'];	
	} else {
		$cover_rubroOper = "img/bgp.png";
	}
	?>
    
    
	<? /*if(isset($_SESSION['adminid'])){ ?>
    <? <img src="<?=$cover_rubroOper?>" class="imgcenter" style="max-height:600px; width:auto;" />
    <div class="diagrama_box_edit">
    <form method="post" action="acciones.php?acc=cargarImgProcesoRubro" id="targetTI3" enctype="multipart/form-data">
        <a class="custom-input-file icon-camera pos_pencil_edit">
        <input name="imagen_publica" id="fileTI3" class="input-file" type="file">
        <input name="rubro" type="hidden" value="<?=$_GET['rubro']?>">
        </a>
    </form>
    </div>*/?>
    <? /*
	} else {
		if(strlen($rubro['img_proceso'])>3){
		?>
		<? /*<img src="<?=$cover_rubroOper?>" class="imgcenter" style="max-height:600px; width:auto;" /> */?>
		<? /*
		}
	} 
	*/?>
    <div class="group productos" id="productos">
    <h3>Productos del rubro</h3>
    Estos son los productos que produce este rubro. Haz click en cualquiera de ellos para ver los procesos que contempla esta plataforma para su producción.
    </br>
    </br>
    <?
        $sql_get_productos = "SELECT DISTINCT producto FROM rubros_operaciones WHERE id_rubro=".$rubro['id_rubro'];
        //$sql_get_productos = "SELECT producto FROM rubros_operaciones WHERE id_rubro=".$rubro['id_rubro']." GROUP BY producto";
        $raux = mysql_query($sql_get_productos);
        while($producto = mysql_fetch_array($raux)){
            if(strlen($producto['producto'])>1){
                ?><div class="btn_producto" id="btn_<?=str_replace(' ', '',$producto['producto'])?>"><a onclick="mostrar_producto('<?=str_replace(' ', '',$producto['producto'])?>')"><?=$producto['producto']?></a></div><?
            }
        }
     ?>
    </div>
    <div class="contenido c2columnas c3560">
        <script src="js/validacion.js"></script>
        <div class="group listas_procesos">
            <h2>Procesos productivos</h2>
            <div class="bajada">Selecciona al proceso que te interesa para ver la ficha descriptiva y posibles mejoras.</div>
            <br>
            <?
            $raux = mysql_query($sql_get_productos);
            while($producto = mysql_fetch_array($raux)){ if(strlen($producto['producto'])>1){
            ?>
            <ul class="lista_procesos invisible" id="<?=str_replace(' ', '',$producto['producto'])?>">
            
            	<?
                $operaciones_rubro = mysql_query("SELECT operaciones.* 
                    FROM operaciones,rubros_operaciones 
                    WHERE rubros_operaciones.id_operacion = operaciones.id_operacion 
                        AND rubros_operaciones.producto='".$producto['producto']."' 
                        AND rubros_operaciones.id_rubro=".$rubro['id_rubro']." 
                        AND operaciones.activo=1 
                    ORDER BY rubros_operaciones.orden ASC");
                
                if(mysql_num_rows($operaciones_rubro)>0){
                    $num_rows = mysql_num_rows($operaciones_rubro);
                    $i = 1;
					while($opera = mysql_fetch_array($operaciones_rubro)){
						?>
                        
						<li class="item_proceso" id="op_<?=$rubro['id_rubro']?>_<?=$opera['id_operacion']?>">
                            <a onclick="ficha_operacion(<?=$rubro['id_rubro']?>,<?=$opera['id_operacion']?>)">
                            <font><?=$opera['nombre']?></font>
                        <u>
                        	<? if($opera['uso_calor']==1){ ?><img src="img/tr.gif" class="icon-37" /><? } ?>
                            <? if($opera['uso_frio']==1){ ?><img src="img/tr.gif" class="icon-36" /><? } ?>
                            <? if($opera['uso_electricidad']==1){ ?><img src="img/tr.gif" class="icon-26" /><? } ?>
                            <? if($opera['uso_combustible']==1){ ?><img src="img/tr.gif" class="icon-25" /><? } ?>
                        </u></a></li>
						<? $i++;if($i<=$num_rows){?>
                        <div class="flecha_abajo"><img src="img/flecha_abajo.png" height="30"/></div>
                        <?
                        }
                        ?><?
					}
				} else {
					?><li><a><font>Sin operaciones registradas</font></a></li><?
				}
				?>
            </ul>
            <? }} ?>
        </div>
        <div class="group"><a name="ficha_proceso"></a>
            <h2>Ficha de proceso</h2>
            
            <div id="detalle_ficha_proceso"><strong>Seleccione operaci&oacute;n para ver ficha</strong><br /></div>
        </div>
    </div>
    
        <div class="group">
        <div class="iconografia">
            <table>
                <tr>
                    <td><img src="./img/energia-01.png"/></br><h2>Consumo eléctrico</h2></td>
                    <td><img src="./img/energia-02.png"/></br><h2>Consumo combustibles</h2></td>
                    <td><img src="./img/energia-03.png"/></br><h2>Consumo frío</h2></td>
                    <td><img src="./img/energia-04.png"/></br><h2>Consumo calor</h2></td>
                <tr>
            </table>
        </div>
    </div>
    
    <h1>Buenas pr&aacute;cticas</h1>
    <div class="bajada">Conoce buenas prácticas para mejorar el desempeño energético de tu rubro. </div>
    <div class="contenido">
    	<br />
        
        <?
		$buenas_practicas = mysql_query("SELECT buenas_practicas.*,empresas.nombre FROM buenas_practicas,empresas WHERE buenas_practicas.id_empresa = empresas.id_user AND buenas_practicas.id_rubro=".$rubro['id_rubro']." ORDER BY id_buena_practica DESC");
		if(mysql_num_rows($buenas_practicas)>0){
			?>
            <div class="group noborder buenas_practicas proyectos_li">
            	<ul>
            <?
			while($bpr = mysql_fetch_array($buenas_practicas)){
				if(strlen($bpr['img_folder'])>3){ $imagen_practica = "buenas_practicas/".$bpr['img_folder']; } else { $imagen_practica = "img/unknown_practica.png"; }
				?>
				<li>
                    <label>
                        <a href="index.php?id=bpracticas&practica=<?=$bpr['id_buena_practica']?>"><img src="<?=$imagen_practica?>" class="img_mejora" /></a>
                    </label>
                    <span><br />
                    	<h4><a href="index.php?id=bpracticas&practica=<?=$bpr['id_buena_practica']?>"><?=$bpr['titulo']?></a></h4><br />
                        Empresa: <?=$bpr['nombre']?><br />
                        Ahorro energ&eacute;tico: <?=$bpr['ahorro_energetico']?>%<br />
                        Ahorro econ&oacute;mico: <?=$bpr['ahorro_economico']?>%<br />
                    </span>
                </li>
				<?
			}
			?>
                </ul>
            </div>
            <?
		} else {
			?><br />No hay buenas pr&aacute;cticas por el momento<?
		}
		?>  
    </div>

    <a href="#" name="MisProyectos"></a>

        <h1>Proyectos
        </h1><div class="bajada">Conoce proyectos de implementación de medidas de eficiencia energética. </div>
        <div class="contenido">
            <br />
            
            <?
            $proyectos = mysql_query("SELECT proyectos.*,proveedores.nombre FROM proyectos, proveedores WHERE proyectos.id_proveedor=proveedores.id_user AND proyectos.id_rubro=".$rubro['id_rubro']." ORDER BY fecha_implementacion DESC LIMIT 6"); 
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
                            <? if($us['id_user']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?><a href="index.php?id=editproyecto&proyecto=<?=$proy['id_proyecto']?>" class="btn">Modificar</a><? } ?>
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

    <script>
	$(document).ready(function() {
        $("#productos div").first().children("a").click();
        $(".listas_procesos ul").first().children("li").first().children("a").click();
        //$("#productos").css("background-color","ccc");
		
        $('#fileTI').change(function() {
		  $('#targetTI').submit();
		});
		$('#fileTI2').change(function() {
		  $('#targetTI2').submit();
		});
		$('#fileTI3').change(function() {
		  $('#targetTI3').submit();
		});
	});
	</script>
    
    
	<?
	} else {
		echo "<div id='error'>Este rubro no existe</div>";	
	}
} else {
	echo "<div id='error'>Error en identificador</div>";	
}
?>
