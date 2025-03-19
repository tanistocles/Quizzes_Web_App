<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Quickzzes</title>
    <link rel="stylesheet" href="mainStyle.css">   
</head>

<?php
$conn = new mysqli("localhost", "root", "", "database");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $_POST;
    $correct = 0;
    foreach ($result as $key => $value) {
        if ($key != "questionCounter" && $key != "userId" && $key != "quizName" && $key != "quizId") {
            if ($value == 1) {
                $correct++;
            }
        }
    } 
    // echo htmlspecialchars($_POST['questionCounter']);
    // echo htmlspecialchars($correct);
    // echo htmlspecialchars($_POST['quizName']);
    $updateQuery = $conn->prepare("INSERT INTO results (student_id, quiz_name, question_total, question_correct, quiz_id) VALUES (?, ?, ?, ?, ?)");
    $updateQuery->bind_param("isiii", $_POST['userId'], $_POST['quizName'], $_POST['questionCounter'], $correct, $_POST['quizId']);
    $updateQuery->execute();
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

            <?php
            //If this is a student 
            if ($user_level == 1) {
                ?>
                <p>Welcome to Quickzzes, your ultimate online quiz platform. Challenge yourself, do quizzes, and track your progress.</p>
            </div>
            <div class="features">
                <div class="feature">
                    <h3>Start a Quiz</h3>
                    <p>Take quizzes to test your knowledge and improve your skills.</p>
                    <a href="startQuiz.php">Start Now</a>
                </div>
                <!-- <div class="feature">
                    <h3>Join a Class</h3>
                    <p>Join new classes, make new friends, and test your mettle against new trivia.</p>
                    <a href="joinClass.php">Join Now</a>
                </div> -->
                <div class="feature">
                    <h3>View Results</h3>
                    <p>See how you have done so far.</p>
                    <a href="results.php">View Results</a>
                </div>
            </div>
                
           

            <?php
            //If this is an admin 
            } else if ($user_level == 3) {
                ?>
                <p>Begin managing the platform now.</p>
            </div>
            <div class="features">
                <div class="feature">
                    <h3>Add an Admin</h3>
                    <p>Add new admins.</p>
                    <a href="addAdmin.php">Add Now</a>
                </div>
                <div class="feature">
                    <h3>Manage Members</h3>
                    <p>Edit, update and kick existing members.</p>
                    <a href="manageMember.php">Create Now</a>
                </div>
                <div class="feature">
                    <h3>View Statistics</h3>
                    <p>See what the platform has done so far.</p>
                    <a href="statistics.php">View Results</a>
                </div>
            </div>
                
            <?php
            //If this is a teacher 
            } else if ($user_level == 2) {
            ?>
            <p>Welcome to Quickzzes, your ultimate online quiz platform. Creating quizzes has never been simpler.</p>
        </div>
        <div class="features">
            <!-- <div class="feature">
                <h3>Manage your Classes</h3>
                <p>Update, delete or create new classes.</p>
                <a href="manageClass.php">Manage Now</a>
            </div> -->
            <div class="feature">
                <h3>Manage a Quiz</h3>
                <p>Manage, create and update quizzes for other members to partake.</p>
                <a href="manageQuiz.php">Create Now</a>
            </div>
            <div class="feature">
                <h3>Add a Student</h3>
                <p>Add a student to one of your quiz.</p>
                <a href="addStudent.php">Add Now</a>
            </div>
        </div>
            <?php
            }
            ?>


    </div>
</body>
</html>
