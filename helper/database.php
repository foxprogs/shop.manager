<?php
/*

test1@mail.ru 1111 - админ и оператор
test2@mail.ru 2222 - оператор
test3@mail.ru 3333 - без группы

*/
function connect()
{
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config/constants.php";
    static $connect = null;
    $connect = $connect ?? mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
    return $connect;
}

/**
* Возвращает null или массив с данными по пользователю + группы, в которых он состоит
*/
function get_user(string $email)
{
    $email = mysqli_escape_string(connect(), $email);
    $query = "SELECT * FROM users WHERE email = '$email' ";
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }
    if (mysqli_num_rows($result) == 0) {
        return null;
    }
    $user = mysqli_fetch_assoc($result);

    $user['groups'] = [];
    $query = "
        SELECT g.* 
        FROM group_user as gu 
        LEFT JOIN groups as g ON gu.group_id = g.id 
        WHERE user_id = " . $user['id'];
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }
    while ($group = mysqli_fetch_assoc($result)) {
        $user['groups'][$group['id']] = $group['name'];
    }

    return $user;
}

function get_products(array $config)
{
    $query = "
        SELECT *
        FROM products as p LEFT JOIN category_product as cp ON (p.id = cp.product_id)
        WHERE p.is_active = 1";
    if (!empty($_GET['category'])) {
        $category = mysqli_escape_string(connect(), $_GET['category']);
        $query .= " AND cp.category_id = $category";
    }
    if (!empty($_GET['new'])) {
        $query .= " AND p.is_new = 1";
    }
    if (!empty($_GET['sale'])) {
        $query .= " AND p.is_sale = 1";
    }

    if (!empty($_GET['min_price'])) {
        $query .= " AND p.price >= " . (int) $_GET['min_price'];
    }
    if (!empty($_GET['max_price'])) {
        $query .= " AND p.price <= " . (int) $_GET['max_price'];
    }

    $query .= " GROUP BY p.id";

    $query .= " ORDER BY " . mysqli_escape_string(connect(), $config['order_column']) . ' ' . mysqli_escape_string(connect(), $config['order_by']);

    $page = 0;
    if (!empty($_GET['page'])) {
        $page = ($_GET['page'] - 1) * PER_PAGE;
    }

    $query .= " LIMIT " . $page . ", ".PER_PAGE;
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_products_stat()
{
    return ['total' => get_total_products(), 'filter' => get_min_max_products()];
}

function get_total_products()
{
    $query = "
        SELECT count(tmp.id) as `total`
        FROM (
            SELECT p.id
            FROM products as p LEFT JOIN category_product as cp ON (p.id = cp.product_id)
            WHERE p.is_active = 1";
    if (!empty($_GET['category'])) {
        $category = mysqli_escape_string(connect(), $_GET['category']);
        $query .= " AND cp.category_id = $category";
    }
    if (!empty($_GET['new'])) {
        $query .= " AND p.is_new = 1";
    }
    if (!empty($_GET['sale'])) {
        $query .= " AND p.is_sale = 1";
    }
    if (!empty($_GET['min_price'])) {
        $query .= " AND p.price >= " . (int) $_GET['min_price'];
    }
    if (!empty($_GET['max_price'])) {
        $query .= " AND p.price <= " . (int) $_GET['max_price'];
    }
    $query .= " GROUP by p.id) as tmp";
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }
    return mysqli_fetch_assoc($result)['total'];
}

function get_min_max_products()
{
    $query = "
        SELECT min(price) as min_price, max(price) as max_price
        FROM (SELECT p.id as id, p.price as price 
            FROM products as p LEFT JOIN category_product as cp ON (p.id = cp.product_id)
            WHERE p.is_active = 1";
    if (!empty($_GET['category'])) {
        $category = mysqli_escape_string(connect(), $_GET['category']);
        $query .= " AND cp.category_id = $category";
    }
    if (!empty($_GET['new'])) {
        $query .= " AND p.is_new = 1";
    }
    if (!empty($_GET['sale'])) {
        $query .= " AND p.is_sale = 1";
    }
    $query .= " GROUP by p.id) as tmp";
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }
    return mysqli_fetch_assoc($result);
}

function get_admin_products()
{
    $products = [];
    $query = "
        SELECT p.id, p.name, p.price, p.is_new, c.name as category_name
        FROM (
            SELECT * FROM products
            WHERE is_active = 1
            ORDER BY id ASC";

    $page = 0;
    if (!empty($_GET['page'])) {
        $page = ($_GET['page'] - 1) * PER_PAGE;
    }

    $query .= " LIMIT " . $page . ", ".PER_PAGE;
    $query .= ") as p LEFT JOIN category_product as cp ON (p.id = cp.product_id)
        LEFT JOIN categories as c ON (c.id = cp.category_id)
        ORDER BY p.id ASC";
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }

    while ($product = mysqli_fetch_assoc($result)) {
        if (!isset($products[$product['id']])) {
            $products[$product['id']] = $product;
            unset($products[$product['id']]['category_name']);
        }
        $products[$product['id']]['categories'][] = $product['category_name'];
    }
    return $products;
}

function get_admin_total_products()
{
    $query = "SELECT count(id) as `total` FROM products WHERE is_active = 1";
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }

    return mysqli_fetch_assoc($result)['total'];
}

function delete_product(int $id)
{
    $id = mysqli_escape_string(connect(), $id);
    $query = "
        UPDATE products
        SET is_active = 0
        WHERE id = $id";
    return mysqli_query(connect(), $query);
}

function add_product()
{
    $name = mysqli_escape_string(connect(), $_POST['name']);
    $price = (int) $_POST['price'];
    $active = isset($_POST['active']) ? 1 : 0 ;
    $new = isset($_POST['new']) ? 1 : 0 ;
    $sale = isset($_POST['sale']) ? 1 : 0 ;
    $query = "
        INSERT INTO products
        (`name`, `price`, `is_active`, `is_new`, `is_sale`)
        VALUES ('$name', $price, $active, $new, $sale)";
    if (mysqli_query(connect(), $query)) {
        $id = mysqli_insert_id(connect());
        if (!empty($_POST['category']) && is_array($_POST['category'])) {
            add_product_category($id);
        }
        if (!empty($_FILES['photo'])) {
            $photo = add_product_photo($id);
            if ($photo !== true) {
                $query = "DELETE FROM products WHERE id = $id";
                mysqli_query(connect(), $query);
                return ['error' => $photo];
            }
        }
        return ['error' => false, 'id' => $id];
    } else {
        return ['error' => 'Ошибка при сохранении данных'];
    }
}

function edit_product(int $id)
{
    $id = (int) $_GET['id'];
    $name = mysqli_escape_string(connect(), $_POST['name']);
    $price = (int) $_POST['price'];
    $active = isset($_POST['active']) ? 1 : 0 ;
    $new = isset($_POST['new']) ? 1 : 0 ;
    $sale = isset($_POST['sale']) ? 1 : 0 ;
    $query = "
        UPDATE products
        SET is_active = $active, is_new = $new, is_sale = $sale, name = '$name', price = $price
        WHERE id = $id";
    if (mysqli_query(connect(), $query)) {
        $query = "DELETE FROM category_product WHERE product_id = $id";
        mysqli_query(connect(), $query);
        if (!empty($_POST['category']) && is_array($_POST['category'])) {
            add_product_category($id);
        }
        if (!empty($_FILES['photo'])) {
            $photo = add_product_photo($id);
            if ($photo !== true) {
                return ['error' => $photo];
            }
        }
        return ['error' => false, 'id' => $id];
    } else {
        return ['error' => 'Ошибка при сохранении данных'];
    }
}

function add_product_photo(int $id)
{
    $photo = $_FILES['photo'];
    if (!is_dir(UPLOAD_FOLDER_SERVER)) {
        if (!mkdir(UPLOAD_FOLDER_SERVER)) {
            return 'Не удалось создать папку для загрузки изображений.';
        }
    }
    if ((int) $photo['error'] ===  UPLOAD_ERR_NO_FILE) {
        // unlink(UPLOAD_FOLDER_SERVER . 'product-' . $id . '.jpg');
        return true;
    }
    if ((int) $photo['error'] !== UPLOAD_ERR_OK) {
        return 'Ошибка загрузки изображения';
    }
    if (mime_content_type($photo['tmp_name']) != 'image/jpeg') {
        return 'Загружать можно только файлы формата .jpg';
    }
    if (!move_uploaded_file($photo['tmp_name'], UPLOAD_FOLDER_SERVER . 'product-' . $id . '.jpg')) {
        return "Ошибка при сохранении файла";
    }
    return true;
}

function add_product_category(int $id)
{
    $query = "
        INSERT INTO category_product
        (`category_id`, `product_id`)
        VALUES ";
    $values = [];
    foreach ($_POST['category'] as $cat_id) {
        $cat_id = (int) $cat_id;
        $values[] = "($cat_id, $id)";
    }
    $query .= implode(',', $values);
    return mysqli_query(connect(), $query);
}

function get_product(int $id)
{
    $id = (int) $id;
    $query = "SELECT p.*, c.id as cat_id, c.name as cat_name FROM products as p 
        LEFT JOIN category_product as cp ON (p.id = cp.product_id)
        LEFT JOIN categories as c ON (c.id = cp.category_id) WHERE p.id = $id";
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }
    if (mysqli_num_rows($result) == 0) {
        return null;
    }
    while ($product = mysqli_fetch_assoc($result)) {
        if (!isset($return)) {
            $return = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'is_active' => $product['is_active'],
                'is_new' => $product['is_new'],
                'is_sale' => $product['is_sale'],
                'categories' => []
            ];
        }
        $return['categories'][$product['cat_id']] = ['id' => $product['cat_id'], 'name' => $product['cat_name']];
    }
    return $return;
}

function get_categories()
{
    $query = "SELECT * FROM categories ORDER BY id ASC";
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function add_order($product)
{
    $product_id = (int) $_POST['product_id'];
    $name = mysqli_escape_string(connect(), $_POST['surname']);
    $name .= ' ' . mysqli_escape_string(connect(), $_POST['name']);
    if (!empty($_POST['third_name'])) {
        $name .= ' ' . mysqli_escape_string(connect(), $_POST['third_name']);
    }
    $comment = mysqli_escape_string(connect(), $_POST['comment'] ?? null);
    $phone = mysqli_escape_string(connect(), $_POST['phone']);
    $email = mysqli_escape_string(connect(), $_POST['email']);
    $is_delivery = ($_POST['is_delivery'] == DELIVERY_YES) ? DELIVERY_YES : DELIVERY_NO ;
    if ($is_delivery == DELIVERY_YES) {
        $address = 'г. ' . mysqli_escape_string(connect(), $_POST['city']);
        $address .= ', ул. ' . mysqli_escape_string(connect(), $_POST['street']);
        $address .= ', д. ' . mysqli_escape_string(connect(), $_POST['home']);
        $address .= ', кв. ' . mysqli_escape_string(connect(), $_POST['aprt']);
    } else {
        $address = null;
    }
    $payment_type = ($_POST['payment_type'] == PAYMENT_CARD) ? PAYMENT_CARD : PAYMENT_CASH ;
    $price = ($product['price'] <= DELIVERY_MIN_PRICE) ? ($product['price'] + DELIVERY_PRICE) : $product['price'] ;

    $query = "
        INSERT INTO orders
        (`product_id`, `name`, `price`, `phone`, `address`, `email`, `is_delivery`, `payment_type`, `comment`)
        VALUES ($product_id, '$name', $price, '$phone', '$address', '$email', $is_delivery, $payment_type, '$comment')";
    if (mysqli_query(connect(), $query)) {
        return ['error' => false, 'id' => mysqli_insert_id(connect())];
    } else {
        return ['error' => 'Ошибка при сохранении данных. ' . $query];
    }
}

function get_orders()
{
    $query = "SELECT * FROM orders ORDER BY status ASC, created_at DESC";
    $result = mysqli_query(connect(), $query);
    if (!$result) {
        die(mysqli_error(connect()));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function order_toggle()
{
    $id = (int) $_POST['id'];
    $status = (int) $_POST['status'] % 2;
    $query = "
        UPDATE orders
        SET status = $status
        WHERE id = $id";
    return mysqli_query(connect(), $query);
}
