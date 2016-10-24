<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']=="1"){
	if(is_numeric($_GET['pag'])){
		$pagina = $_GET['pag'];
	} else {
		$pagina = 1;
	}
	$registros = 30;
	if (!$pagina) {
		$inicio = 0;
		$pagina = 1;
	} else {
		$inicio = ($pagina - 1) * $registros;
	}
?>
<h1>Procesos Productivos
<a href="index.php?id=procesoadd" class="btn btn-primary">Agregar Proceso</a>
</h1>

<table class="table" id="main_table">
    <thead>
        <tr>
            <th>Nombre Proceso</th>
            <th>Rubro</th>
            <th>Productos</th>
            <th width="100">Acciones</th>
        </tr>
    </thead>
    <tbody>
	<?
    $ver_procesos = mysql_query("SELECT * FROM operaciones ORDER BY nombre /*ASC LIMIT ".$inicio.",".$registros."*/");
	$kpi_resp = mysql_query("SELECT * FROM operaciones");
	$total_r = mysql_num_rows($kpi_resp);
	mysql_free_result($kpi_resp);
	$total_paginas = ceil($total_r / $registros);
	
	if(mysql_num_rows($ver_procesos)>0){
		$hayregistros=true;
		while($rubro = mysql_fetch_array($ver_procesos)){
			$ver_rubros = mysql_query("SELECT rubros.nombre,rubros.id_rubro FROM rubros,rubros_operaciones WHERE rubros.id_rubro = rubros_operaciones.id_rubro AND rubros_operaciones.id_operacion=".$rubro['id_operacion']."");
			$i = 0;
			$totalx = "";
			while($ru = mysql_fetch_array($ver_rubros)){
				$irubro = $ru['id_rubro'];
				if($i==0){
					$totalx = $ru['nombre'];
				} else {
					$totalx = $ru['nombre']." + (".(mysql_num_rows($ver_rubros)-1).")";
				}
				$i++;
			}
			if($rubro['activo']==1){ $btn='success'; } else { $btn='danger'; }
		?>
        <tr>
            <td><a name="op<?=$rubro['id_operacion']?>"></a><?=$rubro['nombre']?></td>
        	<td><? if(strlen($totalx)>6){ echo $totalx; } else { echo "<i style='color:#999'>Operaci&oacute;n no asignada a rubro</i>"; } ?></td>
            <td>
            	<?
				$sql_get_productos = "SELECT DISTINCT producto FROM rubros_operaciones WHERE id_operacion=".$rubro['id_operacion'];
		        //$sql_get_productos = "SELECT producto FROM rubros_operaciones WHERE id_rubro=".$rubro['id_rubro']." GROUP BY producto";
		        $raux = mysql_query($sql_get_productos);
		        while($producto = mysql_fetch_array($raux)){
		            if(strlen($producto['producto'])>1){
		                echo $producto['producto'].",";
		            }
		        }
            	 ?>
            </td>
            <td>
				<div class="btn-group">
                      <button type="button" class="btn btn-<?=$btn?> btn-sm" onClick="location.href='index.php?id=procesoedit&proceso=<?=$rubro['id_operacion']?>'">Editar</button>
                      <button type="button" class="btn btn-<?=$btn?> dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        
                        <li><a href="index.php?id=procesoedit&proceso=<?=$rubro['id_operacion']?>">Editar</a></li>
                        <li><a href="../index.php?id=verrubro&rubro=<?=$irubro?>#ficha_proceso" target="_blank">Ver en la web</a></li>
                        <li role="separator" class="divider"></li>
                        <? if($rubro['activo']==1){ ?>
                        <li><a href="funciones.php?acc=delproceso&proceso=<?=$rubro['id_operacion']?>&pag=<?=$_GET['pag']?>">Desactivar</a></li>
                        <? } else { 
                        ?>
                        <li><a href="funciones.php?acc=activarProceso&proceso=<?=$rubro['id_operacion']?>&pag=<?=$_GET['pag']?>">Activar</a></li>
                        <?
                        } 
                        ?>
                        <li><a onClick="if(!confirm('&iquest;Seguro de eliminar este proceso?\n<?=$rubro['nombre']?>')) { return false; }" href="funciones.php?acc=borrarProceso&proceso=<?=$rubro['id_operacion']?>&pag=<?=$_GET['pag']?>">Eliminar</a></li>
                      </ul>
                </div>
            </td>
            
        </tr>
        <?	
		}
		?>
        <?
	} else {
		$hayregistros=false;
		echo "<tr><td colspan='4'><center><br><br>No hay proyectos creados.<br><br><br></center></td></tr>";
	}
	?>
	</tbody>
</table>
<?
	$orden = "";
	if($hayregistros==true && $total_paginas>1){
		//paginar_resultados($_GET['id'],$total_paginas,$pagina,$orden);
	}
} else {
	
}
?>
