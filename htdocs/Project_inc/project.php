<!DOCTYPE html>
<html>
<head>
    <title>Projects Inc. - Projects</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<center><nav>
        <ul>
            <li><a href="DisplayDepartment.php">Department</a></li> 
            <li><a href="DisplayEmployee.php">DepartmentEmployee</a></li> 
            <li><a href="department.php">Department</a></li> 
            <li><a href="insertproject.php">Add New Project</a></li>
        </ul>
    </nav>
</center>

    <h1>Projects</h1>
    
</section> 
    <table>
        <thead>
            <tr>
                <th>Project ID</th>
                <th>Project Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php

            include 'dbconnect.php';

            $sql = "SELECT * FROM project";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['projectID'] . "</td>";
                    echo "<td>" . $row['projectName'] . "</td>";
                    echo "<td>" . $row['startDate'] . "</td>";
                    echo "<td>" . $row['endDate'] . "</td>";
                    echo "<td>" . $row['departmentID'] . "</td>";
                    echo "<td><a href='deleteproject.php?id=" . $row['projectID'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No projects found.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>