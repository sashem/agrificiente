<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']=="1"){
	?>
	<h1>Agregar Proceso Productivo</h1>
	
        <script src="ckeditor/ckeditor.js"></script>
        <form name="form" id="form" action="funciones.php?acc=addProceso" method="post">
        
			<div class="user-form form_extend">
				<h4>Informaci&oacute;n del proceso</h4><br />
				<div class="form-group">
					<label>Nombre proceso</label>
					<input type="text" name="nombre" required value="<?=$row['nombre']?>">
				 </div> 
                 <div class="form-group"><br />
					<label>Descripci&oacute;n</label>
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
            
            
            
            <span id="sel2" style="display:none">
            <?
			$ver_lista_rubros = mysql_query("SELECT * FROM rubros WHERE activo=1 ORDER BY nombre ASC");
				?>
				<option value="0">Seleccionar o no asignar...</option>
				<?
				while($rubr = mysql_fetch_array($ver_lista_rubros)){ ?>
            	<option value="<?=$rubr['id_rubro']?>"><?=$rubr['nombre']?></option>
                <? } ?>
            </span>
          	<div class="user-form form_extend"> 
            	<h4>Asignaci&oacute;n a rubros</h4>       
                 <div class="form-group">
                 
                 	<table id="tabla2">
                        <tr>
                            <th>Orden</th>
                            <th>Rubro</th>
                            <th>Consumo Espec&iacute;fico</th>
                            <th>Fuente</th>
                            <th><a class='btn btn-primary' onclick='addCampo2()'> <span class='glyphicon glyphicon-plus'></span></a></th>
                        </tr>
                    </table>
				</div>
            </div>
            
            <div class="user-form form_extend">
            	<div class="form-group" id="buttons">
                    
                    <br><input type="submit" name="guardar" value="Guardar y cerrar">
                    <input type="submit" name="guardar" value="Guardar">
                </div>
			</div> 	 
        </form>
        <br /><br />
<? 
} else {
	
}
?>
