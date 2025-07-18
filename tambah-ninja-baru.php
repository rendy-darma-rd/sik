<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sik";

$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = $conn->query("SELECT * from jenis_kelamin ORDER BY jenis_kelamin ASC");
$jenisKelaminList = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->query("SELECT * FROM desa ORDER BY nama_desa ASC");
$desaList = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $conn->query("SELECT * FROM level_ninja ORDER BY level_ninja ASC");
$levelNinjaList = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Ninja Baru</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliB<C<KTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
        body { background-color: #d1ecf1; }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <h1>Tambah Ninja Baru</h1>
    <p>Isi formulir di bawah ini dengan data ninja baru.</p>
    <hr>
    <form action="ninja-baru-detail.php" method="POST" enctype="multipart/form-data">
        <table border="1" width="50%">
            <tr>
                <td><b>Nama</b></td>
                <td>
                    <input type="text" name="nama_ninja" required>
                </td>
            </tr>
            <tr>
                <td><b>Jenis Kelamin</b></td>
                <td>
                    <select name="jenis_kelamin" required>
                        <option value=""></option>
                        <?php foreach ($jenisKelaminList as $jenisKelamin): ?>
                            <option value="<?php echo $jenisKelamin['id_jenis_kelamin']; ?>">
                                <?php echo $jenisKelamin['jenis_kelamin']; ?>
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
                            <option value="<?php echo $desa['id_desa']; ?>">
                                <?php echo $desa['nama_desa']; ?>
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
                        <?php foreach ($levelNinjaList as $levelNinja): ?>
                            <option value="<?php echo $levelNinja['id_level_ninja']; ?>">
                                <?php echo $levelNinja['level_ninja']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Foto Profil</b></td>
                <td>
                    <input type="file" name="foto" accept="image/*">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" value="Simpan Data"></td>
            </tr>
        </table>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNL1hNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>