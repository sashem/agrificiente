<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	
	if(is_numeric($_GET['pag'])){
		$pagina = $_GET['pag'];
	} else {
		$pagina = 1;
	}
	$registros = 20;
	if (!$pagina) {
		$inicio = 0;
		$pagina = 1;
	} else {
		$inicio = ($pagina - 1) * $registros;
	}
	if(isset($_GET['mejora']) && is_numeric($_GET['mejora'])){
		$add_mejora = "AND discusiones.id_mejora=".$_GET['mejora']."";	
	}
	//$discusiones =  mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,discusiones.id_discusion,discusiones.titulo,discusiones.mensaje,DATE_FORMAT(discusiones.fecha,'%d/%m/%Y %H:%i') as fecha FROM discusiones,usuarios,rubros_mejoras,mejoras WHERE discusiones.id_user=usuarios.id_user AND rubros_mejoras.id_mejora=discusiones.id_mejora AND rubros.activo=1 AND mejoras.activo=1 AND usuarios.activo=1 ".$add_mejora." ORDER BY discusiones.id_discusion DESC LIMIT ".$inicio.",".$registros."");
	if(isset($_GET['type'])){
		$tipos = implode(",",$_GET['type']);
		$add_sql = "AND discusiones.id_tipo IN (".$tipos.")";	
	}elseif(isset($_GET['tipos'])){
		$tipos = $_GET['tipos'];
		$tipexplode = explode(",",$_GET['tipos']);
		$add_sql = "AND discusiones.id_tipo IN (".$tipos.")";	
	}
	$discusiones =  mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,discusiones.id_discusion,discusiones.titulo,discusiones.mensaje,DATE_FORMAT(discusiones.fecha,'%d/%m/%Y %H:%i') as fecha FROM discusiones,usuarios,rubros_mejoras,mejoras,tipos_discusion WHERE tipos_discusion.id_tipo=discusiones.id_tipo AND discusiones.id_user=usuarios.id_user AND mejoras.id_mejora=discusiones.id_mejora AND mejoras.activo=1 AND usuarios.activo=1 ".$add_mejora." ".$add_sql." GROUP BY discusiones.id_discusion ORDER BY discusiones.id_discusion DESC LIMIT ".$inicio.",".$registros."");

?>

    <h1>Discusiones
    <?
    if(isset($_GET['mejora']) && is_numeric($_GET['mejora'])){
	?><a href="index.php?id=newthread&mejora=<?=$_GET['mejora']?>" class="btn floatright">Abrir tema</a><?	
	}
	?>
    </h1>
    <br />
    <form name="filter" method="get" action="index.php">
    	<input type="hidden" name="id" value="discusiones" />
        <ul class="filter">
            <li><label>Filtar:</label></li>
            <? 
			$allchecked = "";
            $tipos_disc = mysql_query("SELECT * FROM tipos_discusion ORDER BY tipo_user ASC, titulo ASC");
            while($type = mysql_fetch_array($tipos_disc)){
				if(isset($_GET['type'])){
					$marcado = "";
					for($i=0;$i<count($_GET['type']);$i++){
						if($_GET['type'][$i]==$type['id_tipo']){ $marcado = 'checked="checked"'; } 
					}
				} elseif(isset($_GET['tipos'])){
					$marcado = "";
					for($i=0;$i<count($tipexplode);$i++){
						if($tipexplode[$i]==$type['id_tipo']){ $marcado = 'checked="checked"'; }  else {  }
					}	
				} else { $allchecked = 'checked="checked"'; }
            ?>
            <li><span><input type="checkbox" name="type[]" value="<?=$type['id_tipo']?>" id="f<?=$type['id_tipo']?>" onclick="document.filter.submit()" <?=$allchecked?> <?=$marcado?> /></span>
            <label for="f<?=$type['id_tipo']?>"><img src="img/tr.gif" class="<?=$type['class']?>" /><span><?=$type['titulo']?></span></label></li>
            <? } ?>
        </ul>
    </form>
    <br />
    <?
    if(mysql_num_rows($discusiones)>0){
		$kpi_resp = mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,discusiones.id_discusion,discusiones.titulo,discusiones.mensaje,DATE_FORMAT(discusiones.fecha,'%d/%m/%Y %H:%i') as fecha FROM discusiones,usuarios,rubros_mejoras,mejoras,tipos_discusion WHERE tipos_discusion.id_tipo=discusiones.id_tipo AND discusiones.id_user=usuarios.id_user AND mejoras.id_mejora=discusiones.id_mejora AND mejoras.activo=1 AND usuarios.activo=1 ".$add_mejora." ".$add_sql." GROUP BY discusiones.id_discusion");
		$kpi = mysql_fetch_array($kpi_resp);
		$total_r = mysql_num_rows($kpi_resp);
		mysql_free_result($kpi_resp);
		$hayregistros=true;
		$total_paginas = ceil($total_r / $registros);
	?>
    
	<div class="contenido">
    	<br />
    	<div class="group">
    	<?
        while($disc = mysql_fetch_array($discusiones)){
			$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$disc['id_user']." AND principal=1 LIMIT 1");
			$pic = mysql_fetch_array($ver_pic);
			if(mysql_num_rows($ver_pic)>0){ $img_pic = "profiles/".$pic['imagen']; } else { $img_pic = "img/unknown_empresa.jpg"; }
		?>    
        <div class="comment_box">
            <span href="index.php?id=profile&user=<?=$user['id_user']?>" style="background-image:url(<?=$img_pic?>)" class="mini_circ_pic"></span>
            <div class="message_box_disc">
               	<a href="index.php?id=viewthread&thread=<?=$disc['id_discusion']?>"><label><?=$disc['titulo']?></label>
                <br />
                <?
                $arreglo = explode(" ",$disc['mensaje']);
                if(count($arreglo)>19){
                    $corte = 20;
                    $limite = "...";	
                } else {
                    $corte = count($arreglo);
                    $limite = "";
                }
                for($i=0;$i<$corte;$i++){
                    echo " ".$arreglo[$i];
                }
                echo $limite;
                ?>
                </a>
                <i><span class="icon-clock"></span> &nbsp; <?=$disc['fecha']?><u>Autor: <?=$disc['usuarion']?></u>
                <?
                $get_messages = mysql_query("SELECT id_mensaje FROM mensajes WHERE id_discusion=".$disc['id_discusion']."");
				?>
                <u><span class="icon-bubble"></span> <?=mysql_num_rows($get_messages)?></u>
                <? mysql_free_result($get_messages); ?>
                </i>
            </div>
        </div>
        <?
		}
		?>
        </div>
    </div>
    
	<?
	} else {
		$hayregistros=false;
		echo "<div id='error'>No hay discusiones</div>";	
	}
	
	if(isset($_GET['type']) || isset($_GET['tipos'])){
		$orden = "&tipos=".$tipos;
	}
	if($hayregistros==true && $total_paginas>1){
		paginar_resultados($_GET['id'],$total_paginas,$pagina,$orden);
	}
		
} else {
	include("login.php");
}
?>
