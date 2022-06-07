<?php

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

                    <a href="checkout.php" class="btn btn-primary">Carrito</a>
                </div>

            </div>
        </div>
    </header>




    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Captura de artículo</h1>

                    <p>
                        <a href="index.php" class="btn btn-secondary my-2">Inicio</a>
                        <a href="compra.php" class="btn btn-primary my-2">Compra de artículo</a>
                    </p>
                </div>
            </div>
        </section>

        <!--Codigo captura articulo -->
        <div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <!-- <h5 class="modal-title">Modal title</h5> -->
                        <h2 class="fw-bold mb-0">Ingresa los datos</h2>
                    </div>

                    <div class="modal-body p-5 pt-0">
                        <form class="" action="insertar.php" method="post" enctype="multipart/form-data">
                            <!--Campo nombre -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Nombre" name="nombre" maxlength="30" required>
                                <label for="floatingInput">Nombre artículo</label>
                            </div>
                            <!--Campo descripcion -->
                            <div class="form-floating mb-3">
                                <textarea type="text" class="form-control rounded-3" id="floatingPassword" placeholder="Descripcion" name="descripcion" maxlength="200" required>
                                </textarea>
                                <label for="floatingPassword">Descripción</label>
                            </div>
                            <!--Campo precio -->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control rounded-3" id="floatingPassword" placeholder="Precio" name="precio" required min="1" max="9999999999" maxlength="12">
                                <label for="floatingPassword">Precio</label>
                            </div>
                            <!--Campo Cantidad en almacen -->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control rounded-3" id="floatingPassword" placeholder="Cantidad" name="cantidadEnAlmacen" required min="1" max="99999" maxlength="5">
                                <label for="floatingPassword">Cantidad</label>
                            </div>
                            <!--Campo foto -->
                            <div class="form-floating mb-3">
                                <input type="file" class="form-control rounded-3" id="floatingPassword" placeholder="Precio" name="foto" required>
                                <label for="floatingPassword">Seleccionar foto</label>
                            </div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="Capturar">Capturar</button>
                            <small class="text-muted">Es importante que llenes todos los campos o no se registrara el articulo</small>
                        

                        </form>
                    </div>
                </div>
            </div>
        </div>


    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>