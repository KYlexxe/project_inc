<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectName = $_POST['projectName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $departmentID = $_POST['departmentID'];

    $sql = "INSERT INTO project (projectName, startDate, endDate, departmentID) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $projectName, $startDate, $endDate, $departmentID);
    $stmt->execute();

    header("Location: project.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Projects Inc. - Add Project</title>
    <link rel="stylesheet" href="insert.css">
</head>
<body>
    <form method="POST" action="insertproject.php">
        <label for="projectName">Project Name:</label>
        <input type="text" name="projectName" required><br>
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" required><br>
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate"><br>
        <label for="departmentID">Department:</label>
        <select name="departmentID" required>
            <?php
            $sql = "SELECT departmentID, departmentName FROM department";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['departmentID'] . "'>" . $row['departmentName'] . "</option>";
                }
            }
            ?>
        </select><br><br>
        <input type="submit" value="Add Project">
    </form>
</body>
</html>