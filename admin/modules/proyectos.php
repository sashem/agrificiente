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
<h1>Proyectos Consultados
<a href="index.php?id=proyectoadd" class="btn btn-primary">Agregar Proyecto</a>
</h1>

<table class="table">
    <thead>
        <tr>
            <th>Rubro</th>
            <th>Nombre</th>
            <th width="70">Porcentaje</th>
            <th width="100">Acciones</th>
        </tr>
    </thead>
    <tbody>
	<?
    $ver_rubros = mysql_query("SELECT proyectos_consultados.*,rubros.nombre as rubro FROM proyectos_consultados,rubros WHERE proyectos_consultados.id_rubro=rubros.id_rubro ORDER BY id_pc ASC,id_rubro ASC  LIMIT ".$inicio.",".$registros."");
	$kpi_resp = mysql_query("SELECT proyectos_consultados.*,rubros.nombre as rubro FROM proyectos_consultados,rubros WHERE proyectos_consultados.id_rubro=rubros.id_rubro");
	$total_r = mysql_num_rows($kpi_resp);
	mysql_free_result($kpi_resp);
	$total_paginas = ceil($total_r / $registros);
	
	if(mysql_num_rows($ver_rubros)>0){
		$hayregistros=true;
		while($rubro = mysql_fetch_array($ver_rubros)){
		?>
        <tr>
        
        	<td><?=$rubro['rubro']?></td>
            <td><?=$rubro['nombre']?></td>
            <td><?=$rubro['porcentaje']?></td>
            <td>
				<div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm" onClick="location.href='index.php?id=proyectoedit&idpc=<?=$rubro['id_pc']?>'">Editar</button>
                      <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        
                        <li><a href="index.php?id=proyectoedit&idpc=<?=$rubro['id_pc']?>">Editar</a></li>
                        <li><a href="../index.php?id=verrubro&rubro=<?=$rubro['id_rubro']?>" target="_blank">Ver en la web</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="funciones.php?acc=delProyectoC&proyecto=<?=$rubro['id_pc']?>" onClick="if(!confirm('&iquest;Eliminar <?=$rubro['nombre']?>?')) { return false; } else { return true; }">Eliminar</a></li>
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
