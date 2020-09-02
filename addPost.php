<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/animate.css">
    <title>Add Post</title>
</head>
<?php echo file_get_contents('./header.html') ?>

<body>
    <div class="container">
        <div class="wrapper">
            <form action="#" enctype="multipart/form-data" id="blog" method="POST">
                <h2 class="wrapper__title">Add post</h2>
                <div class=" form-text">Запишите заголовок для добавления в блог:</div>
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
    </div>
    <?php echo file_get_contents('./footer.html') ?>
    <script src="./js/script.js"></script>
</body>

</html>