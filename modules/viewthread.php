<?
if(isset($_SESSION["iduser"]) && isset($_SESSION["email"])){
	if(isset($_GET['thread']) && is_numeric($_GET['thread'])){
		$discusiones = mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,discusiones.id_discusion,discusiones.titulo,discusiones.mensaje,DATE_FORMAT(discusiones.fecha,'%d/%m/%Y %H:%i') as fecha FROM discusiones,usuarios WHERE discusiones.id_user=usuarios.id_user AND usuarios.activo=1 AND discusiones.id_discusion=".$_GET['thread']." ORDER BY discusiones.id_discusion LIMIT 1");
    	if(mysql_num_rows($discusiones)>0){
			$disc = mysql_fetch_array($discusiones);
	?>
	<h2><?=$disc['titulo']?></h2>
    <div class="contenido">
    	<div class="group">
        
        	<?
            $ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$disc['id_user']." AND principal=1 LIMIT 1");
			$pic = mysql_fetch_array($ver_pic);
			if(mysql_num_rows($ver_pic)>0){ $img_pic = "profiles/".$pic['imagen']; } else { $img_pic = "img/unknown_empresa.jpg"; }
			?>
            <div class="comment_box">
                <a href="index.php?id=profile&user=<?=$disc['id_user']?>" style="background-image:url(<?=$img_pic?>)" class="mini_circ_pic"></a>
                <div class="message_box_disc">
                    <?=$disc['mensaje']?>
                    <br /><br />
                    <i><span class="icon-clock"></span> &nbsp; <?=$disc['fecha']?><u>Autor: <?=$disc['usuarion']?></u>
                    </i>
                </div>
            </div>
            
            
            <?
			$ver_replys = mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,mensajes.id_mensaje,mensajes.mensaje,DATE_FORMAT(mensajes.fecha,'%d/%m/%Y %H:%i') as fecha FROM mensajes,usuarios WHERE mensajes.id_user=usuarios.id_user AND usuarios.activo=1 AND mensajes.id_padre=0 AND mensajes.id_discusion=".$_GET['thread']." ORDER BY mensajes.id_mensaje ASC");
			if(mysql_num_rows($ver_replys)>0){
				$i=0;
				while($replys = mysql_fetch_array($ver_replys)){
				$ver_pic = mysql_query("SELECT imagen FROM imagenes WHERE id_user=".$replys['id_user']." AND principal=1 LIMIT 1");
				$pic = mysql_fetch_array($ver_pic);
				if(mysql_num_rows($ver_pic)>0){ $img_pic = "profiles/".$pic['imagen']; } else { $img_pic = "img/unknown_empresa.jpg"; }
					if(($i+1)==mysql_num_rows($ver_replys)){ echo '<a name="lastone"></a>'; }
				?>
				<div class="comment_box">
					<a href="index.php?id=profile&user=<?=$replys['id_user']?>" style="background-image:url(<?=$img_pic?>)" class="mini_circ_pic"></a>
					<div class="message_box_disc">
						<?=$replys['mensaje']?><br /><br />
						<i><span class="icon-clock"></span> &nbsp; <?=$replys['fecha']?><u>Autor: <?=$replys['usuarion']?></u>
						<u><a onclick="document.getElementById('m<?=$replys['id_mensaje']?>').style.display=''">Responder</a></u></i>
					</div>
                    <?
                    $ver_replys2 = mysql_query("SELECT usuarios.nombre as usuarion,usuarios.id_user,mensajes.id_mensaje,mensajes.mensaje,DATE_FORMAT(mensajes.fecha,'%d/%m/%Y %H:%i') as fecha FROM mensajes,usuarios WHERE mensajes.id_user=usuarios.id_user AND usuarios.activo=1 AND mensajes.id_padre=".$replys['id_mensaje']." AND mensajes.id_discusion=".$_GET['thread']." ORDER BY mensajes.id_mensaje ASC");
					while($replys2 = mysql_fetch_array($ver_replys2)){
						?>
                        <div class="replyto">
                        <span class="icon-bubble"></span> <a href="index.php?id=profile&user=<?=$replys2['id_user']?>"><?=$replys2['usuarion']?></a><br />
                        <?=$replys2['mensaje']?>
                        </div>
                        <?
					}
					?>
                    <span id="m<?=$replys['id_mensaje']?>" style="display:none">
                    <form method="post" action="acciones.php?acc=replyto">
                    	<input type="text" class="reply_box" name="mensaje" placeholder="Responder al usuario" />
                        <input type="submit" name="replyt" class="btn floatright reply_button" value="Responder">
                        <input type="hidden" name="idmsg" value="<?=$replys['id_mensaje']?>" />
                        <input type="hidden" name="thread" value="<?=$disc['id_discusion']?>" /> 
                    </form>
                    </span><a name="me<?=$replys['id_mensaje']?>"></a>
				</div>
            <?
				$i++;
				}
			} else {
				echo "<center><br>No hay respuestas en este hilo<br></center>";
			}
			?>
            
            
        </div>
    </div>
    
	<script src="ckeditor/ckeditor.js"></script>
    <form method="post" action="acciones.php?acc=replythread">
	<div class="user-form form_extend">
		<div class="form-group">
			<label>Responder tema:</label><br>
			<textarea name="mensaje" required class="ckeditor" id="editor1" rows="7"></textarea>
		</div>
		<div class="form-group" id="buttons"><input type="submit" name="reply" value="Responder"></div>
	</div>
    <input type="hidden" name="thread" value="<?=$disc['id_discusion']?>" />
	</form>
	
	<?
		} else {
			?><div id="error">Error en identificador de mejora</div><?
		}
	} else {
		?><div id="error">Error en identificador</div><?	
	}
} else {
	include("modules/login.php");	
}
?>