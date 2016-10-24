<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
	if(isset($_GET['rubro']) && is_numeric($_GET['rubro'])){
	?>
	<h1>Editar Rubro</h1>
	<?
	
	$data_rubro = mysql_query("SELECT * FROM rubros WHERE id_rubro=".$_GET['rubro']." LIMIT 1");
	if(mysql_num_rows($data_rubro)>0){
		$row = mysql_fetch_array($data_rubro);
		?>
        <script src="ckeditor/ckeditor.js"></script>
        <form name="form" id="form" action="funciones.php?acc=editrubro" method="post" enctype="multipart/form-data">
        
			<div class="user-form form_extend2">
				<h4><?=$row['nombre']?></h4>
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombre" value="<?=$row['nombre']?>"  placeholder="Nombre del rubro" required >
				 </div> 
                 <div class="form-group">
					<label>% Consumo Espec&iacute;fico Min</label>
					<input type="text" name="consumo_especifico_min" value="<?=$row['consumo_especifico_min']?>" placeholder="0.080">
				 </div> 
                 <div class="form-group">
					<label>% Consumo Espec&iacute;fico Max</label>
					<input type="text" name="consumo_especifico_max" value="<?=$row['consumo_especifico_max']?>" placeholder="1.533">
				 </div>   
				 <div class="form-group">  
					<label>% Consumo El&eacute;ctrico</label>
					<input type="text" name="consumo_electrico" value="<?=$row['consumo_electrico']?>" placeholder="70.50">      
				</div>
				<div class="form-group">
					<label>% Consumo Combustible</label>
					<input type="text" name="consumo_comb" value="<?=$row['consumo_comb']?>" placeholder="50.10">
				 </div>  
                 <div class="form-group">  
					<label>Foto portada</label>
					<input type="file" name="imagen_publica" style="max-width: 260px;"  />       
				 </div>
				 <div class="form-group">  
					<label>Icono del Rubro</label>
					<input type="file" name="icono" style="max-width: 260px;"  />       
				</div>
				<div class="form-group">
					<label>Diagrama de Flujo</label>
					<input type="file" name="diagrama_flujo" style="max-width: 260px;" />
				</div>
            </div>
            <div class="user-form form_extend">
				<div class="form-group">
					<label>Descripci&oacute;n</label>
                    <textarea name="descripcion" class="ckeditor" id="editor1"><?=$row['descripcion']?></textarea>
				 </div>
                <div class="form-group" id="buttons"><br><input type="submit" name="guardar" value="Guardar Cambios"></div>
			</div>
        <input type="hidden" name="idrubro" value="<?=$row['id_rubro']?>" /> 	 	 	 
        </form>
        <br /><br />
        <div class="user-form form_extend">
        	<h4>Mejoras asociadas</h4>
            <?
            $ver_mejoras_Asociadas = mysql_query("SELECT mejoras.id_mejora,mejoras.nombre FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora=mejoras.id_mejora AND rubros_mejoras.id_rubro=".$_GET['rubro']." AND mejoras.activo=1");
			if(mysql_num_rows($ver_mejoras_Asociadas)>0){
			?>
            <div class="form-group">
                <ul>
                	<?
                    while($mejoras = mysql_fetch_array($ver_mejoras_Asociadas)){
					?>
                	<li><a href="../index.php?id=mejoras&mejora=<?=$mejoras['id_mejora']?>" target="_blank"><?=$mejoras['nombre']?></a></li>
                    <?
					}
					?>
                </ul>
            </div>
            <?
			} else {
				echo "<br><br>No hay mejoras asociadas";	
			}
			?>
        </div>
        <div class="user-form form_extend">
        	<h4>Procesos asociados</h4>
            <?
            $ver_procesos_Asociados = mysql_query("SELECT operaciones.id_operacion,operaciones.nombre FROM operaciones,rubros_operaciones WHERE rubros_operaciones.id_operacion=operaciones.id_operacion AND rubros_operaciones .id_rubro=".$_GET['rubro']." AND operaciones.activo=1");
			if(mysql_num_rows($ver_procesos_Asociados)>0){
			?>
            <div class="form-group">
                <ul>
                	<?
                    while($proc = mysql_fetch_array($ver_procesos_Asociados)){
					?>
                	<li><a href="../index.php?id=verrubro&rubro=<?=$_GET['rubro']?>#ficha_proceso" target="_blank"><?=$proc['nombre']?></a></li>
                    <?
					}
					?>
                </ul>
            </div>
            <?
			} else {
				echo "<br><br>No hay mejoras asociadas";	
			}
			?>
        </div>
<? 
		} else {
			echo "Este rubro no existe.";	
		}
	} else {
		echo "ID Error";	
	}
} else {
	
}
?>
