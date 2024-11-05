<!DOCTYPE html>
<html>
<head>
    <title>Display employees</title>
    <link rel="stylesheet" href="display.css">
</head>
<body>
<nav>
        <ul>
            <li><a href="DisplayEmployee.php">DepartmentEmployee</a></li> 
            <li><a href="DisplayDepartment.php">DepartmentEmployee</a></li> 
            <li><a href="project.php">project</a></li> 
            <li><a href="department.php">Department</a></li> 
        </ul>
    </nav> 
</body>
</html>

<?php
include 'dbconnect.php';

$sql = "SELECT employeeID, fullName, dateOfBirth, degreeType, typingSpeed, departmentID, project FROM employees";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<table>
        <tr>
            <th>Employee ID</th>
            <th>Full Name</th>
            <th>Date of Birth</th>
            <th>Degree Type</th>
            <th>Typing Speed</th>
            <th>Department</th>
            <th>project</th>
        </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row['employeeID'] . "</td>
                <td>" . $row['fullName'] . "</td>
                <td>" . $row['dateOfBirth'] . "</td>
                <td>" . $row['degreeType'] . "</td>
                <td>" . $row['typingSpeed'] . "</td>
                <td>" . $row['departmentID'] . "</td>
                <td>" . (isset($row['project']) ? $row['project'] : 'N/A') . "</td>
            </tr>";
        }
        

    echo "</table>";
} else {
    echo "No employees found.";
}

$conn->close();
?>