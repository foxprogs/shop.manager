<?php

define('COOKIE_LIFETIME', 60 * 60 * 24 * 30);
define('SESSION_COOKIE_LIFETIME', 60 * 60 * 24);
define('SESSION_LIFETIME', 60 * 60 * 24);
define('SESSION_NAME', 'session_id');

define('DELIVERY_PRICE', 280);
define('DELIVERY_MIN_PRICE', 2000);
define('DELIVERY_NO', 1);
define('DELIVERY_YES', 2);

define('PAYMENT_CARD', 1);
define('PAYMENT_CASH', 2);

define('PER_PAGE', 3);

define('UPLOAD_FOLDER', '/img/products/');
define('UPLOAD_FOLDER_SERVER', $_SERVER['DOCUMENT_ROOT'] . UPLOAD_FOLDER);

define('GROUP_OPERATOR', 'operator');
define('GROUP_ADMIN', 'admin');

define('DB_HOST', 'localhost');
define('DB_USER', 'shop');
define('DB_PASSWORD', 'IW2bSWv7cy4BKs1T');
define('DB_NAME', 'fashion');
