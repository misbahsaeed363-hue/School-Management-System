<?php

include "auth.php";

if($_SESSION['role'] !== "teacher"){
    die("Access Denied");
}

?>