<h2>Create User</h2>
<form action="../users_api.php" method="POST">
  Username: <input name="username"><br>
  Email: <input name="email"><br>
  Password: <input name="password"><br>
  <button type="submit">Create</button>
</form>

<hr>

<h2>Get User by ID</h2>
<form method="GET" action="../users_api.php">
  User ID: <input name="user_id">
  <button type="submit">Get User</button>
</form>

<hr>

<h2>Update User</h2>
<form method="POST" action="../users_api.php?_method=PUT">
  User ID: <input name="user_id"><br>
  New Username: <input name="username"><br>
  New Email: <input name="email"><br>
  <button type="submit">Update</button>
</form>

<hr>

<h2>Delete User</h2>
<form method="POST" action="../users_api.php?_method=DELETE">
  User ID: <input name="user_id">
  <button type="submit">Delete</button>
</form>
