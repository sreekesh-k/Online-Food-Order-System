<?php
session_start();
if (isset($_SESSION["subfood_id"])) {
    echo $_SESSION["subfood_id"];
}
