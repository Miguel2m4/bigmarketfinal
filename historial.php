<?php
	session_start();
	if(!isset($_SESSION['usulogmarket']))
		header('Location: index');
	else
	{
		include("libs/conexion.php");
		$usu  = $_SESSION['usulogmarket'];
		$tipo = $_SESSION['tipousumarket'];
		@$fecini = $_REQUEST['fecini'];
		@$fecfin = $_REQUEST['fecfin'];

		if($tipo !='comprador')
			$usu = '%';
		if($fecini == '')
			$bus = mysql_query("SELECT COUNT(Id_pd) FROM pedidos WHERE comprador_pd like '$usu' AND realizado_pd BETWEEN '1999-01-01' AND '2050-01-01' ");
		else
			$bus = mysql_query("SELECT COUNT(Id_pd) FROM pedidos WHERE comprador_pd like '$usu' AND realizado_pd BETWEEN '$fecini' AND '$fecfin' ");

		$row       = mysql_fetch_row($bus);
		$rows      = $row[0];
		$page_rows = 20;
		$last      = ceil($rows/$page_rows);

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
		if($fecini == '')
			$bus = mysql_query("SELECT * FROM pedidos WHERE comprador_pd like '$usu' AND realizado_pd BETWEEN '1999-01-01' AND '2050-01-01'  ORDER BY Id_pd DESC $limit ");
		else
			$bus = mysql_query("SELECT * FROM pedidos WHERE comprador_pd like '$usu' AND realizado_pd BETWEEN '$fecini' AND '$fecfin'  ORDER BY Id_pd DESC $limit ");

		$paginationCtrls = '';

		if($last != 1){

			if ($pagenum > 1)
			{
			    $previous = $pagenum - 1;
				$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'&fecini='.$fecini.'&fecfin='.$fecfin.'">Anterior</a> &nbsp; &nbsp; ';

			    for($i = $pagenum-4; $i < $pagenum; $i++){
			     	if($i > 0){
			            $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&fecini='.$fecini.'&fecfin='.$fecfin.'">'.$i.'</a> &nbsp; ';
			     	}
			    }
			}

		 	$paginationCtrls .= ''.$pagenum.' &nbsp; ';

		  	for($i = $pagenum+1; $i <= $last; $i++){
		    	$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&fecini='.$fecini.'&fecfin='.$fecfin.'">'.$i.'</a> &nbsp; ';
			    if($i >= $pagenum+4){
			      break;
			    }
		 	}

		    if ($pagenum != $last) {
		        $next = $pagenum + 1;
		        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'&fecini='.$fecini.'&fecfin='.$fecfin.'">Siguiente</a> ';
		    }
		}

		$list = '';
		while($row = mysql_fetch_array($bus, MYSQLI_ASSOC)){
			if($tipo != 'comprador')
			{
				$bus2 = mysql_query("SELECT * FROM compradores WHERE Nit_cp ='$row[comprador_pd]' ");
				$res  = mysql_fetch_array($bus2);
				$cp   = '<td>'.$res['razon_cp'].'</td>';
			}
			else
				$cp='';
			$list.='<tr>
						<td class="mayus">'.$row['Id_pd'].'</td>
						'.$cp.'
						<td>'.$row['realizado_pd'].'</td>
						<td>'.$row['entrega_pd'].'</td>
						<td>'.$row['hora_pd'].'</td>
						<td><a href="javascript:void(0)" class="ver" id="'.$row['Id_pd'].'">Pedido'.$row['Id_pd'].str_replace('-','',implode("-", array_reverse(explode("-", $row['realizado_pd'])))).'</a></td>
					</tr>';
		}

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
<title>Historial | BIGMARKET.COM MAYORISTA</title>
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/stylesheetadmin.css" />
<link rel="stylesheet" href="css/style2.css" />
<link rel="stylesheet" href="css/msj.css" />
<link rel="stylesheet" type="text/css" href="css/style-menu.css">
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/ >
<script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
</head>
<body>
<header>
	<?php
		if($tipo =='comprador')
		{
			$sel = mysql_query("SELECT * FROM compradores WHERE  Nit_cp='$usu' ");
			$res = mysql_fetch_array($sel);
			$us  =  $res['razon_cp'];
		}
		else if($tipo == 'distribuidor')
		{
			$sel = mysql_query("SELECT * FROM distribuidores WHERE  Nit_ds='$usu' ");
			$res = mysql_fetch_array($sel);
			$us  =  $res['razon_ds'];
		}
		else
			$us = 'Administrador';

	?>
	<div id="lado1"><a href="/"><h2><?php echo $us; ?></h2></a></div>
</header>
<nav>
	<div id="lado2"><?php include("menu2.php"); ?></div>
</nav>
<section class="principal">
	<h2>Historial</h2>
	<div class="fechas">
		<form method="GET" action="historial">
			<div class="fecha-calend">
				Desde : <input type="text" name="fecini" value="<?php echo @$fecini; ?>" required>
				<img src="images/calendar.png" >
			</div>    
			<div class="fecha-calend">
				Hasta : <input type="text" name="fecfin" value="<?php echo @$fecfin; ?>" required>
				<img src="images/calendar.png" >
			</div>    
			<input type="submit" value="Buscar">
		</form>
	</div>
		<div class="tabla-pro">
	<table>
		<thead>
			<tr>
				<td>Numero</td>
				<?php
					if($tipo != 'comprador')
						echo'<td>Comprador</td>';
				?>
				<td>Fecha Realizado</td>
				<td>Fecha Entrega</td>
				<td>Horario de Entrega</td>
				<td>Ver Pedido</td>
			</tr>
		</thead>
		<tbody>
			<?php echo $list; ?>
		</tbody>
	</table>
	<div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
	</div>

</section>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/script-menu.js"></script>
<script type="text/javascript" src="js/script_historialped.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
</body>
</html>