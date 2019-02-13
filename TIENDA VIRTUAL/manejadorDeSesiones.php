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
 
//Recibimos las dos variables
$usuario=$_POST["usuario"];
$pass=$_POST["password"];
$conexion= new mysqli("localhost", "root", "", "oficina");
$conexion->query("SET NAMES utf8");
/* Comprobamos si el usuario existe en la tabla clientes */
$cadSql="SELECT * FROM cliente WHERE nombre = '$usuario' AND password = '$pass'";
$datos = $conexion->query($cadSql);
$fila = $datos->fetch_assoc();
//$nombre = $fila['nombre'];
$tipoUsuario = $fila['usuario'];
//$password = $fila['password'];
if($tipoUsuario == "admin"){
   $_SESSION['administrador']=$fila;
    header("Location: vistaAdministrador.php");
    exit();
}elseif($tipoUsuario == "cliente") {
    $_SESSION['cliente']=$fila;
    header("Location: vistaCliente.php");
    exit(); 
}

/* Si no encuentra el usuario */
$_SESSION['reTry']="<tr><td colspan='3'>Login incorrecto</td></tr><tr><td colspan='3'>Inténtelo de nuevo o regístrese si no lo está</td></tr>";
header("Location: index.php");
   

?>
</body>
</html>