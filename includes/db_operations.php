<?php
require_once '../config/database.php';

class TaskOperations {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Create a new task (INSERT)
    public function createTask($title, $description, $priority, $effort, $urgency, $due_date, $user_id) {
        $sql = "INSERT INTO tasks (title, description, priority, effort, urgency, due_date, user_id, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssi", $title, $description, $priority, $effort, $urgency, $due_date, $user_id);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

    // Get all tasks (SELECT)
    public function getAllTasks($user_id) {
        $sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    // Get a single task (SELECT)
    public function getTask($task_id, $user_id) {
        $sql = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    // Update a task (UPDATE)
    public function updateTask($task_id, $title, $description, $priority, $effort, $urgency, $due_date, $status, $user_id) {
        $sql = "UPDATE tasks 
                SET title = ?, description = ?, priority = ?, effort = ?, 
                    urgency = ?, due_date = ?, status = ?, updated_at = NOW() 
                WHERE id = ? AND user_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssii", $title, $description, $priority, $effort, $urgency, $due_date, $status, $task_id, $user_id);
        
        return $stmt->execute();
    }

    // Delete a task (DELETE)
    public function deleteTask($task_id, $user_id) {
        $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $task_id, $user_id);
        
        return $stmt->execute();
    }

    // Get task statistics
    public function getTaskStats($userId) {
        $stats = [
            'active_tasks' => 0,
            'completed_tasks' => 0,
            'delayed_tasks' => 0
        ];

        // Get active tasks count
        $query = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ? AND status = 'in-progress'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stats['active_tasks'] = $row['count'];

        // Get completed tasks count
        $query = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ? AND status = 'completed'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stats['completed_tasks'] = $row['count'];

        // Get delayed tasks count
        $query = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ? AND status = 'delayed'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stats['delayed_tasks'] = $row['count'];

        return $stats;
    }
}
?> 