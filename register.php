<?php
session_start();

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a user with the same username exists, show an error
    if ($result->num_rows > 0) {
        echo "Username already taken. Please choose another one.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect to login page after successful registration
            echo "Registration successful! Redirecting to login page...";
            header("Location: ../registration_completed.html");
            exit();

        } else {
            echo "Error registering user.";
        }
    }
}
?>
