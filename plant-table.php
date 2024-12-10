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
$plant = $plant_result->fetch_assoc();

// Pagination logic
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch compounds data for the selected plant
$query = "SELECT c.*, p.name as plant_part 
          FROM plantcompounds c
          JOIN plantparts p ON c.part_id = p.part_id
          WHERE c.plant_id = ?
          LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $plant_id, $limit, $offset);
$stmt->execute();
$compounds_result = $stmt->get_result();

// Count total compounds for pagination
$count_query = "SELECT COUNT(*) AS total FROM plantcompounds WHERE plant_id = ?";
$count_stmt = $conn->prepare($count_query);
$count_stmt->bind_param("i", $plant_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_compounds = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_compounds / $limit);

?>

<title>Compounds of <?php echo htmlspecialchars($plant['name']); ?></title>

<div class="container">
    <h1>Compounds of <?php echo htmlspecialchars($plant['name']); ?></h1>



    <table>
        <thead>
            <tr>
                <th>Plant Name</th>
                <th>Plant Part</th>
                <th>Compound Name</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $compounds_result->fetch_assoc()) { ?>
                <tr>
                    <td><a href="plant-detail.php?plant_id=<?php echo $plant['plant_id']; ?>"><?php echo htmlspecialchars($plant['name']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['plant_part']); ?></td>
                    <td><a href="compound-detail.php?compound_id=<?php echo $row['compound_id']; ?>"><?php echo htmlspecialchars($row['compound_name']); ?></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href="plant-table.php?plant_id=<?php echo $plant_id; ?>&page=<?php echo $i; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
        <?php } ?>
    </div>

</div>
<br><br><br><br><br><br><br><br><br><br><br>
<?php include('footer.html'); ?>

<!-- Link to global and page-specific styles -->
<link rel="stylesheet" href="./css/styles.css">
<link rel="stylesheet" href="./css/plant-table.css">