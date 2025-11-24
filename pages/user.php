<?php
if (!isset($_SESSION['uid'])) {
    header("Location: ?page=login");
    exit();
}

$sql = "SELECT * FROM `catalogue`";
$query = $connection->query($sql);
$stickers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

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

        <div class="catalogue">
            <div class="title">
                <h2>Лови стикерпак <br> в подарок за регистрацию! </h2>
                <a href="https://t.me/addstickers/mystery_aveeyilug"><img src="assets/images/plus.png" alt=""> Добавить
                    стикерпак в телеграм</a>
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
                                <a href="<?= htmlspecialchars($sticker['image_path']) ?>" download>
                                    Скачать
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>