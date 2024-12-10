<?php include('header.html'); ?>
<?php
include('db_config.php');

// Get the compound ID from the URL parameter
$compound_id = isset($_GET['compound_id']) ? $_GET['compound_id'] : 0;

if ($compound_id == 0) {
    die("No compound selected.");
}

// Fetch compound data
$query = "SELECT * FROM plantcompounds WHERE compound_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $compound_id);
$stmt->execute();
$compound_result = $stmt->get_result();
$compound = $compound_result->fetch_assoc();

// Fetch the associated plant's data
$query = "SELECT * FROM plants WHERE plant_id = ?";
$plant_stmt = $conn->prepare($query);
$plant_stmt->bind_param("i", $compound['plant_id']);
$plant_stmt->execute();
$plant_result = $plant_stmt->get_result();
$plant = $plant_result->fetch_assoc();
?>




<div class="container">
    <h1>Compound Details: <?php echo htmlspecialchars($compound['compound_name']); ?></h1>

    <!-- Links -->
    <p><a href="plant-table.php?plant_id=<?php echo $plant['plant_id']; ?>">Back to Compounds of <?php echo htmlspecialchars($plant['name']); ?></a></p>

    <h2>Compound Information</h2>
    <p><strong>Formula:</strong> <?php echo htmlspecialchars($compound['formula']); ?></p>
    <p><strong>SMILES:</strong> <?php echo htmlspecialchars($compound['smiles']); ?></p>
    <p><strong>Functional Groups:</strong> <?php echo htmlspecialchars($compound['functional_groups']); ?></p>
    <p><strong>2D Structure:</strong> <?php echo htmlspecialchars($compound['structure_2d']); ?></p>
    <p><strong>3D Structure:</strong> <?php echo htmlspecialchars($compound['structure_3d']); ?></p>

</div>

<?php include('footer.html'); ?>
<!-- Link to global and page-specific styles -->
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/compound-detail.css">