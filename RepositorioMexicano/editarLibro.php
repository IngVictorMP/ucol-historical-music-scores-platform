<html>
<head>
    <title>MODIFICAR REGISTRO</title>
</head>

<body>
    <link rel="stylesheet" href="css/modificar.css">
    <?php
    $conexion = mysqli_connect("localhost", "root", "", "db_poudc") or die("Error!");
    $conexion->set_charset("utf8");

    if (isset($_POST['id_post_form'])) {
        //! Datos del autor
        $nombre = $_POST["nombre"]; 
        $apellido = $_POST["apellido"];
        $fecha_nac = $_POST["fecha_nac"];
        $fecha_mue = $_POST["fecha_mue"];
        $lugar_nac = $_POST["lugar_nac"];
        $nacionalidad = $_POST["nacionalidad"];

        // ! Datos de la obra
        $titulo1 = $_POST["titulo1"];
        $titulo2 = $_POST["titulo2"];
        $traduccion = $_POST["traduccion"];
        $subtitulo = $_POST["subtitulo"];
        $num_opus = $_POST["num_opus"];
        $dedicatoria = $_POST["dedicatoria"];
        $instrumentacion = $_POST["instrumentacion"];
        $genero = $_POST["genero"];
        $tonalidad = $_POST["tonalidad"];
        $movimientos = $_POST["movimientos"];
        $estilo = $_POST["estilo"];
        $ano_composicion = $_POST["ano_composicion"];
        $ano_estreno = $_POST["ano_estreno"];
        $idioma = $_POST["idioma"];
        $libretista = $_POST["libretista"];
        $info_complem1 = $_POST["info_complem1"];
        $info_complem2 = $_POST["info_complem2"];

        // ! Datos de la partitura
        $descripcion = $_POST["descripcion"];
        $editorial = $_POST["editorial"];
        $ano_edicion = $_POST["ano_edicion"];
        $num_plancha = $_POST["num_plancha"];
        $grab_mus = $_POST["grab_mus"];
        $ilustrador = $_POST["ilustrador"];
        $num_pag = $_POST["num_pag"];
        $enlace_ext = $_POST["enlace_ext"];
        $observaciones = $_POST["observaciones"];

        // ! Datos del Post
        $id_autor = $_POST["id_autor"];
        $id_obra = $_POST["id_obra"];
        $id_partitura = $_POST["id_partitura"];
        $id_post = $_POST["id_post_form"];
        $pdf_actual = $_POST["pdf_actual"];

        // Verificar si se ha seleccionado un nuevo archivo PDF
        if ($_FILES["pdf"]["name"] != "") {
            // Si se ha seleccionado un nuevo archivo PDF, subirlo y usarlo
            $pdf_nombre = $_FILES["pdf"]["name"];
            $pdf_ruta_temporal = $_FILES["pdf"]["tmp_name"];
            $pdf = "pdfs/" . $pdf_nombre;
            move_uploaded_file($pdf_ruta_temporal, $pdf);
        } else {
            // Si no se ha seleccionado un nuevo archivo PDF, usar el PDF actual
            $pdf = $pdf_actual;
        }

        // Actualizar datos en la base de datos
        $sql = "UPDATE autor SET 
        nombre = '$nombre',
        apellido = '$apellido',
        fecha_nac = '$fecha_nac',
        fecha_mue = '$fecha_mue',
        lugar_nac = '$lugar_nac',
        nacionalidad = '$nacionalidad'
        WHERE id_autor = $id_autor";

        if ($conexion->query($sql) === TRUE) {
        $sql = "UPDATE obra SET 
            titulo1 = '$titulo1',
            titulo2 = '$titulo2',
            traduccion = '$traduccion',
            subtitulo = '$subtitulo',
            num_opus = '$num_opus',
            dedicatoria = '$dedicatoria',
            instrumentacion = '$instrumentacion',
            genero = '$genero',
            tonalidad = '$tonalidad',
            movimientos = '$movimientos',
            estilo = '$estilo',
            ano_composicion = '$ano_composicion',
            ano_estreno = '$ano_estreno',
            idioma = '$idioma',
            libretista = '$libretista',
            info_complem1 = '$info_complem1',
            info_complem2 = '$info_complem2'
            WHERE id_obra = $id_obra";

        if ($conexion->query($sql) === TRUE) {
        $sql = "UPDATE partitura SET 
                descripcion = '$descripcion',
                editorial = '$editorial',
                ano_edicion = '$ano_edicion',
                num_plancha = '$num_plancha',
                grab_mus = '$grab_mus',
                ilustrador = '$ilustrador',
                num_pag = '$num_pag',
                enlace_ext = '$enlace_ext',
                observaciones = '$observaciones'
                WHERE id_partitura = $id_partitura";

        if ($conexion->query($sql) === TRUE) {
            $sql = "UPDATE post SET 
                    pdf = '$pdf'
                    WHERE id_post = $id_post";

            if ($conexion->query($sql) === TRUE) {
                echo "<br><h3><center>¡PARTITURA ACTUALIZADA CORRECTAMENTE!</center></h3>";
                header("Location: RegistrarLibros.php");
            } else {
                echo "Error al actualizar el post: " . $conexion->error;
            }
        } else {
            echo "Error al actualizar la partitura: " . $conexion->error;
        }
        } else {
        echo "Error al actualizar la obra: " . $conexion->error;
        }
        } else {
        echo "Error al actualizar el autor: " . $conexion->error;
        }

      mysqli_close($conexion);
      }
    ?>
</body>

</html><head>
  <title>Problema</title>
</head>

<body>

  <?php
  $conexion = mysqli_connect("localhost", "root", "", "db_poudc") or die("Error!");
  $conexion->set_charset("utf8");
  $consulta = "SELECT post.*, autor.*, obra.* , partitura.*
            FROM post
            INNER JOIN autor ON post.id_autor = autor.id_autor
            INNER JOIN obra ON post.id_obra = obra.id_obra
            INNER JOIN partitura ON post.id_partitura = partitura.id_partitura
            WHERE post.id_post = $_REQUEST[codEditar]";

  $registros = mysqli_query($conexion, $consulta) or  die("Problemas en el select:" . mysqli_error($conexion));

  if ($reg = mysqli_fetch_array($registros)) {
  ?>
    <div class="text">
      <h1>INGRESE LOS NUEVOS DATOS:</h1>
    </div>
    <div class = "Formulario">
      <form action="editarLibro.php" method="POST" enctype="multipart/form-data">
        <br><br><br><br><br>
        <input type="hidden" name="id_post_form" value="<?php echo $reg['id_post'] ?>"><br>
        <input type="hidden" name="id_autor" value="<?php echo $reg['id_autor'] ?>">
        <input type="hidden" name="id_obra" value="<?php echo $reg['id_obra'] ?>">
        <input type="hidden" name="id_partitura" value="<?php echo $reg['id_partitura'] ?>">
        <div class="section">
          <h2>DATOS DEL AUTOR</h2>
          <label>NOMBRE:<br></label>
          <input type="text" name="nombre" placeholder = "INGRESA EL NOMBRE DEL AUTOR" value="<?php echo $reg['nombre'] ?>" required><br>
          <label>APELLIDO:<br></label>
          <input type="text" name="apellido" value="<?php echo $reg['apellido'] ?>" required><br>
          <label>FECHA DE NACIMIENTO:<br></label>
          <input type="date" name="fecha_nac" value="<?php echo $reg['fecha_nac'] ?>"><br>
          <label>FECHA DE MUERTE:<br></label>
          <input type="date" name="fecha_mue" value="<?php echo $reg['fecha_mue'] ?>"><br>
          <label>LUGAR DE NACIMIENTO (PAIS/CIUDAD):<br></label>
          <input type="text" name="lugar_nac" value="<?php echo $reg['lugar_nac'] ?>" required><br>
          <label>NACIONALIDAD<br></label>
          <input type="text" name="nacionalidad" value="<?php echo $reg['nacionalidad'] ?>" required><br>
        </div>
        <div class="section">
        <h2>DATOS DE LA OBRA</h2>
          <label>TITULO:<br></label>
          <input type="text" name="titulo1" value="<?php echo $reg['titulo1'] ?>" required><br>
          <label>TITULO ALTERNATIVO:<br></label>
          <input type="text" name="titulo2" value="<?php echo $reg['titulo2'] ?>"><br>
          <label>TRADUCCION:<br></label>
          <input type="text" name="traduccion" value="<?php echo $reg['traduccion'] ?>"><br>
          <label>SUBTITULO:<br></label>
          <input type="text" name="subtitulo" value="<?php echo $reg['subtitulo'] ?>"><br>
          <label>NUMERO OPUS:<br></label>
          <input type="number" name="num_opus" value="<?php echo $reg['num_opus'] ?>" required><br>
          <label>DEDICATORIA:<br></label>
          <input type="text" name="dedicatoria" value="<?php echo $reg['dedicatoria'] ?>" required><br>
          <label>INSTRUMENTACION:<br></label>
          <input type="text" name="instrumentacion" value="<?php echo $reg['instrumentacion'] ?>" required><br>
          <label>GENERO:<br></label>
          <input type="text" name="genero" value="<?php echo $reg['genero'] ?>" required><br>
          <label>TONALIDAD:<br></label>
          <input type="text" name="tonalidad" value="<?php echo $reg['tonalidad'] ?>" required><br>
          <label>MOVIMIENTOS:<br></label>
          <input type="text" name="movimientos" value="<?php echo $reg['movimientos'] ?>" required><br>
          <label>ESTILO:<br></label>
          <input type="text" name="estilo" value="<?php echo $reg['estilo'] ?>" required><br>
          <label>AÑO DE COMPOSICION:<br></label>
          <input type="number" name="ano_composicion" value="<?php echo $reg['ano_composicion'] ?>"><br>
          <label>AÑO DE ESTRENO:<br></label>
          <input type="number" name="ano_estreno" value="<?php echo $reg['ano_estreno'] ?>"><br>
          <label>IDIOMA:<br></label>
          <input type="text" name="idioma" value="<?php echo $reg['idioma'] ?>"><br>
          <label>LIBRETISTA:<br></label>
          <input type="text" name="libretista" value="<?php echo $reg['libretista'] ?>"><br>
          <label>INFORMACION COMPLEMENTARIA:<br></label>
          <input type="text" name="info_complem1" value="<?php echo $reg['info_complem1'] ?>" required><br>
          <label>MÁS INFORMACIÓN COMPLEMENTARIA:<br></label>
          <input type="text" name="info_complem2" value="<?php echo $reg['info_complem2'] ?>" required><br>
        </div>
        <div class="section">
        <h2>DATOS DE LA PARTITURA</h2>
          <label>DESCRIPCION:<br></label>
          <input type="text" name="descripcion" value="<?php echo $reg['descripcion'] ?>" required><br>
          <label>EDITORIAL:<br></label>
          <input type="text" name="editorial" value="<?php echo $reg['editorial'] ?>" required><br>
          <label>AÑO DE EDICION:<br></label>
          <input type="number" name="ano_edicion" value="<?php echo $reg['ano_edicion'] ?>"><br>
          <label>NUMERO DE PLANCHA:<br></label>
          <input type="text" name="num_plancha" value="<?php echo $reg['num_plancha'] ?>" required><br>
          <label>GRABACION MUSICAL:<br></label>
          <input type="text" name="grab_mus" value="<?php echo $reg['grab_mus'] ?>" required><br>
          <label>ILUSTRADOR:<br></label>
          <input type="text" name="ilustrador" value="<?php echo $reg['ilustrador'] ?>"><br>
          <label>NUMERO DE PAGINAS:<br></label>
          <input type="number" name="num_pag" value="<?php echo $reg['num_pag'] ?>" required><br>
          <label>ENLACE EXTERNO:<br></label>
          <input type="text" name="enlace_ext" value="<?php echo $reg['enlace_ext'] ?>" required><br>
          <label>OBSERVACIONES:<br></label>
          <input type="text" name="observaciones" value="<?php echo $reg['observaciones'] ?>"><br>
          <label>PDF actual:</label>
          <?php echo $reg['pdf']; ?><br><br>
          <label>Subir nuevo PDF:</label>
          <input type="file" name="pdf"><br>
          <!-- Enviar el mismo pdf si no se modifica -->
          <input type="hidden" name="pdf_actual" value="<?php echo $reg['pdf']; ?>">

        </div>
        <br>
        <input type="submit" value="CONFIRMAR EDICIÓN">
      </form>
    </div>

  <?php
  } else
    echo "No existe un curso con dicho codigo";
  ?>

<footer>
  FIME Derechos Reservados
</footer>
