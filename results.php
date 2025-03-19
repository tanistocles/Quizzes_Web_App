<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Quickzzes</title>
    <link rel="stylesheet" href="resultsStyle.css">   
</head>

<?php
$conn = new mysqli("localhost", "root", "", "database");
?>

<body>
    <header>
        <h1>Welcome to Quickzzes!</h1>
    </header>
    <nav>
        <a href="mainPage.php">Home</a>
        <!-- <a href="profile.php">Profile</a>
        <a href="settings.php">Settings</a> -->
        <a href="index.php">Logout</a>
    </nav>
    <div class="container">
        <div class="welcome">
            <?php
            session_start();
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
                header("Location: index.php");
                exit();
            }
            $user_id = $_SESSION['user_id'];
            $email = $_SESSION['email'];
            $user_level = $_SESSION['user_level'];

            $parts = explode("@", $email);
            $name = $parts[0];
            
            // echo '<script>console.log("User Level: ' . addslashes($user_level) . '");</script>';
            ?>
            <h2>Hello, <?php echo htmlspecialchars($name); ?>!</h2>
            <h3 id="instruction"> See your results below.</h3>
        </div>
    </div>
    
    <?php
        $query = $conn->prepare("SELECT results.quiz_name, results.question_total, results.question_correct FROM results WHERE student_id = ?;");
        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();
        foreach ($result as $row) {        
    ?>
            <div class="resultCard">
            <h4 class="quizName">Quiz Name: <?php echo htmlspecialchars($row['quiz_name'])?></h4>
            <p class="totalQuestions">Total Questions: <?php echo htmlspecialchars($row['question_total'])?></p>
            <p class="correctAnswers">Correct Answers: <?php echo htmlspecialchars($row['question_correct'])?></p>
            </div>
    <?php
        }
    ?>

</body>
</html>
