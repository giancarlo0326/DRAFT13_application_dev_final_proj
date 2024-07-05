<?php
session_start();
include 'database.php';

$signup_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $zipCode = $_POST['zip_code'];
    $terms = isset($_POST['terms']) ? $_POST['terms'] : '';

    $errors = array();

    if (empty($firstName)) {
        $errors[] = "First Name is required";
    }
    if (empty($lastName)) {
        $errors[] = "Last Name is required";
    }
    if (empty($address)) {
        $errors[] = "Address is required";
    }
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8 || strlen($password) > 20 || !preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must be 8-20 characters long and contain at least one number.';
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($status) || $status == "Choose...") {
        $errors[] = "Status is required";
    }
    if (empty($zipCode)) {
        $errors[] = "Zip Code is required";
    }
    if (empty($terms)) {
        $errors[] = "You must agree to the terms and conditions";
    }

    if (empty($errors)) {
        $sql_check_username = "SELECT id FROM users WHERE username = ?";
        if ($stmt_check = $conn->prepare($sql_check_username)) {
            $stmt_check->bind_param("s", $username);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                $signup_error = 'Username already taken.';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql_insert_user = "INSERT INTO users (first_name, last_name, address, username, password, email, status, zip_code)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                if ($stmt_insert = $conn->prepare($sql_insert_user)) {
                    $stmt_insert->bind_param("ssssssss", $firstName, $lastName, $address, $username, $hashed_password, $email, $status, $zipCode);
                    if ($stmt_insert->execute()) {
                        $user_id = $stmt_insert->insert_id;
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['user_id'] = $user_id;
                        header('Location: account.php');
                        exit;
                    } else {
                        $signup_error = 'Error creating account.';
                    }
                } else {
                    $signup_error = 'Database error.';
                }
            }

            $stmt_check->close();
        } else {
            $signup_error = 'Database error.';
        }
    } else {
        foreach ($errors as $error) {
            $signup_error .= "<div class='alert alert-danger'>$error</div>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - PUIHAHA Videos</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1>Create <span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type", {
                strings: ["Account"],
                typeSpeed: 100,
                backSpeed: 10,
            });
        </script>
    </div>

    <div class="container mt-5">
        <div class="centered-container">
            <form class="row g-3" method="POST" action="signup.php">
                <div class="col-md-6">
                    <label for="inputFirstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="inputFirstName" name="first_name" placeholder="Jose Protacio Rizal" required>
                </div>
                <div class="col-md-6">
                    <label for="inputLastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="inputLastName" name="last_name" placeholder="Mercado" required>
                </div>
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress" name="address" placeholder="100 Nicanor Reyes St. Sampaloc, Manila" required>
                </div>
                <div class="col-md-6">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="inputUsername" name="username" placeholder="myusername" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Ilovetorentvideos123" required>
                </div>
                <div class="col-md-6">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" placeholder="someone@domain.com" required>
                </div>
                <div class="col-md-4">
                    <label for="inputStatus" class="form-label">Status</label>
                    <select id="inputStatus" class="form-select" name="status" required>
                        <option selected disabled>Choose...</option>
                        <option>Single</option>
                        <option>Married</option>
                        <option>Divorced</option>
                        <option>Widowed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="inputZip" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" id="inputZip" name="zip_code" placeholder="1008" required>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" name="terms" required>
                        <label class="form-check-label" for="gridCheck">
                            By signing up, I hereby agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a> of PUIHAHA Videos Limited.
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Sign Up</button>
                </div>
                <?php if (!empty($signup_error)): ?>
                    <div class="alert alert-danger mt-3"><?php echo $signup_error; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Welcome to PUIHAHA Videos Limited!</p>
                    <p>By signing up, you agree to the following terms and conditions:</p>
                    <ul>
                        <li>You must provide accurate and complete information during registration.</li>
                        <li>Your account is for personal use only and should not be shared with others.</li>
                        <li>You are responsible for maintaining the confidentiality of your account information.</li>
                        <li>All rentals are subject to availability and must be returned by the due date.</li>
                        <li>Late returns may incur additional fees.</li>
                        <li>We reserve the right to modify these terms at any time without prior notice.</li>
                    </ul>
                    <p>For more detailed information, please contact our support team.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
