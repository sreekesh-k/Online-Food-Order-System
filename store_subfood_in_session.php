<?php
session_start();

if (isset($_GET["id"])) {
    $_SESSION["subfood_id"] = $_GET["id"];
    // Optionally, you can send back a response to indicate success
    echo "Subfood ID stored in session: " . $_SESSION["subfood_id"];
} else {
    // Handle invalid request
    echo "Invalid request";
}
