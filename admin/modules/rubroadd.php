<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']=="1"){
?>
	
	<h1>Agregar Rubro</h1>
	
        <script src="ckeditor/ckeditor.js"></script>
        <form name="form" id="form" action="funciones.php?acc=addrubro" method="post" enctype="multipart/form-data">
        
			<div class="user-form form_extend2">
				<h4>Nuevo Rubro</h4>
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombre" required placeholder="Nombre del rubro" >
				 </div> 
                 <div class="form-group">
					<label>% Consumo Espec&iacute;fico Min</label>
					<input type="text" name="consumo_especifico_min" value="" placeholder="0.080">
				 </div> 
                 <div class="form-group">
					<label>% Consumo Espec&iacute;fico Max</label>
					<input type="text" name="consumo_especifico_max" value="" placeholder="1.533">
				 </div>    
				 <div class="form-group">  
					<label>% Consumo El&eacute;ctrico</label>
					<input type="text" name="consumo_electrico" required placeholder="70.50">      
				</div>
				<div class="form-group">
					<label>% Consumo Combustible</label>
					<input type="text" name="consumo_comb" required placeholder="50.10">
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
                    <textarea name="descripcion" class="ckeditor" id="editor1"></textarea>
				 </div>
                <div class="form-group" id="buttons"><br><input type="submit" name="agregar" value="Agregar Rubro"></div>
			</div>	 	 	 
        </form>
        <br /><br />
<? 
		
} else {
	
}
?>
