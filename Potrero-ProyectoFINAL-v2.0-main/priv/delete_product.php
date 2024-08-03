<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

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

header("Location: dashboard.php");
exit();
?>
