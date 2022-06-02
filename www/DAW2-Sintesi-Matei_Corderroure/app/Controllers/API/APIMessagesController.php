<?php

namespace App\Controllers\API;

use App\Models\MessagesModel;
use CodeIgniter\RESTful\ResourceController;

class APIMessagesController extends ResourceController
{
    public function index()
    {
        //
    }

    public function getMessagesFromUser($email) {

        $MessageModel = new MessagesModel();
        $list = $MessageModel->getMessagesFromUser($email);

        if (!empty($list)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Restaurant data found',
                'data' => $list
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No restaurants found',
                'data' => []
            ];
        }
        return $this->respond($response);

    }

    public function getMessageNumber($email) {

        $MessageModel = new MessagesModel();
        $list = $MessageModel->getMessages($email);

        if (!empty($list)) {
            $response = [
                'status' => 200,
                "error" => false,
                'messages' => 'Restaurant data found',
                'data' => $list
            ];
        } else {
            $response = [
                'status' => 404,
                "error" => true,
                'messages' => 'No restaurants found',
                'data' => []
            ];
        }
        return $this->respond($response);

    }
}
