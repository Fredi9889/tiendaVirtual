<?php

class CestaCompra {
    protected $productos = array();
    
    // Introduce un nuevo artículo en la cesta de la compra
    public function nuevo_articulo($codigo) {
    	$cadSql="SELECT *
		FROM producto
		where cod ='$codigo'";
		$conexion= new mysqli("localhost", "root", "", "oficina");
		$conexion->query("SET NAMES utf8");
		$resultado=$conexion->query($cadSql);
		$articulo =$resultado->fetch_assoc();
		$this->productos[]=$articulo;
       	
    }
    // Obtiene los artículos en la cesta
    public function get_productos() {
    	asort($this->productos);
     	return $this->productos; 
 	}

 	// Contar las veces que se repite el mismo producto
 	public function get_nProductosIguales($codProducto) {
 			$nProductosIguales=0;
 		foreach ($this->productos as $valor){
  			foreach ($valor as $indice => $value) {
    			if($indice == 'cod'){
    				if($value == $codProducto){
    					$nProductosIguales++;
    				}
    			}
		  	}
		}
		return $nProductosIguales;
 	}
    
    // Obtiene el coste total de los artículos en la cesta
    public function get_coste() {
	$coste=0;
	foreach ($this->productos as $valor)
	{
		$coste+=$valor->getPVP();
		
	}
     return $coste;  
    }
    
    // Devuelve true si la cesta está vacía
    public function vacia() {
	if (count($this->productos)==0)
		return true;
	else
		return false;
       
    }
    
    // Guarda la cesta de la compra en la sesión del usuario
    public function guarda_cesta() { 
	$_SESSION["cesta"]=$this;
	}
    
    // Recupera la cesta de la compra almacenada en la sesión del usuario
    public static function carga_cesta() {
	if (!isset($_SESSION["cesta"]))
		return new CestaCompra();
	else
		return $_SESSION["cesta"];
        
    }
    // Eliminar producto
    public function eliminarProducto($indiceAEliminar) { 
		foreach ($this->productos as $indice => $valor) {
			if($indiceAEliminar == $indice){
				unset($this->productos[$indiceAEliminar]);
			}
		}
	}
}

?>
