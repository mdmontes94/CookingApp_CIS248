<?php include 'views/partials/header.php'; ?>

<div class="container">
    <h1>Welcome to MatchaMeal!</h1>
    <p>This is your home base for recipes, ingredients, and account management.</p>
    <p>Use the navigation menu above to log in or explore your account.</p>
</div>

<?php if (!empty($recipeOfTheDay)): ?>
    <div class="container">
        <h2>🍽️ Recipe of the Day</h2>
        <h3><?= htmlspecialchars($recipeOfTheDay['name']) ?></h3>
        <p><strong>Cook Time:</strong> <?= htmlspecialchars($recipeOfTheDay['cook_time']) ?> minutes</p>
        <p>
            <a href="index.php?action=recipe_day" class="auth-button">View Full Recipe</a>
        </p>
    </div>
<?php endif; ?>

<?php include 'views/partials/footer.php'; ?>