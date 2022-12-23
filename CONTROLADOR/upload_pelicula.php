<?php
// Conexión a la base de datos
$host = "localhost:3307";
$user = "user_1";
$password = "123456";
$database = "teatro";
$conn = mysqli_connect($host, $user, $password, $database);

// Comprobar si la conexión ha fallado
if (mysqli_connect_errno()) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}
// Comprobar si se ha enviado una imagen
if (isset($_FILES["image"])) {
    // Recibir datos de la imagen
    $titulo_evento = $_POST["titulo_evento"];
    $fecha_evento = $_POST["fecha_evento"];
    $hora = $_POST["hora"];
    $costo = $_POST["costo"];
    $id_sala = $_POST["id_sala"];
    $genero = $_POST["genero"];
    $a_estreno = $_POST["a_estreno"];
    $duracion = $_POST["duracion"];
    $n_director = $_POST["n_director"];
    $sinopsis = $_POST["sinopsis"];
    $image = $_FILES["image"];
    $name = $image["name"];
    $tmp_name = $image["tmp_name"];
    $result = $conn->query("SELECT MAX(id_evento) FROM teatro.evento");
    $row = $result->fetch_assoc();
    $id_nuevo = $row['MAX(id_evento)'];
    $id_nuevo++;

    // Validar datos de la imagen
    if ($name && $genero && $sinopsis && $n_director) {
        // Subir imagen al servidor
        move_uploaded_file($tmp_name, "../IMAGENES/".$name);
        $conn->query("INSERT INTO teatro.evento (id_evento,titulo,fecha,hora,costo,id_sala) VALUES ('$id_nuevo','$titulo_evento','$fecha_evento','$hora','$costo','$id_sala')");

        // Insertar datos de la imagen en la base de datos
        
        $location = "IMAGENES/$name";
        $conn->query("INSERT INTO teatro.pelicula (id_evento,genero, a_estreno, duracion, n_director,sinopsis,nombre_img, ruta_img) VALUES ('$id_nuevo', '$genero','$a_estreno', '$duracion', '$n_director', '$sinopsis','$name','$location')");
        // Mostrar mensaje de éxito
        //echo "Imagen subida con éxito";
        echo "<script>
            window.location.href = '../peliculas.php';
            </script>";
    }
}
// Cerrar conexión a la base de datos
$conn->close();