<?php
require "db.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $status = $_POST["status"];
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, status) VALUES (?, ?,
    ?)");
    $stmt->bind_param("sss", $title, $description, $status);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta name="description" content="A simple task management application built with PHP and MySQL.">
        <title>Add Task</title>
        <link rel="stylesheet" type="text/css" href="app.css">
    </head>
    <body>
        <h2>Add Task</h2>
        <form method="POST" action="create.php">
            <div>
                <label>Title</label>
                <input type="text" name="title" required>
            </div>
            <div>
                <label>Description</label>
                <textarea name="description"></textarea>
            </div>
            <div>
                <label>Status</label>
                <select name="status">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <button type="submit">Save Task</button>
        </form>
        <a href="index.php">Back</a>
    </body>
</html>