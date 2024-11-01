<?php
    require 'config.php';
    if (!empty($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = $id");
        $row = mysqli_fetch_assoc($result);
    }else {
        header("Location: login.php");
    }

    $errors = "";

    $db = mysqli_connect("localhost", "root", "root", "todolist");

    if (isset($_POST['submit'])) {
        $task = $_POST['task'];
        if (empty($task)) {
            $errors = "You must fill in the task";
        }else {
            mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')");
            header("Location: index.php");
        }
    }

    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];
        mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
        header("Location: index.php");
    }

    $tasks = mysqli_query($db, "SELECT * FROM tasks");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link rel="stylesheet" href="todolist.css">
</head>
<body>

    <div class="wrapper">
        <h2>Welcome <?php echo $row["name"]; ?></h2>
        <form method="post" action="index.php"> 
        <?php if (isset($errors)) { ?>
            <p><?php echo $errors; ?></p>
        <?php } ?>
            <input class="task_input" type="text" name="task">
            <button class="task_btn" type="submit" name="submit">+</button>
        </form>
    </div>

    <div class="wrapper">
        <div class="container">
            <?php $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
                <div class="field-task"> 
                    <div class="number"><?php echo $i; ?></div>
                    <div class="task"><?php echo $row['task']; ?></div>
                    <div class="delete">
                        <a href="index.php?del_task=<?php echo $row['id']; ?>">Delete</a>
                    </div>
                </div>
            <?php $i++; } ?>
        </div>
        <a class="link" href="logout.php">Logout</a>
    </div>
    
</body>
</html>