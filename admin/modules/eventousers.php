<?
//ini_set('display_errors',0);
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
	if(isset($_GET['evento']) && is_numeric($_GET['evento'])){
		
		$data_evento = mysql_query("SELECT * FROm eventos WHERE id_evento=".$_GET['evento']." LIMIT 1");
		if(mysql_num_rows($data_evento)>0){
		$row = mysql_fetch_array($data_evento);
	?>
	
	<h1>Usuarios que asistir&aacute;n al evento</h1>
	
        
			<div class="user-form form_extend2">
            	<h4>Evento: <?=$row['nombre']?></h4>
                
                <?
                $i=1;
                $ver_inscritos = mysql_query("
                	SELECT 	usuarios.id_user 
                			,usuarios.nombre
                			,usuarios.email
                			,usuarios.tipo
                			,usuarios.cargo
                			,usuarios.telefono  
                	FROM eventos_usuarios,usuarios 
                	WHERE eventos_usuarios.id_user=usuarios.id_user 
                		AND eventos_usuarios.id_evento = ".$_GET['evento'].""
                	);

                if(mysql_num_rows($ver_inscritos)>0){
				    
                ?>

				<div style="width:100%;">
				<table class="table">
					<thead>
                        <th>#</th>
						<th>Empresa</th>
                        <th>Nombre</th>
						<th>Cargo</th>
						<th>Teléfono</th>
						<th>Email</th>
						<th>Tipo</th>
					</thead>
					<tbody>
                    	<? while($user = mysql_fetch_array($ver_inscritos)){ 
                            if($user["tipo"]==1){
                                $aux_empresa = mysql_fetch_array(mysql_query("SELECT nombre FROM empresas where id_user = ".$user['id_user']));
                            }if($user["tipo"]==2){
                                $aux_empresa = mysql_fetch_array(mysql_query("SELECT nombre from proveedores where id_user =".$user['id_user']));
                            }
                            ?>
                    	<tr>
                            <td><?=$i?></td>
                            <td><?=$aux_empresa["nombre"]?></td>
                    		<td><a href="../index.php?id=profile&user=<?=$user['id_user']?>" target="_blank">
                    		<?=$user['nombre']?>
                    		</a></td>
                    		<td><?=$user['cargo']?></td>
                    		<td><?=$user['telefono']?></td>
                    		<td><?=$user['email']?></td>
                    		<td><?if($user['tipo']==1) echo "Productor"; else echo "Proveedor";?></td>
                    	</tr>
                        <? $i++;} ?>
                    </tbody>
				</table>
				<br><br>

				<h4>Usuarios invitados</h4>

				<table class="table">
					<thead>
						<th>#</th> 
                        <th>Empresa</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Borrar</th>
					</thead>
					<tbody>
			<?
                	$ver_inscritos = mysql_query("
                	SELECT	id_invitado
                			,empresa
                			,nombre
                			,email  
                	FROM invitados_eventos 
                	WHERE id_evento= ".$_GET['evento'].""
                	);
             ?>
                    	<? $i= 1; while($user = mysql_fetch_array($ver_inscritos)){ ?>
                    	<tr>
                            <td><?=$i?></td>
                    		<td><?=$user['empresa']?></td>
                    		<td><?=$user['nombre']?></td>
                    		<td><?=$user['email']?></td>
                    		<td><a onclick="deleteInvitado(<?=$user['id_invitado']?>)" class="btn btn-warning">X</a></td>
                    	</tr>
                        <? $i++;} ?>
                    </tbody>
				</table>
				</div>

                <?
				} else {
					echo "<br><br>No hay usuarios inscritos a este evento";
				}
				?>

            </div>
            <div class="user-form form_extend">
                <div class="form-group" id="buttons"><br><input type="button" onclick="history.back()" value="Volver"></div>
			</div>	
            <input type="hidden" name="id_evento" value="<?=$row['id_evento']?>" />   	 	 
        </form>
        <br /><br />
<? 
		} else {
			echo "Este evento no existe.";	
		}
		
	} else {
		echo "ID Error";	
	}
} else {
	
}
?>
