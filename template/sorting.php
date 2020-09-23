<section class="shop__sorting">
    <div class="shop__sorting-item custom-form__select-wrapper">
        <select class="custom-form__select" name="order_column" onchange="change_order_column(this)">
            <option hidden="">Сортировка</option>
            <option value="price" <?= $config['order_column'] == 'price' ? 'selected' : '' ?>>По цене</option>
            <option value="name" <?= $config['order_column'] == 'name' ? 'selected' : '' ?>>По названию</option>
        </select>
    </div>
    <div class="shop__sorting-item custom-form__select-wrapper">
        <select class="custom-form__select" name="order_by" onchange="change_order_by(this)">
            <option hidden="">Порядок</option>
            <option value="asc" <?= $config['order_by'] == 'asc' ? 'selected' : '' ?>>По возрастанию</option>
            <option value="desc"  <?= $config['order_by'] == 'desc' ? 'selected' : '' ?>>По убыванию</option>
        </select>
    </div>
    <p class="shop__sorting-res"><?= num_word($products_stat['total'], ['Найдена', 'Найдено', 'Найдено']) ?> <span class="res-sort"><?= $products_stat['total'] ?></span> <?= num_word($products_stat['total'], ['модель', 'модели', 'моделей']) ?></p>
</section>
