<?php

require("dbc.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (empty($name) || empty($email) || empty($subject)) {
        echo "All fields are required!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address!";
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        echo "Database error: " . mysqli_error($conn);
        mysqli_close($conn);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);
    $execute = mysqli_stmt_execute($stmt);

    if ($execute === false) {
        echo "Error inserting record: " . mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit;
    }

    echo "OK";

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
