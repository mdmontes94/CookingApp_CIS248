<?php include 'views/partials/header.php'; ?>

<div class="container">
    <h1>Login</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="index.php?action=loginSubmit">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="index.php?action=signup">Sign up here</a>.</p>
</div>

<?php include 'views/partials/footer.php'; ?>
