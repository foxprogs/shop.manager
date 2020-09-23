<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";

if ($user = get_auth_user()) {
    $pages = [
        '/admin/orders' => [
            'url' => '/admin/orders',
            'path' => 'orders.php',
            'access' => ['operator', 'admin'],
        ],
        '/admin/products' => [
            'url' => '/admin/products',
            'path' => 'products.php',
            'access' => ['admin'],
        ],
        '/admin/products/add' => [
            'url' => '/admin/products/add',
            'path' => 'products_add.php',
            'access' => ['admin'],
        ],
        '/admin/products/edit' => [
            'url' => '/admin/products/edit',
            'path' => 'products_edit.php',
            'access' => ['admin'],
        ],
    ];

    $current_page_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (isset($pages[$current_page_url])) {
        $current_page = $pages[$current_page_url];
        if (array_diff($current_page['access'], $user['groups']) == []) {
            require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/" . $current_page['path'];
        } else {
            show_error('Доступ к странице запрещен');
        }
    } else {
        show_error('Страницы не существует');
    }
} else {
    show_error('Для продолжения необходимо войти');
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php";
