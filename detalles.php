<?php

require 'config/config.php';
require 'config/database.php';
$db = new DataBase();
$con = $db->conectar();
if(isset($_GET['Agregar'])){
$id = isset($_GET['idArticulo']) ? $_GET['idArticulo']: '';
$token = isset($_GET['token']) ? $_GET['token']: '';
    if($id =='' || $token==''){
        echo "Error al procesar la peticion";
        exit;
    }else{
        $token_tmp = hash_hmac('sha1',$id,$token);
    }
}

//codigo muestra todos los productos
$sql = $con->prepare("SELECT * FROM articulos where cantidadEnAlmacen >=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

// vamos a ver quéso
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>E-shop</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
                            Carrito <span id="num_cart" class="badge bg-secondary"></span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <section class="py-5 text-center container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <h1 class="fw-light">Detalles </h1>
                        <p>
                            <a href="index.php" class="btn btn-secondary my-2">Inicio</a>
                            <a href="compra.php" class="btn btn-primary my-2">Seguir comprando</a>
                        </p>
                    </div>
                </div>
            </section>
            <div class="container">

            </div>
            <!--container  -->
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    </body>

    </html>