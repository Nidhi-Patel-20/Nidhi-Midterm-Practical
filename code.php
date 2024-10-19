<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db.php';

function redirect($location, $message = '', $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
    header("Location: $location");
    exit();
}

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Add Trip
if (isset($_POST['add_trip'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO trips (first_name, last_name, dob, gender, email, phone, destination, tour_type, travel_dates) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $first_name, $last_name, $dob, $gender, $email, $phone, $destination, $tour_type, $travel_dates);

        $first_name = validateInput($_POST['first_name']);
        $last_name = validateInput($_POST['last_name']);
        $dob = validateInput($_POST['dob']);
        $gender = validateInput($_POST['gender']);
        $email = validateInput($_POST['email']);
        $phone = validateInput($_POST['phone']);
        $destination = validateInput($_POST['destination']);
        $tour_type = validateInput($_POST['tour_type']);
        $travel_dates = validateInput($_POST['travel_dates']);

        $stmt->execute();
        $stmt->close();

        redirect('index.php', 'Trip added successfully!');
    } catch (Exception $e) {
        redirect('index.php', 'Error adding trip: ' . $e->getMessage(), 'error');
    }
}

// Update Trip
if (isset($_POST['update_trip'])) {
    // Print POST data for debugging
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    try {
        $stmt = $conn->prepare("UPDATE trips SET first_name=?, last_name=?, dob=?, gender=?, email=?, phone=?, destination=?, tour_type=?, travel_dates=? WHERE id=?");
        if ($stmt === false) {
            throw new Exception($conn->error);
        }

        $stmt->bind_param("sssssssssi", $first_name, $last_name, $dob, $gender, $email, $phone, $destination, $tour_type, $travel_dates, $id);

        $id = $_POST['id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $destination = $_POST['destination'];
        $tour_type = $_POST['tour_type'];
        $travel_dates = $_POST['travel_dates'];

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $stmt->close();

        // Redirect with success message
        header('Location: index.php?message=Trip updated successfully');
        exit();
    } catch (Exception $e) {
        // Redirect with error message
        header('Location: index.php?error=' . urlencode($e->getMessage()));
        exit();
    }
}

// Delete Trip
if (isset($_GET['delete'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM trips WHERE id = ?");
        $stmt->bind_param("i", $id);

        $id = validateInput($_GET['delete']);

        $stmt->execute();
        $stmt->close();

        redirect('index.php', 'Trip deleted successfully!');
    } catch (Exception $e) {
        redirect('index.php', 'Error deleting trip: ' . $e->getMessage(), 'error');
    }
}

$conn->close();
?>