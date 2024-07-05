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

// Include the database connection file
include 'database.php';

// Get the user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details
$sql_fetch_user = "SELECT first_name, last_name, address, username, email, status, zip_code FROM users WHERE id = ?";
$stmt_fetch_user = $conn->prepare($sql_fetch_user);
$stmt_fetch_user->bind_param("i", $user_id);
$stmt_fetch_user->execute();
$result_fetch_user = $stmt_fetch_user->get_result();

if ($result_fetch_user->num_rows > 0) {
    $user = $result_fetch_user->fetch_assoc();
} else {
    echo "User details not found.";
    exit();
}

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_details'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $zip_code = $_POST['zip_code'];

    // Prepare the SQL statement to update user details
    $sql_update_user = "UPDATE users SET first_name = ?, last_name = ?, address = ?, username = ?, email = ?, status = ?, zip_code = ? WHERE id = ?";
    $stmt_update_user = $conn->prepare($sql_update_user);
    $stmt_update_user->bind_param("sssssssi", $first_name, $last_name, $address, $username, $email, $status, $zip_code, $user_id);

    // Execute the statement
    if ($stmt_update_user->execute()) {
        // Redirect to account page with success message
        header("Location: account.php?update=success");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle form submission for updating password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current hashed password from the database
    $sql_fetch_password = "SELECT password FROM users WHERE id = ?";
    $stmt_fetch_password = $conn->prepare($sql_fetch_password);
    $stmt_fetch_password->bind_param("i", $user_id);
    $stmt_fetch_password->execute();
    $result_fetch_password = $stmt_fetch_password->get_result();

    if ($result_fetch_password->num_rows > 0) {
        $row = $result_fetch_password->fetch_assoc();
        $stored_password = $row['password'];

        // Verify if the current password matches the stored hashed password
        if (password_verify($current_password, $stored_password)) {
            // Validate the new password and confirm password
            if ($new_password !== $confirm_password) {
                $error_message = "New password and confirm password do not match.";
            } else if (strlen($new_password) < 8) {
                $error_message = "Password must be at least 8 characters long.";
            } else {
                // Hash the new password before storing
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Prepare SQL statement to update password
                $sql_update_password = "UPDATE users SET password = ? WHERE id = ?";
                $stmt_update_password = $conn->prepare($sql_update_password);
                $stmt_update_password->bind_param("si", $hashed_password, $user_id);

                // Execute the statement
                if ($stmt_update_password->execute()) {
                    // Redirect to account page with success message
                    header("Location: account.php?password_update=success");
                    exit();
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            }
        } else {
            $error_message = "Current password is wrong.";
        }
    } else {
        $error_message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Manager - PUIHAHA Videos</title>
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

        #displayInfo h4 {
            margin-bottom: 15px;
        }

        #displayInfo h4 strong {
            font-weight: bold;
            color: white; /* Change color to make it stand out */
        }

        #displayInfo .info-label {
            font-size: 1.1em;
            color: white;

        }
        #displayInfo .info-value {
            font-size: 1.2em;
            color: white;
        }

        #displayInfo button {
            width: 200px;
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
        <h1>Hello, user #<span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type",{
                strings: ["<?php echo htmlspecialchars($user_id); ?>"],
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
                        <div class="col-md-8">
                            <div class="greetings">
                                <h1>Account Information</h1>
                            </div>
                            <p></p>

                            <!-- Edit Details Form -->
                            <form id="editForm" action="account.php" method="post" style="display: none;">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="inputStatus" class="form-label">Status</label>
                                    <select id="inputStatus" class="form-select" name="status" required>
                                        <option selected disabled>Choose...</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Divorced</option>
                                        <option>Widowed</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="zip_code" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo htmlspecialchars($user['zip_code']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="update_details">Save Changes</button>
                                <button type="button" class="btn btn-danger" onclick="discardChanges('editForm')">Discard Changes</button>
                            </form>

                            <!-- Edit Password Form -->
                            <form id="passwordForm" action="account.php" method="post" style="display: none;">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
                                if (isset($error_message)) {
                                    echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($error_message) . '</div>';
                                }
                            }
                            ?>
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <button type="submit" class="btn btn-warning" name="update_password">Update Password</button>
                                <button type="button" class="btn btn-danger" onclick="discardChanges('passwordForm')">Discard Changes</button>
                            </form>

                            <!-- Display Information -->
                            <div id="displayInfo">
                                <h4><strong class="info-label">First Name: </strong><span class="info-value"><?php echo htmlspecialchars($user['first_name']); ?></span></h4>
                                <h4><strong class="info-label">Last Name: </strong><span class="info-value"><?php echo htmlspecialchars($user['last_name']); ?></span></h4>
                                <h4><strong class="info-label">Address: </strong><span class="info-value"><?php echo htmlspecialchars($user['address']); ?></span></h4>
                                <h4><strong class="info-label">Username: </strong><span class="info-value"><?php echo htmlspecialchars($user['username']); ?></span></h4>
                                <h4><strong class="info-label">Email: </strong><span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span></h4>
                                <h4><strong class="info-label">Status: </strong><span class="info-value"><?php echo htmlspecialchars($user['status']); ?></span></h4>
                                <h4><strong class="info-label">Zip Code: </strong><span class="info-value"><?php echo htmlspecialchars($user['zip_code']); ?></span></h4>
                                <button id="editDetailsButton" class="btn btn-primary mt-3" onclick="toggleEdit('editForm')">Edit Information</button>
                                <button id="editPasswordButton" class="btn btn-warning mt-3" onclick="toggleEdit('passwordForm')">Edit Password</button>
                            </div>
                            <p></p>
                        </div>
                        <div class="col-md-4">
                            <div id="image-container">
                                <img src="https://i.pinimg.com/474x/4e/79/73/4e7973bf3a86dc66138d09db96b3cc9a.jpg" class="img-fluid" alt="Profile Image">                                
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
                        <p>Copyright &copy; 2024; All images used in this website are from the Internet.</p>
                        <p>Designed by PIPOPIP, June 2024.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function toggleEdit(formId) {
        var forms = document.querySelectorAll('form');
        var displayInfo = document.getElementById('displayInfo');

        forms.forEach(form => {
            if (form.id === formId) {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        });

        displayInfo.style.display = 'none';
    }

    function discardChanges(formId) {
        var form = document.getElementById(formId);
        form.reset(); // Reset the form fields
        form.style.display = 'none'; // Hide the form
        document.getElementById('displayInfo').style.display = 'block'; // Show the display info
    }
</script>

</body>
</html>