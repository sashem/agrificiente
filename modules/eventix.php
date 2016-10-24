<?
//if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){	

	$pagina = $_GET['pag'];
	$registros = 8;
	
	if (!$pagina) {
		$inicio = 0;
		$pagina = 1;
	} else {
		$inicio = ($pagina - 1) * $registros;
	}
	//fin pag
	
	$total_registros = mysql_query("SELECT id_evento FROM eventos");
	$totalr = mysql_num_rows($total_registros);
	$total_paginas = ceil($totalr / $registros);	
	

	$ver_Eventos = mysql_query("SELECT *,DATE_FORMAT(fecha,'%d') as dia,DATE_FORMAT(fecha,'%Y') as ano, DATE_FORMAT(fecha , '%H:%i') as horario,
		CASE month(fecha) WHEN 1 THEN 'Ene' WHEN 2 THEN 'Feb' WHEN 3 THEN 'Mar' WHEN 4 THEN 'Abr' WHEN 5 THEN 'May' WHEN 6 THEN 'Jun' WHEN 7 THEN 'Jul' WHEN 8 THEN 'Ago' WHEN 9 THEN 'Sep' WHEN 10 THEN 'Oct' WHEN 11 THEN 'Nov' WHEN 12 THEN 'Dic'
		END AS mes FROM eventos /*WHERE fecha >= CURDATE()*/ ORDER BY fecha DESC LIMIT ".$inicio.",".$registros."");
	
	//$ver_Eventos = mysql_query("SELECT *,DATE_FORMAT(fecha,'%d') as dia FROM eventos ");

	if(mysql_num_rows($ver_Eventos)>0){
		$hayregistros=true;
		while($not = mysql_fetch_array($ver_Eventos)){
			?>
			<div class="news_box">
				<div class="news_title"><h2><a href="evento.php?evento=<?=$not['id_evento']?>"><?=$not['nombre']?></a></h2></div>
				<label>
					<h4><?=$not['dia']?></h4>
					<?=$not['mes']?>
				</label>
				<div class="news_image"><img src="img/tr.gif" style="background:url(img_eventos/<?=$not['formato']?>) center no-repeat; background-size:cover" /></div>
				<div class="news_content">
                    <div class="lista_mejoras">
                        <span>Fecha</span>
                        <span><?=$not['dia']?> <?=$not['mes']?>, <?=$not['ano']?>  - <?=$not['horario']?> hrs</span>
                    </div>
                    <? if($not['cupos_max']!=-1){ ?>
                    <div class="lista_mejoras">
                        <span>Cupos</span>
                        <span><?=$not['cupos_max']?> &nbsp;&nbsp;
                        <?
                        $ver_si_hay_cupos_sql = mysql_query("SELECT id_evento FROM eventos_usuarios WHERE id_evento = ".$not['id_evento']."");
                        $ver_invitados = mysql_query("SELECT nombre FROM invitados_eventos WHERE id_evento = ".$not['id_evento']."");
                        $cupos_usados = mysql_num_rows($ver_si_hay_cupos_sql) + mysql_num_rows($ver_invitados) ;
                        $cupos_restantes = $not['cupos_max']-$cupos_usados;
                        if($cupos_restantes>0){ 
                            if($cupos_restantes==1){
                                echo "<em>Queda 1 solo cupo</em>";
                            } else {
                                echo "<em>Quedan ".$cupos_restantes." cupos</em>";
                            }
                        }
                        ?>
                        </span>
                    </div>
                    <? } ?>
                    <? if($not['costo']!=-1){ ?>
                    <div class="lista_mejoras">
                        <span>Valor</span>
                        <span><?=str_replace(",",".",number_format($not['costo']))?></span>
                    </div>
                    <? } ?>
                    <div class="lista_mejoras">
                        <span>Organizador</span>
                        <span><?=$not['organizador']?></span>
                    </div>
                    
                
                <br /><a class="btn" href="evento.php?evento=<?=$not['id_evento']?>">Ver Evento</a></div>
			</div>
			<?
		}
	} else {
		$hayregistros=false;
		echo "<div id='error'>No hay eventos por el momento</div>";	
	}
		
		if($hayregistros==true && $total_paginas>1){
		paginar_resultados($_GET['id'],$total_paginas,$pagina,$orden);
	}

//}
?>