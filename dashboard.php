<?php
require './nodes/connection.php';
require './nodes/session-track.php';

if ($role !== 'Admin') {
    header("Location: index.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// tamnbah
if (isset($_POST['add_sticker'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $file = $_FILES['image'];

    $file_name = basename($file['name']);
    $file_size = $file['size'];
    $temp_name = $file['tmp_name'];
    $upload_path = "stickers/" . $file_name;
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if ($file_size > 2097152) {
        echo "<script>alert('File is too large! Maximum size is 2MB.');</script>";
    } elseif (!in_array($file_extension, $allowed_extensions)) {
        echo "<script>alert('Invalid file type! Please upload JPG, PNG, JPEG, WEBP, or SVG files.');</script>";
    } else {
        if (move_uploaded_file($temp_name, $upload_path)) {
            $stmt = $conn->prepare("INSERT INTO stickers (sticker_name, description, price, image_filename) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $name, $description, $price, $file_name);
            if ($stmt->execute()) {
                echo "<script>alert('Sticker added successfully!');</script>";
            } else {
                echo "<script>alert('Database insertion failed: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Failed to upload image file. Please check file permissions.');</script>";
        }
    }
}

// update
if (isset($_POST['update_sticker'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $sql = "UPDATE stickers SET sticker_name = '$name', description = '$description', price = '$price' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Sticker updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update sticker.');</script>";
    }
}

// delete
if (isset($_POST['delete_sticker'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM stickers WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Sticker deleted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to delete sticker.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Sukri's Stickers</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body>
    <?php require './nodes/navbar.php'; ?>

    <div class="container">
        <div class="sidebar">
            <h2>Navigation</h2>
            <br>
            <a href="#" data-action="add">Add Sticker</a>
            <a href="#" data-action="update">Update Sticker</a>
            <a href="#" data-action="delete">Delete Sticker</a>
        </div>

        <div class="action">
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Select an option from the sidebar to manage stickers.</p>

            <!-- tambah -->
            <form id="addStickerForm" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Sticker Name" required><br>
                <textarea name="description" placeholder="Description" required></textarea><br>
                <input type="number" step="0.01" name="price" placeholder="Price" required><br>
                <input type="file" name="image" required><br>
                <button type="submit" name="add_sticker">Add Sticker</button>
            </form>


            <!-- update -->
            <div id="updateStickerSection" class="action-section">
                <h3>Update Sticker</h3>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM stickers");
                while ($sticker = mysqli_fetch_assoc($result)): ?>
                    <div class="sticker-card">
                        <img src="stickers/<?= htmlspecialchars($sticker['image_filename']) ?>" alt="<?= htmlspecialchars($sticker['sticker_name']) ?>">
                        <div class="sticker-info">
                            <h3><?= htmlspecialchars($sticker['sticker_name']) ?></h3>
                            <p><?= htmlspecialchars($sticker['description']) ?></p>
                            <p>$<?= htmlspecialchars($sticker['price']) ?></p>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $sticker['id'] ?>">
                            <input type="text" name="name" value="<?= htmlspecialchars($sticker['sticker_name']) ?>">
                            <input type="text" name="description" value="<?= htmlspecialchars($sticker['description']) ?>">
                            <input type="number" name="price" value="<?= htmlspecialchars($sticker['price']) ?>">
                            <button type="submit" name="update_sticker">Update</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- delete -->
            <div id="deleteStickerSection" class="action-section">
    <h3>Delete Sticker</h3>
    <?php
    $result = mysqli_query($conn, "SELECT * FROM stickers");
    while ($sticker = mysqli_fetch_assoc($result)): ?>
        <div class="sticker-card">
            <img src="stickers/<?= htmlspecialchars($sticker['image_filename']) ?>" alt="<?= htmlspecialchars($sticker['sticker_name']) ?>">
            <div class="sticker-info">
                <h3><?= htmlspecialchars($sticker['sticker_name']) ?></h3>
                <p><?= htmlspecialchars($sticker['description']) ?></p>
                <p>$<?= htmlspecialchars($sticker['price']) ?></p>
            </div>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $sticker['id'] ?>">
                <button type="submit" name="delete_sticker">Delete</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

            </div>

            <script src="./scripts/script.js"></script>
            <script src="./scripts/dashboard.js"></script>

</body>

</html>