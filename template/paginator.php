<ul class="shop__paginator paginator">
    <?php if ($products_stat['total'] > 0) :
        for ($i = 1; $i <= ceil($products_stat['total'] / PER_PAGE); $i++) :
            $query_url = $_SERVER['PHP_SELF'] . '?' . http_build_query(array_merge($_GET, ["page" => $i ])); ?>
    <li>
        <a class="paginator__item" <?= $i == ($_GET['page'] ?? 1) ? '' : 'href="' . $query_url . '"' ?>><?= $i ?></a>
    </li>
        <?php endfor;
    endif; ?>
</ul>
