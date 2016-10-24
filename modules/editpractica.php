<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	if(is_numeric($_GET['practica'])){
	
		if(isset($_SESSION['adminuser'])){
			$ver_practica = mysql_query("SELECT * FROM buenas_practicas WHERE id_buena_practica=".$_GET['practica']." LIMIT 1");
		} else {
			$ver_practica = mysql_query("SELECT * FROM buenas_practicas WHERE id_empresa=".$_SESSION['iduser']." AND id_buena_practica=".$_GET['practica']." LIMIT 1");
		}
		
		if(mysql_num_rows($ver_practica)>0){
			$row = mysql_fetch_array($ver_practica);
?>
			<h1>Modificar Buena Pr&aacute;ctica</h1>

			<form method="post" action="acciones.php?acc=editpractica" enctype="multipart/form-data">
			<div class="user-form form_extend2">
				<h3>Cambiar informaci&oacute;n en <?=$row['titulo']?></h3>
				<div class="form-group">
					<label>T&iacute;tulo</label>
					</br><span class="bajada">Título para identificar la buena práctica</span>
					<input type="text" name="titulo" value="<?=$row['titulo']?>" required placeholder="T&iacute;tulo de la buena practica">
				</div> 
                <div class="form-group">  
					<label>Cargar imagen &nbsp;</label>
					</br><span class="bajada">Imagen que representa la buena práctica (seleccionar para cambiar)</span>
					<input type="file" name="img_folder" style="max-width: 260px;">      
				</div>
                
                
				<div class="form-group">  
					<label>Diagn&oacute;stico inicial</label>
					</br><span class="bajada">Diagnóstico de la situación antes de la buena práctica</span>
					<textarea name="diagnostico_inicial"><?=str_replace("<br>","\n",$row['diagnostico_inicial'])?></textarea>    
				</div> 
                <div class="form-group">  
					<label>Soluci&oacute;n</label>
					</br><span class="bajada">Descripción de la buena práctica y cómo se hace cargo del diagnóstico inicial</span>
					<textarea name="solucion"><?=str_replace("<br>","\n",$row['solucion'])?></textarea>    
				</div> 
                <div class="form-group">  
					<label>Resultado</label>
					</br><span class="bajada">Situación luego de implementada la buena práctica</span>
					<textarea name="resultado"><?=str_replace("<br>","\n",$row['resultado'])?></textarea>    
				</div>
                <div class="form-group">  
					<label>Financiamiento</label>
					</br><span class="bajada">Explicación de cómo fue financiada la buena práctica 
				(por ejemplo: 100% auto-inversión, con aportes estatales, en modo ESCO, etc.)</span>
					<textarea name="financiamiento"><?=str_replace("<br>","\n",$row['financiamiento'])?></textarea>       
				</div>
                
                 
                
                <div class="form-group">
					<label>Inversi&oacute;n</label>
					</br><span class="bajada">Monto invertido en la buena práctica en <b>pesos chilenos</b></span>
                    <input type="text" name="inversion" required value="<?=$row['inversion']?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
				</div>   
				<div class="form-group">  
					<label>Amortizaci&oacute;n</label>
					</br><span class="bajada">Número de <b>años</b> que tardó o tardará en recuperarse la inversión</span>
					<input type="text" name="amortizacion" required value="<?=$row['amortizacion']?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>       
				</div>
				<div class="form-group">
					<label>Consumo proceso previo</label>
					</br><span class="bajada"> Consumo energético <b>anual</b> en <b>kWh</b> antes de la implementación de la buena práctica  </span>
					<input type="text" name="consumo_proceso_previo" value="<?=$row['consumo_proceso_previo']?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
				</div>   
				<div class="form-group">  
					<label>Consumo proceso posterior</label>
					</br><span class="bajada"> Consumo energético <b>anual</b> en <b>kWh</b> después de la implementación de la buena práctica  </span>
					<input type="text" name="consumo_proceso_posterior" value="<?=$row['consumo_proceso_posterior']?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>       
				</div>
                <div class="form-group">  
					<label>Ahorro energ&eacute;tico &nbsp; <i>%</i></label>
					</br><span class="bajada"> Ahorro de la energía consumida por el/los proceso(s) intervenido(s), en <b>% o kWh/año</b> (definir unidad)</span>
					<input type="text" name="ahorro_energetico" value="<?=$row['ahorro_energetico']?>" placeholder="60.30">       
				</div>
                <div class="form-group">  
					<label>Ahorro econ&oacute;mico  &nbsp; <i>%</i></label>
					</br><span class="bajada"> Ahorro de la energía consumida por el/los proceso(s) intervenido(s), en <b>% o pesos chilenos/año</b> (definir unidad) </span>
					<input type="text" name="ahorro_economico" value="<?=$row['ahorro_economico']?>" placeholder="50.30">       
				</div>
           	</div>
            <div class="user-form form_extend">
                <div class="form-group">  
					<label>Asignar a Rubro</label>
					</br><span class="bajada"> Rubro en el cuál la buena práctica fue implementada </span>
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

				<?
				$veR_mejoras = mysql_query("SELECT * FROM mejoras WHERE activo=1 ORDER BY nombre ASC");
				if(mysql_num_rows($veR_mejoras)>0){
				?>
				<h3>Mejoras asociadas a esta buena práctica</h3>
				<span class="bajada">Seleccione el/los tipo(s) de mejora(s) al/a los cuál(es) está asociada esta buena práctica. </span>
				</br></br>	
		        <div class="twocols">
		            <div>
			            <ul class="">
			        	<? while($mejora = mysql_fetch_array($veR_mejoras)){
			                    $ver_mejoras_marcadas = mysql_query("
			                    	SELECT id_mejora 
			                    	FROM buenas_practicas_mejoras 
			                    	WHERE id_buena_practica=".$_GET['practica']." AND id_mejora=".$mejora['id_mejora']." LIMIT 1");
			                    
			                    $marcado = '';
			                    if(mysql_num_rows($ver_mejoras_marcadas)>0){ $marcado = 'checked="checked"'; } 
			            ?>
			                    <li>
			                        <input type="checkbox" class="css-checkbox sme" id="check<?=$mejora['id_mejora']?>" name="idmejora[]" value="<?=$mejora['id_mejora']?>" <?=$marcado?>  />
			                        <label for="check<?=$mejora['id_mejora']?>" class="css-label sme depressed"> &nbsp; <?=$mejora['nombre']?></label>
			                    </li>
			            <? } ?>
			            </ul>
		        	</div>
		     	</div>
		            <br />
		            <?
				} else {
					echo '<div id="error">No hay mejoras en la base de datos.</div>';	
				}
				?>

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