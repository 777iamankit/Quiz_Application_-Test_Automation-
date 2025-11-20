<?php
include 'config.php';
include 'includes/questions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswers = json_decode($_POST['user_answers'], true);
    $timeSpent = json_decode($_POST['time_spent'], true);
    
    $quizData = $_SESSION['quiz_data'];
    $questions = $quizData['questions'];
    
    $results = [];
    $correctCount = 0;
    
    foreach ($questions as $index => $question) {
        $userAnswer = $userAnswers[$index];
        $isCorrect = ($userAnswer == $question['answer']);
        
        if ($isCorrect) {
            $correctCount++;
        }
        
        $results[] = [
            'question' => $question['question'],
            'user_answer' => $userAnswer !== null ? $question['options'][$userAnswer] : 'Not answered',
            'correct_answer' => $question['options'][$question['answer']],
            'is_correct' => $isCorrect,
            'time_spent' => $timeSpent[$index]
        ];
    }
    
    $totalQuestions = count($questions);
    $score = round(($correctCount / $totalQuestions) * 100);
    
    // Clear session data
    unset($_SESSION['quiz_data']);
    unset($_SESSION['current_question']);
} else {
    // Redirect to index if accessed directly
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results - Dynamic Quiz Application</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Quiz Results</h1>
            <p>Here's how you performed</p>
        </header>

        <div class="card">
            <h2>Quiz Summary</h2>
            
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-label">Total Questions</div>
                    <div class="stat-value"><?php echo $totalQuestions; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Correct Answers</div>
                    <div class="stat-value correct"><?php echo $correctCount; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Incorrect Answers</div>
                    <div class="stat-value incorrect"><?php echo $totalQuestions - $correctCount; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Score</div>
                    <div class="stat-value"><?php echo $score; ?>%</div>
                </div>
            </div>

            <h3>Performance Analysis</h3>
            <div class="chart-container">
                <canvas id="performance-chart"></canvas>
            </div>

            <h3>Time Spent Per Question</h3>
            <div class="chart-container">
                <canvas id="time-chart"></canvas>
            </div>

            <h3>Detailed Results</h3>
            <div id="detailed-results">
                <?php foreach ($results as $index => $result): ?>
                    <div class="result-item">
                        <div class="question-text"><?php echo ($index + 1) . '. ' . $result['question']; ?></div>
                        <div class="<?php echo $result['is_correct'] ? 'correct' : 'incorrect'; ?>">
                            Your answer: <?php echo $result['user_answer']; ?> 
                            <?php echo $result['is_correct'] ? '✓' : '✗ (Correct: ' . $result['correct_answer'] . ')'; ?>
                        </div>
                        <div class="time-spent">Time spent: <?php echo $result['time_spent']; ?>s</div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php" class="btn">Take Another Quiz</a>
            </div>
        </div>
    </div>

    <script>
        // Pass PHP data to JavaScript for charts
        const resultsData = {
            correct: <?php echo $correctCount; ?>,
            incorrect: <?php echo $totalQuestions - $correctCount; ?>,
            timeSpent: <?php echo json_encode(array_column($results, 'time_spent')); ?>,
            labels: <?php echo json_encode(range(1, $totalQuestions)); ?>
        };
    </script>
    <script src="js/results.js"></script>
</body>
</html>