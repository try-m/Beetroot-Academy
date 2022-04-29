<?php
    require 'config.php';
    if (!empty($_SESSION["id"])) {
        header("Location: login.php");
    }
    if (isset($_POST["submit"])) {

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmpassword = $_POST["confirmpassword"];

        $duplicate = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
        if (mysqli_num_rows($duplicate) > 0) {
            echo "<script> alert('Email has already taken'); </script>";
        }else {
            if ($password === $confirmpassword) {
                $query = "INSERT INTO tb_user(name, email, password) VALUES('{$name}', '{$email}', '{$password}')";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    header("Location: login.php");
                }else {
                    echo "<script>Error: ".$query.mysqli_error($conn)."</script>";
                }
            }else {
                echo "<script> alert('Password does not match'); </script>";
            }
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
    <title>Registration</title>
</head>
<body>

    <div class="wrapper">
        <h2>Registration</h2>
        <form class="form" action="" method="post" autocomplete="off">
            <label for="name">Name</label>
            <input class="input" id="name" type="text" name="name" required value=""> <br>
            <label for="email">Email</label>
            <input class="input" id="email" type="email" name="email" required value=""> <br>
            <label for="password">Password</label>
            <input class="input" id="password" type="password" name="password" required value=""> <br>
            <label for="confirmpassword">Confirm Password</label>
            <input class="input" id="confirmpassword" type="password" name="confirmpassword" required value=""> <br>
            <button type="submit" name="submit">Register</button>
        </form>
        <br>
        <p>You have already an account! <a href="login.php">Login</a></p>
    </div>
    
</body>
</html>