<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
is_login() ? header('Refresh:0;url=/') : null;
?>
<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
    <?php
    // выводим сообщения только если отправлены какие-то данные с формы
    if (isset($_POST['auth'])) {
        show_error('Неверный логин или пароль');
    }
    ?>
  <form class="custom-form" method="post">
    <input type="email" class="custom-form__input" name="login" value="<?= htmlspecialchars($_POST['login'] ?? $_COOKIE['login'] ?? '') ?>" required="">
    <input type="password" class="custom-form__input" name="password" value='<?= htmlspecialchars($_POST['password'] ?? '') ?>' >
    <button class="button" name="auth" type="submit">Войти в личный кабинет</button>
  </form>
</main>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php";
