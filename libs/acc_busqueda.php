<?php
include('conexion.php');

@$informacion = array();
@$categoria = $_REQUEST['categoria'];
@$producto = $_POST['producto'];

if(!isset($categoria))
	$categoria= array('1','2','3','4','5','6','7');
foreach ($categoria as $cate) {
	$bus = mysql_query("SELECT  productos.*,distribuidores.imagen_ds FROM productos,distribuidores
		WHERE distribuidores.categoria_ds='$cate' AND productos.distribuidor_pr=distribuidores.razon_ds AND nombre_pr like '%$producto%' AND aprobado='si' ");
	while($res = mysql_fetch_object($bus))
	{
		$informacion[] = $res;
	}
}
echo json_encode($informacion);

?>