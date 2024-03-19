<?php
// Include config file and class files
include 'config.php';
include './classes/narudzba.php';
include './classes/recept.php';
include './classes/sastojci.php';
include './classes/recept_sastojci.php';

// Initialize variables to hold error/success messages
$narudzbaMsg = $receptMsg = $sastojciMsg = '';
$narudzbaError = $receptError = $sastojciError = '';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Instantiate the Narudzba, Recept, and Sastojci classes
    $narudzba = new Narudzba($pdo);
    $recept = new Recept($pdo);
    $sastojci = new Sastojci($pdo);
    $receptSastojci = new ReceptSastojci($pdo); // Instantiate the ReceptSastojci class
    
    // Fetch data from the database using class methods
    $narudzbaData = $narudzba->findAll();
    $receptData = $recept->findAll();
    $sastojciData = $sastojci->findAll();
    $receptSastojciData = $receptSastojci->findAll(); // Fetch data from recept_sastojci table

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if form data is submitted and process accordingly
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process Narudzba form data
    if (isset($_POST['add_narudzba'])) {
        $narudzba = new Narudzba($pdo);
        $vrijeme_upita = $_POST['vrijeme_upita'];
        if ($narudzba->save($vrijeme_upita)) {
            $narudzbaMsg = "Narudzba added successfully.";
        } else {
            $narudzbaError = "Error adding Narudzba.";
        }
    }
    // Process Recept form data
    elseif (isset($_POST['add_recept'])) {
        $recept = new Recept($pdo);
        $naziv = $_POST['naziv'];
        $vrijeme_pripreme = $_POST['vrijeme_pripreme'];
        if ($recept->save($naziv, $vrijeme_pripreme)) {
            $receptMsg = "Recept added successfully.";
        } else {
            $receptError = "Error adding Recept.";
        }
    }
    // Process Sastojci form data
    elseif (isset($_POST['add_sastojci'])) {
        $sastojci = new Sastojci($pdo);
        $naziv = $_POST['naziv'];
        $kolicina = $_POST['kolicina'];
        $mjerna_jedinica = $_POST['mjerna_jedinica'];
        if ($sastojci->save($naziv, $kolicina, $mjerna_jedinica)) {
            $sastojciMsg = "Sastojci added successfully.";
        } else {
            $sastojciError = "Error adding Sastojci.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Tables</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Add Data to Narudzba Table</h2>
<form method="post">
    Vrijeme Upita: <input type="datetime-local" name="vrijeme_upita"><br>
    <input type="submit" name="add_narudzba" value="Add Narudzba">
    <span class="error"><?php echo $narudzbaError; ?></span>
    <span class="success"><?php echo $narudzbaMsg; ?></span>
</form>

<h2>Narudzba Table</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Vrijeme Upita</th>
    </tr>
    <?php foreach ($narudzbaData as $row): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['vrijeme_upita']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Add Data to Recept Table</h2>
<form method="post">
    Naziv: <input type="text" name="naziv"><br>
    Vrijeme Pripreme: <input type="text" name="vrijeme_pripreme"><br>
    <input type="submit" name="add_recept" value="Add Recept">
    <span class="error"><?php echo $receptError; ?></span>
    <span class="success"><?php echo $receptMsg; ?></span>
</form>

<h2>Recept Table</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Naziv</th>
        <th>Vrijeme Pripreme</th>
    </tr>
    <?php foreach ($receptData as $row): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['naziv']; ?></td>
        <td><?php echo $row['vrijeme_pripreme']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Add Data to Sastojci Table</h2>
<form method="post">
    Naziv: <input type="text" name="naziv"><br>
    Količina: <input type="text" name="kolicina"><br>
    Mjerna Jedinica: <input type="text" name="mjerna_jedinica"><br>
    <input type="submit" name="add_sastojci" value="Add Sastojci">
    <span class="error"><?php echo $sastojciError; ?></span>
    <span class="success"><?php echo $sastojciMsg; ?></span>
</form>

<h2>Sastojci Table</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Naziv</th>
        <th>Količina</th>
        <th>Mjerna Jedinica</th>
    </tr>
    <?php foreach ($sastojciData as $row): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['naziv']; ?></td>
        <td><?php echo $row['kolicina']; ?></td>
        <td><?php echo $row['mjerna_jedinica']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Recept Sastojci Table</h2>
<table>
    <tr>
        <th>Recept</th>
        <th>Sastojak</th>
        <th>Količina</th>
    </tr>
    <?php foreach ($receptSastojciData as $row): ?>
    <tr>
        <td><?php echo $row['recept_naziv']; ?></td> <!-- Display the name of the recept instead of ID -->
        <td><?php echo $row['sastojak_naziv']; ?></td> <!-- Display the name of the sastojak instead of ID -->
        <td><?php echo $row['kolicina']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
