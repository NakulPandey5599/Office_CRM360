<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MCQ Assessment - {{ $module->title ?? 'Training Module' }}</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f9fafb;
      color: #111827;
      margin: 0;
      padding: 0;
    }
    .mcq-container {
      max-width: 750px;
      margin: 50px auto;
      background: #fff;
      border-radius: 12px;
      padding: 30px 40px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    .mcq-header {
      font-size: 22px;
      font-weight: 700;
      color: #2563eb;
      margin-bottom: 5px;
    }
    .mcq-sub {
      font-size: 14px;
      color: #6b7280;
      margin-bottom: 25px;
    }
    .mcq-question {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 18px;
    }
    .options label {
      display: block;
      padding: 12px;
      margin-bottom: 10px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #f3f4f6;
      cursor: pointer;
      transition: all 0.25s ease;
    }
    .options label:hover {
      background: #e5e7eb;
    }
    .options input[type="radio"] {
      margin-right: 10px;
    }
    .btn-group1 {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
    .btn {
      padding: 10px 18px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .back-btn { background: #9ca3af; color: white; }
    .reset-btn { background: #f59e0b; color: white; }
    .submit-btn { background: #10b981; color: white; }
    .next-btn { background: #2563eb; color: white; }
    .btn:hover { opacity: 0.9; }
    .result-box {
      text-align: center;
      padding: 20px;
      background: #ecfdf5;
      border-radius: 8px;
      color: #065f46;
      font-weight: 600;
      display: none;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="mcq-container">
    <div>
      <div class="mcq-header">MCQ Assessment: {{ $module->title ?? 'Training Module' }}</div>
      <div class="mcq-sub" id="question-count">Question 1 of {{ count($mcqs) }}</div>
      <div id="question-container"></div>
    </div>

```
<!-- Buttons -->
<div class="btn-group1">
  <button class="btn back-btn" onclick="prevQuestion()">Back</button>
  <button class="btn reset-btn" onclick="resetForm()">Reset</button>
  <button class="btn submit-btn" onclick="submitAnswer()">Submit</button>
  <button class="btn next-btn" onclick="nextQuestion()">Next</button>
</div>

<div id="resultBox" class="result-box"></div>
```

  </div>

  <script>
    // ✅ Dynamically loaded MCQs from backend
    const questions = @json(
    $mcqs->map(function($q) {
      return [
        'id' => $q->id,
        'text' => $q->question,
        'options' => [
          'A' => $q->option_a,
          'B' => $q->option_b,
          'C' => $q->option_c,
          'D' => $q->option_d,
        ],
        'correct' => $q->correct_option,
      ];
    })
  );

    let currentQuestion = 0;
    const answers = {};
    const questionContainer = document.getElementById("question-container");
    const questionCount = document.getElementById("question-count");
    const resultBox = document.getElementById("resultBox");

    loadQuestion();

    function loadQuestion() {
      const q = questions[currentQuestion];
      questionCount.textContent = `Question ${currentQuestion + 1} of ${questions.length}`;
      resultBox.style.display = 'none';

      questionContainer.innerHTML = `
        <div class="mcq-question">${q.text}</div>
        <div class="options">
          ${Object.entries(q.options).map(([key, opt]) => `
            <label>
              <input type="radio" name="q${currentQuestion}" value="${key}" ${
                answers[currentQuestion] === key ? "checked" : ""
              }> (${key}) ${opt}
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
        finishQuiz();
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

    // ✅ Final Quiz Submission
    function finishQuiz() {
      const formattedAnswers = {};
      Object.keys(answers).forEach((key) => {
        formattedAnswers[questions[key].id] = answers[key];
      });

      // Calculate Score Client-side
      let correctCount = 0;
      Object.keys(answers).forEach((key) => {
        if (answers[key] === questions[key].correct) {
          correctCount++;
        }
      });
      const total = questions.length;
      const score = `${correctCount} / ${total}`;
      resultBox.style.display = 'block';
      resultBox.textContent = `✅ You scored ${score}`;

      // Send to backend (optional)
      fetch("{{ route('training.submitMcq') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          module_id: "{{ $module->id }}",
          answers: formattedAnswers,
          score: score
        })
      })
      .then(res => res.json())
      .then(data => console.log(data))
      .catch(err => console.error(err));
    }
  </script>

</body>
</html>
