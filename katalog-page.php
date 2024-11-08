<?php
require './nodes/connection.php';
require './nodes/session-track.php';



$query = "SELECT 
            COALESCE(sticker_name, 'default sukri') AS name,
            COALESCE(description, 'default sukri') AS description,
            COALESCE(price, '0.00') AS harga,
            image_filename,
            id
          FROM stickers";

$result = mysqli_query($conn, $query);

$user = $_SESSION['username']; // Assuming `username` is stored in session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sticker_id'])) {
    $sticker_id = $_POST['sticker_id'];
    $check_query = "SELECT * FROM cart WHERE username = '$user' AND sticker_id = '$sticker_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        // Insert the sticker into the cart if it’s not already there
        $insert_query = "INSERT INTO cart (username, sticker_id) VALUES ('$user', '$sticker_id')";
        mysqli_query($conn, $insert_query);
        $message = "Sticker added to your cart!";
    } else {
        $message = "Sticker is already in your cart.";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Katalog Stiker | Sukri's Stickers</title>
    <link rel="stylesheet" href="./styles/katalog-page.css">
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    rel="stylesheet" />
</head>

<body>

    <?php require './nodes/navbar.php' ?>

    <div class="container">
        <h1>Katalog Stiker</h1>
        <p>Jelajahi koleksi stiker unik yang kekinian, dari yang lucu hingga edgy.</p>

        <!-- Display a message if set -->
        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <div class="cards">
            <?php while ($sticker = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <img src="./stickers/<?= htmlspecialchars($sticker['image_filename']) ?>" alt="Sticker Image">
                    <div class="card-name">
                        <h2><?= htmlspecialchars($sticker['name']) ?></h2>
                    </div>
                    <div class="card-desc">
                        <p><?= htmlspecialchars($sticker['description']) ?></p>
                    </div>
                    <div class="card-price">
                        <p>Rp. <?= htmlspecialchars($sticker['harga']) ?></p>
                    </div>
                    <div class="card-icon">
                        <div class="container-sekarang">
                            <button type="button" class="sekarang">Beli Sekarang!</button>
                        </div>
                        <div class="container-add">
                            <form action="katalog-page.php" method="post">
                                <input type="hidden" name="sticker_id" value="<?= $sticker['id'] ?>">
                                <button type="submit" class="cart" title="Add to Cart">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="footer">
        <div class="about-us-container">
            <div class="about-us-header">
                <p>Explore the unique stickers to add style and fun to your life!</p>
                <div class="copyright">
                    <p>&copy; 2023 Sukri's Stickers</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="./scripts/script.js"></script>
    <script src="./scripts/katalog-page.js"></script>
</body>

</html>