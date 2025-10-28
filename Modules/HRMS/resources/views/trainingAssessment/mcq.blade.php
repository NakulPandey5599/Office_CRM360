<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>MCQ Assessment</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="mcq">
  <div class="mcq-container">
    <div>
      <div class="mcq-header">MCQ Assessment: Introduction to Company Culture</div>
      <div class="mcq-sub" id="question-count">Question 1 of 5</div>
      <div id="question-container"></div>
    </div>

    <!-- Buttons -->
    <div class="btn-group1">
      <button class="btn back-btn" onclick="prevQuestion()">Back</button>
      <button class="btn reset-btn" onclick="resetForm()">Reset</button>
      <button class="btn submit-btn" onclick="submitAnswer()">Submit</button>
      <button class="btn next-btn" onclick="nextQuestion()">Next</button>
    </div>
  </div>

  <script>
    const questions = [
      {
        text: "What is the primary focus of our company's mission?",
        options: [
          "Maximizing shareholder profits",
          "Delivering exceptional customer service",
          "Expanding our market presence globally",
          "Developing innovative products"
        ]
      },
      {
        text: "Which of the following best describes our work culture?",
        options: [
          "Rigid and hierarchical",
          "Flexible and collaborative",
          "Competitive and secretive",
          "Individualistic and isolated"
        ]
      },
      {
        text: "What value does our company prioritize most?",
        options: [
          "Transparency",
          "Profit above all",
          "Short-term goals",
          "Exclusivity"
        ]
      },
      {
        text: "How often are team-building events organized?",
        options: [
          "Never",
          "Once a year",
          "Quarterly",
          "Monthly"
        ]
      },
      {
        text: "Which phrase best reflects our vision?",
        options: [
          "To dominate all competitors",
          "To create meaningful impact through innovation",
          "To maintain the status quo",
          "To reduce expenses wherever possible"
        ]
      }
    ];

    let currentQuestion = 0;
    const answers = {};
    const questionContainer = document.getElementById("question-container");
    const questionCount = document.getElementById("question-count");

    // Load the first question
    loadQuestion();

    function loadQuestion() {
      const q = questions[currentQuestion];
      questionCount.textContent = `Question ${currentQuestion + 1} of ${questions.length}`;

      questionContainer.innerHTML = `
        <div class="mcq-question">${q.text}</div>
        <div class="options">
          ${q.options.map((opt, i) => `
            <label class="option">
              <input type="radio" name="q${currentQuestion}" value="${opt}" ${
                answers[currentQuestion] === opt ? "checked" : ""
              }> ${opt}
            </label>
          `).join("")}
        </div>
      `;
    }

    function resetForm() {
      document.querySelectorAll(`input[name="q${currentQuestion}"]`)
        .forEach(el => el.checked = false);
      delete answers[currentQuestion];
    }

    function prevQuestion() {
      if (currentQuestion > 0) {
        currentQuestion--;
        loadQuestion();
      }
    }

    function submitAnswer() {
      const selected = document.querySelector(`input[name="q${currentQuestion}"]:checked`);
      if (selected) {
        answers[currentQuestion] = selected.value;
      } else {
        alert("Please select an option before submitting!");
        return;
      }

      if (currentQuestion < questions.length - 1) {
        currentQuestion++;
        loadQuestion();
      } else {
        finishQuiz(); // ✅ Trigger only on last question
      }
    }

    function nextQuestion() {
      const selected = document.querySelector(`input[name="q${currentQuestion}"]:checked`);
      if (selected) {
        answers[currentQuestion] = selected.value;
      }

      if (currentQuestion < questions.length - 1) {
        currentQuestion++;
        loadQuestion();
      } else {
        finishQuiz();
      }
    }

    // ✅ Show popup when finished
function finishQuiz() {
  const formattedAnswers = {};
  
  // Shift question numbers to start from 1
  Object.keys(answers).forEach(key => {
    formattedAnswers[parseInt(key) + 1] = answers[key];
  });

  const summary = Object.values(formattedAnswers)
    .map((ans, i) => `Q${i + 1}: ${ans || "❌ Skipped"}`)
    .join("\n");

  // Show confirmation popup
  // alert("Submitting your answers...\n\n" + summary);

  // Send formatted answers to backend
  fetch("/training/submit", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(formattedAnswers)
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
  })
  .catch(err => {
    console.error(err);
    alert("❌ Error saving responses. Check console for details.");
  });
}

  </script>
</body>
</html>