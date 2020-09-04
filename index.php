<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>All Posts</title>
</head>

<body>
    <?php
    require_once("./config.php");
    require_once("./pagination.php");
    require_once("./functions.php");
    $conn = connect();
    $recordsLength = length($conn);
    $sql = "SELECT id from goods";
    $result = mysqli_query($conn, $sql);
    $arrayOfId = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $arrayOfId[] = $row['id'];
    }
    file_put_contents('./services/allId.json', json_encode($arrayOfId));
    $close = close($conn);
    $conn = connect();
    insertDB($conn);
    ?>
    <?php echo file_get_contents('./header.html');
    if ($recordsLength <= 0) {
    ?>
        <div class="welcome">
            <h2>Вы еще не добавили не одной записи</h2>
            <a href="./admin.php">Добавить?</a>
        </div>
    <?php
    }
    ?>
    <?php
    $result = takePaginationRecord($conn);
    if ($result == false) {
        echo 404;
        exit();
    }
    ?>
    <div class="container">

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <?php if (isset($row)) echo "<div class=\"record__wrapper\">" ?>
                <div class="record__id">
                    ID:
                    <span><?php if (isset($row['id'])) echo $row['id'] ?></span>
                </div>
                <div class="record__name">
                    Name:
                    <?php if (isset($row['name'])) echo $row['name'] ?>
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
                <div class="more__wrap">
                    <a class="more__link" href="<?php echo "single.php" . "?id=" . "$row[id]" ?>">More...</a>
                </div>
                <?php if (isset($row)) echo "</div>"; ?>

        <?php
            }
        }
        ?>
    </div>
    <?php
    $pages = ceil(length($conn) / 2);
    echo "<div class=\"pagination\">";
    for ($i = 0; $i < $pages; $i++) {
        $j = $i + 1;
        echo "<a class=\" pagination__item\" href=\"index.php?page=$i\">$j</a>";
    }
    echo "</div>";
    $close = close($conn);
    ?>
    <?php echo file_get_contents('./footer.html') ?>
    <script src="./js/admin.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>