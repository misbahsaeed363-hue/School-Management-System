<?php

session_start();

include $_SERVER['DOCUMENT_ROOT']."/school_management_system/config/connection.php";

$teacher_id = $_SESSION['tid'];

$sql = "
SELECT
    sec_id,
    class_id,
    section_name
FROM sections
WHERE teacher_id='$teacher_id'
";

$result = $conn->query($sql);

$data=[];

while($row=$result->fetch_assoc()){
    $data[]=$row;
}

echo json_encode($data);

?>