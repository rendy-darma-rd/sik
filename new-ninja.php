<?php include 'session-check.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ninja Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sik";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id_jenis_kelamin = $_POST['jenis_kelamin'];
    $id_desa = $_POST['desa'];
    $id_level_ninja = $_POST['level_ninja'];

    $query = $conn->prepare("SELECT * FROM jenis_kelamin WHERE id_jenis_kelamin = ?");
    $query->execute([$id_jenis_kelamin]);
    $selectedJenisKelamin = $query->fetch(PDO::FETCH_ASSOC);

    $query = $conn->prepare("SELECT * FROM desa WHERE id_desa = ?");
    $query->execute([$id_desa]);
    $selectedDesa = $query->fetch(PDO::FETCH_ASSOC);

    $query = $conn->prepare("SELECT * FROM level_ninja WHERE id_level_ninja = ?");
    $query->execute([$id_level_ninja]);
    $selectedLevelNinja = $query->fetch(PDO::FETCH_ASSOC);

    $uploadfoto = "/sik/assets/img";
    $dirfoto = $_SERVER['DOCUMENT_ROOT'] . $uploadfoto . "/";
    $namafoto = $dirfoto . basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $namafoto);
    $ninja = array(
        "name" => $_POST['nama_ninja'],
        "id_gender" => $id_jenis_kelamin,
        "gender" => $selectedJenisKelamin['jenis_kelamin'],
        "id_village" => $id_desa,
        "village" => $selectedDesa['nama_desa'],
        "id_level_ninja" => $id_level_ninja,
        "level_ninja" => $selectedLevelNinja['level_ninja'],
        "photo" => $uploadfoto . "/" . basename($_FILES['foto']['name'])
    );

    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("
                    INSERT INTO ninja (nama, jenis_kelamin, desa, level_ninja, foto)
                    VALUES(:nama, :id_jenis_kelamin, :id_desa, :id_level_ninja, :foto)"
    );
    $stmt->bindParam(":nama", $ninja["name"]);
    $stmt->bindParam(":id_jenis_kelamin", $ninja["id_gender"]);
    $stmt->bindParam(":id_desa", $ninja["id_village"]);
    $stmt->bindParam(":id_level_ninja", $ninja["id_level_ninja"]);
    $stmt->bindParam(":foto", $ninja["photo"]);
    $stmt->execute();
    $info = "<p class='text-danger mt-2'>Ninja data successfully added.</p>";
} catch (PDOException $e) {
    $info = "<p class='text-danger mt-2'>Connection failed: " . $e->getMessage() . "</p>";
}
?>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main-content">
        <h1 class="welcome-animate">Ninja Detail</h1>
        <?php
        if ($info) {
            echo '<div class="component-animate">' . $info . '</div>';
        }
        ?>
        <p class="component-animate">Here are the details of the ninja data that has been added.</p>
        <hr class="custom-hr component-animate">
        <div class="component-animate">
        <table class="table table-bordered table-hover shadow rounded">
            <tr>
                <td colwidth-30><b>Name</b></td>
                <td colwidth-70><?php echo $ninja["name"]; ?></td>
            </tr>
            <tr>
                <td colwidth-30><b>Gender</b></td>
                <td colwidth-70><?php echo $ninja["gender"]; ?></td>
            </tr>
            <tr>
                <td colwidth-30><b>Village</b></td>
                <td colwidth-70><?php echo $ninja["village"]; ?></td>
            </tr>
            <tr>
                <td colwidth-30><b>Level</b></td>
                <td colwidth-70><?php echo $ninja["level_ninja"]; ?></td>
            </tr>
            <tr>
                <td colwidth-30><b>Photo</b></td>
                <td colwidth-70><img src="<?php echo $ninja["photo"]; ?>" alt="Ninja Photo" height="150px"></td>
            </tr>
        </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>