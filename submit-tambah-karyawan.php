<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sik";

    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $conn->query("SELECT * from divisi");
    $divisiList = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Karyawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliB<C<KTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <a href="index.html"><b>Sistem Informasi Karyawan</b></a> |
    <a href="daftar-karyawan.php">Daftar Karyawan</a> |
    <a href="submit-tambah-karyawan.php">Tambah Karyawan</a>
    <hr>
    <h1>Tambah Karyawan</h1>
    <p>Isi formulir ini dengan data karyawan.</p>
    <hr>
    <form action="tambah-karyawan.php" method="POST" enctype="multipart/form-data">
        <table border="1" width="50%">
            <tr>
                <td><b>Nama</b></td>
                <td>
                    <input type="text" name="namakaryawan">
                </td>
            </tr>
            <tr>
                <td><b>Jenis Kelamin</b></td>
                <td>
                    <select name="jeniskelamin">
                        <option value=""></option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Divisi</b></td>
                <td>
                    <select name="divisi">
                        <?php foreach ($divisiList as $divisi): ?>
                            <option value="<?php echo $divisi['id_divisi']; ?>">
                                <?php echo $divisi['nama']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Jabatan</b></td>
                <td><input type="text" name="jabatan"></td>
            </tr>
            <tr>
                <td><b>Alamat</b></td>
                <td><textarea name="alamat"></textarea></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <td><b>Telepon</b></td>
                <td><input type="text" name="telepon"></td>
            </tr>
            <tr>
                <td><b>Website</b></td>
                <td><input type="text" name="website"></td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNL1hNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>