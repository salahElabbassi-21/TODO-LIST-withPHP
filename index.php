<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'salahngcv2004');
define('DB_NAME', 'todo-list');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert task into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = $_POST["task_name"];
    if (!empty($task_name)) {
        $stmt = $conn->prepare("INSERT INTO tasks (task_name, is_completed) VALUES (?, 0)"); // Default is_completed as 0 (not completed)
        $stmt->bind_param("s", $task_name);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch open and completed tasks from the database
$open_tasks = $conn->query("SELECT * FROM tasks WHERE is_completed = 0");
$close_tasks = $conn->query("SELECT * FROM tasks WHERE is_completed = 1");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TO DO LIST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container m-5">
    <h1 class="text-center m-4">TO DO LIST CODING WITH SALAH</h1>

    <!-- Add Task Form -->
    <form class="mb-4" action="index.php" method="POST">
        <label for="task">Task:</label>
        <div class="input-group">
            <input type="text" class="form-control" id="task" name="task_name" required placeholder="Enter task">
            <button type="submit" class="btn btn-primary">Add Task</button>
        </div>
    </form>

    <!-- Open and Completed Tasks Inline -->
    <div class="row">
        <!-- Open Tasks Section -->
        <div class="col-md-6">
            <h2>Open Tasks</h2>
            <ul class="list-group">
                <?php if ($open_tasks->num_rows > 0): ?>
                    <?php while ($row = $open_tasks->fetch_assoc()): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?php echo htmlspecialchars($row["task_name"]); ?>
                            <div>
                                <!-- Complete Button -->
                                <form method="post" action="complete_task.php" style="display:inline;">
                                    <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Complete</button>
                                </form>
                                <!-- Delete Button -->
                                <form method="post" action="delete_task.php" style="display:inline;">
                                    <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item">No open tasks</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Completed Tasks Section -->
        <div class="col-md-6">
            <h2>Completed Tasks</h2>
            <ul class="list-group">
                <?php if ($close_tasks->num_rows > 0): ?>
                    <?php while ($row = $close_tasks->fetch_assoc()): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?php echo htmlspecialchars($row["task_name"]); ?>
                            <form method="post" action="delete_task.php" style="display:inline;">
                                <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="list-group-item">No completed tasks</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close();
?>
