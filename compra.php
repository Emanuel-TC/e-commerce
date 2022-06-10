<?php

require 'config/config.php';
require 'config/database.php';
$db = new DataBase();
$con = $db->conectar();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="index.php" class="navbar-brand">

                    <strong>E-shop</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    </ul>

                    <a href="checkout.php" class="btn btn-primary">
                        Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart?></span>
                    </a>
                </div>

            </div>
        </div>
    </header>
    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Compra artículo</h1>
                    <p>
                        <a href="index.php" class="btn btn-secondary my-2">Inicio</a>
                        <a href="registra.php" class="btn btn-primary my-2">Captura de artículo</a>
                    </p>
                    <form class="d-flex" method="get">
                        <input class="form-control me-2" type="search" placeholder="Descripción del artículo" aria-label="Search" name="CajaBusqueda" id="CajaBusqueda">
                        <button class="btn btn-outline-success" type="submit" name="Buscar">Buscar</button>
                    </form>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <?php

                //código boton de busqueda//
                if (isset($_GET['Buscar'])) {
                    $CajaBusqueda = $_GET['CajaBusqueda'];

                    //Código resultado de búsqueda
                    $sql = $con->prepare("SELECT * FROM articulos where descripcion LIKE '%$CajaBusqueda%'");
                    $sql->execute();
                    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    //codigo muestra todos los productos
                    $sql = $con->prepare("SELECT * FROM articulos");
                    $sql->execute();
                    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
                // vamos a ver quéso
                foreach ($resultado as $row) { ?>
                    <div class="col">
                        <div class="card shadow-sm">

                            <?php

                            $idArticulo = $row['idArticulo'];
                            $imagen = $row['foto'];
                            $precio = $row['precio'];
                            $descripcion = $row['descripcion'];
                            $disponibles = $row['cantidadEnAlmacen'];



                            ?>
                            <img src="data:image;base64, <?php echo $imagen = base64_encode($imagen) ?>">
                            <div class="card-body">
                                <!--h5 class="card-title" name="idArticulo"><?php //echo $idA; 
                                                                            ?></h5-->
                                <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                <p class="card-text">
                                    <?php echo $descripcion; ?>
                                </p>

                                <p class="card-text">
                                    Precio: <?php echo MONEDA . number_format($precio, 2, '.', ','); ?> MXN
                                </p>
                                <div class="d-flex justify-content-between align-items-center">


                                    <div class="form-floating mb-3">
                                        
                                    </div>
                                    <div class="btn-group">
                                        <a href="detalles.php?id=<?php
                                        echo $idArticulo; ?>&token=<?php echo
                                        hash_hmac('sha1', $idArticulo, KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                                    </div>
                                    <button name="Agregar" onclick="addProducto(<?php echo $idArticulo;?>,
                                    '<?php echo hash_hmac('sha1', $idArticulo, KEY_TOKEN); ?>')"
                                     class="btn btn-success">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
        <!--container  -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
       
        function addProducto(idArticulo,token){
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('idArticulo',idArticulo)
            formData.append('token',token)
           //formData.append('cantidad',cantidad);

            fetch(url,{
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })

        }
    </script>

</body>

</html>