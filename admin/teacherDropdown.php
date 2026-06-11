<!-- FOR TEACHER DROPDOWN -->

<option value="All" selected disabled>All Teachers</option>
<!-- for class  -->
<?php
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <option value="<?php echo $row['tid'] ?>"><?php echo $row['name'] ?></option>

<?php
    }
}
?>