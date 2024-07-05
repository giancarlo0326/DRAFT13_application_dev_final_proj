<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = null;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['videos'])) {
    $_SESSION['videos'] = array(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - PUIHAHA Videos</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-GVc61Aw9S4NbB32QZpjXe2z0Gzgpgj/YkKCP/pSvFKHlZ2s0s6P/h2NozH2BqljJx+3+2tJoHmxi6Cf2iG63KA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="centered-container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="greetings">
                                <h1>Lights, Camera, Action!</h1>
                            </div>
                            <div>
                                <p></p>
                            </div>
                            <div>
                                <p></p>
                                <h5>
                                    Whether you're in the mood for a timeless classic, the latest blockbuster, 
                                    or a hidden gem, we've got you covered. Start exploring now and let your next 
                                    great movie night begin here!
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="image-container">
                                <img src="https://i.pinimg.com/736x/a8/16/8a/a8168ad2dc2ce80bf218c6d10a3bff35.jpg" class="img-fluid" alt="Responsive image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-content">
        <h1>Rent <span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type",{
                strings: ["DVDs", "Blu-Rays", "Digitals", "anything"],
                typeSpeed: 100,
                backSpeed: 10,
                loop: true
            });
        </script>
    </div>

    
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="carousel-container">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://www.aopa.org/-/media/Images/AOPA-Main/Pilot-Gear-Blog/2020/April/movie.jpg?mw=880&mh=495&as=1&hash=27FC27139F986D3B989CF15D28D174EF" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-lg-block">
                                <h2>Rent videos on-the-go.</h2>
                                <p>Search, rent, watch, repeat.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://i.postimg.cc/1zjL0nPm/video-store-background-magicstudio-sc71bcpk13.png" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-lg-block">
                                <h2>Rent from different genres.</h2>
                                <p>So many, you'll never know what to watch next.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://keystoneacademic-res.cloudinary.com/image/upload/element/18/182043_iStock-11409882251.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-lg-block">
                                <h2>Rent Now!</h2>
                                <p>We don't have hidden fees.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
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
                    <i class="nav-icon fab fa-facebook"></i> <!-- Facebook icon using FontAwesome classes -->
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




    <i class="nav-icon fas fa-sign-in-alt"></i>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
