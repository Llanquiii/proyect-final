<?php
session_start();
include 'priv/config.php';

// Crear el directorio 'uploads' si no existe
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Store - Products</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>GAMERTEC C.O</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <li><a href="priv/dashboard.php">Panel</a></li>
                        <li><a href="publico/logout.php">Salir</a></li>
                    <?php else : ?>
                        <li><a href="publico/login.php">Loguearse</a></li>
                        <li><a href="publico/register.php">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>Nuestros productos</h2>
        <div class="product-gallery">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($product = mysqli_fetch_assoc($result)) {
                    echo "<div class='product-item'>";
                    echo "<img src='" . $product['image'] . "' alt='" . $product['name'] . "'>";
                    echo "<h3>" . $product['name'] . "</h3>";
                    echo "<p>" . $product['description'] . "</p>";
                    echo "<p>Price: $" . $product['price'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
