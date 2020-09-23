<?php

function is_current_page(string $path)
{
    return $path == parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

/**
 * $variant это массив из трех слов, для 1,3,5. Например ['стол', 'стола', 'столов']
 */
function num_word(int $count, array $variant)
{
    if ($count % 100 > 4 && $count % 100 < 21) {
        $index = 2;
    } else {
        switch ($count%10) {
            case 1:
                $index = 0;
                break;
            
            case 2:
            case 3:
            case 4:
                $index = 1;
                break;
            
            default:
                $index = 2;
                break;
        }
    }
    return $variant[$index];
}

function price_format($price)
{
    return number_format((int) $price, 0, '', ' ');
}

function show_error(string $message = 'Неверный логин или пароль')
{
    require_once $_SERVER['DOCUMENT_ROOT'] . "/template/error.php";
}

function return_json(array $message = [])
{
    header('Content-Type: application/json');
    if ($message) {
        echo json_encode($message);
    }
    exit();
}
