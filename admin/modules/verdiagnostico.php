<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser'])){
	if(is_numeric($_GET['diagnostico']) && strlen($_GET['diagnostico'])>0){
	?>
	<h1>Detalles Diagn&oacute;stico</h1>
	<?
	$diagnostico = mysql_query("SELECT diagnosticos.*,DATE_FORMAT(diagnosticos.fecha,'%d-%m-%Y') as fecha,rubros.nombre as rubro FROM diagnosticos,rubros WHERE diagnosticos.id_rubro=rubros.id_rubro AND id_diagnostico=".$_GET['diagnostico']." LIMIT 1");
	if(mysql_num_rows($diagnostico)>0){
		$di = mysql_fetch_array($diagnostico);
	?>
    
         
         <div class="user-form form_extend2" style="font-size:13px;">
            	<h4>Fecha: <?=$di['fecha']?></h4><br />
                <?
                	$maximos = mysql_query("SELECT consumo_especifico_min as min,consumo_especifico_max as max FROM rubros WHERE id_rubro=".$di['id_rubro']."");
					if(mysql_num_rows($maximos)>0){
						$max = mysql_fetch_array($maximos);
						
						
						$tipo_U_productiva = mysql_query("SELECT unidad_productiva FROM rubros WHERE id_rubro=".$di['id_rubro']."");
						if(mysql_result($tipo_U_productiva,0)==0){
							$unidad_productiva = 'kg';
						} else {
							$unidad_productiva = 'litro';
						}
						$texto_consumo_especifico = $di['consumo_especifico']." kWh/".$unidad_productiva;
						$texto_generacion_especifica = $di['generacion_especifica']." kgCO2/".$unidad_productiva;
						?>
						<table>
							<tr>
								<td width="170">Rubro:</td>
								<td colspan="2"><?=$di['rubro']?></td>
							</tr>
							<tr>
								<td>Producci&oacute;n:</td>
								<td width="50"><?=str_replace(".000","",$di['produccion_anual'])?></td>
                                <td><?=$di['unidad_produccion']?></td>
							</tr>
							<tr>
								<td>Consumo el&eacute;ctrico:</td>
								<td><?=str_replace(".000","",$di['consumo_electrico'])?></td><td>
									<?
									if($di['unidad_consumo_electrico']=='0'){ echo 'kWh/a&ntilde;o'; } 
									elseif($di['unidad_consumo_electrico']=='1'){ echo 'MWh/a&ntilde;o"'; } 
									?>
								</td>
							</tr>
							<?
							$total_combustibles = 3;
							for($i=1;$i<=$total_combustibles;$i++){
								$tipo_comb = "tipo_combustible_".$i;
								$unidad_comb = "unidad_combustible_".$i;
								$cantidad_comb = "cantidad_combustible_".$i;
								$consulta_data = "SELECT combustible,unidad FROM combustibles,unidades WHERE id_combustible=".$di[$tipo_comb]." AND id_unidad=".$di[$unidad_comb]." LIMIT 1";
								$sql_comb = mysql_query($consulta_data);
								$arr_comb = mysql_fetch_array($sql_comb);
								if($di[$tipo_comb]>0){
								?>
								<tr>
									<td><?=$arr_comb['combustible']?></td>
									<td><?=str_replace(".000","",$di[$cantidad_comb])?></td>
									<td><?=$arr_comb['unidad']?></td>
								</tr>
								<?
								}
							}
							?>
						</table>
						<br />
						
						<table>
							<tr>
								<td width="170">Consumo espec&iacute;fico</td>
								<td><?=$texto_consumo_especifico?></td>
							</tr>
							<tr>
								<td>Generaci&oacute;n de CO<sub>2</sub></td>
								<td><?=$di['generacion_total']?> kg</td>
							</tr>
							<tr>
								<td>Generaci&oacute;n espec&iacute;fica</td>
								<td><?=$texto_generacion_especifica?></td>
							</tr>
							<tr>
								<td>Consumo Total</td>
								<td><?=$di['consumo_total']?> kWh</td>
							</tr>
						</table>
						<br />
						<?
						$posicion_actual = $di['consumo_especifico'];
						$m_error = 4.55;
						$indice_actual = ($posicion_actual*100)/$max['max'];
						if($posicion_actual==$max['min']){
							$indice_actual = ($max['min']+$m_error)-2;
						}
						if($posicion_actual<=$max['max'] && $posicion_actual>=$max['min']){
							?>
							<link href="css/style.css" rel="stylesheet" type="text/css" />
							<div class="barra_diagnostico">
								<span class="min_diagnostico"><?=$max['min']?></span>
								<span class="max_diagnostico"><?=$max['max']?></span>
								<span class="posicion_diag" style="right:<?=($indice_actual-$m_error)?>%"><?=number_format($posicion_actual,3)?></span>
								<span class="glyphicon glyphicon-map-marker diaglocation" style="right:<?=($indice_actual-$m_error)?>%"></span>
							</div>
							<?
							if($indice_actual<=50 && $indice_actual>=20){
								?><img src="../iconos/diag_piola.png" width="30" align="left" style="margin:0px 15px 0px 0px" /><?
								echo "Su consumo energ&eacute;tico es competitivo dentro de la industria, sin embargo, todav&iacute;a puede ser mejor.";	
							}
							elseif($indice_actual>50){
								?><img src="../iconos/diag_mal.png" width="30" align="left" style="margin:0px 15px 0px 0px" /><?
								echo "Su consumo energ&eacute;tico es muy alto dentro de la industria, sin embargo, puede mejorarlo.";	
							}elseif($indice_actual<20){
								?><img src="../iconos/diag_bien.png" width="30" align="left" style="margin:0px 15px 0px 0px" /><?
								echo "Su consumo energ&eacute;tico es muy bajo dentro de la industria.";	
							}
						} else {
							echo "<br><br>Est&aacute;s fuera del rango. Tu consumo debiese estar entre <strong>".$max['min']."</strong> y <strong>".$max['max']."</strong>. Comun&iacute;cate con el administrador para resolver el problema.";
						}
					}
				
				?>
            </div>
            <div class="user-form form_extend">
                <div class="form-group" id="buttons"><br><input type="button" onclick="history.back()" value="Volver"></div>
			</div>		 	 
        </form>
        <br /><br />
         
         
         
    <?
		
	} else {
		echo "<div id='error'><br><br>No existe diagn&oacute;stico</div>";			
	}
	mysql_free_result($diagnostico);
	
	} else {
		echo "ID Error";	
	}
} else {
	
}
?>
