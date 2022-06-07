<?php

require 'config/config.php';
require 'config/database.php';
    $db = new DataBase();
    $con = $db->conectar();
    $id = $row['idArticulo'];

    if(isset($_POST['id'])){

        $id = $_POST['id'];

        if(isset($_SESSION['checkout']['productos'][$id])){
            $_SESSION['checkout']['productos'][$id] =+1;
        }
        else{
        $_SESSION['checkout']['productos'][$id] =1;
        }
        
        $datos['numero']= count($_SESSION['checkout']['productos']);


    }
    else{
        $datos['ok'] = false; 
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand">

                    <strong>E-shop</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    </ul>

                    <!--a href="carrito.php" class="btn btn-primary">Carrito</a-->
                </div>

            </div>
        </div>
    </header>




    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Carrito</h1>
                    <p class="lead text-muted">¿Encontraste todo lo que buscabas?
                         Recuerda, nuestro objetivo es hacerte feliz.
                    </p>
                    <p>
                        <a href="compra.php" class="btn btn-primary my-2">Compra de artículo</a>
                        <a href="registra.php" class="btn btn-secondary my-2">Captura de artículo</a>
                    </p>
                </div>
            </div>
        </section>

        
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>