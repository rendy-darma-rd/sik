<?php include 'session-check.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ninja Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

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
} catch (PDOException $e) {
	$connectionInfo = "<p class='text-danger mt-2'>Connection failed: " . $e->getMessage() . "</p>";
}
?>

<body>
	<?php include 'navbar.php'; ?>
	<div class="main-content" style="margin-left:40px;">
		<h1 class="welcome-animate" style="margin-top:initial; margin-bottom:initial;">Ninja Detail</h1>
		<p class="component-animate">Below is the ninja detail information.</p>
		<?php
		if ($connectionInfo) {
			echo '<div class="component-animate">' . $connectionInfo . '</div>';
		}
		?>
		<hr class="custom-hr component-animate">
		<div class="component-animate">
		<table class="table table-bordered table-hover shadow rounded" style="width:70%; background-color:#f8f9fa;">
			<tr>
				<td><b>Name</b></td>
				<td><?php echo $ninja["nama"]; ?></td>
			</tr>
			<tr>
				<td><b>Gender</b></td>
				<td><?php echo $ninja["jenis_kelamin"]; ?></td>
			</tr>
			<tr>
				<td><b>Village</b></td>
				<td><?php echo $ninja["desa"]; ?></td>
			</tr>
			<tr>
				<td><b>Level</b></td>
				<td><?php echo $ninja["level_ninja"] ?></td>
			</tr>
			<tr>
				<td><b>Photo</b></td>
				<td><img src="<?php echo $ninja["foto"] ?>" alt="Ninja Photo" height="150px"></td>
			</tr>
		</table>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ndDqu0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
		crossorigin="anonymous"></script>
</body>

</html>