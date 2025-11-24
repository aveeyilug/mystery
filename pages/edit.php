<?php
global $connection;

if (!isset($_SESSION['uid']) && $USER['role_id'] != 2) {
    echo '<script>
    document.location.href = "?page=login"
</script>';
    exit();
}

if (isset($_GET['page']) && $_GET['page'] === 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `catalogue` WHERE id= $id";
    $query = $connection->query($sql);
    $stick = $query->fetch(PDO::FETCH_ASSOC);

    if (!$stick) {
        die('Такой страницы не существует :(');
    }
} else {
    die('Такой страницы не существует :(');
}

$sticker = $stick['image_path'];

if (isset($_POST['edit'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($_FILES['sticker']['name'] != '') {
        $sticker = "assets/images/" . time() . $_FILES['sticker']['name'];
        move_uploaded_file($_FILES['sticker']['tmp_name'], $sticker);
    }

    $flag = true;
    $errors = [
        '<p class="error">Введите название</p>',
        '<p class="error">Введите описание</p>'
    ];
}
?>

<main class="main">
    <div class="main-content container edit-content">

        <div class="add-form">
            <div class="form-title">
                <h2>Изменить стикер</h2>
            </div>

            <form action="" name="edit" method="post" enctype="multipart/form-data">
                <div class="form-input-file">
                    <label for="sticker">Стикер</label>
                    <input type="file" name="sticker" accept="image/*">
                </div>

                <div class="form-input">
                    <label for="title">Название</label>
                    <input type="text" name="title" placeholder="Стикер 7"
                        value="<?= htmlspecialchars($stick['title']) ?>">
                </div>
                <?php
                if (isset($title) && empty($title)) {
                    $flag = false;
                    echo ($errors[0]);
                }
                ?>

                <div class="form-input">
                    <label for="description">Описание</label>
                    <input type="text" name="description" placeholder="Описание описание описание"
                        value="<?= htmlspecialchars($stick['description']) ?>">
                </div>
                <?php
                if (isset($description) && empty($description)) {
                    $flag = false;
                    echo ($errors[1]);
                }
                ?>

                <div class="form-button">
                    <button type="submit" name="edit">Сохранить</button>
                </div>
            </form>
        </div>

    </div>
</main>

<?php
if (isset($_POST['edit'])) {
    if ($flag) {
        $sql = "UPDATE `catalogue` SET `title` = '$title', `description` = '$description', `image_path` = '$sticker' WHERE `catalogue`.`id` = '$id'";
        $result = $connection->query($sql);

        echo '<script>
                alert("Стикер успешно изменен");
                document.location.href = "../?page=admin";
            </script>';
    }
}
?>