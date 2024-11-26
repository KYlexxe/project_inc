<!DOCTYPE html>
<html>
<head>
<title>Display Employees</title>
<link rel="stylesheet" href="display.css">
 </head>
<body>
<center>

<div class="dropdown">
    <button class="dropdown-button">Departments-Projects</button>
    <div class="dropdown-content">
      <a href="department.php">Departments</a>
      <br><br>
      <a href="project.php">Projects</a>
    </div>
  </div>

  <div class="dropdown">
    <button class="dropdown-button">Display</button>
    <div class="dropdown-content">
      <a href="DisplayDepartment.php">Display Department working on projects</a>
      <br><br>
      <a href="DisplayEmployee.php">Display Employee Working on project</a>
    </div>
  </div>

    <h1>List of Employees</h1>

    <div class="insert">
        <a href="insertemployee.php">Add new Employee</a>
        <a href="upload.php">Upload</a>
    </div>
    <br>
<?php
include 'dbconnect.php';

$sql = "SELECT e.employeeID, e.fullName, e.dateOfBirth, e.degreeType, e.typingSpeed, d.DepartmentName, e.jobTitle
FROM employees e
JOIN department d ON e.departmentID = d.departmentID";

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
<th>Job Title</th>
</tr>";

while($row = $result->fetch_assoc()) {
echo "<tr>
<td>" . $row['employeeID'] . "</td>
<td>" . $row['fullName'] . "</td>
<td>" . $row['dateOfBirth'] . "</td>
<td>" . $row['degreeType'] . "</td>
<td>" . $row['typingSpeed'] . "</td>
<td>" . $row['DepartmentName'] . "</td>
<td>" . $row['jobTitle'] . "</td>
</tr>";
}

echo "</table>";
} else {
echo "No employees found.";
}

$conn->close();
?>
</body>
</html>