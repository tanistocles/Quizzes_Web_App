<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Quickzzes</title>
    <link rel="stylesheet" href="addStudentStyle.css">   
</head>

<?php
$conn = new mysqli("localhost", "root", "", "database");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['student_email'];
    $quizzz_id = $_POST['quizChoice'];

    // echo '<script>console.log("User Level: ' . addslashes($email) . '");</script>';


    $query = $conn->prepare("SELECT * FROM login WHERE email = ?;");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    $newstudent_id = 0;
    foreach ($result as $row) {
        $newstudent_id = $row['user_id'];
    }

    if ($newstudent_id != 0) {
        $updateQuery = $conn->prepare("REPLACE INTO quizz_student (quizz_id, student_id) VALUES (?, ?)");
        $updateQuery->bind_param("ii", $quizzz_id, $newstudent_id);
        $updateQuery->execute();
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
            
            // echo '<script>console.log("User Level: ' . addslashes($user_level) . '");</script>';
            ?>
            <h2>Hello, <?php echo htmlspecialchars($name); ?>!</h2>
            <h3 id="instruction">Add your student below.</h3>
        </div>
    </div>
    <form id="addStudentForm" action="" method="POST">
            <div class="studentInputs">
                
            <input type="email" name="student_email" id="studentEmail" placeholder="Enter Student Email" required>
            
            <!-- <input type="number" name="quiz_question" id="quizQuestion" placeholder="Number of Questions (>0)" min="1" required> -->
            <select id="dropBox" name="quizChoice">
            <?php
            $quiz = 0;
            if (isset($_POST['quizChoice']))
                $quiz = $_POST['quizChoice'];
                    $result = $conn->query("SELECT * FROM quizzes WHERE teacher_id = $user_id;");
                    foreach ($result as $row) {
            ?>
                        <option value="<?=$row['quizz_id']?>"<?php
                            # This selects the current quiz we're looking at, if any
                            if ($quiz == $row['quizz_id']) {echo " selected";}
                        ?>><?=$row['quizz_name']?></option>
            <?php
                    }
            ?>
            
            </div>
            <input type="submit" class="addStudentButton" id="addStudent" value= "Add this student">
            <input type="hidden" name="formType" value="addStudent">
    </form>
</body>
<script type="module" src="addStudentScript.js"></script>
</html>
