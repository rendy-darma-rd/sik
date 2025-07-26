<?php include 'session-check.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ninja List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sik";

if (isset($_GET['deleteid'])) {
    $id_ninja = $_GET['deleteid'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $conn->prepare("SELECT * FROM ninja WHERE id_ninja = ?");
        $query->execute([$id_ninja]);
        $selectedNinja = $query->fetch(PDO::FETCH_ASSOC);
        if ($selectedNinja) {
            $deleteQuery = $conn->prepare("DELETE FROM ninja WHERE id_ninja = ?");
            if ($deleteQuery->execute([$id_ninja])) {
                $info = "<p class='text-danger mt-2'>Ninja with ID " . htmlspecialchars($id_ninja) . " has been deleted.</p>";
            }
        }
    } catch (PDOException $e) {
        $info = "<p class='text-danger mt-2'>Failed to delete ninja: " . $e->getMessage() . "</p>";
    }
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $conn->query(
        "SELECT ninja.id_ninja AS id_ninja,
                            ninja.nama AS nama,
                            desa.nama_desa AS desa,
                            level_ninja.level_ninja AS level_ninja
                            FROM ninja
                            LEFT JOIN desa ON ninja.desa = desa.id_desa
                            LEFT JOIN level_ninja ON ninja.level_ninja = level_ninja.id_level_ninja ORDER BY ninja.nama ASC"
    );
    $daftarNinja = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $connectionInfo = "<p class='text-danger mt-2'>Connection failed: " . $e->getMessage() . "</p>";
}
?>

<body>
    <?php include 'navbar.php'; ?>

    <div class="main-content" style="margin-left:40px;">
        <h1 class="welcome-animate" style="margin-top:initial; margin-bottom:initial;">Ninja List</h1>
        <?php
        if ($info) {
            echo '<div class="component-animate">' . $info . '</div>';
        }
        ?>
        <p class="component-animate">Below is the ninja list information.</p>
        <?php
        if ($connectionInfo) {
            echo '<div class="component-animate">' . $connectionInfo . '</div>';
        }
        ?>
        <hr class="custom-hr component-animate">
        <div class="component-animate">
        <table class="table table-bordered table-hover shadow rounded ninja-table"
            style="width:70%; background-color:#f8f9fa;">
            <thead class="table-light">
                <tr>
                    <th class="hapus-col">&nbsp;</th>
                    <th>Name</th>
                    <th>Village</th>
                    <th>Level</th>
                    <th class="detail-col">&nbsp;</th>
                    <th class="edit-col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($daftarNinja as $ninja) {
                    echo "<tr>";
                    echo "<td class='hapus-col'><a href='ninja-list.php?deleteid=" . $ninja["id_ninja"] . "'>Delete</a></td>";
                    echo "<td class='blue-col'>" . $ninja["nama"] . "</td>";
                    echo "<td class='blue-col'>" . $ninja["desa"] . "</td>";
                    echo "<td class='blue-col'>" . $ninja["level_ninja"] . "</td>";
                    echo "<td class='detail-col'><a href='ninja-detail.php?id=" . $ninja["id_ninja"] . "'>View Detail</a></td>";
                    echo "<td class='edit-col'><a href='edit-ninja.php?id=" . $ninja["id_ninja"] . "'>Edit</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>