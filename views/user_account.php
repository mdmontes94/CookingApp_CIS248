<?php include 'views/partials/header.php'; ?>

<div class="container">
    <h1>Welcome, <?= htmlspecialchars($user['name']) ?>!</h1>

    <p>Email: <?= htmlspecialchars($user['email']) ?></p>

    <p><a href="index.php?action=logout">Logout</a></p>
</div>

<?php include 'views/partials/footer.php'; ?>
