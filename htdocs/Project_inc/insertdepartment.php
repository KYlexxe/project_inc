<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departmentName = $_POST['departmentName'];
    $contactNumber = $_POST['contactNumber'];

    $sql = "INSERT INTO department (departmentName, contactNumber) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $departmentName, $contactNumber);
    $stmt->execute();

    header("Location: department.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Projects Inc. - Add Department</title>
    <link rel="stylesheet" href="insert.css">
</head>
<body>
    <form method="POST" action="insertdepartment.php">
    <label for="departmentName"></label>
    <input type="text" name="departmentName" placeholder="Departments Name" required><br>
    <label for="contactNumber"></label>
    <input type="number" name="contactNumber" placeholder="Contact Number" required><br><br>
    
    <input type="submit" value="Add Department">
</form>

</body>
</html>