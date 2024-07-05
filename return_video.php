<?php
session_start();
require 'database.php';
require 'functions.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Check if rental ID is provided
if (isset($_POST['rental_id'])) {
    $rentalId = $_POST['rental_id'];

    // Return the video
    if (returnVideo($conn, $rentalId)) {
        header("Location: viewrentals.php");
        exit();
    } else {
        echo "Failed to return video.";
    }
} else {
    echo "No rental ID provided.";
}
?>
