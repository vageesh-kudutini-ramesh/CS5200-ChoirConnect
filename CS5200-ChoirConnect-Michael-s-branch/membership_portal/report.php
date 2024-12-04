<?php
require 'db_connection.php';
session_start();

$role = $_SESSION['role'] ?? '';

if (isset($_GET['delete']) && !empty($_GET['delete']) && $role === 'Admin') {
    $fileId = $_GET['delete'];
    try {
        // Retrieve the file path from the database
        $stmt = $conn->prepare("SELECT file_path FROM UploadedFiles WHERE id = ?");
        $stmt->bind_param("i", $fileId); // Bind the file ID
        $stmt->execute();
        $result = $stmt->get_result();
        $file = $result->fetch_assoc();

        if ($file) {
            // Delete the file from the server
            if (file_exists($file['file_path'])) {
                unlink($file['file_path']);
            }

            // Delete the file record from the database
            $stmt = $conn->prepare("DELETE FROM UploadedFiles WHERE id = ?");
            $stmt->bind_param("i", $fileId); // Bind the file ID
            $stmt->execute();
        }
    } catch (Exception $e) {
        echo "Error deleting file: " . htmlspecialchars($e->getMessage());
    }
}

try {
    // Retrieve all file records from the database using MySQLi
    $stmt = $conn->prepare("SELECT * FROM UploadedFiles ORDER BY uploaded_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $files = $result->fetch_all(MYSQLI_ASSOC); // Fetch data as an associative array
} catch (Exception $e) {
    echo "Error fetching files: " . htmlspecialchars($e->getMessage());
    $files = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin-top: 40px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
            text-align: center;
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-decoration: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
        a.delete-button {
            color: #dc3545;
            text-decoration: none;
        }
        a.delete-button:hover {
            color: #a71d2a;
        }
        hr {
            border: 1px solid #ddd;
            margin: 40px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Reports</h1>
    </header>

    <h2>Uploaded Files</h2>
    <?php if (!empty($files)): ?>
        <table>
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $file): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($file['file_name']); ?></td>
                        <td><?php echo htmlspecialchars($file['uploaded_at']); ?></td>
                        <td>
                            <a href="<?php echo htmlspecialchars($file['file_path']); ?>" download><i class="fas fa-download"></i> Download</a>
                            <?php if ($role === 'Admin'): ?>
                                | <a href="?delete=<?php echo htmlspecialchars($file['id']); ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this file?');"><i class="fas fa-trash-alt"></i> Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No files uploaded yet.</p>
    <?php endif; ?>

    <!-- Back to Dashboard Button -->
    <a href="dashboard.php" class="button"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
</body>
</html>
