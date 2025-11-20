package quiz;

import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.*;
import java.io.File;
import java.io.IOException;
import java.time.Duration;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.apache.commons.io.FileUtils;
import io.github.bonigarcia.wdm.WebDriverManager;

public class QuizTest {

    static WebDriver driver;

    public static void main(String[] args) throws Exception {
        // Use WebDriverManager to automatically download and setup ChromeDriver
        WebDriverManager.chromedriver().setup();
        
        driver = new ChromeDriver();
        driver.manage().window().maximize();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(10));

        // Create directories
        new File("screenshots").mkdirs();
        new File("logs").mkdirs();

        log("=== Quiz Automation Test Started ===");

        try {
            // 1. Verify Landing Page
            log("Step 1: Verifying Landing Page");
            driver.get("http://localhost:8000");
            Thread.sleep(2000);
            screenshot("1_LandingPage");

            String pageTitle = driver.getTitle();
            String currentUrl = driver.getCurrentUrl();
            
            System.out.println("URL: " + currentUrl);
            System.out.println("Page Title: " + pageTitle);
            log("Landing Page Loaded - URL: " + currentUrl + ", Title: " + pageTitle);

            // Select category and difficulty
            Select categorySelect = new Select(driver.findElement(By.id("category")));
            categorySelect.selectByValue("general");
            
            Select difficultySelect = new Select(driver.findElement(By.id("difficulty")));
            difficultySelect.selectByValue("easy");
            
            log("Selected Category: General, Difficulty: Easy");

            // 2. Start Quiz
            log("Step 2: Starting Quiz");
            driver.findElement(By.cssSelector("button[type='submit']")).click();
            
            Thread.sleep(2000);
            screenshot("2_QuizStarted");
            log("Quiz Started Successfully");

            // 3. Answer Each Question
            log("Step 3: Answering Questions");
            int questionCount = 0;
            
            while (questionCount < 5) {
                questionCount++;
                
                try {
                    WebElement questionElement = driver.findElement(By.className("question-text"));
                    String questionText = questionElement.getText();
                    System.out.println("Question " + questionCount + ": " + questionText);
                    log("Processing Question " + questionCount + ": " + questionText);

                    // Select answer option
                    java.util.List<WebElement> options = driver.findElements(By.className("option"));
                    if (options.size() > 2) {
                        options.get(2).click();
                        log("Selected answer option 3 for Question " + questionCount);
                    } else if (options.size() > 0) {
                        options.get(0).click();
                        log("Selected answer option 1 for Question " + questionCount);
                    }

                    screenshot("3_Question_" + questionCount);

                    // Check if last question
                    try {
                        WebElement submitButton = driver.findElement(By.id("submit-quiz"));
                        if (submitButton.isDisplayed()) {
                            log("Reached final question");
                            break;
                        }
                    } catch (Exception e) {
                        // Continue to next question
                    }

                    // Click Next button
                    if (questionCount < 5) {
                        driver.findElement(By.id("next-btn")).click();
                        Thread.sleep(1000);
                    }
                } catch (Exception e) {
                    log("Error on question " + questionCount + ": " + e.getMessage());
                    break;
                }
            }

            // 4. Submit Quiz
            log("Step 4: Submitting Quiz");
            driver.findElement(By.id("submit-quiz")).click();
            Thread.sleep(2000);
            screenshot("4_QuizSubmitted");
            log("Quiz Submitted");

            // 5. Validate Results
            log("Step 5: Validating Results");
            
            WebElement totalQuestions = driver.findElement(By.id("total-questions"));
            WebElement correctAnswers = driver.findElement(By.id("correct-answers"));
            WebElement score = driver.findElement(By.id("score"));

            System.out.println("=== Quiz Results ===");
            System.out.println("Total Questions: " + totalQuestions.getText());
            System.out.println("Correct Answers: " + correctAnswers.getText());
            System.out.println("Score: " + score.getText());
            
            log("Results - Total: " + totalQuestions.getText() + 
                ", Correct: " + correctAnswers.getText() + 
                ", Score: " + score.getText());

            screenshot("5_FinalResults");
            log("=== Test Completed Successfully ===");

        } catch (Exception e) {
            log("❌ Test Failed with Error: " + e.getMessage());
            e.printStackTrace();
            screenshot("ERROR_" + System.currentTimeMillis());
        } finally {
            if (driver != null) {
                driver.quit();
                log("Browser closed");
            }
        }
    }

    public static void screenshot(String name) throws IOException {
        File src = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
        File target = new File("screenshots/" + name + ".png");
        FileUtils.copyFile(src, target);
        log("Screenshot saved: " + name);
    }

    public static void log(String text) throws IOException {
        System.out.println(text);
        FileUtils.writeStringToFile(new File("logs/selenium.log"), 
            java.time.LocalDateTime.now() + " - " + text + "\n", "UTF-8", true);
    }
}