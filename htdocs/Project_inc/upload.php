<?php   
include 'dbconnect.php'; // Include your database connection file

$uploadDir = 'uploads/images/';
$maxSize = 2 * 1024 * 1024; // 2 MB
$allowedTypes = ['jpg', 'jpeg', 'png'];

// Ensure upload directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Check if form was submitted and a file was uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    $fileName = basename($file['name']);
    $fileSize = $file['size'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Get the employee ID from the form
    $employeeId = intval($_POST['employee_id']);

    // Check if the employee already has a photo uploaded
    $checkPhotoSql = "SELECT filePath FROM uploadFile WHERE employeeID = $employeeId LIMIT 1";
    $result = $conn->query($checkPhotoSql);
    
    if ($result->num_rows > 0) {
        // If a photo exists, delete it from the server and database
        $existingPhoto = $result->fetch_assoc();
        $existingFilePath = $existingPhoto['filePath'];
        
        if (file_exists($existingFilePath)) {
            unlink($existingFilePath);  // Delete the old photo from the server
        }
        
        // Delete the old photo record from the database
        $deleteSql = "DELETE FROM uploadFile WHERE employeeID = $employeeId";
        if (!$conn->query($deleteSql)) {
            echo "<p class='error'>Error deleting old photo record: " . $conn->error . "</p>";
            exit;
        }
    }

    // Validate file type and size
    if (in_array($fileExt, $allowedTypes) && $fileSize <= $maxSize) {
        // Generate a unique name for the file
        $newFileName = uniqid() . '.' . $fileExt;
        $uploadFile = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            // File uploaded successfully, now save it in the database
            $uploadDate = date('Y-m-d H:i:s'); // Current timestamp

            // Insert file information into the uploadFile table
            $sql = "INSERT INTO uploadFile (fileName, fileType, filePath, fileSize, uploadDate, employeeID) 
                    VALUES ('$newFileName', '$fileExt', '$uploadFile', $fileSize, '$uploadDate', $employeeId)";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>File uploaded and saved successfully!</p>";
            } else {
                echo "<p class='error'>Error saving file information: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='error'>Error moving uploaded file.</p>";
        }
    } else {
        echo "<p class='error'>Invalid file type or file size exceeded. Only JPG, JPEG, and PNG files under 2MB are allowed.</p>";
    }
} else {
    echo "<p class='error'>No file uploaded.</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Photo Upload</title>
    <link rel="stylesheet" href="upload.css">
</head>
<body>
<div class="insert">
        <a href="DisplayEmployee.php">Back</a>
        
    </div>
    <br>
    <h1>Upload Employee Photo</h1>

    <div class="form-container">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="employee_id">Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id" required>
            <br><br>
            <label for="photo">Choose Photo:</label>
            <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png" required>
            <br><br>
            <button type="submit">Upload Photo</button>
        </form>
    </div>

    <h2>Employee Profiles</h2>

    <div class="employee-profile">
        <?php
        // Display employee profiles with their photos
        include 'dbconnect.php';
        // Check for connection errors
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        // Retrieve employees and their photo paths from the `uploadFile` table
        $result = $conn->query("SELECT e.fullname, e.photo_id, e.employeeID, u.filePath 
                                FROM employees e 
                                LEFT JOIN uploadFile u ON e.employeeID = u.employeeID");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<p><strong>{$row['fullname']}</strong><br>Employee ID: {$row['employeeID']}</p>";
                if (!empty($row['filePath'])) {
                    echo "<img src='{$row['filePath']}' alt='Employee Photo'>";
                } else {
                    echo "<p>No photo uploaded.</p>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>No employees found.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

