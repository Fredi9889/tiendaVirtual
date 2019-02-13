<?php
require_once("cestaCompra.php");
session_start();
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
    	margin: auto;
    	margin-top: 100px;
      float: left;
    }
    .iz{
    	text-align: left;
    }
    .cen{
    	text-align: center;
    }
    #cesta{
      margin: 0 auto;
      margin-left: 100px;
      margin-top:-18px;
      float: left;
      position:relative;
      
    }
    #div{
      float:left;
      position: relative;
      margin-top: 80px;
      margin-left: 90px;
      
    }
    #listadoP{
      float:left;
      
    }
    #general{
      margin-left: 440px;
    }
</style>
</head> 

<body> ';


//Si la variable sesión está vacía
if (!isset($_SESSION['cliente'])){
   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
   header("Location:index.php"); 
}
$cliente = $_SESSION['cliente'];
echo "<h1>Bienvenido sea ".$cliente['nombre']."</h1>";
//Recuperamos la cesta de la compra
$cesta=CestaCompra::carga_cesta();
// Comprobamos si se ha pulsado el botón de vaciar  cesta
if (isset($_POST["vaciar"])){
  unset($_SESSION["cesta"]);
  $cesta=new CestaCompra();
}
// Comprobamos si se quiere añadir un producto a la cesta
if (isset($_POST["enviar"])){
  $cesta->nuevo_articulo($_POST["cod"]);
  $cesta->guarda_cesta();
}
if(isset($_POST["eliminarP"])){
  $cesta->eliminarProducto($_POST['puntero']);
  $cesta->guarda_cesta();
}
//Select para listar los productos
$cadSql="SELECT *
FROM producto
where stock > 0
order by familia, PVP";
$conexion= new mysqli("localhost", "root", "", "oficina");
$conexion->query("SET NAMES utf8");
$resultado=$conexion->query($cadSql);
//Listado de los productos
echo "<div id='general'><div id='listadoP'><table border=1>";
echo "<tr><th colspan=5 align='center'>LISTADO DE PRODUCTOS DISPONIBLES</th></tr>";
echo "<tr><th>Nombre</th><th>Descripcion</th><th>PVP</th><th>Familia</th><th>Añadir a la cesta</th></tr>";

while ($fila = $resultado->fetch_assoc())
{
echo "<form action='vistaCliente.php' method='post'>";
echo "<tr><td class='iz'>".$fila['nombre']."</td><td class='iz'>".$fila['descripcion']."</td><td class='cen'>".$fila['PVP']." €</td><td class='cen'>".$fila['familia']."</td><td class='cen'>

<input style=\"background-image: url(".$fila['imagen']."); width: 200px; height: 200px; border-width: 0; outline: none;\" type='submit' name='enviar' value=''></td></tr>";


echo "<input type='hidden' name='cod' value=".$fila['cod']."></form>";
}
echo '</table>
<form  align="center" action="logoff.php">
  <input type="submit" value="Cerrar sesion" >
</form>
</div>
<br>
<div id="cesta" style="text-align:center">';
echo'
<table border=1>
<tr><th colspan="2">CESTA</th></tr>
<tr><th>Artículo</th><th>Eliminar</th></tr>
';
// Cesta de la compra
$productosCesta=$cesta->get_productos();
$totalCesta = 0;
foreach ($productosCesta as $puntero =>$valor){
  foreach ($valor as $indice => $value) {
    if($indice == 'nombre'){
      echo "<tr><td>".$value."</td><td class='cen'><form action='vistaCliente.php' method='post'><input type='submit' name='eliminarP' value='X'><input type='hidden' name='puntero' value='".$puntero."'/></form></td></tr>";
    }
    if($indice == 'PVP'){
      $totalCesta+=$value;
    }
  }
}
$mostrar=($cesta->vacia())?'disabled="true"':'';
echo "
</table>
<form action='confitmarCompra.php' method='post'><input type='submit' name='enviar' value='Confirmar compra'".$mostrar."/>
<input type='hidden' name='totalCesta' value='".$totalCesta."'/>
</form>
</div>
<div id='div'>
<form action='verMisDatosYModificar.php' method='post'><input type='submit' name='verDatos' value='Ver mis datos'>
</form><br>
<form action='verComprasYPedidos.php'><input type='submit' name='verCompras' value='Ver mis compras y pedidos'>
</form>
</div>
</div>
";

?>