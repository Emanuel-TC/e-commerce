<?php
    require '../config/config.php';
    require '../config/database.php';
    
    if(isset($_POST['action'])){
        $action = $_POST['action'];
        $idArticulo = isset($_POST['idArticulo']) ? $_POST['idArticulo'] : 0;

        if($action=='agregar'){
            $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
            $respuesta = agregar($idArticulo,$cantidad);
            if($respuesta>0){
                $datos['ok']=true;
            }else{
                $datos['ok']=false;
            }
            $datos['sub'] = MONEDA . number_format($respuesta,2,'.',',');
        }else if($action == 'eliminar'){
                $datos['ok']=eliminar($idArticulo);
        } else{
            $datos['ok']=false;
        }
    }else{
        $datos['ok']=false;
    }

    echo json_encode($datos);


    function agregar($idArticulo,$cantidad){
        $res = 0;
        if($idArticulo >0 && $cantidad>0 && is_numeric(($cantidad))){
            if(isset($_SESSION['carrito']['articulos'][$idArticulo])){
                $_SESSION['carrito']['articulos'][$idArticulo] = $cantidad;

                $db = new DataBase();
                $con = $db->conectar();

            $sql = $con->prepare("SELECT precio FROM articulos where idArticulo=? AND cantidadEnAlmacen >=1");
            $sql->execute([$idArticulo]);
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $row)
           
            $precio = $row['precio'];
            
            $res = $cantidad * $precio;
            return $res;
            }
        }else{
            return $res;
        }
    }

    function eliminar($idArticulo){
        if($idArticulo >0){
            if(isset($_SESSION['carrito']['articulos'][$idArticulo])){
                unset($_SESSION['carrito']['articulos'][$idArticulo]);
                return true;
            }
        }else{
            return false;
        }
    }
?>