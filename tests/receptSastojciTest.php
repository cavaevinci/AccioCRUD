<?php
// Tests for ReceptSastojci class

include './classes/recept_sastojci.php'; // Include the ReceptSastojci class
require './config.php'; // Include the config file to establish database connection

class ReceptSastojciTests {
    protected $receptSastojci;

    public function __construct($db) {
        $this->receptSastojci = new ReceptSastojci($db);
    }

    public function runTests() {
        $this->testFindAll();
        $this->testFindByReceptId();
        $this->testFindBySastojakId();
        $this->testSave();
        // Add more tests here as needed
    }

    public function testFindAll() {
        $result = $this->receptSastojci->findAll();
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindAll passed.\n";
        } else {
            echo "Test testFindAll failed.\n";
        }
    }

    public function testFindByReceptId() {
        $receptId = 1;
        $result = $this->receptSastojci->findByReceptId($receptId);
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindByReceptId passed.\n";
        } else {
            echo "Test testFindByReceptId failed.\n";
        }
    }

    public function testFindBySastojakId() {
        $sastojakId = 1;
        $result = $this->receptSastojci->findBySastojakId($sastojakId);
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindBySastojakId passed.\n";
        } else {
            echo "Test testFindBySastojakId failed.\n";
        }
    }

    public function testSave() {
        $receptId = 1;
        $sastojakId = 1;
        $kolicina = 10;
        $insertedId = $this->receptSastojci->save($receptId, $sastojakId, $kolicina);

        // Retrieve the inserted association and check if it matches the data we inserted
        $result = $this->receptSastojci->findOne($receptId, $sastojakId);
        if ($result && $result['recept_id'] == $receptId && $result['sastojak_id'] == $sastojakId && $result['kolicina'] == $kolicina) {
            echo "Test testSave passed.\n";
        } else {
            echo "Test testSave failed.\n";
        }

        // Clean up: Delete the inserted association from the database
        $this->receptSastojci->delete($receptId, $sastojakId);
    }
}

// Run tests
$receptSastojciTests = new ReceptSastojciTests($db);
$receptSastojciTests->runTests();
?>
