<?php

ob_start();

include 'dbconnect.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM department WHERE departmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        ?>

        <form action="editdepartment.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['departmentID']); ?>">
            <label for="departmentName">Department Name:</label>
            <input type="text" name="departmentName" value="<?php echo htmlspecialchars($row['departmentName']); ?>" required><br>

            <label for="contactNumber">Contact Number:</label>
            <input type="text" name="contactNumber" value="<?php echo htmlspecialchars($row['contactNumber']); ?>" required><br>

            <button type="submit" name="update">Update</button>
        </form>

        <?php
    } else {
        echo "Department not found.";
    }
    $stmt->close();
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $departmentName = $_POST['departmentName'];
    $contactNumber = $_POST['contactNumber'];

   
    $sql = "UPDATE department SET departmentName = ?, contactNumber = ? WHERE departmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $departmentName, $contactNumber, $id);

    if ($stmt->execute()) {
       
        header("Location: department.php"); 
        exit(); 
    } else {
        echo "Error updating department.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Department</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>

    <center>
        <h1>Edit Department</h1>

    </center>
</body>
</html>

<?php
ob_end_flush();
?>
