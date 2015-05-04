<?php
$conexion=mysql_connect("localhost","hogaresd_bmarket","s^+LzF73z5XQ")or die ("No hay Conexion");
$conectDB=mysql_select_db("hogaresd_bigmarket",$conexion) or die ("no existe BD");
mysql_query ("SET NAMES 'utf8'");
?>
