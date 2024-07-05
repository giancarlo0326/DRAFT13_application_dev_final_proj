<?php
session_start();
include 'database.php';

$login_error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $username, $hashed_password);
            if ($stmt->fetch()) {
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $user_id; // Store user ID in session

                    // Remember Me functionality (cookie)
                    if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                        $cookie_name = 'remember_user';
                        $cookie_value = $username;
                        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 30 days
                    } else {
                        // If not checked, unset the cookie if it exists
                        if (isset($_COOKIE['remember_user'])) {
                            unset($_COOKIE['remember_user']);
                            setcookie('remember_user', null, -1, '/');
                        }
                    }

                    header('Location: account.php');
                    exit;
                } else {
                    $login_error = 'Incorrect username or password.';
                }
            }
        } else {
            $login_error = 'Incorrect username or password.';
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - PUIHAHA Videos</title>
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

        #image-container {
            margin-top: 20px;
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
        <h1>Log in <span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type",{
                strings: ["Account"],
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
                        <div class="col-md-6">
                            <div class="greetings">
                                <h1>Log in before unlocking our features!</h1>
                            </div>
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <label for="inputUsername" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Enter your username">
                                </div>
                                <div class="mb-3">
                                    <label for="inputPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Enter your password">
                                </div>
                                <?php if (isset($login_error) && !empty($login_error)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $login_error; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberCheck" name="remember">
                                    <label class="form-check-label" for="rememberCheck">Remember me</label>
                                </div>
                                <button type="submit" class="btn btn-success">Sign In</button>
                            </form>
                            <p></p>
                        </div>
                        <div class="col-md-6">
                            <div id="image-container">
                                <img src="https://img.freepik.com/free-photo/young-person-using-his-smartphone-while-sitting-home-looking-blank-screen-with-copyspace_662251-2132.jpg" class="img-fluid" alt="Responsive image">
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
