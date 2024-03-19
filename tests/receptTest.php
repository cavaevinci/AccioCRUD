<?php
// Tests for Recept class

include './classes/recept.php'; // Include the Recept class
require './config.php'; // Include the config file to establish database connection

class ReceptTests {
    protected $recept;

    public function __construct($db) {
        $this->recept = new Recept($db);
    }

    public function runTests() {
        $this->testFindAll();
        $this->testFindOne();
        $this->testSave();
        // Add more tests here as needed
    }

    public function testFindAll() {
        $result = $this->recept->findAll();
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindAll passed.\n";
        } else {
            echo "Test testFindAll failed.\n";
        }
    }

    public function testFindOne() {
        $id = 1;
        $result = $this->recept->findOne($id);
        if (is_array($result) && isset($result['id']) && $result['id'] == $id) {
            echo "Test testFindOne passed.\n";
        } else {
            echo "Test testFindOne failed.\n";
        }
    }

    public function testSave() {
        $naziv = 'Test Recipe';
        $vrijeme_pripreme = 30;
        $insertedId = $this->recept->save($naziv, $vrijeme_pripreme);

        // Retrieve the inserted recipe and check if it matches the data we inserted
        $result = $this->recept->findOne($insertedId);
        if ($result && $result['naziv'] == $naziv && $result['vrijeme_pripreme'] == $vrijeme_pripreme) {
            echo "Test testSave passed.\n";
        } else {
            echo "Test testSave failed.\n";
        }

        // Clean up: Delete the inserted recipe from the database
        $this->recept->delete($insertedId);
    }
}

// Run tests
$receptTests = new ReceptTests($db);
$receptTests->runTests();
?>
