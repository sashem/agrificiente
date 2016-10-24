<?
if(isset($_SESSION['adminid']) && isset($_SESSION['adminuser']) && $_SESSION['adminid']="1"){

	if(is_numeric($_GET['pag'])){
		$pagina = $_GET['pag'];
	} else {
		$pagina = 1;
	}
	$registros = 50;
	if (!$pagina) {
		$inicio = 0;
		$pagina = 1;
	} else {
		$inicio = ($pagina - 1) * $registros;
	}
	
	if(isset($_GET['user']) && strlen($_GET['user'])>0 && is_numeric($_GET['user'])){
		$sql_add_consulta = "AND imagenes.id_user=".$_GET['user']." ORDER BY id_img DESC";
	} else {
		$sql_add_consulta = "ORDER BY id_img DESC";
	}
	$SQL = "SELECT imagenes.id_img,imagenes.id_album,imagenes.imagen,imagenes.id_album,imagenes.id_user,users.nombre,users.suspendido FROM imagenes,users WHERE imagenes.id_user=users.id_user  ".$sql_add_consulta." LIMIT ".$inicio.",".$registros."";
	
	$ver_pic = mysql_query($SQL);
	
		$kpi_resp = mysql_query("SELECT id_img FROM imagenes");
		$kpi = mysql_num_rows($kpi_resp);
		$total_r = $kpi;
		mysql_free_result($kpi_resp);
		$total_paginas = ceil($total_r / $registros);
	?>
    <h1>Fotos (<?=$total_r?>)</h1>
    <?
	if(mysql_num_rows($ver_pic)>0){
		
		$hayregistros=true;
		?>
        <div class="user-form form_extend table photobox">
        <?
		while($pic = mysql_fetch_array($ver_pic)){
			?>
			<div class="picture">
				<a href="../index.php?id=viewphoto&photo=<?=$pic['id_img']?>" target="_blank" title="Foto por <?=$pic['nombre']?> (<?=$pic['id_user']?>)">
                <? if($pic['id_album']==2){ ?><span class="glyphicon glyphicon-fire"></span><? } ?>
                <? if($pic['suspendido']==1){ ?><span class="glyphicon glyphicon-eye-close"></span><? } ?>
				<img src="../img/tr.gif" style="background-image:url(../profiles/mini_<?=$pic['imagen']?>)" /></a>
                <div>
                	<? if($pic['id_album']!=2){ ?>
                	<a href="funciones.php?acc=sendprivate&photo=<?=$pic['id_img']?>&pag=<?=$pagina?>" title="Enviar a privadas"><span class="glyphicon glyphicon-lock"></span></a>
                	<? } ?>
                    <a href="funciones.php?acc=delpicture&photo=<?=$pic['id_img']?>&pag=<?=$pagina?>" onclick="if(!confirm('¿Est&aacute; seguro que desea eliminar esta foto?')) { return false; } else { return true; }" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>   
               	</div>
			</div>
			<?
		}
		?>
		</div>
		<?
	} else {
		$hayregistros=false;	
	}

	if(($hayregistros==true || $hayregistros==1) && $total_paginas>1){
		paginar_resultados($_GET['id'],$total_paginas,$pagina,$orden);
	} 
	
	
} else {
	
}
?>
