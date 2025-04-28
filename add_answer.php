<?php
session_start();
include('db.php');

// Get question ID from URL
$question_id = $_GET['question_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get answer data from the form
    $answer_text = $_POST['answer_text'];
    $is_correct = $_POST['is_correct'] == 'on' ? 1 : 0;  // Checkbox for correct answer

    // Insert answer into the database
    $stmt = $conn->prepare("INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $question_id, $answer_text, $is_correct);

    if ($stmt->execute()) {
        echo "Answer added successfully!";
    } else {
        echo "Error adding answer: " . $stmt->error;
    }
}
?>
