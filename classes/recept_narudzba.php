<?php
// ReceptNarudzba.php

include './config.php'; // Include the config file to establish database connection

class ReceptNarudzba {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * FROM recept_narudzba";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function findByNarudzbaId($narudzbaId) {
        $query = "SELECT * FROM recept_narudzba WHERE narudzba_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$narudzbaId]);
        return $stmt->fetchAll();
    }

    public function findByReceptId($receptId) {
        $query = "SELECT * FROM recept_narudzba WHERE recept_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$receptId]);
        return $stmt->fetchAll();
    }

    public function findOne($receptId, $narudzbaId) {
        $query = "SELECT * FROM recept_narudzba WHERE recept_id = ? AND narudzba_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$receptId, $narudzbaId]);
        return $stmt->fetch();
    }

    public function save($receptId, $narudzbaId, $kolicina) {
        $query = "INSERT INTO recept_narudzba (recept_id, narudzba_id, kolicina) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$receptId, $narudzbaId, $kolicina]);
        return $this->db->lastInsertId();
    }

    public function update($receptId, $narudzbaId, $kolicina) {
        $query = "UPDATE recept_narudzba SET kolicina = ? WHERE recept_id = ? AND narudzba_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$kolicina, $receptId, $narudzbaId]);
    }

    public function delete($receptId, $narudzbaId) {
        $query = "DELETE FROM recept_narudzba WHERE recept_id = ? AND narudzba_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$receptId, $narudzbaId]);
    }
}
?>
