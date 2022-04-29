<?php
    require 'config.php';
    if (!empty($_SESSION["id"])) {
        header("Location: index.php");
    }
    if (isset($_POST["submit"])) {
        
        $email = $_POST["email"];
        $password = $_POST["password"];
        $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            if ($password === $row["password"]) {
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                header("Location: index.php");
            }else {
                echo "<script> alert('Wrong password'); </script>";
            }
        }else {
            echo "<script> alert('User is not registered'); </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>

    <div class="wrapper">
        <h2>Login</h2>
        <form class="form" action="" method="post" autocomplete="off">
        <label for="email">Email</label>
        <input class="input" id="email" type="text" name="email" required value=""> <br>
        <label for="password">Password</label>
        <input class="input" id="password" type="password" name="password" required value=""> <br>
        <button type="submit" name="submit">Login</button>
        </form>
        <br>
        <p>Create Account! <a href="registration.php">Registration</a></p>
    </div>
    
</body>
</html>