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

        $routes->options("getUser/(:any)", "API\APIUserController::getUser/$1");
        $routes->get("getUser/(:any)", "API\APIUserController::getUser/$1", ['filter'=>'jwt']);

        $routes->options("create","API\APIRestaurantController::create");
        $routes->post("create","API\APIUserController::create", ['filter'=>'jwt']);

        $routes->options("update","API\APIUserController::updateUser");
        $routes->post("update", "API\APIUserController::updateUser", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APIUserController::updateUserSpecific/$1");
        $routes->post("update/(:any)", "API\APIUserController::updateUserSpecific/$1", ['filter'=>'jwt']);
/* 
        $routes->options("delete","API\APIUserController::delete");
        $routes->post("delete","API\APIUserController::delete", ['filter'=>'jwt']);
  */
        //ROLE ROUTES

        $routes->options("getAllRoles", "API\APIUserController::getAllRoles");
        $routes->get("getAllRoles", "API\APIUserController::getAllRoles", ['filter'=>'jwt']);

        $routes->options("createRole","API\APIUserController::createRole");
        $routes->post("createRole","API\APIUserController::createRole", ['filter'=>'jwt']);

        $routes->options("updateRole","API\APIUserController::updateRole");
        $routes->post("updateRole", "API\APIUserController::updateRole", ['filter'=>'jwt']);

        $routes->options("deleteRole","API\APIUserController::deleteRole");
        $routes->post("deleteRole","API\APIUserController::deleteRole", ['filter'=>'jwt']);

        $routes->options("assignRole","API\APIUserController::assignRoleUser");
        $routes->post("assignRole","API\APIUserController::assignRoleUser", ['filter'=>'jwt']);

        $routes->options("removeRole","API\APIUserController::removeRoleUser");
        $routes->post("removeRole","API\APIUserController::removeRoleUser", ['filter'=>'jwt']);

        $routes->options("getImageUser", "API\APIUserController::returnUserImage");
        $routes->post("getImageUser", "API\APIUserController::returnUserImage");

        //USER FUNCTIONS

        $routes->options("changePass", "API\APIUserController::changePassword");
        $routes->post("changePass", "API\APIUserController::changePassword", ['filter'=>'jwt']);

        $routes->options("createValorations", "API\APIUserController::createValorations");
        $routes->post("createValorations", "API\APIUserController::createValorations", ['filter'=>'jwt']);

        $routes->options("contact", "API\APIUserController::contactAdmin");
        $routes->post("contact", "API\APIUserController::contactAdmin", ['filter'=>'jwt']);

        $routes->options("adminContact", "API\APIUserController::sendMessage");
        $routes->post("adminContact", "API\APIUserController::sendMessage", ['filter'=>'jwt']);

        $routes->options("discharge", "API\APIUserController::dischargeRestaurant");
        $routes->post("discharge", "API\APIUserController::dischargeRestaurant", ['filter'=>'jwt']);
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

        $routes->options("restaurantDischarged","API\APIRestaurantController::restaurantDischarged");
        $routes->post("restaurantDischarged","API\APIRestaurantController::restaurantDischarged", ['filter'=>'jwt']);

        $routes->get("getReviews/(:any)", "API\APIRestaurantController::getReviews/$1");

        $routes->options("add","API\APIRestaurantController::addRestaurant");
        $routes->post("add","API\APIRestaurantController::addRestaurant", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APIRestaurantController::updateRestaurant/$1");
        $routes->post("update/(:any)","API\APIRestaurantController::updateRestaurant/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APIRestaurantController::deleteRestaurant/$1");
        $routes->post("delete/(:any)","API\APIRestaurantController::deleteRestaurant/$1", ['filter'=>'jwt']);
        
    });

    ///////////////////////////////////////
    ////////// ALLERGEN ROUTES ////////////
    ///////////////////////////////////////

    $routes->group("allergen", function ($routes) {
        $routes->get("getAll/(:any)", "API\APIAllergenController::getAllAllergens/$1");
    });

    ///////////////////////////////////////
    ////////// CATEGORY ROUTES ////////////
    ///////////////////////////////////////

    $routes->group("category", function ($routes) {
        $routes->get("getAll/(:any)", "API\APICategoryController::getAllCategories/$1");

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

        $routes->options("getMessage/(:any)", "API\APIMessagesController::getMessagesFromUser/$1");
        $routes->get("getMessage/(:any)", "API\APIMessagesController::getMessagesFromUser/$1");

        $routes->options("getMessageNumber/(:any)", "API\APIMessagesController::getMessageNumber/$1");
        $routes->get("getMessageNumber/(:any)", "API\APIMessagesController::getMessageNumber/$1");

        $routes->options("create","API\APIMessagesController::createMessages");
        $routes->post("create","API\APIMessagesController::createMessages", ['filter'=>'jwt']);

    });

    ////////////////////////////////////
    ////////// THEME ROUTES ////////////
    ////////////////////////////////////

    $routes->group("theme", function ($routes) {
        $routes->options("create","API\APIMessagesController::themeCreate");
        $routes->post("create","API\APIMessagesController::themeCreate", ['filter'=>'jwt']);

        $routes->options("update","API\APIMessagesController::themeUpdate");
        $routes->post("update","API\APIMessagesController::themeUpdate", ['filter'=>'jwt']);
        
        $routes->options("delete","API\APIMessagesController::themeDelete");
        $routes->post("delete","API\APIMessagesController::themeDelete", ['filter'=>'jwt']);

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
        $routes->get("getAll/(:any)", "API\APISupplementController::getAllSupplements/$1");

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

        $routes->options("create","API\APITaulaController::createTable");
        $routes->post("create","API\APITaulaController::createTable", ['filter'=>'jwt']);

        $routes->options("update/(:any)","API\APITaulaController::updateTaula/$1");
        $routes->post("update/(:any)","API\APITaulaController::updateTaula/$1", ['filter'=>'jwt']);

        $routes->options("delete/(:any)","API\APITaulaController::deleteTaula/$1");
        $routes->post("delete/(:any)","API\APITaulaController::deleteTaula/$1", ['filter'=>'jwt']);

        $routes->options("getOnline", "API\APITaulaController::getOnlineTables");
        $routes->post("getOnline", "API\APITaulaController::getOnlineTables", ['filter'=>'jwt']);
        $routes->get("getOnline", "API\APITaulaController::getOnlineTables", ['filter'=>'jwt']);


    });

});


//ADMIN ROUTES


$routes->group("admin", function ($routes) {
        $routes->get("users", 'AdminCrudController::listUsers', ['filter'=>'role:administrador']);

        $routes->group("users", function ($routes) {
            $routes->get("create", 'AdminCrudController::createUser', ['filter'=>'role:administrador']);
            $routes->get('update/(:any)', 'AdminCrudController::updateUser/$1', ['filter'=>'role:administrador']);
            $routes->get('delete/(:any)', 'AdminCrudController::deleteUser/$1', ['filter'=>'role:administrador']);
            $routes->get("assign/(:any)", 'AdminCrudController::assignRole/$1', ['filter'=>'role:administrador']);
            $routes->get("remove/(:any)", 'AdminCrudController::removeRole/$1', ['filter'=>'role:administrador']);
        });

        $routes->get("roles", 'AdminCrudController::listRoles', ['filter'=>'role:administrador']);

        $routes->group("roles", function ($routes) {
            $routes->get("create", 'AdminCrudController::createRole', ['filter'=>'role:administrador']);
            $routes->get('update/(:any)', 'AdminCrudController::updateRole/$1', ['filter'=>'role:administrador']);
            $routes->get('delete/(:any)', 'AdminCrudController::deleteRole/$1', ['filter'=>'role:administrador']);
        });

        $routes->get('themes', 'AdminCrudController::listThemes', ['filter'=>'role:administrador']);

        $routes->group("themes", function ($routes) {
            $routes->get("create", 'AdminCrudController::createTheme', ['filter'=>'role:administrador']);
            $routes->get('update/(:any)', 'AdminCrudController::updateTheme/$1', ['filter'=>'role:administrador']);
            $routes->get('delete/(:any)', 'AdminCrudController::deleteTheme/$1', ['filter'=>'role:administrador']);
        });

        $routes->get('messages', 'AdminCrudController::listMessages', ['filter'=>'role:administrador']);
        $routes->get('messages/send', 'AdminCrudController::sendMessage', ['filter'=>'role:administrador']);

        $routes->get('discharge', 'AdminCrudController::listRestaurants', ['filter'=>'role:administrador']);
        $routes->get('discharge/(:any)', 'AdminCrudController::dischargeRestaurants/$1', ['filter'=>'role:administrador']);

});

//RESPONSABLE ROUTES

$routes->group("responsable", function ($routes) {
    $routes->get('restaurants', 'ResponsableCrudController::list_restaurants', ['filter'=>'role:responsable']);

    $routes->group("restaurants", function ($routes) {
        $routes->get("create", 'ResponsableCrudController::addRestaurant', ['filter'=>'role:responsable']);
        $routes->get('update/(:any)', 'ResponsableCrudController::updateRestaurant/$1', ['filter'=>'role:responsable']);
        $routes->get('delete/(:any)', 'ResponsableCrudController::deleteRestaurant/$1', ['filter'=>'role:responsable']);
        $routes->get("manage/(:any)", 'ResponsableCrudController::manageRestaurant/$1', ['filter'=>'role:responsable']);
    });

    $routes->group("restaurant", function ($routes) {
        $routes->get("(:any)/staff/manage", 'ResponsableCrudController::manageStaff/$1', ['filter'=>'role:responsable']);
        $routes->get('(:any)/categories/manage', 'ResponsableCrudController::manageCategories/$1', ['filter'=>'role:responsable']);
        $routes->get('(:any)/dishes/manage', 'ResponsableCrudController::manageDishes/$1', ['filter'=>'role:responsable']);
        $routes->get("(:any)/supplements/manage", 'ResponsableCrudController::manageSupplements/$1', ['filter'=>'role:responsable']);
        $routes->get("(:any)/valorations/see", 'ResponsableCrudController::manageValorations/$1', ['filter'=>'role:responsable']);

    });

});


//CAMBRER CUINER ROUTES




//MAITRE ROUTES




//CLIENT ROUTES

$routes->options('user', 'PrivateController::view');
$routes->get('user', 'PrivateController::view', ['filter' => 'login']);

$routes->options('user/changeData', 'PrivateController::changeData');
$routes->get('user/changeData', 'PrivateController::changeData', ['filter' => 'login']);


$routes->options('discharge', 'PrivateController::dischargeRestaurant');
$routes->get('discharge', 'PrivateController::dischargeRestaurant', ['filter' => 'login']);

$routes->options('contact', 'PrivateController::contactAdmin');
$routes->get('contact', 'PrivateController::contactAdmin', ['filter' => 'login']);

$routes->options('restaurants', 'RestaurantPage::index');
$routes->get('restaurants', 'RestaurantPage::index');

$routes->options('restaurants/(:any)', 'RestaurantSingularPage::index/$1');
$routes->get('restaurants/(:any)', 'RestaurantSingularPage::index/$1');

//FILE EXPLORER

$routes->post('fileconnector', 'FileExplorerController::connector');
$routes->get('fileconnector', 'FileExplorerController::connector');
$routes->get('filemanager', 'FileExplorerController::manager');
$routes->get('/fileget/(:any)', 'FileExplorerController::getImageUser');
$routes->get('/filegetRestaurant/(:any)', 'FileExplorerController::getRestaurantImg');


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
