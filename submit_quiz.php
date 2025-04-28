<?php
include 'backend/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: backend/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$quiz_id = $_POST['quiz_id'];
$answers = $_POST['answers'];

$score = 0;

foreach ($answers as $question_id => $selected_option) {
    $q = $conn->query("SELECT correct_option FROM questions WHERE id=$question_id")->fetch_assoc();
    if ($q['correct_option'] == $selected_option) {
        $score++;
    }
}

// Save Score
$stmt = $conn->prepare("INSERT INTO leaderboard (user_id, quiz_id, score) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $user_id, $quiz_id, $score);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Completed</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #e0bbff, #fff5ba);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        h1, h2 {
            color: #7b2cbf;
        }
        p {
            font-size: 20px;
            margin: 20px 0;
            color: #5a189a;
        }
        a {
            text-decoration: none;
            background-color: #ffb703;
            color: black;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 20px;
        }
        a:hover {
            background-color: #ffd166;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quiz Completed!</h1>
        <p>Your Score: <strong><?php echo $score; ?></strong></p>
        <a href="leaderboard.php">View Leaderboard</a>
    </div>
</body>
</html>
