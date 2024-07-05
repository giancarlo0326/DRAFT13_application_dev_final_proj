<?php
session_start();
require 'database.php';
require 'functions.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Fetch user's rentals
$user_id = $_SESSION['user_id'];
$rentals = getUserRentals($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rentals - PUIHAHA Videos</title>
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
            position: relative;
        }

        .hero-content {
            position: relative;
            text-align: center;
            margin: 48px, 107.5px, 0px;
        }

        .card {
            background-color: #82420f;
            color: white;
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
        <h1>My <span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type", {
                strings: ["Rentals"],
                typeSpeed: 100,
                backSpeed: 10,
            });
        </script>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="centered-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="greetings">
                                <h1>My Rentals</h1>
                            </div>
                            <div>
                                <?php if (count($rentals) > 0): ?>
                                    <table class="table table-dark table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Genre</th>
                                                <th>Director</th>
                                                <th>Rent Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rentals as $rental): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($rental['title']); ?></td>
                                                    <td><?php echo htmlspecialchars($rental['genre']); ?></td>
                                                    <td><?php echo htmlspecialchars($rental['director']); ?></td>
                                                    <td><?php echo htmlspecialchars($rental['rent_date']); ?></td>
                                                    <td>
                                                        <form action="return_video.php" method="post" style="display:inline;">
                                                            <input type="hidden" name="rental_id" value="<?php echo htmlspecialchars($rental['rental_id']); ?>">
                                                            <button type="submit" class="btn btn-danger">Return</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No rentals found.</p>
                                <?php endif; ?>
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
