<?php
include 'backend/db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard</title>
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
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 20px;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h1 {
            color: #6a0dad;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
        }
        th {
            background-color: #6a0dad;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2e6ff;
        }
        tr:hover {
            background-color: #ffe6cc;
        }
        a, button {
            background-color: #6a0dad;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
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
    </style>
</head>
<body>

<div class="container">
    <h1>Leaderboard</h1>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Quiz Title</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "
                SELECT u.username, q.title AS quiz_title, l.score 
                FROM leaderboard l
                JOIN users u ON l.user_id = u.id
                JOIN quizzes q ON l.quiz_id = q.id
                ORDER BY l.score DESC
            ";
            $result = $conn->query($sql);
            $rank = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $rank++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['quiz_title']) . "</td>";
                    echo "<td>" . $row['score'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="dashboard.html">Back to Dashboard</a>
</div>

</body>
</html>
