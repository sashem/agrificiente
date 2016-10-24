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
<h1>Mejoras en rubros
<a href="index.php?id=rubromadd" class="btn btn-primary">Agregar Mejora</a>
</h1>
<table class="table" id="main_table">
    <thead>
        <tr>
            <th>T&iacute;tulo Mejora</th>
            <th>Rubro</th>
            <th class="sorttable_nosort" width="100">Acciones</th>
        </tr>
    </thead>
    <tbody>
	<?
    $ver_rubros_mejoras = mysql_query("SELECT * FROM mejoras ORDER BY nombre ASC /*LIMIT ".$inicio.",".$registros."*/");
	$kpi_resp = mysql_query("SELECT * FROM mejoras");
	$total_r = mysql_num_rows($kpi_resp);
	mysql_free_result($kpi_resp);
	$total_paginas = ceil($total_r / $registros);
	
	if(mysql_num_rows($ver_rubros_mejoras)>0){
		$hayregistros=true;
		while($mejora = mysql_fetch_array($ver_rubros_mejoras)){
			$ver_rubros = mysql_query("SELECT rubros.nombre FROM rubros,rubros_mejoras WHERE rubros.id_rubro = rubros_mejoras.id_rubro AND rubros_mejoras.id_mejora=".$mejora['id_mejora']."");
			$i = 0;
			$totalx = "";
			while($rubro = mysql_fetch_array($ver_rubros)){
				if($i==0){
					$totalx = $rubro['nombre'];
				} else {
					$totalx = $rubro['nombre']." + (".(mysql_num_rows($ver_rubros)-1).")";
				}
				$i++;
			}
		
			
			if($mejora['activo']==1){ $btn='success'; } else { $btn='danger'; }
		?>
        <tr>
        	<td><?=$mejora['nombre']?></td>
        	<td><? if(strlen($totalx)>6){ echo $totalx; } else { echo "<i style='color:#999'>Mejora no asignada a rubro</i>"; } ?></td>
            <td>
				<div class="btn-group">
                      <button type="button" class="btn btn-<?=$btn?> btn-sm" onClick="location.href='index.php?id=rubromedit&mejora=<?=$mejora['id_mejora']?>'">Editar</button>
                      <button type="button" class="btn btn-<?=$btn?> dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        
                        <li><a href="index.php?id=rubromedit&mejora=<?=$mejora['id_mejora']?>">Editar</a></li>
                        <li><a href="../index.php?id=mejoras&mejora=<?=$mejora['id_mejora']?>" target="_blank">Ver en la web</a></li>
                        
                        <li role="separator" class="divider"></li>
                        <? if($mejora['activo']==1){ ?>
                        <li><a href="funciones.php?acc=suspendMejRubro&mejora=<?=$mejora['id_mejora']?>">Desactivar</a></li>
                        <? } else { 
                        ?>
                        <li><a href="funciones.php?acc=unsuspendMejRubro&mejora=<?=$mejora['id_mejora']?>">Activar</a></li>
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
        <?
	} else {
		$hayregistros=false;
		echo "<tr><td colspan='3'><center><br><br>No hay mejoras creadas.<br><br><br></center></td></tr>";	
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
