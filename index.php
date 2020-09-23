<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helper/database.php";

$products_stat = get_products_stat();
?>
<main class="shop-page">
  <header class="intro">
    <div class="intro__wrapper">
      <h1 class=" intro__title">COATS</h1>
      <p class="intro__info">Collection 2020</p>
    </div>
  </header>
  <section class="shop container">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/template/filter.php";
    ?>
    <div class="shop__wrapper">
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/template/sorting.php";
        ?>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/template/products.php";
        ?>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . "/template/paginator.php";
        ?>
    </div>
  </section>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/template/make_order.php";
    ?>
  <section class="shop-page__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Спасибо за заказ!</h2>
      <p class="shop-page__end-message">Ваш заказ успешно оформлен, с вами свяжутся в ближайшее время</p>
      <button class="button button_continue">Продолжить покупки</button>
    </div>
  </section>
</main>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php";
