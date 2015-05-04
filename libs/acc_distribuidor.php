<?php

include('conexion.php');

@$opc = $_REQUEST['opc'];
@$informacion = array();

@$nit = $_REQUEST['nit'];
@$categoria = $_POST['categoria'];
@$razon = $_POST['razon'];
@$telefono = $_POST['telefono'];
@$movil = $_POST['movil'];
@$direccion = $_POST['direccion'];
@$email = $_POST['email'];
@$pass = $_POST['pass'];
@$aprobar = $_POST['aprobar'];

//imagen
@$distri_folder ='../distribuidores';
@$nombre_archivo = $_FILES['imagendis']['name'];
@$tmp_archivo = $_FILES['imagendis']['tmp_name'];
//
switch ($opc) {
	case 'crear':
		$img= 0;
		$archivador='';
		if(isset($nombre_archivo))
		{
			$archivador = $distri_folder . '/'.$nit.'_'.str_replace(' ','-',$nombre_archivo);
			if(!move_uploaded_file($tmp_archivo, $archivador))
				$img = 1;
		}
		if($img != 1)
		{
			if($pass=='')
				$pass = $nit;
			$encript = crypt_blowfish_bycarluys($pass);
			$crea = mysql_query("INSERT INTO distribuidores VALUES ('$nit','$razon','$categoria','$telefono','$movil','$direccion','$email','$archivador') ");
			$encript = crypt_blowfish_bycarluys($pass);
			$usu = mysql_query("INSERT INTO usuarios VALUES('$nit','$encript','distribuidor','$aprobar') ");
			$respuesta['status'] = 'correcto';
		}
		else
			$respuesta['status'] = 'error';

		echo json_encode($respuesta);
	break;
	case 'comprobar':
		$bus = mysql_query("SELECT Nit_ds FROM distribuidores WHERE Nit_ds='$nit' ");
		if(mysql_num_rows($bus)!=0)
			echo'error';
		else
			echo'correcto';
	break;
	case 'cargardat':
		$bus = mysql_query("SELECT * FROM distribuidores WHERE Nit_ds='$nit' ");
		if(mysql_num_rows($bus)!=0)
		{
			$res = mysql_fetch_object($bus);
			$bus2 = mysql_query("SELECT aprobado_us FROM usuarios WHERE Usuario_us='$nit' ");
			$res2 = mysql_fetch_array($bus2);
			$res =(array)$res;
			$res['aprobado'] = $res2['aprobado_us'];
			$res =(object)$res;
			$informacion[]=$res;
		}
		echo '{"info":'.json_encode($informacion).'}';
	break;
	case 'editar':
		$img= 0;
		if(isset($nombre_archivo))
		{
			$archivador = $distri_folder . '/'.$nit.'_'.str_replace(' ','-',$nombre_archivo);
			if(!move_uploaded_file($tmp_archivo, $archivador))
				$img = 1;
			else
			{
				$bus = mysql_query("SELECT * FROM distribuidores WHERE Nit_ds = '$nit' ");
				$res = mysql_fetch_object($bus);
				if($res->imagen_ds!=$archivador)
					unlink($res->imagen_ds);
				$edit = mysql_query("UPDATE distribuidores SET imagen_ds= '$archivador' WHERE Nit_ds='$nit' ");
			}
		}
		if($img != 1)
		{
			$sel =mysql_query("SELECT * FROM distribuidores WHERE Nit_ds='$nit' ");
			$resp = mysql_fetch_object($sel);
			$raz = $resp->razon_ds;
			$edit = mysql_query("UPDATE distribuidores SET categoria_ds='$categoria',razon_ds='$razon',telefono_ds='$telefono',movil_ds='$movil',direccion_ds='$direccion',email_ds='$email' WHERE Nit_ds='$nit' ");
			$edit = mysql_query("UPDATE usuarios SET aprobado_us='$aprobar' WHERE Usuario_us='$nit' ");
			$edit = mysql_query("UPDATE productos SET distribuidor_pr='$razon' WHERE distribuidor_pr='$raz' ");
			if($pass!='')
			{
				$encript = crypt_blowfish_bycarluys($pass);
				$edit = mysql_query("UPDATE usuarios SET pass_us='$encript' WHERE Usuario_us='$nit' ");
			}
			$respuesta['status'] = 'correcto';
		}
		else
			$respuesta['status'] = 'error';

		echo json_encode($respuesta);
	break;
	case 'editar_ds':
		session_start();
		$us = $_SESSION['usulogmarket'];
		$img= 0;
		if(isset($nombre_archivo))
		{
			$archivador = $distri_folder . '/'.$us.'_'.str_replace(' ','-',$nombre_archivo);
			if(!move_uploaded_file($tmp_archivo, $archivador))
				$img = 1;
			else
			{
				$bus = mysql_query("SELECT * FROM distribuidores WHERE Nit_ds = '$us' ");
				$res = mysql_fetch_object($bus);
				if($res->imagen_ds!=$archivador)
					unlink($res->imagen_ds);
				$edit = mysql_query("UPDATE distribuidores SET imagen_ds= '$archivador' WHERE Nit_ds='$us' ");
			}
		}
		if($img != 1)
		{
			$edit = mysql_query("UPDATE distribuidores SET telefono_ds='$telefono',movil_ds='$movil',direccion_ds='$direccion',email_ds='$email' WHERE Nit_ds='$us' ");
			if($pass!='')
			{
				$encript = crypt_blowfish_bycarluys($pass);
				$edit = mysql_query("UPDATE usuarios SET pass_us='$encript' WHERE Usuario_us='$us' ");
			}
			$respuesta['status'] = 'correcto';
		}
		else
			$respuesta['status'] = 'error';

		echo json_encode($respuesta);
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