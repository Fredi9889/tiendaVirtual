<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html> 
<head> 
<title>TIENDA VIRTUAL</title> 
</head> 

<body> 
<?php
session_start();
//Si la variable sesión está vacía
if (!isset($_SESSION['cliente'])) {
   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
   header("Location:index.php"); 
}
$cliente = $_SESSION['cliente'];
echo "<h2>Estas son actualmente tus compras ".$cliente['nombre'].":</h2>";

//Select para listar los pedidos del cliente
$cadSql="SELECT num_pedido, fecha, total_pedido
FROM pedido
WHERE DNI = '".$cliente['DNI']."'";
$conexion= new mysqli("localhost", "root", "", "oficina");
$conexion->query("SET NAMES utf8");
$resultado=$conexion->query($cadSql);
while($fila = $resultado->fetch_assoc()){
	echo "<ul><li>Código: ".$fila['num_pedido'].", Fecha: ".$fila['fecha'].", Total pedido: ".$fila['total_pedido']."€, Productos:</li><ul>";
	//Select para listar los productos por pedido
	$c = "	SELECT pr.nombre AS n, pr.PVP AS p, l.cantidad AS c
			FROM producto pr INNER JOIN linea_pedido l ON pr.cod = l.producto
			INNER JOIN pedido p ON p.num_pedido = l.num_pedido
			WHERE p.num_pedido = '".$fila['num_pedido']."'";
	$r=$conexion->query($c);
	while($f = $r->fetch_assoc()){
		echo "<li>".$f['n']." - ".$f['p']."€ - x".$f['c']."</li>";
	}
	echo "</ul></ul><br>";
}

echo 	'<form action="logoffFromCompra.php">
  			<input type="submit" value="Atrás" >
		</form>';
?>
</body>
</html>