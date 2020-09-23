<?php
if (empty($_GET['id'])) {
    header('Refresh:0;url=/admin/products');
    die();
}
$product = get_product((int)$_GET['id']);
if (!$product) {
    header('Refresh:0;url=/admin/products');
    die();
}
?>
<main class="page-add">
  <h1 class="h h--1">Редактирование товара</h1>
  <form class="custom-form" action="#" method="post">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <div>
          <label for="name" class="custom-form__input-wrapper page-add__first-wrapper">
            <input type="text" class="custom-form__input" value="<?= htmlspecialchars($product['name']) ?>" name="name" id="name">
            <p class="custom-form__input-label" hidden="">
              Название товара
            </p>
          </label>
          <label for="price" class="custom-form__input-wrapper">
            <input type="text" class="custom-form__input" value="<?= $product['price'] ?>" name="price" id="price">
            <p class="custom-form__input-label" hidden="">
              Цена товара
            </p>
          </label>
      </div>
      <br>
      <input type="checkbox" name="active" id="active" <?= $product['is_active'] ? 'checked=""' : '' ?> class="custom-form__checkbox">
      <label for="active" class="custom-form__checkbox-label">Активен</label>
    </fieldset>
    <?php
    $photo = file_exists(UPLOAD_FOLDER_SERVER . 'product-' . $product['id'] . '.jpg');
    ?>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <ul class="add-list">
        <li class="add-list__item add-list__item--add"<?= !$photo ? '' : ' hidden=""' ?>>
          <input type="file" name="photo" id="photo" hidden="">
          <label for="photo">Добавить фотографию</label>
        </li>
        <?php if ($photo) : ?>
        <li class="add-list__item add-list__item--active">
          <img src="<?= UPLOAD_FOLDER . 'product-' . $product['id'] . '.jpg' ?>">
        </li>
        <?php endif; ?>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple">
          <option hidden="">Название раздела</option>
          <?php foreach (get_categories() as $category) : ?>
            <option value="<?= $category['id'] ?>" <?= isset($product['categories'][$category['id']]) ? 'selected' : '' ?>><?= $category['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" <?= $product['is_new'] ? 'checked=""' : '' ?> class="custom-form__checkbox">
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" <?= $product['is_sale'] ? 'checked=""' : '' ?> class="custom-form__checkbox">
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <input type="hidden" name="edit" value="1">
    <button class="button button_edit" data-id="<?= $product['id'] ?>" type="submit">Обновить товар</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно изменен</h2>
    </div>
  </section>
</main>
