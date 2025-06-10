<?php
session_start();
require_once '../includes/db_operations.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$taskOps = new TaskOperations($conn);

// Check if task ID is provided
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Get task details
$task = $taskOps->getTask($task_id, $user_id);

if (!$task) {
    header('Location: dashboard.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $effort = $_POST['effort'];
    $urgency = $_POST['urgency'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    if ($taskOps->updateTask($task_id, $title, $description, $priority, $effort, $urgency, $due_date, $status, $user_id)) {
        $_SESSION['success'] = "Task updated successfully.";
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Failed to update task. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task - TaskNexus</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="composer-container">
        <div class="composer-modal">
            <div class="composer-header">
                <h1 class="composer-title">Edit Task</h1>
                <p class="composer-subtitle">Update task details</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form class="composer-form" method="POST" action="">
                <div class="form-group">
                    <label class="form-label" for="title">Task Title</label>
                    <input type="text" id="title" name="title" class="form-input" value="<?php echo htmlspecialchars($task['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-input" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="priority">Priority</label>
                        <div class="select-wrapper">
                            <select id="priority" name="priority" class="form-select" required>
                                <option value="high" <?php echo $task['priority'] === 'high' ? 'selected' : ''; ?>>High</option>
                                <option value="medium" <?php echo $task['priority'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                                <option value="low" <?php echo $task['priority'] === 'low' ? 'selected' : ''; ?>>Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="effort">Effort Level</label>
                        <div class="select-wrapper">
                            <select id="effort" name="effort" class="form-select" required>
                                <option value="high" <?php echo $task['effort'] === 'high' ? 'selected' : ''; ?>>High</option>
                                <option value="medium" <?php echo $task['effort'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                                <option value="low" <?php echo $task['effort'] === 'low' ? 'selected' : ''; ?>>Low</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="urgency">Urgency</label>
                        <div class="select-wrapper">
                            <select id="urgency" name="urgency" class="form-select" required>
                                <option value="high" <?php echo $task['urgency'] === 'high' ? 'selected' : ''; ?>>High</option>
                                <option value="medium" <?php echo $task['urgency'] === 'medium' ? 'selected' : ''; ?>>Medium</option>
                                <option value="low" <?php echo $task['urgency'] === 'low' ? 'selected' : ''; ?>>Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="due-date">Due Date</label>
                        <input type="date" id="due-date" name="due_date" class="form-input" value="<?php echo $task['due_date']; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <div class="select-wrapper">
                        <select id="status" name="status" class="form-select" required>
                            <option value="pending" <?php echo $task['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="in_progress" <?php echo $task['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo $task['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="delayed" <?php echo $task['status'] === 'delayed' ? 'selected' : ''; ?>>Delayed</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 