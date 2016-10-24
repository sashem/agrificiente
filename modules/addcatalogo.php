<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	if($_SESSION["tipo"]==2){
		$ver_tiempo_ultimo = mysql_query("SELECT DATE_FORMAT(catalogos.fecha,'%d/%m/%Y a las %H:%i hrs') as fecha FROM catalogos 
		WHERE catalogos.fecha>TIMESTAMP(DATE_SUB(NOW(), INTERVAL 0 day)) ORDER BY catalogos.fecha LIMIT 1");
		if(mysql_num_rows($ver_tiempo_ultimo)>0){
			$fecha = mysql_fetch_array($ver_tiempo_ultimo);
			?>
            <div id="error">Solo puedes cargar un cat&aacute;logo por semana</div>
            <center>&Uacute;ltimo cat&aacute;logo cargado con fecha: <?=$fecha['fecha']?></center>
            <?
		} else {
	
?>
			<h1>Agregar Cat&aacute;logo</h1>
			<script src="js/validacion.js"></script>
			<form id="Mform" method="post" action="acciones.php?acc=addcatalogo" enctype="multipart/form-data" onsubmit="return completeMejoras()">
			<div class="user-form form_extend2">
				<div class="form-group">
					<label>T&iacute;tulo</label>
					<input type="text" name="titulo" value="" required placeholder="T&iacute;tulo que aparecer&aacute; en la p&aacute;gina">
				</div> 
                <div class="form-group">  
					<label>Cargar Archivo</label><br />
					<input type="file" name="archivo" required style="max-width: 260px;">      
				</div>
            </div>
            <div class="user-form form_extend"> 
                <div class="form-group">  
					<label>Selecciona hasta 3 mejoras a las que est&aacute; dirigido</label><br /><br />
                    <ul>
                    <?
                    $veR_mejoras = mysql_query("SELECT * FROM mejoras WHERE activo=1 ORDER BY nombre ASC");
                    while($mejora = mysql_fetch_array($veR_mejoras)){
                        ?>
                        <li>
                            <input type="checkbox" id="check<?=$mejora['id_mejora']?>" name="idmejora[]" value="<?=$mejora['id_mejora']?>"  />
                            <label for="check<?=$mejora['id_mejora']?>"> &nbsp; <?=$mejora['nombre']?></label>
                        </li>
                        <?
                    }
                    ?>
                    </ul>
             
				</div>
                <div class="form-group" id="buttons"><br />
                	<input type="submit" name="agregar" value="Agregar Cat&aacute;logo">
                </div>
			</div>
            </form>
<?
		}
	} else {
		echo "<div id='error'>Debes ser productor para cargar una buena pr&aacute;ctica</div>";
	}
}
?>