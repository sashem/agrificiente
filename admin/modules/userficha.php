<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
	if(is_numeric($_GET['user']) && strlen($_GET['user'])>0){
	?>
	<h1>Ficha de usuario <a href="index.php?id=useredit&user=<?=$_GET['user']?>" class="glyphicon glyphicon-pencil bigger"></a></h1>
	<?
	$SQL = "SELECT * FROM usuarios WHERE id_user=".$_GET['user']." LIMIT 1";
	
	$users_list = mysql_query($SQL);
	if(mysql_num_rows($users_list)>0){
		
		$user = mysql_fetch_array($users_list);
		$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$user['id_user']." AND principal=1 LIMIT 1");
		$pic = mysql_fetch_array($ver_pic);
		if(strlen($pic['imagen'])>10){
			$profile_pic = "../profiles/".$pic['imagen'];
		} else { 
			$profile_pic = "../img/unknown.png";
		}
		?> 
            	
                
        <div class="user-form form_extend2 table">
            <div class="titulo"><?=$user['nombre']?></div>
            <div style="background-image:url(<?=$profile_pic?>)" class="circ_pic"></div>
            <div class="form-group">
                <label>Nombre</label><br />
                <?=$user['nombre']?>
            </div>
            <div class="form-group">
                <label>Email</label><br />
                <?=$user['email']?>
            </div>
            <div class="form-group">
                <label>Tel&eacute;fono:</label><br />
                <?=$user['telefono']?>
			</div>
            <div class="form-group">
                <label>Tipo:</label><br />
                <? 
                if($user['tipo']==1){ echo 'Productor'; } 
                elseif($user['tipo']==2){ echo 'Proveedor'; } 
                else { echo 'Indefinido'; }
                ?>
			</div>
            <div class="form-group">
                <label>Cargo:</label><br />
                <?=$user['cargo']?>
			</div>
            <div class="form-group">
                <label>Estado:</label><br />
                <? if($user['activo']==1){ echo "Activo"; } else { echo "<strong>Suspendido</strong>"; } ?>
			</div>
        </div>
        
        
        
        
        <?
        if($user['tipo']==1){
			$empresa = mysql_query("SELECT * FROM empresas WHERE id_user=".$user['id_user']." LIMIT 1");
			$row = mysql_fetch_array($empresa);
		?>
        <div class="user-form form_extend2 table">
        	<div class="titulo">Informaci&oacute;n de Empresa</div>
            
            <div class="form-group">
                <label>Empresa:</label><br />
                <?=$row['nombre']?>
			</div>
            <div class="form-group">
                <label>RUT:</label><br />
                <?=$row['rut']?>
			</div>
            <div class="form-group">
                <label>Tel&eacute;fono:</label><br />
                <?=$row['telefono']?>
			</div>
            <div class="form-group">
                <label>Email:</label><br />
                <?=$row['email']?>
			</div>
            <div class="form-group">
                <label>Sitio web:</label><br />
               	<a href="<?=$row['web']?>" target="_blank"><?=$row['web']?></a>
			</div>
            <div class="form-group">
                <label>Rubro:</label><br />
                <?=$row['rubro']?>
			</div>
            <div class="form-group">
                <label>Producci&oacute;n aproximada:</label><br />
                <?=$row['produccion']?> litros/a&ntilde;o
			</div>
            <br /><br /><br />
            <div class="titulo">Otra Informaci&oacute;n</div>
            
            <div class="form-group">
                <label>Situaci&oacute;n gremial:</label><br />
                <?=$row['situacion_gremial']?> NUMERICO
			</div>
            <div class="form-group">
                <label>Nivel de ventas:</label><br />
                $<?=$row['nivel_ventas']?>
			</div>
            <div class="form-group">
                <label>Realizado Eficiencia:</label><br />
                <? if($row['realizado_eficiencia']==1){ echo "Si"; } else { echo "No"; } ?>
			</div>
            <div class="form-group">
                <label>Realizado Capacitaciones:</label><br />
                <? if($row['realizado_capacitaciones']==1){ echo "Si"; } else { echo "No"; } ?>
			</div>
            <div class="form-group">
                <label>Realizado Auditorias:</label><br />
                <? if($row['realizado_auditorias']==1){ echo "Si"; } else { echo "No"; } ?>
			</div>
            <div class="form-group">
                <label>Realizado Implementaci&oacute;n:</label><br />
                <? if($row['realizado_implementacion']==1){ echo "Si"; } else { echo "No"; } ?>
			</div>
            <div class="form-group">
                <label>Realizado otras:</label><br />
                <?=$row['realizado_otras']?>
			</div>
        </div>
        <?
		
		} else {
			$proveedor = mysql_query("SELECT * FROM proveedores WHERE id_user=".$user['id_user']." LIMIT 1");
			$row = mysql_fetch_array($proveedor);
			
		?>
        <div class="user-form form_extend2 table">
        	<div class="titulo">Informaci&oacute;n de Proveedor</div>
            
            <div class="form-group">
                <label>Proveedor:</label><br />
                <?=$row['nombre']?>
			</div>
            <div class="form-group">
                <label>Tel&eacute;fono:</label><br />
                <?=$row['telefono']?>
			</div>
            <div class="form-group">
                <label>Email:</label><br />
                <?=$row['email']?>
			</div>
            <div class="form-group">
                <label>Sitio web:</label><br />
               	<a href="<?=$row['web']?>" target="_blank"><?=$row['web']?></a>
			</div>
            <div class="form-group">
                <label>Rubro:</label><br />
                <?=$row['rubro']?>
			</div>
            <div class="form-group">
                <label>Tipo:</label><br />
                <?=$row['tipo']?>
			</div>
            <div class="form-group">
                <label>Valoraci&oacute;n:</label><br />
                <?=$row['valoracion']?>
			</div>
            <div class="form-group">
                <label>Producci&oacute;n:</label><br />
                <?=$row['produccion']?>
			</div>
        </div>
        <?
		}
		?>
         
         
         
         
         
         
         <?
		
	} else {
		echo "<div id='error'><br><br>No existe usuario</div>";			
	}
	mysql_free_result($users_list);
	
	} else {
		echo "ID Error";	
	}
} else {
	
}
?>
