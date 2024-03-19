<?php
// Sastojci.php

include './config.php'; // Include the config file to establish database connection

class Sastojci {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * FROM sastojci";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function findOne($id) {
        $query = "SELECT * FROM sastojci WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function save($naziv, $kolicina, $mjerna_jedinica) {
        $query = "INSERT INTO sastojci (naziv, kolicina, mjerna_jedinica) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$naziv, $kolicina, $mjerna_jedinica]);
        return $this->db->lastInsertId();
    }

    public function update($id, $naziv, $kolicina, $mjerna_jedinica) {
        $query = "UPDATE sastojci SET naziv = ?, kolicina = ?, mjerna_jedinica = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$naziv, $kolicina, $mjerna_jedinica, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM sastojci WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
?>
