<?php

class IngredientModel {

    private $db; // use only one property

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Get all ingredients
    public function getAllIngredients() {
        $stmt = $this->db->query("
            SELECT 
                i.ing_ID, 
                i.ing_name, 
                i.ing_category,
                c.ing_cat_name 
            FROM ca_ingredients i
            JOIN ca_ingcategory c ON i.ing_category = c.ing_cat_id
            ORDER BY i.ing_name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIngredientsByCategoryId($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM ca_ingredients WHERE ing_category = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM ca_ingcategory ORDER BY ing_cat_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAllergies() {
    $stmt = $this->db->prepare("SELECT allergy_ID, allergy_name FROM ca_allergies WHERE allergy_ID != 0 ORDER BY allergy_name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns [ ['allergy_ID' => 1, 'allergy_name' => 'Egg'], ... ]
    }

    public function getIngredientById($id) {
        $stmt = $this->db->prepare("SELECT * FROM ca_ingredients WHERE Ing_ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllergyById($id) {
    $stmt = $this->db->prepare("SELECT allergy_name FROM ca_allergies WHERE allergy_ID = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
