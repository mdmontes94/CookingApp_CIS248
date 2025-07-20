<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cooking App</title>
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

<!-- Hamburger menu (mobile only) -->
<button class="hamburger" onclick="toggleMenu()" aria-label="Toggle navigation"></button>

<!-- Navigation -->
<nav id="navMenu" class="navMenu collapsed">
    <a href="index.php" class="<?= $current === 'home' ? 'active' : '' ?>">Home</a>
    <a href="index.php?action=account" class="<?= $current === 'account' ? 'active' : '' ?>">My Account</a>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="index.php?action=logout">Logout</a>
    <?php else: ?>
        <a href="index.php?action=login" class="<?= $current === 'login' ? 'active' : '' ?>">Login</a>
        <a href="index.php?action=signup" class="<?= $current === 'signup' ? 'active' : '' ?>">Sign Up</a>
    <?php endif; ?>
</nav>
