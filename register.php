<?php
    require 'conn.php';
    require 'bd.php';
?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
    
        if ($stmt->execute()) {
            echo "Registration successful!";
            header('Location: login.php');
        } else {
            echo "This name is taken";
        }
    
        $stmt->close();
        $conn->close();
    }
?>
<h2>Please register.</h2>
<form method="POST">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Register</button>
</form>
<a href="login.php">Click if you are logged in.</a>