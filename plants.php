<?php include('header.html'); ?>
<?php
include('db_config.php');
// Fetch all plants
$query = "SELECT * FROM plants";
$result = $conn->query($query);
?>

    <div class="container">
        <label for="plantDropdown">Select a Plant:</label>
        <select id="plantDropdown" onchange="window.location.href=this.value">
            <option value="">-- Select a Plant --</option>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="plant-table.php?plant_id=<?php echo $row['plant_id']; ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include('footer.html'); ?>

<!-- Link to global and page-specific styles -->
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/plants.css">