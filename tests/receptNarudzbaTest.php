<?php
// Tests for ReceptNarudzba class

include './classes/recept_narudzba.php'; // Include the ReceptNarudzba class
require './config.php'; // Include the config file to establish database connection

class ReceptNarudzbaTests {
    protected $receptNarudzba;

    public function __construct($db) {
        $this->receptNarudzba = new ReceptNarudzba($db);
    }

    public function runTests() {
        $this->testFindAll();
        $this->testFindByReceptId();
        $this->testFindByNarudzbaId();
        $this->testSave();
        // Add more tests here as needed
    }

    public function testFindAll() {
        $result = $this->receptNarudzba->findAll();
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindAll passed.\n";
        } else {
            echo "Test testFindAll failed.\n";
        }
    }

    public function testFindByReceptId() {
        $receptId = 1;
        $result = $this->receptNarudzba->findByReceptId($receptId);
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindByReceptId passed.\n";
        } else {
            echo "Test testFindByReceptId failed.\n";
        }
    }

    public function testFindByNarudzbaId() {
        $narudzbaId = 1;
        $result = $this->receptNarudzba->findByNarudzbaId($narudzbaId);
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindByNarudzbaId passed.\n";
        } else {
            echo "Test testFindByNarudzbaId failed.\n";
        }
    }

    public function testSave() {
        $receptId = 1;
        $narudzbaId = 1;
        $kolicina = 10;
        $insertedId = $this->receptNarudzba->save($receptId, $narudzbaId, $kolicina);

        // Retrieve the inserted association and check if it matches the data we inserted
        $result = $this->receptNarudzba->findOne($receptId, $narudzbaId);
        if ($result && $result['recept_id'] == $receptId && $result['narudzba_id'] == $narudzbaId && $result['kolicina'] == $kolicina) {
            echo "Test testSave passed.\n";
        } else {
            echo "Test testSave failed.\n";
        }

        // Clean up: Delete the inserted association from the database
        $this->receptNarudzba->delete($receptId, $narudzbaId);
    }
}

// Run tests
$receptNarudzbaTests = new ReceptNarudzbaTests($db);
$receptNarudzbaTests->runTests();
?>
