<?php

include "auth.php";

if($_SESSION['role'] !== "student"){
    die("Access Denied");
}

?>