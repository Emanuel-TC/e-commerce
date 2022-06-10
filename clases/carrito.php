<?php
    require '../config/config.php';
    require '../config/database.php';
    $db = new DataBase();
    $con = $db->conectar();

    if(isset($_POST['idArticulo'])){
        $idArticulo = $_POST['idArticulo'];
        //$cantidad = $_POST['cantidad'];
        $token = $_POST['token'];

        $token_tmp = hash_hmac('sha1', $idArticulo, $token);
        if ($token_tmp == $token_tmp){

            if(isset($_SESSION['carrito']['articulos'][$idArticulo])){
                
                $_SESSION['carrito']['articulos'][$idArticulo] += 1; //$cantidad

            }else{

                $_SESSION['carrito']['articulos'][$idArticulo] =1;
            }
            $datos['numero'] = count($_SESSION['carrito']['articulos']);
            $datos['ok'] = true;

        }else{
            $datos['ok'] = false;
        }

    }else{
        $datos['ok'] = false;
        echo "Error";
    }

    echo json_encode($datos);
?>