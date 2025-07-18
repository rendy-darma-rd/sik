<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=devide-width, initial-scale=1">
	<title>Detail Ninja</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<style>
        body { background-color: #d1ecf1; }
    </style>
</head>

<body>
	<?php include 'navbar.php'; ?>

	<h1>Detail Ninja</h1>
	<p>Berikut adalah informasi detail ninja.</p>
	<hr>

	<?php
	$servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sik";
	
	try {
		$id_ninja = $_GET["id"];

        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $conn->query(
            "SELECT ninja.id_ninja AS id_ninja,
					ninja.nama AS nama,
                    jenis_kelamin.jenis_kelamin AS jenis_kelamin,
                    desa.nama_desa AS desa,
                    level_ninja.level_ninja AS level_ninja,
                    ninja.foto AS foto
                    FROM ninja
                    LEFT JOIN jenis_kelamin ON ninja.jenis_kelamin = jenis_kelamin.id_jenis_kelamin
                    LEFT JOIN desa ON ninja.desa = desa.id_desa
                    LEFT JOIN level_ninja ON ninja.level_ninja = level_ninja.id_level_ninja
					WHERE id_ninja = '$id_ninja' LIMIT 1"
                    );
		$ninja = $query->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        echo "<p>Koneksi gagal: " . $e->getMessage()."</p>";
    }
	?>

	<table border="1" width="50%">
		<tr>
			<td>
				<b>Nama:</b> <?php echo $ninja["nama"]; ?> <br>
				<b>Jenis Kelamin:</b> <?php echo $ninja["jenis_kelamin"]; ?> <br>
				<b>Desa:</b> <?php echo $ninja["desa"]; ?> <br>
				<b>Level:</b> <?php echo $ninja["level_ninja"] ?> <br>
			</td>
			<td valign="top">
				<img src="<?php echo $ninja["foto"] ?>" alt="Foto Ninja" height="150px">
			</td>
		</tr>
	</table>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqu0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
