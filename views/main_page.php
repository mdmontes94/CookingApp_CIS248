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
        <p><strong>Cook Time:</strong> <?= htmlspecialchars($recipeOfTheDay['cook_time']) ?></p>
        <p>
            <a href="index.php?action=recipe_day" class="auth-button">View Full Recipe</a>
        </p>
    </div>
<?php endif; ?>

<div class="container" style="margin-top: 30px;">
    <h2>Not Sure What to Cook?</h2>
    <p>List the ingredients you have, and we'll help you find the perfect recipe.</p>
    <a href="index.php?action=find_recipe" class="auth-button">Find Recipes by Ingredients</a>
</div>


<?php include 'views/partials/footer.php'; ?>
