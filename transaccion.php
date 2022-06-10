<?php

require 'config/database.php';
        $db = new DataBase();
        $con = $db->conectar();

        //$id = $_GET[""];
        //$cantidad = $_POST["cantidad"];

        if(isset($_GET['Agregar'])){
                $Cantidad = $_GET['cantidad'];

                $ObtenerIdSQL = $con->prepare("SELECT idArticulo from articulos");
                $ObtenerIdSQL->execute();
                        if($ObtenerIdSQL){
                        $CantidadEnAlmacen = $con->prepare("SELECT cantidadEnAlmacen from articulos");
                        $CantidadEnAlmacen->execute();
                        
                                if($CantidadEnAlmacen >= $Cantidad){
                                        echo "<script>alert('Se agregaron correctamente');
                                        window.location='compra.php'
                                     </script>";
                                     /*$InsertaEnCarritoId = $con->prepare("INSERT INTO carrito_compra(idArticulo) 
                                     VALUES ('$id')"); */

                        
                                        }
                                else{
                                        echo "La cantidad: " . $Cantidad. " supera las existencias";
                                }
                                }
        }

?>