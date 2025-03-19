<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Quickzzes</title>
    <link rel="stylesheet" href="editQuizStyle.css">
    <?php
    $conn = new mysqli("localhost", "root", "", "database");
    ?>
    
</head>
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

            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $quizz_id = $_POST['quiz_id'];
                $quizz_name = $_POST['quiz_name'];
                // echo $quizz_id;
            }
            
            // echo '<script>console.log("User Level: ' . addslashes($user_level) . '");</script>';
            ?>
            <h2>Hello, <?php echo htmlspecialchars($name); ?>!</h2>
            <h3 id="instruction"> Edit your quiz below, THE ANSWERS YOU CHOOSE WILL BE THE CORRECT ANSWERS. You can't add or remove questions (for now), try creating a new quiz instead.</h3>
        </div>
    </div>
    
    <form id="quizForm" action="manageQuiz.php" method="POST">
        <?php
        //query for every answer: SELECT questions.question_id, questions.question_text, questions.quizz_id, answers.answer FROM questions, answers WHERE questions.question_id = answers.question_id AND question.question_id = ?;
        //query for every question: SELECT questions.question_id, questions.question_text, questions.quizz_id FROM questions WHERE questions.quizz_id = ?;
            $query = $conn->prepare("SELECT questions.question_id, questions.question_text, questions.quizz_id FROM questions WHERE questions.quizz_id = ?");
            $query->bind_param("i", $quizz_id);
            $query->execute();
            $result = $query->get_result();
            $questionCounter = $result->num_rows;
            foreach ($result as $row) {
                
        ?>
                <div class="questionContainer">
                <input class="questionField" type="text" name="<?php echo htmlspecialchars($row['question_id']). '_question'?>" value="<?php echo htmlspecialchars($row['question_text'])?>" required>

                <div class = "answerContainer">
                <?php
                $query2 = $conn->prepare("SELECT questions.question_id, questions.question_text, questions.quizz_id, answers.answer, answers.correct, answers.answer_id FROM questions, answers WHERE questions.question_id = answers.question_id AND questions.question_id = ?");
                $query2->bind_param("i", $row['question_id']);
                $query2->execute();
                $result2 = $query2->get_result();

                foreach ($result2 as $row2) { 
                ?>  
                    <label class="radioAnswer">
                    <input type="radio" name="<?php echo $row['question_id']. '_radio'?>" value="<?php echo $row2['answer_id']?>" required> 
                    <input class="answerField" type="text" name="<?php echo htmlspecialchars($row2['answer_id']). '_answer'?>" value="<?php echo htmlspecialchars($row2['answer'])?>" required>
                   
                    </label> 
                <?php
                }
                ?>
                </div>
                </div>
                <?php
            }
        ?>
        </div>
        <input type="hidden" id="userId" name="userId" value="<?php echo $user_id?>">
        <input type="hidden" id="quizName" name="quizName" value="<?php echo $quizz_name?>">
        <input type="hidden" id="quizId" name="quizId" value="<?php echo $quizz_id?>">
        <input type="hidden" id="questionCounter" name="questionCounter" value="<?php echo $questionCounter?>">
        <input type="hidden" name="formType" value="editQuiz">
        <button id="submitButton" type="submit" class="submitButton">
        <span class="icon">✔</span> Save changes
        </button>
    </form>
</body>
<script type="module" src="editQuizScript.js"></script>
</html>
