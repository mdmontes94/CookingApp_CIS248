<?php include 'views/partials/header.php'; ?>

<?php if (!empty($recipe)): ?>
    <div class="container">
        <?php if (isset($_SESSION['user']['id'])): ?>
            <?php if ($favorited): ?>
            <a href="index.php?action=favorite_remove&recipe_id=<?= $recipe['recipe_id'] ?>" class="auth-button" style="background-color: #e74c3c;">★ Unfavorite</a>
            <?php else: ?>
            <a href="index.php?action=favorite_add&recipe_id=<?= $recipe['recipe_id'] ?>" class="auth-button">☆ Add to Favorites</a>
            <?php endif; ?>
        <?php endif; ?>

        <h1><?= htmlspecialchars($recipe['name']) ?></h1>
        <p><strong>Difficulty:</strong> <?= htmlspecialchars($recipe['difficulty']) ?> | 
           <strong>Cook Time:</strong> <?= htmlspecialchars($recipe['cook_time']) ?></p>

        <h3>Ingredients</h3>
        <?php if (!empty($ingredients)): ?>
            <ul class="no-bullets">
                <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                <li><?= htmlspecialchars("{$ingredient['quantity']} {$ingredient['unit']} {$ingredient['name']}") ?></li>
                <?php endforeach; ?>
            </ul>

        <?php else: ?>
        <p>No ingredients listed for this recipe.</p>
        <?php endif; ?>
        <h3>Instructions</h3>
        <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>

        <p><a href="index.php" class="auth-button">← Back to Home</a></p>
    </div>
<?php else: ?>
    <div class="container">
        <p>Sorry, we couldn't load the recipe of the day.</p>
    </div>
<?php endif; ?>

<?php include 'views/partials/footer.php'; ?>
