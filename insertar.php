<?php

require 'config/database.php';
    $db = new DataBase();
    $con = $db->conectar();


    $nombre = $_POST["nombre"];
                            $descripcion = $_POST["descripcion"];
                            $precio = $_POST["precio"];
                            $cantidadEnAlmacen = $_POST["cantidadEnAlmacen"];

                            $revisar = getimagesize($_FILES["foto"]["tmp_name"]);
                            if($revisar !== false){
                                $foto = $_FILES['foto']['tmp_name'];
                                $fotoContenido = addslashes(file_get_contents($foto));

                                    $insertarSQL = $con->prepare("INSERT INTO articulos(nombre, descripcion, precio,
                                     cantidadEnAlmacen, foto) 
                                     VALUES ('$nombre','$descripcion','$precio','$cantidadEnAlmacen','$fotoContenido')");
                                    
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
?>