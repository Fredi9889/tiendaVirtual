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
	echo "<h2 align='center'>Registro de cliente</h2>";
	echo "<form action='registroCliente.php' method='post'>";
	echo "<table style='margin: 0 auto;'>";
	echo "<tr><td>DNI:				</td><td>	<input type='text' name='dni' 			/></td></tr>";
	echo "<tr><td>Nombre:			</td><td>	<input type='text' name='nombre' 	 	/></td></tr>";
	echo "<tr><td>Dirección:		</td><td>	<input type='text' name='direccion' 	/></td></tr>";
	echo "<tr><td>Tipo de usuario:	</td><td>	<input type='text' name='tUsuario' 		value='cliente' disabled='true'/></td></tr>";
	echo "<tr><td>Contraseña:		</td><td>	<input type='password' name='contra' 	/></td></tr>";
	echo "<tr><td>Repetir contraseña:		</td><td>	<input type='password' name='contra1' 	/></td></tr>";
	echo "<tr><td align='center'><input type='submit' name='enviar' value='Enviar'></td><td align='center'>
		</form><form action='index.php'>
		<input type='submit' value='Cancelar' />
		</form>
	</td></tr>";
	echo "</table>";
	if(isset($_POST['enviar'])){
		if($_POST['dni'] == "" || $_POST['nombre'] == "" || $_POST['direccion'] == "" || $_POST['contra'] == "" || $_POST['contra1'] == ""){
			echo "<p align='center'>Ha rellenado mal algún campo, revise el formulario<p>";
		}elseif($_POST['contra'] != $_POST['contra1']){
		echo "<p align='center'>La contraseña no coincide, compruébelo<p>";
		}else{
			$insert = "INSERT INTO cliente (DNI, nombre, direccion, usuario, password) VALUES ('".$_POST['dni']."', '".$_POST['nombre']."', '".$_POST['direccion']."', 'cliente', '".$_POST['contra']."')";
			$conexion= new mysqli("localhost", "root", "", "oficina");
			$conexion->query("SET NAMES utf8");
			if($conexion->query($insert)){
				echo "<p align='center'>Usuario registrado correctamente</h2>";
				echo 	'<form align="center" action="index.php">
  							<input type="submit" value="Inicio" >
						</form>';
			}
		}
	}

?>