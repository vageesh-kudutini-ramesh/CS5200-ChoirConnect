<?php
require 'db_connection.php';

try {
    // Retrieve all file records from the database
    $stmt = $conn->prepare("SELECT * FROM UploadedFiles ORDER BY uploaded_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $files = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Error fetching files: " . $e->getMessage();
    $files = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
</head>
<body>
    <h1>Reports</h1>

    <!-- Display uploaded files -->
    <h2>Uploaded Files</h2>
    <?php if (count($files) > 0): ?>
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
                            <a href="<?php echo htmlspecialchars($file['file_path']); ?>" download>Download</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No files uploaded yet.</p>
    <?php endif; ?>
</body>
</html>
