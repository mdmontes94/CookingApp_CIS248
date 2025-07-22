<?php include 'views/partials/header.php'; ?>

<div class="container">

    <?php
$selectedIngredientIds = $_SESSION['last_selected_ingredient_ids'] ?? [];
$ingredientNamesLower = $_SESSION['last_selected_ingredient_names'] ?? [];
?>


    <h1>Matched Recipes</h1>

    <?php if (!empty($allergyName)): ?>
    <p><strong>Allergen Filter:</strong> <?= htmlspecialchars($allergyName) ?></p>
    <?php endif; ?>

    <?php if (empty($matchedRecipes)): ?>
        <p>No recipes found that match your ingredients<?php if (!empty($selectedAllergy)) echo ' and allergen filters'; ?>.</p>
    <?php else: ?>
        <div class="recipe-results">
            <?php foreach ($matchedRecipes as $recipe): ?>
                <div class="recipe-card">
                    <h2>
                        <a href="index.php?action=view_recipe&id=<?= $recipe['recipe_id'] ?>">
                            <?= htmlspecialchars($recipe['name']) ?>
                        </a>
                    </h2>
                    <p><strong>Cook Time:</strong> <?= htmlspecialchars($recipe['cook_time']) ?></p>
                    <p><strong>Difficulty:</strong> <?= htmlspecialchars($recipe['difficulty']) ?></p>

                    <?php if (isset($recipe['match_percent'])): ?>
                        <p class="match-percent"><strong>Match:</strong> <?= $recipe['match_percent'] ?>%</p>
                    <?php endif; ?>

                    <p><strong>Ingredients:</strong></p>
                    <ul class="no-bullets">
                        <?php
                            $matched = [];
                            $nonMatched = [];

                            foreach ($recipe['ingredients'] as $ing) {
                                $isMatch = in_array($ing['ingredient_id'], $selectedIngredientIds);
                                if ($isMatch) {
                                    $matched[] = $ing;
                                } else {
                                    $nonMatched[] = $ing;
                                }
                            }

                            $sortedIngredients = array_merge($matched, $nonMatched);
                        ?>

                        <?php foreach ($sortedIngredients as $ing): ?>
                            <?php
                                $isMatch = in_array($ing['ingredient_id'], $selectedIngredientIds);
                            ?>
                            <li class="<?= $isMatch ? 'highlight-match' : '' ?>">
                                <?= $isMatch ? '✅ ' : '' ?>
                                <?= htmlspecialchars("{$ing['quantity']} {$ing['unit']} {$ing['name']}") ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/partials/footer.php'; ?>
