<?php
include 'dbconnect.php';
$departmentId = $_GET['id'] ?? null;

if ($departmentId) {
    $sql = "SELECT * FROM department WHERE departmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $departmentId);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $sql = "DELETE FROM department WHERE departmentID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $departmentId);

        if ($stmt->execute()) {
            header("Location: department.php");
            exit();
        } else {
            echo "Error deleting department: " . $conn->error;
        }
    } else {
        echo "Department not found.";
        
    }
} else {
    echo "Invalid department ID.";
}

$conn->close();
?>

