<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: signin.php");
    exit(); // Make sure no further code executes after redirect
}

// If logged in, proceed with the rest of your page code
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Pipopip - PUIHAHA Videos</title>
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
        <h1>Meet <span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type",{
                strings: ["the Team", "the Developers", "Pipopip"],
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
                                <h1>We are Pipopip</h1>
                            </div>
                            <div>
                                <p></p>
                            </div>
                            <div>
                                <p></p>
                                <h5>
                                    A group of four, second-year boys studying Bachelor of Science in Information Technology 
                                    (BSIT) at FEU Institute of Technology, Manila.
                                </h5>
                                <p></p>
                                <h5>
                                    We are Pau, Khai, Gab, and Gi.
                                </h5>
                                <p></p>
                                <h5>
                                    You can email any concerns, suggestions or questions to 202211394@fit.edu.ph
                                </h5>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card" style="background-color: #82420f; color: white">
                <img src="https://i.postimg.cc/9MSpZTKG/72777988-2451424078449963-1701144083889651712-n.jpg" class="img-fluid">
                <div class="card-body">
                    <h4 class="card-text">Adia, Paulo Lorenzo</h4>
                    <p class="card-text">Back-end Developer</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card" style="background-color: #82420f; color: white">
                <img src="https://i.postimg.cc/FKTGFwxC/403862841-318790914274463-2122232432582973097-n.jpg" class="img-fluid">
                <div class="card-body">
                    <h4 class="card-text">Carls, Kyle Philippe</h4>
                    <p class="card-text">Back-end Developer</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card" style="background-color: #82420f; color: white">
                <img src="https://i.postimg.cc/MTjssdys/2af97244-8ee8-4a83-ab9a-4ea87e2c36eb.jpg" class="img-fluid">
                <div class="card-body">
                    <h4 class="card-text">Valerio, Gabriel Eduard</h4>
                    <p class="card-text">Back-end Developer</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card" style="background-color: #82420f; color: white">
                <img src="https://i.postimg.cc/1XhvbwBy/3b1a115e-fc7a-4b92-a80e-b6a7e50b1ac8.jpg" class="img-fluid">
                <div class="card-body">
                    <h4 class="card-text">Victorino, Gian Carlo</h4>
                    <p class="card-text">Front-end Developer</p>
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