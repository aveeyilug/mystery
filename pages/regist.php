<?php
if (isset($_POST['reg'])) {
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $password = trim($_POST['password']);
    $password_r = trim($_POST['password_r']);

    $flag = true;

    $errors = [
        '<p class="error">Введите email</p>',
        '<p class="error">Поле email некорректно</p>',
        '<p class="error">Введите пароль</p>',
        '<p class="error">Пароль должен содержать не менее 6 символов</p>',
        '<p class="error">Подтвердите пароль</p>',
        '<p class="error">Пароли не совпадают</p>',
        '<p class="error">Введите данные</p>',
        '<p class="error">Вы уже зарегистрированы!</p>'
    ];

    $_SESSION['email'] = $email;
}
?>

<main class="main">
    <!-- Регистрация -->
    <div class="regist">
        <!-- Логотип -->
        <div class="logo container">
            <a href="?"><img src="assets/images/logo.png" alt=""></a>
        </div>

        <div class="regist-content container">
            <div class="regist-form">
                <div class="form-title">
                    <h2>Создайте аккаунт!</h2>
                    <div class="form-title-link">
                        <p>Вы уже зарегистрированы?</p>
                        <a href="?page=login">Войдите!</a>
                    </div>
                </div>

                <form action="" method="post" name="reg">
                    <div class="form-input">
                        <label for="email">Эл. почта</label>
                        <input type="text" name="email" placeholder="email" value="<?php
                                                                                    if (isset($_SESSION['email'])) {
                                                                                        echo $_SESSION['email'];
                                                                                        unset($_SESSION['email']);
                                                                                    }
                                                                                    ?>">

                    </div>
                    <?php
                    if (isset($email) && empty($email)) {
                        $flag = false;
                        echo ($errors[0]);
                    } elseif (isset($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $flag = false;
                        echo ($errors[1]);
                    } else if (isset($email)) {
                        $sql = "SELECT * FROM users WHERE email = :email";
                        $stmt = $connection->prepare($sql);
                        $stmt->execute([':email' => $email]);
                        $isReg = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (!empty($isReg)) {
                            $flag = false;
                            echo ($errors[7]);
                        }
                    }
                    ?>

                    <div class="form-name">
                        <div class="form-input">
                            <label for="name">Имя</label>
                            <input type="text" name="name" placeholder="Эльза" value="">
                        </div>
                        <div class="form-input">
                            <label for="surname">Фамилия</label>
                            <input type="text" name="surname" placeholder="Гулиева" value="">
                        </div>
                    </div>
                    <?php
                    if (isset($name) && (empty($name) || empty($surname))) {
                        $flag = false;
                        echo ($errors[6]);
                    }
                    ?>

                    <div class="form-input">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" placeholder="Пароль" value="">

                    </div>
                    <?php
                    if (isset($password) && empty($password)) {
                        $flag = false;
                        echo ($errors[2]);
                    } elseif (isset($password) && strlen($password) < 6) {
                        $flag = false;
                        echo ($errors[3]);
                    }
                    ?>

                    <div class="form-input">
                        <label for="password_r">Повторите пароль</label>
                        <input type="password" name="password_r" placeholder="Повторите пароль" value="">
                    </div>
                    <?php
                    if (isset($_POST['reg'])) {
                        if (empty($password_r)) {
                            $flag = false;
                            echo ($errors[4]);
                        } elseif ($password !== $password_r) {
                            $flag = false;
                            echo ($errors[5]);
                        }
                    }
                    ?>

                    <div class="form-button">
                        <button type="submit" name="reg">Зарегистрироваться</button>
                        <p>Нажимая, Вы соглашаетесь с <a href="">политикой конфиденциальности</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
if (isset($_POST['reg'])) {

    if ($flag) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users`(`id`, `email`, `password`, `name`, `surname`, `avatar`, `role_id`) 
        VALUES (NULL,:email,:password, :name, :surname, 'assets/images/stub.png', 1)";
        $stmt = $connection->prepare($sql);
        $params = [
            ':email' => $email,
            ':password' => $password,
            ':name' => $name,
            ':surname' => $surname,
        ];

        $stmt->execute($params);
        if ($stmt->rowCount() == 0) {
            $_SESSION['errors']['general'] = 'Не удалось зарегистрироваться. Пожалуйста, попробуйте еще раз.';
            header('Location: ../index.php?page=regist');
            exit();
        }

        unset($_SESSION['email']);

        echo '<script>document.location.href="?page=login"</script>';
    }
}
?>