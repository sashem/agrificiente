<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	
	$ver_tipo_user = mysql_query("SELECT tipo FROM usuarios WHERE id_user=".$_SESSION["iduser"]." LIMIT 1");
	if(mysql_num_rows($ver_tipo_user)>0){
		$us = mysql_fetch_array($ver_tipo_user);
		if($us['tipo']==1){ $proceed = true; } else { $proceed = false; }
	}
	
	if($proceed == true){
		if(isset($_POST['agregar'])){
			
			$cols = array('kwh_kg','kwh_ton','kwh_l','kwh_m3');
			for($i=0;$i<count($_POST['tipo_combustible']);$i++){
				if($i==0){ $comb_1 = $_POST['tipo_combustible'][$i]; $unidad_1 = $_POST['unidad_combustible'][$i]; $cantidad_1 = soloNumericos($_POST['cantidad_combustible'][$i]); }
				if($i==1){ $comb_2 = $_POST['tipo_combustible'][$i]; $unidad_2 = $_POST['unidad_combustible'][$i]; $cantidad_2 = soloNumericos($_POST['cantidad_combustible'][$i]); }
				if($i==2){ $comb_3 = $_POST['tipo_combustible'][$i]; $unidad_3 = $_POST['unidad_combustible'][$i]; $cantidad_3 = soloNumericos($_POST['cantidad_combustible'][$i]); }
			}
			
			if(isset($unidad_1) && is_numeric($unidad_1) && $unidad_1>0){
				$columna1 = mysql_query("SELECT col_energia FROM unidades WHERE id_unidad =".$unidad_1."");
				$row = mysql_fetch_array($columna1);
				$col_1 = $cols[($row['col_energia']-1)];
				$consumo_comsutible_1 = mysql_query("SELECT ".$col_1." FROM combustibles WHERE id_combustible = ".$comb_1."");
				$row = mysql_fetch_array($consumo_comsutible_1);
				$print_1 = $row[$col_1]*$cantidad_1;
			} else {
				$print_1 = 0;	
			}
			if(isset($unidad_2) && is_numeric($unidad_2) && $unidad_2>0){
				$columna2 = mysql_query("SELECT col_energia FROM unidades WHERE id_unidad =".$unidad_2."");
				$row = mysql_fetch_array($columna2);
				$col_2 = $cols[($row['col_energia']-1)];
				$consumo_comsutible_2 = mysql_query("SELECT ".$col_2." FROM combustibles WHERE id_combustible = ".$comb_2."");
				$row = mysql_fetch_array($consumo_comsutible_2);
				$print_2 = $row[$col_2]*$cantidad_2; 
			} else {
				$print_2 = 0;	
			}
			if(isset($unidad_3) && is_numeric($unidad_3) && $unidad_3>0){
				$columna3 = mysql_query("SELECT col_energia FROM unidades WHERE id_unidad =".$unidad_3."");
				$row = mysql_fetch_array($columna3);
				$col_3 = $cols[($row['col_energia']-1)];
				$consumo_comsutible_3 = mysql_query("SELECT ".$col_3." FROM combustibles WHERE id_combustible = ".$comb_3."");
				$row = mysql_fetch_array($consumo_comsutible_3);
				$print_3 = $row[$col_3]*$cantidad_3;
			} else {
				$print_3 = 0;	
			}
			$consumo_total_combustible = $print_1+$print_2+$print_3;
			$consumo_electrico = soloNumericos($_POST['consumo_electrico'])*($_POST['unidad_consumo_electrico']==0?1:1000);
			if(isset($comb_1) && is_numeric($comb_1) && $comb_1>0){
				$co2_1 = mysql_query("SELECT kgco2_kWh FROM combustibles WHERE id_combustible=".$comb_1."");
				if(mysql_num_rows($co2_1)>0){
					$total_co2_1 = mysql_result($co2_1,0)*$print_1;
				} else {
					$total_co2_1 = 0;	
				}
			} else {
				$total_co2_1 = 0;	
			}
			if(isset($comb_2) && is_numeric($comb_2) && $comb_2>0){
				$co2_2 = mysql_query("SELECT kgco2_kWh FROM combustibles WHERE id_combustible=".$comb_2."");
				if(mysql_num_rows($co2_1)>0){
					$total_co2_2 = mysql_result($co2_2,0)*$print_2;
				} else {
					$total_co2_2 = 0;	
				}
			} else {
				$total_co2_2 = 0;
			}
			if(isset($comb_3) && is_numeric($comb_3) && $comb_3>0){
				$co2_3 = mysql_query("SELECT kgco2_kWh FROM combustibles WHERE id_combustible=".$comb_3."");
				if(mysql_num_rows($co2_1)>0){
					$total_co2_3 = mysql_result($co2_3,0)*$print_3;
				} else {
					$total_co2_3 = 0;	
				}
			} else {
				$total_co2_3 = 0;
			}
			
			$co2_electrico = mysql_query("SELECT kgco2_kWh FROM combustibles WHERE id_combustible=13");
			$total_co2_electrico = mysql_result($co2_electrico,0)*$consumo_electrico;
			
			$consumo_total_co2 = $total_co2_1+$total_co2_2+$total_co2_3+$total_co2_electrico;
			
			if($_POST['unidad_produccion']=='kg' || $_POST['unidad_produccion']=='litro'){
				$var_prod = soloNumericos($_POST['produccion'])*1;	
			} else {
				$var_prod = soloNumericos($_POST['produccion'])*1000;
			}
			$tipo_U_productiva = mysql_query("SELECT unidad_productiva FROM rubros WHERE id_rubro=".$_POST['idrubro']."");
			if(mysql_result($tipo_U_productiva,0)==0){ //solido
				$unidad_productiva = 'kg';
			} else {
				$unidad_productiva = 'litro';
			}
			$consumo_especifico = ($consumo_total_combustible+$consumo_electrico)/$var_prod;
			$texto_consumo_especifico = number_format($consumo_especifico,4)." kWh/".$unidad_productiva;
			$generacion_especifica = $consumo_total_co2/$var_prod;
			$texto_generacion_especifica = number_format($generacion_especifica,4)." kgCO2/".$unidad_productiva;
			
			$CONSUMO_TOTAL = $consumo_total_combustible+$consumo_electrico; // [consumo_total]
			$GENERACION_TOTAL = $consumo_total_co2; // [generacion_total]
			$GENERACION_ESPECIFICA = $generacion_especifica; // [generacion_especifica]
			$CONSUMO_ESPECIFICOx = $consumo_especifico; // [consumo_especifico]
			
			
		}
		?>
	
		<script src="js/validacion.js"></script>
		<div class="contenido c2columnas">
			<div class="group noborder">
				<h1>Diagn&oacute;stico</h1>
				<div class="bajada">Evalua tu desempeño energético. Completa la ficha con tus datos sin usar "." y ",".</div>
                <form name="diag" id="diag" method="post" action="index.php?id=diagnostico#Results">
             		<div class="user-form form_extend" style="width:100%; padding:20px 10px">
                        <div class="form-group">
                            <label>Rubro</label>
                            <?
							$ver_rubros = mysql_query("SELECT * FROM rubros WHERE activo=1 ORDER BY nombre ASC");
							if(mysql_num_rows($ver_rubros)>0){
							?>
							<select name="idrubro" required onchange="getUniProd(this.value,'unidad_rubro')" >
								<option value="">Seleccionar rubro...</option>
								<?
								while($rub = mysql_fetch_array($ver_rubros)){
								?>
								<option value="<?=$rub['id_rubro']?>" <? if($_POST['idrubro']==$rub['id_rubro']){ echo 'selected="selected"'; } ?> ><?=$rub['nombre']?></option>
								<?	
								}
								?>
							</select>
							<?	
							}
							?>
                        </div>
                        <div class="form-group">
                            <label>Producci&oacute;n anual</label><br />
                            <div class="c7030">
                            	<input type="text" name="produccion" value="<?=$_POST['produccion']?>" required />
                                <select name="unidad_produccion" id="unidad_rubro" required>
                                	<? 
									if(isset($_POST['agregar'])){ 
										$respC = mysql_query("SELECT unidad_productiva FROM rubros WHERE id_rubro=".$_POST['idrubro']." LIMIT 1");
										$combc = mysql_fetch_array($respC);
										if($combc['unidad_productiva']==0){
											?>
											<option value="kg" <? if($_POST['unidad_produccion']=='kg'){ echo 'selected="selected"'; } ?>>kg</option>
											<option value="ton" <? if($_POST['unidad_produccion']=='ton'){ echo 'selected="selected"'; } ?>>Ton</option>
											<?
										} else {
											?>
											<option value="litro" <? if($_POST['unidad_produccion']=='litro'){ echo 'selected="selected"'; } ?>>Litros</option>
											<option value="m3" <? if($_POST['unidad_produccion']=='m3'){ echo 'selected="selected"'; } ?>>Metros c&uacute;bicos</option>
											<?
										}
									} else { ?>
                                	<option value="">Seleccionar rubro</option>
                                    <? } ?>
                                    
                                </select>
                            </div>
                        </div>
                        <br /><br />
                        <div class="form-group">
                            <label>Consumo el&eacute;ctrico anual</label><br />
                            <div class="c7030">
                            	<input type="text" name="consumo_electrico" value="<?=$_POST['consumo_electrico']?>" />
                            	<select name="unidad_consumo_electrico">
                                	<option value="0" <? if($_POST['unidad_consumo_electrico']=='0'){ echo 'selected="selected"'; } ?>>kWh/a&ntilde;o</option>
                                	<option value="1" <? if($_POST['unidad_consumo_electrico']=='1'){ echo 'selected="selected"'; } ?>>MWh/a&ntilde;o</option>
                                </select>
                            </div>
                        </div>
                        <br /><br />
                        <div class="form-group">
                        	
                            <label>Combustible 1</label><br />
                            <div class="c33">
                            	<select required name="tipo_combustible[]" onchange="getTipoC(this.value,'unidad_1')">
                                	<option value="">Seleccionar...</option>
                                	<?
                                    $combustibles = mysql_query("SELECT * FROM combustibles WHERE tipo_unidad>0 ORDER BY combustible ASC");
									while($comb = mysql_fetch_array($combustibles)){
									?><option value="<?=$comb['id_combustible']?>" <? if($_POST['tipo_combustible'][0]==$comb['id_combustible']){ echo 'selected="selected"'; } ?>><?=$comb['combustible']?></option><?	
									}
									?>
                                </select>
                            	<input required type="text" name="cantidad_combustible[]" value="<?=$_POST['cantidad_combustible'][0]?>" />
                                <select required name="unidad_combustible[]" id="unidad_1">
                                    <?
									if(isset($_POST['agregar']) && is_numeric($_POST['tipo_combustible'][0])){ 
										$respC = mysql_query("SELECT id_unidad,unidad FROM unidades WHERE tipo=(SELECT tipo_unidad FROM combustibles WHERE id_combustible=".$_POST['tipo_combustible'][0].")");
										while($combc = mysql_fetch_array($respC)){
											?>
											<option value="<?=$combc['id_unidad']?>" <? if($_POST['unidad_combustible'][0]==$combc['id_unidad']){ echo 'selected="selected"'; } ?>><?=$combc['unidad']?></option>
											<?	
										}
									} else {
										?><option value="">Seleccionar combustible</option><?
									}
									?>
                                </select>
                            </div>
                        </div>
                        <br /><br />
                        <div class="form-group">
                            <label>Combustible 2</label><br />
                            <div class="c33">
                            	<select name="tipo_combustible[]" onchange="getTipoC(this.value,'unidad_2')">
                                	<option value="">Seleccionar...</option>
                                	<?
                                    $combustibles = mysql_query("SELECT * FROM combustibles WHERE tipo_unidad>0 ORDER BY combustible ASC");
									while($comb = mysql_fetch_array($combustibles)){
									?><option value="<?=$comb['id_combustible']?>" <? if($_POST['tipo_combustible'][1]==$comb['id_combustible']){ echo 'selected="selected"'; } ?>><?=$comb['combustible']?></option><?	
									}
									?>
                                </select>
                            	<input type="text" name="cantidad_combustible[]" value="<?=$_POST['cantidad_combustible'][1]?>" />
                            	<select name="unidad_combustible[]" id="unidad_2">
                                	<?
									if(isset($_POST['agregar']) && is_numeric($_POST['tipo_combustible'][1])){ 
										$respC = mysql_query("SELECT id_unidad,unidad FROM unidades WHERE tipo=(SELECT tipo_unidad FROM combustibles WHERE id_combustible=".$_POST['tipo_combustible'][1].")");
										while($combc = mysql_fetch_array($respC)){
											?>
											<option value="<?=$combc['id_unidad']?>" <? if($_POST['unidad_combustible'][1]==$combc['id_unidad']){ echo 'selected="selected"'; } ?>><?=$combc['unidad']?></option>
											<?	
										}
									} else {
										?><option value="">Seleccionar combustible</option><?
									}
									?>
                                </select>
                            </div>
                        </div>
                        <br /><br />
                        <div class="form-group">
                            <label>Combustible 3</label><br />
                            <div class="c33">
                            	<select name="tipo_combustible[]" onchange="getTipoC(this.value,'unidad_3')">
                                	<option value="">Seleccionar...</option>
                                	<?
                                    $combustibles = mysql_query("SELECT * FROM combustibles WHERE tipo_unidad>0 ORDER BY combustible ASC");
									while($comb = mysql_fetch_array($combustibles)){
									?><option value="<?=$comb['id_combustible']?>" <? if($_POST['tipo_combustible'][2]==$comb['id_combustible']){ echo 'selected="selected"'; } ?>><?=$comb['combustible']?></option><?	
									}
									?>
                                </select>
                            	<input type="text" name="cantidad_combustible[]" value="<?=$_POST['cantidad_combustible'][2]?>" />
                            	<select name="unidad_combustible[]" id="unidad_3">
                                	<?
									if(isset($_POST['agregar']) && is_numeric($_POST['tipo_combustible'][2])){ 
										$respC = mysql_query("SELECT id_unidad,unidad FROM unidades WHERE tipo=(SELECT tipo_unidad FROM combustibles WHERE id_combustible=".$_POST['tipo_combustible'][2].")");
										while($combc = mysql_fetch_array($respC)){
											?>
											<option value="<?=$combc['id_unidad']?>" <? if($_POST['unidad_combustible'][2]==$combc['id_unidad']){ echo 'selected="selected"'; } ?>><?=$combc['unidad']?></option>
											<?	
										}
									} else {
										?><option value="">Seleccionar combustible</option><?
									}
									?>
                                </select>
                            </div>
                        </div>
                        
                        <br /><br />
                        <div class="form-group" id="buttons"><br />
                            <input type="submit"  name="agregar" value="Calcular" />
                            
                        </div>
                        
                    </div>
                </form>
                
                <h1>Mis diagn&oacute;sticos hist&oacute;ricos</h1>
                
                <br />
                <?
                $mis_diagnosticos = mysql_query("SELECT *,DATE_FORMAT(fecha,'%d-%m-%Y') as fecha FROM diagnosticos WHERE id_empresa=".$_SESSION['iduser']." ORDER BY id_diagnostico DESC");
				if(mysql_num_rows($mis_diagnosticos)>0){
					?>
                    <table width="100%">
                    	<thead>
                        	<tr>
                            	<th>Fecha</th>
                                <th>Consumo Espec&iacute;fico</th>
                                <th>CO<sub>2</sub></th>
                            </tr>
                        </thead>
                        <tbody>
						<?
                        while($diag = mysql_fetch_array($mis_diagnosticos)){
                            ?>
                            <tr>
                            	<td align="left"><a class="enlace_a_diag" href="#Results" onclick="cargarDataDiagnostico('DataDiagnostico',<?=$diag['id_diagnostico']?>)"><?=$diag['fecha']?></a></td> 
                                <td align="left"><?=$diag['consumo_especifico']?></td> 
                                <td align="left"><?=$diag['generacion_total']?></td>  
                            </tr>
                            <?
                        }
                        ?>
                        </tbody>
                    </table>
                    <?
				} else {
					echo "No has guardado diagn&oacute;sticos por el momento";	
				}
				?>
                
			</div>
			<div class="group noborder"><a href="#" name="Results"></a>
            	<span id="DataDiagnostico">
				<h1>Resultados</h1>
                <?
				if($_GET['error']=='outrange'){
				?><br /><br /><div class="invalido">Error: Tu consumo est&aacute; fuera del rango. &nbsp; <span>x</span></div><?	
				}elseif($_GET['error']=='db'){
				?><br /><br /><div class="invalido">Error: No se pudo guardar el diagn&oacute;stico. Contacte al administrador. &nbsp; <span>x</span></div><?	
				} 
				
				if($_GET['status']=='ok'){
				?><br /><br /><div class="valido">Diagn&oacute;stico guardado con &eacute;xito. &nbsp; <span>x</span></div>
				<br /><br />
                Puedes cargar los diagn&oacute;sticos guardados cuantas veces quieras, seleccionando en la lista (Mis diagn&oacute;sticos hist&oacute;ricos), la fecha de carga.
				<?	
				}
				
				
				
                if(isset($_POST['agregar'])){
					
					$maximos = mysql_query("SELECT consumo_especifico_min as min,consumo_especifico_max as max,nombre as namerubro FROM rubros WHERE id_rubro=".$_POST['idrubro']."");
					if(mysql_num_rows($maximos)>0){
						$max = mysql_fetch_array($maximos);
						?>
                        <br /><br />
                        <table>
                            <tr>
                                <td>Rubro:</td>
                                <td colspan="2"><?=$max['namerubro']?></td>
                            </tr>
                            <tr>
                                <td>Producci&oacute;n:</td>
                                <td><?=$_POST['produccion']?></td><td><?=$_POST['unidad_produccion']?></td>
                            </tr>
                            <tr>
                                <td>Consumo el&eacute;ctrico:</td>
                                <td><?=$_POST['consumo_electrico']?></td><td>
                                    <?
                                    if($_POST['unidad_consumo_electrico']=='0'){ echo 'kWh/a&ntilde;o'; } 
                                    elseif($_POST['unidad_consumo_electrico']=='1'){ echo 'MWh/a&ntilde;o"'; } 
                                    ?>
                                </td>
                            </tr>
                            <?
                            $total_combustibles = 3;
                            for($i=0;$i<$total_combustibles;$i++){
                                $tipo_comb = $_POST['tipo_combustible'][$i];
                                $unidad_comb = $_POST['unidad_combustible'][$i];
                                $cantidad_comb = $_POST['cantidad_combustible'][$i];
                                $consulta_data = "SELECT combustible,unidad FROM combustibles,unidades WHERE id_combustible=".$tipo_comb." AND id_unidad=".$unidad_comb." LIMIT 1";
                                $sql_comb = mysql_query($consulta_data);
                                $arr_comb = mysql_fetch_array($sql_comb);
                                //if($tipo_comb>0){
                                ?>
                                <tr>
                                    <td width="170"><?=$arr_comb['combustible']?></td>
                                    <td><?=$cantidad_comb?></td>
                                    <td><?=$arr_comb['unidad']?></td>
                                </tr>
                                <?
                                //}
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
                                <td><?=str_replace(",","",number_format($GENERACION_TOTAL,4))?> kg</td>
                            </tr>
                            <tr>
                            	<td>Generaci&oacute;n espec&iacute;fica</td>
                                <td><?=$texto_generacion_especifica?></td>
                            </tr>
                            <tr>
                            	<td>Consumo Total</td>
                                <td><?=str_replace(",","",number_format($CONSUMO_TOTAL,4))?> kWh</td>
                            </tr>
                        </table>
                        <br />
                        <?
						$posicion_actual = $CONSUMO_ESPECIFICOx;
						//echo "tu posici&oacute;n: ".$posicion_actual."<br><br>";
						$m_error = 4.55;
						$indice_actual = ($posicion_actual*100)/$max['max'];
						//echo $indice_actual;
						
						if($posicion_actual==$max['min']){
							$indice_actual = ($max['min']+$m_error)-2;
						}
						
						if($posicion_actual<=$max['max'] && $posicion_actual>=$max['min']){
							?>
                            <div class="barra_diagnostico">
                                <span class="min_diagnostico"><?=$max['min']?></span>
                                <span class="max_diagnostico"><?=$max['max']?></span>
                                <span class="posicion_diag" style="right:<?=($indice_actual-$m_error)?>%"><?=number_format($posicion_actual,3)?></span>
                                <span class="icon-location diaglocation" style="right:<?=($indice_actual-$m_error)?>%"></span>
                            </div>
							<?
							if($indice_actual<=50 && $indice_actual>=20){
								?><img src="iconos/diag_piola.png" width="60" align="left" style="margin:0px 15px 0px 0px" /><?
								echo "Tu consumo energ&eacute;tico es competitivo dentro de la industria, sin embargo, todav&iacute;a puede ser mejor. Si quieres saber c&oacute;mo ser m&aacute;s competitivo, entra a ver las mejoras que te proponemos para tu industria.";	
							}
							elseif($indice_actual>50){
								?><img src="iconos/diag_mal.png" width="60" align="left" style="margin:0px 15px 0px 0px" /><?
								echo "Tu consumo energ&eacute;tico es muy alto dentro de la industria, sin embargo, puedes mejorarlo. Si quieres saber c&oacute;mo, entra a ver las mejoras que te proponemos para tu industria.";	
							}elseif($indice_actual<20){
								?><img src="iconos/diag_bien.png" width="60" align="left" style="margin:0px 15px 0px 0px" /><?
								echo "Felicidades: Tu consumo energ&eacute;tico es muy bajo dentro de la industria. Si quieres saber c&oacute;mo disminuirla aun m&aacute;s, entra a ver las mejoras que te proponemos para tu industria.";	
							}
							?>
                            <br /><br /><br />
                            <span id="buttons"><input type="button" value="Guardar diagn&oacute;stico" onclick="guardarDiagnostico()" /></span>
                            <?
						} else {
							echo "<br><br>Est&aacute;s fuera del rango. Tu consumo debiese estar entre <strong>".$max['min']."</strong> y <strong>".$max['max']."</strong>. Comun&iacute;cate con el administrador para resolver el problema.";
						}
					}
					
				}
				?>
                </span>
			</div>
		</div>
		<?
		/*
		} else {
			echo "<div id='error'>No existen diagn&oacute;sticos</div>";	
		}*/
	} else {
		echo "<div id='error'>Debes ser productor para obtener un diagn&oacute;stico</div>";	
	}
} else {
	include("login.php");	
}
?>
