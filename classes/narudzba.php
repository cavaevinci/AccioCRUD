<?php
// arudzba.php

include './config.php';

class Narudzba {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $query = "SELECT * FROM narudzba";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function findOne($id) {
        $query = "SELECT * FROM narudzba WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function save($vrijeme_upita) {
        $query = "INSERT INTO narudzba (vrijeme_upita) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$vrijeme_upita]);
        return $this->db->lastInsertId();
    }

    public function update($id, $vrijeme_upita) {
        $query = "UPDATE narudzba SET vrijeme_upita = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$vrijeme_upita, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM narudzba WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }
}
