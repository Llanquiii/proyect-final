<?php
include '../priv/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($conn, $sql)) {
        echo "User registered successfully!";
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
        <title>Register</title>
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
                        <li><a href="login.php">Login</a></li>
                    </ul>
                </nav>
        </div>
    </header>

    <div class="container">
        <form method="post" action="">
            <h2>Register</h2>
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            Role: 
            <select name="role">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select><br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
