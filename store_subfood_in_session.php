<?php
session_start();
if (!isset($_SESSION["subfood_ids"])) {
    $_SESSION["subfood_ids"] = array();
}
if (isset($_GET["id"])) {
    $_SESSION["subfood_ids"][] = $_GET["id"];
    // Optionally, you can send back a response to indicate success
    echo "Subfood ID stored in session: " . $_GET["id"];
} else {
    // Handle invalid request
    echo "Invalid request";
}
