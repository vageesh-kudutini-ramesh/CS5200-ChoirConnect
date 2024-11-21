<?php
require 'db_connection.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $absence_reason = isset($_POST['absence_reason']) ? $_POST['absence_reason'] : '';

    // Input validation
    if (empty($date) || !strtotime($date)) {
        die("Invalid date format.");
    }
    if (!isset($status) || ($status != "1" && $status != "0")) {
        die("Invalid status value.");
    }

    // Update the database
    $stmt = $conn->prepare("UPDATE Attendance SET date = ?, status = ?, absence_reason = ? WHERE attendance_id = ?");
    $stmt->bind_param("sisi", $date, $status, $absence_reason, $id);

    if ($stmt->execute() === TRUE) {
        header("Location: manage_attendance.php?success=3");
        exit;
    } else {
        echo "Error updating data: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Retrieve the current record
    $result = $conn->query("SELECT * FROM Attendance WHERE attendance_id = $id");
    $row = $result->fetch_assoc();
    if (!$row) {
        die("Record not found.");
    }
    ?>
    <form method="post">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="1" <?php if ($row['status']) echo "selected"; ?>>Present</option>
            <option value="0" <?php if (!$row['status']) echo "selected"; ?>>Absent</option>
        </select><br><br>

        <label for="absence_reason">Absence Reason:</label>
        <input type="text" id="absence_reason" name="absence_reason" value="<?php echo $row['absence_reason']; ?>"><br><br>

        <input type="submit" value="Update">
    </form>
    <?php
}
$conn->close();
?>
