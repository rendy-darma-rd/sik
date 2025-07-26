<?php include 'session-check.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Ninja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sik";

$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_ninja = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_ninja) {
    echo "<p>Ninja with ID not found.</p>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM ninja WHERE id_ninja = ?");
$stmt->execute([$id_ninja]);
$ninja = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$ninja) {
    echo "<p>Ninja with ID $id_ninja not found.</p>";
    exit;
}

$jenisKelaminList = $conn->query("SELECT id_jenis_kelamin, jenis_kelamin FROM jenis_kelamin ORDER BY jenis_kelamin ASC")->fetchAll(PDO::FETCH_ASSOC);
$desaList = $conn->query("SELECT id_desa, nama_desa FROM desa ORDER BY nama_desa ASC")->fetchAll(PDO::FETCH_ASSOC);
$levelList = $conn->query("SELECT id_level_ninja, level_ninja FROM level_ninja ORDER BY level_ninja ASC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_ninja'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $desa = $_POST['desa'];
    $level_ninja = $_POST['level_ninja'];
    $foto = $ninja['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $uploadfoto = "/sik/assets/img";
        $dirfoto = $_SERVER['DOCUMENT_ROOT'] . $uploadfoto . "/";
        $namafoto = $dirfoto . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $namafoto);
        $foto = $uploadfoto . "/" . basename($_FILES['foto']['name']);
    }
    $stmt = $conn->prepare("UPDATE ninja SET nama = ?, jenis_kelamin = ?, desa = ?, level_ninja = ?, foto = ? WHERE id_ninja = ?");
    $stmt->execute([$nama, $jenis_kelamin, $desa, $level_ninja, $foto, $id_ninja]);
    $updateInfo = "<p class='text-danger mt-2'>Ninja data successfully updated.</p>";
    $stmt = $conn->prepare("SELECT * FROM ninja WHERE id_ninja = ?");
    $stmt->execute([$id_ninja]);
    $ninja = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main-content">
        <h1 class="welcome-animate">Edit Ninja</h1>
        <?php
            if ($updateInfo) {
                echo '<div class="component-animate">' . $updateInfo . '</div>';
            }
        ?>
		<p class="component-animate">Edit the ninja detail information below.</p>
        <hr class="custom-hr component-animate">
        <div class="component-animate">
        <form method="POST" enctype="multipart/form-data">
            <table class="table table-bordered table-hover shadow rounded">
                <tr>
                    <td colwidth-30><b>Name</b></td>
                    <td colwidth-70><input type="text" name="nama_ninja" value="<?php echo htmlspecialchars($ninja['nama']); ?>" required class="form-control"></td>
                </tr>
                <tr>
                    <td colwidth-30><b>Gender</b></td>
                    <td colwidth-70>
                        <select name="jenis_kelamin" required class="form-select">
                            <option value=""></option>
                            <?php foreach ($jenisKelaminList as $jk): ?>
                                <option value="<?php echo $jk['id_jenis_kelamin']; ?>" <?php if ($jk['id_jenis_kelamin'] == $ninja['jenis_kelamin']) echo 'selected'; ?> >
                                    <?php echo htmlspecialchars($jk['jenis_kelamin']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colwidth-30><b>Village</b></td>
                    <td colwidth-70>
                        <select name="desa" required class="form-select">
                            <option value=""></option>
                            <?php foreach ($desaList as $desa): ?>
                                <option value="<?php echo $desa['id_desa']; ?>" <?php if ($desa['id_desa'] == $ninja['desa']) echo 'selected'; ?> >
                                    <?php echo htmlspecialchars($desa['nama_desa']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colwidth-30><b>Level</b></td>
                    <td colwidth-70>
                        <select name="level_ninja" required class="form-select">
                            <option value=""></option>
                            <?php foreach ($levelList as $level): ?>
                                <option value="<?php echo $level['id_level_ninja']; ?>" <?php if ($level['id_level_ninja'] == $ninja['level_ninja']) echo 'selected'; ?> >
                                    <?php echo htmlspecialchars($level['level_ninja']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colwidth-30><b>Profile Photo</b></td>
                    <td colwidth-70><input type="file" name="foto" accept="image/*" class="form-control">
                        <?php if (!empty($ninja['foto'])): ?>
                            <br><img src="<?php echo $ninja['foto']; ?>" alt="Ninja Photo" width="100">
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td colwidth-30></td>
                    <td colwidth-70><input type="submit" name="submit" value="Save Data" class="btn btn-primary"></td>
                </tr>
            </table>
        </form>
        </div>
    </div>
</body>

</html>