<?php include 'session-check.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Ninja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

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

<body>
    <?php include 'navbar.php'; ?>
    <div class="main-content" style="margin-left:40px;">
        <h1 class="welcome-animate" style="margin-top:initial; margin-bottom:initial;">Add New Ninja</h1>
        <p class="component-animate">Fill out the form below with the new ninja's data.</p>
        <hr class="custom-hr component-animate">
        <div class="component-animate">
        <form action="new-ninja.php" method="POST" enctype="multipart/form-data">
            <table class="table table-bordered table-hover shadow rounded" style="width:70%; background-color:#f8f9fa;">
                <tr>
                    <td><b>Name</b></td>
                    <td>
                        <input type="text" name="nama_ninja" required class="form-control">
                    </td>
                </tr>
                <tr>
                    <td><b>Gender</b></td>
                    <td>
                        <select name="jenis_kelamin" required class="form-select">
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
                    <td><b>Village</b></td>
                    <td>
                        <select name="desa" required class="form-select">
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
                        <select name="level_ninja" required class="form-select">
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
                    <td><b>Profile Photo</b></td>
                    <td>
                        <input type="file" name="foto" accept="image/*" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Save Data" class="btn btn-primary"></td>
                </tr>
            </table>
        </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNL1hNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>