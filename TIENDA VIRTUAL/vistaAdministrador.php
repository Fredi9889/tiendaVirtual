<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html> 
<head> 
<title>TIENDA VIRTUAL</title>

<style type="text/css">
	#divTabla {
	    float: left;
	    position: relative;
    }
    div{

  	}
  	.x{
  		position: relative;
  		left: 50px;
  	}
	#pedidosClientes{
		position: absolute;
		top: 135px;
  		left: 950px;
	}
</style>
</head> 
<body> 
<?php
session_start();
//Si la variable sesión está vacía
if (!isset($_SESSION['administrador'])) {
   	/* nos envía a la siguiente dirección en el caso de no poseer autorización */
   	header("Location:index.php");
}
$administrador = $_SESSION['administrador'];
echo "<h2>Usuario administrador: ".$administrador['nombre']."</h2>";
// Si pulsamos el botón cargar foto
if(isset($_POST['enviar'])){
	if($foto = $_POST['foto']){
		$destino = "img/".$foto;

		$nImagen="UPDATE producto SET imagen='".$destino."' WHERE cod='".$_POST['cod']."'";
		$conexion= new mysqli("localhost", "root", "", "oficina");
		$conexion->query("SET NAMES utf8");
		$conexion->query($nImagen);
	}else{
		header("Location:vistaAdministrador.php");
	}
}
//Si se pulsa el botón de consultar pedidos del cliente por DNI
if(isset($_POST['consultar'])){
	$dni = $_POST['dni'];
	echo "<div id='pedidosClientes'>";
	//Select para comprobar que exista el DNI introducido por el administrador
	$select="SELECT * FROM cliente WHERE DNI ='".$dni."'";
	$conexion= new mysqli("localhost", "root", "", "oficina");
	$conexion->query("SET NAMES utf8");
	$re = $conexion->query($select);
	if($re->fetch_assoc() == 0){
		echo "<h4>ERROR, no existe ningún cliente con DNI ".$dni."</h4>";
	}else{
	//Select para listar los pedidos del cliente
	$cadSql="SELECT num_pedido, fecha, total_pedido
	FROM pedido
	WHERE DNI = '".$dni."'";
	$resultado=$conexion->query($cadSql);
			echo "<h4>Estos son los pedidos realizados por el cliente con DNI  ".$dni.":</h4>";
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
		
	}
	echo "</div>";
}



// Listado de los productos
$cadSql="SELECT *
FROM producto
order by familia, PVP";
$conexion= new mysqli("localhost", "root", "", "oficina");
$conexion->query("SET NAMES utf8");
$resultado=$conexion->query($cadSql);
echo "<div id='divTabla'><table border=1>"; 
echo "<tr><th colspan=7 align='center'>Listado de productos</th></tr>";
echo "<tr><th>Nombre</th><th>Descripcion</th><th>PVP</th><th>Familia</th><th>Stock</th><th>Nueva imagen</th><th>Pulse para actualizarla</th></tr>";

while ($fila = $resultado->fetch_assoc())
{
	echo "<tr><td class='iz'>".$fila['nombre']."</td><td class='iz'>".$fila['descripcion']."</td><td class='cen'>".$fila['PVP']." €</td><td class='cen'>".$fila['familia']."</td><td class='cen'>".$fila['stock']."</td>
		<td>
		<form action='vistaAdministrador.php' method='post'>
		<input type='file' name ='foto' aria-describedby ='fileHelp'/>
		<input type='hidden' name ='cod' value='".$fila['cod']."'/>
		</td><td><input style=\"background-image: url(".$fila['imagen']."); width: 200px; height: 200px; border-width: 0; outline: none;\" type='submit' name='enviar' value=''></td></form></tr>";
}
echo 	'</table><br><form action="logoff.php" method="post">    
   			<input type="submit" value="Volver al login" >
		</form></div>';
//Pedidos por clientes
echo '<div class="x"><h4>Ver las compras de los clientes</h4><form action="vistaAdministrador.php" method="post"><label>Cliente: </label><input type="text" name="dni" placeholder="DNI del cliente" value=""/><input type="submit" name="consultar" value="Consultar"/></form></div>'

?>
</body>
</html>