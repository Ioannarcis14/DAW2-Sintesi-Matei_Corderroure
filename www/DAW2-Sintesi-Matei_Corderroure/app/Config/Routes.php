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
    
    /////////////////////////////////////////////////////
    ///////// ROUTES AUTHENTICATION API ROUTES //////////
    /////////////////////////////////////////////////////
    
    $routes->options("register", "API\APIAuthController::register");
    $routes->post("register", "API\APIAuthController::register");

    $routes->options("login", "API\APIAuthController::login");
    $routes->post("login", "API\APIAuthController::login");

    $routes->options("logout", "API\APIAuthController::logout");
    $routes->get("logout", "API\APIAuthController::logout", ['filter'=>'jwt']);

    $routes->options("validate", "API\APIAuthController::isUserAuthenticated");
    $routes->post("validate", "API\APIAuthController::isUserAuthenticated", ['filter'=>'jwt']);

    //////////////////////////////////////////////
    ///////// ROUTES TESTING API ROUTES //////////
    //////////////////////////////////////////////
    
    $routes->options("testAuth","API\APIAdministracioController::testAuth");
    $routes->get("testAuth","API\APIAdministracioController::testAuth");

    $routes->options("testUser","API\APIAdministracioController::testUser");
    $routes->get("testUser","API\APIAdministracioController::testUser");

    $routes->options("testAdmin","API\APIAdministracioController::testAdmin");
    $routes->get("testAdmin","API\APIAdministracioController::testAdmin");

    $routes->options("testResponsable","API\APIAdministracioController::testResponsable");
    $routes->get("testResponsable","API\APIAdministracioController::testResponsable");

    $routes->options("testStaff","API\APIAdministracioController::testStaff");
    $routes->get("testStaff","API\APIAdministracioController::testStaff");


    //////////////////////////////////////////////////////
    /////// ROUTES RELATED WITH USERS AND ROLES //////////
    //////////////////////////////////////////////////////

    $routes->group("users", function ($routes) { 

       
        //STAFF ROUTES

        $routes->options("getStaff", "API\APIUserController::getAllStaff");
        $routes->post("getStaff", "API\APIUserController::getAllStaff", ['filter'=>'jwt']);

        $routes->options("createStaff", "API\APIUserController::createStaff");
        $routes->post("createStaff", "API\APIUserController::createStaff", ['filter'=>'jwt']);

        $routes->options("updateStaff", "API\APIUserController::updateStaff");
        $routes->post("updateStaff", "API\APIUserController::updateStaff", ['filter'=>'jwt']);

        $routes->options("deleteStaff", "API\APIUserController::deleteStaff");
        $routes->post("deleteStaff", "API\APIUserController::deleteStaff", ['filter'=>'jwt']);

        //USER ROUTES

        $routes->options("getAll", "API\APIUserController::getAllUsers");
        $routes->get("getAll", "API\APIUserController::getAllUsers", ['filter'=>'jwt']);

        $routes->options("create","API\APIRestaurantController::create");
        $routes->post("create","API\APIUserController::create", ['filter'=>'jwt']);

        $routes->options("update","API\APIUserController::update");
        $routes->post("update", "API\APIUserController::update", ['filter'=>'jwt']);

        $routes->options("delete","API\APIUserController::delete");
        $routes->post("delete","API\APIUserController::delete", ['filter'=>'jwt']);

        //ROLE ROUTES

        $routes->options("getAllRoles", "API\APIUserController::getAllRoles");
        $routes->get("getAllRoles", "API\APIUserController::getAllRoles", ['filter'=>'jwt']);

        $routes->options("createRole","API\APIUserController::createRole");
        $routes->post("createRole","API\APIUserController::createRole", ['filter'=>'jwt']);

        $routes->options("updateRole/(:any)","API\APIUserController::updateRole/$1");
        $routes->post("updateRole/(:any)", "API\APIUserController::updateRole/$1", ['filter'=>'jwt']);

        $routes->options("deleteRole/(:any)","API\APIUserController::deleteRole/$1");
        $routes->post("deleteRole/(:any)","API\APIUserController::deleteRole/$1", ['filter'=>'jwt']);

        $routes->options("assignRole","API\APIUserController::assignRole");
        $routes->post("assignRole","API\APIUserController::assignRole", ['filter'=>'jwt']);

        $routes->options("getImageUser", "API\APIUserController::returnUserImage");
        $routes->post("getImageUser", "API\APIUserController::returnUserImage");
    });

    /////////////////////////////////////////////////////
    ////////// RESTAURANT AND REVIEWS ROUTES ////////////
    /////////////////////////////////////////////////////

    $routes->group("restaurant", function ($routes) { 

        $routes->get("getAll", "API\APIRestaurantController::getAllRestaurants"); 

        $routes->get("getAllRestReviews", "API\APIRestaurantController::getAllRestaurantsWithReviews"); 

        $routes->get("getRestaurant/(:any)", "API\APIRestaurantController::getSpecificRestaurant/$1");

        $routes->options("getRestaurantUsers","API\APIRestaurantController::getAllRestaurantsFromUsers");
        $routes->post("getRestaurantUsers","API\APIRestaurantController::getAllRestaurantsFromUsers", ['filter'=>'jwt']);

        $routes->get("getReviews/(:any)", "API\APIRestaurantController::getReviews/$1");

        $routes->options("create","API\APIRestaurantController::createRestaurant");
       // $routes->post("create","API\APIRestaurantController::createRestaurant", ['filter'=>'jwt']);
        $routes->post("create","API\APIRestaurantController::createRestaurant");

        $routes->options("update/(:any)","API\APIRestaurantController::updateRestaurant/$1");
        $routes->post("update/(:any)","API\APIRestaurantController::updateRestaurant/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APIRestaurantController::deleteRestaurant/$1");
        $routes->post("delete/(:any)","API\APIRestaurantController::deleteRestaurant/$1", ['filter'=>'jwt']);

        $routes->options("createReviews","API\APIRestaurantController::createReviews");
        $routes->post("createReviews","API\APIRestaurantController::createReviews");
    });

    ///////////////////////////////////////
    ////////// ALLERGEN ROUTES ////////////
    ///////////////////////////////////////

    $routes->group("allergen", function ($routes) {
        $routes->get("getAll", "API\APIAllergenController::getAllAllergens");
    });

    ///////////////////////////////////////
    ////////// CATEGORY ROUTES ////////////
    ///////////////////////////////////////

    $routes->group("category", function ($routes) {
        $routes->get("getAll", "API\APICategoryController::getAllCategories");

        $routes->options("create","API\APICategoryController::createCategory");
        $routes->post("create","API\APICategoryController::createCategory", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APICategoryController::updateCategory/$1");
        $routes->post("update/(:any)","API\APICategoryController::updateCategory/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APICategoryController::deleteCategory/$1");
        $routes->post("delete/(:any)","API\APICategoryController::deleteCategory/$1", ['filter'=>'jwt']);

    });

    /////////////////////////////////////
    ////////// DISHES ROUTES ////////////
    /////////////////////////////////////

    $routes->group("dish", function ($routes) {
        $routes->get("getAllRestaurant/(:any)", "API\APIDishController::getAllDishesFromRestaurant/$1");

        $routes->get("getAllCategory", "API\APIDishController::getAllDishesFromCategory");

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

    ///////////////////////////////////////
    ////////// MESSAGES ROUTES ////////////
    ///////////////////////////////////////

    $routes->group("messages", function ($routes) {
        $routes->get("getAll", "API\APIMessagesController::getAllMessages");

        $routes->options("create","API\APIMessagesController::createMessages");
        $routes->post("create","API\APIMessagesController::createMessages", ['filter'=>'jwt']);

    });

    ////////////////////////////////////
    ////////// ORDER ROUTES ////////////
    ////////////////////////////////////

    $routes->group("order", function ($routes) {
        $routes->get("getAll", "API\APIOrderController::getAllOrders");

        $routes->options("create","API\APIOrderController::createOrder");
        $routes->post("create","API\APIOrderController::createOrder", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APIOrderController::updateOrder/$1");
        $routes->post("update/(:any)","API\APIOrderController::updateOrder/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APIOrderController::deleteOrder/$1");
        $routes->post("delete/(:any)","API\APIOrderController::deleteOrder/$1", ['filter'=>'jwt']);

    });

    ///////////////////////////////////////
    ///////// SUPPLEMENT ROUTES ///////////
    ///////////////////////////////////////

    $routes->group("supplement", function ($routes) {
        $routes->get("getAll", "API\APISupplementController::getAllSupplements");

        $routes->options("create","API\APISupplementController::createSupplement");
        $routes->post("create","API\APISupplementController::createSupplement", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APISupplementController::updateSupplement/$1");
        $routes->post("update/(:any)","API\APISupplementController::updateSupplement/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APISupplementController::deleteSupplement/$1");
        $routes->post("delete/(:any)","API\APISupplementController::deleteSupplement/$1", ['filter'=>'jwt']);

    });

    ////////////////////////////////////
    ////////// TABLE ROUTES ////////////
    ////////////////////////////////////

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
        $routes->match(['get','post'], 'admin/users', 'AdminCrudController::manageUser', ['filter'=>'role:administrador']);
        $routes->match(['get','post'], 'users', 'AdminCrudController::manageUser', ['filter'=>'role:administrador']);
        $routes->match(['get','post'], 'assignRoles', 'AdminCrudController::assignRoles', ['filter'=>'role:administrador']);
        $routes->match(['get','post'], 'roles', 'AdminCrudController::manageRole', ['filter'=>'role:administrador']);
        $routes->match(['get','post'], 'messages', 'AdminCrudController::seeMessages', ['filter'=>'role:administrador']);
        $routes->match(['get','post'], 'discharge', 'AdminCrudController::dischargeRestaurant', ['filter'=>'role:administrador']);
        $routes->match(['get','post'], 'themes', 'AdminCrudController::manageThemes', ['filter'=>'role:administrador']);

});

//RESPONSABLE ROUTES

$routes->group("responsable", function ($routes) {
    $routes->match(['get','post'], 'restaurants', 'ResponsableCrudController::view', ['filter'=>'role:responsable']);

});


//CAMBRER CUINER ROUTES




//MAITRE ROUTES




//CLIENT ROUTES

$routes->options('user', 'PrivateController::view');
$routes->get('user', 'PrivateController::view');

$routes->options('restaurants', 'RestaurantPage::index');
$routes->get('restaurants', 'RestaurantPage::index');

$routes->options('restaurants/(:any)', 'RestaurantSingularPage::index');
$routes->get('restaurants/(:any)', 'RestaurantSingularPage::index');


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
