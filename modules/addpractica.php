<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	if($_SESSION["tipo"]==1){
	
?>
			<h1>Agregar Buena Pr&aacute;ctica</h1>

			<form method="post" action="acciones.php?acc=addpractica" enctype="multipart/form-data">
			<div class="user-form form_extend2">
				<div class="form-group">
					<label>T&iacute;tulo</label>
					</br><span class="bajada">Título para identificar la buena práctica</span>
					<input type="text" name="titulo" value="" required placeholder="T&iacute;tulo de la buena practica">
				</div> 
                <div class="form-group">  
					<label>Cargar imagen</label><br />
				</br><span class="bajada">Imagen que representa la buena práctica</span>
					<input type="file" name="img_folder" style="max-width: 260px;">      
				</div>
                
                
				<div class="form-group">  
					<label>Diagn&oacute;stico inicial</label>
					</br><span class="bajada">Diagnóstico de la situación antes de la buena práctica</span>
					<textarea name="diagnostico_inicial"></textarea>    
				</div> 
                <div class="form-group">  
					<label>Soluci&oacute;n</label>
					</br><span class="bajada">Descripción de la buena práctica y cómo se hace cargo del diagnóstico inicial</span>
					<textarea name="solucion"></textarea>    
				</div> 
                <div class="form-group">  
					<label>Resultado</label>
					</br><span class="bajada">Situación luego de implementada la buena práctica</span>
					<textarea name="resultado"></textarea>    
				</div>
                <div class="form-group">  
					<label>Financiamiento</label>
					</br><span class="bajada">Explicación de cómo fue financiada la buena práctica 
				(por ejemplo: 100% auto-inversión, con aportes estatales, en modo ESCO, etc.)</span>
					<textarea name="financiamiento"></textarea>       
				</div>
                
                 
                
                <div class="form-group">
					<label>Inversi&oacute;n</label>
					</br><span class="bajada">Monto invertido en la buena práctica en <b>pesos chilenos</b></span>
                    <input type="text" name="inversion" required value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
				</div>   
				<div class="form-group">  
					<label>Amortizaci&oacute;n</label>
					</br><span class="bajada">Número de <b>años</b> que tardó o tardará en recuperarse la inversión</span>
					<input type="text" name="amortizacion" required value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>       
				</div>
				<div class="form-group">
					<label>Consumo proceso previo</label>
					</br><span class="bajada"> Consumo energético <b>anual</b> en <b>kWh</b> antes de la implementación de la buena práctica  </span>
					<input type="text" name="consumo_proceso_previo" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
				</div>   
				<div class="form-group">  
					<label>Consumo proceso posterior</label>
					</br><span class="bajada"> Consumo energético <b>anual</b> en <b>kWh</b> después de la implementación de la buena práctica  </span>
					<input type="text" name="consumo_proceso_posterior" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>       
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
					<?
                    $ver_rubros = mysql_query("SELECT * FROM rubros WHERE activo=1 ORDER BY nombre ASC");
					if(mysql_num_rows($ver_rubros)>0){
					?>
                    <select name="idrubro" required >
                    	<option value="">Seleccionar rubro...</option>
                        <?
                        while($rub = mysql_fetch_array($ver_rubros)){
						?>
                        <option value="<?=$rub['id_rubro']?>"><?=$rub['nombre']?></option>
                        <?	
						}
						?>
                    </select>
                    <?	
					}
					?>
				</div>

		        <br />
		        <label>Selecciona la(s) mejora(s) de la buena práctica:</label>
		        <br />
		    	<br />
		    	
		        <?
				$veR_mejoras = mysql_query("SELECT * FROM mejoras WHERE activo=1 ORDER BY nombre ASC");
				if(mysql_num_rows($veR_mejoras)>0){
				?>
		        <div class="twocols">
		            <ul class="mismejoras">
		        	<? while($mejora = mysql_fetch_array($veR_mejoras)){
		                    
		                    //$ver_mejoras_marcadas = mysql_query("SELECT id_mejora FROM mejoras_proveedores WHERE id_proveedor=".$_SESSION['iduser']." AND id_mejora=".$mejora['id_mejora']." LIMIT 1");
		                    //$marcado = '';
		                    //if(mysql_num_rows($ver_mejoras_marcadas)>0){ $marcado = 'checked="checked"'; } 
		            ?>
		                    <li>
		                        <input type="checkbox" class="css-checkbox sme" id="check<?=$mejora['id_mejora']?>" name="idmejora[]" value="<?=$mejora['id_mejora']?>" <?=$marcado?>  />
		                        <label for="check<?=$mejora['id_mejora']?>" class="css-label sme depressed"> &nbsp; <?=$mejora['nombre']?></label>
		                    </li>
		            <? } ?>
		            </ul>
		         </div>
		            <br />
		            <?
				} else {
					echo '<div id="error">No hay mejoras en la base de datos.</div>';	
				}
				?>

                <div class="form-group" id="buttons"><br />
                	<input type="submit" name="agregar" value="Agregar">
                </div>
			</div>


            </form>
<?
		
	} else {
		echo "<div id='error'>Debes ser productor para cargar una buena pr&aacute;ctica</div>";
	}
}
?>