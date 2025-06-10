<?php
session_start();
require_once '../includes/db_operations.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$taskOps = new TaskOperations($conn);

// Get task statistics
$stats = $taskOps->getTaskStats($_SESSION['user_id']);

// Get all tasks
$tasks = $taskOps->getAllTasks($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang=
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TaskNexus</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">TaskNexus</div>
            <nav>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link active">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="task-composer.php" class="nav-link">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a href="insights.php" class="nav-link">Reports</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Dashboard</h1>
                <div class="user-menu">
                    <div class="user-avatar" id="userAvatar">
                        <?php echo strtoupper($_SESSION['first_name'][0] . $_SESSION['last_name'][0]); ?>
                    </div>
                    <a href="logout.php" class="btn btn-secondary">Logout</a>
                </div>
            </header>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Active Assignments Card -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Active Assignments</h3>
                    </div>
                    <div class="card-value"><?php echo $stats['active_tasks']; ?></div>
                    <p class="card-description">Tasks currently in progress</p>
                </div>

                <!-- Efficiency Score Card -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Efficiency Score</h3>
                    </div>
                    <div class="card-value">
                        <?php 
                        $total_tasks = $stats['active_tasks'] + $stats['completed_tasks'];
                        $efficiency = $total_tasks > 0 ? round(($stats['completed_tasks'] / $total_tasks) * 100) : 0;
                        echo $efficiency . '%';
                        ?>
                    </div>
                    <p class="card-description">Based on task completion rate</p>
                </div>

                <!-- Delayed Tasks Card -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Delayed Tasks</h3>
                    </div>
                    <div class="card-value"><?php echo $stats['delayed_tasks']; ?></div>
                    <p class="card-description">Tasks past due date</p>
                </div>
            </div>

            <!-- Recent Tasks Table -->
            <div class="dashboard-card" style="margin-top: 2rem;">
                <div class="card-header">
                    <h3 class="card-title">Recent Tasks</h3>
                </div>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th class="table-header">Task</th>
                                <th class="table-header">Priority</th>
                                <th class="table-header">Due Date</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td class="table-row"><?php echo htmlspecialchars($task['title']); ?></td>
                                <td class="table-row">
                                    <span class="status-badge status-<?php echo $task['priority']; ?>">
                                        <?php echo ucfirst($task['priority']); ?>
                                    </span>
                                </td>
                                <td class="table-row"><?php echo date('M d, Y', strtotime($task['due_date'])); ?></td>
                                <td class="table-row">
                                    <span class="status-badge status-<?php echo $task['status']; ?>">
                                        <?php echo ucfirst($task['status']); ?>
                                    </span>
                                </td>
                                <td class="table-row">
                                    <a href="edit-task.php?id=<?php echo $task['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                                    <a href="delete-task.php?id=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 