<?php
$menuredirection = array(
    "ninjaListURL" => "ninja-list.php",
    "addNewNinjaURL" => "add-new-ninja.php",
    "ninjaListText" => "Ninja List",
    "addNewNinjaText" => "Add New Ninja"
);
?>
<link rel="stylesheet" href="assets/css/style.css">
<div class="navbar-container">
    <div class="navbar-left">
        <a href="dashboard.php" class="navbar-link"><b>Ninja Information System</b></a>
        <span class="navbar-link">|</span>
        <a href="<?php echo $menuredirection["ninjaListURL"] ?>" class="navbar-link">
            <?php echo $menuredirection["ninjaListText"] ?></a>
        <span class="navbar-link">|</span>
        <a href="<?php echo $menuredirection["addNewNinjaURL"] ?>" class="navbar-link">
            <?php echo $menuredirection["addNewNinjaText"] ?></a>
    </div>
    <a href="logout-process.php" class="navbar-logout">Logout</a>
</div>
<hr>