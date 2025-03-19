<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Quickzzes</title>
    <link rel="stylesheet" href="style.css">   
</head>

<?php
$conn = new mysqli("localhost", "root", "", "database");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (($_POST['formType']) == "editQuiz") {
        $quizId = $_POST['quizId'];

        $query = $conn->prepare("SELECT * FROM questions WHERE quizz_id = ?;");
        $query->bind_param("i", $quizId);
        $query->execute();
        $result = $query->get_result();

        //update the questions
        foreach ($result as $row) {
            $question_Id = $row['question_id'];
            $updateQuery = $conn->prepare("UPDATE questions SET question_text = ? WHERE question_id = ? AND quizz_id = ?;");
            $updateQuery->bind_param("sii", $_POST[$question_Id. '_question'], $question_Id, $quizId);
            $updateQuery->execute();

            //update the answers
            $query2 = $conn->prepare("SELECT * FROM answers WHERE question_id = ?;");
            $query2->bind_param("i", $question_Id);
            $query2->execute();
            $result2 = $query2->get_result();

            foreach ($result2 as $row2) {
                $answer_Id = $row2['answer_id'];
                $updateQuery2 = $conn->prepare("UPDATE answers SET answer = ?, correct = 0 WHERE answer_id = ? AND question_id = ?;");
                $updateQuery2->bind_param("sii", $_POST[$answer_Id. '_answer'], $answer_Id, $question_Id);
                $updateQuery2->execute();
            }
            // foreach ($result2 as $row2) {
            //     $answer_Id = $row2['answer_id'];
                $updateQuery3 = $conn->prepare("UPDATE answers SET correct = 1 WHERE answer_id = ? AND question_id = ?;");
                $updateQuery3->bind_param("ii", $_POST[$question_Id. '_radio'], $question_Id);
                $updateQuery3->execute();
            // }
        } 
        // echo htmlspecialchars($_POST['questionCounter']);
        // echo htmlspecialchars($correct);
        // echo htmlspecialchars($_POST['quizName']);
        // $updateQuery = $conn->prepare("INSERT INTO results (student_id, quiz_name, question_total, question_correct, quiz_id) VALUES (?, ?, ?, ?, ?)");
        // $updateQuery->bind_param("isiii", $_POST['userId'], $_POST['quizName'], $_POST['questionCounter'], $correct, $_POST['quizId']);
        // $updateQuery->execute();
    }
    
}
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
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (($_POST['formType']) == "addQuiz") { 
                    $query = ('SELECT MAX(quizz_id) AS largest_id FROM quizzes;');
                    $result = $conn->query($query);

                    $largestScore = 0;

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $largestScore = $row['largest_id'];
                    }
                    $newQuizId = $largestScore+1;

                    $updateQuery = $conn->prepare("INSERT INTO quizzes (quizz_id, quizz_name, teacher_id) VALUES (?, ?, ?)");
                    $updateQuery->bind_param("isi", $newQuizId, $_POST['quiz_name'], $user_id);
                    $updateQuery->execute();

                    $noQuestion = $_POST['quiz_question'];
                    //generate new questions
                    for ($i = 0; $i < $noQuestion; $i++) {
                        $query2 = ('SELECT MAX(question_id) AS largest_id FROM questions;');
                        $result2 = $conn->query($query2);
                        $row2 = $result2->fetch_assoc();
                        
                        $a = $row2['largest_id'];
                        $newQuestionId = $a+1;
                        $defaultQuestion = "0";
                        $updateQuestion = $conn->prepare("INSERT INTO questions (question_id, question_text, quizz_id) VALUES (?, ?, ?)");
                        $updateQuestion->bind_param("isi", $newQuestionId, $defaultQuestion, $newQuizId);
                        $updateQuestion->execute();

                        //generate new answers
                        for ($j = 0; $j < 4; $j++) {
                            $query3 = ('SELECT MAX(answer_id) AS largest_id FROM answers;');
                            $result3 = $conn->query($query3);
                            $row3 = $result3->fetch_assoc();
                            
                            $a = $row3['largest_id'];
                            $newAnswerId = $a+1;
                            $defaultAnswer = "0";
                            $defaultCorrect = 0;

                            $updateAnswer = $conn->prepare("INSERT INTO answers (answer_id, answer, correct, question_id) VALUES (?, ?, ?, ?)");
                            $updateAnswer->bind_param("isii", $newAnswerId, $defaultAnswer, $defaultCorrect, $newQuestionId);
                            $updateAnswer->execute();
                        }
                    }
                }
            }
            // echo '<script>console.log("User Level: ' . addslashes($user_level) . '");</script>';
            ?>

            <h2>Hello, <?php echo htmlspecialchars($name); ?>!</h2>
            <h3 id="instruction"> Choose a quiz to edit, or create a new one</h3>
        </div>
    </div>
    
    
    <?php
        $query = $conn->prepare("SELECT * FROM quizzes WHERE quizzes.teacher_id = ?;");
        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();

        foreach ($result as $row) {
    ?>
    <input type="button" class="quizzButton" value= "ID: <?php echo htmlspecialchars($row['quizz_id']); echo("| "); echo htmlspecialchars($row['quizz_name']); ?>">
    <?php
        }
    ?>
    
        <form id="addQuizForm" action="" method="POST">
            <div class="quizInputs">
            <input type="text" name="quiz_name" id="quizName" placeholder="Enter Quiz Name" required>
            
            <input type="number" name="quiz_question" id="quizQuestion" placeholder="Number of Questions (>0)" min="1" required>
            </div>
            <input type="submit" class="addQuizButton" id="addQuiz" value= "Add a new quiz">
            <input type="hidden" name="formType" value="addQuiz">
        </form>
    </div>

</body>



<script type="module" src="manageQuizScript.js"></script>
</html>
