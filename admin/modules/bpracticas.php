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
<h1>Buenas Pr&aacute;cticas</h1>

<table class="table">
    <thead>
        <tr>
            <th>Nombre Proceso</th>
            <th>Rubro</th>
            <th width="100">Acciones</th>
        </tr>
    </thead>
    <tbody>
	<?
    $ver_procesos = mysql_query("SELECT * FROM buenas_practicas ORDER BY titulo ASC LIMIT ".$inicio.",".$registros."");
	$kpi_resp = mysql_query("SELECT * FROM buenas_practicas");
	$total_r = mysql_num_rows($kpi_resp);
	mysql_free_result($kpi_resp);
	$total_paginas = ceil($total_r / $registros);
	
	if(mysql_num_rows($ver_procesos)>0){
		$hayregistros=true;
		while($rubro = mysql_fetch_array($ver_procesos)){
			$ver_rubros = mysql_query("SELECT rubros.nombre,rubros.id_rubro FROM rubros,buenas_practicas WHERE rubros.id_rubro = buenas_practicas.id_rubro AND buenas_practicas.id_buena_practica=".$rubro['id_buena_practica']."");
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
			$btn='success'; 
		?>
        <tr>
            <td><a name="op<?=$rubro['id_buena_practica']?>"></a><?=$rubro['titulo']?></td>
        	<td><? if(strlen($totalx)>6){ echo $totalx; } else { echo "<i style='color:#999'>Buena pr&aacute;ctica no asignada a rubro</i>"; } ?></td>
            <td>
				<div class="btn-group">
                      <button type="button" class="btn btn-<?=$btn?> btn-sm" onClick="location.href='index.php?id=editpractica&practica=<?=$rubro['id_buena_practica']?>'">Editar</button>
                      <button type="button" class="btn btn-<?=$btn?> dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        
                        <li><a href="index.php?id=editpractica&practica=<?=$rubro['id_buena_practica']?>">Editar</a></li>
                        <li><a href="../index.php?id=bpracticas&practica=<?=$rubro['id_buena_practica']?>" target="_blank">Ver en la web</a></li>
                        <li style="display:none"><a onClick="if(!confirm('&iquest;Seguro de eliminar esta buena pr&aacute;ctica?\n<?=$rubro['titulo']?>')) { return false; }" href="funciones.php?acc=borrarPractica&practica=<?=$rubro['id_buena_practica']?>&pag=<?=$_GET['pag']?>">Eliminar</a></li>
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
		paginar_resultados($_GET['id'],$total_paginas,$pagina,$orden);
	}
} else {
	
}
?>
