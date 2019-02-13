<?php
echo
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html> 
<head> 
<title>TIENDA VIRTUAL</title>
<style type="text/css">
	table {
    	margin: 0 auto;
    	margin-top: 100px;
    }
    .iz{
    	text-align: left;
    }
    .cen{
    	text-align: center;
    }
    img{
        width:100px;
        height: 100px;
    }
</style>
</head> 

<body> ';

$cadSql="SELECT *
FROM producto
where stock > 0
order by familia, PVP";

$conexion= new mysqli("localhost", "root", "", "oficina");
$conexion->query("SET NAMES utf8");
$resultado=$conexion->query($cadSql);
echo "<table border=1>"; 
echo "<tr><th colspan=5 align='center'>Listado de productos</th></tr>";
echo "<tr><th>Nombre</th><th>Descripcion</th><th>PVP</th><th>Familia</th><th>Imagen</th></tr>";

while ($fila = $resultado->fetch_assoc())
{
echo "<tr><td class='iz'>".$fila['nombre']."</td><td class='iz'>".$fila['descripcion']."</td><td class='cen'>".$fila['PVP']." €</td><td class='cen'>".$fila['familia']."</td><td><img src='".$fila['imagen']."'></td></tr>";
}
echo '</table><br><form  align="center" action="index.php" method="post">
 
    
   <input type="submit" value="Volver al login" >
 
</form>';
?>