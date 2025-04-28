<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die("Error: Invalid request method.");
}

if (!isset($_POST['title']) || empty(trim($_POST['title']))) {
    die("Error: Quiz title is required.");
}

if (!isset($_POST['questions']) || empty($_POST['questions'])) {
    die("Error: At least one question must be added.");
}

$title = trim($_POST['title']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO quizzes (title, creator_id) VALUES (?, ?)");
if (!$stmt) {
    die("Error preparing quiz insert statement: " . $conn->error);
}
$stmt->bind_param("si", $title, $user_id);

if (!$stmt->execute()) {
    die("Error inserting quiz: " . $stmt->error);
}

$quiz_id = $stmt->insert_id;
$stmt->close();

foreach ($_POST['questions'] as $q) {
    if (
        empty(trim($q['question'])) ||
        empty(trim($q['option1'])) ||
        empty(trim($q['option2'])) ||
        empty(trim($q['option3'])) ||
        empty(trim($q['option4'])) ||
        !isset($q['correct_option'])
    ) {
        continue;
    }

    $question = trim($q['question']);
    $option1 = trim($q['option1']);
    $option2 = trim($q['option2']);
    $option3 = trim($q['option3']);
    $option4 = trim($q['option4']);
    $correct_option = (int) $q['correct_option'];

    $stmt_q = $conn->prepare("INSERT INTO questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt_q) {
        die("Error preparing question insert statement: " . $conn->error);
    }
    $stmt_q->bind_param("isssssi", $quiz_id, $question, $option1, $option2, $option3, $option4, $correct_option);

    if (!$stmt_q->execute()) {
        die("Error inserting question: " . $stmt_q->error);
    }

    $stmt_q->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Created</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #a8edea, #fed6e3);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 50px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
        }
        h2 {
            color: #06d6a0;
        }
        p {
            font-size: 18px;
            margin-top: 20px;
            color: #073b4c;
        }
        a {
            text-decoration: none;
            background-color: #118ab2;
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: bold;
            margin: 10px;
            display: inline-block;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #06d6a0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Quiz Created Successfully! 🎉</h2>
    <p>
        <a href="../create_quiz.html">Create Another Quiz</a> 
        <a href="../take_quiz.php">Take a Quiz</a>
        <a href="../dashboard.html">Back to Dashboard</a>
    </p>
</div>

</body>
</html>
