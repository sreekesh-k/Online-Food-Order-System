<?php
include("db_connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <nav>
            <img src="Images/Logos/yum.png" alt="YumStreet" class="logo">
            <ul class="nav-links">
                <?php
                if (isset($_SESSION['username'])) {
                    $username = $_SESSION['username'];
                    echo
                    "
                <li><a href='orders.php'>$username's Cart</a></li>
                <li><a href='logout.php'>Logout</a></li>
                ";
                } else {
                    echo "
                <li><a href='Signup.php'>Signup</a></li>
                <li><a href='login.php'>Login</a></li>
                ";
                }
                ?>
            </ul>
        </nav>
    </header>
</body>

</html>