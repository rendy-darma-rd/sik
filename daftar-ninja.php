<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Ninja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
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
                    echo "<p>Ninja dengan ID " . htmlspecialchars($id_ninja) . " telah dihapus.</p>";
                }
            }
        } catch (PDOException $e) {
            echo "<p>Gagal menghapus ninja: " . $e->getMessage() . "</p>";
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
                            LEFT JOIN level_ninja ON ninja.level_ninja = level_ninja.id_level_ninja"
        );
        $daftarNinja = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<p>Koneksi gagal: " . $e->getMessage() . "</p>";
    }

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
    <h1>Daftar Ninja</h1>
    <p>Berikut adalah informasi daftar ninja.</p>
    <hr>
    <table border="1" width="50%">
        <tr>
            <td></td>
            <td><b>Nama</b></td>
            <td><b>Desa</b></td>
            <td><b>Level</b></td>
            <td></td>
        </tr>
        <?php
        foreach ($daftarNinja as $ninja) {
            echo "<tr>";
            echo "<td><a href='daftar-ninja.php?deleteid=" . $ninja["id_ninja"] . "'>Hapus</a></td>";
            echo "<td>" . $ninja["nama"] . "</td>";
            echo "<td>" . $ninja["desa"] . "</td>";
            echo "<td>" . $ninja["level_ninja"] . "</td>";
            echo "<td><a href='detail-ninja.php?id=" . $ninja["id_ninja"] . "'>Lihat Detail</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>