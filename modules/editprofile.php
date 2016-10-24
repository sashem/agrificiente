<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	$ver_tipo_user = mysql_query("SELECT * FROM usuarios WHERE id_user=".$_SESSION['iduser']." LIMIT 1");
	if(mysql_num_rows($ver_tipo_user)>0){
		$us = mysql_fetch_array($ver_tipo_user);
		
		
		if(isset($_POST['guardar'])){
			//clave
			$add_sql_passwd = "";
			if(strlen(trim($_POST['clave']))>5 && trim($_POST['clave'])==trim($_POST['reclave'])){
				$add_sql_passwd = "clave='".md5(trim($_POST['clave']))."',";	
			}
			mysql_query("UPDATE usuarios SET correo_catalogos=0, correo_proyectos=0 WHERE id_user=".$us['id_user']."");
			
			$update_user = mysql_query("UPDATE usuarios SET 
			email='".corregir($_POST['user_email'])."',
			nombre='".corregir(ucfirst($_POST['user_nombre']))."',
			".$add_sql_passwd."
			telefono='".corregir($_POST['user_telefono'])."',
			cargo='".corregir(ucfirst($_POST['user_cargo']))."',
			correo_catalogos='".$_POST['correo_catalogos']."',
			correo_proyectos='".$_POST['correo_proyectos']."'
			WHERE id_user=".$us['id_user']."");
			
			/* Para COOKIES */
			$_SESSION['email'] = trim($_POST['user_email']);
			@mysql_query("UPDATE cookies SET email='".$_SESSION['email']."' WHERE id_user=".$us['id_user']."");
			
			if($update_user){
				if($us['tipo']==1){ //empresa - productor
					$update_empresa_proveedor = "UPDATE empresas SET
					`nombre` = '".corregir(ucfirst($_POST['nombre']))."',
					`rut` = '".corregir($_POST['rut'])."',
					`descripcion` = '".corregir(str_replace("\n","<br>",$_POST['descripcion']))."',
					`email` = '".corregir($_POST['email'])."',
					`telefono` = '".corregir($_POST['telefono'])."',
					`web` = 'http://".corregir(str_replace("http://","",$_POST['web']))."',
					`rubro` = '".corregir($_POST['rubro'])."',
					`produccion` = '".corregir($_POST['produccion'])."',
					`situacion_gremial` = '".($_POST['situacion_gremial'])."',
					`nivel_ventas` = '".($_POST['nivel_ventas'])."',
					`realizado_eficiencia` = '".($_POST['realizado_eficiencia'])."',
					`realizado_capacitaciones` = '".($_POST['realizado_capacitaciones'])."',
					`realizado_auditorias` = '".($_POST['realizado_auditorias'])."',
					`realizado_implementacion` = '".($_POST['realizado_implementacion'])."',
					`realizado_otras` = '".corregir($_POST['realizado_otras'])."'
					WHERE id_user=".$us['id_user']."";
				} elseif($us['tipo']==2){ //proveedor
					$update_empresa_proveedor = "UPDATE proveedores SET
					`nombre` = '".corregir(ucfirst($_POST['nombre']))."',
					`descripcion` = '".corregir(str_replace("\n","<br>",$_POST['descripcion']))."',
					`email` = '".corregir($_POST['email'])."',
					`telefono` = '".corregir($_POST['telefono'])."',
					`rubro` = '".corregir($_POST['rubro'])."',
					`web` = 'http://".corregir(str_replace("http://","",$_POST['web']))."',
					`produccion` = '".corregir($_POST['produccion'])."',
					`tipo` = '".corregir(ucfirst($_POST['tipo']))."'
					WHERE id_user=".$us['id_user']."";
				}
				@mysql_query($update_empresa_proveedor);
			}
			//echo "Cambiado";
			?><script>location.href='index.php?id=profile&user=<?=$_SESSION['iduser']?>'</script><?
		} else {
		
		
		
			if($us['tipo']==1){
				$empresa = mysql_query("SELECT * FROM empresas WHERE id_user=".$us['id_user']." LIMIT 1");
				$row = mysql_fetch_array($empresa);
				
				$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$us['id_user']." AND principal=1 LIMIT 1");
				$pic = mysql_fetch_array($ver_pic);
				
			?>
			<form method="post" action="index.php?id=editprofile">
			
			<div class="user-form form_extend2">
				<h3>Datos Empresa</h3>
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombre" value="<?=$row['nombre']?>">
				 </div> 
                 <div class="form-group">
					<label>RUT</label>
					<input type="text" name="rut" value="<?=$row['rut']?>">
				 </div>   
				 <div class="form-group">  
					<label>Tel&eacute;fono</label>
					<input type="text" name="telefono" value="<?=$row['telefono']?>">       
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" value="<?=$row['email']?>">
				 </div>   
				 <div class="form-group">  
					<label>Sitio web</label>
					<input type="text" name="web" value="<?=$row['web']?>">       
				</div>
				<div class="form-group">
					<label>Rubro</label>
					<input type="text" name="rubro" value="<?=$row['rubro']?>">
				 </div> 
				<div class="form-group">  
					<label>Descripci&oacute;n Empresa</label>
					<textarea name="descripcion"><?=str_replace("<br>","\n",$row['descripcion'])?></textarea>    
				</div>  
				<div class="form-group">
					<label>Nivel de ventas</label>
					<div class="bajada">Indicar valor aproximado en pesos chilenos</div>
					<input type="text" name="nivel_ventas" value="<?=$row['nivel_ventas']?>">
				</div>
				<div class="form-group">
					<label>¿En su empeza existe un área de eficiencia energética y/o energías renovables?</label>
					<select name="realizado_eficiencia">
						<option value="">Seleccionar</option>
						<option value="1" <? if($row['realizado_eficiencia']==1){ echo 'selected'; }?> >Si</option>
						<option value="0" <? if($row['realizado_eficiencia']==0){ echo 'selected'; }?> >No</option>
					</select>
				</div>
				<div class="form-group">
					<label>¿Ha realizado capacitaciones de eficiencia energética y/o energías renovables?</label>
					<select name="realizado_capacitaciones">
						<option value="">Seleccionar</option>
						<option value="1" <? if($row['realizado_capacitaciones']==1){ echo 'selected'; }?> >Si</option>
						<option value="0" <? if($row['realizado_capacitaciones']==0){ echo 'selected'; }?> >No</option>
					</select>
				</div>
				<div class="form-group">
					<label>¿Ha realizado auditorías energéticas?</label>
					<select name="realizado_auditorias">
						<option value="">Seleccionar</option>
						<option value="1" <? if($row['realizado_auditorias']==1){ echo 'selected'; }?> >Si</option>
						<option value="0" <? if($row['realizado_auditorias']==0){ echo 'selected'; }?> >No</option>
					</select>
				</div>
				<div class="form-group">
					<label>¿Ha implementado medidas de eficiencia energética y/o energías renovables?</label>
					<select name="realizado_implementacion">
						<option value="">Seleccionar</option>
						<option value="1" <? if($row['realizado_implementacion']==1){ echo 'selected'; }?> >Si</option>
						<option value="0" <? if($row['realizado_implementacion']==0){ echo 'selected'; }?> >No</option>
					</select>
				</div> 
				<div class="form-group">
					<label>¿Ha realizado otro tipo de actividades relacionadas con la eficiencia energética y/o las energías renovables?</label>
					<input type="text" name="realizado_otras" value="<?=$row['realizado_otras']?>">
				</div> 
			</div>
			
			<div class="user-form form_extend2">
				<h3>Datos Usuario</h3>
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="user_nombre" value="<?=$us['nombre']?>">
				 </div>   
				 <div class="form-group">  
					<label>Tel&eacute;fono</label>
					<input type="text" name="user_telefono" value="<?=$us['telefono']?>">       
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="user_email" value="<?=$us['email']?>">
				 </div>   
				 <div class="form-group">  
					<label>Cargo</label>
					<input type="text" name="user_cargo" value="<?=$us['cargo']?>">       
				</div>
                <div class="form-group">
                    <label>Contrase&ntilde;a </label><i>Llenar para cambiarla</i>
                    <input type="password" name="clave" placeholder="Ingresar contrase&ntilde;a si desea modificarla" pattern="[a-zA-Z0-9_-]{6,12}"  title="Alfanumericos 6-12 caracteres"  />
                </div>
                <div class="form-group">
                    <label>Reescribir contrase&ntilde;a</label>
                    <input type="password" name="reclave" placeholder="Reingrese su contrase&ntilde;a a modificar" pattern="[a-zA-Z0-9_-]{6,12}"  title="Alfanumericos 6-12 caracteres" />
                </div>
                
                <br /><br /><br />
                <h3>Env&iacute;o de emails (no en requerimientos iniciales - PDF)</h3>
				<div class="form-group">
					<ul>
                        <li>
                            <input type="checkbox" id="check1" name="correo_catalogos" value="1" <? if($us['correo_catalogos']==1){ echo 'checked="checked"'; }?>   />
                            <label for="check1"> &nbsp; Recibir correos de nuevos cat&aacute;logos</label>
                        </li>
                        <li>
                            <input type="checkbox" id="check2" name="correo_proyectos" value="1" <? if($us['correo_proyectos']==1){ echo 'checked="checked"'; }?>   />
                            <label for="check2"> &nbsp; Recibir correos de nuevos proyectos</label>
                        </li>
                    </ul>
				</div>
                
                <div class="form-group" id="buttons"><input type="submit" name="guardar" value="Guardar Cambios"></div>
			</div>
			</form>
			
			
			
			<? 
			} elseif($us['tipo']==2){ 
				$proveedor = mysql_query("SELECT * FROM proveedores WHERE id_user=".$us['id_user']." LIMIT 1");
				$row = mysql_fetch_array($proveedor);
				
				
				$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$us['id_user']." AND principal=1 LIMIT 1");
				$pic = mysql_fetch_array($ver_pic);
				
			?>
			
			<form method="post" action="index.php?id=editprofile">
			<div class="user-form form_extend2">
				<h3>Datos Proveedor</h3>
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombre" value="<?=$row['nombre']?>">
				 </div>   
				 <div class="form-group">  
					<label>Tipo (consultora, proveedor de equipos,…)</label>
					<input type="text" name="tipo" value="<?=$row['tipo']?>" placeholder="Ejemplo: Consultora">       
				</div>
				<div class="form-group">  
					<label>Tel&eacute;fono</label>
					<input type="text" name="telefono" value="<?=$row['telefono']?>">       
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" value="<?=$row['email']?>">
				 </div>   
				 <div class="form-group">  
					<label>Sitio web</label>
					<input type="text" name="web" value="<?=$row['web']?>">       
				</div>  
				<div class="form-group">  
					<label>Producci&oacute;n aproximada</label>
					<input type="text" name="produccion" value="<?=$row['produccion']?>">  ejemplo: 1.000.000 kg/año, litros/año, ton/año       
				</div>
				<div class="form-group">  
					<label>Descripci&oacute;n Empresa</label>
					<textarea name="descripcion"><?=str_replace("<br>","\n",$row['descripcion'])?></textarea>    
				</div>
			</div>
			
			<div class="user-form form_extend2">
				<h3>Datos Usuario</h3>
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="user_nombre" value="<?=$us['nombre']?>">
				 </div>   
				 <div class="form-group">  
					<label>Tel&eacute;fono</label>
					<input type="text" name="user_telefono" value="<?=$us['telefono']?>">       
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="user_email" value="<?=$us['email']?>">
				 </div>  
				 <div class="form-group">  
					<label>Cargo</label>
					<input type="text" name="user_cargo" value="<?=$us['cargo']?>">       
				</div>
                <div class="form-group">
                    <label>Contrase&ntilde;a </label><i>Llenar para cambiarla</i>
                    <input type="password" name="clave" placeholder="Ingresar contrase&ntilde;a si desea modificarla" pattern="[a-zA-Z0-9_-]{6,12}"  title="Alfanumericos 6-12 caracteres"  />
                </div>
                <div class="form-group">
                    <label>Reescribir contrase&ntilde;a</label>
                    <input type="password" name="reclave" placeholder="Reingrese su contrase&ntilde;a a modificar" pattern="[a-zA-Z0-9_-]{6,12}"  title="Alfanumericos 6-12 caracteres" />
                </div>
                
                
                <br /><br /><br />
                <h3>Env&iacute;o de emails (no en requerimientos iniciales - PDF)</h3>
				<div class="form-group">
					<ul>
                        <li>
                            <input type="checkbox" id="check1" name="correo_catalogos" value="1" <? if($us['correo_catalogos']==1){ echo 'checked="checked"'; }?> />
                            <label for="check1"> &nbsp; Recibir correos de nuevos cat&aacute;logos de otros proveedores</label>
                        </li>
                        <li>
                            <input type="checkbox" id="check2" name="correo_proyectos" value="1" <? if($us['correo_proyectos']==1){ echo 'checked="checked"'; }?> />
                            <label for="check2"> &nbsp; Recibir correos de nuevos proyectos</label>
                        </li>
                    </ul>
				</div>
                
                
                
                
                <div class="form-group" id="buttons"><input type="submit" name="guardar" value="Guardar Cambios"></div>
			</div>
            </form>
			<? 
			}
		
		
			
		}
		
		 
	} else {
		echo "<div id='error'>No existe usuario</div>";
	}
} else {
	echo "<div id='error'>Error de usuario</div>";
}
?>      