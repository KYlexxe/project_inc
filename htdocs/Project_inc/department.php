<!DOCTYPE html>   
<html>
<head>
    <title>Projects Inc. - Departments</title>
    <link rel="stylesheet" href="style.css">
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
  
  </div>


<br><br>
   

        <h1>Departments</h1>
        <div class="insert">
        <a href="insertdepartment.php">Add new Departments</a>
    </div>
    <br>
        <table>
           <thead>
              <tr>
                <th>Department ID</th>
                <th>Department Name</th>
                <th>Contact Number</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
                <?php
                include 'dbconnect.php';

                $sql = "SELECT * FROM department";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['departmentID']) . "</td>";
                        echo "<td><a href='department.php?departmentID=" . urlencode($row['departmentID']) . "'>" . htmlspecialchars($row['departmentName']) . "</a></td>";
                        echo "<td>" . htmlspecialchars($row['contactNumber']) . "</td>";
                        echo "<td><a href='editdepartment.php?id=" . urlencode($row['departmentID']) . "'>Edit</a></td>";
                        echo "<td><a href='deletedepartment.php?id=" . urlencode($row['departmentID']) . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No departments found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        
        if (isset($_GET['departmentID'])) {
            $departmentID = $_GET['departmentID'];

            echo "<h2>Employees in Department </h2>";

            $sqlEmployees = "SELECT * FROM employees WHERE departmentID = ?";
            $stmt = $conn->prepare($sqlEmployees);
            $stmt->bind_param("i", $departmentID);
            $stmt->execute();
            $resultEmployees = $stmt->get_result();

        if ($resultEmployees->num_rows > 0) {
                echo "<table>";
                echo "<tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                         <th>job Title</th>
                 </tr>";
                    while ($emp = $resultEmployees->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($emp['employeeID'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($emp['fullname'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($emp['jobtitle'] ?? '') . "</td>";
                echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No employees found in this department.</p>";
}
$stmt->close();

        }

        $conn->close();
        ?>
    </center>
</body>
</html>


