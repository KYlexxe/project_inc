<?php
include 'dbconnect.php';
$projectId = $_GET['id'] ?? null;

if ($projectId) {
    $sql = "SELECT * FROM project WHERE projectID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $sql = "DELETE FROM project WHERE projectID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $projectId);

        if ($stmt->execute()) {
           
            header("Location: project.php");
            exit();
        } else {
            echo "Error deleting project: " . $conn->error;
        }
    } else {
        echo "Project not found.";
    }
} else {
    echo "Invalid project ID.";
}

$conn->close();
?>
