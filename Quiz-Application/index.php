<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Quiz Application</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Dynamic Quiz Application</h1>
            <p>Test your knowledge with our interactive quiz platform</p>
        </header>

        <div class="card">
            <h2>Quiz Setup</h2>
            <form action="quiz.php" method="POST">
                <div class="form-group">
                    <label for="category">Select Category:</label>
                    <select id="category" name="category" required>
                        <option value="general">General Knowledge</option>
                        <option value="science">Science</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="difficulty">Select Difficulty:</label>
                    <select id="difficulty" name="difficulty" required>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
                <button type="submit" class="btn">Start Quiz</button>
            </form>
        </div>

        <footer>
            <p>Dynamic Quiz Application &copy; 2023</p>
        </footer>
    </div>
</body>
</html>