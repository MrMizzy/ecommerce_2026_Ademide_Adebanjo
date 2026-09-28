<?php
ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "db.php";
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta name="description" content="A simple task management application built with PHP and MySQL.">
        <title>Tasks</title>
        <link rel="stylesheet" type="text/css" href="app.css">
    </head>
    <body id="main">
        <h1>My Tasks</h1>
        <a href="create.php">+ Add Task</a>
        <div class="task-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="task-item">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <span><?php echo $row['status']; ?></span>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this task?');">Delete</a>
                </div>
                <?php endwhile; ?>
        </div>
    </body>
</html>
<?php $conn->close(); ?>