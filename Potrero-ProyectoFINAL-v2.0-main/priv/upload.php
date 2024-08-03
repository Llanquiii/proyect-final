<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $filename = $_FILES['file']['name'];
    $filepath = 'uploads/' . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
        $uploaded_by = $_SESSION['username'];
        $sql = "INSERT INTO files (filename, filepath, uploaded_by) VALUES ('$filename', '$filepath', '$uploaded_by')";
        if (mysqli_query($conn, $sql)) {
            echo "File uploaded successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1>Hardware Store</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="../publico/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <form method="post" enctype="multipart/form-data" action="">
            <h2>Upload File</h2>
            <input type="file" name="file" required><br>
            <input type="submit" value="Upload File">
        </form>
    </div>
</body>
</html>
