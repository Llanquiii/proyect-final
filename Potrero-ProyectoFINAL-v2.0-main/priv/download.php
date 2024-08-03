<?php
include 'config.php';
$id = $_GET['id'];

$sql = "SELECT * FROM files WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$file = mysqli_fetch_assoc($result);

if (file_exists($file['filepath'])) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file['filepath']));
    header('Content-Length: ' . filesize($file['filepath']));
    readfile($file['filepath']);
    exit();
} else {
    echo "File not found.";
}
?>
