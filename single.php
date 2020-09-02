<?php
require_once("./config.php");
require_once("./functions.php");
$conn = connect();
$data = singleRecord($conn);
if (empty($data)) {
    exit('404');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title><?php echo $data['name'] ?></title>
</head>

<body>
    <?php echo file_get_contents('./header.html') ?>
    <?php
    ?>
    <div class="container">
        <div class="record__wrapper">
            <div class="record__id">
                ID:
                <span><?php echo $data['id']; ?></span>
            </div>
            <div class="record__name">
                Name:
                <?php echo $data['name'] ?>
            </div>
            <div class="record__info">
                <div class="record__descr">
                    <?php if (isset($row['description'])) echo $row['description'] ?>
                </div>
                <img src="
                    <?php
                    if (strlen($row['image']) != 0) {
                        echo 'images/' . $row['image'];
                    } else {
                        echo 'local-images/no_icon.png';
                    }
                    ?>">
            </div>
        </div>
    </div>
    <?php echo file_get_contents('./footer.html') ?>
</body>

</html>