<?php
if (isset($_POST['log'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $flag = true;

    $errors = [
        '<p class="error">Введите email</p>',
        '<p class="error">Вы не зарегистрированы!</p>',
        '<p class="error">Введите пароль</p>',
        '<p class="error">Неверный пароль</p>',
    ];

    $_SESSION['email'] = $email;

    $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = $connection->query($sql);
    $user = $result->fetch(PDO::FETCH_ASSOC);
}
?>
<main class="main">
    <!-- Авторизация -->
    <div class="login">
        <!-- Логотип -->
        <div class="logo container">
            <a href="?"><img src="assets/images/logo.png" alt=""></a>
        </div>

        <div class="login-content container">
            <div class="login-form">
                <div class="form-title">
                    <h2>Мы скучали!</h2>
                    <div class="form-title-link">
                        <p>Еще не зарегистрированы?</p>
                        <a href="?page=regist">Пора это исправить!</a>
                    </div>
                </div>

                <form action="" method="post" name="log">
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
                    } else if (isset($email)) {
                        $sql = "SELECT * FROM users WHERE email = :email";
                        $stmt = $connection->prepare($sql);
                        $stmt->execute([':email' => $email]);
                        $isReg = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (empty($isReg)) {
                            $flag = false;
                            echo ($errors[1]);
                        }
                    }
                    ?>

                    <div class="form-input">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" placeholder="Пароль" value="">
                    </div>
                    <?php
                    if (isset($email) && empty($password)) {
                        $flag = false;
                        echo ($errors[2]);
                    } elseif (isset($email) && !password_verify($password, $user['password'])) {
                        $flag = false;
                        echo ($errors[3]);
                    }
                    ?>

                    <div class="form-button">
                        <button type="submit" name="log">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?
if (isset($_POST['log'])) {
    if ($flag) {
        unset($_SESSION['email']);

        $_SESSION['uid'] = $user['id'];

        if (!empty($user)) {
            if (password_verify($password, $user['password'])) {
                if ($user['role_id'] == 3) {
                    echo '<script>';
                    echo 'if(confirm("Вы заблокированы за нарушения правил пользования. Если Вы считаете, что произошла ошибка, то обратитесь в поддержку."))';
                    echo 'window.location = "index.php";';
                    echo 'else window.location = "index.php";';
                    echo '</script>';
                } else {
                    $_SESSION['uid'] = $user['id'];

                    switch ($user['role_id']) {
                        case 1:
                            header('Location: ?page=user');
                            exit();
                        case 2:
                            header('Location: ?page=admin');
                            exit();
                        default:
                            header("Location: index.php");
                            exit();
                    }
                }
            } else {
                $flag = false;
                echo ($errors[3]); 
            }
        }

        if ($flag) {
            unset($_SESSION['uid']); 
        }
    }
}
?>