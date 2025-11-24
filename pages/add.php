<?php
error_reporting(E_ERROR | E_PARSE);
global $connection;

if (!isset($_SESSION['uid']) && $USER['role_id'] != 2) {
    echo '<script>
    document.location.href = "?page=login"
</script>';
    exit();
}

if (isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $sticker = "assets/images/" . time() . $_FILES['sticker']['name'];
    $flag = true;
    $errors = [
        '<p class="error">Загрузите изображение</p>',
        '<p class="error">Введите название</p>',
        '<p class="error">Введите описание</p>',
        '<p class="error">Неверный формат файла. Загрузите изображение</p>'
    ];

    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileMimeType = mime_content_type($_FILES['sticker']['tmp_name']);
    $fileExtension = strtolower(pathinfo($_FILES['sticker']['name'], PATHINFO_EXTENSION));
}
?>

<!-- Форма для добавления стикера -->
<main class="main">
    <div class="main-content container add-content">

        <div class="add-form">
            <div class="form-title">
                <h2>Добавить стикер</h2>
            </div>

            <form action="" name="add" method="post" enctype="multipart/form-data">
                <div class="form-input-file">
                    <label for="sticker">Стикер</label>
                    <input type="file" name="sticker">
                </div>
                <?php
                if (isset($_POST['add'])) {
                    if (empty($_FILES['sticker']['name'])) {
                        $flag = false;
                        echo ($errors[0]);
                    } elseif (!in_array($fileMimeType, $allowedMimeTypes) || !in_array($fileExtension, $allowedExtensions)) {
                        $flag = false;
                        echo ($errors[3]);
                    }
                }
                ?>

                <div class="form-input">
                    <label for="title">Название</label>
                    <input type="text" name="title" placeholder="Стикер 7" value="">
                </div>
                <?php
                if (isset($title) && empty($title)) {
                    $flag = false;
                    echo ($errors[1]);
                }
                ?>

                <div class="form-input">
                    <label for="description">Описание</label>
                    <input type="text" name="description" placeholder="Описание описание описание" value="">
                </div>
                <?php
                if (isset($description) && empty($description)) {
                    $flag = false;
                    echo ($errors[2]);
                }
                ?>

                <div class="form-button">
                    <button type="submit" name="add">Сохранить</button>
                </div>
            </form>
        </div>

    </div>
</main>

<?php
if (isset($_POST['add'])) {
    if ($flag) {
        move_uploaded_file($_FILES['sticker']['tmp_name'], $sticker);
        $sql = "INSERT INTO `catalogue` (`id`, `title`, `description`, `image_path`) VALUES (NULL, '$title', '$description', '$sticker')";
        $result = $connection->query($sql);
        echo '<script>
                alert("Стикер успешно добавлен");
                document.location.href = "../?page=admin";
            </script>';
    }
}
?>