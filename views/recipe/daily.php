<?php include 'views/partials/header.php'; ?>

<?php if (!empty($recipe)): ?>
    <div class="container">
        <h1><?= htmlspecialchars($recipe['name']) ?></h1>
        <p><strong>Difficulty:</strong> <?= htmlspecialchars($recipe['difficulty']) ?> | 
           <strong>Cook Time:</strong> <?= htmlspecialchars($recipe['cook_time']) ?> minutes</p>

        <h3>Ingredients</h3>
        <?php if (!empty($ingredients)): ?>
        <ul>
            <?php foreach ($ingredients as $ingredient): ?>
                <li>
                    <?= htmlspecialchars($ingredient['quantity']) ?>
                    <?= htmlspecialchars($ingredient['unit']) ?>
                    <?= htmlspecialchars($ingredient['ingredient_name']) ?>
                </li>
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
