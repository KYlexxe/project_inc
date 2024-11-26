<!DOCTYPE html>
<html>
<head>
<title>Insert Employee</title>
<link rel="stylesheet" href="insertemployee.css">
</head>
<body>
<center>



<h1>Insert New Employee</h1>

<form action="insertemployee.php" method="POST">
    <label for="fullName">Full Name:</label><br>
    <input type="text" id="fullName" name="fullName" required><br><br>

    <label for="dateOfBirth">Date of Birth:</label><br>
    <input type="date" id="dateOfBirth" name="dateOfBirth" required><br><br>

    <label for="degreeType">Degree Type:</label><br>
    <input type="text" id="degreeType" name="degreeType" required><br><br>

    <label for="typingSpeed">Typing Speed (WPM):</label><br>
    <input type="number" id="typingSpeed" name="typingSpeed" required><br><br>

    <label for="departmentID">Department:</label><br>
    <select id="departmentID" name="departmentID" required>
        <?php
        include 'dbconnect.php';
        $sql = "SELECT departmentID, DepartmentName FROM department";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['departmentID'] . "'>" . $row['DepartmentName'] . "</option>";
            }
        } else {
            echo "<option value=''>No departments available</option>";
        }
        ?>
    </select><br><br>

    <label for="jobTitle">Job Title:</label><br>
    <input type="text" id="jobTitle" name="jobTitle" required><br><br>

    <input type="submit" value="Insert Employee">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $degreeType = $_POST['degreeType'];
    $typingSpeed = $_POST['typingSpeed'];
    $departmentID = $_POST['departmentID'];
    $jobTitle = $_POST['jobTitle'];

    // Insert data into the database
    include 'dbconnect.php';
    $sql = "INSERT INTO employees (fullName, dateOfBirth, degreeType, typingSpeed, departmentID, jobTitle) 
            VALUES ('$fullName', '$dateOfBirth', '$degreeType', '$typingSpeed', '$departmentID', '$jobTitle')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>New employee added successfully.</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $conn->close();
}
?>

</center>
</body>
</html>
