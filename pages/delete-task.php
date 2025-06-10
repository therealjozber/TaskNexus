<?php
session_start();
require_once '../includes/db_operations.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if task ID is provided
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit();
}

$taskOps = new TaskOperations($conn);
$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Delete the task
if ($taskOps->deleteTask($task_id, $user_id)) {
    $_SESSION['success'] = "Task deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete task.";
}

header('Location: dashboard.php');
exit();
?> 