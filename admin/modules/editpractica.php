<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
	if(is_numeric($_GET['practica'])){
		$ver_practica = mysql_query("SELECT * FROM buenas_practicas WHERE id_buena_practica=".$_GET['practica']." LIMIT 1");
		
		
		if(mysql_num_rows($ver_practica)>0){
			$row = mysql_fetch_array($ver_practica);
?>
			<h1>Modificar Buena Pr&aacute;ctica</h1>

			<form method="post" action="acciones.php?acc=editpractica" enctype="multipart/form-data">
			<div class="user-form form_extend2">
				<h3>Cambiar informaci&oacute;n en <?=$row['titulo']?></h3>
				<div class="form-group">
					<label>T&iacute;tulo</label>
					<input type="text" name="titulo" value="<?=$row['titulo']?>" required placeholder="T&iacute;tulo de la buena practica">
				</div> 
                <div class="form-group">  
					<label>Cargar imagen &nbsp; <i>(Seleccionar para cambiar)</i></label><br />
					<input type="file" name="img_folder" style="max-width: 260px;">      
				</div>
				<div class="form-group">  
					<label>Diagn&oacute;stico inicial</label>
					<textarea name="diagnostico_inicial"><?=str_replace("<br>","\n",$row['diagnostico_inicial'])?></textarea>    
				</div> 
                <div class="form-group">  
					<label>Soluci&oacute;n</label>
					<textarea name="solucion"><?=str_replace("<br>","\n",$row['solucion'])?></textarea>    
				</div> 
                <div class="form-group">  
					<label>Resultado</label>
					<textarea name="resultado"><?=str_replace("<br>","\n",$row['resultado'])?></textarea>    
				</div>
                <div class="form-group">  
					<label>Financiamiento</label>
					<textarea name="financiamiento"><?=str_replace("<br>","\n",$row['financiamiento'])?></textarea>       
				</div>
                
                 
                
                <div class="form-group">
					<label>Inversi&oacute;n</label>
                    <input type="text" name="inversion" required value="<?=$row['inversion']?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
				</div>   
				<div class="form-group">  
					<label>Amortizaci&oacute;n</label>
					<input type="text" name="amortizacion" required value="<?=$row['amortizacion']?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>       
				</div>
				<div class="form-group">
					<label>Consumo proceso previo</label>
					<input type="text" name="consumo_proceso_previo" value="<?=$row['consumo_proceso_previo']?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
				</div>   
				<div class="form-group">  
					<label>Consumo proceso posterior</label>
					<input type="text" name="consumo_proceso_posterior" value="<?=$row['consumo_proceso_posterior']?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>       
				</div>
                <div class="form-group">  
					<label>Ahorro energ&eacute;tico &nbsp; <i>%</i></label>
					<input type="text" name="ahorro_energetico" value="<?=$row['ahorro_energetico']?>" placeholder="60.30">       
				</div>
                <div class="form-group">  
					<label>Ahorro econ&oacute;mico  &nbsp; <i>%</i></label>
					<input type="text" name="ahorro_economico" value="<?=$row['ahorro_economico']?>" placeholder="50.30">       
				</div>
           	</div>
            <div class="user-form form_extend">
                <div class="form-group">  
					<label>Asignar a Rubro</label>
					<?
                    $ver_rubros = mysql_query("SELECT * FROM rubros WHERE activo=1 ORDER BY nombre ASC");
					if(mysql_num_rows($ver_rubros)>0){
					?>
                    <select name="idrubro" required >
                    	<option value="">Seleccionar rubro...</option>
                        <?
                        while($rub = mysql_fetch_array($ver_rubros)){
						?>
                        <option value="<?=$rub['id_rubro']?>" <? if($rub['id_rubro']==$row['id_rubro']){ ?>selected<? } ?>><?=$rub['nombre']?></option>
                        <?	
						}
						?>
                    </select>
                    <?	
					}
					?>
				</div>
                <div class="form-group" id="buttons"><br />
                	<input type="submit" name="guardar" value="Guardar Cambios">
                </div>
			</div>
            <input type="hidden" name="idpractica" value="<?=$row['id_buena_practica']?>">
            </form>
<?
		} else {
			echo "<div id='error'>Esta pr&aacute;ctica no existe</div>";
		}
	} else {
		echo "<div id='error'>Error en identificador</div>";
	}
}
?>