<?php
// Recept.php

include './config.php'; // Include the config file to establish database connection

class Recept {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * FROM recept";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function findOne($id) {
        $query = "SELECT * FROM recept WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function save($naziv, $vrijeme_pripreme) {
        $query = "INSERT INTO recept (naziv, vrijeme_pripreme) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$naziv, $vrijeme_pripreme]);
        return $this->db->lastInsertId();
    }

    public function update($id, $naziv, $vrijeme_pripreme) {
        $query = "UPDATE recept SET naziv = ?, vrijeme_pripreme = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$naziv, $vrijeme_pripreme, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM recept WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
?>
