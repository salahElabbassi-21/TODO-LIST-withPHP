<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'salahngcv2004');
define('DB_NAME', 'todo-list');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['task_id'])) {
    $task_id = (int) $_POST['task_id'];


    $stmt = $conn->prepare("UPDATE tasks SET is_completed = 1 WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the main page (index.php)
header("Location: index.php");
exit();
?>
