<?php
    define("KEY_TOKEN", "Dross140600.");
    define("MONEDA", "$");

    session_start();

    $num_cart = 0;
    if(isset($_SESSION['carrito']['articulos'])){
        $num_cart = count($_SESSION['carrito']['articulos']);
    }
?>