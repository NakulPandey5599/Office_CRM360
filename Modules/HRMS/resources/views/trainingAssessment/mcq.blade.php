<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>MCQ Assessment - {{ $assessment->assessment_name ?? 'Training Module' }}</title>

  <style>
    /* ===================== MCQ PAGE STYLES ===================== */

    .mcq {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background: #f0f2f5;
      --primary: #4361ee;
      --primary-light: #4895ef;
      --primary-dark: #3a0ca3;
      --bg-primary: #f8fafc;
      --bg-secondary: #f1f5f9;
      --bg-card: #ffffff;
      --text-primary: #1e293b;
      --text-secondary: #64748b;
      --border-light: #e2e8f0;
      --border-medium: #cbd5e1;
    }

    .mcq-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 600px;
      min-height: 400px;
      padding: 30px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .mcq-header {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #047edf;
    }

    .mcq-sub {
      font-size: 15px;
      color: #555;
      margin-bottom: 20px;
    }

    .mcq-question {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .options {
      flex-grow: 1;
    }

    .option {
      display: flex;
      align-items: center;
      margin-bottom: 16px;
      font-size: 16px;
      cursor: pointer;
    }

    .option input {
      margin-right: 12px;
    }

    .btn-group1 {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .btn {
      flex: 1;
      margin: 0 5px;
      padding: 12px;
      border: none;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .back-btn {
      background: #6b7280;
      color: white;
    }
    .back-btn:hover {
      background: #4b5563;
    }

    .reset-btn {
      background: #f43f5e;
      color: white;
    }
    .reset-btn:hover {
      background: #e11d48;
    }

    .submit-btn {
      background: #047edf;
      color: white;
    }
    .submit-btn:hover {
      background: #0369a1;
    }

    .next-btn {
      background: #22c55e;
      color: white;
    }
    .next-btn:hover {
      background: #16a34a;
    }

    .result-box {
      margin-top: 20px;
      text-align: center;
      padding: 12px;
      background: #dcfce7;
      color: #166534;
      border-radius: 8px;
      font-weight: 600;
      display: none;
    }
  </style>
</head>

<body class="mcq">
  <div class="mcq-container">
    @if($assessment)
      <div>
        <div class="mcq-header">MCQ Assessment: {{ $assessment->assessment_name }}</div>
        <div class="mcq-sub" id="question-count">Question 1 of {{ count($questions) }}</div>

        <div id="question-container"></div>
      </div>

      <!-- Buttons -->
      <div>
        <div class="btn-group1">
          <button class="btn back-btn" onclick="prevQuestion()">Back</button>
          <button class="btn reset-btn" onclick="resetForm()">Reset</button>
          <button class="btn submit-btn" onclick="submitAnswer()">Submit</button>
          <button class="btn next-btn" onclick="nextQuestion()">Next</button>
        </div>
        <div id="resultBox" class="result-box"></div>
      </div>
    @else
      <div>
        <div class="mcq-header">No Assessment Found</div>
        <p style="color: #555;">Please create a new assessment first.</p>
      </div>
    @endif
  </div>

  @if($assessment)
  
  <script>
  // ✅ Load questions dynamically from backend
  const questions = @json($questions);
  let currentQuestion = 0;
  const answers = {};
  const container = document.getElementById("question-container");
  const qCount = document.getElementById("question-count");
  const resultBox = document.getElementById("resultBox");

  function renderQuestion() {
    const q = questions[currentQuestion];
    qCount.textContent = `Question ${currentQuestion + 1} of ${questions.length}`;
    container.innerHTML = `
      <div class="mcq-question">${q.text}</div>
      <div class="options">
        ${Object.entries(q.options).map(([key, value]) => `
          <label class="option">
            <input type="radio" name="q${currentQuestion}" value="${key}" ${answers[currentQuestion] === key ? "checked" : ""}>
            ${key}. ${value}
          </label>
        `).join('')}
      </div>
    `;
    resultBox.style.display = "none";
  }

  function resetForm() {
    document.querySelectorAll(`input[name="q${currentQuestion}"]`).forEach(el => el.checked = false);
    delete answers[currentQuestion];
  }

  async function nextQuestion() {
    const selected = document.querySelector(`input[name="q${currentQuestion}"]:checked`);
    if (selected) answers[currentQuestion] = selected.value;
    if (currentQuestion < questions.length - 1) {
      currentQuestion++;
      renderQuestion();
    } else {
      await storeAndShowResult();
    }
  }

  function prevQuestion() {
    if (currentQuestion > 0) {
      currentQuestion--;
      renderQuestion();
    }
  }

  async function submitAnswer() {
    const selected = document.querySelector(`input[name="q${currentQuestion}"]:checked`);
    if (!selected) {
      alert("Please select an option before submitting!");
      return;
    }
    answers[currentQuestion] = selected.value;
    if (currentQuestion < questions.length - 1) {
      currentQuestion++;
      renderQuestion();
    } else {
      await storeAndShowResult();
    }
  }

  // ✅ Compute score + Store in DB automatically
  async function storeAndShowResult() {
    let correct = 0;
    Object.keys(answers).forEach((key) => {
      if (answers[key] === questions[key].correct) correct++;
    });

    const score = correct;
    const total = questions.length;
    resultBox.textContent = `✅ You scored ${score} / ${total}`;
    resultBox.style.display = "block";

    // ✅ Store in database
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    try {
      const response = await fetch("{{ route('training.storeAnswers') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({
          assessment_id: {{ $assessment->id }},
          score: score,
          total: total,
          answers: answers,
        }),
      });

      const result = await response.json();
      if (result.success) {
        console.log("✅ Result stored successfully!");
      } else {
        console.warn("⚠️ Failed to store result", result);
      }
    } catch (error) {
      console.error("❌ Error saving result:", error);
    }
  }

  // Load the first question
  renderQuestion();
</script>

  @endif
</body>
</html>
