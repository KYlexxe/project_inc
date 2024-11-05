<?php
include 'dbconnect.php';

if (!isset($_GET['department']) || empty($_GET['department'])) {
    die("Department ID is missing from the URL.");
}

$departmentID = $_GET['department'];

$sql = "SELECT e.employeeName FROM employee e 
        INNER JOIN department_employee de ON e.employeeID = de.employeeID 
        WHERE de.departmentID = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Prepare statement failed: ' . $conn->error);
}

$stmt->bind_param("i", $departmentID);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die('Query execution failed: ' . $conn->error);
}

?>