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

if(!isset($_POST['enviar'])){
echo "<h2>Mis datos:</h2>";
echo "<form action='verMisDatosYModificar.php' method='post'>";
echo "<table>";
echo "<tr><td>DNI:				</td><td>	<input type='text' name='dni' 		value='".$cliente['DNI']."' /></td></tr>";
echo "<tr><td>Nombre:			</td><td>	<input type='text' name='nombre' 	value='".$cliente['nombre']."' /></td></tr>";
echo "<tr><td>Dirección:		</td><td>	<input type='text' name='direccion' value='".$cliente['direccion']."' /></td></tr>";
echo "<tr><td>Tipo de usuario:	</td><td>	<input type='text' name='tUsuario' 	value='".$cliente['usuario']."' disabled='true'/></td></tr>";
echo "<tr><td>Contraseña:		</td><td>	<input type='text' name='contra' 	value='".$cliente['password']."' /></td></tr>";
echo "<tr><td align='left'><input type='submit' name='enviar' value='Modificar datos'></form></td><td align='right'><form action='vistaCliente.php'><input type='submit' value='Volver'></form></td></tr>";
echo "<tr><td colspan='2' style='color:#FF0000;'>¡ATENCIÓN! Si modifica sus datos se borrarán <br> los registros de sus anteriores operaciones</td></tr>";
echo "</table>";
}else{
//Borrado previo de los nodos hijos del usuario para su posterior modificación
//Borrado de linea_pedido
$borradoLPedido="DELETE linea_pedido
from linea_pedido inner join pedido on linea_pedido.num_pedido = pedido.num_pedido
				  inner join cliente on cliente.DNI = pedido.DNI
where cliente.DNI='".$cliente['DNI']."'";
$conexion= new mysqli("localhost", "root", "", "oficina");
$conexion->query("SET NAMES utf8");
$conexion->query($borradoLPedido);
//Borrado pedido
$borradoPedido = "DELETE pedido from pedido inner join cliente on cliente.DNI = pedido.DNI where cliente.DNI='".$cliente['DNI']."'";
$conexion->query($borradoPedido);
//Actulizar los datos del usuario
$actualizarUsuario = "UPDATE cliente SET DNI = '".$_POST['dni']."', nombre = '".$_POST['nombre']."', direccion = '".$_POST['direccion']."', password = '".$_POST['contra']."' WHERE cliente.DNI = '".$cliente['DNI']."' AND cliente.usuario = '".$cliente['usuario']."'";
if($conexion->query($actualizarUsuario)){
	echo 	"<h2>Datos modificados correctamente</h2>
			<h3>Por favor, vuelva a loguearse con sus nuevas credenciales</h3>";
	echo 	'<form action="logoff.php">
  				<input type="submit" value="Volver" >
			</form>';
}else{
	echo "<h2>Lo sentimos, ha habido algún error en la modificación</h2>";
	echo 	'<form action="vistaCliente.php">
  				<input type="submit" value="Atrás" >
			</form>';
}
}

?>
</body>
</html>