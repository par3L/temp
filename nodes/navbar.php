<div class="header">
    <div class="logo">
      <img src="./assets/logo.png" alt="logo" class="logo" />
    </div>
    <div class="nav">
      <a href="./index.php">Home</a>
      <a href="./katalog-page.php">Katalog</a>
      <a href="#about" onclick="scrollToAbout()">About Us</a>
    </div>
    <div class="nav" id="parent-log">
      <div class="login">
        <div class="login-highlight">
          <?php if ($isLoggedIn): ?>
            <span>Hai, <?= htmlspecialchars($role) ?></span>
            <div class="dropdown">
              <i class="fa fa-caret-down dropdown-icon" onclick="toggleDropdown()"></i>
              <div class="dropdown-menu" id="dropdownMenu">
                <?php if ($role === 'Admin'): ?>
                  <a href="./dashboard.php">Dashboard</a>
                <?php else: ?>
                  <a href="edit-profile.php">Edit Profile</a>
                  <a href="cart.php">Cart</a>
                <?php endif; ?>
                <a href="./nodes/destroy_session.php">Logout</a>
              </div>
            </div>
          <?php else: ?>
            <a href="./login-page.php">Sign in</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
</div>