
<h2>Sectores productivos</h2>

<div class="rubros_list">
	<?
    $ver_rubros = mysql_query("SELECT id_rubro,nombre,imagen FROM rubros WHERE activo=1 ORDER BY id_rubro ASC");
	if(mysql_num_rows($ver_rubros)>0){
		?>
        <ul>
        <?
		while($rubro = mysql_fetch_array($ver_rubros)){
		?>
        <li>
        	<a href="index.php?id=verrubro&rubro=<?=$rubro['id_rubro']?>">
                <label><img src="iconos/<?=$rubro['imagen']?>"></label>
                <span><?=$rubro['nombre']?></span>
            </a>
        </li>
        <?		
		}
		?>
        </ul>
        </br>
        </br>
        <?
	} else {
		echo "No hay rubros por el momento";	
	}
	?>
	
    	
</div>
