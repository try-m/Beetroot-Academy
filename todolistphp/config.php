<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "root", "application");
    if (!$conn) {
        echo "<script>alert('Connection failed.');</script>";
    }
?>