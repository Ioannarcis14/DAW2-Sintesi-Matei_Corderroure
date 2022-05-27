<?php

namespace App\Controllers\API;

use App\Models\CategoryModel;
use CodeIgniter\RESTful\ResourceController;

class APICategoryController extends ResourceController
{
    public function index()
    {
       //
    }

    public function getAllCategories($slug) {
        $catModel = new CategoryModel();
        $list = $catModel->getCategory($slug);

        if (!empty($list)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Category data found',
                'data' => $list
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No categories found',
                'data' => []
            ];
        }
        return $this->respond($response);
    }
}
