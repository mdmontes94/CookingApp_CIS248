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

    <div style="margin-top: 30px; text-align: center;">
        <h3>New here?</h3>
        <p>By creating an account, you can:</p>
        <ul style="list-style: none; padding-left: 0;">
            <li>✅ Save your favorite recipes</li>
            <li>✅ Track ingredients in your pantry</li>
            <li>✅ Get personalized recipe matches</li>
        </ul>
        <p><a href="index.php?action=signup" class="auth-button">Create Account</a></p>
    </div>
</div>

<?php include 'views/partials/footer.php'; ?>
