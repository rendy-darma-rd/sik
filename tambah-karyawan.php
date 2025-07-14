<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sik";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id_divisi = $_POST['divisi'];
    $query = $conn->prepare("SELECT * FROM divisi WHERE id_divisi = ?");
    $query->execute([$id_divisi]);
    $divisiName = $query->fetch(PDO::FETCH_ASSOC);
}
catch (PDOException $e) {
    echo "<p>Koneksi gagal: " . $e->getMessage()."</p>";
}

$uploadfoto = "/sik/assets/img";
$dirfoto = $_SERVER['DOCUMENT_ROOT'] . $uploadfoto . "/";
$namafoto = $dirfoto . basename($_FILES['foto']['name']);
move_uploaded_file($_FILES['foto']['tmp_name'], $namafoto);
$karyawan = array(
    "nama" => $_POST['namakaryawan'],
    "jeniskelamin" => $_POST['jeniskelamin'],
    "divisi" => $id_divisi,
    "divisi_nama" => $divisiName['nama'],
    "jabatan" => $_POST['jabatan'],
    "alamat" => $_POST['alamat'],
    "email" => $_POST['email'],
    "telepon" => $_POST['telepon'],
    "website" => $_POST['website'],
    "foto" => $uploadfoto . "/" . basename($_FILES['foto']['name'])
);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Karyawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <?php
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
    <?php
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("
                INSERT INTO karyawan (nama, jabatan, divisi, jenis_kelamin, alamat, telepon, email, website, foto)
                VALUES(:nama, :jabatan, :divisi, :jeniskelamin, :alamat, :telepon, :email, :website, :foto)"
            );
            $stmt->bindParam(":nama", $karyawan["nama"]);
            $stmt->bindParam(":jabatan", $karyawan["jabatan"]);
            $stmt->bindParam(":divisi", $karyawan["divisi"]);
            $stmt->bindParam(":jeniskelamin", $karyawan["jeniskelamin"]);
            $stmt->bindParam(":alamat", $karyawan["alamat"]);
            $stmt->bindParam(":telepon", $karyawan["telepon"]);
            $stmt->bindParam(":email", $karyawan["email"]);
            $stmt->bindParam(":website", $karyawan["website"]);
            $stmt->bindParam(":foto", $karyawan["foto"]);
            $stmt->execute();
            echo "<p>Data berhasil ditambahkan.</p>";
        }
        catch (PDOException $e) {
            echo "<p>Koneksi gagal: " . $e->getMessage()."</p>";
        }
    ?>
    <h1>Detail Karyawan</h1>
    <p>Berikut adalah detail data karyawan yang telah ditambahkan.</p>
    <hr>
    <table border="1" width="50%">
        <tr>
            <td><b>Nama</b></td>
            <td><?php echo $karyawan["nama"]; ?></td>
        </tr>
        <tr>
            <td><b>Jenis Kelamin</b></td>
            <td><?php echo $karyawan["jeniskelamin"]; ?></td>
        </tr>
        <tr>
            <td><b>Divisi</b></td>
            <td><?php echo $karyawan["divisi_nama"]; ?></td>
        </tr>
        <tr>
            <td><b>Jabatan</b></td>
            <td><?php echo $karyawan["jabatan"]; ?></td>
        </tr>
        <tr>
            <td><b>Alamat</b></td>
            <td><?php echo $karyawan["alamat"]; ?></td>
        </tr>
        <tr>
            <td><b>Telepon</b></td>
            <td><?php echo $karyawan["telepon"]; ?></td>
        </tr>
        <tr>
            <td><b>Email</b></td>
            <td><?php echo $karyawan["email"]; ?></td>
        </tr>
        <tr>
            <td><b>Website</b></td>
            <td><?php echo $karyawan["website"]; ?></td>
        </tr>
        <tr>
            <td><b>Foto</b></td>
            <td><img src="<?php echo $karyawan["foto"]; ?>" alt="Foto Karyawan" width="100"></td>
        </tr>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/boostrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
