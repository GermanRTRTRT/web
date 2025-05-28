<?php 

$host = "localhost";  // corregido el ":" por ";"
$user = "root";
$password = "";
$dbname = "bd_vincular";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error) { 
  die("Conexión fallida: " . $conn->connect_error);
}

$name = $_POST['nombre'];
$user = $_POST['usuario'];
$email = $_POST['correo'];
$pass = $_POST['contraseña'];

if (isset($_POST['insertar'])) {
  $sql = "INSERT INTO usuarios (nombre, usuario, correo, contraseña) VALUES (?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $name, $user, $email, $pass);

  if ($stmt->execute()) { 
     echo "Datos registrados correctamente.";
  } else { 
     echo "Error al registrar: " . $stmt->error;
  }

  $stmt->close();
}

if (isset($_POST['mostrar'])) {
  $mostrar = "SELECT * FROM usuarios";
  $sql = mysqli_query($conn, $mostrar);

  echo "<table border='1' align='center'>
        <tr>
          <th>Nombre</th>
          <th>Usuario</th>
          <th>Correo</th>
          <th>Contraseña</th>
        </tr>";

  while ($ver = mysqli_fetch_array($sql)) { 
    echo "<tr>";
    echo "<td>" . $ver['nombre'] . "</td>";
    echo "<td>" . $ver['usuario'] . "</td>";
    echo "<td>" . $ver['correo'] . "</td>";
    echo "<td>" . $ver['contraseña'] . "</td>";
    echo "</tr>";
  }

  echo "</table>";
}

if (isset($_POST['actualizar'])) {
  $actualizar = "UPDATE usuarios SET nombre='$name', usuario='$user', contraseña='$pass' WHERE correo='$email'";
  if (mysqli_query($conn, $actualizar)) {
    echo "Registro actualizado correctamente.";
  } else {
    echo "Error al actualizar: " . mysqli_error($conn);
  }
}

if (isset($_POST['eliminar'])) {
  $eliminar = "DELETE FROM usuarios WHERE correo='$email'";
  if (mysqli_query($conn, $eliminar)) {
    echo "Registro eliminado correctamente.";
  } else {
    echo "Error al eliminar: " . mysqli_error($conn);
  }
}

$conn->close();
?>
