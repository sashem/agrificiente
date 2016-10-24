<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']="1"){

	if(is_numeric($_GET['pag'])){
		$pagina = $_GET['pag'];
	} else {
		$pagina = 1;
	}
	$registros = 50;
	if (!$pagina) {
		$inicio = 0;
		$pagina = 1;
	} else {
		$inicio = ($pagina - 1) * $registros;
	}
	
	if(isset($_GET['ordenar']) && strlen($_GET['ordenar'])>2){
		if($_GET['ordenar']=='nombre'){
			$sql_add_consulta = "ORDER BY ".$_GET['ordenar']." ASC";	
		}
		elseif($_GET['ordenar']=='email'){
			$sql_add_consulta = "ORDER BY email ASC";	
		} elseif($_GET['ordenar']=='tipo'){
			$sql_add_consulta = "ORDER BY tipo ASC";	
		}
	} else {
		$sql_add_consulta = "ORDER BY id_user DESC";
	}
	$SQL = "SELECT id_user,nombre,email,activo,tipo FROM usuarios WHERE 1=1 ".$sql_add_consulta." LIMIT ".$inicio.",".$registros."";
	
	$users_list = mysql_query($SQL);
	
		$kpi_resp = mysql_query("SELECT id_user FROM usuarios WHERE activo=1");
		$total_r = mysql_num_rows($kpi_resp);
		mysql_free_result($kpi_resp);
		$total_paginas = ceil($total_r / $registros);
	?>
    <h1>Usuarios (<?=$total_r?>)</h1>
    <?
	if(mysql_num_rows($users_list)>0){
		$hayregistros=true;
		
		?>
        <table class="table table-users">
            <thead>
                <tr>
                    <th width="60"></th>
                    <th><a href="index.php?id=<?=$_GET['id']?>&pag=<?=$pagina?>&ordenar=nombre" class="<? if($_GET['ordenar']=='nombre'){ echo 'marked'; } ?>">Nombre</a></th>
                    <th><a href="index.php?id=<?=$_GET['id']?>&pag=<?=$pagina?>&ordenar=email" class="<? if($_GET['ordenar']=='email'){ echo 'marked'; } ?>">Email</a></th>
                    <th width="130"><a href="index.php?id=<?=$_GET['id']?>&pag=<?=$pagina?>&ordenar=tipo" class="<? if($_GET['ordenar']=='tipo'){ echo 'marked'; } ?>">Tipo</a></th>
                    <th width="140">Acciones</th>
                </tr>
            </thead>
            <tbody>
        <?
		while($user = mysql_fetch_array($users_list)){
			$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$user['id_user']." AND principal=1 LIMIT 1");
			$pic = mysql_fetch_array($ver_pic);
			$explode_name = explode(" ",$user['nombre']); 
			if(strlen($pic['imagen'])>10){
				$profile_pic = "../profiles/".$pic['imagen'];
			} else { 
				$profile_pic = "../img/unknown.png";
			}
			?> 
            	<tr class="suspend<?=$user['suspendido']?>">
                	<td>
                    	<a href="../index.php?id=profile&user=<?=$user['id_user']?>" target="_blank" style="background-image:url(<?=$profile_pic?>)" class="circ_pic"></a>
                    </td>
                    <td><?=$explode_name[0]?></td>
                    <td><?=strtolower($user['email'])?></td>
                    <td>
                    <?
                    if($user['tipo']==1){ $type='Productor'; } else { $type='Proveedor'; }
					echo $type;
					?>
                    </td>
                    <?
                    if($user['activo']==1){ $btn='success'; } else { $btn='danger'; }
					?>
                    <td>
                    	<div class="btn-group">
                          <button type="button" class="btn btn-<?=$btn?> btn-sm" onClick="location.href='index.php?id=userficha&user=<?=$user['id_user']?>'">Ver Ficha</button>
                          <button type="button" class="btn btn-<?=$btn?> dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="index.php?id=userficha&user=<?=$user['id_user']?>">Ver Ficha</a></li>
                            <li><a href="index.php?id=useredit&user=<?=$user['id_user']?>">Editar</a></li>
                            <li><a href="funciones.php?acc=userlogin&pag=<?=$pagina?>&user=<?=$user['id_user']?>" target="_blank">Entrar como</a></li>
                            <li role="separator" class="divider"></li>
                            <? if($user['activo']==1){ ?>
                            <li><a href="funciones.php?acc=suspend&user=<?=$user['id_user']?>&pag=<?=$pagina?>">Suspender</a></li>
                            <? } else { 
							?>
                            <li><a href="funciones.php?acc=unsuspend&user=<?=$user['id_user']?>&pag=<?=$pagina?>">Volver a activar</a></li>
                            <?
							} 
							?>
                          </ul>
                        </div>
                    </td>
                </tr>
            <?
		}
		?>
        	</tbody>
        </table>
        <?
	} else {
		$hayregistros=false;
		echo "<div id='error'><br><br>No hay usuarios</div>";			
	}
	mysql_free_result($users_list);
	
	if(isset($_GET['ordenar']) && $_GET['ordenar']!=NULL){
		$orden = "&ordenar=".$_GET['ordenar'];
	} else {
		$orden = "";
	}
	if($hayregistros==true && $total_paginas>1){
		paginar_resultados($_GET['id'],$total_paginas,$pagina,$orden);
	}
	
	
} else {
	
}
?>
