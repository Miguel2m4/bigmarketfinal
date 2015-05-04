<?php
include("conexion.php");

    $usuario = mysql_real_escape_string($_POST['usuario']);
    $pswd = mysql_real_escape_string($_POST['password']);
    $answer = array();
    $sel = mysql_query("SELECT  * FROM usuarios WHERE Usuario_us='$usuario' ");
    if ($resp = mysql_num_rows($sel)!=0)
    {
        $resp = mysql_fetch_array($sel);
        $pass = $resp['pass_us'];
        if( crypt($pswd, $pass) == $pass)
        {
            session_start();
            $_SESSION['usulogmarket'] = $resp['Usuario_us'];
            $bus = mysql_query("SELECT tipo_us from usuarios where Usuario_us='$usuario'");
            $resp2=mysql_fetch_array($bus);
            $_SESSION['tipousumarket'] = $resp2['tipo_us'];
            if($resp['aprobado_us'] != 'si')
            {
                $answer = 'bloqueo';
                unset($_SESSION['usulogmarket']);
                unset($_SESSION['tipousumarket']);
                session_destroy();
            }
            else
            {
                if($_SESSION['tipousumarket'] == 'distribuidor')
                    $answer['redirec'] = 'productodis';
                else
                    $answer['redirec'] = 'historial';
            }
        }
        else
            $answer = 'error';
    }
    else
    {
    	 $answer = 'error';
    }
    echo json_encode($answer);
?>