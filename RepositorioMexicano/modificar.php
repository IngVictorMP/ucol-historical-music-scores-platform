<html>

<head>
    <title>MODIFICAR REGISTRO</title>
</head>

<body>
    <?php
    $conexion = mysqli_connect("localhost", "root", "", "bibliotecafime") or die("Error!");
    $conexion->set_charset("utf8");

    if (isset($_POST['id_usr_form'])) {
        $id_usr_form = $_POST['id_usr_form'];
        $nombre_usr_form = $_POST['Nombre_Usuario'];
        $apellido_usr_form = $_POST['Apellidos_Usuario'];
        $dni_usr_form = $_POST['DNI'];
        $domicilio_usr_form = $_POST['Domicilio'];
        $poblacion_usr_form = $_POST['Poblacion'];
        $provincia_usr_form = $_POST['Provincia'];
        $fecha_nac_usr_form = $_POST['Fecha_Nacimiento'];

        mysqli_query($conexion, "UPDATE usuarios
                                 SET Nombre_Usuario='$nombre_usr_form', Apellidos_Usuario='$apellido_usr_form', DNI='$dni_usr_form', Domicilio='$domicilio_usr_form',
                                     Poblacion='$poblacion_usr_form', Provincia='$provincia_usr_form', Fecha_Nacimiento='$fecha_nac_usr_form'
                                 WHERE Codigo_Usuario=$id_usr_form") or die("Problemas en el update:" . mysqli_error($conexion));

        echo "Se modificó el registro del usuario con dicho código.";

     
        header("Location: RegistrarUsuario.php");
        exit(); 
    } else {
        echo "No se recibió el identificador del usuario a modificar.";
    }

    mysqli_close($conexion);
    ?>
</body>

</html><head>
  <title>Problema</title>
</head>

<body>

  <?php
$conexion=mysqli_connect("localhost","root","","bibliotecafime") or die ("Error!"); 
$conexion->set_charset("utf8");

  $registros = mysqli_query($conexion, "select * from usuarios where Codigo_Usuario = $_REQUEST[codEditar]") or  die("Problemas en el select:" . mysqli_error($conexion));
  if ($reg = mysqli_fetch_array($registros)) {
    ?>

    <form action="modificar.php" method="post">
      INGRESE LOS NUEVOS DATOS:
      <input type="text" name="Nombre_Usuario" value="<?php echo $reg['Nombre_Usuario'] ?>">
	  <input type="text" name="Apellidos_Usuario" value="<?php echo $reg['Apellidos_Usuario'] ?>">
	  <input type="text" name="DNI" value="<?php echo $reg['DNI'] ?>">
	  <input type="text" name="Domicilio" value="<?php echo $reg['Domicilio'] ?>">
      <input type="hidden" name="Poblacion" value="<?php echo $reg['Poblacion'] ?>">
      <input type="text" name="Provincia" value="<?php echo $reg['Provincia'] ?>">
	  <input type="text" name="Fecha_Nacimiento" value="<?php echo $reg['Fecha_Nacimiento'] ?>">
      <br>
      <input type="submit" value="Modificar">
    </form>

  <?php
  } else
    echo "No existe un curso con dicho codigo";
  ?>

