<?php

require("dbc.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone_number = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $department = isset($_POST['department']) ? trim($_POST['department']) : '';
    $appointment_date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $doctor = isset($_POST['doctor']) ? trim($_POST['doctor']) : '';
    $notes = isset($_POST['message']) ? trim($_POST['message']) : '';


    if (empty($full_name) || empty($email) || empty($phone_number) || empty($department) || empty($appointment_date) || empty($doctor)) {
        echo "All fields are required!";
        exit;
    }


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address!";
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO appointments (full_name, email, phone_number, department, appointment_date, doctor, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo "Database error: " . mysqli_error($conn);
        mysqli_close($conn);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $full_name, $email, $phone_number, $department, $appointment_date, $doctor, $notes);
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