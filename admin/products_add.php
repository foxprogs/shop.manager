<main class="page-add">
  <h1 class="h h--1">Добавление товара</h1>
  <form class="custom-form" action="#" method="post">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <div>
      <label for="name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="name" id="name" required="">
        <p class="custom-form__input-label">
          Название товара
        </p>
      </label>
      <label for="price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="price" id="price" required="">
        <p class="custom-form__input-label">
          Цена товара
        </p>
      </label>
      </div>
      <br>
      <input type="checkbox" name="active" id="active" checked="" class="custom-form__checkbox">
      <label for="active" class="custom-form__checkbox-label">Активен</label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <ul class="add-list">
        <li class="add-list__item add-list__item--add">
          <input type="file" name="photo" id="photo" hidden="">
          <label for="photo">Добавить фотографию</label>
        </li>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple" required="">
          <option hidden="">Название раздела</option>
          <?php foreach (get_categories() as $category) : ?>
            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox">
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <input type="hidden" name="add" value="1">
    <button class="button button_add" type="submit">Добавить товар</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
    </div>
  </section>
</main>
