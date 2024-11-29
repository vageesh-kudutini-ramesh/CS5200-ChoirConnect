<?php
require 'db_connection.php';

if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $fileId = $_GET['delete'];
    try {
        // Retrieve the file path from the database
        $stmt = $conn->prepare("SELECT file_path FROM UploadedFiles WHERE id = :id");
        $stmt->execute([':id' => $fileId]);
        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($file) {
            // Delete the file from the server
            if (file_exists($file['file_path'])) {
                unlink($file['file_path']);
            }

            // Delete the file record from the database
            $stmt = $conn->prepare("DELETE FROM UploadedFiles WHERE id = :id");
            $stmt->execute([':id' => $fileId]);
        }
    } catch (Exception $e) {
        echo "Error deleting file: " . htmlspecialchars($e->getMessage());
    }
}

try {
    // Retrieve all file records from the database using PDO
    $stmt = $conn->prepare("SELECT * FROM UploadedFiles ORDER BY uploaded_at DESC");
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch data as an associative array
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .delete-button {
            color: #ff0000;
            text-decoration: none;
        }
        .delete-button:hover {
            text-decoration: underline;
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
                            <a href="<?php echo htmlspecialchars($file['file_path']); ?>" download>Download</a> |
                            <a href="?delete=<?php echo htmlspecialchars($file['id']); ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No files uploaded yet.</p>
    <?php endif; ?>

    <!-- Back to Dashboard Button -->
    <br><br>
    <a href="dashboard.php" class="button">Back to Dashboard</a>
</body>
</html>
