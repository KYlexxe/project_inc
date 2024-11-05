<!DOCTYPE html>
<html>
<head>
    <title>Projects Inc. - Departments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
        <ul>
            <li><a href="project.php">Projects</a></li> 
        </ul>
    </nav> 
    <h1>Departments</h1>
    <section id="department">
    <a href="insertdepartment.php">Add Department</a>
    </section><br>
    <table>
        <thead>
            <tr>
                <th>Department ID</th>
                <th>Department Name</th>
                <th>Contact Number</th>
                <th>Actions</th>
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
                    echo "<td>" . $row['departmentID'] . "</td>";
                    echo "<td>" . $row['departmentName'] . "</td>";
                    echo "<td>" . $row['contactNumber'] . "</td>";
                    echo "<td><a href='deletedepartment.php?id=" . $row['departmentID'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No departments found.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>