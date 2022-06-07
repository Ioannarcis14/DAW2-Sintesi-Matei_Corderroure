<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use SIENSIS\KpaCrud\Libraries\KpaCrud;


class ResponsableCrudController extends BaseController
{


    //Restaurants
    public function getRestaurants(){

    }

    public function addRestaurant(){

    }

    public function updateRestaurant(){

    }


    public function deleteRestaurant(){

    }

    //Category

    public function getCategories() {

    }

    public function addCategory() {

    }

    public function editCategory() {

    }

    public function deleteCategory() {

    }

    //Dishes

    public function getDishes() {

    }

    public function addDish() {

    }

    public function editDish() {

    }

    public function deleteDish() {

    }

    public function assignSupplement() {

    }

    public function assignAllergen() {
        
    }

    //Supplements

    public function getSupplements() {

    }

    public function addSupplement() {

    }

    public function editSupplement() {

    }

    public function deleteSupplement() {

    }
    
    //Allergen

    public function getAllergens() {
        
    }

    public function view()
    {
        $auth = service('authentication');
        $userId = $auth->id();

        $crud = new KpaCrud();
        $crud->setTable('restaurant');
        $crud->setPrimaryKey('id');

        $crud->setConfig([
            "recycled_button" => false,
            "exportXLS" => false,
            "print" => false,
            "multidelete" => false,
            "deletepermanent" => false,

        ]);
        $crud->setColumns(['id','name','city']);
        
        $crud->addPostAddCallBack(array($this, 'hashNewPassword'));
        $crud->addPostEditCallBack(array($this, 'hashEditPassword'));

        $crud->addItemFunction('assign', 'fa fa-id-badge', array($this, 'myCustomPage'), "Enter restaurant");

    

        $data['output'] = $crud->render();

        return view('responsable/manage_restaurants', $data);

    }
}
