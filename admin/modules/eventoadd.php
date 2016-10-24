<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']=="1"){
?>
	
	<h1>Agregar Evento</h1>
	
        <script src="ckeditor/ckeditor.js"></script>
        <form name="form" id="form" action="funciones.php?acc=addevento" method="post" enctype="multipart/form-data">

			<div class="user-form form_extend2">
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombre" required placeholder="Nombre del evento" >
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
					<input type="text" name="fecha" value="" id="fecha_evento" placeholder="dd-mm-yyyy" required style="max-width:74%; display:inline-block">
                    <input type="text" name="hora" value="" placeholder="hh:mm" required pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" style="max-width:24%; display:inline-block">
				 </div>   
				 <div class="form-group">  
					<label>Cupos</label>
					<input type="text" name="cupos_max" required placeholder="30">      
				</div>
				<div class="form-group">
					<label>Ubicaci&oacute;n</label>
					<input type="text" name="localizacion" required placeholder="Direcci&oacute;n N&deg; 000" >
				 </div>   
                 <div class="form-group">  
					<label>Sitio web</label>
					<input type="url" name="pagina_web" placeholder="http://" />       
				 </div>
				 <div class="form-group">  
					<label>Organizador</label>
					<input type="text" name="organizador"  />       
                </div>
                <div class="form-group">  
					<label>Costo</label>
					<input type="text" name="costo" placeholder="8000"  required />       
                </div>
                <div class="form-group">
                    <label>Imagen del evento</label>
                    <input type="file" name="formato" style="max-width: 260px;" required />
                </div>
            </div>
            <div class="user-form form_extend">
				<div class="form-group">
					<label>Descripci&oacute;n</label>
                    <textarea name="descripcion" class="ckeditor" id="editor1"></textarea>
				 </div>
                <div class="form-group" id="buttons"><br><input type="submit" name="agregar" value="Agregar Evento"></div>
			</div>	 	 	 
        </form>
        <br /><br />
<? 
		
} else {
	
}
?>
