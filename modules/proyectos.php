<?
if(isset($_GET['proyecto']) && is_numeric($_GET['proyecto'])){
	$proyectos = mysql_query("SELECT proyectos.*,energia.energia as tipo_energia, DATE_FORMAT(proyectos.fecha_implementacion,'%d/%m/%Y') as fecha_implementacion FROM proyectos,usuarios,energia WHERE proyectos.tipo_energia=energia.id_energia AND proyectos.id_proveedor = usuarios.id_user AND proyectos.id_proyecto =".$_GET['proyecto']." LIMIT 1");
	
	if(mysql_num_rows($proyectos)>0){
		$proy = mysql_fetch_array($proyectos);
        $rubro = mysql_fetch_array(mysql_query("SELECT nombre FROM rubros WHERE id_rubro =".$proy['id_rubro']));
?>

    <h1><?=$proy['nombre']?>
     - Sector: <?=$rubro['nombre'] ?>
	<? if($proy['id_proveedor']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?><a href="index.php?id=editproyecto&proyecto=<?=$proy['id_proyecto']?>" class="iconedit"><span class="icon-pencil"></span> &nbsp; Editar</a><? } ?>
    </h1>
    
    <div class="contenido c2columnas columnas_proyectos">
        <h3>Informaci&oacute;n principal</h3>
        <div class="group">
            <ul>
                <li>
                    <label class="tooltip">Empresa: <div class="tooltiptext">Empresa dónde se realizó el proyecto</div></label>
                    <span><?=$proy['empresa']?></span>
                </li>
                <li>
                    <label class="tooltip">Recurso utilizado: <div class="tooltiptext">Tipo de recurso natural aprovechado en la mejora</div></label>
                    <span><?=$proy['recurso']?></span>
                </li>
                <li>
                    <label class="tooltip">Tipo de energ&iacute;a: <div class="tooltiptext"> Tipo de energía ahorrada o reemplazada</div></label>
                    <span><?=$proy['tipo_energia']?></span>
                </li>
                <li>
                    <label class="tooltip">Capacidad instalada: <div class="tooltiptext"> En caso de ser un proyecto de autogeneración, potencia instalada</div></label>
                    <span><?=number_format($proy['capacidad_instalada'], 0, ',', '.');?></span>
                    <span class="bajada"> <b> kW</b></span>

                </li>
                <li>
                    <label class="tooltip">Procesos intervenidos: <div class="tooltiptext">Procesos industriales que fueron intervenidos por el proyecto</div></label>
                    <span><?=$proy['procesos_intervenidos']?></span>
                </li>
                <li>
                    <label class="tooltip">Ahorro de energ&iacute;a: <div class="tooltiptext">Ahorro de la energía consumida en el/los proceso(s) intervenido(s)</div></label>
                    <span><?=$proy['energia_ahorro']?>%</span>
                </li>
                <li>
                    <label class="tooltip">Porcentaje de ahorro: <div class="tooltiptext">Ahorro de los costos asociados al/a los proceso(s) intervenido(s)</div></label>
                    <span><?=$proy['porcentaje_ahorro']?>%</span>
                </li>
                <li>
                    <label class="tooltip">Inversi&oacute;n: <div class="tooltiptext">Monto invertido en el proyecto</div></label>
                    <span>$<?=number_format($proy['inversion'], 0, ',', '.');?><b> Pesos chilenos</b></span>
                </li>
			</ul>
		</div>
        
        
        <div class="group">
            <ul>
                <li>
                    <label class="tooltip">Payback esperado: <div class="tooltiptext">Número de años en que se recupera la inversión</div></label>
                    <span><?=$proy['payback_esperado']?><b> Años</b></span>
                </li>
                <li>
                    <label class="tooltip">Tipo de financiamiento: <div class="tooltiptext">Forma en que se financió el proyecto</div></label>
                    <span><?=$proy['tipo_financiamiento']?></span>
                </li>
                <li>
                    <label class="tooltip">Fecha de implementaci&oacute;n: <div class="tooltiptext">Fecha en la que el proyecto se encontraba/se encontrará operativo</div></label>
                    <span><?=$proy['fecha_implementacion']?></span>
                </li>
                <li>
                    <label class="tooltip">Subsidio: <div class="tooltiptext">En caso de que hubiera subsidio, monto subsidiado</div></label>
                    <span>$<?=number_format($proy['subsidio'], 0, ',', '.');?><b> Pesos chilenos</b></span>
                </li>
                <li>
                    <label class="tooltip">Modelo de negocio: <div class="tooltiptext">Forma en que opera el proyecto como negocio (ESCO, auto-explotación)</div></label>
                    <span><?=$proy['modelo_negocio']?></span>
                </li>
                <li>
                    <label class="tooltip">Rol Proveedor: <div class="tooltiptext">Papel de la empresa proveedora en el proyecto</div></label>
                    <span><?=$proy['rol_proveedor']?></span>
                </li>
                <li>
                    <label class="tooltip">Localizaci&oacute;n: <div class="tooltiptext">Lugar físico dónde se realizó el proyecto</div></label>
                    <span><?=$proy['localizacion']?></span>
                </li>
			</ul>
		</div>
	</div>
    
	<div class="contenido c2columnas columnas_proyectos">     
        <div class="group">
        	<h4>Descripci&oacute;n</h4><br /><br />
            <? if(strlen($proy['descripcion'])>1){ echo $proy['descripcion']; } else { echo "Sin descripci&oacute;n"; }?>
		</div>
        
        <div class="group"><a href="#" name="imgg"></a>
        	<? if(strlen($proy['img_folder'])>3){ $imagen_practica = "proyectos/".$proy['img_folder']; } else { $imagen_practica = "img/unknown_practica.png"; } ?>
        	<img src="<?=$imagen_practica?>" class="imgcenter imgproyecto" />
        	<? if($proy['id_proveedor']==$_SESSION['iduser'] || isset($_SESSION['adminid'])){ ?>
            <div class="diagrama_box_edit">
            <form method="post" action="acciones.php?acc=cargarPicProyecto" id="targetTI" enctype="multipart/form-data">
                <a class="custom-input-file icon-camera pos_pencil_edit">
                <input name="imagen_publica" id="fileTI" class="input-file" type="file">
                <input name="idproyecto" type="hidden" value="<?=$_GET['proyecto']?>">
                </a>
            </form>
            </div>
            <? } ?>
		</div>
    </div>
    <script>
		$(document).ready(function() {
			$('#fileTI').change(function() {
			  $('#targetTI').submit();
			});
		});
		</script>
	<?
	} else {
		echo "<div id='error'>Este proyecto no existe</div>";	
	}
} else {
	echo "<div id='error'>Error en identificador</div>";	
}
?>
