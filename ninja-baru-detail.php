<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Ninja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <?php
    $menuredirection = array(
        "daftarninjaURL" => "daftar-ninja.php",
        "tambahninjabaruURL" => "tambah-ninja-baru.php",
        "daftarninjaText" => "Daftar Ninja",
        "tambahninjabaruText" => "Tambah Ninja Baru"
    );
    ?>

    <a href="index.html"><b>Sistem Informasi Ninja</b></a> |
    <a href="<?php echo $menuredirection["daftarninjaURL"] ?>">
        <?php echo $menuredirection["daftarninjaText"] ?></a> |
    <a href="<?php echo $menuredirection["tambahninjabaruURL"] ?>">
        <?php echo $menuredirection["tambahninjabaruText"] ?></a>
    <hr>

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
            "nama" => $_POST['nama_ninja'],
            "id_jenis_kelamin" => $id_jenis_kelamin,
            "jenis_kelamin" => $selectedJenisKelamin['jenis_kelamin'],
            "id_desa" => $id_desa,
            "desa" => $selectedDesa['nama_desa'],
            "id_level_ninja" => $id_level_ninja,
            "level_ninja" => $selectedLevelNinja['level_ninja'],
            "foto" => $uploadfoto . "/" . basename($_FILES['foto']['name'])
        );

        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("
                INSERT INTO ninja (nama, jenis_kelamin, desa, level_ninja, foto)
                VALUES(:nama, :id_jenis_kelamin, :id_desa, :id_level_ninja, :foto)"
        );
        $stmt->bindParam(":nama", $ninja["nama"]);
        $stmt->bindParam(":id_jenis_kelamin", $ninja["id_jenis_kelamin"]);
        $stmt->bindParam(":id_desa", $ninja["id_desa"]);
        $stmt->bindParam(":id_level_ninja", $ninja["id_level_ninja"]);
        $stmt->bindParam(":foto", $ninja["foto"]);
        $stmt->execute();
        echo "<p>Data ninja berhasil ditambahkan.</p>";
    } catch (PDOException $e) {
        echo "<p>Koneksi gagal: " . $e->getMessage() . "</p>";
    }
    ?>

    <h1>Detail Ninja</h1>
    <p>Berikut adalah detail data ninja yang telah ditambahkan.</p>
    <hr>
    <table border="1" width="50%">
        <tr>
            <td><b>Nama</b></td>
            <td><?php echo $ninja["nama"]; ?></td>
        </tr>
        <tr>
            <td><b>Jenis Kelamin</b></td>
            <td><?php echo $ninja["jenis_kelamin"]; ?></td>
        </tr>
        <tr>
            <td><b>Desa</b></td>
            <td><?php echo $ninja["desa"]; ?></td>
        </tr>
        <tr>
            <td><b>Level Ninja</b></td>
            <td><?php echo $ninja["level_ninja"]; ?></td>
        </tr>
        <tr>
            <td><b>Foto</b></td>
            <td><img src="<?php echo $ninja["foto"]; ?>" alt="Foto Ninja" width="100"></td>
        </tr>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/boostrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>