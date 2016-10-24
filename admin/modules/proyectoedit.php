<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']=="1"){
	if(isset($_GET['idpc']) && is_numeric($_GET['idpc'])){
	?>
	<h1>Editar Proyecto Consultado</h1>
	<?
	
	$data_proyecto = mysql_query("SELECT * FROM proyectos_consultados WHERE id_pc=".$_GET['idpc']." LIMIT 1");
	if(mysql_num_rows($data_proyecto)>0){
		$row = mysql_fetch_array($data_proyecto);
		
		$ver_rubros = mysql_query("SELECT id_rubro,nombre FROM rubros ORDER BY id_rubro ASC");
		
		?>
        
        
        <form name="form" id="form" action="funciones.php?acc=editProyectoC" method="post">
        
			<div class="user-form form_extend2">
				<h4>Informaci&oacute;n de proyecto</h4><br />
				<div class="form-group">
					<label>Nombre proyecto</label>
					<input type="text" name="nombre" required value="<?=$row['nombre']?>">
				 </div> 
                 <div class="form-group">
					<label>Porcentaje</label>
					<input type="text" name="porcentaje" required value="<?=$row['porcentaje']?>" placeholder="20.60">
				 </div>
                 <div class="form-group">
					<label>Rubro asignado</label>
					<select name="idrubro">
                    	<?
                        while($rub = mysql_fetch_array($ver_rubros)){
						?>
                    	<option value="<?=$rub['id_rubro']?>" <? if($rub['id_rubro']==$row['id_rubro']){ echo 'selected'; } ?> ><?=$rub['nombre']?></option>
                        <?	
						}
						?>
                    </select>
				 </div> 
            </div>
            <div class="user-form form_extend">
				
                <div class="form-group" id="buttons"><br><input type="submit" name="guardar" value="Guardar Cambios"></div>
			</div>
        <input type="hidden" name="idpc" value="<?=$row['id_pc']?>" />	 	 	 
        </form>
        <br /><br />
<? 
		} else {
			echo "Este proyecto no existe.";	
		}
	} else {
		echo "ID Error";	
	}
} else {
	
}
?>
