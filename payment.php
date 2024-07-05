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

// Process form submission if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields (basic validation)
    $username = trim($_POST['username']);
    $bankNumber = trim($_POST['bankNumber']);
    $pin = trim($_POST['pin']);
    $paymentMethod = $_POST['paymentMethod'];

    // Example of basic validation (you should add more as needed)
    if (empty($username) || empty($bankNumber) || empty($pin)) {
        $error_message = "Please fill out all required fields.";
    } elseif (strlen($pin) !== 4 || !ctype_digit($pin)) {
        $error_message = "PIN must be a 4-digit number.";
    } else {
        // Process payment logic here (not implemented in this example)
        // You would typically integrate with a payment gateway and handle payment confirmation
        // Redirect to a success page or show a success message
        // Example:
        header("Location: payment_success.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - PUIHAHA Videos</title>
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
        <h1>Pay <span class="auto-type typed-text"></span></h1>
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
        <script>
            var typed = new Typed(".auto-type",{
                strings: ["with PayMaya", "with GCash", "with MasterCard", "Now"],
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
                        </div>
                        <div>
                            <form>
                                <p></p>
                                <h5>Bank Details:</h5>
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="bankNumber">Bank Number:</label>
                                    <input type="text" class="form-control" id="bankNumber" name="bankNumber" required>
                                </div>
                                <div class="form-group">
                                    <label for="pin">4-digit PIN:</label>
                                    <input type="password" class="form-control" id="pin" name="pin" minlength="4" maxlength="4" required>
                                </div>
                                <div class="form-group">
                                    <label for="paymentMethod">Payment Method:</label>
                                    <select class="form-control" id="paymentMethod" name="paymentMethod">
                                        <option value="paymaya">PayMaya</option>
                                        <option value="gcash">GCash</option>
                                        <option value="mastercard">MasterCard</option>
                                    </select>
                                </div>
                                <p></p>
                                <button type="submit" class="btn btn-success">Proceed to Payment</button>
                                <p></p>
                                <button type="button" class="btn btn-danger" id="discardRentBtn">Discard Rent</button>
                                <p></p>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div id="image-container">
                            <img src="https://www.pngall.com/wp-content/uploads/2/Credit-Card-PNG-Pic.png" class="img-fluid" alt="Credit Card Image">
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            
            // Fetch input values
            const username = document.getElementById('username').value;
            const bankNumber = document.getElementById('bankNumber').value;
            const pin = document.getElementById('pin').value;
            const paymentMethod = document.getElementById('paymentMethod').value;
            
            // Example: You can fetch the video details dynamically from your application logic
            const videoTitle = "Sample Video Title";
            const rentalDays = 7; // Example: Number of days for rental
            const amount = 100; // Example: Amount to be paid
            
            // Construct confirmation message
            const confirmationMessage = `You are paying $${amount} for renting "${videoTitle}" for ${rentalDays} days using ${paymentMethod}. Confirm?`;
            
            // Show confirmation dialog
            if (confirm(confirmationMessage)) {
                // Proceed with form submission
                form.submit();
            } else {
                // Optionally, handle cancel action
                console.log('Payment cancelled.');
            }
        });
    });
</script>

</body>
</html>
