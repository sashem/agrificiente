<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	if(isset($_GET['mejora']) && is_numeric($_GET['mejora'])){
		$ver_mejoras = mysql_query("SELECT mejoras.id_mejora as id_mejora, mejoras.nombre as nombremejora,mejoras.descripcion as descripcion, rubros_mejoras.* FROM mejoras,rubros_mejoras WHERE rubros_mejoras.id_mejora = mejoras.id_mejora AND rubros_mejoras.id_rubro_mejora=".$_GET['mejora']." LIMIT 1");
    	if(mysql_num_rows($ver_mejoras)>0){
			$mejora = mysql_fetch_array($ver_mejoras);
	?>
	<h2>Nueva discusi&oacute;n en <?=$mejora['nombremejora']?></h2>
	<br />
    <? if($_GET['error']=='notype'){ ?>
    <div class="invalido">Debes seleccionar el tipo de discusi&oacute;n</div>
    <? } elseif($_GET['error']=='unknown'){ ?>
    <div class="invalido">No se pudo agregar el tema. Favor contactar al administrador</div>
    <?	
	}
	?>
	<script src="ckeditor/ckeditor.js"></script>
    <form method="post" action="acciones.php?acc=addtema">
	<div class="user-form form_extend">
		<div class="form-group">
			<label>Tema de la discusi&oacute;n</label>
			<input type="text" placeholder="T&iacute;tulo del tema" name="titulo" required>
		</div>
		<div class="form-group select-items">
			<label>Tipo discusi&oacute;n</label><br>
			<select class="cs-select cs-skin-border" style="display:none" name="tipo" required>
			<option value="" disabled >
				 Seleccionar...
			</option>
			<?
			$ver_tipos_d = mysql_query("SELECT * FROM tipos_discusion ORDER BY tipo_user ASC, titulo ASC");
			while($rowt = mysql_fetch_array($ver_tipos_d)){
				if($rowt['tipo_user']==0){
				?>
				<option value="<?=$rowt['id_tipo']?>"><?=$rowt['titulo']?></option>
				<?
				} elseif($rowt['tipo_user']==1 && isset($_SESSION['adminuser'])){
				?>
                <option value="<?=$rowt['id_tipo']?>"><?=$rowt['titulo']?></option>
                <?
				}
			}
			?>
		</select>
		</div>
		<div class="form-group">
			<label>Mensaje</label><br>
			<textarea name="mensaje" required class="ckeditor" id="editor1" rows="7"></textarea>
		</div>
		<div class="form-group" id="buttons"><input type="submit" name="create" value="Crear Discusi&oacute;n"></div>
	</div>
    <input type="hidden" name="mejora" value="<?=$_GET['mejora']?>" />
	</form>
	
	<script src="js/classie.js"></script>
	<script src="js/selectFx.js"></script>
	<script>
		(function() {
			[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
				new SelectFx(el);
			} );
		})();
	</script>
	
	<?
		} else {
			?><div id="error">Error en identificador de mejora</div><?
		}
	} else {
		?><div id="error">Error en identificador</div><?	
	}
} else {
	include("login.php");	
}
?>