<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sik";

$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_ninja = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_ninja) {
    echo "<p>ID Ninja tidak ditemukan.</p>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM ninja WHERE id_ninja = ?");
$stmt->execute([$id_ninja]);
$ninja = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$ninja) {
    echo "<p>Ninja dengan ID $id_ninja tidak ditemukan.</p>";
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
    echo "<p>Data ninja berhasil diubah.</p>";
    $stmt = $conn->prepare("SELECT * FROM ninja WHERE id_ninja = ?");
    $stmt->execute([$id_ninja]);
    $ninja = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Ninja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #d1ecf1; }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <h1>Edit Ninja</h1>
    <form method="POST" enctype="multipart/form-data">
        <table border="1" width="50%">
            <tr>
                <td><b>Nama</b></td>
                <td><input type="text" name="nama_ninja" value="<?php echo htmlspecialchars($ninja['nama']); ?>" required></td>
            </tr>
            <tr>
                <td><b>Jenis Kelamin</b></td>
                <td>
                    <select name="jenis_kelamin" required>
                        <option value=""></option>
                        <?php foreach ($jenisKelaminList as $jk): ?>
                            <option value="<?php echo $jk['id_jenis_kelamin']; ?>" <?php if ($jk['id_jenis_kelamin'] == $ninja['jenis_kelamin']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($jk['jenis_kelamin']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Desa</b></td>
                <td>
                    <select name="desa" required>
                        <option value=""></option>
                        <?php foreach ($desaList as $desa): ?>
                            <option value="<?php echo $desa['id_desa']; ?>" <?php if ($desa['id_desa'] == $ninja['desa']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($desa['nama_desa']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Level</b></td>
                <td>
                    <select name="level_ninja" required>
                        <option value=""></option>
                        <?php foreach ($levelList as $level): ?>
                            <option value="<?php echo $level['id_level_ninja']; ?>" <?php if ($level['id_level_ninja'] == $ninja['level_ninja']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($level['level_ninja']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Foto Profil</b></td>
                <td>
                    <input type="file" name="foto" accept="image/*">
                    <?php if (!empty($ninja['foto'])): ?>
                        <br><img src="<?php echo $ninja['foto']; ?>" alt="Foto Ninja" width="100">
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" value="Simpan Data"></td>
            </tr>
        </table>
    </form>
</body>

</html>