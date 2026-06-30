<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: /school_management_system/index.php");
    exit;
}

?>