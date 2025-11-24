<?php
global $connection;

if (!isset($_SESSION['uid']) && $USER['role_id'] != 2) {
    echo '<script>
    document.location.href = "?page=login"
</script>';
    exit();
}

$sql = "SELECT * FROM `catalogue`";
$query = $connection->query($sql);
$stickers = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['del'])) {
    $sticker_id = $_POST['sticker_id'];

    $stmt = $connection->prepare("DELETE FROM `catalogue` WHERE `id` = :sticker_id");
    $stmt->bindParam(':sticker_id', $sticker_id, PDO::PARAM_INT);
    $stmt->execute();
    ?>
    <script>
        alert('Вы успешно удалили стикер с id: ' + <?= json_encode($sticker_id) ?>);
        document.location.href = "../?page=admin";
    </script>
    <?php
    exit();
}

$sql = 'SELECT users.*, roles.name AS role_name FROM `users`
        JOIN `roles` ON users.role_id = roles.id
        ORDER BY users.id DESC LIMIT 6';
$query = $connection->query($sql);
$users = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['ban'])) {
    $user_id = $_POST['user_id'];
    $stmt = $connection->prepare("UPDATE `users` SET `role_id` = 3 WHERE `id` = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
}

if (isset($_POST['unban'])) {
    $user_id = $_POST['user_id'];
    $stmt = $connection->prepare("UPDATE `users` SET `role_id` = 1 WHERE `id` = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
}
?>

<!-- Админ панель -->
<main class="main">
    <div class="main-content container">
        <!-- Личная информация -->
        <div class="lkInformation">
            <img src="<?= htmlspecialchars($USER['avatar']) ?>" alt="" class="avatar">
            <div class="lkInformation-txt">
                <div class="lkInformation-txt-edit">
                    <p>ID:
                        <?= htmlspecialchars($USER['id']) ?>
                    </p>
                    <a href="?page=editAccount"><img src="assets/images/pen.png" alt=""></a>
                </div>
                <h2>
                    <?= htmlspecialchars($USER['name'] . ' ' . $USER['surname']) ?>
                </h2>
            </div>
        </div>

        <div class="users-table">
            <div class="title">
                <h2>Пользователи</h2>
                <a href="?page=users">Все пользователи</a>
            </div>
            <div class="users">
                <table>
                    <tr>
                        <th>Id</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Статус</th>
                        <th>Управление</th>
                    </tr>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?= $user['id'] ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['email']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($user['role_name']) ?>
                            </td>
                            <td>
                                <?php if ($user['role_id'] == 2): ?>
                                    <button class="unactive">Заблокировать</button>
                                <?php elseif ($user['role_id'] == 3): ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit"
                                            onclick="return confirm('Вы действительно хотите разблокировать этого пользователя?')"
                                            name="unban">Разблокировать</button>
                                    </form>
                                <?php else: ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit"
                                            onclick="return confirm('Вы действительно хотите заблокировать этого пользователя?')"
                                            name="ban">Заблокировать</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="catalogue">
            <div class="title">
                <h2>Стикерпак</h2>
                <a href="?page=add"><img src="assets/images/plus.png" alt=""> Добавить новый стикер</a>
            </div>
            <div class="catalogue-cards">
                <?php foreach ($stickers as $sticker): ?>
                    <div class="card">
                        <img src="<?= htmlspecialchars($sticker['image_path']) ?>" alt="">
                        <div class="card-txt">
                            <h3>
                                <?= htmlspecialchars($sticker['title']) ?>
                            </h3>
                            <p>
                                <?= htmlspecialchars($sticker['description']) ?>
                            </p>
                            <div class="card-txt-btns">
                                <a href="?page=edit&id=<?= $sticker['id'] ?>">Редактировать</a>
                                <form action="" name="del" method="post">
                                    <input type="hidden" name="sticker_id" value="<?= $sticker['id'] ?>">
                                    <button type="submit" name="del" class="button2">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>