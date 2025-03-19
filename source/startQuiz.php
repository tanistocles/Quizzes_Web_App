<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Quickzzes</title>
    <link rel="stylesheet" href="style.css">
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
            
            // echo '<script>console.log("User Level: ' . addslashes($user_level) . '");</script>';
            ?>
            <h2>Hello, <?php echo htmlspecialchars($name); ?>!</h2>
            <h3 id="instruction"> Choose one of the quizzes that you have been added to begin.</h3>
        </div>
    </div>
    <div class="buttonContainer">
    <?php
        $query = $conn->prepare("SELECT quizz_student.student_id, quizzes.quizz_name, quizzes.quizz_id, quizzes.teacher_id FROM quizz_student, quizzes WHERE quizz_student.quizz_id = quizzes.quizz_id AND student_id = ?;");
        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();

        foreach ($result as $row) {
    ?>
    <input type="button" class="quizzButton" value= "ID: <?php echo htmlspecialchars($row['quizz_id']); echo("| "); echo htmlspecialchars($row['quizz_name']); ?>">
    <?php
        }
    ?>
    </div>
</body>
<script type="module" src="startQuizScript.js"></script>
</html>
