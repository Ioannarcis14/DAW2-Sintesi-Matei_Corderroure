<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomePageController::index');

//(The API routes will have JWT Filters and the web routes will have Myth/Auth Filters)

//API ROUTES 

$routes->group("api", function ($routes) {

    $routes->options("register", "API\APIUserController::register");
    $routes->post("register", "API\APIUserController::register");

    $routes->options("login", "API\APIUserController::login");
    $routes->post("login", "API\APIUserController::login");

    $routes->options("logout", "API\APIUserController::logout");
    $routes->get("logout", "API\APIUserController::logout", ['filter'=>'jwt']);

    $routes->options("validate", "API\APIUserController::isUserAuthenticated");
    $routes->post("validate", "API\APIUserController::isUserAuthenticated", ['filter'=>'jwt']);

    $routes->group("users", function ($routes) {

        $routes->get("getAll", "API\APIUserController::getAllUsers");

        $routes->options("create","API\APIRestaurantController::create");
        $routes->post("create","API\APIUserController::create", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APIUserController::update/$1");
        $routes->post("update/(:any)", "API\APIUserController::update/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APIUserController::delete/$1");
        $routes->post("delete/(:any)","API\APIUserController::delete/$1", ['filter'=>'jwt']);

        $routes->get("getAllRoles", "API\APIUserController::getAllRoles");

        $routes->options("createRole","API\APIUserController::createRole");
        $routes->post("createRole","API\APIUserController::createRole", ['filter'=>'jwt']);

        $routes->options("updateRole/(:any)","API\APIUserController::updateRole/$1");
        $routes->post("updateRole/(:any)", "API\APIUserController::updateRole/$1", ['filter'=>'jwt']);

        $routes->options("deleteRole/(:any)","API\APIUserController::deleteRole/$1");
        $routes->post("deleteRole/(:any)","API\APIUserController::deleteRole/$1", ['filter'=>'jwt']);

        $routes->options("assignRole","API\APIUserController::assignRole");
        $routes->post("assignRole","API\APIUserController::assignRole", ['filter'=>'jwt']);
    });
 
    $routes->group("restaurant", function ($routes) {
        $routes->get("getAll", "API\APIRestaurantController::getAllRestaurants");
        
        $routes->get("getRestaurant/(:any)", "API\APIRestaurantController::getSpecificRestaurant/$1");

        $routes->get("getReviews/(:any)", "API\APIRestaurantController::getReviews/$1");

        $routes->options("create","API\APIRestaurantController::createRestaurant");
        $routes->post("create","API\APIRestaurantController::createRestaurant", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APIRestaurantController::updateRestaurant/$1");
        $routes->post("update/(:any)","API\APIRestaurantController::updateRestaurant/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APIRestaurantController::deleteRestaurant/$1");
        $routes->post("delete/(:any)","API\APIRestaurantController::deleteRestaurant/$1", ['filter'=>'jwt']);

        $routes->options("createReviews","API\APIRestaurantController::createReviews");
        $routes->post("createReviews","API\APIRestaurantController::createReviews");
    });

    $routes->group("allergen", function ($routes) {
        $routes->get("getAll", "API\APIAllergenController::getAllAllergens");
    });

    $routes->group("category", function ($routes) {
        $routes->get("getAll", "API\APICategoryController::getAllCategories");

        $routes->options("create","API\APICategoryController::createCategory");
        $routes->post("create","API\APICategoryController::createCategory", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APICategoryController::updateCategory/$1");
        $routes->post("update/(:any)","API\APICategoryController::updateCategory/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APICategoryController::deleteCategory/$1");
        $routes->post("delete/(:any)","API\APICategoryController::deleteCategory/$1", ['filter'=>'jwt']);

    });

    $routes->group("dish", function ($routes) {
        $routes->get("getAll", "API\APIDishController::getAllDishes");

        $routes->options("create","API\APIDishController::createDish");
        $routes->post("create","API\APIDishController::createDish", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APIDishController::updateDish/$1");
        $routes->post("update/(:any)","API\APIDishController::updateDish/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APIDishController::deleteDish/$1");
        $routes->post("delete/(:any)","API\APIDishController::deleteDish/$1", ['filter'=>'jwt']);
        
        $routes->options("assignSupplement","API\APIDishController::assignSupplement");
        $routes->post("assignSupplement","API\APIDishController::assignSupplement", ['filter'=>'jwt']);

        $routes->options("assignCategory","API\APIDishController::assignCategory");
        $routes->post("assignCategory","API\APIDishController::assignCategory", ['filter'=>'jwt']);

        $routes->options("assignAllergen","API\APIDishController::assignAllergen");
        $routes->post("assignAllergen","API\APIDishController::assignAllergen", ['filter'=>'jwt']);

    });

    $routes->group("messages", function ($routes) {
        $routes->get("getAll", "API\APIMessagesController::getAllMessages");

        $routes->options("create","API\APIMessagesController::createMessages");
        $routes->post("create","API\APIMessagesController::createMessages", ['filter'=>'jwt']);

    });

    $routes->group("order", function ($routes) {
        $routes->get("getAll", "API\APIOrderController::getAllOrders");

        $routes->options("create","API\APIOrderController::createOrder");
        $routes->post("create","API\APIOrderController::createOrder", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APIOrderController::updateOrder/$1");
        $routes->post("update/(:any)","API\APIOrderController::updateOrder/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APIOrderController::deleteOrder/$1");
        $routes->post("delete/(:any)","API\APIOrderController::deleteOrder/$1", ['filter'=>'jwt']);

    });

    $routes->group("supplement", function ($routes) {
        $routes->get("getAll", "API\APISupplementController::getAllSupplements");

        $routes->options("create","API\APISupplementController::createSupplement");
        $routes->post("create","API\APISupplementController::createSupplement", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APISupplementController::updateSupplement/$1");
        $routes->post("update/(:any)","API\APISupplementController::updateSupplement/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APISupplementController::deleteSupplement/$1");
        $routes->post("delete/(:any)","API\APISupplementController::deleteSupplement/$1", ['filter'=>'jwt']);

    });

    $routes->group("taula", function ($routes) {
        $routes->get("getAll", "API\APITaulaController::getAllTaules");

        $routes->options("create","API\APITaulaController::createTaula");
        $routes->post("create","API\APITaulaController::createTaula", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APITaulaController::updateTaula/$1");
        $routes->post("update/(:any)","API\APITaulaController::updateTaula/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APITaulaController::deleteTaula/$1");
        $routes->post("delete/(:any)","API\APITaulaController::deleteTaula/$1", ['filter'=>'jwt']);

    });

});


//ADMIN ROUTES


$routes->group("admin", function ($routes) {
        $routes->match(['get','post'], 'users', 'AdminCrudController::view', ['filter'=>'role:administrador']);

});

//RESPONSABLE ROUTES

$routes->group("responsable", function ($routes) {
    $routes->match(['get','post'], 'restaurants', 'ResponsableCrudController::view', ['filter'=>'role:responsable']);

});


//CAMBRER CUINER ROUTES




//MAITRE ROUTES




//CLIENT ROUTES



/*
*-----------------------------------------------------------------------
*   MYTH AUTH SERVICE ROUTES
*-----------------------------------------------------------------------
*/

// Login/out
$routes->get('login', 'AuthController::login', ['as' => 'login']);
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

// Registration
$routes->get('register', 'AuthController::register', ['as' => 'register']);
$routes->post('register', 'AuthController::attemptRegister');

// Activation
$routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
$routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

// Forgot/Resets
$routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
$routes->post('forgot', 'AuthController::attemptForgot');
$routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
$routes->post('reset-password', 'AuthController::attemptReset');





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
