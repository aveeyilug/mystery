<?php
global $connection;

if (!isset($_SESSION['uid']) && $USER['role_id'] != 2 ) {
    echo '<script>
    document.location.href = "?page=login"
</script>';
    exit();
}

$sql = 'SELECT users.*, roles.name AS role_name FROM `users`
        JOIN `roles` ON users.role_id = roles.id
        ORDER BY users.id';
$query = $connection->query($sql);
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="main">
    <div class="main-content container">
        <div class="title users-title">
            <h2>Пользователи</h2>
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
                            <?php else: ?>
                                <button>Заблокировать</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</main>