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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="datetime-local"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add Data to Narudzba Table</h2>
    <form method="post">
        <label for="vrijeme_upita">Vrijeme Upita:</label><br>
        <input type="datetime-local" id="vrijeme_upita" name="vrijeme_upita"><br>
        <input type="submit" name="add_narudzba" value="Add Narudzba">
        <span class="error"><?php echo $narudzbaError; ?></span>
        <span class="success"><?php echo $narudzbaMsg; ?></span>
    </form>

    <h2>Narudzba Table</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Vrijeme Upita</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($narudzbaData as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['vrijeme_upita']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Add Data to Recept Table</h2>
    <form method="post">
        <label for="naziv">Naziv:</label><br>
        <input type="text" id="naziv" name="naziv"><br>
        <label for="vrijeme_pripreme">Vrijeme Pripreme:</label><br>
        <input type="text" id="vrijeme_pripreme" name="vrijeme_pripreme"><br>
        <input type="submit" name="add_recept" value="Add Recept">
        <span class="error"><?php echo $receptError; ?></span>
        <span class="success"><?php echo $receptMsg; ?></span>
    </form>

    <h2>Recept Table</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Vrijeme Pripreme</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receptData as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['naziv']; ?></td>
                <td><?php echo $row['vrijeme_pripreme']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Add Data to Sastojci Table</h2>
    <form method="post">
        <label for="naziv_sastojci">Naziv:</label><br>
        <input type="text" id="naziv_sastojci" name="naziv"><br>
        <label for="kolicina">Količina:</label><br>
        <input type="text" id="kolicina" name="kolicina"><br>
        <label for="mjerna_jedinica">Mjerna Jedinica:</label><br>
        <input type="text" id="mjerna_jedinica" name="mjerna_jedinica"><br>
        <input type="submit" name="add_sastojci" value="Add Sastojci">
        <span class="error"><?php echo $sastojciError; ?></span>
        <span class="success"><?php echo $sastojciMsg; ?></span>
    </form>

    <h2>Sastojci Table</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Količina</th>
                <th>Mjerna Jedinica</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sastojciData as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['naziv']; ?></td>
                <td><?php echo $row['kolicina']; ?></td>
                <td><?php echo $row['mjerna_jedinica']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Recept Sastojci Table</h2>
    <table>
        <thead>
            <tr>
                <th>Recept</th>
                <th>Sastojak</th>
                <th>Količina</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receptSastojciData as $row): ?>
            <tr>
                <td><?php echo $row['recept_naziv']; ?></td>
                <td><?php echo $row['sastojak_naziv']; ?></td>
                <td><?php echo $row['kolicina']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>
