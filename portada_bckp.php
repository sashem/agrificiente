<body>
<?
$REFER_URL_NEXT = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<div class="subcontent">
	<div class="index_left">
        <h2>Calendario de eventos</h2>
        <div class="eventos" style="text-align:center">
            <? $eventos = mysql_query("SELECT * FROM eventos ORDER BY fecha DESC limit 5"); ?>
                <table class="eventos_table">
                    <thead>
                        <tr><th>Evento</th><th>Fecha de inicio</th><th>Cupos</th></tr>
                    </thead>
                    <tbody>
                        <? while($evento = mysql_fetch_array($eventos)){ ?>
                        <tr onclick="location.href=evento.php?evento=<?=$evento['id_evento']?>">
                            <td><a href="evento.php?evento=<?=$evento['id_evento']?>"><?= $evento['nombre'] ?></a></td>
                            <td><?= $evento['fecha'] ?></td>
                            <td><? if($evento['cupos_max'] != -1){ echo $evento['cupos_max']; } ?></td>
                        </tr>
                        <? } ?>
                    </tbody>
                </table>
                <a class="btn" style="display:block;margin-left:auto;margin-right:auto;" href="index.php?id=eventos">Ver mas</a>
            <? ?>
        </div>


        <h2>Revisa buenas prácticas de nuestros usuarios</h2>
        <div class="slider">
            <div class="slick-slider">
                <?
                $buenas_practicas = mysql_query("SELECT buenas_practicas.*,empresas.nombre FROM buenas_practicas,empresas where buenas_practicas.id_empresa = empresas.id_user order by RAND() LIMIT 10");
                if(mysql_num_rows($buenas_practicas)>0){
                    
                    while($bpr = mysql_fetch_array($buenas_practicas)){
                        if(strlen($bpr['img_folder'])>3){ $imagen_practica = "buenas_practicas/".$bpr['img_folder']; } else { $imagen_practica = "img/unknown_practica.png"; }
                        ?>
                        <div>
                            <label>
                            <div class="img_circle">
                                <a href="index.php?id=bpracticas&practica=<?=$bpr['id_buena_practica']?>">
                                <img src="<?=$imagen_practica?>" class="img_portada" />
                                </a>
                            </div>
                            </label>
                            <span>
                                <h4><a href="index.php?id=bpracticas&practica=<?=$bpr['id_buena_practica']?>"><?=$bpr['titulo']?></a></h4>
                                Ahorro energ&eacute;tico: <?=$bpr['ahorro_energetico']?>%<br />
                                Ahorro econ&oacute;mico: <?=$bpr['ahorro_economico']?>%<br />
                            </span>
                        </div>
                        <?
                    }
                } else {
                    ?><br />No hay buenas pr&aacute;cticas por el momento<?
                }
                ?>
            </div>
        </div>

        <h2>Algunos de nuestros proveedores</h2>
        <div class="slider">
            <div class="slick-slider">
                <?
                $proveedores = mysql_query("
                    SELECT DISTINCT proveedores.*,usuarios.activo,imagenes.imagen
                    FROM proveedores,usuarios,imagenes 
                    WHERE proveedores.id_user = usuarios.id_user 
                        AND usuarios.activo=1
                        AND imagenes.id_user = usuarios.id_user
                    ");
                if(mysql_num_rows($buenas_practicas)>0){
                    
                    while($pro = mysql_fetch_array($proveedores)){
                        //print_r($pro);
                        //echo($pro['imagen']);
                        if(strlen($pro['imagen'])>3){ $imagen_practica = "profiles/".$pro['imagen']; } else { $imagen_practica = "img/unknown_empresa.jpg"; }
                        ?>
                        <div>
                            <label>
                            <div class="img_circle">
                            <a href="index.php?id=profile&user=<?=$pro['id_user']?>"><img src="<?=$imagen_practica?>" class="img_portada" /></a>
                            </div>
                            </label>
                            <span>
                                <h4><a href="index.php?id=profile&user=<?=$pro['id_user']?>"><?=$pro['nombre']?></a></h4>
                            </span>
                        </div>
                        <?
                    }
                } else {
                    ?><br />No hay buenas pr&aacute;cticas por el momento<?
                }
                ?>
            </div>
        </div>
    	<!--<img src="img/portada.png" />-->
    



    </div>



    <div class="index_right">
        
        <form class="form-signin" role="form" name="form" method="post" action="entrar.php">
        <div class="user-form login_form login_index">
            <div class="titulo">
            <br /><br />
            <strong>Si ya tienes usuario, inicia sesi&oacute;n aqu&iacute;</strong>
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" name="user" required autofocus>
            </div>
            <div class="form-group">
                <input type="password"  placeholder="Contrase&ntilde;a" name="pass" required>
            </div>
            <div class="form-group">
                <input type="checkbox" name="noclose" value="true" checked="checked"> No cerrar sesi&oacute;n
            </div>
            <div class="form-group" id="buttons">
                <input  name="entrar" type="submit" value="Entrar"></input>
            </div>
            <div class="form-group">
                <a href="index.php?id=lostpass">&iquest;Olvid&oacute; su Contrase&ntilde;a?</a> 
            </div>
        </div>
        	<input type="hidden" value="entrar" name="id">
            <input type="hidden" name="refer" value="<?=$REFER_URL_NEXT?>">
        </form>
        
        <form class="form-signin" role="form" name="form" method="post" action="index.php?id=registro">
        <div class="user-form login_form login_index">
        	<div class="titulo">
            
            <input type="radio" name="tipo" checked="checked" value="2" id="productor"/>
            <label for="productor" class="but-index" title="Entrar como productor" >Productor</label>
            <input type="radio" name="tipo" id="proveedor" value="1"  />
            <label for="proveedor" class="but-index" title="Entrar como proveedor" >Proveedor</label>
            
            <br /><br />
            <strong>Registrarse como <span id="registeras">Productor</span></strong></div>
            <div class="form-group">
                <input type="text" placeholder="Nombre de empresa" name="nombre_empresa" required >
            </div>
            <div class="form-group">
                <input type="text" placeholder="Cargo" name="cargo" required >
            </div>
            <div class="form-group">
                <input type="text" placeholder="Nombre de contacto" name="nombre" required >
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email de contacto" name="email" required >
            </div>
            <div class="form-group">
                <input type="text" placeholder="Tel&eacute;fono de contacto" name="telefono" required >
            </div>
            <div class="form-group" id="buttons">
                <input name="registrar" type="submit" value="Registrarse"></input>
                <input type="hidden" name="tipo" id="tipo_user" value="productor" />
            </div>
            
            
        </div>
            <input type="hidden" name="refer" value="<?=$REFER_URL_NEXT?>">
        </form>
        
	</div>
    
</div>
<script>
$(document).ready(function() {
    $(".slick-slider").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: true,
        centerMode: true,
        focusOnSelect: true
    });
	$("#productor").change(function() {
		if(this.checked) {
			document.getElementById('registeras').innerHTML = 'Productor';
			document.getElementById('tipo_user').value = 'productor';
			
		}
	});
	$("#proveedor").change(function() {
		if(this.checked) {
			document.getElementById('registeras').innerHTML = 'Proveedor';
			document.getElementById('tipo_user').value = 'proveedor';
		}
	});
});
</script>
    
            
</body>
</html>
