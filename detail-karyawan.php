<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=devide-width, initial-scale=1">
	<title>Detail Karyawan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
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
	<h1>Detail Karyawan</h1>
	<p>Berikut adalah informasi detail karyawan.</p>
	<hr>

	<?php
	$servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sik";
	
	try {
		$id_karyawan = $_GET["id"];

        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $conn->query(
            "SELECT karyawan.id_karyawan AS id_karyawan,
					karyawan.nama AS nama,
                    divisi.nama AS divisi,
                    karyawan.jabatan AS jabatan,
                    karyawan.telepon AS telepon,
					karyawan.jenis_kelamin AS jeniskelamin,
					karyawan.alamat AS alamat,
					karyawan.email AS email,
					karyawan.website AS website,
					karyawan.foto AS foto
                    FROM karyawan
                    LEFT JOIN divisi
                    ON karyawan.divisi = divisi.id_divisi
					WHERE id_karyawan = '$id_karyawan' LIMIT 1"
                    );
		$karyawan = $query->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        echo "<p>Koneksi gagal: " . $e->getMessage()."</p>";
    }

	/*$karyawan = array(
		'nama' => 'Andi Sulaiman',
		'jeniskelamin' => 'Pria',
		'divisi' => 'Keuangan',
		'jabatan' => 'Manajer Keuangan',
		'alamat' => 'Jl. ABC No. 123, Jakarta',
		'email' => 'andi.sulaiman@email.com',
		'telepon' => '08123456789',
		'website' => 'http://www.andisulaiman.com',
		'foto' => 'assets/img/profile-photo.jpg',
		'pendidikan' => array(
			array('jenjang' => 'S1', 'sekolah' => 'Universitas ABC Jurusan Keuangan'),
			array('jenjang' => 'SMA', 'sekolah' => 'SMA 1 Jakarta'),
			array('jenjang' => 'SMP', 'sekolah' => 'SMP 1 Jakarta'),
			array('jenjang' => 'SD', 'sekolah' => 'SD 1 Jakarta')
		),
		'keahlian' => array(
			'Perencanaan keuangan',
			'Menghitung pajak',
			'Membuat analisa bisnis'
		)
	);*/
	?>

	<table border="1" width="50%">
		<tr>
			<td>
				<b>Nama:</b> <?php echo $karyawan["nama"]; ?> <br>
				<b>Jenis Kelamin:</b> <?php echo $karyawan["jeniskelamin"]; ?> <br>
				<b>Divisi:</b> <?php echo $karyawan["divisi"]; ?> <br>
				<b>Jabatan:</b> <?php echo $karyawan["jabatan"] ?> <br>
				<b>Alamat Domisili:</b> <?php echo $karyawan["alamat"] ?> <br>
				<b>Email:</b>
				<a href="mailto:<?php echo $karyawan["email"]; ?>" target="_blank">
					<?php echo $karyawan["email"]; ?>
				</a> <br>
				<b>Telepon:</b> <i><?php echo $karyawan["telepon"] ?></i> <br>
				<b>Website:</b>
				<a href="<?php echo $karyawan["website"]; ?>" target="_blank">
					<?php echo $karyawan["website"] ?>
				</a> <br>
			</td>
			<td valign="top">
				<img src="<?php echo $karyawan["foto"] ?>" alt="Foto Karyawan" height="150px">
			</td>
		</tr>
	</table>
	<br>
	<b>Daftar Pendidikan:</b> <br>
	<table border="1" width="50%">
		<tr>
			<td>
				<b>Jenjang</b>
			</td>
			<td>
				<b>Nama Sekolah</b>
			</td>
		</tr>
		<tr>
			<td><?php echo $karyawan["pendidikan"][0]['jenjang']; ?></td>
			<td><?php echo $karyawan["pendidikan"][0]['sekolah']; ?></td>
		</tr>
		<tr>
			<td><?php echo $karyawan["pendidikan"][1]['jenjang']; ?></td>
			<td><?php echo $karyawan["pendidikan"][1]['sekolah']; ?></td>
		</tr>
		<tr>
			<td><?php echo $karyawan["pendidikan"][2]['jenjang']; ?></td>
			<td><?php echo $karyawan["pendidikan"][2]['sekolah']; ?></td>
		</tr>
		<tr>
			<td><?php echo $karyawan["pendidikan"][3]['jenjang']; ?></td>
			<td><?php echo $karyawan["pendidikan"][3]['sekolah']; ?></td>
		</tr>
	</table>
	<br>
	<b>Daftar Keahlian:</b> <br>
	<ol>
		<li><?php echo $karyawan["keahlian"][0]; ?></li>
		<li><?php echo $karyawan["keahlian"][1]; ?></li>
		<li><?php echo $karyawan["keahlian"][2]; ?></li>
	</ol>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqu0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
