<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']=="1"){
	?>
	<h1>Agregar Mejora en Rubro</h1>
        
        <script src="ckeditor/ckeditor.js"></script>
        
        <form name="form" id="form" action="funciones.php?acc=addMejoraRubro" method="post" enctype="multipart/form-data">
        
			<div class="user-form form_extend2">
				<h4>Informaci&oacute;n de mejora</h4>
				<div class="form-group">
					<label>Nombre de la mejora</label>
					<input type="text" name="nombre_mejora" value="" required >
				 </div>
             </div> 
             <div class="user-form form_extend">   
                 <div class="form-group">
					<label>Descripci&oacute;n Mejora</label>
                    <textarea name="descripcion" class="ckeditor" id="editor1"></textarea>
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
			$ver_lista_rubros = mysql_query("SELECT * FROM rubros WHERE activo=1 ORDER BY id_rubro ASC");
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
                 
                 	<table id="tabla">
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
                    </table>
				</div>
            </div>
            <div class="user-form form_extend">
				
                <div class="form-group" id="buttons"><br>
                    <input type="submit" name="guardar" value="Guardar y Cerrar">
                    <input type="submit" name="guardar" value="Guardar"></div>
			</div>	 	 	 
        </form>
        <br /><br />
<? 
} else {
	
}
?>
