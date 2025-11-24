<!-- Подвал -->
<footer class="footer">
    <!-- Контент -->
    <div class="footer-content container" id="contacts">

        <!-- Информация -->
        <div class="footer-info">
            <a href="?"><img src="assets/images/logo2.png" alt=""></a>
            <a href="?">© Гулиева Эльза, 2024</a>
        </div>

        <!-- Навигация -->
        <div class="footer-nav">
            <b>Навигация</b>
            <div class="footer-nav-content">
                <div class="footer-nav-content-item">
                    <a href="">Главная</a>
                    <a href="">Об игре</a>
                    <a href="">Этапы</a>
                </div>
                <div class="footer-nav-content-item">
                    <a href="">Стикеры</a>
                    <a href="">Авторизация</a>
                    <a href="">Регистрация</a>
                </div>
            </div>
        </div>

        <!-- Контакты -->
        <div class="footer-contacts" >
            <b>Контакты</b>
            <div class="footer-contacts-content">
                <a href="">420061, г. Казань, <br>
                    ул. Галеева, д. 3</a>
                <a href="mailto:support@mystery.com">support@mystery.com</a>
                <a href="tel:+79655819801">+ 7 (965) 581-98-01</a>
            </div>
        </div>

        <!-- Мобильное меню -->
        <div class="footer-mob">
            <details>
                <summary><b>Навигация</b> <img src="assets/images/arrowDown2.png" alt=""> </summary>
                <a href="?">Главная</a>
                <a href="?">Об игре</a>
                <a href="?">Этапы</a>
                <a href="?">Стикеры</a>
                <a href="?">Авторизация</a>
                <a href="?">Регистрация</a>
            </details>
            <details>
                <summary><b>Контакты</b> <img src="assets/images/arrowDown2.png" alt=""> </summary>
                <a href="">420061, г. Казань,
                    ул. Галеева, д. 3</a>
                <a href="mailto:support@mystery.com">support@mystery.com</a>
                <a href="tel:+79655819801">+ 7 (965) 581-98-01</a>
            </details>
            <!-- Скрипт для закрытия списка при открытии другого -->
            <script>
                const details = document.querySelectorAll('details');
                details.forEach(detail => {
                    detail.addEventListener('toggle', () => {
                        if (detail.open) {
                            details.forEach(d => {
                                if (d !== detail && d.open) {
                                    d.open = false;
                                }
                            });
                        }
                    });
                });
            </script>
        </div><!-- Подписаться -->
        <div class="footer-follow">
            <b>Новости и акции</b>
            <div class="footer-follow-content">
                <form action="">
                    <input type="text" placeholder="Email">
                    <button>Подписаться</button>
                </form>
            </div>
        </div>
    </div>


    </div>
</footer>