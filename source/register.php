<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Register - Quickzzes</title>
    <link rel="stylesheet" href="registerStyle.css"> 
    <?php
    $conn = new mysqli("localhost", "root", "", "database");
    ?>
    
</head>

</body>
    <h1>Quickzzes</h1>
    <div class="registerContainer">
        <h2>Register</h2>
        <form action="" method="POST">

            <div class="radioContainer">
                <label>
                    Student <input type="radio" id="student" name="userType" value="student" required> 
                </label>
                <label>
                    Teacher <input type="radio" id="teacher" name="userType" value="teacher" required> 
                </label>
            </div>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <input type="password" id="passwordAgain" name="passwordAgain" placeholder="Repeat your password" required>

            <button type="submit">Register</button>
        </form>
        <div class="loginLink">
            <p>Already have an account? <a href="index.php">Login here</a></p>
        </div>
    </div>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordAgain = $_POST['passwordAgain'];
    $userType = $_POST['userType'];

    $sql = "SELECT user_id, password FROM login WHERE email = '$email'";
    $result = $conn->query($sql);

    echo'<script>
    const emailField = document.getElementById("email");
    const passwordFieldAgain = document.getElementById("passwordAgain");
    const passwordField = document.getElementById("password");
    emailField.value = "'. htmlspecialchars($email) .'";
    passwordField.value = "'. htmlspecialchars($password) .'";
    passwordFieldAgain.value = "'. htmlspecialchars($passwordAgain) .'";
    </script>';

    if ($result->num_rows > 0) {
        echo '<script>
        emailField.style.border = "2px solid red";
        const errorMessage = document.createElement("div");
        errorMessage.innerText = "Account already exists. Please log in!";
        errorMessage.style.color = "red";
        errorMessage.style.marginTop = "-7px";
        errorMessage.style.position = "relative";
        errorMessage.style.top = "-5px";
        errorMessage.style.fontSize = "12px";
        emailField.parentNode.insertBefore(errorMessage, emailField.nextSibling);
        </script>';
    }
    else if ($password != $passwordAgain) {
        //2 passwords not matched.
        echo '<script>
        passwordFieldAgain.style.border = "2px solid red";
        const errorMessage = document.createElement("div");
        errorMessage.innerText = "Password not matched. Please try again!";
        errorMessage.style.color = "red";
        errorMessage.style.marginTop = "-7px";
        errorMessage.style.position = "relative";
        errorMessage.style.top = "-5px";
        errorMessage.style.fontSize = "12px";
        passwordField.parentNode.insertBefore(errorMessage, passwordFieldAgain.nextSibling);
        </script>';
    }
    else {
        $query = ('SELECT MAX(user_id) AS largest_id FROM login;');
        $result = $conn->query($query);

        $largestScore = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $largestScore = $row['largest_id'];
        }
        $newUserId = $largestScore+1;

        $newUserLevel = 0;
        if ($userType == 'student') {
            $newUserLevel = 1;
        }
        else {
            $newUserLevel = 2;
        }

        $updateQuery = $conn->prepare("INSERT INTO login (user_id, email, password, user_level) VALUES (?, ?, ?, ?)");
        $updateQuery->bind_param("issi", $newUserId, $email, $password, $newUserLevel);
        $updateQuery->execute();

        echo '<script>
        passwordFieldAgain.style.border = "2px solid green";
        passwordField.style.border = "2px solid green";
        emailField.style.border = "2px solid green";
        const errorMessage = document.createElement("div");
        errorMessage.innerText = "Sign up successful. Please log in!";
        errorMessage.style.color = "green";
        errorMessage.style.marginTop = "-7px";
        errorMessage.style.position = "relative";
        errorMessage.style.top = "-5px";
        errorMessage.style.fontSize = "12px";
        passwordField.parentNode.insertBefore(errorMessage, passwordFieldAgain.nextSibling);
        </script>';
    } 
}

?>
</html>