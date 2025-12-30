<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registro de Partituras - Repositorio Mexicano</title>
        <link rel="stylesheet" href="css/registroUsuario.css">
        <style>
            header #menu ul
            {
                margin: 0;
                padding: 0;
                font-size: 17px;
            }

        </style>
    </head>
    <body>
        <div id="main-container">
            <header>
                <div id="menu">
                    <ul>
                        <li id="logo"><a href="index.html"><img src="img/logo.png" alt=""></a></li>
                        <li><b><a href="index.html">HOMEㅤ</a></li>
                        <li><a href="registrarLibros.php">REGISTROS DE PARTITURASㅤ</a></li>
                        <li><a href="Consultar.php">BUSCAR PARTITURAㅤ</a></li>
                        <li><a href="IniciarSesion.html">INICIAR SESIÓNㅤ</a></li></b> 
                    </ul>
                </div>
            
                <main>
                    <br><br><br><br><br><br><br>
                    <div class="text">
                        <h1>REGISTROS PARTITURAS</h1>
                        <p>Completa el formulario del final para <b>registrar</b> una nueva partitura.</p>
                        
                    </div>
                </main>
            </header>
        </div>

        <?php
            
            // Conexion a la base de datos
            $usuario = "root";
            $password = "";
            $servidor = "localhost";
            $basededatos = "db_poudc";
            // $conexion = mysqli_connect( $servidor, $usuario, "" ) or die ("No se ha podido conectar al servidor de Base de datos");
            // $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
            // Conectar a la base de datos
            $conexion = new mysqli($servidor, $usuario, $password, $basededatos);

            // Verificar la conexión
            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Crear la conexion a la base de datos
            $conn = new mysqli($servidor, $usuario, $password, $basededatos);
            // Comprobar la conexión
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }


            $consulta = "SELECT post.*, autor.*, obra.* , partitura.*
            FROM post
            INNER JOIN autor ON post.id_autor = autor.id_autor
            INNER JOIN obra ON post.id_obra = obra.id_obra
            INNER JOIN partitura ON post.id_partitura = partitura.id_partitura";

            $resultado = mysqli_query($conexion, $consulta) or  die("Problemas en el select:" . mysqli_error($conexion));
            // $consulta1 = "SELECT * FROM post";
            // $resultado = mysqli_query( $conexion, $consulta4 ) or die ( "Algo ha ido mal en la consulta a la base de datos");
        ?>


        <?php
            if(isset($_POST["insert"]))
            {
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
                $pdf_nombre = $_FILES["pdf"]["name"];
                $pdf_ruta_temporal = $_FILES["pdf"]["tmp_name"];
                $pdf = "pdfs/" . $pdf_nombre;
                move_uploaded_file($pdf_ruta_temporal, $pdf);

                // Insertar datos en la base de datos
                $sql = "INSERT INTO autor (nombre, apellido, fecha_nac, fecha_mue, lugar_nac, nacionalidad)
                VALUES ('$nombre', '$apellido', '$fecha_nac', '$fecha_mue', '$lugar_nac', '$nacionalidad')";
                if ($conn->query($sql) === TRUE) {
                    $id_autor = $conn->insert_id; // Obtener el ID del autor insertado
                    $sql = "INSERT INTO obra (titulo1, titulo2, traduccion, subtitulo, num_opus, dedicatoria, instrumentacion, genero, tonalidad, movimientos, estilo, ano_composicion, ano_estreno, idioma, libretista, info_complem1, info_complem2)
                            VALUES ('$titulo1', '$titulo2', '$traduccion', '$subtitulo', '$num_opus', '$dedicatoria', '$instrumentacion', '$genero', '$tonalidad', '$movimientos', '$estilo', '$ano_composicion', '$ano_estreno', '$idioma', '$libretista', '$info_complem1', '$info_complem2')";
                    if ($conn->query($sql) === TRUE) {
                            $id_obra = $conn->insert_id; // Obtener el ID de la obra insertada
                            $sql = "INSERT INTO partitura (descripcion, editorial, ano_edicion, num_plancha, grab_mus, ilustrador, num_pag, enlace_ext, observaciones)
                                    VALUES ('$descripcion', '$editorial', '$ano_edicion', '$num_plancha', '$grab_mus', '$ilustrador', '$num_pag', '$enlace_ext', '$observaciones')";
                            if ($conn->query($sql) === TRUE) {
                                $id_partitura = $conn->insert_id; // Obtener el ID de la partitura insertada
                                $sql = "INSERT INTO post (id_autor, id_obra, id_partitura, pdf)
                                        VALUES ('$id_autor', '$id_obra', '$id_partitura', '$pdf')";
                                if ($conn->query($sql) === TRUE) {
                                    echo "<br><h3><center>¡PARTITURA REGISTRADA CORRECTAMENTE!</center></h3>";
                                    header("Location: RegistrarLibros.php");
                                } else {
                                    echo "Error al guardar el post: " . $conn->error;
                                }
                            } else {
                                echo "Error al guardar la partitura: " . $conn->error;
                            }
                        } else {
                            echo "Error al guardar la obra: " . $conn->error;
                    }
                    } else {
                    echo "Error al guardar el autor: " . $conn->error;
                }

                // Cerrar conexión
                $conn->close();
            }
        ?>



        <div class="result-container">
            <table>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <tr>
                    <th>No. Partitura</th>
                    <th>Titulo</th>
                    <th>Nombre Autor</th>
                    <th>Nacionalidad</th>
                    <th>Instrumentacion</th>
                    <th>Genero</th>
                    <th>No. Paginas</th>
                    <th>PDF</th>
                    <th>ACCIONES</th>
                </tr>

                <?php
                    while ($columna = mysqli_fetch_array($resultado)) {
                        echo "<tr>";
                        echo "<td>{$columna['id_post']}</td>
                        <td>{$columna['titulo1']}</td>
                        <td>{$columna['nombre']}</td>
                        <td>{$columna['nacionalidad']}</td>
                        <td>{$columna['instrumentacion']}</td>
                        <td>{$columna['genero']}</td>
                        <td>{$columna['num_pag']}</td>
                        <td><a href='{$columna['pdf']}' target='_blank'>Abrir PDF</a></td>";
                        echo "<td>
                                <form method ='POST' action='eliminarLibro.php'>
                                    <input type ='hidden' value='{$columna['id_post']}' name='codEliminar' />
                                    <input type='submit' value='Eliminar' />
                                </form>
                                <br>
                                <form method ='POST' action='editarLibro.php'>
                                    <input type ='hidden' value='{$columna['id_post']}' name='codEditar' />
                                    <input type='submit' value='Modificar' />
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                    mysqli_close($conexion);
                ?>
            </table>
            <br><br>
        </div>

        <div class = "Formulario">
            <form method="POST" action="RegistrarLibros.php" enctype="multipart/form-data">
                <div class="section">
                    <h2>DATOS DEL AUTOR</h2>
                    <label>NOMBRE:<br></label>
                    <input type="text" name="nombre" placeholder="INGRESA EL NOMBRE DEL AUTOR" required><br />
                    <label>APELLIDO:<br></label>
                    <input type="text" name="apellido" placeholder="INGRESA EL NOMBRE DEL AUTOR" required><br />
                    <label>FECHA DE NACIMIENTO:<br></label>
                    <input type="date" name="fecha_nac" placeholder="INGRESA LA FECHA DE NACIMIENTO"><br />
                    <label>FECHA DE MUERTE:<br></label>
                    <input type="date" name="fecha_mue" placeholder="INGRESA LA FECHA DE MUERTE"><br />
                    <label>LUGAR DE NACIMIENTO (PAIS/CIUDAD):<br></label>
                    <input type="text" name="lugar_nac" placeholder="INGRESA EL LUGAR DE NACIMIENTO DEL AUTOR" required><br />
                    <label>NACIONALIDAD<br></label>
                    <input type="text" name="nacionalidad" placeholder="INGRESA LA NACIONALIDAD DEL AUTOR" required><br />
                    <input type="hidden" name="id_atr_form" value="<?php echo $reg['id_autor'] ?>">
                    <!-- Agregar más campos aquí si es necesario -->
                </div>
                <div class="section">
                    <h2>DATOS DE LA OBRA</h2>
                    <label>TITULO:<br></label>
                    <input type="text" name="titulo1" placeholder="INGRESA EL TITULO DE LA OBRA" required><br />
                    <label>TITULO ALTERNATIVO:<br></label>
                    <input type="text" name="titulo2" placeholder="INGRESA EL TITULO ALTERNATIVO DE LA OBRA"><br />
                    <label>TRADUCCION / TRANSLITERACIÓN DEL TITULO:<br></label>
                    <input type="text" name="traduccion" placeholder="INGRESA EL TITULO DE LA OBRA"><br />
                    <label>SUBTITULO:<br></label>
                    <input type="text" name="subtitulo" placeholder="INGRESA EL SUBTITULO DE LA OBRA"><br />
                    <label>NÚMERO DE OPUS:<br></label>
                    <input type="number" name="num_opus" placeholder="INGRESA EL NUMERO DE OPUS DE LA OBRA" required><br />
                    <label>DEDICATORIA:<br></label>
                    <input type="text" name="dedicatoria" placeholder="INGRESA EL TITULO DE LA OBRA" required><br />
                    <label>INSTRUMENTACIÓN:<br></label>
                    <input type="text" name="instrumentacion" placeholder="INGRESA LA INSTRUMENTACIÓN DE LA OBRA" required><br />
                    <label>GÉNERO:<br></label>
                    <input type="text" name="genero" placeholder="INGRESA EL GÉNERO DE LA OBRA" required><br />
                    <label>TONALIDAD:<br></label>
                    <input type="text" name="tonalidad" placeholder="INGRESA LA TONALIDAD DE LA OBRA"><br />
                    <label>MOVIMIENTOS:<br></label>
                    <input type="text" name="movimientos" placeholder="INGRESA LOS MOVIMIENTOS DE LA OBRA"><br />
                    <label>ESTILO:<br></label>
                    <input type="text" name="estilo" placeholder="INGRESA EL ESTILO DE LA OBRA" required><br />
                    <label>AÑO DE COMPOSICIÓN:<br></label>
                    <input type="number" max="9999" name="ano_composicion" placeholder="INGRESA EL AÑO DE COMPOSICIÓN DE LA OBRA"><br />
                    <label>AÑO DE ESTRENO:<br></label>
                    <input type="number" max="9999" name="ano_estreno" placeholder="INGRESA EL AÑO DE ESTRENO DE LA OBRA"><br />
                    <label>IDIOMA:<br></label>
                    <input type="text" name="idioma" placeholder="INGRESA EL IDIOMA DE LA OBRA"><br />
                    <label>LIBRETISTA:<br></label>
                    <input type="text" name="libretista" placeholder="INGRESA EL LIBRETISTA DE LA OBRA"><br />
                    <label>INFORMACIÓN COMPLEMENTARIA:<br></label>
                    <input type="text" name="info_complem1" placeholder="INGRESA INFORMACIÓN COMPLEMENTARIA DE LA OBRA" required><br />
                    <label>MÁS INFORMACIÓN COMPLEMENTARIA:<br></label>
                    <input type="text" name="info_complem2" placeholder="INGRESA INFORMACIÓN COMPLEMENTARIA DE LA OBRA" required><br />
                    <input type="hidden" name="id_obra_form" value="<?php echo $reg['id_obra'] ?>">
                    <!-- Agregar más campos aquí si es necesario -->
                </div>
                <div class="section">
                    <h2>DATOS DE LA PARTITURA</h2>
                    <label>DESCRIPCION:<br></label>
                    <input type="text" name="descripcion" placeholder="INGRESA EL IDIOMA DE LA OBRA" required><br />
                    <label>EDITORIAL:<br></label>
                    <input type="text" name="editorial" placeholder="INGRESA LA EDITORIAL DE LA OBRA" required><br />
                    <label>AÑO DE EDICIÓN:<br></label>
                    <input type="number" max="9999" name="ano_edicion" placeholder="INGRESA EL AÑO DE EDICIÓN DE LA OBRA"><br />
                    <label>NÚMERO DE PLANCHA:<br></label>
                    <input type="text" name="num_plancha" placeholder="INGRESA EL NÚMERO DE PLANCHA DE LA OBRA" required><br />
                    <label>GRABACIÓN MUSICAL:<br></label>
                    <input type="text" name="grab_mus" placeholder="INGRESA LA GRABACIÓN MUSICAL DE LA OBRA" required><br />
                    <label>ILUSTRADOR:<br></label>
                    <input type="text" name="ilustrador" placeholder="INGRESA EL ILUSTRADOR DE LA OBRA"><br />
                    <label>NÚMERO DE PÁGINAS:<br></label>
                    <input type="number" name="num_pag" placeholder="INGRESA EL NÚMERO DE PÁGINAS DE LA OBRA" required><br />
                    <label>ENLACE EXTERNO:<br></label>
                    <input type="text" name="enlace_ext" placeholder="INGRESA EL ENLACE EXTERNO DE LA OBRA" required><br />
                    <label>OBSERVACIONES:<br></label>
                    <input type="text" name="observaciones" placeholder="INGRESA LAS OBSERVACIONES DE LA OBRA"><br />
                    <label>PDF:<br></label>
                    <input type="file" name="pdf" placeholder="INGRESA EL PDF DE LA OBRA" required><br />
                    <input type="hidden" name="id_pta_form" value="<?php echo $reg['id_partitura'] ?>">
                    <!-- Agregar más campos aquí si es necesario -->
                </div>

                <button type="submit" name="insert">GUARDAR PARTITURA</button>
            </form>
        </div>
                 
        <footer>
            FIME Derechos Reservados
        </footer>
    </body>
</html>