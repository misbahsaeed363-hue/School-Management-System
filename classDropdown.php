 <!-- FOR CLASS DROPDOWN -->

 <!-- for class  -->
 <?php
    $sql = "SELECT * FROM classes";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
         <option value="<?php echo $row['id'] ?>"><?php echo $row['class_name'] ?></option>

 <?php
        }
    }
    ?>