<?php
include 'backend/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take a Quiz</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fbeaff, #fff6cc);
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            padding: 30px;
            max-width: 700px;
            margin: auto;
            background: white;
            border-radius: 20px;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h1, h2 {
            color: #6a0dad;
        }
        a, button {
            background-color: #6a0dad;
            color: white;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            display: inline-block;
        }
        a:hover, button:hover {
            background-color: #9b30ff;
        }
        select {
            padding: 10px;
            width: 80%;
            margin-top: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        form {
            margin-top: 30px;
        }
        h3 {
            margin-top: 20px;
            color: #444;
        }
        input[type="radio"] {
            margin: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Select a Quiz to Take</h1>

    <?php
    // Display available quizzes
    if (!isset($_GET['quiz_id'])) {
        $result = $conn->query("SELECT * FROM quizzes");
        while ($quiz = $result->fetch_assoc()) {
            echo "<div><a href='take_quiz.php?quiz_id=".$quiz['id']."'>".$quiz['title']."</a></div>";
        }
    }

    // If user clicked a quiz
    if (isset($_GET['quiz_id'])) {
        $quiz_id = $_GET['quiz_id'];

        // Fetch questions
        $questions = $conn->query("SELECT * FROM questions WHERE quiz_id=$quiz_id");

        if ($questions->num_rows > 0) {
            echo "<form method='POST' action='submit_quiz.php'>";
            echo "<input type='hidden' name='quiz_id' value='$quiz_id'>";
            while ($q = $questions->fetch_assoc()) {
                echo "<h3>".$q['question']."</h3>";
                echo "<input type='radio' name='answers[".$q['id']."]' value='1' required> ".$q['option1']."<br>";
                echo "<input type='radio' name='answers[".$q['id']."]' value='2'> ".$q['option2']."<br>";
                echo "<input type='radio' name='answers[".$q['id']."]' value='3'> ".$q['option3']."<br>";
                echo "<input type='radio' name='answers[".$q['id']."]' value='4'> ".$q['option4']."<br><br>";
            }
            echo "<button type='submit'>Submit Quiz</button>";
            echo "</form>";
        } else {
            echo "<p><b>No questions found for this quiz yet.</b></p>";
        }
    }
    ?>

    <br><br>
    <a href="dashboard.html">Back to Dashboard</a>
</div>

</body>
</html>
