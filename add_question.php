<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to add questions.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get quiz ID and question data from form
    $quiz_id = $_POST['quiz_id']; 
    $question_text = $_POST['question_text'];

    // Insert question into the database
    $stmt = $conn->prepare("INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)");
    $stmt->bind_param("is", $quiz_id, $question_text);

    if ($stmt->execute()) {
        // Redirect to a page where the user can add answers to the question
        header("Location: add_answer.php?question_id=" . $conn->insert_id);
        exit();
    } else {
        echo "Error adding question: " . $stmt->error;
    }
}
?>
