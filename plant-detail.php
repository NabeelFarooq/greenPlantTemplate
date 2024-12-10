<?php include('header.html'); ?>
<?php
include('db_config.php');

// Get the plant ID from the URL parameter
$plant_id = isset($_GET['plant_id']) ? $_GET['plant_id'] : 0;

if ($plant_id == 0) {
    die("No plant selected.");
}

// Fetch plant data
$query = "SELECT * FROM plants WHERE plant_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $plant_id);
$stmt->execute();
$plant_result = $stmt->get_result();

if ($plant_result->num_rows > 0) {
    $plant = $plant_result->fetch_assoc();
} else {
    die("Plant not found.");
}
?>

<title>Plant Details</title>

<div class="container">
    <h1>Plant Details</h1>

    <h2>
        <?php
        $plant_name = trim($plant['name']);
        $common_name = trim($plant['common_name']);

        echo htmlspecialchars($plant_name);

        if (!empty($common_name)) {
            echo " (" . htmlspecialchars($common_name) . ")";
        }
        ?>
    </h2>

    <p><strong>Kingdom:</strong> <?php echo htmlspecialchars($plant['kingdom']); ?></p>
    <p><strong>Family:</strong> <?php echo htmlspecialchars($plant['family']); ?></p>
    <p><strong>Group:</strong> <?php echo htmlspecialchars($plant['group']); ?></p>
    <p><strong>Synonymous Names:</strong> <?php echo htmlspecialchars($plant['synonymous_names']) ?: 'N/A'; ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($plant['description']) ?: 'N/A'; ?></p>
    <p><strong>Image:</strong></p>
    <img src="<?php echo htmlspecialchars($plant['image']); ?>" alt="Image of <?php echo htmlspecialchars($plant['name']); ?>" width="300" />

    <br><br>
    <a href="plant-table.php?plant_id=<?php echo $plant['plant_id']; ?>">View Compounds of <?php echo htmlspecialchars($plant['name']); ?></a>
</div>

<?php include('footer.html'); ?>

<!-- Link to global and page-specific styles -->
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/plant-detail.css">