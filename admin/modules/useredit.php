<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']="1"){
	if((is_numeric($_GET['user']) && strlen($_GET['user'])>0) || (is_numeric($_POST['iduser']) && strlen($_POST['iduser'])>0)){
		if(is_numeric($_GET['user']) && strlen($_GET['user'])>0){
			$id_user = $_GET['user'];
		} elseif(is_numeric($_POST['iduser']) && strlen($_POST['iduser'])>0){
			$id_user = $_POST['iduser'];
		} else {
			$id_user = $_GET['user'];
		}
		
		$ver_tipo_user = mysql_query("SELECT * FROM usuarios WHERE id_user=".$id_user." LIMIT 1");
		if(mysql_num_rows($ver_tipo_user)>0){
			$us = mysql_fetch_array($ver_tipo_user);
		}
		
		
	?>
	<h1>Editar perfil</h1>
	<?
	if(isset($_POST['guardar'])){
			$contrasena = $_POST['clave'];
			$contrasena2 = $_POST['reclave'];
			$ERROR_BACK = "<center id='buttons'><a href='javascript:history.back(1)'>&laquo; Volver Atr&aacute;s</a></center><br><br>";
			if(($contrasena == $contrasena2) && strlen(trim($_POST["password"]))>5  && strlen(trim($_POST["password2"]))>5) {
				$password = md5($_POST['password']);
				$addSQL = "clave='".$password."',";
			}
			$add_sql_passwd = "";
				if(strlen(trim($_POST['clave']))>5 && trim($_POST['clave'])==trim($_POST['reclave'])){
					$add_sql_passwd = "clave='".md5(trim($_POST['clave']))."',";	
				}
				$update_user = mysql_query("UPDATE usuarios SET 
				email='".corregir($_POST['user_email'])."',
				nombre='".corregir(ucfirst($_POST['user_nombre']))."',
				".$add_sql_passwd."
				telefono='".corregir($_POST['user_telefono'])."',
				cargo='".corregir(ucfirst($_POST['user_cargo']))."'
				WHERE id_user=".$us['id_user']."");
				
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
					
					if(mysql_query($update_empresa_proveedor)){
						echo "<div class='valido'>Cambios realizados con &eacute;xito</div><br>";
						?><script>location.href='index.php?id=userficha&user=<?=$id_user?>'</script><?
					} else {
						echo "<div class='invalido'>No se pudieron realizar los cambios</div><br>";		
					}
				}
		
		
	}
	
	$data_user = mysql_query("SELECT * FROM usuarios WHERE id_user=".$id_user." LIMIT 1");
	if(mysql_num_rows($data_user)>0){
		$user = mysql_fetch_array($data_user);
		?>
        
        <form name="form" id="form" action="index.php?id=useredit" method="post">
        
        <?
        if($us['tipo']==1){
			$empresa = mysql_query("SELECT * FROM empresas WHERE id_user=".$user['id_user']." LIMIT 1");
			$row = mysql_fetch_array($empresa);
				
		?>
			<div class="user-form form_extend2">
				<h4>Datos Empresa</h4>
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
					<label>Producci&oacute;n aproximada</label>
					<input type="text" name="produccion" value="<?=$row['produccion']?>">  litros/a&ntilde;o 
				 	<br /><br />
					<label>situacion_gremial</label>
					<input type="text" name="situacion_gremial" value="<?=$row['situacion_gremial']?>">
				</div> 
				<div class="form-group">
					<label>nivel_ventas</label>
					<input type="text" name="nivel_ventas" value="<?=$row['nivel_ventas']?>">
				</div>
				<div class="form-group">
					<label>realizado_eficiencia</label>
					<select name="realizado_eficiencia">
						<option value="">Seleccionar</option>
						<option value="1" <? if($row['realizado_eficiencia']==1){ echo 'selected'; }?> >Si</option>
						<option value="0" <? if($row['realizado_eficiencia']==0){ echo 'selected'; }?> >No</option>
					</select>
				</div>
				<div class="form-group">
					<label>realizado_capacitaciones</label>
					<select name="realizado_capacitaciones">
						<option value="">Seleccionar</option>
						<option value="1" <? if($row['realizado_capacitaciones']==1){ echo 'selected'; }?> >Si</option>
						<option value="0" <? if($row['realizado_capacitaciones']==0){ echo 'selected'; }?> >No</option>
					</select>
				</div>
				<div class="form-group">
					<label>realizado_auditorias</label>
					<select name="realizado_auditorias">
						<option value="">Seleccionar</option>
						<option value="1" <? if($row['realizado_auditorias']==1){ echo 'selected'; }?> >Si</option>
						<option value="0" <? if($row['realizado_auditorias']==0){ echo 'selected'; }?> >No</option>
					</select>
				</div>
				<div class="form-group">
					<label>realizado_implementacion</label>
					<select name="realizado_implementacion">
						<option value="">Seleccionar</option>
						<option value="1" <? if($row['realizado_implementacion']==1){ echo 'selected'; }?> >Si</option>
						<option value="0" <? if($row['realizado_implementacion']==0){ echo 'selected'; }?> >No</option>
					</select>
				</div> 
				<div class="form-group">
					<label>realizado_otras</label>
					<input type="text" name="realizado_otras" value="<?=$row['realizado_otras']?>">
				</div> 
			</div>
			
			<div class="user-form form_extend2">
				<h4>Datos Usuario</h4>
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
                <div class="form-group" id="buttons"><br><input type="submit" name="guardar" value="Guardar Cambios"></div>
			</div>
        <?
        } elseif($us['tipo']==2){ 
			$proveedor = mysql_query("SELECT * FROM proveedores WHERE id_user=".$user['id_user']." LIMIT 1");
			$row = mysql_fetch_array($proveedor);
		?>
			<div class="user-form form_extend2">
				<h3>Datos Proveedor</h3>
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" name="nombre" value="<?=$row['nombre']?>">
				 </div>   
				 <div class="form-group">  
					<label>Tipo</label>
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
					<input type="text" name="produccion" value="<?=$row['produccion']?>">  litros/a&ntilde;o       
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
                <div class="form-group" id="buttons"><br><input type="submit" name="guardar" value="Guardar Cambios"></div>
			</div>
                <?
		}
		?>  
      
        <input type="hidden" name="iduser" value="<?=$us['id_user']?>" /> 	 	 	 
        </form>
        <br /><br />
<? 
	} else {
		?><div id="error">Ok, Esto es raro. Error no identificado</div><?	
	}
	mysql_free_result($data_user);
	
	} else {
		echo "ID Error";	
	}
} else {
	
}
?>
