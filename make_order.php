<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config/constants.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helper/views.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helper/database.php";

/*
1. Валидация полей
2. Рассчет суммы с учетом доставки
3. Запись в базу
*/
$validate = [
    ['field' => 'product_id', 'error' => 'Не выбран товар'],
    ['field' => 'name', 'error' => 'Не указано имя'],
    ['field' => 'surname', 'error' => 'Не указана фамилия'],
    ['field' => 'phone', 'error' => 'Не указан телефон'],
    ['field' => 'email', 'error' => 'Не указан email'],
    ['field' => 'is_delivery', 'error' => 'Не выбран способ доставки'],
    ['field' => 'payment_type', 'error' => 'Не выбран способ оплаты'],
];

foreach ($validate as $one) {
    if (empty($_POST[$one['field']])) {
        return_json(['status' => 'error', 'data' => $one['error']]);
    }
}
$product = get_product((int)$_POST['product_id']);
if (empty($product) || $product['is_active'] == 0) {
    return_json(['status' => 'error', 'data' => 'Товар не найден']);
}

if ($_POST['is_delivery'] == DELIVERY_YES) {
    if (empty($_POST['city']) || empty($_POST['street']) || empty($_POST['home']) || empty($_POST['aprt'])) {
        return_json(['status' => 'error', 'data' => 'Не все поля адреса заполнены']);
    }
}

$query = add_order($product);

if ($query['error'] === false) {
    return_json(['status' => 'success', 'data' => $query['id']]);
} else {
    return_json(['status' => 'error', 'data' => $query['error']]);
}
