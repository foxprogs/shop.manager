<?php

function get_order_column()
{
    if (empty($_COOKIE['order_column']) || !in_array($_COOKIE['order_column'], ['name', 'price'])) {
        setcookie('order_column', 'price', time() + 60 * 60 * 24 * 30, '/');
        return 'price';
    } else {
        return $_COOKIE['order_column'];
    }
}

function get_order_by()
{
    if (empty($_COOKIE['order_by']) || !in_array($_COOKIE['order_by'], ['asc', 'desc'])) {
        setcookie('order_by', 'asc', time() + 60 * 60 * 24 * 30, '/');
        return 'asc';
    } else {
        return $_COOKIE['order_by'];
    }
}
