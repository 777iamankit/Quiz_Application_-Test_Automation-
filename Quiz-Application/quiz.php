<?php
include 'config.php';
include 'includes/questions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'] ?? 'general';
    $difficulty = $_POST['difficulty'] ?? 'easy';
    
    $questions = getQuizQuestions($category, $difficulty);
    
    if (empty($questions)) {
        die("No questions found for the selected category and difficulty.");
    }
    
    // Store quiz data in session
    $_SESSION['quiz_data'] = [
        'category' => $category,
        'difficulty' => $difficulty,
        'questions' => $questions,
        'start_time' => time(),
        'user_answers' => array_fill(0, count($questions), null),
        'time_spent' => array_fill(0, count($questions), 0)
    ];
    
    $_SESSION['current_question'] = 0;
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
    <title>Quiz - Dynamic Quiz Application</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Quiz Time!</h1>
            <p>Category: <?php echo ucfirst($category); ?> | Difficulty: <?php echo ucfirst($difficulty); ?></p>
        </header>

        <div class="card">
            <div class="progress-bar">
                <div class="progress" id="quiz-progress"></div>
            </div>
            
            <div class="timer" id="timer">Time: <?php echo TIME_PER_QUESTION; ?>s</div>
            
            <form id="quiz-form" action="results.php" method="POST">
                <div class="question-container">
                    <div class="question-text" id="question-text">Loading question...</div>
                    <div class="options-container" id="options-container">
                        <div class="option">Loading options...</div>
                    </div>
                </div>
                
                <input type="hidden" id="current-question" name="current_question" value="0">
                <input type="hidden" id="user-answers" name="user_answers">
                <input type="hidden" id="time-spent" name="time_spent">
                
                <div class="navigation">
                    <button type="button" id="prev-btn" class="btn btn-secondary">Previous</button>
                    <button type="button" id="next-btn" class="btn">Next</button>
                    <button type="submit" id="submit-quiz" class="btn btn-success hidden">Submit Quiz</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Pass PHP data to JavaScript - FIXED VERSION
    window.quizData = <?php echo json_encode($_SESSION['quiz_data']); ?>;
    window.timePerQuestion = <?php echo TIME_PER_QUESTION; ?>;
    window.currentQuestionIndex = <?php echo $_SESSION['current_question']; ?>;
    
    // Debug: Log data to console
    console.log('Quiz Data:', window.quizData);
    console.log('Time per question:', window.timePerQuestion);
    console.log('Current question index:', window.currentQuestionIndex);
</script>
    <script src="js/script.js"></script>
</body>
</html>