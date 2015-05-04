<?php
	include('conexion.php');

	@$opc = $_REQUEST['opc'];
	@$informacion = array();

	@$idpr       = $_POST['id'];
	@$nombrepr   = $_POST['nombre'];
	@$descpr     = $_POST['desc'];
	@$cantidadpr = $_POST['cantidad'];
	@$valorpr    = $_POST['valor'];
	@$entrega    = $_POST['entrega'];
	@$hora       = $_POST['hora'];

	switch ($opc) {
		case 'registrar':
			session_start();
			$usu      = $_SESSION['usulogmarket'];
			$valtotal = 0;
			for($i = 0;$i < count($cantidadpr);$i++)
			{
				$valtotal += $cantidadpr[$i] * $valorpr[$i];
			}
			$crea = mysql_query("INSERT INTO pedidos VALUES ('','$usu',NOW(),'$entrega','$hora','$valtotal') ");
			if($crea)
			{
				$sel = mysql_query("SELECT MAX(Id_pd) as id FROM pedidos ");
				$res = mysql_fetch_array($sel);
				$id  = $res['id'];
				for($i = 0;$i < count($nombrepr);$i++)
				{
					$crea = mysql_query("INSERT INTO pedidos_detalles VALUES ('$id','$nombrepr[$i]','$descpr[$i]','$cantidadpr[$i]','$valorpr[$i]') ");
				}

				$bus = mysql_query("SELECT * FROM compradores WHERE Nit_cp = '$usu' ");
				$res2 = mysql_fetch_array($bus);
				$cliente = $res2['razon_cp'];

				$asunto = "Bigmarket - Nuevo pedido";
			 	$cabeceras = "From: $cliente - $asunto";
				$email_to = "correo@bigmarketmayorista.com";
				$contenido = "Nuevo pedido: \n"
				. "\n"
				. "\n"
				. "Cliente: $cliente \n"
				. "Id Pedido: $id \n"
				. "\n";

				if (@mail($email_to, $asunto ,$contenido ,$cabeceras ))
					echo 'correcto';

				$informacion['status'] = 'correcto';
			}
			else
				$informacion['status'] = 'error';

			echo json_encode($informacion);
		break;

		default:
			break;
	}

?>