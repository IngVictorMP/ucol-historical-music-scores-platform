<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username/email and password from the form
    $usernameOrEmail = $_POST["username"];
    $password = $_POST["password"];

    // Perform authentication (replace this with your actual authentication logic)
    // Assuming you're using PDO for database access
    $pdo = new PDO('mysql:host=localhost;dbname=db_poudc', 'root', '');
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE (id_usuario = ? OR email = ?) AND password = ?");
    $stmt->execute([$usernameOrEmail, $usernameOrEmail, $password]);
    $user = $stmt->fetch();

    if ($user) {
        // Authentication successful
        // Start a session and redirect to index.html
        session_start();
        $_SESSION["username"] = $user["username"];
        header("Location: index.html");
        exit();
    } else {
        // Authentication failed
        // Check if the username/email exists
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? OR email = ?");
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            // Username/email exists, but password is incorrect
            header("Location: index.html?error=incorrect_password");
            exit();
        } else {
            // Username/email doesn't exist
            header("Location: index.html?error=incorrect_username_or_email");
            exit();
        }
    }
} else {
    // If the form is not submitted, redirect back to the login page
    header("Location: index.html");
    exit();
}
