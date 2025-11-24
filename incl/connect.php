<?php
try {
    /* $dsn = 'mysql:host=localhost;dbname=z876'; */
    $dsn = 'mysql:host=localhost;dbname=mystery';
    /* $connection = new PDO($dsn, 'z876', '6iscKGe2k3nmne7J'); */
    $connection = new PDO($dsn, 'root', '');
} catch (PDOException $exception) {
    echo 'Возникла ошибка при подключении' . $exception->getMessage();
}
