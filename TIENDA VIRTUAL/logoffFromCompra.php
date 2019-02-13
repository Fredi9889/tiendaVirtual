<?php
require_once("cestaCompra.php");
    /* Recuperamos la información de la sesión*/
    session_start();
    $_SESSION['cesta'] = new CestaCompra();
    header("Location: vistaCliente.php");
?>