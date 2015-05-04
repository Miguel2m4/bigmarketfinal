<?php
	include('conexion.php');

	session_start();
	$opc = $_REQUEST['info'];

	if($opc=='log')
	{
		 if(!isset($_SESSION['usulogmarket']))
	    {
	        $status['login'] = 'error';
	    }
	    else
	    {
	    	 $status['login'] = 'correcto';
	    	 if(@$_SESSION['tipousumarket']=='distribuidor')
	    	 	$status['redirec'] = 'productodis';
	    	 else
	    	 	$status['redirec'] = 'historial';
	    }
	}
	if($opc=='tipo')
	{
		if(@$_SESSION['tipousumarket']!='comprador')
    		 $status['tipo'] = 'error';
    	else
    		 $status['tipo'] = 'correcto';
	}

	echo json_encode($status);
?>