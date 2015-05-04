<?php
	session_start();
	if($_SESSION['tipousumarket']!='administrador')
		header('Location: index');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width , initial-scale=1 ,maximum-scale=1 user-scalable=no" />
<meta name="keywords" lang="es" content="">
<meta name="robots" content="All">
<meta name="description" lang="es" content="">
<title>Distribuidores | BIGMARKET.COM MAYORISTA</title>
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/stylesheetadmin.css" />
<link rel="stylesheet" href="css/style2.css" />
<link rel="stylesheet" type="text/css" href="css/style-menu.css">
<link rel="stylesheet" href="css/msj.css" />
<script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
</head>
<body>
<header>
<div id="lado1"><a href="/"><h2>Administrador</h2></a></div>
</header>
<nav>
	<div id="lado2"><?php include("menu2.php"); ?></div>
</nav>
<section class="principal">
	<h2>Distribuidores</h2>
	<form class="forma" id="distribuidor">
		<select required id="accion">
			<option value="">Seleccionar</option>
			<option value="crear">Crear</option>
			<option value="editar">Editar</option>
		</select>
		<select required name="categoria" disabled>
			<option value="">Seleccionar Cat</option>
			<option value="1">Aseo industrial</option>
			<option value="2">Carnicos</option>
			<option value="3">Pescaderia</option>
			<option value="4">Pollo</option>
			<option value="5">Rancho y Licores</option>
			<option value="6">Salsamentaria</option>
			<option value="7">Viveres y Abarrotes</option>
		</select>
		<input type="text" placeholder="Nit o CC" name="nit" required disabled>
		<input type="text" placeholder="Razón Social" name="razon" required disabled>
		<input type="text" placeholder="Telefono" name="telefono" required disabled>
		<input type="text" placeholder="Movil" name="movil" disabled>
		<input type="text" placeholder="Dirección" name="direccion" required disabled>
		<input type="email" placeholder="Email" name="email" required disabled>
		<input type="text" placeholder="Contraseña" name="pass" disabled>
		<input type="file" id="adjunto" disabled>
		<label>Abrobado </label><input type="radio" name="aprobar" value="si" disabled> <label>Pendiente </label><input type="radio" name="aprobar" value="no" disabled>
		<br>
		<input type="submit" value="Guardar" disabled>
	</form>
</section>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/script-menu.js"></script>
<script type="text/javascript" src="js/script_distribuidor.js"></script>
</body>
</html>