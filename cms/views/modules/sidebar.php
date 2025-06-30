<?php 
// Asegúrate de que la sesión esté activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validar si la sesión del admin existe
if (isset($_SESSION["admin"])) {
    $admin = $_SESSION["admin"];
} else {
    // Si no hay sesión, puedes redirigir o cargar valores por defecto
    $admin = (object)[
        "symbol_admin" => "",
        "title_admin" => ""
    ];
}
?>

<div class="bg-white shadow" id="sidebar-wrapper">

    <div class="sidebar-heading text-center py-4">
        <?php echo $admin->symbol_admin; ?>
        <span class="menu-text"><?php echo $admin->title_admin; ?></span>
    </div>

    <hr class="mt-0 borderDashboard">

    <ul class="list-group list-group-flush" id="sortable">

        <li class="list-group-item list-group-item-action position-relative">
            <a class="bg-transparent text-dark" href="/inicio">
                <i class="bi bi-house-door-fill textColor"></i>
                <span class="menu-text">Inicio</span>
            </a>
        </li>

        <li class="list-group-item list-group-item-action position-relative">
            <a class="bg-transparent text-dark" href="/admins">
                <i class="bi bi-person-fill-gear textColor"></i>
                <span class="menu-text">Administradores</span>
            </a>
        </li>

    </ul>

    <hr class="borderDashboard">

    <button class="btn btn-default border rounded btn-sm ms-3 menu-text mt-2">Agregar Pagina</button>

</div>
