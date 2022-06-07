<?php

require 'config/database.php';
    $db = new DataBase();
    $con = $db->conectar();


    $nombre = $_POST["nombre"];
                            $descripcion = $_POST["descripcion"];
                            $precio = $_POST["precio"];
                            $cantidadEnAlmacen = $_POST["cantidadEnAlmacen"];

                            if($_FILES["foto"]){
                                $nombre_base = basename($_FILES["foto"]["name"]);
                                $nombre_final = date("d-m-y"). "-". date("H-i-s")."-" . $nombre_base;
                                $ruta = "images/" . $nombre_final;
                                $subirFoto = move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta);

                                if($subirFoto){
                                    $insertarSQL = $con->prepare("INSERT INTO articulos(nombre, descripcion, precio,
                                     cantidadEnAlmacen, foto) 
                                     VALUES ('$nombre','$descripcion','$precio','$cantidadEnAlmacen','$ruta')");
                                    
                                    $insertarSQL->execute();
                                     //$resultado =   mysqli_query($con, $insertarSQL);

                                     if($insertarSQL){
                                         echo "<script>alert('Se capturó correctamente'); window.location='registra.php'
                                         </script>"; 
                                     }
                                     else{
                                         printf("Error: ");
                                     }
                                }
                            }


?>