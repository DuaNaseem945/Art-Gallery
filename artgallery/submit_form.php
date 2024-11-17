<?php
// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artist";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data and sanitize inputs
$artistName = htmlspecialchars($_POST['artistName']);
$email = htmlspecialchars($_POST['email']);
$portfolio = htmlspecialchars($_POST['portfolio']);
$genreOfArt = htmlspecialchars($_POST['genreOfArt']);
$exhibitions = htmlspecialchars($_POST['exhibitions']);
$awards = htmlspecialchars($_POST['awards']);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO contacts (artistName, email, portfolio, genreOfArt, exhibitions, awards) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $artistName, $email, $portfolio, $genreOfArt, $exhibitions, $awards);

// Execute the query and check for success
if ($stmt->execute()) {
    $alertMessage = "New record created successfully";
} else {
    $alertMessage = "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();

// Display alert and redirect using JavaScript
echo "<script type='text/javascript'>
    alert('$alertMessage');
    window.location.href = 'artist.html';
</script>";
?>
