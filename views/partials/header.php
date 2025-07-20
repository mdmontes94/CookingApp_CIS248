<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MatchaMeal</title>
    <link rel="stylesheet" href="assets/css/site.css">
    <script>
        function toggleMenu() {
            const nav = document.getElementById('navMenu');
            nav.classList.toggle('collapsed');
        }
    </script>
</head>
<body>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current = $_GET['action'] ?? 'home';
?>

<!-- Top Header Bar -->
<div class="topBar">
    <!-- Hamburger menu -->
    <button class="hamburger" onclick="toggleMenu()" aria-label="Toggle navigation"></button>

    <!-- Logo center -->
    <div class="nav-brand">
        <a href="index.php">
            <img src="assets/images/matchameal-logo.png" alt="MatchaMeal logo" class="logo">
        </a>
    </div>

    <!-- Auth links -->
    <div class="authLinks">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="index.php?action=account" class="auth-button">Account</a>
        <?php else: ?>
            <a href="index.php?action=login" class="auth-button">Get Started</a>
        <?php endif; ?>
    </div>

</div>

<!-- Navigation Menu -->
<nav id="navMenu" class="navMenu collapsed">
    <a href="index.php" class="<?= $current === 'home' ? 'active' : '' ?>">Home</a>
    <a href="index.php?action=recipe_day" class="<?= $current === 'daily' ? 'active' : '' ?>">Recipe of the Day</a>
    <a href="index.php?action=account" class="<?= $current === 'account' ? 'active' : '' ?>">My Account</a>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="index.php?action=logout">Logout</a>
    <?php else: ?>
        <a href="index.php?action=login" class="<?= $current === 'login' ? 'active' : '' ?>">Login</a>
        <a href="index.php?action=signup" class="<?= $current === 'signup' ? 'active' : '' ?>">Sign Up</a>
    <?php endif; ?>
</nav>
