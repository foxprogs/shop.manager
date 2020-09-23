<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/constants.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/menu.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helper/auth.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helper/views.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helper/menu.php";

$user = get_auth_user();
if (!in_array('admin', $user['groups'])) {
    return_json(['status' => 'error', 'data' => 'Доступ запрещен']);
}

if (empty($_GET['id'])) {
    return_json(['status' => 'error', 'data' => 'Ошибка идентификатора']);
}

if (empty($_POST['edit'])) {
    return_json(['status' => 'error', 'data' => 'Форма не отправлена']);
}
if (empty($_POST['name'])) {
    return_json(['status' => 'error', 'data' => 'Не указано название товара']);
}
if (empty($_POST['price'])) {
    return_json(['status' => 'error', 'data' => 'Не указана цена товара']);
}

$query = edit_product((int) $_GET['id']);

if ($query['error'] === false) {
    return_json(['status' => 'success', 'data' => $query['id']]);
} else {
    return_json(['status' => 'error', 'data' => $query['error']]);
}
