# Online-Quiz-Maker
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quiz Platform</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
    h1, h2 {
      text-align: center;
    }
    .question {
      margin-bottom: 15px;
    }
    .options {
      margin-left: 20px;
    }
    .login, .quiz, .scoreboard, .analytics {
      display: none;
    }
    .leaderboard li {
      margin: 5px 0;
    }
    button {
      padding: 10px 15px;
      margin-top: 10px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Online Quiz Platform</h1>

    <div class="login">
      <h2>Login</h2>
      <input type="text" id="username" placeholder="Username" /><br /><br />
      <input type="password" id="password" placeholder="Password" /><br /><br />
      <button onclick="login()">Login</button>
    </div>

    <div class="quiz">
      <h2>Quiz</h2>
      <div id="quizContainer"></div>
      <button onclick="submitQuiz()">Submit Quiz</button>
      <div id="result"></div>
    </div>

    <div class="scoreboard">
      <h2>Leaderboard</h2>
      <ul id="leaderboard" class="leaderboard"></ul>
    </div>

    <div class="analytics">
      <h2>Quiz Analytics</h2>
      <p id="analyticsData"></p>
    </div>
  </div>

  <script>
    const users = [{ username: "admin", password: "1234" }];
    const quizData = [
      {
        question: "What is the capital of France?",
        options: ["Berlin", "Madrid", "Paris", "Rome"],
        answer: 2
      },
      {
        question: "Which is the largest ocean?",
        options: ["Atlantic", "Indian", "Arctic", "Pacific"],
        answer: 3
      },
      {
        question: "Who wrote 'Hamlet'?",
        options: ["Shakespeare", "Milton", "Wordsworth", "Keats"],
        answer: 0
      }
    ];
    let scores = [];
    let attempts = 0;

    const loginSection = document.querySelector(".login");
    const quizSection = document.querySelector(".quiz");
    const scoreboard = document.querySelector(".scoreboard");
    const analytics = document.querySelector(".analytics");

    loginSection.style.display = "block";

    function login() {
      const uname = document.getElementById("username").value;
      const pass = document.getElementById("password").value;

      const validUser = users.find(u => u.username === uname && u.password === pass);
      if (validUser) {
        loginSection.style.display = "none";
        quizSection.style.display = "block";
        renderQuiz();
      } else {
        alert("Invalid credentials!");
      }
    }

    function renderQuiz() {
      const container = document.getElementById("quizContainer");
      container.innerHTML = "";
      quizData.forEach((q, idx) => {
        const qDiv = document.createElement("div");
        qDiv.className = "question";
        qDiv.innerHTML = `<p>${idx + 1}. ${q.question}</p>`;
        const options = q.options.map((opt, i) =>
          `<label><input type="radio" name="q${idx}" value="${i}"> ${opt}</label><br/>`
        ).join("");
        qDiv.innerHTML += `<div class="options">${options}</div>`;
        container.appendChild(qDiv);
      });
    }

    function submitQuiz() {
      let score = 0;
      quizData.forEach((q, idx) => {
        const selected = document.querySelector(`input[name="q${idx}"]:checked`);
        if (selected && parseInt(selected.value) === q.answer) score++;
      });

      attempts++;
      scores.push(score);
      document.getElementById("result").innerHTML = `<h3>Your Score: ${score}/${quizData.length}</h3>`;

      updateLeaderboard();
      updateAnalytics();
    }

    function updateLeaderboard() {
      scoreboard.style.display = "block";
      const lb = document.getElementById("leaderboard");
      lb.innerHTML = "";
      const sorted = [...scores].sort((a, b) => b - a).slice(0, 5);
      sorted.forEach((s, i) => {
        const li = document.createElement("li");
        li.textContent = `Rank ${i + 1}: ${s} points`;
        lb.appendChild(li);
      });
    }

    function updateAnalytics() {
      analytics.style.display = "block";
      const avg = (scores.reduce((a, b) => a + b, 0) / scores.length).toFixed(2);
      document.getElementById("analyticsData").innerText =
        `Total Attempts: ${attempts}, Average Score: ${avg}`;
    }
  </script>
</body>
</html>
