<?php

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/auth.php";

if($_SESSION['role'] !== "admin"){
    die("Access Denied");
}

?>