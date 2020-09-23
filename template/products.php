<section class="shop__list">
    <?php $products = get_products($config);
    if (count($products) == 0) : ?>
        <p>Ничего не найдено по вашему запросу</p>
    <?php else : ?>
        <?php foreach ($products as $product) : ?>
            <article class="shop__item product" data-id="<?= $product['id'] ?>" tabindex="0">
                <div class="product__image">
                    <img src="/img/products/product-<?= $product['id'] ?>.jpg" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
                <p class="product__name"><?= htmlspecialchars($product['name']) ?></p>
                <span class="product__price"><?= price_format($product['price']) ?> руб.</span>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
