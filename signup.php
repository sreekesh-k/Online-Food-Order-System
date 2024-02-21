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

    <title>Sign up</title>
</head>

<body background="Images/Background/food.jpg">
    <div class="login-container">
        <form class="login-form" action="" method="POST">
            <h2>Create an account</h2>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="phone number">Phone number:</label>
            <input type="number" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="submit" name="submit" class="btn">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST["submit"])) {
                $name = $_POST['name'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];

                // Store passwords securely by hashing them before storing them in the database. This prevents storing plain text passwords, which can be a security risk if the database is compromised.
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Check if the username already exists in the database.
                $chk_username = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $chk_username->bind_param("s", $name);
                $chk_username->execute();
                $result = $chk_username->get_result();

                if ($result->num_rows > 0) {
                    // Display an error message if the username already exists
                    echo "Username already exists. Please choose a different name.";
                } else {
                    // Prepare and execute the INSERT statement using prepared statements
                    $stmts = $conn->prepare("INSERT INTO users (username, password, emailid, phonenumber) VALUES (?, ?, ?, ?)");
                    $stmts->bind_param("ssss", $name, $hashed_password, $email, $phone);
                    if ($stmts->execute()) {
                        header("Location: Login.php"); // Redirect to the login page after successful registration
                        exit; // Exit to prevent further execution
                    } else {
                        // Display error message if registration fails
                        echo "Error: " . $stmts->error;
                    }
                }
            }
        }

        ?>
    </div>
</body>

</html>