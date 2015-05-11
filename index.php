<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width , initial-scale=1 ,maximum-scale=1 user-scalable=no" />
<meta name="keywords" lang="es" content="">
<meta name="robots" content="All">
<meta name="description" lang="es" content="">
<title>BIGMARKET.COM MAYORISTA</title>
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/stylesheet.css" />
<link rel="stylesheet" href="css/style1.css" />
<link rel="stylesheet" href="css/login_style.css" />
<link rel="stylesheet" href="css/msj.css" />
<link rel="stylesheet" type="text/css" href="css/style-menu.css">
<link href="css/jquery-ui/jquery-ui.min.css" rel="stylesheet">

</head>
<body>
<header>
<div id="lado1"><a href="/"><h2>Bigmarket.com</h2></a></div>
<div id="lado2"><?php include("menu.php"); ?></div>
</header>
<div class="contene-busca">
	<div id="conten1"><img src="images/carrito.png">
		<div id="tituli"><img src="images/titulo.png"></div>
		<form id="busqueda1" method="POST" action="resultado-busqueda">
			<span id="buscar"><span class="icon-buscar"></span></span>
			<input type="text" placeholder="¿Qué deseas Buscar?" name="producto" class="auto" required>
		</form>
	</div>
</div>
<div class="contenido1">
	<h2>Selecciona la categoría </h2>
	<form id="busqueda2" method="POST" action="resultado-busqueda">
		<div class="categoria">
			<p><input type="checkbox" name="categoria[]" value="7"> Viveres y Abarrotes </p>
		</div>
		<div class="categoria">
			<p><input type="checkbox" name="categoria[]" value="2"> Carnicos </p>
		</div>
		<div class="categoria">
			<p><input type="checkbox" name="categoria[]" value="4"> Pollo </p>
		</div>
		<div class="categoria">
			<p><input type="checkbox" name="categoria[]" value="3"> Pescaderia</p>
		</div>
		<div class="categoria">
			<p> <input type="checkbox" name="categoria[]" value="6"> Salsamentaria</p>
		</div>
		<div class="categoria">
			<p><input type="checkbox" name="categoria[]" value="1"> Aseo industrial</p>
		</div>
		<div class="categoria">
			<p><input type="checkbox" name="categoria[]" value="5"> Rancho y Licores</p>
		</div>
		<div>
			<input type="submit" value="Buscar ahora!">
		</div>
	</form>
</div>

<hr class="divi1">

<div class="contenido2">
<h2>NUESTRAS EMPRESAS</h2>
	<div class="catsegunda" id="7">
		<a href="javascript:void(0)">
			<img  class="df1" src="images/ejemplo.png" />
			<img  class="df2" src="images/pollo.png" style="display: none;opacity:0" />
			<h2>Vivieres y Abarrotes</h2>
		</a>
	</div>
	<div class="catsegunda" id="2">
		<a href="javascript:void(0)">
			<img  class="df1" src="images/ejemplo.png" />
			<img  class="df2" src="images/carne.png" style="display: none;opacity:0" />
			<h2>Cárnicos</h2>
		</a>
	</div>
	<div class="catsegunda pollo" id="4">
		<a href="javascript:void(0)">
			<img  class="df1" src="images/ejemplo.png" />
			<img  class="df2" src="images/pollo.png" style="display: none;opacity:0" />
			<h2>Pollo</h2>
		</a>
	</div>
	<div class="catsegunda" id="3">
		<a href="javascript:void(0)">
			<img  class="df1" src="images/ejemplo.png" />
			<img  class="df2" src="images/pez.png" style="display: none;opacity:0" />
			<h2>Pescadería</h2>
		</a>
	</div>
	<div class="catsegunda" id="6">
		<a href="javascript:void(0)">
			<img  class="df1" src="images/ejemplo.png" />
			<img  class="df2" src="images/salsa.png" style="display: none;opacity:0" />
			<h2>Salsamentaría</h2>
		</a>
	</div>
	<div class="catsegunda" id="1">
		<a href="javascript:void(0)">
			<img  class="df1" src="images/ejemplo.png" />
			<img  class="df2" src="images/aseo.png" style="display: none;opacity:0" />
			<h2>Aseo industrial</h2>
		</a>
	</div>
	<div class="catsegunda" id="5">
		<a href="javascript:void(0)">
			<img  class="df1" src="images/ejemplo.png" />
			<img  class="df2" src="images/licor.png" style="display: none;opacity:0" />
			<h2>Rancho y Licores</h2>
		</a>
	</div>
</div>


<footer>
	<div id="foot">
		<div class="footersec">
			<h2>Información de contacto</h2>
			<p><strong>Email:</strong> correo@bigmarketmayorista.com</p>
			<p><strong>Telefono:</strong> (8) 684 48 40</p>
			<p><strong>Celular:</strong> +57 311 499 82 55 - 313 221 68 73</p>
			<p><strong>Dirección:</strong> Calle 31 No 16A - 04 B - La Ceiba</p>
		</div>
		<div class="footersec">
		<h2>Deseas recibir mas Información</h2>
		<p>Ingresa tu correo para recibir mas informacion</p><p>acerca de novedades en nuestros productos.</p>
			<form>
				<input type="email" placeholder="Email" required>
				<input type="submit" value="Enviar">
			</form>
		</div>
		<div class="footersec"></div>
		<hr class="divi1">
		<div id="copyright">
            <p>Copyright © Bigmarket.com SAS, 2015.Todos los derechos reservados diseñado por <a href="http://inngeniate.com/" target="blank"> Inngeniate.com</a></p>
            <div id="logo">
                <img src="images/logoinn.png">
            </div>
        </div>
    </div>
</footer>


	<div class="cd-user-modal">
		<div class="cd-user-modal-container">
			<div id="cd-login">
				<form class="cd-form" id="iniciar">
					<p class="fieldset">
						<label class="image-replace cd-username">Usuario</label>
						<input class="full-width has-padding has-border" type="text" placeholder="Usuario" name="usuario">
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" >Password</label>
						<input class="full-width has-padding has-border" type="password" placeholder="Password" name="password">
						<a href="#0" class="hide-password">Mostrar</a>
					</p>

					<p class="fieldset">
						<input class="full-width" type="submit" value="Iniciar">
					</p>
				</form>

			</div>

			<a href="#0" class="cd-close-form">Close</a>
		</div>
	</div>


<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/script-menu.js"></script>
<script type="text/javascript" src="js/script_inicio.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script src="js/modernizr.js"></script>
<script src="js/modal_login.js"></script>
<script src="js/script_login.js"></script>
</body>
</html>