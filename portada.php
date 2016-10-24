<body>
<?
$REFER_URL_NEXT = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
    
    <div class="hero-image">
        <p> PLATAFORMA <br> INFORMATIVA E INTERACTIVA </p>
    </div>

    <div>
        <h2 class="medidas-portada">MEDIDAS DE EFICIENCIA ENERGÉTICA EN LOS RUBROS:</h2>
    </div>
    <div class="rubros-portada">
        <? $ver_rubros = mysql_query("SELECT id_rubro,nombre,imagen FROM rubros WHERE activo=1 ORDER BY id_rubro ASC");
        if(mysql_num_rows($ver_rubros)>0){
            ?>
            
            <?
            while($rubro = mysql_fetch_array($ver_rubros)){
            ?>
            <div class="rubro-portada">
                <a href="index.php?id=verrubro&rubro=<?=$rubro['id_rubro']?>">
                    <img src="iconos/<?=$rubro['imagen']?>">
                    <p><?=$rubro['nombre']?><p>
                </a>
            </div>
            <?      
            }
            ?>
            </br>
            </br>
            <?
        } else {
            echo "No hay rubros por el momento";    
        }
        ?>
    </div>
    <div class="btnes-portada">
        <div class="btn-portada col-productor">
            <div class="img-btn-portada productor">
                <p>PRODUCTOR</p>
            </div>
            <div class="btn-portada-content">
                Conoce a los productores que están interesados en implementar medidas de eficiencia energética.
                <br><br>
                <a href="">Ver más</a>
            </div>
        </div>
        <div class="btn-portada col-proveedor">
            <div class="img-btn-portada proveedor">
                <p>PROVEEDOR</p>
            </div>
            <div class="btn-portada-content">
                Conoce los proveedores de productos y servicios que te pueden apoyar mejorar tu desempeño energético.
                <br><br>
                <a href="">Ver más</a>
            </div>
        </div>
        <div class="btn-portada col-diagnostico">
            <div class="img-btn-portada diagnostico">
                <p>DIAGNÓSTICO</p>
            </div>
            <div class="btn-portada-content">
                Descubra el potencial de ahorro y mejoramiento de tus procesos productivos con una herramienta de autodiagnóstico.
                <br><br>
                <a href="">Evalúa tu desempeño energético</a>
            </div>
        </div>
    </div>
    <div class="eventos-portada">
            <div class="header-eventos-portada">
                <p>EVENTOS</p>
            </div>
            <div class="eventos">
                <? $eventos = mysql_query("SELECT * FROM eventos ORDER BY fecha DESC limit 3");
                while($evento = mysql_fetch_array($eventos)){ ?>
                    <div class="evento-container">
                        <a href="evento.php?evento=<?=$evento['id_evento']?>"><img src="img/calendar.png"></a>
                        <br>
                        <a href="evento.php?evento=<?=$evento['id_evento']?>"><?=$evento['nombre']?></a>
                    </div>     
                <? } ?>
                <a class="btn-ver-mas" style="display:block;margin-left:auto;margin-right:auto;" href="index.php?id=eventos">Ver más</a>
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
