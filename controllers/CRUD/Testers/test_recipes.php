<!DOCTYPE html>
<html>
<head>
    <title>Test Recipes API</title>
</head>
<body>
    <h1>Test Recipes API</h1>
    <!--Create recipe won't *really* be needed right now since that's gonna be setup through the phpmyadmin side of things-->
    <h2>Create Recipe</h2>
    <form action="../recipes_api.php" method="post">
        <input type="text" name="name" placeholder="Recipe Name"><br>
        <input type="text" name="instructions" placeholder="Instructions"><br>
        <input type="text" name="difficulty" placeholder="Difficulty"><br>
        <input type="number" name="cook_time" placeholder="Cook Time"><br>
        <button type="submit">Create Recipe</button>
    </form>

    <hr>

    <h2>Get All Recipes</h2>
    <form action="../recipes_api.php" method="get">
        <button type="submit">Fetch All</button>
    </form>

    <h2>Get Recipe by ID</h2>
    <form action="../recipes_api.php" method="get">
        <input type="number" name="recipe_id" placeholder="Recipe ID">
        <button type="submit">Fetch One</button>
    </form>

    <hr>

    <h2>Delete Recipe</h2>
    <form action="../recipes_api.php" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <input type="number" name="recipe_id" placeholder="Recipe ID">
        <button type="submit">Delete</button>
    </form>

    <h2>Update Recipe</h2>
    <form action="../recipes_api.php" method="post">
        <input type="hidden" name="_method" value="PUT">
        <input type="number" name="recipe_id" placeholder="Recipe ID"><br>
        <input type="text" name="name" placeholder="New Name"><br>
        <input type="text" name="ingredients" placeholder="New Ingredients"><br>
        <input type="text" name="instructions" placeholder="New Instructions"><br>
        <input type="text" name="difficulty" placeholder="New Difficulty"><br>
        <input type="number" name="cook_time" placeholder="New Cook Time"><br>
        <button type="submit">Update</button>
    </form>

</body>
</html>
