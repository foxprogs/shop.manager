<?php
$products = get_admin_products();
$total = get_admin_total_products();
?>
<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <a class="page-products__button button" href="/admin/products/add">Добавить товар</a>
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
  </div>
    <ul class="page-products__list">
        <?php if (count($products) == 0) : ?>
            <li><p>Ничего нет</p></li>
        <?php else : ?>
            <?php foreach ($products as $product) : ?>
                <li class="product-item page-products__item">
                  <b class="product-item__name"><?= $product['name'] ?></b>
                  <span class="product-item__field"><?= $product['id'] ?></span>
                  <span class="product-item__field"><?= price_format($product['price']) ?> руб.</span>
                  <span class="product-item__field"><?= implode(', ', $product['categories']) ?></span>
                  <span class="product-item__field"><?= $product['is_new'] ? 'Да' : 'Нет' ?></span>
                  <a href="/admin/products/edit?id=<?= $product['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
                  <button class="product-item__delete" data-id="<?= $product['id'] ?>"></button>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <br>
    <ul class="shop__paginator paginator">
        <?php if ($total > 0) :
            for ($i = 1; $i <= ceil($total / PER_PAGE); $i++) : ?>
        <li>
            <a class="paginator__item" <?= $i == ($_GET['page'] ?? 1) ? '' : "href='/admin/products?page=$i'"?>><?= $i ?></a>
        </li>
            <?php endfor;
        endif; ?>
    </ul>
</main>
