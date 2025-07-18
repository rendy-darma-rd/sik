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
