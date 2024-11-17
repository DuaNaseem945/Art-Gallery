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

// Directory to save uploaded images
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($_FILES["product_image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$uploadOk = 1;

// Check if image file is an actual image or fake image
$check = getimagesize($_FILES["product_image"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Check file size (e.g., 5MB max)
if ($_FILES["product_image"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        // Prepare form data
        $description = htmlspecialchars($_POST['description']);
        $status = htmlspecialchars($_POST['status']);
        $price = htmlspecialchars($_POST['price']);
        $imagePath = htmlspecialchars(basename($_FILES["product_image"]["name"]));

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO products (description, status, price, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $description, $status, $price, $imagePath);

        // Execute the query and check for success
        if ($stmt->execute()) {
            $alertMessage = "New record created successfully";
        } else {
            $alertMessage = "Error: " . $stmt->error;
        }

        // Close connections
        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();

// Display alert and redirect using JavaScript
echo "<script type='text/javascript'>
    alert('$alertMessage');
    window.location.href = 'insertProduct.html';
</script>";

?>




