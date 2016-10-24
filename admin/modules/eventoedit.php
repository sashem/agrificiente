<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
	if(isset($_GET['evento']) && is_numeric($_GET['evento'])){
		
		$data_evento = mysql_query("SELECT *,
		DATE_FORMAT(fecha , '%d') diaa, DATE_FORMAT(DATE_SUB(fecha, INTERVAL 1 MONTH), '%m') mess, DATE_FORMAT(fecha, '%Y') anoo ,
		DATE_FORMAT(fecha , '%d-%m-%Y') complete_fecha, DATE_FORMAT(fecha , '%H:%i') horario
		FROM eventos WHERE id_evento=".$_GET['evento']." LIMIT 1");
		if(mysql_num_rows($data_evento)>0){
		$row = mysql_fetch_array($data_evento);
	?>
	
	<h1>Editar Evento</h1>
	
        <script src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
		$(window).load(function()
		{
			$('#fecha_evento').glDatePicker({
				<? if($row['fecha']!="00-00-0000"){ ?>
				selectedDate: new Date(<?=$row['anoo']?>, <?=$row['mess']?>, <?=$row['diaa']?>),
				<? } ?>
				dowOffset: 1
			});
		});
		</script>
        <form name="form" id="form" action="funciones.php?acc=editevento" method="post" enctype="multipart/form-data">

			<div class="user-form form_extend2">
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombre" required placeholder="Nombre del evento" value="<?=$row['nombre']?>" >
				 </div> 
                 <script type="text/javascript">
				$(window).load(function(){
					$('#fecha_evento').glDatePicker({
						dowOffset: 1
					});
				});
				</script>
                 <div class="form-group">
					<label>Fecha</label><br />
					<input type="text" name="fecha" value="<?=$row['complete_fecha']?>" id="fecha_evento" placeholder="yyyy-mm-dd" required style="max-width:74%; display:inline-block">
                    <input type="text" name="hora" value="<?=$row['horario']?>" placeholder="hh:mm" required pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" style="max-width:24%; display:inline-block">
				 </div>   
				 <div class="form-group">  
					<label>Cupos</label>
					<input type="text" name="cupos_max" required placeholder="30" value="<?=$row['cupos_max']?>">      
				</div>
				<div class="form-group">
					<label>Ubicaci&oacute;n</label>
					<input type="text" name="localizacion" value="<?=$row['localizacion']?>" required placeholder="Direcci&oacute;n N&deg; 000" >
				 </div>   
                 <div class="form-group">  
					<label>Sitio web</label>
					<input type="url" name="pagina_web" value="<?=$row['pagina_web']?>" placeholder="http://" />       
				 </div>
				 <div class="form-group">  
					<label>Organizador</label>
					<input type="text" name="organizador" value="<?=$row['organizador']?>"  />       
                </div>
                <div class="form-group">  
					<label>Costo</label>
					<input type="text" name="costo" value="<?=$row['costo']?>" placeholder="8000"  required />       
                </div>
                <div class="form-group">
                    <label>Cambiar imagen del evento</label>
                    <input type="file" name="formato" style="max-width: 260px;" />
                </div>
            </div>
            <div class="user-form form_extend">
				<div class="form-group">
					<label>Descripci&oacute;n</label>
                    <textarea name="descripcion" class="ckeditor" id="editor1"><?=$row['descripcion']?></textarea>
				 </div>
                <div class="form-group" id="buttons"><br><input type="submit" name="guardar" value="Guardar cambios"></div>
			</div>	
            <input type="hidden" name="id_evento" value="<?=$row['id_evento']?>" />   	 	 
        </form>
        <br /><br />
<? 
		} else {
			echo "Este evento no existe.";	
		}
		
	} else {
		echo "ID Error";	
	}
} else {
	
}
?>
