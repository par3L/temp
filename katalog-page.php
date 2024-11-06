<?php
require './nodes/connection.php';
require './nodes/session-track.php';

$query = "SELECT 
            COALESCE(sticker_name, 'default sukri') AS name,
            COALESCE(description, 'default sukri') AS description,
            COALESCE(price, '0.00') AS harga,
            image_filename 
          FROM stickers";

$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Stiker | Sukri's Stickers</title>
    <link rel="icon" href="./assets/logo.png" type="image/x-icon">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="./styles/katalog-page.css">
</head>

<body>

    <?php require './nodes/navbar.php' ?>

    <div class="container">
        <h1>Katalog Stiker</h1>
        <p>Jelajahi koleksi stiker unik yang kekinian, dari yang lucu hingga edgy.</p>

        <div class="cards">
            <?php while ($sticker = mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <img src="./stickers/<?= htmlspecialchars($sticker['image_filename']) ?>" alt="Sticker Image">
                <h2><?= htmlspecialchars($sticker['name']) ?></h2>
                <p><?= htmlspecialchars($sticker['description']) ?></p>
                <p>Rp. <?= htmlspecialchars($sticker['harga']) ?></p>
                <div class="card-icons">
                    <i class="fa-solid fa-cart-shopping"></i>
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
</body>

</html>