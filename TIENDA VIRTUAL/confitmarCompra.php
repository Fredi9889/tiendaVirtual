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
require_once("cestaCompra.php");
session_start();

//Si la variable sesión está vacía
if (!isset($_SESSION['cliente'])) {
   	/* nos envía a la siguiente dirección en el caso de no poseer autorización */
   	header("Location:index.php"); 
}
$cliente = $_SESSION['cliente'];

$cesta=CestaCompra::carga_cesta();
if ($cesta->vacia()){
	die ("<a href=vistaCliente.php>Cesta vacía</a>");
}

$clienteDNI = $cliente['DNI'];
$totalCesta = $_POST['totalCesta'];
$codPedido = "";

//Insert para guardar pedido
$cadInsertP="INSERT INTO pedido (num_pedido, DNI, fecha, total_pedido)
VALUES (NULL, '".$clienteDNI."', NOW(), '".$totalCesta."')";
$conexion= new mysqli("localhost", "root", "", "oficina");
$conexion->query("SET NAMES utf8");
if($conexion->query($cadInsertP)){
	//Insertamos en la variable 'codPedido' el id del último pedido añadido
	$maxId="SELECT max(num_pedido) as maxP
			FROM pedido
			WHERE num_pedido IS NOT NULL";
	$resultado=$conexion->query($maxId);
	$x = $resultado->fetch_assoc();
	$codPedido = $x['maxP'];
}

//Coger las variables del producto
$codProducto = 0;
$precioProducto = 1;

$productosCesta=$cesta->get_productos();
foreach ($productosCesta as $valor){
	$aux=0;
  foreach ($valor as $indice => $value) {
  	
	    if($indice == 'cod'){
	    	if($value == $codProducto){
	    		$aux=1;
	    	}else{
	    		$codProducto = $value;
	    	}
	    }
	    if($indice == 'PVP'){
	      $precioProducto = $value * $cesta->get_nProductosIguales($codProducto) ;
	    }
	
  }
      //Insert para guardar línea de pedido
  	if($aux == 0){
		$cadInsertLP="INSERT INTO linea_pedido (num_pedido, num_linea, producto, cantidad, precio)
		VALUES ('".$codPedido."', NULL, '".$codProducto."', '".$cesta->get_nProductosIguales($codProducto)."', '".$precioProducto."')";
		$conexion->query($cadInsertLP);
	}
}


	echo "<h2>Compra realizada</h2>";
	echo "<ul>";
		foreach ($productosCesta as $puntero =>$valor){
		  foreach ($valor as $indice => $value) {
		  	if($indice == 'descripcion'){
		  		$descripcion = $value;
		  	}
		    if($indice == 'nombre'){
		      $nombre = $value;
		    }
		    if($indice == 'PVP'){
		    	$PVP = $value;
		    }
		  }
		  echo 	"
		      		<li>".$nombre." -- ".$descripcion." -- ".$PVP."€</li>
		      	";
		}
	echo "</ul>";
	
	echo "<p>Total a pagar: ".$totalCesta ."€";

echo 	'<form action="logoffFromCompra.php">
  			<input type="submit" value="Seguir comprando" >
	  	</form><br>';
echo 	'<form action="logoff.php">
  			<input type="submit" value="Cerrar sesión" >
	  	</form>';

?>
</body>
</html>