<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
	if(is_numeric($_GET['pag'])){
		$pagina = $_GET['pag'];
	} else {
		$pagina = 1;
	}
	$registros = 40;
	if (!$pagina) {
		$inicio = 0;
		$pagina = 1;
	} else {
		$inicio = ($pagina - 1) * $registros;
	}
?>
<h1>Diagn&oacute;sticos
</h1>

<table class="table table-users">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Fecha Diagn&oacute;stico</th>
            <th>Consumo Espec&iacute;fico</th>
            <th>CO<sub>2</sub></th>
            <th width="100">Acciones</th>
        </tr>
    </thead>
    <tbody>
	<?
	$diagnosticos = mysql_query("SELECT diagnosticos.*,DATE_FORMAT(diagnosticos.fecha,'%d-%m-%Y') as fecha,usuarios.nombre as NameUser FROM diagnosticos,usuarios WHERE diagnosticos.id_empresa=usuarios.id_user AND usuarios.activo=1 ORDER BY diagnosticos.id_diagnostico DESC LIMIT ".$inicio.",".$registros."");
	$kpi_resp = mysql_query("SELECT diagnosticos.* FROM diagnosticos,usuarios WHERE diagnosticos.id_empresa=usuarios.id_user AND usuarios.activo=1");
	$total_r = mysql_num_rows($kpi_resp);
	mysql_free_result($kpi_resp);
	$total_paginas = ceil($total_r / $registros);
	
	if(mysql_num_rows($diagnosticos)>0){
		$hayregistros=true;
		while($diag = mysql_fetch_array($diagnosticos)){
			$btn='success'; 
			
			$tipo_U_productiva = mysql_query("SELECT unidad_productiva FROM rubros WHERE id_rubro=".$diag['id_rubro']."");
			if(mysql_result($tipo_U_productiva,0)==0){ //solido
				$unidad_productiva = 'kg';
			} else {
				$unidad_productiva = 'litro';
			}
		?>
        <tr>
            <td><a name="op<?=$diag['id_diagnostico']?>"></a><?=$diag['NameUser']?></td>
        	<td><?=$diag['fecha']?></td>
            <td><?=$diag['consumo_especifico']?> kWh/<?=$unidad_productiva?></td> 
            <td><?=$diag['generacion_total']?> kg</td>  
            <td>
				<div class="btn-group">
                      <a class="btn btn-<?=$btn?> btn-sm" href="index.php?id=verdiagnostico&diagnostico=<?=$diag['id_diagnostico']?>">Detalles</a>
                </div>
            </td>
        </tr>
        <?	
		}
		?>
        <?
	} else {
		$hayregistros=false;
		echo "<tr><td colspan='5'><center><br><br>No hay diagn&oacute;sticos en la base de datos.<br><br><br></center></td></tr>";
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
