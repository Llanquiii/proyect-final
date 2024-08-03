<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

include 'config.php';

// Crear el directorio 'uploads' si no existe
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Manejar la subida del archivo
    $image = $_FILES['image'];
    $image_name = basename($image['name']);
    $image_path = 'uploads/' . $image_name;

    if (move_uploaded_file($image['tmp_name'], $image_path)) {
        $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image_path')";
        if (mysqli_query($conn, $sql)) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir producto</title>
    <link rel="stylesheet" href="../css/addproduct.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>GAMERTEC C.O</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="../priv/dashboard.php">Panel</a></li>
                    <li><a href="../publico/logout.php">Salir</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <form method="post" enctype="multipart/form-data" action="">
            <h2>Añadir producto</h2>
            Nombre: <input type="text" name="name" required><br>
            Descripcion: <textarea name="description" required></textarea><br>
            Precio: <input type="number" step="0.01" name="price" required><br>
            Imagen: <input type="file" name="image" accept="image/*" required><br>
            <input type="submit" value="Add Product">
        </form>
    </div>
</body>
</html>
