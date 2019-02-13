<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html> 
<head> 
<title>TIENDA VIRTUAL</title> 
<style type="text/css">
	table {
    margin: 0 auto;
    margin-top: 200px;
	}
 
</style>

</head> 

<body>
	<table>
			<tr>
				<th colspan="3" align="center">
				   	Login
				</th>
			</tr>
		<form  action="manejadorDeSesiones.php" method="post">
			<tr>
				<td colspan="3">
			   		<input name="usuario" type="text" placeholder="Usuario" size="35"/>
			   	</td>
			</tr>
			<tr>
				<td colspan="3">
			   		<input name="password"  type="password" placeholder="Contraseña" size="35"/>
				</td>
			</tr>
			<tr >
				<td>
			   		<input type="submit" name="enviar" value="Acceder" class="enviar">
			   		</form>
				</td>
				<td>
				   	<form  action="registroCliente.php">
				   		<input type="submit" value="Registrarse" class="enviar">
				   	</form>
				</td>
				<td>
				   	<form  action="listadoProductos.php">
				   		<input type="submit" value="Ver productos" class="enviar">
				   	</form>
				</td>
			</tr>
	<?php
	//Si se pulsó el botón acceder y la variable sesión está vacía
	if(isset($_SESSION['reTry'])){
		echo $_SESSION['reTry'];
		session_destroy();
	}
	
	?>
	</table>

</body> 
</html>