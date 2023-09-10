<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MHenriquez paginación</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <?php
        require_once __DIR__."/config/variables-conexion.php";
        require_once __DIR__."/database/globals.php";
        require_once __DIR__."/database/articulos.php";

        $page                = 1;
        $totalArticlesByPage = 3;

        // Si se ha hecho paginación $page toma el valor de la página actual
        if(isset($_GET['page'])) {
            $page = intval($_GET['page']);
        }

        // Algoritmo para calcular la paginación
        $data = $select((($page - 1) * $totalArticlesByPage), $totalArticlesByPage);
        
        // Result con múltiples resultados
        $articulos = $data['result'];

        // Recursos para la paginación
        $totalArticles = $data['totalArticles'][0]['totalArticles'];
        $totalPages    = ceil($totalArticles / $totalArticlesByPage);

        // Validación de parámetros en la url
        if($page > $totalPages || $page < 1) {
            header("Location: index.php");
        }
    ?>
</head>
<body>
    <div class="container my-5">
        <header class="mb-5">
            <h1>MHenriquez paginación</h1>
        </header>

        <main>
            <?php foreach ($articulos as $articulo) { ?>
                <div class="alert alert-primary" role="alert">
                    <!-- Para objetos se usa la sintáxis compleja {} y comilla doble, para primitivos no es necesario el {} -->
                    <?php echo "{$articulo['name']} {$articulo['id']}" ?>
                </div>
            <?php } ?>
        </main>

        <footer>
            <!-- Paginación -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link <?php echo (($page - 1) === 0) ? 'disabled' : '' ?>" href="?page=<?php echo ($page - 1) ?>">
                            Anterior
                        </a>
                    </li>

                    <!-- Recorrer las páginas y mostrar los links -->
                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <li class="page-item">
                            <!-- Como redirecciona a la misma página y es el index, no hace falta colocar index.php -->
                            <a class="page-link <?php echo ($i == $page) ? 'active' : '' ?>" href="?page=<?php echo $i ?>">
                                <?php echo $i ?>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="page-item">
                        <a class="page-link <?php echo (($page + 1) > $totalPages) ? 'disabled' : '' ?>" href="?page=<?php echo ($page + 1) ?>">
                            Siguiente
                        </a>
                    </li>
                </ul>
            </nav>

            <p>
                <?php echo "Mostrando la página $page de $totalPages páginas." ?>
            </p>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
