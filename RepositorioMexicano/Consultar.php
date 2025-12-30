<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registro de Libros - BIBLIOTECA FIME</title>
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
                        <li id="logo"><a href="#"><img src="img/logo.png" alt=""></a></li>
                        
                        <li><b><a href="index.html">HOMEㅤ</a></li>
                        <li><a href="registrarLibros.php">REGISTROS DE PARTITURASㅤ</a></li>
                        <li><a href="Consultar.php">BUSCAR PARTITURAㅤ</a></li>
                        <li><a href="IniciarSesion.html">INICIAR SESIÓNㅤ</a></li></b>  
                    </ul>
                </div>
            
                <main>
                    <br><br><br><br><br><br><br>
                    <div class="text">
                        <h1>BÚSQUEDA DE PARTITURAS</h1>                        
                    </div>
                </main>
            </header>
        </div>

                    <div class="section" id="features">
                        <form method="post">
                        <br><br><br>    
                            <label for="busqueda"><b>ㅤㅤㅤPARTITURA A BUSCAR:</b></label>
                            <input type="text" id="busqueda" name="busqueda" required>
                            <button type="submit" name="buscar">Buscar</button>
                        </form>

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

                            $resultado_todos = mysqli_query($conexion, $consulta) or  die("Problemas en el select:" . mysqli_error($conexion));

                            if (isset($_POST['buscar'])) {
                                $busqueda = mysqli_real_escape_string($conexion, $_POST['busqueda']);

                                $consulta_busqueda = "SELECT post.*, autor.*, obra.* , partitura.*
                                                        FROM post
                                                        INNER JOIN autor ON post.id_autor = autor.id_autor
                                                        INNER JOIN obra ON post.id_obra = obra.id_obra
                                                        INNER JOIN partitura ON post.id_partitura = partitura.id_partitura 
                                                        WHERE titulo1 LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%'
                                                        OR nacionalidad LIKE '%$busqueda%' OR instrumentacion LIKE '%$busqueda%'
                                                        OR genero LIKE '%$busqueda%' OR num_pag LIKE '%$busqueda%'
                                                        OR editorial LIKE '%$busqueda%' OR idioma LIKE '%$busqueda%'";

                                $resultado_busqueda = mysqli_query($conexion, $consulta_busqueda) or die("Error en la consulta");

                                if (mysqli_num_rows($resultado_busqueda) > 0) {
                                    echo "<h3>ㅤㅤㅤRESULTADOS DE LA BÚSQUEDA:</h3>";
                                    echo "<table border='1'>
                                            <tr>
                                                <th>NOMBRE DE LA OBRA</th>
                                                <th>NOMBRE DEL AUTOR</th>
                                                <th>NACIONALIDAD AUTOR</th>
                                                <th>INSTRUMENTACION</th>
                                                <th>GENERO</th>
                                                <th>No. PAGINAS</th>
                                                <th>IDIOMA</th>
                                                <th>EDITORIAL</th>
                                                <th>PDF</th>
                                                <th>ACCIONES</th>
                                            </tr>";

                                    while ($fila_busqueda = mysqli_fetch_assoc($resultado_busqueda)) {
                                        echo "<tr>
                                                <td>{$fila_busqueda['titulo1']}</td>
                                                <td>{$fila_busqueda['nombre']}</td>
                                                <td>{$fila_busqueda['nacionalidad']}</td>
                                                <td>{$fila_busqueda['instrumentacion']}</td>
                                                <td>{$fila_busqueda['genero']}</td>
                                                <td>{$fila_busqueda['num_pag']}</td>
                                                <td>{$fila_busqueda['idioma']}</td>
                                                <td>{$fila_busqueda['editorial']}</td>
                                                <td><a href='{$fila_busqueda['pdf']}' target='_blank'>Abrir PDF</a></td>
                                                <td>
                                                <form method ='POST' action='eliminarLibro.php'>
                                                    <input type ='hidden' value='{$fila_busqueda['id_post']}' name='codEliminar' />
                                                    <input type='submit' value='Eliminar' />
                                                </form>
                                                <br>
                                                <form method ='POST' action='editarLibro.php'>
                                                    <input type ='hidden' value='{$fila_busqueda['id_post']}' name='codEditar' />
                                                    <input type='submit' value='Modificar' />
                                                </form>
                                                </td>";
                                        echo "</tr>";
                                    }

                                    echo "</table><br>";
                                } else {
                                    echo "<label>No se encontraron resultados para la búsqueda: <b>$busqueda<b></label><br>";
                                }
                            }

                            echo "<h3>ㅤㅤㅤPARTITURAS EN LA BASE DE DATOS:</h3>";
                            echo "<table border='1'>
                                    <tr>
                                    <th>NOMBRE DE LA OBRA</th>
                                    <th>NOMBRE DEL AUTOR</th>
                                    <th>NACIONALIDAD AUTOR</th>
                                    <th>INSTRUMENTACION</th>
                                    <th>GENERO</th>
                                    <th>No. PAGINAS</th>
                                    <th>IDIOMA</th>
                                    <th>EDITORIAL</th>
                                    <th>PDF</th>
                                    <th>ACCIONES</th>
                                </tr>";

                            while ($fila_todos = mysqli_fetch_assoc($resultado_todos)) {
                                echo "<tr>
                                    <td>{$fila_todos['titulo1']}</td>
                                    <td>{$fila_todos['nombre']}</td>
                                    <td>{$fila_todos['nacionalidad']}</td>
                                    <td>{$fila_todos['instrumentacion']}</td>
                                    <td>{$fila_todos['genero']}</td>
                                    <td>{$fila_todos['num_pag']}</td>
                                    <td>{$fila_todos['idioma']}</td>
                                    <td>{$fila_todos['editorial']}</td>
                                    <td><a href='{$fila_todos['pdf']}' target='_blank'>Abrir PDF</a></td>
                                    <td>
                                    <form method ='POST' action='eliminarLibro.php'>
                                        <input type ='hidden' value='{$fila_todos['id_post']}' name='codEliminar' />
                                        <input type='submit' value='Eliminar' />
                                    </form>
                                    <br>
                                    <form method ='POST' action='editarLibro.php'>
                                        <input type ='hidden' value='{$fila_todos['id_post']}' name='codEditar' />
                                        <input type='submit' value='Modificar' />
                                    </form>
                                    </td>";
                            echo "</tr>";
                            }

                            echo "</table>";

                            // Cerrar la conexión
                            mysqli_close($conexion);
                        ?>
        
                    </div>
                </main>
            </header>
        </div>
        <footer>
                ©  «Copyright» Derechos Reservados 
        </footer>
    </body>
</html>