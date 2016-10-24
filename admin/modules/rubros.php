<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']=="1"){
	if(is_numeric($_GET['pag'])){
		$pagina = $_GET['pag'];
	} else {
		$pagina = 1;
	}
	$registros = 15;
	if (!$pagina) {
		$inicio = 0;
		$pagina = 1;
	} else {
		$inicio = ($pagina - 1) * $registros;
	}
?>
<h1>Rubros
<a href="index.php?id=rubroadd" class="btn btn-primary">Agregar Rubro</a>
</h1>

<table class="table">
    <thead>
        <tr>
            <th class="sorttable_nosort" width="60"></th>
            <th>T&iacute;tulo Rubro</th>
            <th class="sorttable_nosort" width="100">Acciones</th>
        </tr>
    </thead>
    <tbody>
	<?
    $ver_rubros = mysql_query("SELECT id_rubro,nombre,imagen,activo FROM rubros ORDER BY id_rubro ASC LIMIT ".$inicio.",".$registros."");
	$kpi_resp = mysql_query("SELECT id_rubro FROM rubros");
	$total_r = mysql_num_rows($kpi_resp);
	mysql_free_result($kpi_resp);
	$total_paginas = ceil($total_r / $registros);
		
	if(mysql_num_rows($ver_rubros)>0){
		$hayregistros=true;
		while($rubro = mysql_fetch_array($ver_rubros)){
		?>
        <tr>
        
        	<td><img src="../iconos/<?=$rubro['imagen']?>" style="max-width:79px; max-height:61px;"></td>
            <td><?=$rubro['nombre']?></td>
            <td>
            	<?
				if($rubro['activo']==1){ $btn='success'; } else { $btn='danger'; }
				?>
				<div class="btn-group">
                      <button type="button" class="btn btn-<?=$btn?> btn-sm" onClick="location.href='index.php?id=rubroedit&rubro=<?=$rubro['id_rubro']?>'">Editar</button>
                      <button type="button" class="btn btn-<?=$btn?> dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        
                        <li><a href="index.php?id=rubroedit&rubro=<?=$rubro['id_rubro']?>">Editar</a></li>
                        <li><a href="../index.php?id=verrubro&rubro=<?=$rubro['id_rubro']?>" target="_blank">Ver en la web</a></li>
                        <li role="separator" class="divider"></li>
                        <? if($rubro['activo']==1){ ?>
                        <li><a href="funciones.php?acc=delrubro&rubro=<?=$rubro['id_rubro']?>">Desactivar</a></li>
                        <? } else { 
                        ?>
                        <li><a href="funciones.php?acc=activarRubro&rubro=<?=$rubro['id_rubro']?>">Activar</a></li>
                        <?
                        } 
                        ?>
                        
                      </ul>
                </div>
            </td>
        </tr>
        <?		
		}
	} else {
		$hayregistros=false;
		echo "<tr><td colspan='3'><center><br><br>No hay rubros creados.<br><br><br></center></td></tr>";	
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
