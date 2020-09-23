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

if (empty($_POST['id'])) {
    return_json(['status' => 'error', 'data' => 'Ошибка идентификатора']);
}

if (!delete_product($_POST['id'])) {
    return_json(['status' => 'error', 'data' => 'Ошибка при удалении']);
}

return_json(['status' => 'success', 'data' => $_POST['id']]);
