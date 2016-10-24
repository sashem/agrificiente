<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']="1"){

	?>
	<h1>Agregar Proyecto Consultado</h1>
 
        <form name="form" id="form" action="funciones.php?acc=addProyectoC" method="post">
        
			<div class="user-form form_extend2">
				<h4>Informaci&oacute;n de proyecto</h4><br />
				<div class="form-group">
					<label>Nombre proyecto</label>
					<input type="text" name="nombre" value="" required >
				 </div> 
                 <div class="form-group">
					<label>Porcentaje</label>
					<input type="text" name="porcentaje" value="" required placeholder="20.60">
				 </div>
                 <div class="form-group">
					<label>Rubro asignado</label>
					<select name="idrubro" required >
                    	<option value="">Seleccionar...</option>
                    	<?
						$ver_rubros = mysql_query("SELECT id_rubro,nombre FROM rubros ORDER BY id_rubro ASC");
                        while($rub = mysql_fetch_array($ver_rubros)){
						?>
                    	<option value="<?=$rub['id_rubro']?>"><?=$rub['nombre']?></option>
                        <?	
						}
						?>
                    </select>
				 </div> 
            </div>
            <div class="user-form form_extend">
				
                <div class="form-group" id="buttons"><br><input type="submit" name="agregar" value="Agregar proyecto"></div>
			</div>
        <input type="hidden" name="idpc" value="<?=$row['id_pc']?>" />	 	 	 
        </form>
        <br /><br />
<? 
} else {
	
}
?>
