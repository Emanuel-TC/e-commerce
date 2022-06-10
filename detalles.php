<?php

require 'config/config.php';
require 'config/database.php';

$db = new DataBase();
$con = $db->conectar();

$idArticulo = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($idArticulo == '' || $token == '') {
    echo "Error al procesar la peticion";
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $idArticulo, $token);
    if ($token_tmp == $token_tmp) {
        $sql = $con->prepare("SELECT count(idArticulo) FROM articulos where idArticulo=? AND cantidadEnAlmacen >=1");
        $sql->execute([$idArticulo]);
        if ($sql->fetchColumn() > 0) {

            $sql = $con->prepare("SELECT idArticulo, nombre, foto, precio, descripcion, cantidadEnAlmacen FROM articulos where idArticulo=? AND cantidadEnAlmacen >=1");
            $sql->execute([$idArticulo]);
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado as $row)
            $idArticulo = $row['idArticulo'];
            $nombre = $row['nombre'];
            $imagen = $row['foto'];
            $precio = $row['precio'];
            $descripcion = $row['descripcion'];
            $disponibles = $row['cantidadEnAlmacen'];
        }
    } else {
        echo "Error al procesar la peticion";
        exit;
    }
}

//codigo muestra todos los productos


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
                    <h1 class="fw-light">Detalles </h1>
                    <p>
                        <a href="index.php" class="btn btn-secondary my-2">Inicio</a>
                        <a href="compra.php" class="btn btn-primary my-2">Seguir comprando</a>
                    </p>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong class="d-inline-block mb-2 text-primary">Producto con id: <?php echo $idArticulo; ?></strong>
                            <h3 class="mb-0"><?php echo $row['nombre']; ?></h3>
                            <div class="mb-1 text-muted">Precio: <?php echo MONEDA . number_format($precio, 2, '.', ','); ?> MXN</div>
                            <p class="card-text mb-auto lead"><?php echo $descripcion; ?></p>
                            <p class="card-text mb-auto lead">Disponibles:  <?php echo $disponibles; ?></p>

                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <img width="200" height="250" src="data:image;base64, <?php echo $imagen = base64_encode($imagen) ?>" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                        </div>
                        <div class="d-grid gap-3 col-10 mx-auto">
                        <form method="get">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control rounded-3" id="cantidad" placeholder="cantidad" name="cantidad" min="1" max="99999" maxlength="5" value="1">
                                <label for="floatingPassword">Cantidad </label>
                                
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-outline-primary" type="button" name="Agregar" onclick="addProducto(<?php echo $idArticulo;?>,'<?php echo $token_tmp;?>')">Agregar a carrito</a>
                            </div>
                        </form>
                        </div>

                    </div>
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