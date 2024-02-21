<?php
session_start();
session_destroy();
header("exit.php");
exit();
