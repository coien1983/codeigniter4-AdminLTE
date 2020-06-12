<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');


$routes->group("admin",function ($routes){

    $routes->add("index","admin\ManageController::login");

    $routes->add("index/index","admin\IndexController::index");

    $routes->group("manage",function ($routes){
        $routes->add("login","admin\ManageController::login");
    });

    $routes->group("role",function ($routes){
        $routes->add("index","admin\RoleController::index");
        $routes->add("add","admin\RoleController::add");
        $routes->add("edit/(:num)","admin\RoleController::edit");
        $routes->add("delete","admin\RoleController::delete");
        $routes->add("roleStatus","admin\RoleController::roleStatus");
        $routes->add("access/(:num)","admin\RoleController::access");
    });

    $routes->group("menu",function ($routes){
        $routes->add("index","admin\MenuController::index");
        $routes->add("edit/(:num)","admin\MenuController::edit");
        $routes->add("add/(:num)","admin\MenuController::add");
        $routes->add("delete/(:num)","admin\MenuController::delete");
    });

    $routes->group("staff",function ($routers){
       $routers->add("profile","admin\StaffController::profile");
       $routers->add("index","admin\StaffController::index");
       $routers->add('logout',"admin\StaffController::logout");
       $routers->add('add',"admin\StaffController::add");
       $routers->add('edit/(:num)',"admin\StaffController::edit");
       $routers->add('delete',"admin\StaffController::delete");
       $routers->add('staffStatus',"admin\StaffController::staffStatus");
    });

    $routes->group("setting",function ($routes){
        $routes->add("index","admin\SettingController::index");
        $routes->add("update","admin\SettingController::update");
    });
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
