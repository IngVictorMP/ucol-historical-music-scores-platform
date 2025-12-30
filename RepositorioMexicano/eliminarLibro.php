<html>
    <head>
        <title>ELIMINAR REGISTRO</title>
    </head>
    <body>
        <?php
            $conexion = mysqli_connect("localhost", "root", "", "db_poudc") or die("Error!");
            $conexion->set_charset("utf8");

            $codEliminar = $_REQUEST['codEliminar'];

            $registros = mysqli_query($conexion, "SELECT * FROM post WHERE id_post = $codEliminar") or die("Problemas en el select:" . mysqli_error($conexion));

            if ($reg = mysqli_fetch_array($registros)) {
                mysqli_query($conexion, "DELETE FROM post WHERE id_post = $codEliminar") or
                    die("Problemas en el delete:" . mysqli_error($conexion));
                echo "Se efectuó el borrado del libro con dicho código.";

                header("Location: registrarLibros.php");
                exit(); 
            } else {
                echo "No existe un libro con ese código.";
            }

            mysqli_close($conexion);
        ?>
    </body>
</html>