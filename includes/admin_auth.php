<?php

include "auth.php";

if($_SESSION['role'] !== "admin"){
    die("Access Denied");
}

?>