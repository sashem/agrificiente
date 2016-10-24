<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']=="1"){
	if(isset($_GET['mejora']) && is_numeric($_GET['mejora'])){
	?>
	<h1>Editar Mejora en Rubro</h1>
	<?
	
	$ver_mejoras = mysql_query("SELECT * FROM mejoras WHERE id_mejora=".$_GET['mejora']." LIMIT 1");
	if(mysql_num_rows($ver_mejoras)>0){
		$row = mysql_fetch_array($ver_mejoras);
		?>
        
        <script src="ckeditor/ckeditor.js"></script>
        
        <form name="form" id="form" action="funciones.php?acc=editMejoraRubro" method="post" enctype="multipart/form-data">
        	<div class="user-form form_extend2">
				<h4>Informaci&oacute;n de mejora</h4>
				<div class="form-group">
					<label>Nombre de la mejora</label>
					<input type="text" name="nombre_mejora" value="<?=$row['nombre']?>">
				</div>
             </div>
			<div class="user-form form_extend"> 
                 <div class="form-group">
					<label>Descripci&oacute;n Mejora</label>
                    <textarea name="descripcion" class="ckeditor" id="editor1"><?=$row['descripcion']?></textarea>
				 </div>
            </div>
            <div class="user-form form_extend2">       
                 <h4>Usos</h4>
                 <div class="form-group">
                 	<h3>Calor:</h3>
                    <div class="onoffswitch">
                        <input type="checkbox" name="uso_calor" value="1" class="onoffswitch-checkbox" id="uso_calor" <? if($row['uso_calor']==1){?>checked="checked"<? } ?>>
                        <label class="onoffswitch-label" for="uso_calor">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
				</div>
                <div class="form-group">
                    <h3>Fr&iacute;o:</h3>
                    <div class="onoffswitch">
                        <input type="checkbox" name="uso_frio" value="1" class="onoffswitch-checkbox" id="uso_frio" <? if($row['uso_frio']==1){?>checked="checked"<? } ?>>
                        <label class="onoffswitch-label" for="uso_frio">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">   
                    
                    <h3>Electricidad:</h3>
                    <div class="onoffswitch">
                        <input type="checkbox" name="uso_electricidad" value="1" class="onoffswitch-checkbox" id="uso_electricidad" <? if($row['uso_electricidad']==1){?>checked="checked"<? } ?>>
                        <label class="onoffswitch-label" for="uso_electricidad">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">   
                    
                    <h3>Combustible:</h3>
                    <div class="onoffswitch">
                        <input type="checkbox" name="uso_combustible" value="1" class="onoffswitch-checkbox" id="uso_combustible" <? if($row['uso_combustible']==1){?>checked="checked"<? } ?>>
                        <label class="onoffswitch-label" for="uso_combustible">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                    
                </div>
            </div> 
            
            
            
            
            
            
            <span id="sel" style="display:none">
            <?
			$ver_lista_rubros = mysql_query("SELECT * FROM rubros WHERE activo=1 ORDER BY nombre ASC");
				?>
				<option value="0">Seleccionar o no asignar...</option>
				<?
				while($rubr = mysql_fetch_array($ver_lista_rubros)){ ?>
            	<option value="<?=$rubr['id_rubro']?>"><?=$rubr['nombre']?></option>
                <? } ?>
            </span>
            <span id="valorID" style="display:none">
            	<option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </span>
          	<div class="user-form form_extend"> 
            	<h4>Asignaci&oacute;n a rubros</h4>       
                 <div class="form-group">
                 
                 	<table id="tabla" class="tablaOperaciones">
                        <tr>
                            <th>Valor</th>
                            <th>Rubro</th>
                            <th>Ahorro min</th>
                            <th>Ahorro max</th>
                            <th>Pri min</th>
                            <th>Pri max</th>
                            <th>Fuente</th>
                            <th><a class='btn btn-primary' onclick='addCampo()'> <span class='glyphicon glyphicon-plus'></span></a></th>
                        </tr>
                        <?
                        $ver_rubros_asociados = mysql_query("SELECT * FROM rubros_mejoras WHERE id_mejora=".$row['id_mejora']." ORDER BY id_rubro_mejora ASC");
						$is = 0;
						while($rme = mysql_fetch_array($ver_rubros_asociados)){
						?>
                        <tr>
                        	<td><select type="text" name="valor[]">
                            	<option value="1" <? if($rme['valoracion']=='1'){ echo 'selected="selected"'; } ?> >1</option>
                                <option value="2" <? if($rme['valoracion']=='2'){ echo 'selected="selected"'; } ?> >2</option>
                                <option value="3" <? if($rme['valoracion']=='3'){ echo 'selected="selected"'; } ?> >3</option>
                                <option value="4" <? if($rme['valoracion']=='4'){ echo 'selected="selected"'; } ?> >4</option>
                                <option value="5" <? if($rme['valoracion']=='5'){ echo 'selected="selected"'; } ?> >5</option>
                            </select></td>
                            <td><select type="text" name="idrubro[]">
                            	<option value="0">Seleccionar o no asignar...</option>
                            	<? 
								$ver_lista_rubros2 = mysql_query("SELECT * FROM rubros WHERE activo=1 ORDER BY id_rubro ASC");
								while($rubr2 = mysql_fetch_array($ver_lista_rubros2)){ ?>
                                <option value="<?=$rubr2['id_rubro']?>" <? if($rme['id_rubro']==$rubr2['id_rubro']){ echo 'selected="selected"'; } ?> ><?=$rubr2['nombre']?></option>
                                <? } ?>
                            </select></td>
                            <td><input type="text" name="ahorro_min[]" placeholder="20.60" value="<?=$rme['ahorro_min']?>"></td>
                            <td><input type="text" name="ahorro_max[]" placeholder="50.50" value="<?=$rme['ahorro_max']?>"></td>
                            <td><input type="text" name="pri_min[]" placeholder="1" value="<?=$rme['pri_min']?>"></td>
                            <td><input type="text" name="pri_max[]" placeholder="7" value="<?=$rme['pri_max']?>"></td>
                            <td><input type="text" name="fuente[]" placeholder="Fuente" value="<?=$rme['fuente']?>"></td>
                            <td><a class='btn btn-primary' onclick='eliminarRubroMejora(<?=$rme['id_rubro_mejora']?>),eliminarCampo(this)'><span class='glyphicon glyphicon-trash'></span></a></td>
                        </tr>
                        <?
							$is++;
						}
						?>
                    </table>
				</div>
            
                <div class="form-group" id="buttons"><br /><br /><br />
                    <input type="submit" name="guardar" value="Guardar y Cerrar">
                    <input type="submit" name="guardar" value="Guardar"></div>
			</div>
        <input type="hidden" name="idmejora" value="<?=$row['id_mejora']?>" />	 	 	 
        </form>
        <br /><br />
<? 
		} else {
			echo "Esta mejora no existe.";	
		}
	} else {
		echo "ID Error";	
	}
} else {
	
}
?>
