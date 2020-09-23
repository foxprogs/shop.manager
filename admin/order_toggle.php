<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/constants.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helper/auth.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helper/views.php";

$user = get_auth_user();
if (!in_array('admin', $user['groups']) && !in_array('operator', $user['groups'])) {
    return_json(['status' => 'error', 'data' => 'Доступ запрещен']);
}

if (empty($_POST['id'])) {
    return_json(['status' => 'error', 'data' => 'Не указан идентификатор']);
}

if (!isset($_POST['status'])) {
    return_json(['status' => 'error', 'data' => 'Не указан идентификатор']);
}

if (order_toggle()) {
    return_json(['status' => 'success']);
} else {
    return_json(['status' => 'error', 'data' => 'Ошибка при выполнении запроса']);
}
