<?php include 'views/partials/header.php'; ?>

<div class="container">
    <h1>Welcome, <?= htmlspecialchars($user['name']) ?>!</h1>

    <p><a href="index.php?action=logout" class="auth-button">Logout</a></p>

    <!-- Favorites Section -->
    <h2>Your Favorite Recipes</h2>
    <?php if (empty($favorites)): ?>
        <p>You haven't favorited any recipes yet.</p>
    <?php else: ?>
        <ul class="no-bullets">
            <?php foreach ($favorites as $fav): ?>
                <li>
                    <a href="index.php?action=view_recipe&id=<?= $fav['recipe_id'] ?>">
                        <?= htmlspecialchars($fav['name'] ?? 'Unknown Recipe') ?>
                    </a>
                    <a href="index.php?action=favorite_remove&recipe_id=<?= $fav['recipe_id'] ?>" class="auth-button" style="background-color:#e74c3c;">Remove</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Pantry Section -->
    <h2>Your Pantry</h2>
<?php if (empty($pantryItems)): ?>
    <p>Your pantry is empty. Add ingredients from the <a href="index.php?action=find_recipe">ingredient selection page</a>.</p>
<?php else: ?>
    <?php
    $grouped = [];
    foreach ($pantryItems as $item) {
        $grouped[$item['ing_cat_name']][] = $item;
    }
    ?>
    <?php foreach ($grouped as $category => $items): ?>
        <h3><?= htmlspecialchars($category) ?></h3>
        <ul class="no-bullets">
            <?php foreach ($items as $item): ?>
            <li>
                <?= htmlspecialchars($item['Ing_Name']) ?>
                <button class="auth-button remove-btn" 
                style="background-color:#e74c3c;"
                data-id="<?= $item['Ing_ID'] ?>"
                data-name="<?= htmlspecialchars($item['Ing_Name']) ?>">
                Remove
                </button>
            </li>
            <?php endforeach; ?>
        </ul>

    <?php endforeach; ?>
<?php endif; ?>

</div>

<script>
    document.querySelectorAll('.remove-btn').forEach(button => {
        button.addEventListener('click', function () {
            const ingId = this.dataset.id;
            const ingName = this.dataset.name;

            if (!confirm(`Are you sure you want to remove ${ingName} from your pantry?`)) return;

            fetch(`index.php?action=remove_pantry_item_ajax&id=${ingId}`, {
                method: 'POST'
            })
            .then(response => response.text())
            .then(data => {
                const cleaned = data.trim();
                console.log("Server response:", cleaned); // inspect actual output

                if (cleaned.includes("success")) {
                    this.closest('li').remove();  // remove item from DOM
                } else {
                    alert("Failed to remove ingredient.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Error removing ingredient.");
            });
        });
    });
</script>

<?php include 'views/partials/footer.php'; ?>
