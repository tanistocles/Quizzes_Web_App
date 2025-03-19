<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Login - Quickzzes</title>
    <link rel="stylesheet" href="indexStyle.css"> 
    <?php
    $conn = new mysqli("localhost", "root", "", "database");
    ?>
    
</head>
<body>
    <h1>Quickzzes</h1>
    <div class="loginContainer">
        <h2>Login</h2>
        <form action="" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>
        <div class="registerLink">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if ($password === $user['password']) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $email;
            $_SESSION['user_level'] = $user['user_level'];

            header("Location: mainPage.php");
            exit();
        } else {
            // Invalid password
            echo '<script>
            const passwordField = document.getElementById("password");
            passwordField.style.border = "2px solid red";
            const errorMessage = document.createElement("div");
            errorMessage.innerText = "Invalid password. Please try again!";
            errorMessage.style.color = "red";
            errorMessage.style.marginTop = "-7px";
            errorMessage.style.position = "relative";
            errorMessage.style.top = "-5px";
            errorMessage.style.fontSize = "12px";
            passwordField.parentNode.insertBefore(errorMessage, passwordField.nextSibling);
            </script>';
        }
    } else {
        // Email not found
        echo '<script>
        const emailField = document.getElementById("email");
        emailField.value = "'. htmlspecialchars($email) .'";
        emailField.style.border = "2px solid red";
        const errorMessage = document.createElement("div");
        errorMessage.innerText = "Invalid email. Please try again!";
        errorMessage.style.color = "red";
        errorMessage.style.marginTop = "-7px";
        errorMessage.style.position = "relative";
        errorMessage.style.top = "-5px";
        errorMessage.style.fontSize = "12px";
        emailField.parentNode.insertBefore(errorMessage, emailField.nextSibling);
        </script>';
    }
}
?>
</html>
