<?php

include('conexion.php');

@$opc = $_REQUEST['opc'];
@$busq = strtolower($_GET["term"]);
@$busq2 = mysql_real_escape_string($_GET['q']);
@$informacion = array();

@$idprod = $_POST['idprod'];
@$nombre = $_REQUEST['nombre'];
@$descr = $_POST['descr'];
@$valor = $_POST['valor'];
@$distribuidor = $_POST['distribuidor'];
@$aprobar = $_POST['aprobar'];

//imagen
@$producto_folder ='../distribuidores/productos';
@$nombre_archivo = $_FILES['imagenprod']['name'];
@$tmp_archivo = $_FILES['imagenprod']['tmp_name'];
//
//buscar producto
if($busq!='')
{
	session_start();
	if($_SESSION['tipousumarket']=='distribuidor')
	{
		$bus = mysql_query("SELECT * FROM distribuidores WHERE Nit_ds='$_SESSION[usulogmarket]' ");
		$res = mysql_fetch_object($bus);
		$bus = mysql_query("SELECT nombre_pr from productos where nombre_pr like '%$busq%' AND distribuidor_pr ='$res->razon_ds' ");
	}
	else
		$bus = mysql_query("SELECT nombre_pr from productos where nombre_pr like '%$busq%'");
	while($resp = mysql_fetch_array($bus))
		{
			$informacion[] = $resp['nombre_pr'];
		}
	echo json_encode($informacion);
}

if($busq2!='')
{
	$bus = mysql_query("SELECT productos.nombre_pr,categorias.tipo FROM productos,distribuidores,categorias
		WHERE productos.nombre_pr like '%$busq2%'  AND productos.distribuidor_pr=distribuidores.razon_ds AND distribuidores.categoria_ds=categorias.ref  ");
	while($resp = mysql_fetch_array($bus))
		{
			$informacion['myData'][] = array(
				'categoria' =>$resp['tipo'],
				'producto'  =>$resp['nombre_pr']
			);
		}
	if(mysql_num_rows($bus)==0)
	{
		$informacion['myData'][] = array(
				'categoria' =>'',
				'producto'  =>'No hay resultados'
			);
	}
	echo json_encode($informacion);
}

switch ($opc) {
	case 'crear':
		$img= 0;
		$archivador='';
		if(isset($nombre_archivo))
		{
			$archivador = $producto_folder . '/'.str_replace(' ','_',$nombre_archivo);
			if(!move_uploaded_file($tmp_archivo, $archivador))
				$img = 1;
		}

		if($img != 1)
		{
			session_start();
			if($_SESSION['tipousumarket']=='distribuidor')
			{
				$bus = mysql_query("SELECT * FROM distribuidores WHERE Nit_ds='$_SESSION[usulogmarket]' ");
				$res = mysql_fetch_object($bus);
				$crea = mysql_query("INSERT INTO productos VALUES ('','$nombre','$descr','$valor','$res->razon_ds','$archivador','$aprobar') ");
			}
			else
				$crea = mysql_query("INSERT INTO productos VALUES ('','$nombre','$descr','$valor','$distribuidor','$archivador','$aprobar') ");
			$respuesta['status'] = 'correcto';
		}
		else
			$respuesta['status'] = 'error';

		echo json_encode($respuesta);
	break;
	case 'comprobar':
		$bus = mysql_query("SELECT nombre_pr FROM productos WHERE nombre_pr='$nombre' ");
		if(mysql_num_rows($bus)!=0)
			echo'error';
		else
			echo'correcto';
	break;
	case 'cargardat':
		$bus = mysql_query("SELECT * FROM productos WHERE nombre_pr='$nombre' ");
		$res = mysql_fetch_object($bus);
		$informacion[]=$res;
		echo '{"info":'.json_encode($informacion).'}';
	break;
	case 'editar':
		$img= 0;
		if(isset($nombre_archivo))
		{
			$archivador = $producto_folder . '/'.str_replace(' ','_',$nombre_archivo);
			if(!move_uploaded_file($tmp_archivo, $archivador))
				$img = 1;
			else
			{
				$bus = mysql_query("SELECT * FROM productos WHERE Id_pr='$idprod' ");
				$res = mysql_fetch_object($bus);
				if($res->imagen_pr!=$archivador)
					unlink($res->imagen_pr);
				$edit = mysql_query("UPDATE productos SET imagen_pr='$archivador' WHERE Id_pr='$idprod' ");
			}
		}

		if($img != 1)
		{
			$edit = mysql_query("UPDATE productos SET nombre_pr='$nombre', descr_pr='$descr',valor_pr='$valor',aprobado='$aprobar' WHERE Id_pr='$idprod' ");
			$respuesta['status'] = 'correcto';
		}
		else
			$respuesta['status'] = 'error';

		echo json_encode($respuesta);
	break;
	case 'bloquear':
		$act = mysql_query("UPDATE productos SET aprobado='$aprobar' WHERE Id_pr='$idprod' ");
	break;
	default:

		break;
}

function crypt_blowfish_bycarluys($password, $digito = 7) {
	$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$salt = sprintf('$2a$%02d$', $digito);
	for($i = 0; $i < 22; $i++)
	{
	 $salt .= $set_salt[mt_rand(0, 63)];
	}
	return crypt($password, $salt);
}

?>