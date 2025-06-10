<?php
session_start();
require_once '../includes/db_operations.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$taskOps = new TaskOperations($conn);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $effort = $_POST['effort'];
    $urgency = $_POST['urgency'];
    $due_date = $_POST['due_date'];
    $user_id = $_SESSION['user_id'];

    if ($taskOps->createTask($title, $description, $priority, $effort, $urgency, $due_date, $user_id)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Failed to create task. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Composer - TaskNexus</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="composer-container">
        <div class="composer-modal">
            <div class="composer-header">
                <h1 class="composer-title">Create New Task</h1>
                <p class="composer-subtitle">Fill in the details to create a new task</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form class="composer-form" method="POST" action="">
                <div class="form-group">
                    <label class="form-label" for="title">Task Title</label>
                    <input type="text" id="title" name="title" class="form-input" placeholder="Enter task title" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-input" rows="4" placeholder="Enter task description"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="priority">Priority</label>
                        <div class="select-wrapper">
                            <select id="priority" name="priority" class="form-select" required>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="effort">Effort Level</label>
                        <div class="select-wrapper">
                            <select id="effort" name="effort" class="form-select" required>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="urgency">Urgency</label>
                        <div class="select-wrapper">
                            <select id="urgency" name="urgency" class="form-select" required>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="due-date">Due Date</label>
                        <input type="date" id="due-date" name="due_date" class="form-input" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 