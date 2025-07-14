<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sik";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $conn->query(
            "SELECT karyawan.id_karyawan AS id_karyawan,
                    karyawan.nama AS nama,
                    divisi.nama AS divisi,
                    karyawan.jabatan AS jabatan,
                    karyawan.telepon AS telepon
                    FROM karyawan
                    LEFT JOIN divisi
                    ON karyawan.divisi = divisi.id_divisi"
                    );
        $daftarkaryawan = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        echo "<p>Koneksi gagal: " . $e->getMessage()."</p>";
    }

    $menuredirection = array(
        "daftarkaryawanURL" => "daftar-karyawan.php",
        "tambahkaryawanURL" => "submit-tambah-karyawan.php",
        "daftarkaryawanText" => "Daftar Karyawan",
        "tambahkaryawanText" => "Tambah Karyawan"
    );
    ?>

    <a href="index.html"><b>Sistem Informasi Karyawan</b></a> |
    <a href="<?php echo $menuredirection["daftarkaryawanURL"] ?>">
        <?php echo $menuredirection["daftarkaryawanText"] ?></a> |
    <a href="<?php echo $menuredirection["tambahkaryawanURL"] ?>">
        <?php echo $menuredirection["tambahkaryawanText"] ?></a>
    <hr>
    <h1>Daftar Karyawan</h1>
    <p>Berikut adalah informasi daftar karyawan.</p>
    <hr>
    <?php
        /*$andi = array(
            "name" => "Andi Sulaiman",
            "divisi" => "Keuangan",
            "jabatan" => "Manajer Keuangan",
            "telepon" => "08123456789"
        );
        $budi = array(
            "name" => "Budi Setiawan",
            "divisi" => "Keuangan",
            "jabatan" => "Supervisor Keuangan",
            "telepon" => "08123456788"
        );
        $candra = array(
            "name" => "Candra Budiman",
            "divisi" => "Keuangan",
            "jabatan" => "Staf Keuangan",
            "telepon" => "08123456787"
        );

        $daftarkaryawan = array($andi, $budi, $candra);*/
        ?>
        <table border="1" width="50%">
            <tr>
                <td><b>Nama</b></td>
                <td><b>Divisi</b></td>
                <td><b>Jabatan</b></td>
                <td><b>Telepon</b></td>
                <td><b>Lihat Detail</b></td>
            </tr>
            <?php
                    foreach($daftarkaryawan as $karyawan) {
                        echo "<tr>";
                        echo "<td>" . $karyawan["nama"] . "</td>";
                        echo "<td>" . $karyawan["divisi"] . "</td>";
                        echo "<td>" . $karyawan["jabatan"] . "</td>";
                        echo "<td>" . $karyawan["telepon"] . "</td>";
                        echo "<td><a href='detail-karyawan.php?id=" . $karyawan["id_karyawan"] . "'>Lihat Detail</a></td>";
                        echo "</tr>";
                    }
            ?>
        </table>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>