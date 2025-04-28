<?php
session_start();  // Start the session

// Include the database connection file
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debugging
    echo "Username: " . $username . "<br>";
    echo "Password: " . $password . "<br>";

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging
    echo "Rows found: " . $result->num_rows . "<br>";

   /* if ($result->num_rows > 0) {
        // If user is found, set session and redirect to dashboard
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../dashboard.html");
        exit();
    } else {
        echo "User not found or incorrect credentials.";
    }*/
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Set the session user_id after successful login
        $_SESSION['user_id'] = $row['id']; 
        header("Location: ../dashboard.html");  // Redirect to dashboard after login
        exit();
    } else {
        echo "User not found or incorrect credentials.";
    }
}
?>
