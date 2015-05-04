<!DOCTYPE html>
	<?php
		include('libs/conexion.php');
		@$producto = $_POST['producto'];
		@$categoria = $_POST['categoria'];
	?>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width , initial-scale=1 ,maximum-scale=1 user-scalable=no" />
<meta name="keywords" lang="es" content="">
<meta name="robots" content="All">
<meta name="description" lang="es" content="">
<title>Productos | BIGMARKET.COM MAYORISTA</title>
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/stylesheet.css" />
<link rel="stylesheet" href="css/style1.css" />
<link rel="stylesheet" href="css/msj.css" />
<link rel="stylesheet" href="css/login_style.css" />
<link rel="stylesheet" type="text/css" href="css/sweetalert2.css">
<link rel="stylesheet" type="text/css" href="css/style-menu.css">
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/ >
<script src="js/modernizr.js"></script>
</head>
<body>
<header>
<div id="lado1"><a href="/"><h2>Bigmarket.com</h2></a></div>
<div id="lado2"><?php include("menu.php"); ?></div>
</header>
<div class="principal">
	<div id="busca">
		<div id="sup-iz">
		<form id="busqueda">
			<span id="buscar2"><span class="icon-buscar"></span></span>
			<input type="text" placeholder="¿Qué deseas buscar?" name="producto" value="<?php echo@$producto;?>">
		</form>
		</div>
		<div id="sup-der"><span id="ubicacion-car"><a href="#" id="mostrar-carrito"><span class="icon-shopping-cart itemcarro"></span></a></span><span id="ped">Cant <span class="bgc">0</span></span><a href="javascript:void(0)" class="terminar-ped">Terminar Pedido</a></div>
	</div>
	<div class="carrito-terminar"></div>
	<div class="carrito">
		<div class="carrito-t">
			<table id="lista">
				<thead>
					<tr>
						<td>
							<h2>El carrito esta vacio.</h2>
						</td>
					</tr>
				</thead>
			</table>
		</div>
		<div class="carrito-respon">
			</div>
	</div>

	<div id="lado-menu">
		<div id="lateral">
			<h2>Categorias</h2>
			<ul id="categorias">
				<a href="javascript:void(0)"><li id="7">Viveres y Abarrotes</li></a>
				<a href="javascript:void(0)"><li id="2">Carnicos</li></a>
				<a href="javascript:void(0)"><li id="4">Pollo</li></a>
				<a href="javascript:void(0)"><li id="3">Pescaderia</li></a>
				<a href="javascript:void(0)"><li id="6">Salsamentaria</li></a>
				<a href="javascript:void(0)"><li id="1">Aseo industrial</li></a>
				<a href="javascript:void(0)"><li id="5">Rancho y Licores</li></a>
				<a href="javascript:void(0)"><li>Todas</li></a>
			</ul>
		</div>
	</div>

	<div id="lado-bus">

		<div id="tags">
			<?php
				if(!isset($categoria))
					$categoria= array('1','2','3','4','5','6','7');
				foreach ($categoria as $cate) {
					$bus = mysql_query("SELECT tipo FROM categorias WHERE ref='$cate'");
					$res = mysql_fetch_object($bus);
					echo'<a href="javascript:void(0)" id="'.$cate.'">'.$res->tipo.'<span class="icon-borrar"></span></a>';
				}
			?>
		</div>
		<div id="carga" style="padding: 10% 0;">
			<img src="images/busq.gif" />
		</div>
		<div id="resultados" style="display: none"></div>
	</div>

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

</div>

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/script-menu.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
<script src="js/menumostrar.js"></script>
<script src="js/modal_login.js"></script>
<script src="js/script_login.js"></script>
<script src="js/script_busqueda.js"></script>
<script src="js/sweetalert2.min.js"></script>
</body>
</html>