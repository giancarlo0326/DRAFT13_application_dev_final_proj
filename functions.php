<?php
require_once 'database.php';

// Function to add a new video
function addVideo($title, $genre, $director, $release_date, $available_copies, $video_type) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO videos (title, genre, director, release_date, available_copies, video_type) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssds", $title, $genre, $director, $release_date, $available_copies, $video_type);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    $stmt->close();
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to get all videos
function getAllVideos($conn) {
    $stmt = $conn->prepare("SELECT * FROM videos");
    $stmt->execute();
    $result = $stmt->get_result();
    $videos = [];
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }
    return $videos;
}

// Function to get video details by ID
function getVideoById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Function to edit a video
function editVideo($conn, $id, $title, $genre, $director, $release_date, $available_copies, $video_type) {
    $stmt = $conn->prepare("UPDATE videos SET title = ?, genre = ?, director = ?, release_date = ?, available_copies = ?, video_type = ? WHERE id = ?");
    $stmt->bind_param("ssssisi", $title, $genre, $director, $release_date, $available_copies, $video_type, $id);
    return $stmt->execute();
}

// Function to delete a video
function deleteVideo($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}


// Function to delete rent history entries related to a video
function deleteRentHistoryByVideoId($conn, $videoId) {
    $stmt = $conn->prepare("DELETE FROM rent_history WHERE video_id = ?");
    $stmt->bind_param("i", $videoId);
    return $stmt->execute();
}

// Function to rent a video
function rentVideo($conn, $userId, $videoId, $days) {
    $stmt = $conn->prepare("INSERT INTO rentals (user_id, video_id, rent_date, days) VALUES (?, ?, NOW(), ?)");
    $stmt->bind_param("iii", $userId, $videoId, $days);

    if ($stmt->execute()) {
        updateAvailableCopies($conn, $videoId, -1); // Decrease available copies by 1
        addRentHistory($conn, $userId, $videoId, 'rent'); // Add to rent history
        return true;
    } else {
        return false;
    }
}

// Function to return a video
function returnVideo($conn, $rentalId) {
    // Get video ID before deleting the rental record
    $stmt = $conn->prepare("SELECT video_id FROM rentals WHERE id = ?");
    $stmt->bind_param("i", $rentalId);
    $stmt->execute();
    $result = $stmt->get_result();
    $videoId = $result->fetch_assoc()['video_id'];

    // Delete rental record
    $stmt = $conn->prepare("DELETE FROM rentals WHERE id = ?");
    $stmt->bind_param("i", $rentalId);
    if ($stmt->execute()) {
        updateAvailableCopies($conn, $videoId, 1); // Increase available copies by 1
        addRentHistory($conn, $_SESSION['user_id'], $videoId, 'return'); // Add to rent history
        return true;
    } else {
        return false;
    }
}

// Function to update available copies of a video
function updateAvailableCopies($conn, $videoId, $increment) {
    $stmt = $conn->prepare("UPDATE videos SET available_copies = available_copies + ? WHERE id = ?");
    $stmt->bind_param("ii", $increment, $videoId);
    return $stmt->execute();
}

// Function to get user's rentals
function getUserRentals($conn, $userId) {
    $stmt = $conn->prepare("
        SELECT videos.title, videos.genre, videos.director, rentals.id as rental_id, rentals.rent_date 
        FROM rentals 
        INNER JOIN videos ON rentals.video_id = videos.id 
        WHERE rentals.user_id = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $rentals = [];
    while ($row = $result->fetch_assoc()) {
        $rentals[] = $row;
    }
    return $rentals;
}

// Function to get rental history
function getRentHistory($conn) {
    $stmt = $conn->prepare("
        SELECT rent_history.user_id, rent_history.video_id, rent_history.action_date, rent_history.action, 
               users.username, videos.title 
        FROM rent_history 
        INNER JOIN users ON rent_history.user_id = users.id 
        INNER JOIN videos ON rent_history.video_id = videos.id 
        ORDER BY rent_history.action_date DESC
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    return $history;
}

// Function to add rental history
function addRentHistory($conn, $userId, $videoId, $action) {
    $stmt = $conn->prepare("INSERT INTO rent_history (user_id, video_id, action_date, action) VALUES (?, ?, NOW(), ?)");
    $stmt->bind_param("iis", $userId, $videoId, $action);
    return $stmt->execute();
}
?>
