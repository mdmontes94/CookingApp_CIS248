<?php include 'views/partials/header.php'; ?>

<div class="container">
    <h1>What Ingredients Do You Have?</h1>

    <form id="ingredientForm" method="post" action="index.php?action=match_recipes">
        <!-- ✅ Corrected: removed array brackets from name -->
        <input type="hidden" name="ingredient" id="selectedIngredients" value="">

        <?php foreach ($categories as $category): ?>
            <div class="category-group">
                <h3><?= htmlspecialchars($category['ing_cat_name']) ?></h3>
                <div class="ingredient-buttons">
                    <?php foreach ($ingredients as $ingredient): ?>
                        <?php if ($ingredient['ing_category'] == $category['ing_cat_id']): ?>
                            <button type="button" class="ingredient-btn" data-id="<?= $ingredient['ing_ID'] ?>">
                                <?= htmlspecialchars($ingredient['ing_name']) ?>
                            </button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (!empty($allergies)): ?>
            <div class="form-group">
                <label for="allergy_filter">Exclude recipes with ingredients containing:</label>
                <select name="allergy_filter" id="allergy_filter" class="auth-button" style="margin-top: 5px;">
                    <option value="">None</option>
                    <?php foreach ($allergies as $a): ?>
                    <option value="<?= htmlspecialchars($a['allergy_ID']) ?>"><?= htmlspecialchars($a['allergy_name']) ?></option>
                    <?php endforeach; ?>

                </select>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user'])): ?>
            <button type="button" id="addToPantryBtn" class="auth-button">Add to Pantry</button>
        <?php endif; ?>

        <button type="submit" class="auth-button">Find Recipes</button>
    </form>
</div>

<script>
    const selected = new Set();

    document.querySelectorAll('.ingredient-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            if (selected.has(id)) {
                selected.delete(id);
                btn.classList.remove('selected');
            } else {
                selected.add(id);
                btn.classList.add('selected');
            }
            document.getElementById('selectedIngredients').value = Array.from(selected).join(',');
        });
    });

    <?php if (isset($_SESSION['user'])): ?>
    document.getElementById('addToPantryBtn').addEventListener('click', function () {
        const formData = new FormData(document.getElementById('ingredientForm'));
        fetch('index.php?action=add_to_pantry', {
            method: 'POST',
            body: formData
        })
            .then(res => res.text())
            .then(() => alert("Ingredients added to pantry"))
            .catch(err => {
                alert("Failed to add to pantry");
                console.error(err);
            });
    });
    <?php endif; ?>
</script>

<?php include 'views/partials/footer.php'; ?>
