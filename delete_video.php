<?php
session_start();
require 'database.php';
require 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$id = $_GET['id'];

if (deleteVideo($conn, $id)) {
    header("Location: videos.php");
    exit();
} else {
    echo "Failed to delete video.";
}
?>