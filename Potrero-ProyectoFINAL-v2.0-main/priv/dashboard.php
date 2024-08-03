<?php
session_start();
include 'config.php';

// Verificar si el usuario está logueado y es un administrador
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// Crear el directorio 'uploads' si no existe
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product_id'])) {
    $product_id = intval($_POST['delete_product_id']);
    
    // Obtener la imagen del producto
    $sql = "SELECT image FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
    $image_path = $product['image'];

    // Eliminar el producto de la base de datos
    $sql = "DELETE FROM products WHERE id = $product_id";
    if (mysqli_query($conn, $sql)) {
        // Eliminar la imagen del servidor
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        echo "Product deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>GAMERTEC C.O</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="upload.php">Subir archivos</a></li>
                    <li><a href="add_product.php">Añadir producto</a></li>
                    <li><a href="../publico/logout.php">Salir</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>Panel admin</h2>
        <p>BIENVENIDO, <?php echo $_SESSION['username']; ?>!.</p>
        
        <h2>Productos</h2>
        <?php
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($product = mysqli_fetch_assoc($result)) {
                echo "<div class='product'>";
                echo "<h2>" . $product['name'] . "</h2>";
                echo "<img src='" . $product['image'] . "' alt='" . $product['name'] . "'>";
                echo "<p>" . $product['description'] . "</p>";
                echo "<p>Price: $" . $product['price'] . "</p>";
                echo "<form method='post' action='' style='display:inline;'>
                          <input type='hidden' name='delete_product_id' value='" . $product['id'] . "'>
                          <input type='submit' value='Delete' onclick='return confirm(\"Estas seguro de eliminar este producto?\");'>
                      </form>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }
        ?>
    </div>
</body>
</html>
