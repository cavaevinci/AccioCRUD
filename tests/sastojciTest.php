<?php
// Tests for Sastojci class

include './classes/sastojci.php'; // Include the Sastojci class
require './config.php'; // Include the config file to establish database connection

class SastojciTests {
    protected $sastojci;

    public function __construct($db) {
        $this->sastojci = new Sastojci($db);
    }

    public function runTests() {
        $this->testFindAll();
        $this->testFindOne();
        $this->testSave();
        // Add more tests here as needed
    }

    public function testFindAll() {
        $result = $this->sastojci->findAll();
        if (is_array($result) && count($result) > 0) {
            echo "Test testFindAll passed.\n";
        } else {
            echo "Test testFindAll failed.\n";
        }
    }

    public function testFindOne() {
        $id = 1;
        $result = $this->sastojci->findOne($id);
        if (is_array($result) && isset($result['id']) && $result['id'] == $id) {
            echo "Test testFindOne passed.\n";
        } else {
            echo "Test testFindOne failed.\n";
        }
    }

    public function testSave() {
        $naziv = 'Test Ingredient';
        $kolicina = 100;
        $mjerna_jedinica = 'g';
        $insertedId = $this->sastojci->save($naziv, $kolicina, $mjerna_jedinica);

        // Retrieve the inserted ingredient and check if it matches the data we inserted
        $result = $this->sastojci->findOne($insertedId);
        if ($result && $result['naziv'] == $naziv && $result['kolicina'] == $kolicina && $result['mjerna_jedinica'] == $mjerna_jedinica) {
            echo "Test testSave passed.\n";
        } else {
            echo "Test testSave failed.\n";
        }

        // Clean up: Delete the inserted ingredient from the database
        $this->sastojci->delete($insertedId);
    }
}

// Run tests
$sastojciTests = new SastojciTests($db);
$sastojciTests->runTests();
?>
