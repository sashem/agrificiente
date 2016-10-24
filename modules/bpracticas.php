<?
if(isset($_GET['practica']) && is_numeric($_GET['practica'])){
	$buenas_practicas = mysql_query("SELECT buenas_practicas.*,empresas.nombre FROM buenas_practicas,empresas WHERE buenas_practicas.id_empresa=empresas.id_user AND id_buena_practica=".$_GET['practica']." ORDER BY id_buena_practica DESC");
		
	if(mysql_num_rows($buenas_practicas)>0){
		$practica = mysql_fetch_array($buenas_practicas);
?>

    <h1><?=$practica['titulo']?>
    <? if($practica['id_empresa']==$_SESSION['iduser'] || isset($_SESSION['adminuser'])){ ?><a href="index.php?id=editpractica&practica=<?=$practica['id_buena_practica']?>" class="iconedit"><span class="icon-pencil"></span> &nbsp; Editar</a><? } ?>
    </h1>
    
    
    <div class="contenido c6035">
        
        <div class="group">
            <h3>Informaci&oacute;n principal</h3>
            <ul>
                <li>
                    <label>Inversi&oacute;n :</label> 
                    <span><?= number_format($practica['inversion'], 0, ',', '.');?></span>
                    <span class="bajada"> <b>Pesos chilenos</b></span>
                </li>
                <li>
                    <label>Amortizaci&oacute;n:</label>
                    <span><?=$practica['amortizacion']?></span>
                    <span class="bajada"> <b>Años</b></span>
                </li>
                <li>
                    <label>Consumo proceso previo:</label>
                    <span><?=number_format($practica['consumo_proceso_previo'], 0, ',', '.');?></span>
                    <span class="bajada"> <b>kWh/año</b></span>
                </li>
                <li>
                    <label>Consumo proceso posterior:</label>
                    <span><?=number_format($practica['consumo_proceso_posterior'], 0, ',', '.');?></span>
                    <span class="bajada"> <b>kWh/año</b></span>
                </li>
                <li>
                    <label>Ahorro energ&eacute;tico:</label>
                    <span><?=$practica['ahorro_energetico']?></span>
                </li>
                <li>
                    <label>Ahorro econ&oacute;mico:</label>
                    <span><?=$practica['ahorro_economico']?></span>
                </li>
                <li>
                    <label>Financiamiento:</label>
                    <span><?=$practica['financiamiento']?></span>
                </li>
			</ul>
		</div>
        
        <div class="group">
        	<?
            if(strlen($practica['img_folder'])>3){ $imagen_practica = "buenas_practicas/".$practica['img_folder']; } else { $imagen_practica = "img/unknown_practica.png"; }
			?><br />
			<img src="<?=$imagen_practica?>" class="imgcenter" />
            
            <? if($practica['id_empresa']==$_SESSION['iduser'] || isset($_SESSION['adminid'])){ ?>
            <div class="diagrama_box_edit">
            <form method="post" action="acciones.php?acc=cargarPicBPractica" id="targetTI" enctype="multipart/form-data">
                <a class="custom-input-file icon-camera pos_pencil_edit">
                <input name="imagen_publica" id="fileTI" class="input-file" type="file">
                <input name="bpractica" type="hidden" value="<?=$_GET['practica']?>">
                </a>
            </form>
            </div>
            <? } ?>
        </div>

        <script>
		$(document).ready(function() {
			$('#fileTI').change(function() {
			  $('#targetTI').submit();
			});
		});
		</script>
    </div>
    <div class="contenido">

            <h3>Diagn&oacute;stico Inicial</h3>
            <div class="group"><?=$practica['diagnostico_inicial']?><br /><br /></div>

            <h3>Soluci&oacute;n</h3>
            <div class="group"><?=$practica['solucion']?><br /><br /></div>
            
            <h3>Resultado</h3>
            <div class="group"><?=$practica['resultado']?><br /><br /></div>


        </div>
        
        <div class="contenido" style="display:block;">
            <div>
                <h3>Mejoras asociadas a esta buena práctica</h3>
                </br>
                <?
                    $mejoras = mysql_query("SELECT mejoras.id_mejora,mejoras.nombre from mejoras,buenas_practicas_mejoras where buenas_practicas_mejoras.id_mejora = mejoras.id_mejora and buenas_practicas_mejoras.id_buena_practica = ".$_GET['practica']);
                if(mysql_num_rows($mejoras)>0){
                ?>
                    <ul class="mismejoras">
                    <? while($mejora = mysql_fetch_array($mejoras)){ ?>
                        <li><span class="icon icon-pushpin"></span> <a href="index.php?id=mejoras&mejora=<?=$mejora['id_mejora']?>"><?=$mejora['nombre']?></a></span>
                    <? } ?>
                    </ul>
                <? }else{ ?>
                No hay mejoras asociadas a esta buena práctica.
                <? } ?>
            </div>
        </div>
	<?
	} else {
		echo "<div id='error'>Esta pr&aacute;ctica no existe</div>";	
	}
} else {
	echo "<div id='error'>Error en identificador</div>";	
}
?>
