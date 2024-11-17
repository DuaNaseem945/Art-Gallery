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

// Fetch products
$sql = "SELECT id, description, status, price, image_path FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Gallery</title>
    <style>
        body {
            background-color: rgb(14, 13, 13);
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .product {
            background-color: #1f1f1f;
            border-radius: 8px;
            margin: 1em;
            padding: 1em;
            display: inline-block;
            text-align: left;
            width: 300px;
            height: 480px;
        }

        .product img {
            width: 100%;
            border-radius: 8px;
            max-height: 60%;
        }

        .product h2 {
            font-size: 1.5em;
        }

        .product p {
            font-size: 1em;
        }

        .product .price {
            font-size: 1.2em;
            color: #4CAF50;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        body {
            background-image: url(background.jpg);
            background-attachment: fixed;
            height: 600px;
            margin: 0px;

        }

        .banner {
            height: 85px;
            width: 100%;
            font-size: 60px;

            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            text-align: left;
            font-weight: bold;
            padding: 20px;

            background-color: rgb(15, 2, 2);
            color: white;
            background-attachment: fixed;

        }

        .button1 {
            margin-left: 15px;
            margin-right: 6px;
            margin-bottom: 15px;
            margin-top: 10px;
            background-color: white;
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 10px;
            padding-bottom: 10px;
            font-weight: bold;
            cursor: pointer;

        }

        .button1 {
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        .button1:hover {
            background-color: rgb(49, 9, 16);
            color: rgb(247, 242, 242);
        }
    </style>
</head>
<body>
<section class="banner-section">
        <div class="section">
            <div>
                <header class="banner">
                    Art Gallery
                    <button class="button1">
                        <a href="abstract_art.html">
                            ABSTRACT ARTWORK
                        </a>
                    </button>
                    <button class="button1">
                        <a href="artist.html">ARTISTS</a>

                    </button>
                    <button class="button1">

                        <a href="portrait.html">
                            PORTRAITS
                        </a>
                    </button>
                    <button class="button1">

                        <a href="insertProduct.html">
                            INSERT PRODUCTS
                        </a>
                    </button>
                </header>
            </div>
        </div>
    </section>
    <h1>Gallery</h1>
    <div class="products-container">
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='uploads/" . htmlspecialchars($row['image_path']) . "' alt='Product Image'>";
                echo "<h2>" . htmlspecialchars($row['description']) . "</h2>";
                echo "<p>Status: " . htmlspecialchars($row['status']) . "</p>";
                echo "<p class='price'>$" . htmlspecialchars($row['price']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "No products found.";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
