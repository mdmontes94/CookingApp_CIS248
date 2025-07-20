<?php include 'views/partials/header.php'; ?>

<div class="container">
    <h1>Sign Up</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="index.php?action=signupSubmit">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <button type="submit">Sign Up</button>
    </form>

    <p>Already have an account? <a href="index.php?action=login">Login here</a>.</p>
</div>

<?php include 'views/partials/footer.php'; ?>
