<!DOCTYPE html>
<html>
<head>
    <title>Display Departments Working on Projects</title>
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
                <a href="DisplayDepartment.php">Display All Departments Working on Projects</a>
                <br><br>
                <a href="DisplayEmployee.php">Display Employee Working on Project</a>
            </div>
        </div>

        <br><br>
        <h1>Departments Working on Projects</h1>

        <?php
        include 'dbconnect.php';

        $sql = "SELECT d.departmentID, d.departmentName, p.projectName
                FROM department_project dp
                JOIN department d ON dp.departmentID = d.departmentID
                JOIN project p ON dp.projectID = p.projectID";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<table>
                <thead>
                    <tr>
                        <th>Department Name</th>
                        <th>Project Name</th>
                        </tr>
                </thead>
                    <tbody>";
            while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td><a href='DisplayEmployee.php?departmentID=" . $row['departmentID'] . "'>" . htmlspecialchars($row['departmentName']) . "</a></td>
                            <td>" . htmlspecialchars($row['projectName']) . "</td>
                        </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>No departments found for any projects.</p>";
                }
        } else {
                echo "<p>Error executing query: " . htmlspecialchars($stmt->error) . "</p>";
        }
            $stmt->close();
    } else {
            echo "<p>Error preparing statement: " . htmlspecialchars($conn->error) . "</p>";
    }

        $conn->close(); 
        ?>
    </center>
</body>
</html>
