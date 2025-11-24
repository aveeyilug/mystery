<?php
session_start();
require_once 'incl/connect.php';
include ('components/head.php');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мистерия: Зов путешествий</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
</head>

<body>
    <div class="wrapper">
        <?php
        /* Подключение шапки */
        if (!isset($_GET['page']) || !in_array($_GET['page'], ['login', 'regist'])) {
            include 'components/header.php';
        }

        if (isset($_GET['page'])) {
            if ($_GET['page'] == 'add') {
                include 'pages/add.php';
            } elseif ($_GET['page'] == 'admin') {
                include 'pages/admin.php';
            } elseif ($_GET['page'] == 'edit') {
                include 'pages/edit.php';
            } elseif ($_GET['page'] == 'editAccount') {
                include 'pages/editAccount.php';
            } elseif ($_GET['page'] == 'home') {
                include 'pages/home.php';
            } elseif ($_GET['page'] == 'login') {
                include 'pages/login.php';
            } elseif ($_GET['page'] == 'regist') {
                include 'pages/regist.php';
            } elseif ($_GET['page'] == 'user') {
                include 'pages/user.php';
            } elseif ($_GET['page'] == 'users') {
                include 'pages/users.php';
            }
        } else {
            include 'pages/home.php';
        }

        /* Подключение подвала */
        if (!isset($_GET['page']) || !in_array($_GET['page'], ['login', 'regist'])) {
            include 'components/footer.php';
        }
        ?>
    </div>
</body>

</html>