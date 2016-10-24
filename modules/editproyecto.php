<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	if(isset($_GET['proyecto']) && is_numeric($_GET['proyecto'])){
		if($_SESSION["tipo"]==2){
			if(isset($_SESSION['adminuser'])){
				$ver_proyecto = mysql_query("SELECT *,DATE_FORMAT(fecha_implementacion , '%d') diaa,
					DATE_FORMAT(DATE_SUB(fecha_implementacion, INTERVAL 1 MONTH), '%m') mess,DATE_FORMAT(fecha_implementacion , '%d-%m-%Y') complete_fecha,
					DATE_FORMAT(fecha_implementacion , '%Y') anoo FROM proyectos WHERE id_proyecto=".$_GET['proyecto']." LIMIT 1");
			} else {
				$ver_proyecto = mysql_query("SELECT *,DATE_FORMAT(fecha_implementacion , '%d') diaa,
					DATE_FORMAT(DATE_SUB(fecha_implementacion, INTERVAL 1 MONTH), '%m') mess,DATE_FORMAT(fecha_implementacion , '%d-%m-%Y') complete_fecha,
					DATE_FORMAT(fecha_implementacion, '%Y') anoo FROM proyectos WHERE id_proveedor=".$_SESSION['iduser']." AND id_proyecto=".$_GET['proyecto']." LIMIT 1");
			}
			
			
			if(mysql_num_rows($ver_proyecto)>0){
				$row = mysql_fetch_array($ver_proyecto);
?>
			<h1>Editar Proyecto</h1>

			<form method="post" action="acciones.php?acc=editproyecto" enctype="multipart/form-data">
			<div class="user-form form_extend2">
				<div class="form-group">
					<label>Nombre proyecto</label>
					<input type="text" name="nombre" value="<?=$row['nombre']?>" required placeholder="Nombre del proyecto">
				</div>
				<div class="form-group">
					<label>Rubro</label>
					</br><span class="bajada">Rubro en que se implementó el proyecto</span>
					<Select name="id_rubro" required>
						
							<? $rubros = mysql_query("SELECT DISTINCT id_rubro,nombre from rubros where activo=1");
 							while($rubro = mysql_fetch_array($rubros)){
 								?> <option   value=" <?=$rubro['id_rubro']?> " <? if($rubro['id_rubro']==$row['id_rubro']){ echo 'selected'; } ?> ><?=$rubro['nombre'] ?> </option> <?
 							}
 							?>
						
					</select>
				</div>
                <div class="form-group">
					<label>Empresa</label>
					</br><span class="bajada">Empresa dónde se realizó el proyecto</span>
					<input type="text" name="empresa" value="<?=$row['empresa']?>" required placeholder="Nombre de la empresa">
				</div>
                <div class="form-group">  
					<label>Imagen proyecto &nbsp; <i>Seleccione para cambiar</i></label><br />
				</br><span class="bajada">Imagen del proyecto realizado</span>
					<input type="file" name="img_folder" style="max-width: 260px;">      
				</div>
                <div class="form-group">
					<label>Recurso</label>
					</br><span class="bajada">Tipo de recurso natural aprovechado en la mejora</span>
					<input type="text" name="recurso" value="<?=$row['recurso']?>" placeholder="Recurso">
				</div>
				<div class="form-group">  
					<label>Tipo de energ&iacute;a</label> 
					</br><span class="bajada">Tipo de energía ahorrada o reemplazada</span> 
                    <?
                    $ver_rubros = mysql_query("SELECT * FROM energia ORDER BY energia ASC");
					if(mysql_num_rows($ver_rubros)>0){
					?>
                    <select name="tipo_energia" required >
                        <?
                        while($rub = mysql_fetch_array($ver_rubros)){
						?>
                        <option value="<?=$rub['id_energia']?>" <? if($rub['id_energia']==$row['id_energia']){ echo 'selected'; } ?> ><?=$rub['energia']?></option>
                        <?	
						}
						?>
                    </select>
                    <?	
					}
					?>
				</div> 
                <div class="form-group">  
					<label>Capacidad instalada</label>
					</br><span class="bajada">En caso de ser un proyecto de autogeneración, potencia instalada en <b>kW</b></span>
					<input type="number" name="capacidad_instalada" value="<?=$row['capacidad_instalada']?>" maxlength="2" step="1" min="0" max="99">   
				</div> 
                <div class="form-group">  
					<label>Procesos Intervenidos</label>
				</br><span class="bajada">Procesos industriales que fueron intervenidos por el proyecto</span>
                    <textarea name="procesos_intervenidos"><?=str_replace("<br>","\n",$row['procesos_intervenidos'])?></textarea>   
				</div>  
				<div class="form-group">  
					<label>Tipo de financiamiento</label>
					</br><span class="bajada">Forma en que se financió el proyecto</span>
                    <textarea name="tipo_financiamiento"><?=str_replace("<br>","\n",$row['tipo_financiamiento'])?></textarea>       
				</div>
                <div class="form-group">  
					<label>Ahorro de energ&iacute;a &nbsp; <i>%</i></label>
					</br><span class="bajada">Ahorro porcentual o neto de la energía consumida en el/los proceso(s) intervenido(s). (especificar unidad. ejemplo: 20 kWh/año, 15%)</span>
					<input type="text" name="energia_ahorro" value="<?=$row['energia_ahorro']?>" placeholder="30.50">       
				</div>
                <div class="form-group">
					<label>Porcentaje de ahorro &nbsp; <i>%</i></label>
				</br><span class="bajada">Ahorro porcentual o neto de la energía consumida en el/los proceso(s) intervenido(s). (especificar unidad. ejemplo: 20 kWh/año, 15%)</span>
                    <input type="text" name="porcentaje_ahorro" value="<?=$row['porcentaje_ahorro']?>" placeholder="45.30">
				</div> 
				<div class="form-group">  
					<label>Inversi&oacute;n</label>
				</br><span class="bajada">Monto invertido en el proyecto en <b> Pesos chilenos</b></span>
					<input type="text" name="inversion" required value="<?=$row['inversion']?>" placeholder="300000">       
				</div>
				<div class="form-group">
					<label>Payback esperado</label>
					</br><span class="bajada">Número de años en que se recupera la inversión</span>
					<input type="text" name="payback_esperado" value="<?=$row['payback_esperado']?>" placeholder="3">
				</div> 
                <script type="text/javascript">
				$(window).load(function()
				{
					$('#example1').glDatePicker({
						<? if($row['complete_fecha']!="00-00-0000"){ ?>
						selectedDate: new Date(<?=$row['anoo']?>, <?=$row['mess']?>, <?=$row['diaa']?>),
						<? } ?>
						dowOffset: 1
					});
				});
				</script>
                <div class="form-group">  
					<label>Fecha de implementaci&oacute;n</label>
					</br><span class="bajada">Fecha en la que el proyecto se encontraba/se encontrará operativo</span>
					<input type="text" size="35" name="fecha_implementacion" value="<?=$row['complete_fecha']?>" id="example1" placeholder="dd-mm-yyyy" />
				</div>
                <div class="form-group">  
					<label>Subsidio  &nbsp; <i>$</i></label>
					</br><span class="bajada">En caso de que hubiera subsidio, monto subsidiado en <b> Pesos chilenos</b></span>
					<input type="text" name="subsidio" value="<?=$row['subsidio']?>" placeholder="50000000">       
				</div>
                <div class="form-group">  
					<label>Modelo de negocio</label>
					</br><span class="bajada">Forma en que opera el proyecto como negocio (ESCO, auto-explotación)</span>
                    <textarea name="modelo_negocio"><?=str_replace("<br>","\n",$row['modelo_negocio'])?></textarea>      
				</div>
                <div class="form-group">  
					<label>Rol Proveedor</label>
					</br><span class="bajada">Papel de la empresa proveedora en el proyecto</span>
					<input type="text" name="rol_proveedor" value="<?=$row['rol_proveedor']?>">       
					<br>
					<label>Localizaci&oacute;n</label>
					<input type="text" name="localizacion" value="<?=$row['localizacion']?>">       
				</div>
                
                
            </div>
            <div class="user-form form_extend">
            	<div class="form-group">  
					<label>Descripci&oacute;n</label>
					<textarea name="descripcion"><?=str_replace("<br>","\n",$row['descripcion'])?></textarea>    
				</div>
                <div class="form-group" id="buttons"><br />
                	<input type="submit" name="guardar" value="Guardar Cambios">
                </div>
			</div>
            <input type="hidden" name="idproyecto" value="<?=$row['id_proyecto']?>">
            </form>
<?
			} else {
				echo "<div id='error'>No existe proyecto o no tienes permiso</div>";
			}
		} else {
			echo "<div id='error'>Debes ser productor para cargar una buena pr&aacute;ctica</div>";
		}
	} else {
		echo "<div id='error'>Error de c&oacute;digo</div>";
	}
}
?>