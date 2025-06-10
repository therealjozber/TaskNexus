<?php
require_once '../includes/auth_check.php';
require_once '../includes/db_operations.php';

$taskOps = new TaskOperations($conn);

// Get task statistics
$stats = $taskOps->getTaskStats($_SESSION['user_id']);

// Get all tasks for the table
$tasks = $taskOps->getAllTasks($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insights - TaskNexus</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="insights-container">
        <div class="insights-header">
            <h1 class="insights-title">Task Insights</h1>
            <div class="filter-bar">
                <div class="filter-group">
                    <button class="filter-button active">All</button>
                    <button class="filter-button">This Week</button>
                    <button class="filter-button">This Month</button>
                    <button class="filter-button">This Quarter</button>
                </div>
                <div class="filter-group">
                    <button class="export-button">Export PDF</button>
                    <button class="export-button">Export Excel</button>
                    <button class="export-button">Export PNG</button>
                </div>
            </div>
        </div>

        <div class="insights-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Task Completion Rate</h3>
                </div>
                <div class="chart-placeholder">
                    <?php
                    $total_tasks = $stats['active_tasks'] + $stats['completed_tasks'];
                    $completion_rate = $total_tasks > 0 ? round(($stats['completed_tasks'] / $total_tasks) * 100) : 0;
                    echo "Completion Rate: {$completion_rate}%";
                    ?>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Task Distribution</h3>
                </div>
                <div class="chart-placeholder">
                    <?php
                    echo "Active: {$stats['active_tasks']}<br>";
                    echo "Completed: {$stats['completed_tasks']}<br>";
                    echo "Delayed: {$stats['delayed_tasks']}";
                    ?>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3 class="chart-title">Task Status Overview</h3>
                </div>
                <div class="chart-placeholder">
                    <?php
                    $total = $stats['active_tasks'] + $stats['completed_tasks'] + $stats['delayed_tasks'];
                    if ($total > 0) {
                        $active_percent = round(($stats['active_tasks'] / $total) * 100);
                        $completed_percent = round(($stats['completed_tasks'] / $total) * 100);
                        $delayed_percent = round(($stats['delayed_tasks'] / $total) * 100);
                        echo "Active: {$active_percent}%<br>";
                        echo "Completed: {$completed_percent}%<br>";
                        echo "Delayed: {$delayed_percent}%";
                    } else {
                        echo "No tasks available";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="data-table">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th class="table-header">Task</th>
                        <th class="table-header">Priority</th>
                        <th class="table-header">Due Date</th>
                        <th class="table-header">Status</th>
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
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>