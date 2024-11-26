<?php 

ob_start();

include 'dbconnect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM project WHERE projectID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Project</title>
            <link rel="stylesheet" href="edit.css">
        </head>
        <body>
            <center>
                <h1>Edit Project</h1>

                <form action="editproject.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['projectID']); ?>">
                    
                    <label for="projectName">Project Name:</label>
                    <input type="text" name="projectName" value="<?php echo htmlspecialchars($row['projectName']); ?>" required><br>

                    <label for="startDate">Start Date:</label>
                    <input type="date" name="startDate" value="<?php echo htmlspecialchars($row['startDate']); ?>" required><br>

                    <label for="endDate">End Date:</label>
                    <input type="date" name="endDate" value="<?php echo htmlspecialchars($row['endDate']); ?>" required><br>

                    <button type="submit" name="update">Update</button>
                </form>

            </center>
        </body>
        </html>

        <?php
    } else {
        echo "Project not found.";
    }
    $stmt->close();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $projectName = $_POST['projectName'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

   
    $sql = "UPDATE project SET projectName = ?, startDate = ?, endDate = ? WHERE projectID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $projectName, $startDate, $endDate, $id);

    if ($stmt->execute()) {
      
        header("Location: project.php"); 
        exit(); 
    } else {
        echo "Error updating project.";
    }
    $stmt->close();
}

$conn->close();
?>

<?php

ob_end_flush();
?>
