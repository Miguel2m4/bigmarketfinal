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
<title>Compradores | BIGMARKET.COM MAYORISTA</title>
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
	<h2>Compradores</h2>
	<form class="forma" id="comprador">
		<select required id="accion" >
			<option value="">Seleccionar</option>
			<option value="crear">Crear</option>
			<option value="editar">Editar</option>
		</select>
		<input type="text" placeholder="Nit o CC" name="nit" disabled required>
		<input type="text" placeholder="Razón Social" name="razon" disabled required>
		<input type="text" placeholder="Telefono" name="telefono" disabled required>
		<input type="text" placeholder="Movil" name="movil" disabled>
		<input type="text" placeholder="Dirección" name="direccion" disabled required>
		<input type="email" placeholder="Email" name="email" disabled required>
		<input type="text" placeholder="Contraseña" name="pass" disabled >
		<label>Abrobado </label><input type="radio" name="aprobar" value="si" disabled required> <label>Pendiente </label><input type="radio" name="aprobar" value="no" disabled>
		<br>
		<input type="submit" value="Guardar" disabled>
	</form>
</section>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/script-menu.js"></script>
<script type="text/javascript" src="js/script_comprador.js"></script>
</body>
</html>