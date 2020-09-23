<?php
$orders = get_orders();
?>
<main class="page-order">
    <h1 class="h h--1">Список заказов</h1>
    <?php if (count($orders) > 0) : ?>
        <ul class="page-order__list">
            <?php foreach ($orders as $order) : ?>
                <li class="order-item page-order__item">
                  <div class="order-item__wrapper">
                    <div class="order-item__group order-item__group--id">
                      <span class="order-item__title">Номер заказа</span>
                      <span class="order-item__info order-item__info--id"><?= $order['id'] ?></span>
                    </div>
                    <div class="order-item__group">
                      <span class="order-item__title">Сумма заказа</span>
                      <?= price_format($order['price']) ?> руб.
                    </div>
                    <button class="order-item__toggle"></button>
                  </div>
                  <div class="order-item__wrapper">
                    <div class="order-item__group order-item__group--margin">
                      <span class="order-item__title">Заказчик</span>
                      <span class="order-item__info"><?= htmlspecialchars($order['name']) ?></span>
                    </div>
                    <div class="order-item__group">
                      <span class="order-item__title">Номер телефона</span>
                      <span class="order-item__info"><?= htmlspecialchars($order['phone']) ?></span>
                    </div>
                    <div class="order-item__group">
                      <span class="order-item__title">Способ доставки</span>
                      <span class="order-item__info"><?= ($order['is_delivery'] == DELIVERY_YES) ? 'Доставка' : 'Самовывоз' ?></span>
                    </div>
                    <div class="order-item__group">
                      <span class="order-item__title">Способ оплаты</span>
                      <span class="order-item__info">Наличными</span>
                    </div>
                    <div class="order-item__group order-item__group--status">
                      <span class="order-item__title">Статус заказа</span>
                      <span data-id="<?= $order['id'] ?>" class="order-item__info order-item__info--<?= $order['status'] ? 'yes' : 'no' ?>"><?= $order['status'] ? 'Выполнено' : 'Не выполнено' ?></span>
                      <button class="order-item__btn">Изменить</button>
                    </div>
                  </div>
                  <div class="order-item__wrapper">
                    <div class="order-item__group">
                      <span class="order-item__title">Адрес доставки</span>
                      <span class="order-item__info"><?= htmlspecialchars($order['address']) ?></span>
                    </div>
                  </div>
                  <div class="order-item__wrapper">
                    <div class="order-item__group">
                      <span class="order-item__title">Комментарий к заказу</span>
                      <span class="order-item__info"><?= htmlspecialchars($order['comment']) ?></span>
                    </div>
                  </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Заказов нет</p>
    <?php endif; ?>
</main>
