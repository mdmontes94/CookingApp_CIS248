<?php

function getConnection() {
    $dataURL = 'mysql:host=localhost;dbname=cookingappdb';
    $user = '';
    $pass = '';

    try {
        $db = new PDO($dataURL, $user, $pass);
        return $db;
    } catch(PDOException $e) {
        $error = $e->getMessage();
        echo "<p>Connection Error: $error </p>";
        return null;
    }
}

?>