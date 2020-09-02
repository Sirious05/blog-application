<?php
require_once("./config.php");
require_once("./pagination.php");
require_once("./functions.php");
$conn = connect();
$length = length($conn);
clearImages($conn);
$conn = connect();
if (!empty($_FILES) && !empty($_POST)) {
    $formTitle = $_POST['edit-title'];
    $formDescr = $_POST['edit-descr'];
    $id = $_POST['edit-id'];
    $oldId = $_POST['old-id'];
    $formImage = $_FILES['editImg'];
    $sql = "UPDATE goods SET id=\"$id\",name=\"$formTitle\",description=\"$formDescr\",image=\"{$formImage['name']}\" WHERE id=\"$oldId\"";
    if (trim($formTitle) == '') {
        $sql = "UPDATE goods SET id=\"$id\",description=\"$formDescr\",image=\"{$formImage['name']}\" WHERE id=\"$oldId\"";
    }
    if (trim($formDescr) == '') {
        $sql = "UPDATE goods SET id=\"$id\",name=\"$formTitle\",image=\"{$formImage['name']}\" WHERE id=\"$oldId\"";
    }
    if (trim($id) == '') {
        $sql = "UPDATE goods SET name=\"$formTitle\",description=\"$formDescr\",image=\"{$formImage['name']}\" WHERE id=\"$oldId\"";
    }
    $result = mysqli_query($conn, $sql);
    move_uploaded_file("{$formImage['tmp_name']}", "images/" . "{$formImage['name']}");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/animate.css">
    <title>Admin Panel </title>
</head>

<body>
    <?php echo file_get_contents('./header.html');
        $result = takePaginationRecord($conn);
        if ($result == false) {
        echo 404;
        exit();
    }
    ?>
    <div class="container">
        <div class="add-post">
            <h2>Add post</h2>
            <img src="./local-images/plus.png">
        </div>
        <div class="wrapper">
            <form novalidate action="#" enctype="multipart/form-data" id="blog" method="POST">
                <h2 class="wrapper__title">Add post</h2>
                <div class="form-text">Запишите заголовок для добавления в блог:</div>
                <input type="text" name="title" placeholder="Введите текст" required>
                <div class="form-text">Запишите описание для добавления в блог:</div>
                <textarea rows="10" cols="45" name="descr" placeholder="Введите текст" required></textarea>
                <div class="form-text">Выберите файл картинки для добавления в блог:</div>
                <input type="file" name="img" id="img" required />
                <label for="img">Выбрать файл</label>
                <div class="form-text">Запишите id записи</div>
                <input type="number" name="id" required />
                <button class="wrapper__submit">Добавить</button>
            </form>
        </div>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <?php if (isset($row)) echo "<div class=\"record__wrapper\">" ?>
                <div class="edit"></div>
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
                <form novalidate action="#" enctype="multipart/form-data" class="record__form" method="POST">
                    <div class=" form-text">Выберите заголовок для изменения записи :</div>
                    <input type="text" name="edit-title" placeholder="Введите текст">
                    <div class="form-text">Выберите описание для изменения записи:</div>
                    <textarea style="margin:0" rows="10" cols="45" name="edit-descr" placeholder="Введите текст"></textarea>
                    <div class="form-text">Выберите файл для изменения в записи:</div>
                    <input type="file" name="editImg" required id="<?php echo "file" . $row['id'] ?>" class="editmg" />
                    <label for="<?php echo "file" . $row['id'] ?>">Выбрать файл</label>
                    <div class="form-text">Введите новый id записи(можно записать старый id)</div>
                    <input type="number" name="edit-id" />
                    <button>Отправить</button>
                </form>
        <?php if (isset($row)) echo "</div>";
            }
        }
        $pages = ceil(length($conn) / 2);
        echo "<div class=\"pagination\">";
        for ($i = 0; $i < $pages; $i++) {
            $j = $i + 1;
            echo "<a class=\" pagination__item\" href=\"admin.php?page=$i\">$j</a>";
        }
        echo "</div>";
        $close = close($conn);
        ?>
    </div>
    <?php echo file_get_contents('./footer.html') ?>
    <script src="./js/admin.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>