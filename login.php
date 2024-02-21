<?php
include("db_connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/style.css">
    <link rel="icon" type="image/png" href="Images/Logos/yum.png">

    <title>Login Page</title>
</head>

<body background="Images/Background/food.jpg">
    <div class="login-container">
        <form class="login-form" action="" method="POST">
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>


            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="login" name="login" class="btn">
            <a href="signup.php">Don't have an account?</a>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if (isset($_POST["login"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                // Prepare the SQL statement with a placeholder for the username
                $sql = "SELECT * FROM users WHERE username=?";
                $stmt = mysqli_prepare($conn, $sql);

                // Bind the username parameter to the prepared statement
                mysqli_stmt_bind_param($stmt, "s", $username);

                // Execute the prepared statement
                mysqli_stmt_execute($stmt);

                // Get the result of the prepared statement
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    // Fetch the user data
                    $row = mysqli_fetch_assoc($result);
                    $hashedpassword = $row["password"];
                    // Verify the password
                    if (password_verify($password, $row["password"])) {
                        // Start a new session and store the username in the session variable
                        session_start();
                        $_SESSION["username"] = $row["username"];
                        // Redirect to home page after successful login
                        header("Location: index.php");
                        exit();
                    } else {
                        // Display an error message if the password is incorrect
                        $msg = "<center><h4 style='color:red;'>Invalid Password!</h4></center>";
                        echo $msg;
                    }
                } else {
                    $msg = "<center><h4 style='color:red;'>Invalid Username!</h4></center>";
                    echo $msg;
                }
            }
        }
        ?>
    </div>
</body>

</html>