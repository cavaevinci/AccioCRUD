<?php
// Tests for Narudzba class

include './classes/narudzba.php';
require './config.php'; // Include the config file to establish database connection

class NarudzbaTests {
    protected $narudzba;

    public function __construct($db) {
        $this->narudzba = new Narudzba($db);
    }

    public function runTests() {
        $this->testFindAll();
        $this->testFindOne();
        $this->testSave();
        // Add more tests here as needed
    }

    public function testFindAll() {
        $result = $this->narudzba->findAll();
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindAll passed.\n";
        } else {
            echo "Test testFindAll failed.\n";
        }
    }

    public function testFindOne() {
        $id = 1;
        $result = $this->narudzba->findOne($id);
        if (is_array($result) && isset($result['id']) && $result['id'] == $id) {
            echo "Test testFindOne passed.\n";
        } else {
            echo "Test testFindOne failed.\n";
        }
    }

    public function testSave() {
        $vrijeme_upita = '2024-03-15 15:00:00';
        $insertedId = $this->narudzba->save($vrijeme_upita);

        // Retrieve the inserted order and check if it matches the data we inserted
        $result = $this->narudzba->findOne($insertedId);
        if ($result && $result['vrijeme_upita'] == $vrijeme_upita) {
            echo "Test testSave passed.\n";
        } else {
            echo "Test testSave failed.\n";
        }

        // Clean up: Delete the inserted order from the database
        $this->narudzba->delete($insertedId);
    }
}

// Run tests
$narudzbaTests = new NarudzbaTests($db);
$narudzbaTests->runTests();
?>
