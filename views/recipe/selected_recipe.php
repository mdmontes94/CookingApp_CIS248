<?php include 'views/partials/header.php'; ?>

<div class="container">
    <?php if (!$recipe): ?>
        <h1>Recipe Not Found</h1>
        <p>Sorry, we couldn't find the recipe you're looking for.</p>
    <?php else: ?>

        <!-- Favorite Button (if logged in) -->
        <?php if (isset($_SESSION['user']['id'])): ?>
            <div style="margin-bottom: 10px;">
                <?php if (!empty($favorited)): ?>
                    <a href="index.php?action=favorite_remove&recipe_id=<?= $recipe['recipe_id'] ?>" class="auth-button" style="background-color: #e74c3c;">★ Unfavorite</a>
                <?php else: ?>
                    <a href="index.php?action=favorite_add&recipe_id=<?= $recipe['recipe_id'] ?>" class="auth-button">☆ Add to Favorites</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Recipe Info -->
        <h1><?= htmlspecialchars($recipe['name']) ?></h1>
        <p><strong>Cook Time:</strong> <?= htmlspecialchars($recipe['cook_time']) ?></p>
        <p><strong>Difficulty:</strong> <?= htmlspecialchars($recipe['difficulty']) ?></p>

        <!-- Ingredient Highlighting -->
        <?php
            $matched = [];
            $nonMatched = [];

            $selectedIngredientIds = $_SESSION['last_selected_ingredient_ids'] ?? [];
            $ingredientNamesLower = $_SESSION['last_selected_ingredient_names'] ?? [];

            if (!empty($recipe['ingredients'])) {
                foreach ($recipe['ingredients'] as $ing) {
                    $isMatch = in_array($ing['ingredient_id'], $selectedIngredientIds);
                    if ($isMatch) {
                        $matched[] = $ing;
                    } else {
                        $nonMatched[] = $ing;
                    }
                }
            }

            $sortedIngredients = array_merge($matched, $nonMatched);
        ?>

        <?php if (!empty($sortedIngredients)): ?>
            <h3>Ingredients</h3>
            <ul class="no-bullets">
                <?php foreach ($sortedIngredients as $ing): ?>
                    <?php $isMatch = in_array($ing['ingredient_id'], $selectedIngredientIds); ?>
                    <li class="<?= $isMatch ? 'highlight-match' : '' ?>">
                        <?= $isMatch ? '✅ ' : '' ?>
                        <?= htmlspecialchars("{$ing['quantity']} {$ing['unit']} {$ing['name']}") ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No ingredients listed for this recipe.</p>
        <?php endif; ?>

        <!-- Instructions -->
        <h3>Instructions</h3>
        <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p>

        <br>
        <a href="javascript:history.back()" class="auth-button">⬅ Back</a>
    <?php endif; ?>
</div>

<?php include 'views/partials/footer.php'; ?>
