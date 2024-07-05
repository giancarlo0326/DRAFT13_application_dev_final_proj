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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = sanitizeInput($_POST['title']);
    $genre = sanitizeInput($_POST['genre']);
    $director = sanitizeInput($_POST['director']);
    $release_date = sanitizeInput($_POST['release_date']);
    $available_copies = sanitizeInput($_POST['available_copies']);
    $video_type = sanitizeInput($_POST['video_type']);

    // Update video in database
    if (editVideo($conn, $id, $title, $genre, $director, $release_date, $available_copies, $video_type)) {
        header("Location: videos.php");
        exit();
    } else {
        $error = "Failed to update video.";
    }
} else {
    // Fetch video details for editing
    $id = $_GET['id'];
    $video = getVideoById($conn, $id);
    if (!$video) {
        header("Location: videos.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Videos - PUIHAHA Videos</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        h1 {
            color: #fff;
            font-size: 75px;
            text-align: center;
        }

        .typed-text {
            color: #82420f;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 4rem;
            }
        }

        body {
            position: relative; /* Ensure body is relative for absolute positioning inside */
        }

        .hero-content {
            position: relative; /* Use relative positioning instead of absolute */
            text-align: center; /* Center align content */
            margin: 48px, 107.5px, 0px;
        }

    </style>
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
            <a href="add.php">Add Videos</a>
            <a href="videos.php">Videos</a>
        <a href="viewrentals.php">Rentals</a>
        <a href="rent_history.php">Rent History</a>
        <a href="account.php">Account</a>
        <a href="aboutdevs.php">About Us</a>
        <a href="signin.php">Sign In</a>
        <a href="signup.php">Sign Up</a>
        <a href="logout.php">Log Out</a>
        </div>
    </nav>

    <div class="hero-content">
        <h1>Edit your <span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type",{
                strings: ["entries"],
                typeSpeed: 100,
                backSpeed: 10,
            });
        </script>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="centered-container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="greetings">
                                <h1>Edit Video</h1>
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>
                                <form action="edit_video.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($video['id']); ?>">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($video['title']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="genre" class="form-label">Genre</label>
                                        <select class="form-select" id="genre" name="genre" required>
                                            <option selected disabled>Choose...</option>
                                            <option value="Action" <?php if ($video['genre'] == 'Action') echo 'selected'; ?>>Action</option>
                                            <option value="Comedy" <?php if ($video['genre'] == 'Comedy') echo 'selected'; ?>>Comedy</option>
                                            <option value="Drama" <?php if ($video['genre'] == 'Drama') echo 'selected'; ?>>Drama</option>
                                            <option value="Horror" <?php if ($video['genre'] == 'Horror') echo 'selected'; ?>>Horror</option>
                                            <option value="Science Fiction" <?php if ($video['genre'] == 'Science Fiction') echo 'selected'; ?>>Science Fiction</option>
                                            <option value="Fantasy" <?php if ($video['genre'] == 'Fantasy') echo 'selected'; ?>>Fantasy</option>
                                            <option value="Romance" <?php if ($video['genre'] == 'Romance') echo 'selected'; ?>>Romance</option>
                                            <option value="Thriller" <?php if ($video['genre'] == 'Thriller') echo 'selected'; ?>>Thriller</option>
                                            <option value="Animation" <?php if ($video['genre'] == 'Animation') echo 'selected'; ?>>Animation</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="director" class="form-label">Director</label>
                                        <input type="text" class="form-control" id="director" name="director" value="<?php echo htmlspecialchars($video['director']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="release_date" class="form-label">Release Date</label>
                                        <input type="date" class="form-control" id="release_date" name="release_date" value="<?php echo htmlspecialchars($video['release_date']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="available_copies" class="form-label">Available Copies</label>
                                        <input type="number" class="form-control" id="available_copies" name="available_copies" value="<?php echo htmlspecialchars($video['available_copies']); ?>" min="1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="video_type" class="form-label">Video Type</label>
                                        <select class="form-select" id="video_type" name="video_type" required>
                                            <option value="DVD" <?php if ($video['video_type'] == 'DVD') echo 'selected'; ?>>DVD</option>
                                            <option value="Blu-Ray" <?php if ($video['video_type'] == 'Blu-Ray') echo 'selected'; ?>>Blu-Ray</option>
                                            <option value="Digital" <?php if ($video['video_type'] == 'Digital') echo 'selected'; ?>>Digital</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="videoFile" class="form-label">Upload Video</label>
                                        <input type="file" class="form-control" id="videoFile" name="videoFile" accept="video/*">
                                    </div>
                                    <div class="mb-3">
                                        <label for="thumbnailFile" class="form-label">Upload Thumbnail</label>
                                        <input type="file" class="form-control" id="thumbnailFile" name="thumbnailFile" accept="image/*">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Video</button>
                                    <a href="videos.php" class="btn btn-danger">Discard Changes</a>
                                </form>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="image-container">
                                <img src="https://res.cloudinary.com/benbrandt/image/upload/v1409116509/director_and_editor_kxd7bw.jpg" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                    </div>
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
                        <p></p>
                        <p>This website is for educational purposes only and no copyright infringement is intended.</p>
                        <p>Copyright &copy;2024; All images used in this website are from the Internet.</p>
                        <p>Designed by PIPOPIP, June 2024.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
