<?php
if (isset($_POST['editAccount'])) {
    $user_id = trim($_POST['user_id']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);

    $flag = true;
    $errors = [
        '<p class="error">Введите имя</p>',
        '<p class="error">Введите фамилию</p>',
        '<p class="error">Неверный формат файла. Загрузите изображение</p>'
    ];

    if (empty($name)) {
        $flag = false;
        $nameError = $errors[0];
    }

    if (empty($surname)) {
        $flag = false;
        $surnameError = $errors[1];
    }

    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileMimeType = mime_content_type($_FILES['avatar']['tmp_name']);
        $fileExtension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileMimeType, $allowedMimeTypes) || !in_array($fileExtension, $allowedExtensions)) {
            $flag = false;
            $imageError = $errors[2];
        }
    }
}
?>

<main class="main">
    <div class="main-content container edit-content">
        <div class="add-form">
            <div class="form-title">
                <h2>Изменить</h2>
            </div>

            <form action="" name="editAccount" method="post" enctype="multipart/form-data">
                <div class="form-input-file">
                    <label for="avatar">Аватарка</label>
                    <input type="file" name="avatar">
                </div>
                <?php
                if (isset($imageError)) {
                    echo $imageError;
                }
                ?>

                <input type="hidden" name="user_id" value="<?= $USER['id'] ?>">

                <div class="form-input">
                    <label for="title">Имя</label>
                    <input type="text" name="name" placeholder="Эльза" value="<?= $USER['name'] ?>">
                </div>
                <?php
                if (isset($nameError)) {
                    echo $nameError;
                }
                ?>

                <div class="form-input">
                    <label for="surname">Фамилия</label>
                    <input type="text" name="surname" placeholder="Гулиева" value="<?= $USER['surname'] ?>">
                </div>
                <?php
                if (isset($surnameError)) {
                    echo $surnameError;
                }
                ?>



                <div class="form-button">
                    <button type="submit" name="editAccount">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
if (isset($_POST['editAccount']) && $flag) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK && $flag) {
        $upload_dir = 'assets/images/';

        $filename = $_FILES['avatar']['name'];

        $avatar_path = $upload_dir . $filename;

        move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path);

        $sql = "UPDATE `users` SET `name` = '$name', `surname` = '$surname', `avatar` = '$avatar_path' WHERE `id` = '$user_id'";
    } else {
        $sql = "UPDATE `users` SET `name` = '$name', `surname` = '$surname' WHERE `id` = '$user_id'";
    }

    $result = $connection->query($sql);

    echo '<script>document.location.href="?page=home"</script>';
}
?>