<!DOCTYPE html> 
<html>
<head>
    <title>Projects Inc. - Projects</title>
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

    <h1>Projects</h1>

    <div class="insert">
        <a href="insertproject.php">Add new Projects</a>
    </div>
    <br>

    <table>
        <thead>
            <tr>
                <th>Project ID</th>
                <th>Project Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Department</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'dbconnect.php';

            $sql = "SELECT project.*, department.departmentName
                    FROM project
                    INNER JOIN department ON project.departmentID = department.departmentID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['projectID']) . "</td>";
                    echo "<td><a href='project.php?projectID=" . urlencode($row['projectID']) . "'>" . htmlspecialchars($row['projectName']) . "</a></td>";
                    echo "<td>" . htmlspecialchars($row['startDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['endDate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['departmentName']) . "</td>";
                    echo "<td><a href='editproject.php?id=" . urlencode($row['projectID']) . "'>Edit</a></td>";
                    echo "<td><a href='deleteproject.php?id=" . $row['projectID'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No Projects Found.</td></tr>";
            }

            if (isset($_GET['projectID'])) {
                $projectID = $_GET['projectID'];

                
                $sqlEmployees = "SELECT employees.employeeID, employees.fullname, employees.jobtitle, department.departmentName 
                                 FROM employees
                                 INNER JOIN department ON employees.departmentID = department.departmentID
                                 INNER JOIN project_employee ON employees.employeeID = project_employee.employeeID
                                 WHERE project_employee.projectID = ?";
                $stmt = $conn->prepare($sqlEmployees);
                $stmt->bind_param("i", $projectID);
                $stmt->execute();
                $resultEmployees = $stmt->get_result();

                if ($resultEmployees->num_rows > 0) {
                    echo "<h3>Employees working on this project:</h3>";
                    echo "<table>";
                    echo "<tr><th>Employee ID</th><th>Employee Name</th><th>Job Title</th><th>Department</th></tr>";
                    while ($emp = $resultEmployees->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($emp['employeeID']) . "</td>";
                        echo "<td>" . htmlspecialchars($emp['fullname']) . "</td>";
                        echo "<td>" . htmlspecialchars($emp['jobtitle']) . "</td>";
                        echo "<td>" . htmlspecialchars($emp['departmentName']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                   
            
                    
                }
                $stmt->close();

                $sqlDepartments = "SELECT department.departmentID, department.departmentName 
                                   FROM department
                                   INNER JOIN department_project ON department.departmentID = department_project.departmentID
                                   WHERE department_project.projectID = ?";

                $stmt = $conn->prepare($sqlDepartments);
                $stmt->bind_param("i", $projectID);
                $stmt->execute();
                $resultDepartments = $stmt->get_result();

                if ($resultDepartments->num_rows > 0) {
                    echo "<h3>Departments working on this project:</h3>";
                    echo "<table>";
                    echo "<tr><th>Department ID</th><th>Department Name</th></tr>";
                    while ($dept = $resultDepartments->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($dept['departmentID']) . "</td>";
                        echo "<td>" . htmlspecialchars($dept['departmentName']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No departments found for this project.</p>";
                }
                $stmt->close();
            }

            $conn->close();
            ?>

        </tbody>
    </table>
</center>
</body>
</html>
