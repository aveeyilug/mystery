<?php
if (isset($_POST['logout'])) {
    session_start();
    if (!isset($_POST))
        die('Поддерживается только метод post. Вы передаете get запрос');
    unset($_SESSION['uid']);
    header('Location: ../index.php?page=login');
    die();
}

if (isset($_SESSION['uid'])) {
    // Определяем URL страницы профиля в зависимости от роли пользователя
    $profile_page = ($USER['role_id'] == 2) ? "admin" : "user";
}
?>

<!-- Шапка -->
<header class="header">
    <!-- Контент -->
    <div class="header-content container">

        <div class="header-left">
            <!-- Логотип -->
            <div class="header-logo">
                <a href="?"><img src="assets/images/logo.png" alt=""></a>
            </div>

            <!-- Навигация -->
            <div class="header-nav">
                <a href="?page=home#about">Об игре</a>
                <a href="?page=home#stages">Этапы</a>
                <a href="?page=home#contacts">Контакты</a>
            </div>
        </div>

        <!-- Кнопки -->
        <div class="header-btns">
            <?php if (isset($_SESSION['uid'])) { ?>
                <div class="header-btns-content">
                    <form action="" name="logout" method="post">
                        <button type="submit" name="logout" class="header-button">Выйти</button>
                    </form>
                    <a href="?page=<?= $profile_page ?>" class="header-avatar"><img src="<?= htmlspecialchars($USER['avatar']) ?>"
                            alt=""></a>
                </div>
            <?php } else { ?>
                <div class="header-btns-content">
                    <a href="?page=login" class="header-button">Войти</a>
                    <a href="?page=regist" class="header-button">Зарегистрироваться</a>
                </div>
            <?php }
            ?>
        </div>

        <div class="header-mob">
            <div class="menu">
                <input type="checkbox" id="burger-checkbox" class="burger-checkbox">
                <label for="burger-checkbox" class="burger"></label>
                <ul class="menu-list">
                    <li><a href="?page=home#about" class="menu-item">Об игре</a>
                    <li><a href="?page=home#stages" class="menu-item">Этапы</a>
                    <li><a href="?page=home#contacts" class="menu-item">Контакты</a>
                        <!-- Кнопки -->
                        <div class="header-mob-btns">
                            <?php if (isset($_SESSION['uid'])) { ?>
                                <div class="header-btns-content">
                                    <form action="" name="logout" method="post">
                                        <button type="submit" name="logout" class="header-button">Выйти</button>
                                    </form>
                                    <a href="?page=<?= $profile_page ?>" class="header-avatar">Профиль</a>
                                </div>
                            <?php } else { ?>
                                <a href="?page=login" class="a1 header-button">Войти</a>
                                <a href="?page=regist" class="a2 header-button">Зарегистрироваться</a>
                            <?php }
                            ?>
                        </div>
                </ul>
            </div>
        </div>

    </div>
</header>