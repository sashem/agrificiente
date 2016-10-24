<? 
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	if($_GET['us']=='empresas' || $_GET['us']=='proveedores'){
		
	
		if(is_numeric($_GET['pag'])){
			$pagina = $_GET['pag'];
		} else {
			$pagina = 1;
		}
		$registros = 500;
		if (!$pagina) {
			$inicio = 0;
			$pagina = 1;
		} else {
			$inicio = ($pagina - 1) * $registros;
		}
		?>
		<div>
			<? if($_GET['us']=='empresas'){ ?>
				<h1>Conoce a los productores que están interesados en implementar medidas de eficiencia energética. </h1>
			<? } ?>
			<? if($_GET['us']=='proveedores'){ ?>
				<h1>Conoce los proveedores de productos y servicios que te pueden apoyar mejorar tu desempeño energético.</h1>
			<? } ?>

		</div>
		<h2>
			<div class="select-items">
			<form method="GET" name="formex" action="index.php?id=albums">
			<select class="cs-select cs-skin-border" name="ordenar">
				<option value="" disabled >Ordenar por</option>
				<option value="fecha" <? if($_GET['ordenar']=='fecha'){ echo 'selected="selected"'; } ?>>M&aacute;s nuevos</option>
				<option value="nombre" <? if($_GET['ordenar']=='nombre'){ echo 'selected="selected"'; } ?>>Nombre Usuario</option>
			</select>
			<? if(isset($pagina)){ ?>
			<input type="hidden" name="pag" value="<?=$pagina?>" />
			<? } ?>
			<input type="hidden" name="id" value="users" />
			<input type="hidden" name="us" value="<?=$_GET['us']?>" />
			<input type="submit" id="enviar_S" style="display:none" />
			</form>
			</div>
			<br />
		</h2>
		
	
		<div class="circ_box">
		<?
		if(isset($_GET['ordenar']) && strlen($_GET['ordenar'])>2){
			if($_GET['ordenar']=='nombre'){
				$sql_add_consulta = "ORDER BY ".$_GET['ordenar']." ASC";	
			}
			elseif($_GET['ordenar']=='fecha'){
				$sql_add_consulta = "ORDER BY id_user DESC";	
			}
		} else {
			$sql_add_consulta = "ORDER BY RAND()";
		}
		
		if($_GET['us']=='empresas'){
			$tabla_sql = "empresas";
		} else { //proveedores
			$tabla_sql = "proveedores";
		}
			
			
		$SQL = "SELECT usuarios.id_user,".$tabla_sql.".nombre FROM usuarios,".$tabla_sql." WHERE ".$tabla_sql.".id_user=usuarios.id_user AND usuarios.activo=1  ".$sql_add_consulta." LIMIT ".$inicio.",".$registros."";
	
		$users_list = mysql_query($SQL);
		if(mysql_num_rows($users_list)>0){
			
			if($_GET['us']=='empresas'){
				$kpi_resp = mysql_query("SELECT id_user FROM empresas,usuarios WHERE empresas.id_user=usuarios.id_user AND usuarios.activo=1");
			} else { //proveedores
				$kpi_resp = mysql_query("SELECT id_user FROM proveedores,usuarios WHERE proveedores.id_user=usuarios.id_user AND usuarios.activo=1");
			}
			
			$kpi = mysql_fetch_array($kpi_resp);
			$total_r = mysql_num_rows($kpi_resp);
			mysql_free_result($kpi_resp);
			$hayregistros=true;
			$total_paginas = ceil($total_r / $registros);
			
			
			while($user = mysql_fetch_array($users_list)){
				$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$user['id_user']." AND principal=1 LIMIT 1");
				$pic = mysql_fetch_array($ver_pic);
				?>
				<div class="circ_pic_out">
					<? if(strlen($pic['imagen'])>10){
						$profile_pic = "profiles/".$pic['imagen'];
					} else { 
						$profile_pic = "img/unknown_empresa.jpg";
					}
					?>
					<a href="index.php?id=profile&user=<?=$user['id_user']?>" style="background-image:url(<?=$profile_pic?>)" class="circ_pic"></a>
					<div class="ratingblock"><span><?=$user['nombre']?></span></div>
				</div>
			<?
				mysql_free_result($ver_pic);
			}
		} else {
			$hayregistros=false;
			echo "<div id='error'><br><br>No hay usuarios</div>";	
		}
		mysql_free_result($users_list);
		
		
		?>
		</div>
		
		<?
		if(isset($_GET['us']) && $_GET['us']!=NULL){
			$orden = "&us=".$_GET['us'];
		} else {
			$orden = "";
		}
		if($hayregistros==true && $total_paginas>1){
			paginar_resultados($_GET['id'],$total_paginas,$pagina,$orden);
		}
		?>
		<script src="js/classie.js"></script>
		<script src="js/selectFx.js"></script>
		<script>
			(function() {
				[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
					new SelectFx(el);
				} );
			})();
			$(document).ready(function() {
				$('.cs-options li').click(function(){
				   $('#enviar_S').click();
				});
			});
		</script>
		<?
	} else {
		echo "<div id='error'>Error en identificador</div>";	
	}
} else {
	include("login.php");
}
?>