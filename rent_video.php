<?php
session_start();
require 'database.php';
require 'functions.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $videoId = $_POST['video_id'];
    $days = $_POST['days'];

    if (rentVideo($conn, $userId, $videoId, $days)) {
        header("Location: viewrentals.php");
        exit();
    } else {
        $error = "Failed to rent video.";
    }
}

// Fetch video details for display
if (isset($_GET['id'])) {
    $videoId = $_GET['id'];
    $video = getVideoById($conn, $videoId);
    if (!$video) {
        header("Location: videos.php");
        exit();
    }
} else {
    header("Location: videos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Video - PUIHAHA Videos</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav>
    <a class="home-link" href="index.php">
        <img src="https://i.postimg.cc/CxLnK8q1/PUIHAHA-VIDEOS.png" alt="Home">
    </a>
    <input type="checkbox" id="sidebar-active">
    <label for="sidebar-active" class="open-sidebar-button">
        <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
    </label>
    <label id="overlay" for="sidebar-active"></label>
    <div class="links-container">
        <label for="sidebar-active" class="close-sidebar-button">
            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg>
        </label>
        <a href="videos.php">Videos</a>
        <a href="viewrentals.php">Rentals</a>
        <a href="rent_history.php">Rent History</a>
        <a href="account.php">Account</a>
        <a href="aboutdevs.php">About Us</a>
        <a href="signin.php">Sign In</a>
        <a href="signup.php">Sign Up</a>
        <a href="logout.php">Log Out</a>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="centered-container">
                <h1>Rent Video: <?php echo htmlspecialchars($video['title']); ?></h1>
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="rent_video.php">
                    <input type="hidden" name="video_id" value="<?php echo htmlspecialchars($video['id']); ?>">
                    <div class="mb-3">
                        <label for="days" class="form-label">Number of Days</label>
                        <input type="number" class="form-control" id="days" name="days" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-success">Rent</button>
                    <a href="videos.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="collab">
                    <img src="https://i.postimg.cc/CxLnK8q1/PUIHAHA-VIDEOS.png" class="collab-img img-fluid">
                </div>
            </div>
            <div class="col-md-4">
                <div class="footerBottom text-center text-md-end">
                    <h3>Application Development and Emerging Technologies - Final Project</h3>
                    <p>This website is for educational purposes only and no copyright infringement is intended.</p>
                    <p>Copyright &copy;2024; All images used in this website are from the Internet.</p>
                    <p>Designed by PIPOPIP, June 2024.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
