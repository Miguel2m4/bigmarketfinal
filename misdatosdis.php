<?php
	session_start();
	if($_SESSION['tipousumarket']!='distribuidor')
		header('Location: index');
	else
	{
		include('libs/conexion.php');
		$us = $_SESSION['usulogmarket'];
		$sel = mysql_query("SELECT * FROM distribuidores WHERE  Nit_ds='$us' ");
		$res = mysql_fetch_array($sel);
	}
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
<div id="lado1"><a href="/"><h2><?php echo $res['razon_ds']; ?></h2></a></div>
</header>
<nav>
	<div id="lado2"><?php include("menu2.php"); ?></div>
</nav>
<section class="principal">
	<h2>Mis Datos</h2>
	<form class="forma" id="perfil">
		<input type="text" placeholder="Nit o CC" value="<?php echo $res['Nit_ds']; ?>" disabled required>
		<input type="text" placeholder="Razón Social" value="<?php echo $res['razon_ds']; ?>" disabled required>
		<input type="text" placeholder="Telefono" name="telefono" value="<?php echo $res['telefono_ds']; ?>" required>
		<input type="text" placeholder="Movil" name="movil" value="<?php echo $res['movil_ds']; ?>">
		<input type="text" placeholder="Dirección" name="direccion" value="<?php echo $res['direccion_ds']; ?>" required>
		<input type="email" placeholder="Email" name="email" value="<?php echo $res['email_ds']; ?>" required>
		<input type="text" placeholder="Contraseña" name="pass" >
		<br>
		Mi imagen:
		<br>
		<div class="img_distri">
			<img src="<?php echo substr($res['imagen_ds'],1); ?>">
		</div>
		<input type="file" id="adjunto">
		<br><br>
		<input type="submit" value="Guardar">
	</form>
</section>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/script-menu.js"></script>
<script type="text/javascript" src="js/script_misdatosdis.js"></script>
</body>
</html>