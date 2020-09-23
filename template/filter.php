<?php
$filter_min = $products_stat['filter']['min_price'] ?? 0;
$filter_max = $products_stat['filter']['max_price'] ?? 10000;

$range_min = $_GET['min_price'] ?? $filter_min;
$range_max = $_GET['max_price'] ?? $filter_max;

?>
<section class="shop__filter filter">
  <form method="get">
    <div class="filter__wrapper">
        <b class="filter__title">Категории</b>
        <ul class="filter__list">
            <li>
                <a class="filter__list-item <?= empty($_GET['category']) ? 'active' : '' ?>" href="/">Все</a>
            </li>
            <?php foreach (get_categories() as $category) : ?>
                <li>
                    <a class="filter__list-item <?= $category['id'] == ($_GET['category'] ?? 0) ? 'active' : '' ?>" href="/category/<?= $category['id'] ?>"><?= $category['name'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="filter__wrapper">
      <b class="filter__title">Фильтры</b>
      <div class="filter__range range">
        <span class="range__info">Цена</span>
        <div class="range__line" data-min="<?= $filter_min ?>" data-max="<?= $filter_max ?>" aria-label="Range Line"></div>
        <div class="range__res">
          <input type="hidden" id="min_price" name="min_price" value="<?= $range_min ?>" />
          <input type="hidden" id="max_price" name="max_price" value="<?= $range_max ?>" />
          <span class="range__res-item min-price"><?= $filter_min ?> руб.</span>
          <span class="range__res-item max-price"><?= $filter_max ?> руб.</span>
        </div>
      </div>
    </div>

    <fieldset class="custom-form__group">
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox"<?= !empty($_GET['new']) ? ' checked' : '' ?>>
      <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox"<?= !empty($_GET['sale']) ? ' checked' : '' ?>>
      <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
    </fieldset>
    <button class="button" type="submit" style="width: 100%">Применить</button>
  </form>
</section>
