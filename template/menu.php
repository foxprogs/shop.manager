<nav class="page-<?= $position_class ?>__menu">
    <ul class="main-menu main-menu--<?= $position_class ?>">
        <?php foreach ($main_menu as $el) :?>
            <li>
                <a class='main-menu__item <?= is_current_page($el['path']) ? $active_class : '' ?>' href='<?= $el['path'] ?>'><?= $el['title'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
