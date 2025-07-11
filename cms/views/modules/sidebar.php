<?php

$url = "pages?orderBy=order_page&orderMode=ASC";
$method = "GET";
$fields = array();

$pages = CurlController::request($url, $method, $fields);

if ($pages->status == 200) {

    $pages = $pages->results;

} else {

    $pages = array();

}

?>

<div class="bg-white shadow" id="sidebar-wrapper">

    <div class="sidebar-heading text-center py-4">
        <?php echo $admin->symbol_admin; ?>
        <span class="menu-text"><?php echo $admin->title_admin; ?></span>
    </div>

    <hr class="mt-0 borderDashboard">

    <ul class="list-group list-group-flush" id="sortable">

        <?php if (!empty($pages)): ?>

            <?php foreach ($pages as $key => $value): ?>

                <li class="list-group-item list-group-item-action position-relative">

                    <a class="bg-transparent text-dark" href="/<?php echo $value->url_page; ?>">

                        <i class="<?php echo $value->icon_page ?> textColor"></i>
                        <span class="menu-text"><?php echo $value->title_page ?></span>
                    </a>
                </li>

            <?php endforeach; ?>

        <?php endif; ?>

    </ul>

    <?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

        <hr class="borderDashboard">

        <button class="btn btn-default border rounded btn-sm ms-3 menu-text mt-2 myPage">Agregar Pagina</button>


    <?php endif ?>

</div>