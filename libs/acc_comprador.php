<?php

include('conexion.php');

@$opc = $_REQUEST['opc'];
@$informacion = array();

@$nit = $_REQUEST['nit'];
@$razon = $_POST['razon'];
@$telefono = $_POST['telefono'];
@$movil = $_POST['movil'];
@$direccion = $_POST['direccion'];
@$email = $_POST['email'];
@$pass = $_POST['pass'];
@$aprobar = $_POST['aprobar'];

switch ($opc) {
	case 'crear':
		if($pass=='')
			$pass = $nit;
		$encript = crypt_blowfish_bycarluys($pass);
		$crea = mysql_query("INSERT INTO compradores VALUES ('$nit','$razon','$telefono','$movil','$direccion','$email') ");
		$encript = crypt_blowfish_bycarluys($pass);
		$usu = mysql_query("INSERT INTO usuarios VALUES('$nit','$encript','comprador','$aprobar') ");
		if($crea)
			echo'correcto';
	break;
	case 'comprobar':
		$bus = mysql_query("SELECT Nit_cp FROM compradores WHERE Nit_cp='$nit' ");
		if(mysql_num_rows($bus)!=0)
			echo'error';
		else
			echo'correcto';
	break;
	case 'cargardat':
		$bus = mysql_query("SELECT * FROM compradores WHERE Nit_cp='$nit' ");
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
		$edit = mysql_query("UPDATE compradores SET razon_cp='$razon',telefono_cp='$telefono',movil_cp='$movil',direccion_cp='$direccion',email_cp='$email' WHERE Nit_cp='$nit' ");
		$edit = mysql_query("UPDATE usuarios SET aprobado_us='$aprobar' WHERE Usuario_us='$nit' ");
		if($pass!='')
		{
			$encript = crypt_blowfish_bycarluys($pass);
			$edit = mysql_query("UPDATE usuarios SET pass_us='$encript' WHERE Usuario_us='$nit' ");
		}
		if($edit)
			echo'correcto';
	break;
	case 'editar_cp':
		session_start();
		$us = $_SESSION['usulogmarket'];
		$edit = mysql_query("UPDATE compradores SET razon_cp='$razon',telefono_cp='$telefono',movil_cp='$movil',direccion_cp='$direccion',email_cp='$email' WHERE Nit_cp='$us' ");
		if($pass!='')
		{
			$encript = crypt_blowfish_bycarluys($pass);
			$edit2= mysql_query("UPDATE usuarios SET pass_us='$encript' WHERE Usuario_us='$us' ");
		}
		if($edit2)
			echo'correcto';
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