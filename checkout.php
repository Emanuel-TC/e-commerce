<?php

require 'config/config.php';
require 'config/database.php';
$db = new DataBase();
$con = $db->conectar();

$articulos = isset($_SESSION['carrito']['articulos']) ? $_SESSION['carrito']['articulos'] : null;

//print_r($_SESSION);
$lista_carrito = array();

if ($articulos != null) {
    foreach ($articulos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT idArticulo, nombre, foto, precio, descripcion, $cantidad as cantidad FROM articulos where idArticulo=? AND cantidadEnAlmacen >=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
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
                    <a href="checkout.php" class="btn btn-primary">
                        Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart ?></span>
                    </a>
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

        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Foto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($lista_carrito == null) {
                            echo '<tr><td colspan="6" class="text-center"><b>Lista vacia</b></td></tr>';
                        } else {
                            $total = 0;
                            foreach ($lista_carrito as $articulo) {
                                $idArticulo = $articulo['idArticulo'];
                                $nombre = $articulo['nombre'];
                                $imagen = $articulo['foto'];
                                $precio = $articulo['precio'];
                                $cantidad = $articulo['cantidad'];
                                $descripcion = $articulo['descripcion'];
                                $subtotal = $precio * $cantidad;
                                $total += $subtotal;

                        ?>
                                <tr>
                                    <td><?php echo $nombre; ?></td>
                                    <td><img width="50" height="80" src="data:image;base64, <?php echo $imagen = base64_encode($imagen) ?>"></td>
                                    <td>Precio: <?php echo MONEDA . number_format($precio, 2, '.', ','); ?> MXN</td>
                                    <td>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control rounded-3" id="cantidad_<?php echo $idArticulo; ?>" placeholder="cantidad" name="cantidad" min="1" max="99999" maxlength="5" value="<?php echo $cantidad; ?>" size="3" onchange="actualizaCantidad(this.value,<?php echo $idArticulo; ?>)">
                                            <label for="floatingPassword">Cantidad </label>

                                        </div>
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $idArticulo; ?>" name="subtotal[]">
                                            <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?> MXN
                                        </div>
                                    </td>
                                    <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $idArticulo; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">
                                            Eliminar
                                        </a></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="4"></td>
                                <td colspan="2">
                                    <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                </td>
                            </tr>
                    </tbody>
                <?php } ?>
                </table>

            </div>

        </div>

    </main>

    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminaModalLabel">Alerta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto de la lista?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn-eliminar" type="button" class="btn btn-danger" onclick="elimina">Eliminar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('')

        function actualizaCantidad(cantidad, idArticulo) {
            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('idArticulo', idArticulo)
            formData.append('action', 'agregar')
            formData.append('cantidad', cantidad);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let divsubtotal = document.getElementById('subtotal_' + idArticulo)
                        divsubtotal.innerHTML = data.sub

                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')

                        for (i = 0; i < list.length; i++) {
                            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                        }
                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2

                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php MONEDA;  ?>' + total
                    }
                })

        }
    </script>

</body>

</html>