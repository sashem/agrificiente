<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
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
<h1>Eventos
<a href="index.php?id=eventoadd" class="btn btn-primary">Agregar Evento</a>
</h1>

<table class="table">
    <thead>
        <tr>
            <th>Nombre evento</th>
            <th>Fecha</th>
            <th>Cupos</th>
            <th width="100">Acciones</th>
        </tr>
    </thead>
    <tbody>
	<?
    $ver_eventos = mysql_query("SELECT *,DATE_FORMAT(fecha,'%d/%m/%Y') as fecha FROM eventos ORDER BY id_evento DESC LIMIT ".$inicio.",".$registros."");
	$kpi_resp = mysql_query("SELECT * FROM eventos");
	$total_r = mysql_num_rows($kpi_resp);
	mysql_free_result($kpi_resp);
	$total_paginas = ceil($total_r / $registros);
	
	if(mysql_num_rows($ver_eventos)>0){
		$hayregistros=true;
		while($evento = mysql_fetch_array($ver_eventos)){
			$btn='success'; 
		?>
        <tr>
            <td><a name="op<?=$evento['id_evento']?>"></a><?=$evento['nombre']?></td>
        	<td><?=$evento['fecha']?></td>
            <td><?=$evento['cupos_max']?></td>
            <td>
				<div class="btn-group">
                      <button type="button" class="btn btn-<?=$btn?> btn-sm" onClick="location.href='index.php?id=eventoedit&evento=<?=$evento['id_evento']?>'">Editar</button>
                      <button type="button" class="btn btn-<?=$btn?> dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        
                        <li><a href="index.php?id=eventoedit&evento=<?=$evento['id_evento']?>">Editar</a></li>
                        <li><a href="index.php?id=eventousers&evento=<?=$evento['id_evento']?>">Ver asistencia</a></li>
                        <li><a href="../evento.php?evento=<?=$evento['id_evento']?>" target="_blank">Ver en la web</a></li>
                        <li><a onClick="if(!confirm('&iquest;Seguro de eliminar este evento?\n<?=$evento['nombre']?>')) { return false; }" href="funciones.php?acc=borrarevento&evento=<?=$evento['id_evento']?>&pag=<?=$_GET['pag']?>">Eliminar</a></li>
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
		echo "<tr><td colspan='4'><center><br><br>No hay eventos creados.<br><br><br></center></td></tr>";
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
