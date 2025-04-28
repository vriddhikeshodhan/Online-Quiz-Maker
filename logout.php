<?php
session_start();  // Start the session
session_destroy();  // Destroy the session to log the user out
header("Location: ../index.html");  // Redirect to homepage after logout
exit();
?>
