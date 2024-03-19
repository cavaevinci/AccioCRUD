<?php
// ReceptSastojci.php

include './config.php'; // Include the config file to establish database connection

class ReceptSastojci {   
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT rs.*, r.naziv AS recept_naziv, s.naziv AS sastojak_naziv 
                  FROM recept_sastojci rs
                  JOIN recept r ON rs.recept_id = r.id
                  JOIN sastojci s ON rs.sastojak_id = s.id";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function findByReceptId($receptId) {
        $query = "SELECT rs.*, s.naziv AS sastojak_naziv 
                  FROM recept_sastojci rs
                  JOIN sastojci s ON rs.sastojak_id = s.id
                  WHERE rs.recept_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$receptId]);
        return $stmt->fetchAll();
    }

    public function findBySastojakId($sastojakId) {
        $query = "SELECT rs.*, r.naziv AS recept_naziv 
                  FROM recept_sastojci rs
                  JOIN recept r ON rs.recept_id = r.id
                  WHERE rs.sastojak_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$sastojakId]);
        return $stmt->fetchAll();
    }

    public function findOne($receptId, $sastojakId) {
        $query = "SELECT * FROM recept_sastojci WHERE recept_id = ? AND sastojak_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$receptId, $sastojakId]);
        return $stmt->fetch();
    }

    public function save($receptId, $sastojakId, $kolicina) {
        $query = "INSERT INTO recept_sastojci (recept_id, sastojak_id, kolicina) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$receptId, $sastojakId, $kolicina]);
        return $this->db->lastInsertId();
    }

    public function update($receptId, $sastojakId, $kolicina) {
        $query = "UPDATE recept_sastojci SET kolicina = ? WHERE recept_id = ? AND sastojak_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$kolicina, $receptId, $sastojakId]);
    }

    public function delete($receptId, $sastojakId) {
        $query = "DELETE FROM recept_sastojci WHERE recept_id = ? AND sastojak_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$receptId, $sastojakId]);
    }
}
?>
