<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	if($_SESSION["tipo"]==2){
		?>
        <h1>Mis mejoras</h1>
        <br />
        <h4>Selecciona las mejoras que provees:</h4>
        <br />
        
        <?
		$veR_mejoras = mysql_query("SELECT * FROM mejoras WHERE activo=1 ORDER BY nombre ASC");
		if(mysql_num_rows($veR_mejoras)>0){
			?>
        	<form method="post" action="acciones.php?acc=updateMejoras">
            <div class="twocols">
                <ul class="mismejoras">
                <?
                while($mejora = mysql_fetch_array($veR_mejoras)){
                    
                    $ver_mejoras_marcadas = mysql_query("SELECT id_mejora FROM mejoras_proveedores WHERE id_proveedor=".$_SESSION['iduser']." AND id_mejora=".$mejora['id_mejora']." LIMIT 1");
                    $marcado = '';
                    if(mysql_num_rows($ver_mejoras_marcadas)>0){ $marcado = 'checked="checked"'; } 
                    ?>
                    <li>
                        <input type="checkbox" class="css-checkbox sme" id="check<?=$mejora['id_mejora']?>" name="idmejora[]" value="<?=$mejora['id_mejora']?>" <?=$marcado?>  />
                        <label for="check<?=$mejora['id_mejora']?>" class="css-label sme depressed"> &nbsp; <?=$mejora['nombre']?></label>
                    </li>
                    <?
                }
                ?>
                </ul>
            </div>
            <br />
            <span id="buttons"><input type="submit" name="updateP" value="Guardar Cambios"></span>
        	</form>
            <?
		} else {
			echo '<div id="error">No hay mejoras en la base de datos.</div>';	
		}
	}
}
?>
