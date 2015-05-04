<?php
	session_start();
	if($_SESSION['tipousumarket']!='administrador')
		header('Location: index');
	else
	{
		include('libs/conexion.php');
		$us = $_SESSION['usulogmarket'];
		$sel = mysql_query("SELECT * FROM distribuidores WHERE  Nit_ds='$us' ");
		$res = mysql_fetch_array($sel);

		$totales = 0;
		@$prod = $_REQUEST['prod'];
		@$distr = $_REQUEST['distr'];

		if($prod=='')
			$prod = '%';
		if($distr=='')
			$distr = '%';
		$bus2 = mysql_query("SELECT * FROM distribuidores WHERE razon_ds like '$distr' ");
		while($res2 = mysql_fetch_object($bus2))
		{
			$bus3 = mysql_query("SELECT nombre_pr from productos where nombre_pr like '%$prod%' AND distribuidor_pr ='$res2->razon_ds' ");
			while($res3 = mysql_fetch_object($bus3))
			{
				$bus4 = mysql_query("SELECT COUNT(nombre_pr) FROM pedidos_detalles WHERE nombre_pr = '$res3->nombre_pr' GROUP BY nombre_pr  ");
				if(mysql_fetch_row($bus4)!=0)
					$totales++;
			}
		}

		$rows = $totales;
		$page_rows = 15;

		$last = ceil($rows/$page_rows);

		if($last < 1){
			$last = 1;
 		}
 		$pagenum = 1;

 		if(isset($_GET['pn'])){
		  $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
		}
		if ($pagenum < 1) {
		    $pagenum = 1;
		} else if ($pagenum > $last) {
		    $pagenum = $last;
		}
		$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

		$paginationCtrls = '';
		if($last != 1){

			if ($pagenum > 1)
			{
			    $previous = $pagenum - 1;
				$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'&idstri='.$distr.'">Anterior</a> &nbsp; &nbsp; ';

			    for($i = $pagenum-4; $i < $pagenum; $i++){
			     	if($i > 0){
			            $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&idstri='.$distr.'">'.$i.'</a> &nbsp; ';
			     	}
			    }
			}

		 	$paginationCtrls .= ''.$pagenum.' &nbsp; ';

		  	for($i = $pagenum+1; $i <= $last; $i++){
		    	$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&idstri='.$distr.'">'.$i.'</a> &nbsp; ';
			    if($i >= $pagenum+4){
			      break;
			    }
		 	}
		 	if ($pagenum != $last) {
		        $next = $pagenum + 1;
		        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'&idstri='.$distr.'">Siguiente</a> ';
		    }
		}

		$list = '';

		$bus2 = mysql_query("SELECT * FROM distribuidores WHERE razon_ds like '$distr'  $limit ");
		while($res2 = mysql_fetch_object($bus2))
		{
			$bus3 = mysql_query("SELECT Id_pr,nombre_pr,aprobado from productos where nombre_pr like '%$prod%' AND distribuidor_pr ='$res2->razon_ds'  $limit  ");
			while($res3 = mysql_fetch_object($bus3))
			{
				$bus4 = mysql_query("SELECT nombre_pr,SUM(cant_pr) as total FROM pedidos_detalles WHERE nombre_pr = '$res3->nombre_pr' GROUP BY nombre_pr ORDER BY nombre_pr DESC  ");
				if(mysql_num_rows($bus4)!=0)
				{
					$row = mysql_fetch_array($bus4);

					$sel  = mysql_query("SELECT * FROM categorias WHERE ref ='$res2->categoria_ds' ");
					$rsel = mysql_fetch_object($sel);
					$cat  = $rsel->tipo;
					if($res3->aprobado=='no')
						$apr = '<td><input type="checkbox" class="bloqueo" id="'.$res3->Id_pr.'" checked></td>';
					else
						$apr = '<td><input type="checkbox" class="bloqueo" id="'.$res3->Id_pr.'"></td>';
					$list.='<tr>
								<td class="mayus">'.$row['nombre_pr'].'</td>
								<td class="mayus">'.$cat.'</td>
								<td class="mayus">'.$res2->razon_ds.'</td>
								<td>'.$row['total'].'</td>
								'.$apr.'
							</tr>';
				}
				else
				{
					$sel  = mysql_query("SELECT * FROM categorias WHERE ref ='$res2->categoria_ds' ");
					$rsel = mysql_fetch_object($sel);
					$cat  = $rsel->tipo;
					if($res3->aprobado=='no')
						$apr = '<td><input type="checkbox" class="bloqueo" id="'.$res3->Id_pr.'" checked></td>';
					else
						$apr = '<td><input type="checkbox" class="bloqueo" id="'.$res3->Id_pr.'"></td>';
					$list.='<tr>
								<td class="mayus">'.$res3->nombre_pr.'</td>
								<td class="mayus">'.$cat.'</td>
								<td class="mayus">'.$res2->razon_ds.'</td>
								<td>0</td>
								'.$apr.'
							</tr>';
				}
			}
		}

	}
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
<link rel="stylesheet" href="css/stylesheetadmin.css" />
<link rel="stylesheet" href="css/style2.css" />
<link rel="stylesheet" type="text/css" href="css/style-menu.css">
<link rel="stylesheet" href="css/msj.css" />
<link href="css/jquery-ui/jquery-ui.min.css" rel="stylesheet">
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
<div class="submenu">
	<a href="javascript:void(0)" id="edit"><</a><a href="#verproductos" id="verprods">Listar productos</a>
</div>
	<h2>Productos</h2>
	<form class="forma" id="producto">
		<select required id="accion">
			<option value="">Seleccionar</option>
			<option value="crear">Crear</option>
			<option value="editar">Editar</option>
		</select>
		<input type="hidden" name="idprod">
		<input type="text" placeholder="Nombre del Producto" name="nombre" required disabled>
		<input type="text" placeholder="Caracteristica" name="descr" required disabled>
		<input type="number" placeholder="Valor Unitario" name="valor" required disabled>
		<select required name="distribuidor" disabled>
			<option value="">Seleccionar Distribuidor</option>
			<?php
				include('libs/conexion.php');
				$bus = mysql_query("SELECT razon_ds FROM distribuidores");
				while($res = mysql_fetch_object($bus))
				{
					echo'<option value="'.$res->razon_ds.'">'.$res->razon_ds.'</option>';
				}
			?>
		</select>
		<input type="file" id="adjunto" disabled>
		<label>Abrobado </label><input type="radio" name="aprobar" value="si" disabled> <label>Pendiente </label><input type="radio" name="aprobar" value="no" disabled>
		<br>
		<input type="submit" value="Guardar" disabled>
	</form>

<div id="verproductos" style="display: none" >
	<form class="forma" method="GET" action="producto">
		<p>Busqueda:</p>
		<input type="text" placeholder="Nombre del Producto"  class='auto2' name="prod" >
		<select name="distr">
			<option value="">Seleccione Distribuidor</option>
			<?php
				$sel = mysql_query("SELECT * FROM distribuidores");
				while($res = mysql_fetch_object($sel))
				{
					echo'<option>'.$res->razon_ds.'</option>';
				}
			?>

		</select>
		<input type="submit" value="Buscar">
	</form>

	<div class="tabla-pro">
		<table>
			<thead>
				<tr>
					<td>
						Nombre
					</td>
					<td>
						Categoria
					</td>
					<td>
						Distribuidor
					</td>
					<td>
						Adquisición
					</td>
					<td>
						Bloquear
					</td>
				</tr>
			</thead>
			<tbody>
				<?php echo $list; ?>
			</tbody>
		</table>
		<div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
	</div>
</div>

</section>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/script-menu.js"></script>
<script type="text/javascript" src="js/script_producto.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
</body>
</html>