<?

if (!class_exists('AdminMenu')) {
    require_once "AdminMenu.php";
}

$adminMenu = new AdminMenu($database);
