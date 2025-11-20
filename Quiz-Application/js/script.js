// Quiz state variables
let currentQuestionIndex = 0;
let userAnswers = [];
let timeSpent = [];
let timer;
let timeLeft;
let quizSubmitted = false;

// Initialize the quiz
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - initializing quiz');
    console.log('Available quizData:', window.quizData);
    
    // Check if quiz data is available
    if (!window.quizData || !window.quizData.questions) {
        console.error('Quiz data not loaded properly');
        document.getElementById('question-text').textContent = 'Error loading quiz data. Please go back and try again.';
        return;
    }
    
    // Initialize arrays from PHP data
    userAnswers = [...window.quizData.user_answers];
    timeSpent = [...window.quizData.time_spent];
    currentQuestionIndex = window.currentQuestionIndex || 0;
    
    console.log('Questions loaded:', window.quizData.questions.length);
    console.log('First question:', window.quizData.questions[0]);
    
    // Show first question
    showQuestion(currentQuestionIndex);
    
    // Add event listeners
    document.getElementById('prev-btn').addEventListener('click', showPreviousQuestion);
    document.getElementById('next-btn').addEventListener('click', showNextQuestion);
    document.getElementById('submit-quiz').addEventListener('click', submitQuiz);
});

// Display a question
function showQuestion(index) {
    if (quizSubmitted) return;
    
    console.log('Showing question:', index);
    
    if (!window.quizData.questions[index]) {
        console.error('Question data not available for index:', index);
        document.getElementById('question-text').textContent = 'Error loading question.';
        return;
    }
    
    // Reset timer
    clearInterval(timer);
    timeLeft = window.timePerQuestion;
    updateTimerDisplay();
    
    // Start timer
    timer = setInterval(() => {
        if (quizSubmitted) {
            clearInterval(timer);
            return;
        }
        
        timeLeft--;
        updateTimerDisplay();
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            // Record time spent
            timeSpent[index] = window.timePerQuestion;
            
            // Auto-advance or submit
            if (index === window.quizData.questions.length - 1) {
                submitQuiz();
            } else {
                showNextQuestion();
            }
        }
    }, 1000);
    
    // Update progress bar
    const progress = ((index + 1) / window.quizData.questions.length) * 100;
    document.getElementById('quiz-progress').style.width = `${progress}%`;
    
    // Show/hide navigation buttons
    document.getElementById('prev-btn').classList.toggle('hidden', index === 0);
    document.getElementById('next-btn').classList.toggle('hidden', index === window.quizData.questions.length - 1);
    document.getElementById('submit-quiz').classList.toggle('hidden', index !== window.quizData.questions.length - 1);
    
    // Update current question index
    document.getElementById('current-question').value = index;
    currentQuestionIndex = index;
    
    // Display question
    const question = window.quizData.questions[index];
    document.getElementById('question-text').textContent = `${index + 1}. ${question.question}`;
    
    // Display options
    const optionsContainer = document.getElementById('options-container');
    optionsContainer.innerHTML = '';
    
    question.options.forEach((option, i) => {
        const optionElement = document.createElement('div');
        optionElement.classList.add('option');
        if (userAnswers[index] === i) {
            optionElement.classList.add('selected');
        }
        optionElement.textContent = option;
        optionElement.addEventListener('click', () => selectOption(i));
        optionsContainer.appendChild(optionElement);
    });
}

// Update timer display
function updateTimerDisplay() {
    const timerDisplay = document.getElementById('timer');
    timerDisplay.textContent = `Time: ${timeLeft}s`;
    
    if (timeLeft <= 10) {
        timerDisplay.style.color = '#dc3545';
        timerDisplay.style.fontWeight = 'bold';
    } else if (timeLeft <= 20) {
        timerDisplay.style.color = '#ffc107';
    } else {
        timerDisplay.style.color = '#4a6ee0';
    }
}

// Select an option
function selectOption(optionIndex) {
    if (quizSubmitted) return;
    
    userAnswers[currentQuestionIndex] = optionIndex;
    
    // Update UI to show selected option
    const options = document.querySelectorAll('.option');
    options.forEach((option, i) => {
        if (i === optionIndex) {
            option.classList.add('selected');
        } else {
            option.classList.remove('selected');
        }
    });
}

// Show previous question
function showPreviousQuestion() {
    if (currentQuestionIndex > 0 && !quizSubmitted) {
        // Record time spent on current question
        timeSpent[currentQuestionIndex] = window.timePerQuestion - timeLeft;
        currentQuestionIndex--;
        showQuestion(currentQuestionIndex);
    }
}

// Show next question
function showNextQuestion() {
    if (currentQuestionIndex < window.quizData.questions.length - 1 && !quizSubmitted) {
        // Record time spent on current question
        timeSpent[currentQuestionIndex] = window.timePerQuestion - timeLeft;
        currentQuestionIndex++;
        showQuestion(currentQuestionIndex);
    }
}

// Submit the quiz
function submitQuiz() {
    if (quizSubmitted) return;
    
    quizSubmitted = true;
    clearInterval(timer);
    
    // Record time spent on current question
    timeSpent[currentQuestionIndex] = window.timePerQuestion - timeLeft;
    
    // Prepare data for submission
    document.getElementById('user-answers').value = JSON.stringify(userAnswers);
    document.getElementById('time-spent').value = JSON.stringify(timeSpent);
    
    // Submit the form
    document.getElementById('quiz-form').submit();
}