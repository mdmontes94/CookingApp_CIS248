<!DOCTYPE html>
<html>
    <head>
        <title>Test Favorites API</title>
    </head>
    <body>

        <h2>Add Favorite Recipe</h2>
        <form action="../favorites_api.php" method="POST">
        User ID: <input name="user_id"><br>
        Recipe ID: <input name="recipe_id"><br>
        <button type="submit">Add Favorite</button>
        </form>

        <hr>

        <h2>Get Favorites for User</h2>
        <form method="GET" action="../favorites_api.php">
        User ID: <input name="user_id">
        <button type="submit">Get Favorites</button>
        </form>

        <hr>

        <h2>Delete Favorite by ID</h2>
        <form method="POST" action="../favorites_api.php?_method=DELETE">
        Favorite ID: <input name="favorite_id">
        <button type="submit">Delete Favorite</button>
        </form>
    </body>
</html>